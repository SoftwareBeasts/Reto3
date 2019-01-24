/*Funcion que carga los datos de la categoria que se desea editar*/
$('#cambiarCategoriaModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('currname');
    var idRecipient = button.data('currid');
    var modal = $(this);
    modal.find('#modalFormNombreCat').val(recipient);
    modal.find('#modalFormIdCat').val(idRecipient);
    modal.find('#modalDeleteCatBtn').attr('href', "index.php?controller=categoria&action=deleteCategoria&id=" + idRecipient);
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
    modal.find('#modalFormPedMinProd').val(min);
    modal.find('#option' + cat).attr('selected', 'selected');
    modal.find('#modalFormIdProd').val(id);
});
/*$(document).ready(function () {
    $("[class=addCart]").on("click", function () {
        addCart(this);
    });
});*/
/*
$.ajax({
    type: "POST",
    url: "./index.php?controller=producto&action=addCart",
    data: {id : productId, cantidad : cuantity}
}).done(function () {
*/