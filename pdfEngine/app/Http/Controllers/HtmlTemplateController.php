<?php

namespace App\Http\Controllers;

use App\Models\HtmlTemplate;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use stdClass;

class HtmlTemplateController extends Controller
{
   public function List(Request $request){
    //todo pagination
    $templates = HtmlTemplate::query()->paginate();
    return View('templatelist',['templates'=>$templates]);
   }
   public function Create(Request $request){
    if($request->has('templatename')){
        $nt=new HtmlTemplate();
        $nt->templatename=$request->input('templatename');
        if($nt->save()){
            return redirect(route('edittemplate',$nt->templatename));
        }else{
            return abort(500);
        }
    }else{
        return abort(400);
    }
   }
   public function Print(Request $request,$template){
    if($request->json()->all()['data'] && $request->json()->all()['filename']){
        $tmpl = HtmlTemplate::query()->where('templatename','=',$template)->first();
        $hcode=null;
        $fcode=null;
        if($tmpl->header){
            $htmpl = HtmlTemplate::find($tmpl->header);
            $hcode=$htmpl->templatecode;
        }
        if($tmpl->footer){
            $ftmpl = HtmlTemplate::find($tmpl->footer);
            $fcode=$ftmpl->templatecode;
        }
        $options=null;
        if($tmpl->options){
            $options=json_decode($tmpl->options);
        }
        if($tmpl){
            return $this->RenderCustom($tmpl->templatecode,$request->json()->all()['data'],$request->json()->all()['filename'],$hcode,$fcode,$options);
        }else{
            return abort(404);
        }

    }

    }
   public function PrintCustom(Request $request){
    if($request->json()->all()['templatecode'] && $request->json()->all()['data'] && $request->json()->all()['filename']){
        $headercode=null;
        $footercode=null;
        if(isset($request->json()->all()['header'])) $headercode=$request->json()->all()['header'];
        if(isset($request->json()->all()['footer'])) $footercode=$request->json()->all()['footer'];
        return $this->RenderCustom($request->json()->all()['templatecode'],$request->json()->all()['data'],$request->json()->all()['filename'],$headercode,$footercode);
    }
   }
   public function PrintPreview(Request $request){
    if($request->has('templatecode') && $request->has('filename')){
        $headercode=null;
        if($request->has('headertemplate')){
            $ht=HtmlTemplate::find($request->input('headertemplate'));
            if($ht)$headercode=$ht->templatecode;
        }
        $footercode=null;
        if($request->has('footertemplate')){
            $ft=HtmlTemplate::find($request->input('footertemplate'));
            if($ft)$footercode=$ft->templatecode;
        }
        $options=new stdClass();
        if($request->has('headerheight'))$options->headerheight=$request->input('headerheight');
        if($request->has('margintop'))$options->margintop=$request->input('margintop');
        if($request->has('footerheight'))$options->footerheight=$request->input('footerheight');
        if($request->has('marginbottom'))$options->marginbottom=$request->input('marginbottom');
        if($request->has('marginleft'))$options->marginleft=$request->input('marginleft');
        if($request->has('marginright'))$options->marginright=$request->input('marginright');
        if($request->has('pagesize'))$options->pagesize=$request->input('pagesize');
        if($request->has('customwidth'))$options->customwidth=$request->input('customwidth');
        if($request->has('customheight'))$options->customheight=$request->input('customheight');
        return $this->RenderCustom($request->input('templatecode'), json_decode($request->input('data')),$request->input('filename'),$headercode,$footercode,$options);
    }
   }

   //todo remove DANGER of php injection
   private function RenderCustom($html,$data,$filename,$headercode=null,$footercode=null,$options=null){
    $out=View::make('templates/handlebarrender',['html'=>$html,'jsondata'=>json_encode($data)])->render();
    $headerhtml=null;
    $footerhtml=null;
    if($headercode){
        $headerhtml=View::make('templates/handlebarrender',['html'=>$headercode,'jsondata'=>json_encode($data)])->render();
    }
    if($footercode){
        $footerhtml=View::make('templates/handlebarrender',['html'=>$footercode,'jsondata'=>json_encode($data)])->render();
    }
        return $this->RenderPDFWKHTMLTOPDF($out,$filename,$headerhtml,$footerhtml,$options);
   }

   private function RenderPDFWKHTMLTOPDF($html,$filename,$htmlheader=null,$htmlfooter=null,$options=null){
    $random=Str::random(20);
    while(Storage::disk('local')->exists(DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$random.'.html')){
        $random=Str::random(20);
    }
    Storage::disk('local')->put(DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$random.'.html', $html);
    if($htmlheader){
        Storage::disk('local')->put(DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$random.'header.html', $htmlheader);
    }
    if($htmlfooter){
        Storage::disk('local')->put(DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$random.'footer.html', $htmlfooter);
    }
    $fullpath=Storage::path('tmp'.DIRECTORY_SEPARATOR.$random.'.html');
    $fullheaderpath=Storage::path('tmp'.DIRECTORY_SEPARATOR.$random.'header.html');
    $fullfooterpath=Storage::path('tmp'.DIRECTORY_SEPARATOR.$random.'footer.html');
    $pdfpath=Storage::path('tmp'.DIRECTORY_SEPARATOR.$random.'.pdf');
    $command=env('WKHTMLTOPDF');
    if(isset($options->headerheight) || isset($options->margintop)){
        $hheight=0;
        if(isset($options->headerheight))$hheight += $options->headerheight;
        if(isset($options->margintop))$hheight += $options->margintop;
        $command .=' -T '.$hheight.'mm';
    }
    if(isset($options->footerheight) || isset($options->marginbottom)){
        $fheight=0;
        if(isset($options->footerheight))$fheight += $options->footerheight;
        if(isset($options->marginbottom))$fheight += $options->marginbottom;
        $command .=' -B '.$fheight.'mm';
    }

    if($htmlheader){
        $command .=' --header-html "'.$fullheaderpath.'"';
    }

    if($htmlfooter){
        $command .=' --footer-html "'.$fullfooterpath.'"';
    }

    if(isset($options->marginleft)){
        $command .=' -L '.$options->marginleft.'mm';
    }
    if(isset($options->marginright)){
        $command .=' -R '.$options->marginright.'mm';
    }

    if(isset($options->pagesize) && $options->pagesize != 'Custom'){
        $command .=' -s '.$options->pagesize;
    }
    if(isset($options->pagesize) && $options->pagesize == 'Custom' && isset($options->customwidth)){
        $command .=' --page-width '.$options->customwidth;
    }
    if(isset($options->pagesize) && $options->pagesize == 'Custom' && isset($options->customheight)){
        $command .=' --page-height '.$options->customheight;
    }



    $command.=' --dpi 600 --disable-smart-shrinking "'.$fullpath.'" "'.$pdfpath.'"';
    $pipes=array();
    $descriptorspec = array(
        0 => array("pipe", "rb"),
        1 => array("pipe", "wb"),
        2 => array("pipe", "wb"),
    );
   $prog= proc_open($command,$descriptorspec,$pipes);
   if(!$prog){
    throw new \RuntimeException("failed to create process! \"{$command}\"");
}
$stdout="";
$stderr="";
$fetch=function()use(&$stdout,&$stderr,&$pipes){
    $tmp=stream_get_contents($pipes[1]);
    if(is_string($tmp) && strlen($tmp) > 0){
        $stdout.=$tmp;
    }
    $tmp=stream_get_contents($pipes[2]);
    if(is_string($tmp) && strlen($tmp) > 0){
        $stderr.=$tmp;
    }
};
fclose($pipes[0]);
$status=array();

while(($status=proc_get_status($prog))['running']){
    $fetch();
}
fclose($pipes[1]);
fclose($pipes[2]);
proc_close($prog);
Storage::disk('local')->delete(DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$random.'.html');
if($htmlheader){
    Storage::disk('local')->delete(DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$random.'header.html');
}
if($htmlfooter){
    Storage::disk('local')->delete(DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$random.'footer.html');
}
//return Storage::download('tmp'.DIRECTORY_SEPARATOR.$random.'.pdf');
return response()->file($pdfpath,['Content-disposition'=>'filename="'.$filename.'.pdf"'])->deleteFileAfterSend(true);
   }

function Edit(Request $request, $templatename){
    $tmpl=HtmlTemplate::query()->where('templatename','=',$templatename)->first();
    $templates=HtmlTemplate::all();
    if($tmpl){
        return View('templates.edit',['template'=>$tmpl,'templates'=>$templates]);
    }else{
        return abort(404);
    }
   }
   function Save(Request $request, $templatename){
    $tmpl=HtmlTemplate::query()->where('templatename','=',$templatename)->first();
    if($tmpl){
        if($request->has('templatecode') && $request->has('sampledata')){
            $tmpl->templatecode=$request->input('templatecode');
            $tmpl->sampledata=$request->input('sampledata');
            if($request->has('headertemplate')) $tmpl->header=$request->input('headertemplate');
            if($request->has('footertemplate')) $tmpl->footer=$request->input('footertemplate');
            $options=new stdClass();
            if($request->has('headerheight')) $options->headerheight=$request->input('headerheight');
            if($request->has('footerheight')) $options->footerheight=$request->input('footerheight');
            if($request->has('marginbottom')) $options->marginbottom=$request->input('marginbottom');
            if($request->has('margintop')) $options->margintop=$request->input('margintop');
            if($request->has('marginleft')) $options->marginleft=$request->input('marginleft');
            if($request->has('marginright')) $options->marginright=$request->input('marginright');
            if($request->has('pagesize')) $options->pagesize=$request->input('pagesize');
            if($request->has('customwidth')) $options->customwidth=$request->input('customwidth');
            if($request->has('customheight')) $options->customheight=$request->input('customheight');
            $tmpl->options=json_encode($options);
            $tmpl->Save();
            $templates=HtmlTemplate::all();
            return View('templates.edit',['template'=>$tmpl,'templates'=>$templates]);
        }else{
            return abort(422);
        }

    }else{
        return abort(404);
    }
   }
}
