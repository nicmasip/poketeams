$('#modalDelete').on('shown.bs.modal', function (event) {
    let deleteTeamPokemon = document.getElementById('deleteTeamPokemon');
    let element = event.relatedTarget;
    let action = element.getAttribute('data-url');
    let name = element.dataset.name;
    deleteTeamPokemon.innerHTML = name;
    let form = document.getElementById('modalDeleteResourceForm');
    form.action = action;
})