$('#modalDelete').on('shown.bs.modal', function (event) {
    let deleteItem = document.getElementById('deleteItem');
    let element = event.relatedTarget;
    let action = element.getAttribute('data-url');
    let name = element.dataset.name;
    deleteItem.innerHTML = name;
    let form = document.getElementById('modalDeleteResourceForm');
    form.action = action;
})