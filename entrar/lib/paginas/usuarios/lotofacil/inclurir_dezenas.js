
function toggleButton(button) {
    button.classList.toggle('active');
}

function removerDezena(numero) {

    let inputDezenas = document.getElementById('dezenas');
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

    atualizarContador();
}

function adicionarDezena(numero) {
    let inputDezenas = document.getElementById('dezenas');
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

    atualizarContador();
}

function atualizarContador() {
    let inputDezenas = document.getElementById('dezenas');
    let contador = inputDezenas.value.split('-').filter(Boolean).length;

    document.getElementById('contador').textContent = contador + ' dezenas marcadas';
    
}

document.querySelectorAll('.numeros button').forEach(button => {
    button.addEventListener('click', () => {
        let numero = button.textContent;
        if (button.classList.contains('active')) {
            toggleButton(button);
            let inputDezenas = document.getElementById('dezenas');
            inputDezenas.value = inputDezenas.value.replace(numero, '').replace('--', '-').trim();
            atualizarContador();
        } else {
            if (document.querySelectorAll('.numeros button.active').length < 20) {
                toggleButton(button);
                adicionarDezena(button.textContent);
            }
        }
    });

    button.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        let numero = button.textContent;
        removerDezena(numero);
    });
});

function gerar_jogo() {
    // Coloque aqui a função para gerar o jogo
}