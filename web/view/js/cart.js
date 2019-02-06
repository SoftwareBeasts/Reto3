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
                $nombreOK = false;
                $fechaOK = false;
                $emailOK = false;
                $telOK = false;
                //Nombre
                if($('#nombre').val().length < 2){$nombreOK = true;}
                //fecha
                if(/((19|20)[0-9]{2})\-([0-2][0-9])\-([0-2][0-9]|[3][0-1])/.test(text)){$fechaOK = true;}
                //email
                if(/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/.test($('#email'))){$emailOK = true;}
                //telefono
                if(!/^[9|6|7][0-9]{8}$/.test($('#telefono').val())){$telOK = true;}

                if($nombreOK && $fechaOK && $emailOK && $telOK){
                    $('#pestanaFin').toggleClass("disabled");
                    $('#pestanaFin').trigger('click');
                }
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
        if($('#nombre').val().length < 2){
            $('#nombre').css({"box-shadow": "inset 0px 0px 10px 1px red"})
        }else{
            $('#nombre').css({"box-shadow": ""});
            $('#nombreResumen').text($(this).val());
        }
    });
    $('#fecha').on("change", function () {
        if(!/^((19|20)[0-9]{2})\-([0-2][0-9])\-([0-2][0-9]|[3][0-1])$/.test($('#fecha').val())){
            $('#fecha').css({"box-shadow": "inset 0px 0px 10px 1px red"})
        }else{
            $('#fecha').css({"box-shadow": ""});
            $('#fechaResumen').text($(this).val());
        }
    });
    $('#email').on("change", function () {
        let a = new RegExp("^([a-z\\d!#$%&'*+\\-\\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\\.[a-z\\d!#$%&'*+\\-\\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|\"((([ \\t]*\\r\\n)?[ \\t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \\t]*\\r\\n)?[ \\t]+)?\")@(([a-z\\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\\d\\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\\d\\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\\.?$");
        if(!a.test($('#email').val())){
            $('#email').css({"box-shadow": "inset 0px 0px 10px 1px red"})
        }else{
            $('#email').css({"box-shadow": ""});
            $('#emailResumen').text($(this).val());
        }
    });
    $('#telefono').on("change", function () {
        if(!/^[9|6|7][0-9]{8}$/.test($('#telefono').val())){
            $('#telefono').css({
                "box-shadow": "inset 0px 0px 10px 1px red"
            })
        }else{
            $('#telefono').css({"box-shadow": ""});
            $('#telResumen').text($(this).val());
        }
    });
    $('#enviarSegundo').on("click", function () {
        $('#enviarPrimero').trigger('click');
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
            telefono: {
                required: true,
                minlength: 9
            }
        },
        messages: {
            nombre: {
                required: "Por favor indica tu nombre",
                minlength: "El nombre debe tener al menos 2 letras"
            },
            fecha: "Por favor introduce una fecha",
            email: "Por favor introduce tu email",
            telefono: {
                required: "Por favor indica tu telefono",
                minlength: "El telefono debe tener al menos 9 dígitos"
            }
        },
        submitHandler: function(form) {
            form.submit();
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