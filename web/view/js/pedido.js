$(document).ready(function () {
    $("#botonSinConfirmar").on("click", function () {
        if($("#confirmados").hasClass("collapse")){
            $("#confirmados").collapse('hide');
            $("#sinConfirmar").collapse('show');
        }else{
            $("#sinConfirmar").collapse('hide');
        }
    });
    $("#botonConfirmados").on("click", function () {
        if($("#sinConfirmar").hasClass("collapse")){
            $("#sinConfirmar").collapse('hide');
            $("#confirmados").collapse('show');
        }else{
            $("#confirmados").collapse('hide');
        }
    });
});