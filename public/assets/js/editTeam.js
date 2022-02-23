let numberShown = document.querySelectorAll('.teampokemonShown').length;
let count = numberShown;
let btnAddPokemon = document.getElementById('btnAddPokemon');
let btnRemovePokemon = document.getElementById('btnRemovePokemon');
let div = document.getElementById('eventNode');
let mainContainer = document.getElementById('mainContainer');

btnAddPokemon.addEventListener('click', function(){
    if(count < 6){
        count++;
        let divClone = div.cloneNode(true);
        divClone.removeAttribute('id');

        let title = divClone.querySelector('#cardTitle');
        title.textContent = 'Pokémon #' + count;
        title.id = 'cardTitle' + count;
        
        let pokemon = divClone.querySelector('#pokemon');
        pokemon.id = 'pokemon' + count;
        pokemon.required = true;
        
        let gender = divClone.querySelector('#gender');
        gender.id = 'gender' + count;
        gender.required = true;
        
        let level = divClone.querySelector('#level');
        level.id = 'level' + count;
        level.required = true;
        level.name = 'level[]';
        
        let levelLabel = divClone.querySelector('#levelLabel');
        levelLabel.for = 'level[]';
        
        divClone.classList.add('mb-4');
        divClone.classList.remove('d-none');
        
        divClone.id = 'divClone' +  count;
        
        mainContainer.appendChild(divClone);
    }
});

btnRemovePokemon.addEventListener('click', function(){
    if(count > numberShown){
        let idToSelect = 'divClone' +  count;
        let divCloneToRemove = document.getElementById(idToSelect);
        mainContainer.removeChild(divCloneToRemove);
        count--;
    }
});