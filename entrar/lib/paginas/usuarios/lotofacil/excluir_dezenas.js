
function toggleButton(button) {
    button.classList.toggle('active');
}

function removerDezena1(numero) {

    let inputDezenas = document.getElementById('dezenas_excluidas');
    let valorAtual = inputDezenas.value.trim();

    let dezenas = valorAtual.split('-').filter(Boolean).map(Number);
    let index = dezenas.indexOf(numero);

    if (index !== -1) {
        dezenas.splice(index, 1);

        if (dezenas.length > 0) {
            inputDezenas.value = dezenas.join('-');
        } else {
            inputDezenas.value = '';
        }
    }
    atualizarContador1();
}
function DezenasExcluidas(numero) {
    let inputDezenas = document.getElementById('dezenas_excluidas');
    let valorAtual = inputDezenas.value.trim();

    if (valorAtual === '') {
        inputDezenas.value = numero;
    } else {
        let dezenas = valorAtual.split('-').map(Number);
        if (!dezenas.includes(Number(numero))) {
            dezenas.push(numero);
            dezenas = dezenas.sort((a, b) => a - b);
            inputDezenas.value = dezenas.join('-');
        }
    }
    atualizarContador1();
}

function atualizarContador1() {

    let inputDezenas = document.getElementById('dezenas_excluidas');
    let contador = inputDezenas.value.split('-').filter(Boolean).length;

    document.getElementById('contador1').textContent = contador + ' dezenas marcadas';
}

document.querySelectorAll('.excluir button').forEach(button => {
    button.addEventListener('click', () => {
        let numero = button.textContent;
        if (button.classList.contains('active')) {
            toggleButton(button);
            let inputDezenas = document.getElementById('dezenas_excluidas');
            inputDezenas.value = inputDezenas.value.replace(numero, '').replace('--', '-').trim();
            atualizarContador1();
        } else {
            if (document.querySelectorAll('.excluir button.active').length < 5) {
                toggleButton(button);
                DezenasExcluidas(button.textContent);
            }
        }
    });

    button.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        let numero = button.textContent;
        removerDezena1(numero);
    });
    
});

function gerar_jogo() {
    // Coloque aqui a função para gerar o jogo
}
