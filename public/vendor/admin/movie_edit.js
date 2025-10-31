$(function() {
    $("#releaseYear").datepicker({
        "dateFormat": "yy-mm-dd"
    });
});

$(document).ready(function() {
    $('.select2-multiple').select2();

    let _ytVerifySpinner = $("#YTVerifySpinner");
    _ytVerifySpinner.hide();


    $("#videoSource").on("change", function() {
        verifyVideoSource(this.value);
    });

    let videoSource = $("#videoSource").val();
    verifyVideoSource(videoSource);

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

function verifyVideoSource(videoSource) {
    let _ytVerifyDiv = $("#YTVerifyDiv");
    let _urlId = $("#urlId");
    let _posterDiv = $("#posterDiv");
    let _posterDivDetail1 = $("#posterDivDetail1");
    let _posterDivDetail2 = $("#posterDivDetail2");
    let _captionDiv = $("#captionDiv");
    let _captionDivDetail1 = $("#captionDivDetail1");
    let _captionDivDetail2 = $("#captionDivDetail2");
    if(videoSource=="YT"){
        _ytVerifyDiv.show();
        _urlId.prop('disabled', true);
        _posterDiv.hide();
        _posterDivDetail1.hide();
        _posterDivDetail2.hide();
        _captionDiv.hide();
        _captionDivDetail1.hide();
        _captionDivDetail2.hide();
    }else{
        _ytVerifyDiv.hide();
        _urlId.prop('disabled', false);
        _posterDiv.show();
        _posterDivDetail1.show();
        _posterDivDetail2.show();
        _captionDiv.show();
        _captionDivDetail1.show();
        _captionDivDetail2.show();
    }
}

let stepper1
document.addEventListener('DOMContentLoaded', function () {
    stepper1 = new Stepper(document.querySelector('#stepper1'))
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
        ['directorId', 'Seleccione el director'],
        ['price', 'Ingrese el precio']
    ];

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
            ['urlId', 'Ingrese el codigo de Muse.ai'],
        ];
    }
    if(emptyfy(elements)){
        let _form = document.getElementById('frmEditMovie');
        _form.submit();
    }
});
