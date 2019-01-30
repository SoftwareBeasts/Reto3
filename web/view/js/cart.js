$(document).ready(function () {
    $(".eliminar").on("click", function () {
        deleteProduct(this);
    });
    $(".cuantity").on("change", function () {
        refreshPrice(this);
    })
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

function refreshPrice(thisInput) {
    let precioUnitario = deleteLastCharacter($(thisInput).parent().siblings(".precioUnitario").html());
    let price = $(thisInput).parent().siblings(".precioSubtotal").html();
    price = deleteLastCharacter(price);
    price = price *
}

function deleteLastCharacter(string) {
    return price.substring(0,price.length-1);
}