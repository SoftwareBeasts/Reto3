$(document).ready(function () {
    $(".botoncolapsar").on("click", function () {
        $('.botoncolapsar').toggleClass("active");
        $('.active').focus();
        $('.colapsar').collapse("toggle");
    });

    $(".pedidoCard").on({
        mouseenter: function () {
            $(this).addClass("shadow-lg");
        },
        mouseleave: function () {
            $(this).removeClass("shadow-lg");
        }
    });

    $(".btnAceptar").on("click", function () {
        let id = $(this).val();
        $.ajax({
            type: "POST",
            url: "./index.php?controller=pedido&action=confirmarPedido",
            data: {id : id}
        }).done(function () {
            // alert("confirmado");
            location.reload();
        });
    });

    $('.btnBorrar').on('click', function () {
        let id = $(this).val();
        $.ajax({
            type: "POST",
            url: "./index.php?controller=pedido&action=rechazarPedido",
            data: {id : id}
        }).done(function () {
            // alert("rechazado");
            location.reload();
        });
    });
});