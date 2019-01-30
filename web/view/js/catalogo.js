var toastCounter = 0;

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

function addCartNumber(cuantity) {
    let badge = $("#cartBadge");
    if(badge.hasClass("d-none"))
        badge.removeClass("d-none");
    badge.html(parseInt(badge.html())+parseInt(cuantity));
}

function generateMessage(cuantity) {
    let message = "Se han añadido "+cuantity+" productos a tu carrito";
    if(cuantity<=1){
        message = "Se ha añadido "+cuantity+" producto a tu carrito";
    }
    return message;
}
$(".toast").on("hide.bs.toast",function(){
    let tempId = $(this).parent().id();
    console.log("hey");
    $(this).parent().parent().remove("#"+tempId);
})
function showMessage(message) {
    let uniqueId = toastCounter
    $(".toast-container").html($(".toast-container").html()+"<div id=\""+uniqueId+"\" aria-live=\"polite\" aria-atomic=\"true\" class=\"p-4\" style=\"\">\n" +
        "        <div  class=\"toast alertBotstrap\" data-delay=\"3000\">\n" +
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
        "        </div>\n" +
        "    </div>");
    let ultimoToast = "#"+uniqueId;
    $(ultimoToast+" .alertMsg").html(message);
    $(ultimoToast+" .alertBotstrap").toast('show');
    setTimeout(function () {
        $(ultimoToast+" .alertBotstrap").toast("hide");
        let tempId = uniqueId;
        console.log(uniqueId);
        $(ultimoToast).parent().remove("#"+tempId);
    }, 3500)
    toastCounter++;
}

