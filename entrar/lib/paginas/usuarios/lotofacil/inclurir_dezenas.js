
function toggleButton2(button) {
    button.classList.toggle('active');
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

    // Remover o primeiro traço, se existir no início
    if (inputDezenas.value.startsWith('-')) {
        inputDezenas.value = inputDezenas.value.substring(1);
    }

    // Remover o último traço, se existir no final
    if (inputDezenas.value.endsWith('-')) {
        inputDezenas.value = inputDezenas.value.slice(0, -1);
    }

    atualizarContador2();
}
function atualizarContador2() {
    let inputDezenas = document.getElementById('dezenas');
    let valorAtual = inputDezenas.value.trim();

    let contador = valorAtual.split('-').filter(Boolean).length;

    document.getElementById('contador2').textContent = contador + ' dezenas marcadas';
    document.getElementById('qt_contador').value = contador;

    calcular_consulta();
}

document.querySelectorAll('.numeros button').forEach(button => {
    button.addEventListener('click', () => {
        let numero = button.textContent;
        if (button.classList.contains('active')) {
            toggleButton2(button);
            let inputDezenas = document.getElementById('dezenas');
            inputDezenas.value = inputDezenas.value.replace(numero, '').replace('--', '-').trim();
            document.getElementById('alerta2').textContent = '';
            adicionarDezena(''); // Adicione esta linha para chamar DezenasExcluidas com uma string vazia
        } else {
            if (document.querySelectorAll('.numeros button.active').length < 20) {
                document.getElementById('alerta2').textContent = '';
                toggleButton2(button);
                adicionarDezena(button.textContent);
            }
        }
    });
});


function calcular_consulta() {

    var qt_dezenas = parseFloat(document.getElementById('qt_contador').value);
    var valor_15 = parseFloat(document.getElementById('valor_15').value.replace(',', '.'));
    var valor_16 = parseFloat(document.getElementById('valor_16').value.replace(',', '.'));
    var valor_17 = parseFloat(document.getElementById('valor_17').value.replace(',', '.'));
    var valor_18 = parseFloat(document.getElementById('valor_18').value.replace(',', '.'));
    var valor_19 = parseFloat(document.getElementById('valor_19').value.replace(',', '.'));
    var valor_20 = parseFloat(document.getElementById('valor_20').value.replace(',', '.'));

    var resultado;

    /*if (qt_dezenas < 15) {
        resultado = (0 * 1).toFixed(2);
    } else */if (qt_dezenas <= 15) {
        resultado = (valor_15).toFixed(2);
    } else if (qt_dezenas == 16) {
        resultado = (valor_16).toFixed(2);
    } else if (qt_dezenas == 17) {
        resultado = (valor_17).toFixed(2);
    } else if (qt_dezenas == 18) {
        resultado = (valor_18).toFixed(2);
    } else if (qt_dezenas == 19) {
        resultado = (valor_19).toFixed(2);
    } else if (qt_dezenas == 20) {
        resultado = (valor_20).toFixed(2);
    }

    document.getElementById('valor_sem_milhar').value = resultado;
    //console.log(resultado);

    let valor_formatado = new Intl.NumberFormat('pt-BR', { style:'currency', currency: 'BRL'}).format(resultado);
    document.getElementById('valor_consulta').textContent = valor_formatado;
    //console.log(valor_formatado);
}

function consultar_jogo() {
    let valor = document.getElementById('valor_sem_formatacao').value; // "0,10"
    let saldo = document.getElementById('saldo_formatado').value; // "1.000,00" ou "1.000"
    let qt_contador = document.getElementById('qt_contador').value;
    let numeros_escolhidos = document.getElementById('dezenas').value;

    // Converter para número usando o formato de moeda
    //let valor = parseFloat(valor_str.replace('R$ ', '').replace('.', '').replace(',', '.'));
    //let saldo = parseFloat(saldo_str.replace('R$ ', '').replace('.', '').replace(',', '.'));

    //console.log(valor);
    //console.log(saldo);

    if (!isNaN(valor) && !isNaN(saldo)) {
        if(qt_contador >= 15 && qt_contador <= 20){
            if (valor <= saldo) {
                document.getElementById('alerta2').value = 'Jogo gerado.';
                // gera jogo

                console.log(numeros_escolhidos);
                chamarFuncaoPHP();
                //limparSelecaoEBotoes();

            } else {
                let saldo_formatado = new Intl.NumberFormat('pt-BR', { style:'currency', currency: 'BRL'}).format(saldo);
                //console.log(saldo_formatado);

                let valor_formatado = new Intl.NumberFormat('pt-BR', { style:'currency', currency: 'BRL'}).format(valor);
                //console.log(valor_formatado);
                
                document.getElementById('alerta2').textContent = 'Seu saldo é de ' + saldo_formatado + ' e está abaixo do custo a ser gerado ' + valor_formatado + '.';
            }            
        }else{
            document.getElementById('alerta2').textContent = 'Você precisa selecionar entre 15 e 20 dezenas.';
        }

    } else {
        document.getElementById('alerta2').textContent = 'Valores inválidos';
    }
}

function chamarFuncaoPHP() {
    var concurso_anterior = document.getElementById('ultimo_concurso').value;
    concurso_anterior = parseFloat(concurso_anterior);
    var concurso_referente = concurso_anterior + 1;
    var qt_dez = document.getElementById('qt_contador').value;
    var saldo_formatado = document.getElementById('saldo_formatado').value;    
    var valor_jogo = document.getElementById('valor_sem_milhar').value;
    var referente_jogo = 'lotofacil';
    var jogos = document.getElementById('dezenas').value;

    // Cria um objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    var resposta = false;
    // Especifica o método HTTP e a URL do arquivo PHP
    xhr.open('POST', 'consulta_jogo.php', true);

    // Define a função de callback a ser chamada quando a resposta estiver pronta
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {  

            // A resposta do PHP está disponível em xhr.responseText
            console.log(xhr.responseText);
            // Aqui você pode manipular a resposta, como atualizar a página ou exibir uma mensagem.

            resposta = xhr.responseText;

            if(resposta === '1'){
                document.getElementById('alerta2').textContent = 'Esse jogo ja foi consultado e registrado para o concurso ' + concurso_referente + '.';
            }else{
                saldo_formatado = parseFloat(saldo_formatado.replace('.', '').replace(',', '.')); // Substitui a vírgula por ponto
                valor_jogo = parseFloat(valor_jogo.replace(',', '.')); // Substitui a vírgula por ponto
                
                var novo_saldo = saldo_formatado - valor_jogo; // novo_saldo = 958.70

                // Agora, atualize o valor na entrada do formulário
                document.getElementById('saldo_formatado').value = novo_saldo.toFixed(2); // toFixed(2) para exibir duas casas decimais
                document.getElementById('lista_jogos').value = concurso_referente;
                document.getElementById('alerta2').textContent = 'Consulta realizada com sucesso.';

                // Simular um clique no botão
                carregarJogos();
            }

        }
    };

    // Configura os cabeçalhos da requisição
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Monta a string de dados a serem enviados
    var dados = 'saldo_formatado=' + encodeURIComponent(saldo_formatado) +
                '&concurso_anterior=' + encodeURIComponent(concurso_anterior) +
                '&concurso_referente=' + encodeURIComponent(concurso_referente) +
                '&qt_dez=' + encodeURIComponent(qt_dez) +
                '&valor_jogo=' + encodeURIComponent(valor_jogo) +
                '&referente_jogo=' + encodeURIComponent(referente_jogo) +
                '&jogos=' + encodeURIComponent(jogos);

    // Envie a requisição com os dados
    xhr.send(dados);
}


function limparSelecaoEBotoes() {
    // Desselecione todos os botões (substitua 'btn' pelo seletor real dos seus botões)
    var botoes = document.querySelectorAll('.numeros button');
    botoes.forEach(function(botao) {
        botao.classList.remove('active'); // Remover a classe 'active'

    });
    config_padrao();

    //console.log('oi');
    // Limpe o valor do campo (substitua 'campo' pelo seletor real do seu campo)
    document.getElementById('valor_consulta').value = '';
    document.getElementById('dezenas').value = '';
    document.getElementById('alerta2').textContent = '';
}