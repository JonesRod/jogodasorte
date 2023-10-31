function validateForm() {
    var uf =document.getElementById('uf').value;
    var alerta = document.querySelector('#msg');
    var sem_escolha ="Escolha";
    
    if(uf === sem_escolha){
        alerta.textContent = "Selecione o Estado!";
        document.getElementById('uf').focus();
        return false; // Impede o envio do formulário
    }
    // Se todas as verificações passaram
    alerta.textContent = "";
    return true;
}       

function formatcnpj(input) {
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos

    if (value.length <= 11) { // Se o comprimento for menor ou igual a 11, assume que é CPF
        if (value.length > 9) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})/, '$1.$2.$3-');
        } else if (value.length > 6) {
            value = value.replace(/(\d{3})(\d{3})/, '$1.$2.');
        } else if (value.length > 3) {
            value = value.replace(/(\d{3})/, '$1.');
        }
    } else { // Caso contrário, assume que é CNPJ
        value = value.substr(0, 14);
        if (value.length > 12) {
            value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{1})/, '$1.$2.$3/$4-$5');
        } else if (value.length > 11){
            value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})/, '$1.$2.$3/$4');
        }
    }

    input.value = value;
}
function verificacnpj(){
    var cnpj =document.getElementById('cnpj').value;

    if(cnpj.length < 14){
        //console.log(cpf);
        document.querySelector('#msg').textContent = "CNPJ ou CPF invalido! Preencha o campo corretamente.";
        document.getElementById('cnpj').focus();
    }else if(cnpj.length > 14 && cnpj.length < 18){
        document.querySelector('#msg').textContent = "CNPJ ou CPF invalido! Preencha o campo corretamente.";
        document.getElementById('cnpj').focus();
    }else{
        document.querySelector('#msg').textContent = "";
    }  
}

function formatarCEP(input) {
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    if (value.length > 8) {
        value = value.substr(0, 8);
    }
     if (value.length > 5) {
        value = value.replace(/(\d{5})/, '$1-');
    }
    input.value = value;
}
async function fetchCityByCEP() {
    const cep = document.getElementById('cep').value.replace(/\D/g, ''); // Remove caracteres não numéricos

    if (cep.length !== 8) {
        //alert('CEP inválido.');
        document.querySelector('#msg').textContent = "CEP invalido! Preencha o campo corretamente.";
        document.querySelector('#cidade').value = "";
        document.getElementById('cep').focus();
        return;
    }

    const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
    const data = await response.json();
    document.querySelector('#msg').textContent = "";

    if (data.erro) {
        //alert('CEP não encontrado.');
        document.querySelector('#msg').textContent = "CEP está incorretamente.";
        document.querySelector('#cidade').value = "";
        //document.getElementById('icep').focus();
        return;
    }
    document.querySelector('#msg').textContent = "";
    document.getElementById('cidade').value = data.localidade;
}
function formatarCelular(input) {
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    if (value.length > 11) {
        value = value.substr(0, 11);
    }
    if (value.length > 10) {
        value = value.replace(/(\d{1})(\d{1})(\d{5})/, '($1$2) $3-');
    } else if (value.length > 6) {
        value = value.replace(/(\d{1})(\d{1})(\d{4})/, '($1$2) $3-');
    } else if (value.length > 2) {
        value = value.replace(/(\d{1})(\d{1})/, '($1$2) ');
    }else if (value.length > 2) {
        value = value.replace(/(\d{1})(\d{1})/, '($1$2) ');
    }else if (value.length > 1) {
        value = value.replace(/(\d{1})/, '($1');
    }
    input.value = value;
}
function verificaCelular(){
    var celular =document.getElementById('celular').value;
    //console.log(celular.length);
    if(celular.length < 11 ){
        
        document.querySelector('#msg').textContent = "Preencha o campo Celular corretamente!";
        document.getElementById('celular').focus();
    }else{
        document.querySelector('#msg').textContent = "";
    }
}
$(document).ready(function() {
    $('#creditos').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});