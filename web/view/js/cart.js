$(document).ready(function () {
    $(".eliminar").on("click", function () {
        deleteProduct(this);
    });
    $(".cuantity").on("change", function () {
        refreshPrice(this);
    })
});

function deleteProduct(thisButton) {
    let button = $(thisButton);
    let productId = button.val();

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
        else
        {
            let tdPrecioTotal = $("#precioTotal");
            let precio = deleteLastCharacter(tdPrecioTotal.html()) -deleteLastCharacter(button.parent().siblings(".precioSubtotal").html());
            tdPrecioTotal.html(precio+"€");
            button.parent().parent().remove();
        }
    });
}

function refreshPrice(thisInput) {
    let input = $(thisInput);
    let td = input.parent().siblings(".precioSubtotal");
    let cantidad = input.val();
    let newPrice = deleteLastCharacter(input.parent().siblings(".precioUnitario").html()) * cantidad;
    let tdTotal = $("#precioTotal");
    let pTotal = (deleteLastCharacter(tdTotal.html()) - deleteLastCharacter(td.html())) +newPrice;
    td.html(newPrice + "€");
    tdTotal.html(pTotal+"€");

    $.ajax({
        type: "POST",
        url: "./index.php?controller=pedido&action=editCart",
        data: {id : input.attr('valorId'), cuantity : cantidad}
    });
}

function deleteLastCharacter(string) {
    return parseInt(string.substring(0,string.length-1));
}