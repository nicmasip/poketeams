$('#modalDelete').on('shown.bs.modal', function (event) {
    let element = event.relatedTarget;
    let action = element.getAttribute('data-url');
    let form = document.getElementById('modalDeleteResourceForm');
    form.action = action;
})