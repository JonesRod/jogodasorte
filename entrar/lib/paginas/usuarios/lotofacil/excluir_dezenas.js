function config_padrao(){

    // Configura a quantidade de dezenas entre 15 e 20
    document.getElementById('qt_dezenas').value = '15';
    document.getElementById('qt_dezenas').setAttribute('min', '15');
    document.getElementById('qt_dezenas').setAttribute('max', '20');
    document.getElementById('qt_jogos').value = '1';

    calcular();
}
function calcular() {
    var qt_dezenas = parseFloat(document.getElementById('qt_dezenas').value);
    var qt_jogos = parseFloat(document.getElementById('qt_jogos').value);
    var valor_15 = parseFloat(document.getElementById('valor_15').value.replace(',', '.'));
    var valor_16 = parseFloat(document.getElementById('valor_16').value.replace(',', '.'));
    var valor_17 = parseFloat(document.getElementById('valor_17').value.replace(',', '.'));
    var valor_18 = parseFloat(document.getElementById('valor_18').value.replace(',', '.'));
    var valor_19 = parseFloat(document.getElementById('valor_19').value.replace(',', '.'));
    var valor_20 = parseFloat(document.getElementById('valor_20').value.replace(',', '.'));

    var resultado;

    if (qt_dezenas == 15) {
        resultado = (valor_15 * qt_jogos).toFixed(2);
    } else if (qt_dezenas == 16) {
        resultado = (valor_16 * qt_jogos).toFixed(2);
    } else if (qt_dezenas == 17) {
        resultado = (valor_17 * qt_jogos).toFixed(2);
    } else if (qt_dezenas == 18) {
        resultado = (valor_18 * qt_jogos).toFixed(2);
    } else if (qt_dezenas == 19) {
        resultado = (valor_19 * qt_jogos).toFixed(2);
    } else if (qt_dezenas == 20) {
        resultado = (valor_20 * qt_jogos).toFixed(2);
    }

    // Formatando o valor sem o símbolo de moeda
    let valor_sem_formatado = resultado.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    
    // Substituindo o ponto pela vírgula
    valor_sem_formatado = valor_sem_formatado.replace('.', ',');
    
    document.getElementById('valor_sem_formatacao').value = valor_sem_formatado;
    
    let valor_formatado = new Intl.NumberFormat('pt-BR', { style:'currency', currency: 'BRL'}).format(resultado);
    document.getElementById('valor').textContent = valor_formatado;

}

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
    let valor_str = document.getElementById('valor_sem_formatacao').value; // "0,10"
    let saldo_str = document.getElementById('saldo_formatado').value; // "1.000,00" ou "1.000"

    // Converter para número usando o formato de moeda
    let valor = parseFloat(valor_str.replace('R$ ', '').replace('.', '').replace(',', '.'));
    let saldo = parseFloat(saldo_str.replace('R$ ', '').replace('.', '').replace(',', '.'));

    //console.log(valor); // Saída: 0.1
    //console.log(saldo); // Saída: 1000

    if (!isNaN(valor) && !isNaN(saldo)) {
        if (valor <= saldo) {
            document.getElementById('alerta').textContent = 'Jogo gerado.';
            // Chama a função para gerar os números aleatórios
            gerarNumerosAleatorios();
            limparSelecaoEBotoes();
        } else {
            let saldo_formatado = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(saldo);
            let valor_formatado = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor);
            document.getElementById('alerta').textContent = 'Seu saldo é de ' + saldo_formatado + ' e está abaixo do custo a ser gerado ' + valor_formatado + '.';
        }
    } else {
        document.getElementById('alerta').textContent = 'Valores inválidos';
    }
}



function gerarNumerosAleatorios() {
    var qt_dezenas = parseInt(document.getElementById('qt_dezenas').value);
    var qt_jogos = parseInt(document.getElementById('qt_jogos').value);
    var dezenas_excluidas = document.getElementById('dezenas_excluidas').value.split('-').map(Number);

    console.log(qt_dezenas);
    console.log(qt_jogos);
    console.log(dezenas_excluidas);

    // Função para gerar números aleatórios sem repetição e dentro do intervalo desejado
    function gerarNumerosUnicos(inicio, fim, quantidade, excluidas) {
        var numeros = [];
        while (numeros.length < quantidade) {
            var numeroAleatorio = Math.floor(Math.random() * (fim - inicio + 1)) + inicio;
            if (!numeros.includes(numeroAleatorio) && !excluidas.includes(numeroAleatorio)) {
                numeros.push(numeroAleatorio);
            }
        }
        return numeros.sort((a, b) => a - b);
    }

    // Gera a quantidade de jogos desejada
    for (var j = 0; j < qt_jogos; j++) {
        var numerosDoJogo = gerarNumerosUnicos(1, 25, qt_dezenas, dezenas_excluidas);
        var resultado = numerosDoJogo.join('-');
        console.log(resultado);
    }
}


function limparSelecaoEBotoes() {
    // Desselecione todos os botões (substitua 'btn' pelo seletor real dos seus botões)
    var botoes = document.querySelectorAll('.excluir button');
    botoes.forEach(function(botao) {
        botao.classList.remove('active'); // Remover a classe 'active'

    });

    config_padrao();

    //console.log('oi');
    // Limpe o valor do campo (substitua 'campo' pelo seletor real do seu campo)
    document.getElementById('valor').value = '';
    document.getElementById('dezenas_excluidas').value = '';
    document.getElementById('alerta').textContent = '';
}
