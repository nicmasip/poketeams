$('#modalDelete').on('shown.bs.modal', function (event) {
    let deletePokemon = document.getElementById('deletePokemon');
    let element = event.relatedTarget;
    let action = element.getAttribute('data-url');
    let name = element.dataset.name;
    deletePokemon.innerHTML = name;
    let form = document.getElementById('modalDeleteResourceForm');
    form.action = action;
})