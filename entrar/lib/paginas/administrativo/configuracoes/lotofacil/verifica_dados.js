function validarFormulario() {
    var dataInput = document.getElementById("data").value;

    if (!validarData(dataInput)) {
        alert("Por favor, insira uma data válida e no formato dd/mm/yyyy.");
        document.getElementById("data").focus(); // Dá foco ao campo
        return false;
    }
    //return true;

    var dataProximoConcurso = document.getElementById("dataProximoConcurso").value;

    if (!validarData(dataProximoConcurso)) {
        alert("Por favor, insira uma data válida e no formato dd/mm/yyyy.");
        document.getElementById("dataProximoConcurso").focus(); // Dá foco ao campo
        return false;
    }
    return true;   
}

function config_lotofacil() {
    window.location.href = 'config_lotofacil.php';
}

function validarDezena(input) {
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos

    if (value.length > 2) {
        value = value.substr(0, 2);    
    }
    // Verifica se o valor é maior que 25
    if (value > 25) {
        alert("O valor máximo permitido é 25.");
        value = ''; // Define o valor para 25
    }
    input.value = value;
}

function verifi_dez_iguais(input){
    let inputs = document.querySelectorAll('.dez input');
    let numeros = new Set();

    for (let i = 0; i < inputs.length; i++) {
        let num = parseInt(inputs[i].value, 10);
        if (!isNaN(num) && inputs[i].value !== "") { // Verifica se é um número e se o campo está preenchido
            numeros.add(num);
        }
    }

    if (numeros.size !== inputs.length) {
        alert("Os números não podem ser iguais.");
        input.value = "";
        return;
    }

    numeros = Array.from(numeros);
    numeros.sort(function(a, b) {
        return a - b;
    });

    for (let i = 0; i < inputs.length; i++) {
        if (!isNaN(numeros[i])) {
            inputs[i].value = numeros[i];
        }
    }    
}
function verifi_dez_iguais(input){
    let inputs = document.querySelectorAll('.dez input');
    let numeros = new Set();
    let numerosPreenchidos = [];

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value !== "") {
            let num = parseInt(inputs[i].value, 10);
            if (!isNaN(num)) {
                numeros.add(num);
                numerosPreenchidos.push(num);
            }
        }
    }

    if (numerosPreenchidos.length !== new Set(numerosPreenchidos).size) {
        alert("Os números não podem ser iguais.");
        input.value = "";
        return;
    }

    numeros = Array.from(numeros);
    numeros.sort(function(a, b) {
        return a - b;
    });

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value !== "") {
            inputs[i].value = numeros.shift();
        }
    }    
}



function validarData(input) {
    var regexData = /^\d{2}\/\d{2}\/\d{4}$/; // Formato esperado: dd/mm/yyyy
    if (!regexData.test(input)) {
        return false; // A data não está no formato esperado
    }
    
    var partesData = input.split("/");
    var dia = parseInt(partesData[0], 10);
    var mes = parseInt(partesData[1], 10) - 1; // Mês é base 0 no JavaScript (janeiro é 0)
    var ano = parseInt(partesData[2], 10);
    
    var dataObj = new Date(ano, mes, dia);
    
    if (
        dataObj.getFullYear() !== ano ||
        dataObj.getMonth() !== mes ||
        dataObj.getDate() !== dia
    ) {
        return false; // A data é inválida (ex: 31/02/2022)
    }
    
    return true; // A data é válida
}
//validardataProximoConcurso
function formatarData(input) {
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    if (value.length > 8) {
        value = value.substr(0, 8);
    }
    if (value.length > 4) {
        value = value.replace(/(\d{2})(\d{2})/, '$1/$2/');
    } else if (value.length > 2) {
        value = value.replace(/(\d{2})/, '$1/');
    } 
    input.value = value;
}

$(document).ready(function() {
    $('#rateio_15_acertos').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});
$(document).ready(function() {
    $('#rateio_14_acertos').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});
$(document).ready(function() {
    $('#rateio_13_acertos').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});
$(document).ready(function() {
    $('#rateio_12_acertos').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});
$(document).ready(function() {
    $('#rateio_11_acertos').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});
$(document).ready(function() {
    $('#acumulado_15_acertos').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});
$(document).ready(function() {
    $('#arrecadacao_total').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});
$(document).ready(function() {
    $('#valorAcumuladoConcursoEspecial').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});
$(document).ready(function() {
    $('#valorAcumuladoProximoConcurso').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});