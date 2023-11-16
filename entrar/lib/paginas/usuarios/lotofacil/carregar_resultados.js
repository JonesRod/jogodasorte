function carregarResultados() {
    // Obter o valor do campo de entrada
    var concursoEscolhido = document.getElementById('lista_resultados').value;
    if(concursoEscolhido !=''){
        // Aqui você faria uma requisição AJAX para obter os dados do PHP
        // Exemplo de requisição AJAX usando Fetch API
        fetch('carregar_resultados.php?concurso=' + concursoEscolhido)
            .then(response => response.text())
            .then(data => {
                // Inserir a tabela gerada no elemento com id 'tabelaJogos'
                document.getElementById('tabelaResultados').innerHTML = data;
            })
            .catch(error => console.error('Erro:', error));        
    }

}
