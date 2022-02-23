$('#modalDelete').on('shown.bs.modal', function (event) {
    let deleteTeam = document.getElementById('deleteTeam');
    let element = event.relatedTarget;
    let action = element.getAttribute('data-url');
    let name = element.dataset.name;
    deleteTeam.innerHTML = name;
    let form = document.getElementById('modalDeleteResourceForm');
    form.action = action;
})