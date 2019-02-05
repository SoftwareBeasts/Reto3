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
                $('#pestanaFin').toggleClass("disabled");
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
        $('#nombreResumen').text($(this).val());
    });
    // $('#nombre').on("blur", function () {
    //     if ($('#nombre').val().length < 2){
    //         // alert('El nombre debe tener como mínimo 2 letras');
    //         $('#nombre').focus();
    //     }
    // });
    $('#fecha').on("change", function () {
        $('#fechaResumen').text($(this).val());
    });
    $('#email').on("change", function () {
        $('#emailResumen').text($(this).val());
    });
    $('#telefono').on("change", function () {
        $('#telResumen').text($(this).val());
    });

    $("#formCarrito").validate({
        rules: {
            nombre: {
                required: true,
                minlength: 2
            },
            fecha: "required",
            email: {
                required: true,
                email: true
            },
            telefono: "required"
        },
        messages: {
            nombre: {
                required: "Por favor indica tu nombre",
                minlength: "El nombre debe tener al menos 2 letras"
            },
            fecha: "Por favor introduce una fecha",
            email: "Por favor introduce tu email",
            telefono: "Por favor introduce tu teléfono"
        },
        submitHandler: function(form) {
            // form.submit();
            $('#enviarPrimero').trigger('click');
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
        }
    });
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