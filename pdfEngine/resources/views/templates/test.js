$(document).ready(function () {
    $('.barcode128').forEach(
        function(element){
            JsBarcode($(element).id(), "1234", {
                format: "pharmacode",
                lineColor: "#0aa",
                width: 4,
                height: 40,
                displayValue: false
              });
        }
    );
     });
