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
            location.reload();
        });
    });

    $(".enviarEmail").on("click", function () {
        window.location.replace("http://www.w3schools.com");
    });

    $('#enviarEmail').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

    $('.btnBorrar').on('click', function () {
        let idPedido = $(this).val();
        $.ajax({
            type: "POST",
            url: "./index.php?controller=pedido&action=rechazarFinalizarPedido",
            data: {id : idPedido}
        }).done(function () {
            // alert("rechazado");
            location.reload();
        });
    });
});