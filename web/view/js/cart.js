$(document).ready(function () {
    $(".eliminar").on("click", function () {
        deleteProduct(this);
    });
});

function deleteProduct(thisButton) {
    let productId = $(thisButton).val();

    $.ajax({
        type: "POST",
        url: "./index.php?controller=pedido&action=deleteCart",
        data: {id : productId}
    }).done(function (data) {
        if(data)
        {
            $("#content").html("<div class=\"offset-md-3 col-md-5 text-center\">" +
                "<h6>No se han añadido productos a tu carrito. Añade productos <a href=\"../index.php\">aquí</a></h6>" +
                "</div>");
        }
        $(thisButton).parent().parent().remove();
    });
}