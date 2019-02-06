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
        let idPedido = $(this).val();
        $.ajax({
            type: "POST",
            url: "./index.php?controller=pedido&action=confirmarPedido",
            data: {id : idPedido}
        }).done(function () {
            // alert("confirmado");
            let currentId = $("#"+idPedido);
            $("#confirmados").append(currentId);
            $(currentId).find("div div :button").remove();
            $(currentId).find("div div").append("<button class=\"btn btn-success btnBorrar\" id=\"\" value=\"{{ pedido.idpedido }}\"><i class=\"fas fa-check-double\"></i> Finalizado</button>\n");
        });
    });

    $('.btnBorrar').on('click', function () {
        let idPedido = $(this).val();
        $.ajax({
            type: "POST",
            url: "./index.php?controller=pedido&action=rechazarFinalizarPedido",
            data: {id : idPedido}
        }).done(function () {
            // alert("rechazado");
            $("#"+idPedido).remove();
        });
    });
});