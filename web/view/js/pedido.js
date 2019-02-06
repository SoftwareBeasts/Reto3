/*Agrega eventos a diferentes elementos de la pagina*/
$(document).ready(function () {
    /*Alterna entre los pedidos Sin Confirmar y los COnfirmados*/
    $(".botoncolapsar").on("click", function () {
        $('.botoncolapsar').toggleClass("active");
        $('.active').focus();
        $('.colapsar').collapse("toggle");
    });
    /*Efecto Visual de Sombra al pasar el raton por encima de los pedidos*/
    $(".pedidoCard").on({
        mouseenter: function () {
            $(this).addClass("shadow-lg");
        },
        mouseleave: function () {
            $(this).removeClass("shadow-lg");
        }
    });
    /*Eliminar el pedido de sin confirmar y moverlo a confirmados por ajax*/
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
    /*Eliminar el pedido por ajax*/
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

    /*Enviar correo custom*/
    $('.enviarEmail').on('click', function () {
        let boton = $(this);
        let id = boton.attr("form");
        // let emailD = $(this).parent().siblings(".modal-body").child(".form-group").child("#email").val();
        let emailD = $('#email'+id).val();
        let asuntoD = $('#asunto'+id).val();
        let cuerpo = $('#contenido'+id).val();


        $.ajax({
            type: "POST",
            url: "./index.php?controller=pedido&action=customEmail",
            data: {
                email : emailD,
                asunto : asuntoD,
                contenido : cuerpo
            }
        }).done(function () {
            $('#enviarEmail').trigger("click");
            // alert(emailD+asuntoD+cuerpo);
        });
    });
});