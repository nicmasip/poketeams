$('#modalDelete').on('shown.bs.modal', function (event) {
    let deleteAbility = document.getElementById('deleteAbility');
    let element = event.relatedTarget;
    let action = element.getAttribute('data-url');
    let name = element.dataset.name;
    deleteAbility.innerHTML = name;
    let form = document.getElementById('modalDeleteResourceForm');
    form.action = action;
})