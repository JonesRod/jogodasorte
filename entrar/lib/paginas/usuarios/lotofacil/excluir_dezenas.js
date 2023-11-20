function config_padrao(){

    // Configura a quantidade de dezenas entre 15 e 20
    document.getElementById('qt_dezenas').value = '15';
    document.getElementById('qt_dezenas').setAttribute('min', '15');
    document.getElementById('qt_dezenas').setAttribute('max', '20');
    document.getElementById('qt_jogos').value = '1';

    calcular();

    var concurso_anterior = document.getElementById('ultimo_concurso').value;
    concurso_anterior = parseFloat(concurso_anterior);
    var concurso_referente = concurso_anterior + 1;

    document.getElementById('lista_jogos').value = concurso_referente;
    document.getElementById('lista_resultados').value = concurso_anterior;

    // Simular um clique no botão
    carregarJogos();

    carregarResultados();
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

    document.getElementById('valor_sem_formatacao').value = resultado;
    
    let valor_formatado = new Intl.NumberFormat('pt-BR', { style:'currency', currency: 'BRL'}).format(resultado);
    document.getElementById('valor').textContent = valor_formatado;

}

function toggleButton1(button) {
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
    let valor = document.getElementById('valor_sem_formatacao').value.trim(); // "7752.00"
    let saldo = document.getElementById('saldo_formatado').value.trim(); // "10000.00"

    valor = parseFloat(valor);
    saldo = parseFloat(saldo);

    if (!isNaN(valor) && !isNaN(saldo)) {
        console.log(valor);
        console.log(saldo);

        if (valor <= saldo) {
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

    function gerarJogo() {
        var numerosDoJogo = gerarNumerosUnicos(1, 25, qt_dezenas, dezenas_excluidas);
        var resultado = numerosDoJogo.join('-');

        // Chama a função PHP e aguarda a resposta
        var resposta = chamar_FuncaoPHP(resultado);

        if (resposta === 'repetido') {
            console.log('Jogo repetido, gerando outro...');
            return gerarJogo(); // Chama recursivamente para gerar outro jogo
        }
        return resultado;
    }

    var jogos = [];
    for (var j = 0; j < qt_jogos; j++) {
        var novoJogo = gerarJogo();
        jogos.push(novoJogo);
    }

    console.log('Jogos gerados:', jogos);
}


function chamar_FuncaoPHP(numeros) {
    var concurso_anterior = document.getElementById('ultimo_concurso').value;
    concurso_anterior = parseFloat(concurso_anterior);
    var concurso_referente = concurso_anterior + 1;
    var qt_dez = document.getElementById('qt_dezenas').value;
    var qt_jogos = document.getElementById('qt_jogos').value;
    var saldo_formatado = document.getElementById('saldo_formatado').value;    
    var valor_jogo = document.getElementById('valor_sem_formatacao').value;
    var referente_jogo = 'lotofacil';
    var jogos = numeros;

    var valor_cada = valor_jogo / qt_jogos;

    //console.log(valor_cada);
    // Cria um objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    var resposta = false;
    // Especifica o método HTTP e a URL do arquivo PHP
    xhr.open('POST', 'consulta_jogo1.php', true);

    // Define a função de callback a ser chamada quando a resposta estiver pronta
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {  

            // A resposta do PHP está disponível em xhr.responseText
            //console.log(xhr.responseText);
            // Aqui você pode manipular a resposta, como atualizar a página ou exibir uma mensagem.

            resposta = xhr.responseText;

            if(resposta === 'repetido'){
             // gerar outro jogo no lugar
            }else{
                saldo_formatado = parseFloat(saldo_formatado); // Exemplo: 1000.00
                valor_cada = parseFloat(valor_cada); // Exemplo: 0.10                
            
                var novo_saldo = saldo_formatado - valor_cada;

                //console.log("Saldo Formatado:", saldo_formatado);
                //console.log("Valor do Jogo:", valor_jogo);  

                document.getElementById('saldo_formatado').value = novo_saldo.toFixed(2);
                document.getElementById('lista_jogos').value = concurso_referente;
                document.getElementById('alerta').textContent = 'Jogo gerado com sucesso.';
                               
                // Simular um clique no botão
                carregarJogos();
            }

        }
    };

    saldo_formatado = parseFloat(saldo_formatado); // Exemplo: 1000.00
    valor_cada = parseFloat(valor_cada); // Exemplo: 0.10                

    var novo_saldo = saldo_formatado - valor_cada;

    //console.log("Saldo Formatado:", saldo_formatado);
    //console.log("Valor do Jogo:", valor_jogo);  

    document.getElementById('saldo_formatado').value = novo_saldo.toFixed(2);

    // Configura os cabeçalhos da requisição
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Monta a string de dados a serem enviados
    var dados = 'saldo_formatado=' + encodeURIComponent(saldo_formatado) +
                '&concurso_anterior=' + encodeURIComponent(concurso_anterior) +
                '&concurso_referente=' + encodeURIComponent(concurso_referente) +
                '&qt_dez=' + encodeURIComponent(qt_dez) +
                '&valor_jogo=' + encodeURIComponent(valor_cada) +
                '&referente_jogo=' + encodeURIComponent(referente_jogo) +
                '&jogos=' + encodeURIComponent(jogos);

    // Envie a requisição com os dados
    xhr.send(dados);
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
