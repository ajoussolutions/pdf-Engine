<!doctype html>
<html lang="en" class="h-100">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//unpkg.com/grapesjs/dist/css/grapes.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
        .gjs-one-bg {
    background-color: #6c757d !important;
}
.gjs-four-color {
    color: #0d6efd !important;
}
.gjs-four-color-h:hover {
    color: #212529 !important;
}
        </style>
    <title>Templatedesigner</title>
  </head>
  <body  class="h-100 bg-secondary text-light">
    <div class="container-fluid h-100 mt-2">
        @include('main.topmenu')
        <div class="row h-100">
            <div class="col">
                <div id="templateeditor">

                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <h5>{{$template->templatename}}</h5> <a class="btn btn-primary m-2" onclick="ReloadPreview()" role="button">Reload Preview</a> <a class="btn btn-success m-2" onclick="Save()" role="button">Save Template</a>
                        <div id="pdfpreviewwrapper" style="height: 700px"></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <form method="POST" action="" id="savetemplate">
                        <div class="col">
                            <h6><i class="bi bi-gear"></i> Options</h6>
                            <div class="row row border mt-1 p-2 rounded">
                                <div class="col">
                                    <label for="headertemplate" class="form-label">Header</label>
                                    <select class="form-select" aria-label="Headertemplate" id="headertemplate" name="headertemplate">
                                        <option></option>
                                        @if ($templates)
                                            @foreach ($templates as $htemplate)
                                            <option value="{{$htemplate->id}}" {{($template->header == $htemplate->id)?'selected':''}}>{{$htemplate->templatename}}</option>
                                            @endforeach
                                        @endif
                                      </select>
                                      <div class="mb-3">
                                        <label for="headerheight" class="form-label">Height (mm)</label>
                                        <input class="form-control form-control-sm" id="headerheight" name="headerheight" type="number" value="{{(isset($template->options()->headerheight))?$template->options()->headerheight:''}}" style="max-width: 100px">
                                      </div>
                                </div>
                                <div class="col">
                                    <label for="footertemplate" class="form-label">Footer</label>
                                    <select class="form-select" aria-label="Footertemplate" id="footertemplate" name="footertemplate">
                                        <option></option>
                                        @if ($templates)
                                            @foreach ($templates as $ftemplate)
                                            <option value="{{$ftemplate->id}}" {{($template->footer == $ftemplate->id)?'selected':''}}>{{$ftemplate->templatename}}</option>
                                            @endforeach
                                        @endif
                                      </select>
                                      <div class="mb-3">
                                        <label for="footerheight" class="form-label">Height (mm)</label>
                                        <input class="form-control form-control-sm" id="footerheight" name="footerheight" type="number" value="{{(isset($template->options()->footerheight))?$template->options()->footerheight:''}}" style="max-width: 100px">
                                      </div>
                                </div>
                            </div>
                            <div class="row border mt-1 p-2 rounded">
                                <div class="col">
                                    <label for="marginleft" class="form-label">Margin Left (mm)</label>
                                    <input class="form-control form-control-sm" id="marginleft" name="marginleft" type="number" value="{{(isset($template->options()->marginleft))?$template->options()->marginleft:''}}" style="max-width: 100px">
                                </div>
                                <div class="col">
                                    <label for="margintop" class="form-label">Margin Top (mm)</label>
                                    <input class="form-control form-control-sm" id="margintop" name="margintop" type="number" value="{{(isset($template->options()->margintop))?$template->options()->margintop:''}}" style="max-width: 100px">
                                </div>
                                <div class="col">
                                    <label for="marginright" class="form-label">Margin Right (mm)</label>
                                    <input class="form-control form-control-sm" id="marginright" name="marginright" type="number" value="{{(isset($template->options()->marginright))?$template->options()->marginright:''}}" style="max-width: 100px">
                                </div>
                                <div class="col">
                                    <label for="marginbottom" class="form-label">Margin Bottom (mm)</label>
                                    <input class="form-control form-control-sm" id="marginbottom" name="marginbottom" type="number" value="{{(isset($template->options()->marginbottom))?$template->options()->marginbottom:''}}" style="max-width: 100px">
                                </div>
                                <div class="col">
                                    <label for="pagesize" class="form-label">Pagesize</label>
                                    <select class="form-select" aria-label="Pagesize" id="pagesize" name="pagesize" onchange="UpdateCustom()">
                                        <option value="A4" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A4')?'selected':''}}>A4</option>
                                        <option value="A3" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A3')?'selected':''}}>A3</option>
                                        <option value="A2" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A2')?'selected':''}}>A2</option>
                                        <option value="A1" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A1')?'selected':''}}>A1</option>
                                        <option value="A5" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A5')?'selected':''}}>A5</option>
                                        <option value="A6" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A6')?'selected':''}}>A6</option>
                                        <option value="A7" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A7')?'selected':''}}>A7</option>
                                        <option value="A8" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A8')?'selected':''}}>A8</option>
                                        <option value="A9" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='A9')?'selected':''}}>A9</option>
                                        <option value="Letter" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='Letter')?'selected':''}}>Letter</option>
                                        <option value="Custom" {{(isset($template->options()->pagesize) && $template->options()->pagesize=='Custom')?'selected':''}}>Custom</option>
                                    </select>
                                </div>
                                <div class="col" id="customsizes" style="display:none">
                                    <label for="customwidth" class="form-label">Custom Width (mm)</label>
                                    <input class="form-control form-control-sm" id="customwidth" onchange="UpdatePaperCanvas()" name="customwidth" type="number" min="0" value="{{(isset($template->options()->customwidth))?$template->options()->customwidth:'0'}}" style="max-width: 100px">
                                    <label for="customheight" class="form-label">Custom Height (mm)</label>
                                    <input class="form-control form-control-sm" id="customheight" name="customheight" type="number" min="0" value="{{(isset($template->options()->customheight))?$template->options()->customheight:'0'}}" style="max-width: 100px">
                                </div>
                            </div>
                            </div>
                        </div>
                    <div class="col">
                        <h6><i class="bi bi-filetype-json"></i> Sampledata</h6>
                        @csrf
                        <textarea name="sampledata" id="previewdata" style="width:100%">{!!$template->sampledata!!}</textarea>
                        <input type="hidden" id="templatecode" name="templatecode" />
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfobject@2.2.8/pdfobject.min.js"></script>
    <script src="//unpkg.com/grapesjs"></script>
<script src="https://cdn.jsdelivr.net/npm/grapesjs-preset-newsletter@0.2.21/dist/grapesjs-preset-newsletter.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/grapesjs-preset-webpage@0.1.11/dist/grapesjs-preset-webpage.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
      function pdfEngine(editor){
        const barcodescript = function() {
            JsBarcode(this).init();
};
      editor.Components.addType('barcode', {
    isComponent: el => el.tagName === 'svg' && el.classList.contains('jsbarcode'),
  model: {
    defaults: {
        barcodescript,
        tagName:'svg',
        components:'BARCODE',
        traits:[
            'jsbformat',
            'jsbvalue',
            'jsbwidth',
            'jsbheight',
            {
                name: 'jsbdisplayvalue',
                label:'Value',
                type:'select',
                options:[
                    {id:'1',label:'Show'},
                    {id:'0',label:'Hide'},
                ]

            }
        ],
        attributes:{
            class:'jsbarcode',
            'jsbformat':"CODE128",
            'jsbvalue':"123456789012",
            'jsbwidth':2,
            'jsbheight':'20',
            'jsbtextmargin':"0",
            'jsbdisplayvalue':"1"
        },
    }
  }
});
editor.BlockManager.add('Barcode', {
        label: '<svg width="50px" height="50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path fill="none" d="M0 0h24v24H0z"/><path d="M4 5v14h16V5H4zM3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm3 4h3v10H6V7zm4 0h2v10h-2V7zm3 0h1v10h-1V7zm2 0h3v10h-3V7z"/></g></svg><br>Barcode',
        content: { type: 'barcode' },
      });
  }

    var editor = grapesjs.init({
       canvas:{
        scripts:['https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js']
       },
      height: window.innerHeight - 50,
      width:'300mm',
      //noticeOnUnload: 0,
      storageManager:{
        autoload: 0,
      },
      assetManager: {
        upload: 0,
        uploadText: 'Uploading is not available in this demo',
      },
      container : '#templateeditor',
      fromElement: true,
      plugins: ['gjs-preset-newsletter','grapesjs-preset-webpage',pdfEngine],
      pluginsOpts: {
        'gjs-preset-newsletter': {
          modalLabelImport: 'Paste all your code here below and click import',
          modalLabelExport: 'Copy the code and use it wherever you want',
          codeViewerTheme: 'material',
          //defaultTemplate: templateImport,
          importPlaceholder: '<table class="table"><tr><td class="cell">Hello world!</td></tr></table>',
          cellStyle: {
            'font-size': '12px',
            'font-weight': 300,
            'vertical-align': 'top',
            color: 'rgb(111, 119, 125)',
            margin: 0,
            padding: 0,
          }
        }
      }
    });
    $(document).ready(function(){
        editor.Components.addComponent({!!json_encode($template->templatecode)!!});
        UpdateCustom();
        UpdatePaperCanvas();
        ReloadPreview();
    })
    editor.on('update', RenderBarcodes())
function RenderBarcodes(){
    $("#iFrame").contents().find(".jsbarcode").each(function(){
        JsBarcode(this).init();
    })
}
</script>
<script>
    function getDPI() {
    var div = document.createElement( "div");
    div.style.height = "1in";
    div.style.width = "1in";
    div.style.top = "-100%";
    div.style.left = "-100%";
    div.style.position = "absolute";

    document.body.appendChild(div);

    var result =  div.offsetHeight;

    document.body.removeChild( div );

    return result;

}
function UpdatePaperCanvas(){
    var paperwidth=0;
    if($('#pagesize option:selected').val()=='A4')paperwidth=210;
    if($('#pagesize option:selected').val()=='A3')paperwidth=297;
    if($('#pagesize option:selected').val()=='Custom')paperwidth=($('#customwidth').val()*1);
    editor.DeviceManager.remove('paper');
    paperwidth=paperwidth * ( getDPI() / 25.4 );
    editor.DeviceManager.add({id:'paper',name:'Paper',width:paperwidth})
    editor.DeviceManager.select('desktop');
    editor.DeviceManager.select('paper');
}
function UpdateCustom(){
    UpdatePaperCanvas();
if($('#pagesize option:selected').val()=='Custom'){
    $('#customsizes').css('display','block');
}else{
    $('#customsizes').css('display','none');
}
}
function ReloadPreview(){
  var htmlWithCss = encodeURIComponent(editor.runCommand('gjs-get-inlined-html')).replace('#','%23');
  var previewdata=encodeURI($('#previewdata').val());
  var headerheight=$('#headerheight').val();
  var headertemplate=$('#headertemplate option:selected').val();
  var footerheight=$('#footerheight').val();
  var footertemplate=$('#footertemplate option:selected').val();
  var marginleft=$('#marginleft').val();
  var marginright=$('#marginright').val();
  var margintop=$('#margintop').val();
  var marginbottom=$('#marginbottom').val();
  var pagesize=$('#pagesize option:selected').val();
  var customwidth=$('#customwidth').val();
  var customheight=$('#customheight').val();
  url="/api/preview?filename=pdfpreview&templatecode="+htmlWithCss
  +"&data="+previewdata
  +'&headerheight='+headerheight
  +'&headertemplate='+headertemplate
  +'&footerheight='+footerheight
  +'&footertemplate='+footertemplate
  +'&margintop='+margintop
  +'&marginbottom='+marginbottom
  +'&marginleft='+marginleft
  +'&marginright='+marginright
  +'&pagesize='+pagesize
  +'&customwidth='+customwidth
  +'&customheight='+customheight;

  PDFObject.embed(url, "#pdfpreviewwrapper");
}
function Save(){
$('#templatecode').val(editor.runCommand('gjs-get-inlined-html'));
$('#savetemplate').submit();
}
</script>
  </body>
</html>


