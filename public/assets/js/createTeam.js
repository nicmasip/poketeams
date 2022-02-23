    let count = 1;
    let btnAddPokemon = document.getElementById('btnAddPokemon');
    let btnRemovePokemon = document.getElementById('btnRemovePokemon');
    let div = document.getElementById('eventNode');
    
    btnAddPokemon.addEventListener('click', function(){
        if(count < 6){
            if(count == 0){
                div.classList.remove('d-none');
                let pokemon = div.querySelector('#pokemon');
                pokemon.required = true;
                let gender = div.querySelector('#gender');
                gender.required = true;
                let level = div.querySelector('#level');
                level.required = true;
                count++
            }
            else{
                count++
                let divClone = div.cloneNode(true);
                divClone.removeAttribute('id');
                
                let emptyClassInputs = divClone.querySelectorAll('.emptyInput');
                for (let i = 0; i < emptyClassInputs.length; ++i) {
                    emptyClassInputs[i].value = '';
                }
                
                let emptyClassSelects = divClone.querySelectorAll('.emptySelect');
                for (let i = 0; i < emptyClassSelects.length; ++i) {
                    emptyClassSelects[i].value = ' ';
                    emptyClassSelects[i].selected = true;
                    emptyClassSelects[i].disabled = true;
                }
                
                let title = divClone.querySelector('#cardTitle');
                title.textContent = 'Pokémon #' + count;
                title.id = 'cardTitle' + count;
                
                let pokemon = divClone.querySelector('#pokemon');
                pokemon.id = 'pokemon' + count;
                let gender = divClone.querySelector('#gender');
                gender.id = 'gender' + count;
                let level = divClone.querySelector('#level');
                level.id = 'level' + count;
                
                divClone.classList.add('mb-4');
                divClone.id = 'divClone' +  count;
                div.parentNode.appendChild(divClone);
            }
            console.log(count);
        }
    });
    
    btnRemovePokemon.addEventListener('click', function(){
        if(count > 0){
            if(count == 1){
                let pokemon = div.querySelector('#pokemon');
                pokemon.required = false;
                let gender = div.querySelector('#gender');
                gender.required = false;
                let level = div.querySelector('#level');
                level.required = false;
                div.classList.add('d-none');
            }
            else{
                let idToSelect = 'divClone' +  count;
                let divCloneToRemove = document.getElementById(idToSelect);
                div.parentNode.removeChild(divCloneToRemove);
            }
            count--;
            console.log(count);
        }
    });