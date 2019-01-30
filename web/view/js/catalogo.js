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

    $.ajax({
        type: "POST",
        url: "./index.php?controller=pedido&action=addCart",
        data: {id : productId, cantidad : cuantity}
    }).done(function () {
        addCartNumber(cuantity);
        showMessage(generateMessage(cuantity));
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

function showMessage(message) {
    $("#toastDisplay").removeClass("d-none");
    $("#alertMsg").html(message);
    $("#alertBotstrap").toast('show');
    setTimeout(function () {
        $("#toastDisplay").addClass("d-none");
    }, 3500)
}

