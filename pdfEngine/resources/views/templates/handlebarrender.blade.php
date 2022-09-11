<!DOCTYPE HTML>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<div id="printtemplate">
    {!!$html!!}

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script id="injection">
$(".jsbarcode").each(function(){
    $(this).JsBarcode($(this).attr('jsbvalue'),{
        format:$(this).attr('jsbformat'),
        width:$(this).attr('jsbwidth'),
        height:$(this).attr('jsbheight'),
        displayValue: ($(this).attr('jsbdisplayvalue') ==1)
    });
});
        //JsBarcode('.jsbarcode').init();
     </script>
</div>

<script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
<script>
  $(document).ready(function(){
    var template = Handlebars.compile($('#printtemplate').html());
    $('body').html(template({!! $jsondata !!}));
  });
</script>

