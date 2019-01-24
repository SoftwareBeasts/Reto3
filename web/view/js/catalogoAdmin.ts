$('#cambiarCategoriaModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('currname')
    var idRecipient = button.data('currid')
    // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#modalFormNombreCat').val(recipient)
    modal.find('#modalFormIdCat').val(idRecipient)
    modal.find('#modalDeleteCatBtn').attr('href',"index.php?controller=categoria&action=deleteCategoria&id="+idRecipient)
})

$('#borrarProdModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('prodid') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#modalFormIdProdDel').val(recipient)
})