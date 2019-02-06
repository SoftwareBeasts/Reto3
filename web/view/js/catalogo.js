var toastCounter = 0;
/*Añade prductos al carrito de la compra*/
$(document).ready(function () {
    $(".addCart").on("click", function () {
        addCart(this);
    });
});

/*Cambian el icono de los desplegables de categoria*/
$(".contenidoCategoria").on("show.bs.collapse",function(){
    let activador = $(".desplegable[data-target='#"+$(this).attr("id")+"']");
    let target = $(activador).find("div>div:last");
    $(target).html('<i class="fas fa-angle-down"></i>');
    $(activador).parent().parent().removeClass("categoria-closed");
    $(activador).parent().parent().addClass("categoria-open");
})
$(".contenidoCategoria").on("hide.bs.collapse",function(){
    let activador = $(".desplegable[data-target='#"+$(this).attr("id")+"']");
    let target = $(activador).find("div>div:last");
    $(target).html('<i class="fas fa-angle-right"></i>');
    $(activador).parent().parent().removeClass("categoria-open");
    $(activador).parent().parent().addClass("categoria-closed");
})

/**
 * Añade el producto al que se le haya hecho click al carrito de la compra y llama a la funcion que muestra un toast
 * @param buttonThis buttonElement El botón que ha ejecutado la accion
 */
function addCart(buttonThis) {
    let button = $(buttonThis);
    let productId = button.val();
    let cuantity = $('#spinner'+productId).val();
    $(".toast-container").html($(".toast-container").html()+"");

    $.ajax({
        type: "POST",
        url: "./index.php?controller=pedido&action=addCart",
        data: {id : productId, cantidad : cuantity}
    }).done(function () {
        addCartNumber(cuantity);
        showMessage(generateMessage(cuantity),);
    });
}

/**
 * Aumenta la cantidad de la medalla que hay en el icono del carrito en la parte superior de la pantalla
 * @param cuantity Que cantidad aumenta
 */
function addCartNumber(cuantity) {
    let badge = $("#cartBadge");
    if(badge.hasClass("d-none"))
        badge.removeClass("d-none");
    badge.html(parseInt(badge.html())+parseInt(cuantity));
}

/**
 * Genera el mensaje del toast a mostrar
 * @param cuantity La cantidad de productos que se ha añadido
 * @returns {string} El mensaje
 */
function generateMessage(cuantity) {
    let message = "Se han añadido "+cuantity+" productos a tu carrito";
    if(cuantity<=1){
        message = "Se ha añadido "+cuantity+" producto a tu carrito";
    }
    return message;
}

/**
 * Comprueba que haya algun toast en el paso de mostrarse y retrasa a los siguientes
 *
 * Si hay algun toast mostrandose, la aparicion de los siguientes toasts se retrasa 2 segundos
 * @param toastId El id del toast que se quiere mostrar
 */
function checkToastShown(toastId) {
    if ($(".toast-container>.toast").hasClass("showing")){
        setTimeout(()=>{
            console.log("no");
            checkToastShown(toastId);
        },1000);
    }else{
        console.log("si");
        $(".toast-container>#"+toastId).toast('show');
        setTimeout(()=>{
            $(".toast-container>#"+toastId).toast('hide');
            setTimeout(()=>{
                $(".toast-container>#"+toastId).remove();
            },2000)
        },2000);
    }
}

/**
 * Crea el toast que se va a mostrar, y le introduce el mensaje apropiado, después, llama a la funcion checkToastShown
 * @param message
 */
function showMessage(message) {
    $(".toast-container").html($(".toast-container").html()+
        "        <div  class=\"toast alertBotstrap\" data-autohide='false' id='"+toastCounter+"'>\n" +
        "            <div class=\"toast-header\">\n" +
        "                <img src=\"./view/media/favicon.png\" class=\"rounded mr-2\" alt=\"...\">\n" +
        "                <strong class=\"mr-auto\">Escuela de Hostelería</strong>\n" +
        "                <small>ahora mismo</small>\n" +
        "                <button type=\"button\" class=\"ml-2 mb-1 close\" data-dismiss=\"toast\" aria-label=\"Close\">\n" +
        "                    <span aria-hidden=\"true\">&times;</span>\n" +
        "                </button>\n" +
        "            </div>\n" +
        "            <div  class=\"toast-body text-center alertMsg\">\n" +
        "            </div>\n" +
        "        </div>");
    let currentToastId = toastCounter;
    let ultimoToast = ".toast-container>#"+currentToastId;
    $(ultimoToast+" .alertMsg").html(message);
    checkToastShown(currentToastId);


/*
    let primerToast = ".toast-container>.toast:first";
    setTimeout(()=>{
        console.log("Me cago en dios y en su puta madre")
        $(primerToast).;
    },5000)
    */
    toastCounter++;
}

