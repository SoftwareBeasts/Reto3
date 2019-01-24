/*Funcion que carga los datos de la categoria que se desea editar*/
$('#cambiarCategoriaModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Button that triggered the modal
    let recipient = button.data('currname')
    let idRecipient = button.data('currid')
    let modal = $(this)
    modal.find('#modalFormNombreCat').val(recipient)
    modal.find('#modalFormIdCat').val(idRecipient)
    modal.find('#modalDeleteCatBtn').val(idRecipient)
})
/*Funcion que carga el id del producto seleccionado para borrar*/
$('#borrarProdModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let recipient = button.data('prodid')
    let modal = $(this)
    modal.find('#modalFormIdProdDel').val(recipient)
})
/*Funcion que carga los datos del producto seleccionado para editar*/
$('#editarProdModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Button that triggered the modal
    let nombre = button.data('prodnom')
    let id = button.data('prodid')
    let desc = button.data('proddesc')
    let prec = button.data('prodprec')
    let img = button.data('prodimg')
    let min = button.data('prodmin')
    let cat = button.data('prodcat')
    var modal = $(this)
    modal.find('#modalFormNombreProd').val(nombre)
    modal.find('#modalFormDescProd').val(desc)
    modal.find('#modalFormPrecioProd').val(prec)
    modal.find('#modalCurrImgProd').attr('src',img)
    modal.find('#modalCurrImgrutProd').val(img)
    modal.find('#modalFormPedMinProd').val(min)
    modal.find('#option'+cat).attr('selected','selected')
    modal.find('#modalFormIdProd').val(id)
})

$(document).ready(function (){
    $("#modalDeleteCatBtn").on("click",function(){
        deleteCategoria(this);
    })
})

function deleteCategoria (buttonThis){
    let button = $(buttonThis);
    let catId = button.val();

    $.ajax({
        type: "POST",
        url: "./index.php?controller=categoria&action=deleteCategoria",
        data: {id : catId}
    }).done(function () {
        $("#cardCategoria"+catId).remove();
        $("#cambiarCategoriaModal").modal("hide");
}
