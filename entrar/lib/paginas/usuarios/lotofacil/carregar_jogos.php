<?php
include('../../../conexao.php');

$concursoEscolhido = $_GET['concurso'];

// Consulta SQL para obter os jogos do concurso escolhido ordenados pelo ID
$jogos = "SELECT * FROM jogos WHERE concurso_referente = $concursoEscolhido ORDER BY id ASC";
$result = $conn->query($jogos);

// Verifica se a consulta foi bem-sucedida
if ($result === false) {
    die("Erro na consulta: " . $conn->error);
}

// Exibe a tabela HTML
echo "<table border='1'>
        <tr>
            <th>Ordem</th>
            <th>Qt dez.</th>
            <th>Jogos</th>
            <th>11 Acertos</th>
            <th>12 Acertos</th>
            <th>13 Acertos</th>
            <th>14 Acertos</th>
            <th>15 Acertos</th>
        </tr>";

$ordem = 1; // Inicializa o número de ordem

// Verifica se há resultados antes de iterar
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $numerosJogo = explode('-', $row['jogos']);
        $numerosJogo = array_map('intval', $numerosJogo);

        // Consulta SQL para obter os números sorteados do concurso
        $sqlSorteados = "SELECT numeros FROM resultados_lotofacil";
        $resultSorteados = $conn->query($sqlSorteados);

        // Verifica se a consulta foi bem-sucedida
        if ($resultSorteados === false) {
            die("Erro na consulta: " . $conn->error);
        }

        $acertos11 = $acertos12 = $acertos13 = $acertos14 = $acertos15 = 0;

        while ($rowSorteados = $resultSorteados->fetch_assoc()) {
            $numerosSorteados = explode('-', $rowSorteados['numeros']);
            $numerosSorteados = array_map('intval', $numerosSorteados);

            $acertos = count(array_intersect($numerosSorteados, $numerosJogo));

            switch ($acertos) {
                case 11:
                    $acertos11++;
                    break;
                case 12:
                    $acertos12++;
                    break;
                case 13:
                    $acertos13++;
                    break;
                case 14:
                    $acertos14++;
                    break;
                case 15:
                    $acertos15++;
                    break;
                default:
                    break;
            }
        }

        echo "<tr>
                <td style='text-align: center;'>" . $ordem . "</td>
                <td style='text-align: center;'>" . $row['qt_dez'] . "</td>
                <td>" . $row['jogos'] . "</td>
                <td style='text-align: center;'>" . $acertos11 . "</td>
                <td style='text-align: center;'>" . $acertos12 . "</td>
                <td style='text-align: center;'>" . $acertos13 . "</td>
                <td style='text-align: center;'>" . $acertos14 . "</td>
                <td style='text-align: center;'>" . $acertos15 . "</td>
            </tr>";

        $ordem++; // Incrementa o número de ordem
    }
} else {
    echo "<tr><td colspan='8'>Nenhum jogo encontrado para o concurso escolhido.</td></tr>";
}

echo "</table>";

$conn->close();
?>
