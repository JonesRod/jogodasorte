function formatarMoeda(valor) {
  // Remove tudo que não é dígito
  valor = valor.replace(/\D/g, '');

  // Adiciona os zeros à esquerda, se necessário
  while (valor.length < 3) {
      valor = '0' + valor;
  }

  // Separa os centavos dos milhares
  var centavos = valor.substring(valor.length - 2);
  var milhares = valor.substring(0, valor.length - 2);

  // Remove zeros à esquerda dos milhares
  milhares = milhares.replace(/^0+/, '');

  // Adiciona o ponto para milhares, se necessário
  if (milhares.length > 3) {
      milhares = milhares.replace(/(\d)(?=(\d{3})+$)/g, '$1.');
  }

  // Formata como moeda brasileira
  return (milhares || '0') + ',' + centavos;
}

// Função para formatar o valor enquanto o usuário digita
function formatarCampoMoeda(campo) {
  // Remove qualquer formatação existente
  var valorAtual = campo.value.replace(/[^\d]/g, '');

  // Formata apenas se houver algum valor digitado
  if (valorAtual) {
      campo.value = formatarMoeda(valorAtual);
  }
}

function formatar_Moeda(valor) {
  // Converte para número e formata como moeda brasileira
  return parseFloat(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function calcularValores() {
  var valor_15 = document.getElementById("valor_15").value;
  
  // Remove caracteres não numéricos, troca vírgula por ponto e converte para número
  var valor_15_em_centavos = parseFloat(valor_15.replace(/[^\d,]/g, '').replace(',', '.'));

  // Verifica se o valor é um número válido
  if (!isNaN(valor_15_em_centavos)) {
      var resultado_em_centavos_16 = (valor_15_em_centavos * 16) / 2;
      var resultado_em_centavos_17 = (valor_15_em_centavos * 136) / 2;
      var resultado_em_centavos_18 = (valor_15_em_centavos * 818) / 2;
      var resultado_em_centavos_19 = (valor_15_em_centavos * 3876) / 2;
      var resultado_em_centavos_20 = (valor_15_em_centavos * 15504) / 2;

      // Atualiza o campo de texto com o valor calculado
      document.getElementById("valor_16").value = formatar_Moeda(resultado_em_centavos_16);
      document.getElementById("valor_17").value = formatar_Moeda(resultado_em_centavos_17);
      document.getElementById("valor_18").value = formatar_Moeda(resultado_em_centavos_18);
      document.getElementById("valor_19").value = formatar_Moeda(resultado_em_centavos_19);
      document.getElementById("valor_20").value = formatar_Moeda(resultado_em_centavos_20);
  } else {
      console.log("O valor em valor_15 não é um número válido.");
  }
}
