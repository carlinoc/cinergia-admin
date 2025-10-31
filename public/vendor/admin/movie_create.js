
$(function() {
    $("#releaseYear").datepicker({
        "dateFormat": "yy-mm-dd"
    });
});

$(document).ready(function() {
    let _ytVerifySpinner = $("#YTVerifySpinner");
    let _ytVerifyDiv = $("#YTVerifyDiv");
    let _urlId = $("#urlId");
    let _posterDiv = $("#posterDiv");
    let _posterDivDetail = $("#posterDivDetail");
    let _captionDiv = $("#captionDiv");
    let _captionDivDetail = $("#captionDivDetail");

    $('.select2-multiple').select2();

   _ytVerifySpinner.hide();

   $("#videoSource").on("change", function() {
        let videoSource = $("#videoSource").val();
        if(videoSource=="YT"){
            _ytVerifyDiv.show();
            _urlId.prop('disabled', true);
            _posterDiv.hide();
            _posterDivDetail.hide();
            _captionDiv.hide();
            _captionDivDetail.hide();
        }else{
            _ytVerifyDiv.hide();
            _urlId.prop('disabled', false);
            _posterDiv.show();
            _posterDivDetail.show();
            _captionDiv.show();
            _captionDivDetail.show();
        }
   });

   $("#payment_type").on("change", function() {
        let paymentType = $("#payment_type").val();
        if(paymentType==""){
            $("#priceSolDiv").hide();
            $("#priceUSDDiv").hide();
        }else{
            $("#priceSolDiv").show();
            $("#priceUSDDiv").show();
        }
   });
});

let stepper1
document.addEventListener('DOMContentLoaded', function () {
    stepper1 = new Stepper(document.querySelector('#stepper1'))
    var stepperFormEl = document.querySelector('#stepper1')

    stepperFormEl.addEventListener('show.bs-stepper', function (event) {
        var nextStep = event.detail.indexStep;
        var currentStep = nextStep;

        if (currentStep > 0) {
            currentStep--;
        }
        console.log(nextStep);
    })

});

$("#name").keyup(function() {
    let _text = $(this).val();
    $("#slug").val(slugify(_text));
});


$('#next1').on('click', function(e) {
    e.preventDefault();

    let elements = [
        ['categoryId', 'Seleccione una categoría'],
        ['languageId', 'Seleccione un idioma'],
        ['name', 'Ingrese el nombre de la película']
    ];

    if(emptyfy(elements)){
        stepper1.next();
    }
});

$('#next2').on('click', function(e) {
    e.preventDefault();

    let elements = [
        ['movieLength', 'Ingresa la duración de la película'],
        ['releaseYear', 'Ingrese la fecha de lanzamiento'],
        ['ageRateId', 'Seleccione la clasificación'],
        ['genres', 'Seleccione los géneros'],
        ['directorId', 'Seleccione el director']
    ];
    if($("#payment_type").val()!=""){
        elements.push(['price', 'Ingrese el precio en S/']);
        elements.push(['priceUSD', 'Ingrese el precio en USD']);
    }

    if(emptyfy(elements)){
        if(isNotNaNGlobal($("#price").val())==false){
            Swal.fire({
                title: "Oops",
                text: "El precio en S/ debe ser un valor numérico",
                icon: "warning"
            });
            return;
        }
        if(isNotNaNGlobal($("#priceUSD").val())==false){
            Swal.fire({
                title: "Oops",
                text: "El precio en USD debe ser un valor numérico",
                icon: "warning"
            });
            return;
        }
        stepper1.next();
    }
});

$('#btnSaveMovie').on('click', function(e) {
    e.preventDefault();

    let elements = [];
    if($("#videoSource").val()=="NN"){
        elements = [
            ['urlId', 'Ingrese el codigo de Muse.ai']
        ];
    }
    if(emptyfy(elements)){
        let _form = document.getElementById('frmNewMovie');
        _form.submit();
    }
});
