function validateForm() {
    var uf =document.getElementById('uf').value;
    var alerta = document.querySelector('#msg');
    var dataInput = document.getElementById("nascimento").value;
    var sem_escolha ="Escolha";
    
    if(uf === sem_escolha){
        alerta.textContent = "Selecione o Estado!";
        document.getElementById('uf').focus();
        return false; // Impede o envio do formulário
    }
    if (!validarData(dataInput)) {
        alert("Por favor, insira uma data válida e no formato dd/mm/yyyy.");
        document.getElementById('nascimento').focus();
        return false;
    }
    // Se todas as verificações passaram
    alerta.textContent = "";
    return true;
}

document.getElementById("form").addEventListener("submit", function(event) {
    var dataInput = document.getElementById("nascimento").value; // Substitua 'inputData' pelo ID do seu campo de data
    
    if (!validarData(dataInput)) {
        alert("Por favor, insira uma data válida no formato dd/mm/yyyy.");
        document.getElementById('nascimento').focus();
        event.preventDefault(); // Impede o envio do formulário
    }
});         

function formatCPF(input) {
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    if (value.length > 11) {
        value = value.substr(0, 11);
    }
    if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})/, '$1.$2.$3-');
    } else if (value.length > 6) {
        value = value.replace(/(\d{3})(\d{3})/, '$1.$2.');
    } else if (value.length > 3) {
        value = value.replace(/(\d{3})/, '$1.');
    }
    input.value = value;
}
function verificaCpf(){
    var cpf =document.getElementById('cpf').value;
    var primeiro_nome = document.getElementById('primeiro_nome').value;

    if(primeiro_nome === ''){
        document.getElementById('primeiro_nome').value= document.getElementById('nome_completo').value;
    }if(cpf.length < 14){
        //console.log(cpf);
        document.querySelector('#msg').textContent = "CPF invalido! Preencha o campo corretamente.";
        document.getElementById('cpf').focus();
    }else{
        document.querySelector('#msg').textContent = "";
    }  
}

function validarData(data) {
    var regexData = /^\d{2}\/\d{2}\/\d{4}$/; // Formato esperado: dd/mm/yyyy
    if (!regexData.test(data)) {
        return false; // A data não está no formato esperado
    }
    
    var partesData = data.split("/");
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

function verificarAceite() {
    var checkbox = document.getElementById('aceito');
    var botaoEnviar = document.getElementById('solicitar');
    
    if (checkbox.checked) {
        botaoEnviar.disabled = false;
    } else {
        botaoEnviar.disabled = true;
    }
}