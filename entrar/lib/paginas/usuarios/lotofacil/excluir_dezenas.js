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
    var valor_15 = parseFloat(document.getElementById('valor_15').value);
    var valor_16 = parseFloat(document.getElementById('valor_16').value);
    var valor_17 = parseFloat(document.getElementById('valor_17').value);
    var valor_18 = parseFloat(document.getElementById('valor_18').value);
    var valor_19 = parseFloat(document.getElementById('valor_19').value);
    var valor_20 = parseFloat(document.getElementById('valor_20').value);

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
    //let valor_sem_formatado = resultado.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    
    // Substituindo o ponto pela vírgula
    let valor_sem_formatado = resultado;
    
    document.getElementById('valor_sem_formatacao').value = resultado;
    
    let valor_formatado = new Intl.NumberFormat('pt-BR', { style:'currency', currency: 'BRL'}).format(resultado);
    document.getElementById('valor').textContent = valor_formatado;

}

/*function toggleButton1(button) {
    button.classList.toggle('active');
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

    // Remover o primeiro traço, se existir no início
    if (inputDezenas.value.startsWith('-')) {
        inputDezenas.value = inputDezenas.value.substring(1);
    }

    // Remover o último traço, se existir no final
    if (inputDezenas.value.endsWith('-')) {
        inputDezenas.value = inputDezenas.value.slice(0, -1);
    }

    atualizarContador1();
}

function atualizarContador1() {
    let inputDezenas = document.getElementById('dezenas_excluidas');
    let valorAtual = inputDezenas.value.trim();

    let contador = valorAtual.split('-').filter(Boolean).length;

    document.getElementById('contador1').textContent = contador + ' dezenas marcadas';
}

document.querySelectorAll('.excluir button').forEach(button => {
    button.addEventListener('click', () => {
        let numero = button.textContent;
        if (button.classList.contains('active')) {
            toggleButton1(button);
            let inputDezenas = document.getElementById('dezenas_excluidas');
            inputDezenas.value = inputDezenas.value.replace(numero, '').replace('--', '-').trim();
            DezenasExcluidas(''); // Adicione esta linha para chamar DezenasExcluidas com uma string vazia
        } else {
            if (document.querySelectorAll('.excluir button.active').length < 5) {
                toggleButton1(button);
                DezenasExcluidas(button.textContent);
            }
        }
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

    //console.log(qt_dezenas);
    //console.log(qt_jogos);
    //console.log(dezenas_excluidas);

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
        chamarFuncaoPHP(resultado);
    }

}

function chamarFuncaoPHP(valor) {
    // Cria um objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Especifica o método HTTP e a URL do arquivo PHP
    xhr.open('POST', 'consulta_jogo.php', true);

    // Define a função de callback a ser chamada quando a resposta estiver pronta
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // A resposta do PHP está disponível em xhr.responseText
            console.log(xhr.responseText);
            // Aqui você pode manipular a resposta, como atualizar a página ou exibir uma mensagem.
        }
    };

    // Configura os cabeçalhos da requisição
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Envie a requisição com os dados
    xhr.send('valor= ' + encodeURIComponent(valor));
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
}*/
