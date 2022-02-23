$('#modalDelete').on('shown.bs.modal', function (event) {
    let deleteUser = document.getElementById('deleteUser');
    let element = event.relatedTarget;
    let action = element.getAttribute('data-url');
    let name = element.dataset.name;
    deleteUser.innerHTML = name;
    let form = document.getElementById('modalDeleteResourceForm');
    form.action = action;
})