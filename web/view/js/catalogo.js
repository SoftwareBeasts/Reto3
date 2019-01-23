$(document).ready(function () {
    $("[class=addCart]").on("click", function () {
        addCart(this);
    });
});

function addCart(buttonThis) {
    let button = $(button);
    let productId = button.val();
    let cuantity = $('#spinner'+'productId').val();

    $.ajax({
        type: "POST",
        url: "./index.php?controller=producto&action=addCart",
        data: {id : productId, cantidad : cuantity}
    }).done(function () {
        
    });
    return encontrado;
}

