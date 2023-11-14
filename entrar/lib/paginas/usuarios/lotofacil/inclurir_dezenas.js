
function toggleButton(button) {
    button.classList.toggle('active');
}

function removerDezena2(numero) {

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

    atualizarContador2();
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

    atualizarContador2();
}

function atualizarContador2() {
    let inputDezenas = document.getElementById('dezenas');
    let contador = inputDezenas.value.split('-').filter(Boolean).length;

    document.getElementById('contador2').textContent = contador + ' dezenas marcadas';
    document.getElementById('qt_contador').value = contador;

    calcular_consulta();
}
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
document.querySelectorAll('.numeros button').forEach(button => {
    button.addEventListener('click', () => {
        let numero = button.textContent;
        if (button.classList.contains('active')) {
            toggleButton(button);
            let inputDezenas = document.getElementById('dezenas');
            inputDezenas.value = inputDezenas.value.replace(numero, '').replace('--', '-').trim();
            document.getElementById('alerta2').textContent = '';
            atualizarContador2();
        } else {
            if (document.querySelectorAll('.numeros button.active').length < 20) {
                document.getElementById('alerta2').textContent = '';
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

function consultar_jogo() {
    let valor_str = document.getElementById('valor_sem_formatacao').value; // "0,10"
    let saldo_str = document.getElementById('saldo_formatado').value; // "1.000,00" ou "1.000"
    let qt_contador = document.getElementById('qt_contador').value;
    let numeros_escolhidos = document.getElementById('dezenas').value;

    // Converter para número usando o formato de moeda
    let valor = parseFloat(valor_str.replace('R$ ', '').replace('.', '').replace(',', '.'));
    let saldo = parseFloat(saldo_str.replace('R$ ', '').replace('.', '').replace(',', '.'));

    //console.log(valor);
    //console.log(saldo);

    if (!isNaN(valor) && !isNaN(saldo)) {
        if(qt_contador >= 1 && qt_contador <= 20){
            if (valor <= saldo) {
                document.getElementById('alerta2').value = 'Jogo gerado.';
                // gera jogo

                console.log(numeros_escolhidos);
                chamarFuncaoPHP(numeros_escolhidos);
                //limparSelecaoEBotoes();

            } else {

                let saldo_formatado = new Intl.NumberFormat('pt-BR', { style:'currency', currency: 'BRL'}).format(saldo);
                //console.log(saldo_formatado);

                let valor_formatado = new Intl.NumberFormat('pt-BR', { style:'currency', currency: 'BRL'}).format(valor);
                //console.log(valor_formatado);
                
                document.getElementById('alerta2').textContent = 'Seu saldo é de R$ ' + saldo_formatado + ' e está abaixo do custo a ser gerado R$ ' + valor_formatado + '.';

            }            
        }else{
            document.getElementById('alerta2').textContent = 'Você precisa selecionar entre 15 e 20 dezenas.';
        }

    } else {
        document.getElementById('alerta2').textContent = 'Valores inválidos';
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