$(document).ready(function () {
    $(".eliminar").on("click", function () {
        deleteProduct(this);
    });
    $(".cuantity").on("change", function () {
        refreshPrice(this);
    });
    $(".pestana").on("click", function () {
        switch ($(this).attr('id')){
            case 'iraDatos':
                // $('#pestanaDatos').toggleClass("disabled");
                $('#pestanaDatos').trigger('click');
                // $('#pestanaCarrito').toggleClass("disabled");
                // $('#pestanaCarrito').css({
                //     "background-color": "#00db39",
                //     "color": "white",
                //     "border": "1px solid #dee2e6"
                // });
                break;
            case 'iraFin':
                // $('#pestanaFin').toggleClass("disabled");
                $('#pestanaFin').trigger('click');
                // $('#pestanaDatos').toggleClass("disabled");
                // $('#pestanaDatos').css({
                //     "background-color": "#00db39",
                //     "color": "white",
                //     "border": "1px solid #dee2e6"
                // });
                break;
            case 'iraTienda':
                window.location.href = "index.php";
                break;
            default:
                $('#pestanaCarrito').trigger('click');
                break;
        }
    });
    $('#formFechaDatepicker input').datepicker({
        language: "es",
        format: 'yyyy-mm-d',
        startDate: '+4d',
        forceParse: false,
        orientation: "bottom right",
        daysOfWeekDisabled: "0,1,2",
        todayHighlight: true
    });
    /*let fecha = new Date();
    let fechaFormat = fecha.getFullYear()+"-"+dobleDigito(fecha.getMonth()+1)+"-"+dobleDigito(fecha.getDate()+4);
    $('#fecha').attr("min", fechaFormat);
    $('#fecha').attr("value", fechaFormat);*/
});

function dobleDigito(n) {
    return n < 10 ? '0' + n : '' + n;
}

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
            $("#content").html("<div class=\"m-auto col-md-5 text-center\">\n" +
                "                        <h6>No se han añadido productos a tu carrito. Añade productos </h6>\n" +
                "                    </div>\n" +
                "                    <button class=\"page-link pestana m-auto col-5\" id=\"iraTienda\">Aqu&iacute;</button>");
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