// Aplica o comportamento de select 2 a todos os inputs com a classe select2
// Permite que possa ser pesquisado as informações do select e também selects múltiplos
document.querySelectorAll('.select2').forEach(function(selectElement) {
    const options = Array.from(selectElement.querySelectorAll('option'));
    const isMultiple = selectElement.hasAttribute('multiple');
    let selectedOptions = isMultiple ? [] : null;
    const optionsLabels = [];
    selectElement.classList.add('d-none');

    const container = document.createElement('div');
    const selector2 = document.createElement('div');
    selector2.classList.add('selector-2');

    // Configura as estruturas em html do seletor
    const fieldSearch = document.createElement('div');
    fieldSearch.classList.add('field-search');
    const input = document.createElement('input');
    input.type = 'text';
    input.classList.add('form-control');
    input.placeholder = 'Pesquise pelo item desejado';
    fieldSearch.appendChild(input);

    const optionsList = document.createElement('div');
    optionsList.classList.add('options-list');

    // Adiciona os containers onde serão mostrados as opções do seletor
    selector2.appendChild(fieldSearch);
    selector2.appendChild(optionsList);
    container.appendChild(selector2);

    // Adiciona as tags de pesquisa em caso de seletor múltiplo
    function changeSearchTags() {
        const tags = selector2.querySelectorAll('.tag');
        tags.forEach(tag => tag.remove());
        options.forEach(option => option.removeAttribute('selected'));

        if (Array.isArray(selectedOptions)) {
            selectedOptions.forEach(index => {
                const tag = document.createElement('div');
                tag.classList.add('tag');
                tag.textContent = optionsLabels[index];
                fieldSearch.appendChild(tag);
                options[index].setAttribute('selected', 'true');
            });
        } else if (selectedOptions !== null) {
            options[selectedOptions].setAttribute('selected', 'true');
        }
    }

    // Para cada opção realiza uma cópia e adiciona à estrutura de select2, também realiza os binds dos eventos
    options.forEach((option, index) => {
        const optionDiv = document.createElement('div');
        optionDiv.classList.add('selector-option');
        optionDiv.textContent = option.textContent;
        optionDiv.dataset.val = option.value;
        optionsLabels.push(option.textContent);

        if (option.selected) {
            optionDiv.classList.add('selected');
            if (isMultiple) {
                selectedOptions.push(index);
            } else {
                selectedOptions = index;
            }
        }

        optionsList.appendChild(optionDiv);

        optionDiv.addEventListener('click', function() {
            if (optionDiv.classList.contains('selected')) {
                optionDiv.classList.remove('selected');
                if (isMultiple) {
                    const selectedIndex = selectedOptions.indexOf(index);
                    if (selectedIndex !== -1) {
                        selectedOptions.splice(selectedIndex, 1);
                        changeSearchTags();
                    }
                }
            } else {
                if (isMultiple) {
                    optionDiv.classList.add('selected');
                    selectedOptions.push(index);
                } else {
                    const allOptions = optionsList.querySelectorAll('.selector-option');
                    allOptions.forEach(opt => opt.classList.remove('selected'));
                    optionDiv.classList.add('selected');
                    selectedOptions = index;
                }
                changeSearchTags();
            }
        });
    });

    selectElement.closest('div').appendChild(container);

    // Ao selecionar uma opção
    container.addEventListener('click', function(event) {
        event.stopPropagation();
        selector2.classList.add('active');
        const rect = container.getBoundingClientRect();
        if (rect.top + rect.height + 300 > window.innerHeight) {
            optionsList.classList.add('upper');
        }
    });

    // AO realizar a busca por uma opção
    input.addEventListener('keyup', function() {
        const searchValue = input.value.toLowerCase();
        const optionDivs = optionsList.querySelectorAll('.selector-option');
        optionDivs.forEach((optionDiv, index) => {
            if (optionsLabels[index].toLowerCase().includes(searchValue)) {
                optionDiv.classList.remove('d-none');
            } else {
                optionDiv.classList.add('d-none');
            }
        });
    });

    changeSearchTags();
});

// Fecha o componente de select 2 ao clicar erm qualquer outro ponto da tela
window.addEventListener('click', function() {
    document.querySelectorAll('.selector-2').forEach(function(element) {
        element.classList.remove('active');
    });
});
