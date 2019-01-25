$(document).ready(function () {
    $("#botonSinConfirmar").on("click", function () {
        $(this).toggleClass("active");
        $("#botonConfirmados").toggleClass("active");
        $("#sinConfirmar").collapse("toggle");
        $("#confirmados").collapse("toggle");
    });
    $("#botonConfirmados").on("click", function () {
        $(this).toggleClass("active");
        $("#botonSinConfirmar").toggleClass("active");
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