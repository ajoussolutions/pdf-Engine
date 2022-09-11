<div id="templateeditor" style="width:210mm;border:solid 1px grey">

</div>
<textarea id="previewdata"></textarea>
<h1>Preview <a onclick="ReloadPreview()">Reload</a></h1>
<div id="pdfpreviewwrapper"></div>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfobject@2.2.8/pdfobject.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/smartblock@1.3.2/css/smartblock.css" />
<script src="https://unpkg.com/smartblock@1.3.2/dist/editor.js"></script>
<script src="https://unpkg.com/smartblock@1.3.2/dist/extensions.js"></script>
<!-- You can use smartblock without using JSX -->
<!-- bundle size is much smaller than the package build with react !-->
<script>
    var htmlresult='';
SmartBlock.Editor('#templateeditor', {
  html: {!!"'".$template->templatecode."'"!!},
  extensions: SmartBlock.Extensions,
  onChange: function(result) {
    htmlresult=result.html;
    console.log(result.json, result.html);
  }
});
</script>
<script>
function ReloadPreview(){
    $template=encodeURI(htmlresult);
    $previewdata=encodeURI($('#previewdata').val());
    PDFObject.embed("/api/preview?filename=pdfpreview&templatecode="+$template+"&data="+$previewdata, "#pdfpreviewwrapper");
}
</script>
