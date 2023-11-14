<?php
    // Recebe o valor enviado pelo JavaScript
    $valor = $_POST['valor'];

    include('../../../conexao.php');

    if(!isset($_SESSION)){
        session_start(); 
    }

    if(isset($_SESSION['usuario'])){

        // Converte a string em um array de números
        $numeros = explode('-', $valor);
        $numeros = array_map('intval', $numeros);

        // Consulta SQL para obter os números já registrados nos jogos
        $sql_jogos = "SELECT concurso, numeros FROM resultados_lotofacil";
        $result_jogos = $conn->query($sql_jogos);

        // Arrays para armazenar a contagem de números repetidos com diferentes quantidades de dezenas
        $repeticoes_por_quantidade = array_fill(11, 5, 0);

        // Arrays para armazenar os números dos concursos repetidos com diferentes quantidades de dezenas
        $concurso_repetido_por_quantidade = array_fill(11, 5, array());

        // Verifica se a consulta foi bem-sucedida
        if ($result_jogos) {
            // Extrai os números dos jogos registrados
            while ($row = $result_jogos->fetch_assoc()) {
                $numeros_jogos = explode('-', $row['numeros']);
                $numeros_jogos = array_map('intval', $numeros_jogos);

                // Verifica a quantidade de números repetidos
                $numeros_repetidos = array_intersect($numeros, $numeros_jogos);
                $quantidade_repetidos = count($numeros_repetidos);

                // Atualiza o array de contagem de acordo com a quantidade de repetições
                if ($quantidade_repetidos >= 11 && $quantidade_repetidos <= 15) {
                    $repeticoes_por_quantidade[$quantidade_repetidos]++;
                    $concurso_repetido_por_quantidade[$quantidade_repetidos][] = $row['concurso'];
                }
            }

            // Exibe a contagem de números repetidos para diferentes quantidades de dezenas
            for ($i = 11; $i <= 15; $i++) {
                echo "Concursos com $i dezenas repetidas: " . $repeticoes_por_quantidade[$i] . "<br>";
                echo "Números dos concursos: " . implode(', ', $concurso_repetido_por_quantidade[$i]) . "<br>";
            }
        } else {
            // Tratamento de erro ao executar a consulta SQL
            echo "Erro ao executar a consulta SQL: " . $conn->error;
        }
    }
?>
