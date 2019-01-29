$(document).ready(function () {
    $("#botonSinConfirmar").on("click", function () {
        $(this).toggleClass("active");
        $(this).toggleClass("border-info");
        $("#botonConfirmados").toggleClass("active");
        $("#botonConfirmados").toggleClass("border-info");
        $("#sinConfirmar").collapse("toggle");
        $("#confirmados").collapse("toggle");
    });
    $("#botonConfirmados").on("click", function () {
        $(this).toggleClass("active");
        $(this).toggleClass("border-info");
        $("#botonSinConfirmar").toggleClass("active");
        $("#botonSinConfirmar").toggleClass("border-info");
        $("#sinConfirmar").collapse("toggle");
        $("#confirmados").collapse("toggle");
    });
    $(".pedidoCard").on({
        mouseenter: function () {
            $(this).addClass("shadow-lg");
        },
        mouseleave: function () {
            $(this).removeClass("shadow-lg");
        }
    });
});