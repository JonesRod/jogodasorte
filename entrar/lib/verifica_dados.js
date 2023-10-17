function validarFormulario() {
    var dataInput = document.getElementById("nascimento").value;

    if (!validarData(dataInput)) {
        alert("Por favor, insira uma data válida e no formato dd/mm/yyyy.");
        return false;
    }
    return true;
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