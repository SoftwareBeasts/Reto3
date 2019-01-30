/*Esta funcion cambia tamaños y contenido de diferentes elementos al cambia el
* tamaño de la pantalla*/
$(document).ready(function () {
    // Optimalisation: Store the references outside the event handler:
    var $window = $(window);
    var $pane = $('#pane1');
    function checkWidth() {
        var windowsize = $window.width();
        if (windowsize < 1100) {
            //si la ventana es mas pequeña que 1100, cambiamos el contenido de los
            //botones Editar, por un icono
            $('.editarCategoria').html("<i class='fas fa-cog'></i>");
        }
        else {
            $('.editarCategoria').html("Editar");
        }
        if (windowsize < 590) {
            $('.addButton').html('<i class="fas fa-plus"></i>');
        }
        else {
            $('.addCat').html('A&ntilde;adir Categor&iacute;a');
            $('.addProd').html('A&ntilde;adir Producto');
        }
        if (windowsize < 576) {
            $('.contentContainer').removeClass("container-fluid");
        }
        else {
            $('.contentContainer').addClass("container-fluid");
        }
    }
    // Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);
});
/*Añade una sombra a los contenedores del producto al pasar el raton por encima*/
$(".productoContainer").on({
    mouseenter: function () {
        $(this).addClass("shadow-lg");
    },
    mouseleave: function () {
        $(this).removeClass("shadow-lg");
    }
});
/*Cambia el color de fondo de los controlles de las categorias al al clickar*/
$(".contenedor-collapse").on("show.bs.collapse", function () {
    var activador = $(".categoria-toggler[data-target='#" + $(this).attr("id") + "']");
    var carta = activador.parent().parent().parent().parent();
    carta.removeClass("categoria-not-selected");
    carta.addClass("categoria-selected");
});
$(".contenedor-collapse").on("hide.bs.collapse", function () {
    var activador = $(".categoria-toggler[data-target='#" + $(this).attr("id") + "']");
    var carta = activador.parent().parent().parent().parent();
    carta.removeClass("categoria-selected");
    carta.addClass("categoria-not-selected");
});
/*Funcion que carga los datos de la categoria que se desea editar*/
$('#cambiarCategoriaModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('currname');
    var idRecipient = button.data('currid');
    var modal = $(this);
    modal.find('#modalFormNombreCat').val(recipient);
    modal.find('#modalFormIdCat').val(idRecipient);
    modal.find('#modalDeleteCatBtn').val(idRecipient);
});
/*Funcion que carga el id del producto seleccionado para borrar*/
$('#borrarProdModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var recipient = button.data('prodid');
    var modal = $(this);
    modal.find('#modalFormIdProdDel').val(recipient);
});
/*Funcion que carga los datos del producto seleccionado para editar*/
$('#editarProdModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var nombre = button.data('prodnom');
    var id = button.data('prodid');
    var desc = button.data('proddesc');
    var prec = button.data('prodprec');
    var img = button.data('prodimg');
    var min = button.data('prodmin');
    var cat = button.data('prodcat');
    var modal = $(this);
    modal.find('#modalFormNombreProd').val(nombre);
    modal.find('#modalFormDescProd').val(desc);
    modal.find('#modalFormPrecioProd').val(prec);
    modal.find('#modalCurrImgProd').attr('src', img);
    modal.find('#modalCurrImgrutProd').val(img);
    modal.find('#modalFormPedMinProd').val(min);
    modal.find('#option' + cat).attr('selected', 'selected');
    modal.find('#modalFormIdProd').val(id);
});
$(document).ready(function () {
    $("#modalDeleteCatBtn").on("click", function () {
        confirmarDelete(this);
    });
});
function confirmarDelete(button) {
    $(button).html("Estas Seguro?");
    $(button).prop("onclick", null).off("click");
    $(button).on("click", function () {
        deleteCategoria(this);
    });
}
function deleteCategoria(buttonThis) {
    var button = $(buttonThis);
    var catId = button.val();
    $.ajax({
        type: "POST",
        url: "./index.php?controller=categoria&action=deleteCategoria",
        data: { id: catId }
    }).done(function () {
        $("#cardCategoria" + catId).remove();
        $(button).html("Borrar");
        $(button).prop("onclick", null).off("click");
        $(button).on("click", function () {
            confirmarDelete(this);
        });
        $("#cambiarCategoriaModal").modal("hide");
    });
}
