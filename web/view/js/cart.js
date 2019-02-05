$(document).ready(function () {
    $(".eliminar").on("click", function () {
        deleteProduct(this);
    });
    $(".cuantity").on("change", function () {
        refreshPrice(this);
        $('td[resumenCantidad="'+$(this).attr("valorId")+'"').html($(this).val());
    });
    $(".pestana").on("click", function () {
        switch ($(this).attr('id')){
            case 'iraDatos':
                $('#pestanaDatos').trigger('click');
                $('#resumenCarrito').html($('#contenido').html());
                break;
            case 'iraFin':
                $('#pestanaFin').trigger('click');
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
        autoclose: true,
        format: 'yyyy-mm-d',
        startDate: '+4d',
        forceParse: false,
        orientation: "bottom right",
        daysOfWeekDisabled: "0,1,2",
        todayHighlight: true
    });
    $(".cuantity").each(function () {
        $('td[resumenCantidad="'+$(this).attr("valorId")+'"').html($(this).val());
    });
    $(".precioSubtotal").on("change", function () {
        $('td[resumenSubTotal="'+$(this).attr("valorId")+'"').html($(this).text());
    });
    $(".precioSubtotal").each(function () {
        $('td[resumenSubTotal="'+$(this).attr("valorId")+'"').html($(this).text());
    });
    $('#nombre').on("change", function () {
        $('#nombreResumen').text("Nombre: "+$(this).val());
    });
    $('#fecha').on("change", function () {
        $('#fechaResumen').text("Fecha de recogida: "+$(this).val());
    });
    $('#email').on("change", function () {
        $('#emailResumen').text("Email: "+$(this).val());
    });
    $('#telefono').on("change", function () {
        $('#telResumen').text("Teléfono: "+$(this).val());
    });
    let f = new Date();
    f.setDate(f.getDate()+4);
    // $('#formCarrito').on("submit", function () {
    //     if ($('#fecha').val() < f){
    //         alert('fecha mal');
    //     }
    // });
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
            $("#contenido").html("<div class='m-auto col-md-5 text-center'><h6>No se han añadido productos a tu carrito. Añade productos </h6></div><button class='page-link pestana m-auto col-5' id='iraTienda'>Aqu&iacute;</button>");
            $("#iraTienda").on("click", function () {window.location.href = "index.php";});
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
    $('td[resumenSubTotal="'+input.attr("valorId")+'"').html(td.html());
    tdTotal.html(pTotal+"€");
    $('td[resumenTotal]').html(tdTotal.html());

    $.ajax({
        type: "POST",
        url: "./index.php?controller=pedido&action=editCart",
        data: {id : input.attr('valorId'), cuantity : cantidad}
    });
}

function deleteLastCharacter(string) {
    return parseInt(string.substring(0,string.length-1));
}