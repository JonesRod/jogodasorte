$(document).ready(function() {
    $('#valor_15').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});

$(document).ready(function() {
    $('#valor_16').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});

$(document).ready(function() {
    $('#valor_17').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});

$(document).ready(function() {
    $('#valor_18').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});

$(document).ready(function() {
    $('#valor_19').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});

$(document).ready(function() {
    $('#valor_20').inputmask('currency', {
      radixPoint: ',',
      prefix: 'R$ ',
      numericInput: true
    });
});

function calcularValores() {
  var valor_15 = document.getElementById("valor_15").value;
  // Remove o prefixo "R$ " e o separador de milhares (",")
  valor_15_sem_prefixo = valor_15.replace('R$ ', '').replace(',', '');

  // Converte para número
  var valor_15_em_centavos  = parseFloat(valor_15_sem_prefixo);
  
  // Verifica se o valor é um número válido
  if (!isNaN(valor_15_em_centavos)) {

    var resultado_em_centavos_16 = (valor_15_em_centavos * 16) / 2;
    var resultado_em_centavos_17 = (valor_15_em_centavos * 136) / 2;
    var resultado_em_centavos_18 = (valor_15_em_centavos * 818) / 2;
    var resultado_em_centavos_19 = (valor_15_em_centavos * 3876) / 2;
    var resultado_em_centavos_20 =(valor_15_em_centavos * 15504) / 2;

    // Converte o resultado de volta para reais
    var resultado_em_reais_16 = resultado_em_centavos_16 / 100;
    var resultado_em_reais_17 = resultado_em_centavos_17 / 100;
    var resultado_em_reais_18 = resultado_em_centavos_18 / 100;
    var resultado_em_reais_19 = resultado_em_centavos_19 / 100;
    var resultado_em_reais_20 = resultado_em_centavos_20 / 100;

    // Atualiza o campo de texto com o valor calculado
    document.getElementById("valor_16").value = "R$ " + resultado_em_reais_16.toFixed(2).replace('.', ',');
    document.getElementById("valor_17").value = "R$ " + resultado_em_reais_17.toFixed(2).replace('.', ',');
    document.getElementById("valor_18").value = "R$ " + resultado_em_reais_18.toFixed(2).replace('.', ',');
    document.getElementById("valor_19").value = "R$ " + resultado_em_reais_19.toFixed(2).replace('.', ',');
    document.getElementById("valor_20").value = "R$ " + resultado_em_reais_20.toFixed(2).replace('.', ',');

  } else {
    console.log("O valor em valor_15 não é um número válido.");
  }
}
