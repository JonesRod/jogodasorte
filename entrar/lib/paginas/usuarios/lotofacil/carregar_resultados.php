<?php
include('../../../conexao.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['usuario'])) {
    $id = $_SESSION['usuario'];
    $concursoEscolhido = $_GET['concurso'];
    $referente_jogo = 'lotofacil';
    
    // Consulta SQL para obter os jogos do concurso escolhido ordenados pelo ID
    $jogos = "SELECT * FROM jogos WHERE id_usuario = $id && referente_jogo = '$referente_jogo' && concurso_referente = $concursoEscolhido ORDER BY id ASC";
    $resultJogos = $conn->query($jogos);
    
    // Verifica se a consulta foi bem-sucedida
    if ($resultJogos === false) {
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
    if ($resultJogos->num_rows > 0) {
        while ($rowJogos = $resultJogos->fetch_assoc()) {
            $numerosJogo = explode('-', $rowJogos['jogos']);
            $numerosJogo = array_map('intval', $numerosJogo);

            // Consulta SQL para obter os números sorteados do concurso
            $sqlSorteado = "SELECT * FROM resultados_lotofacil WHERE concurso = $concursoEscolhido";
            $resultSorteado = $conn->query($sqlSorteado);

            // Verifica se a consulta foi bem-sucedida
            if ($resultSorteado === false) {
                die("Erro na consulta: " . $conn->error);
            }

            $acertos11 = $acertos12 = $acertos13 = $acertos14 = $acertos15 = 0;

            if ($resultSorteado->num_rows > 0) {
                while ($rowSorteado = $resultSorteado->fetch_assoc()) {
                    $numerosSorteados = explode('-', $rowSorteado['numeros']);
                    $numerosSorteados = array_map('intval', $numerosSorteados);

                    // Comparar com os números sorteados
                    $acertos = count(array_intersect($numerosJogo, $numerosSorteados));

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

                // Adiciona a condição para exibir somente os jogos com pelo menos 11 acertos
                if ($acertos11 > 0 || $acertos12 > 0 || $acertos13 > 0 || $acertos14 > 0 || $acertos15 > 0) {
                    echo "<tr>
                            <td style='text-align: center;'>" . $ordem . "</td>
                            <td style='text-align: center;'>" . $rowJogos['qt_dez'] . "</td>
                            <td style='text-align: left;'>" . $rowJogos['jogos'] . "</td>
                            <td style='text-align: center;'>" . $acertos11 . "</td>
                            <td style='text-align: center;'>" . $acertos12 . "</td>
                            <td style='text-align: center;'>" . $acertos13 . "</td>
                            <td style='text-align: center;'>" . $acertos14 . "</td>
                            <td style='text-align: center;'>" . $acertos15 . "</td>
                        </tr>";

                    $ordem++; // Incrementa o número de ordem
                }
            } else {
                echo "<tr><td colspan='8'>Ainda não teve o sorteio para este concurso.</td></tr>";
                exit;
            }
        }
    } else {
        echo "<tr><td colspan='8'>Nenhum jogo encontrado para o concurso escolhido.</td></tr>";
    }

    echo "</table>";
    echo "<h3>Tabela de acertos de todos</h3>";

    // Consulta SQL para obter os jogos do concurso escolhido ordenados pelo ID
    $jogos = "SELECT * FROM jogos WHERE id_usuario = $id && referente_jogo = '$referente_jogo' && concurso_referente <> $concursoEscolhido ORDER BY id DESC";
    $result = $conn->query($jogos);

    // Verifica se a consulta foi bem-sucedida
    if ($result === false) {
        die("Erro na consulta: " . $conn->error);
    }

    // Exibe a tabela HTML
    echo "<table border='1'>
            <tr>
                <th>Usuarios</th>
                <th>Ref. concurso</th>
                <th>Qt dez.</th>
                <th>11 Acertos</th>
                <th>12 Acertos</th>
                <th>13 Acertos</th>
                <th>14 Acertos</th>
                <th>15 Acertos</th>
            </tr>";

    //$ordem = 1; // Inicializa o número de ordem

    // Verifica se há resultados antes de iterar
    if ($result->num_rows > 0) {
        while ($rowJogos = $result->fetch_assoc()) {
            $numerosJogo = explode('-', $rowJogos['jogos']);
            $numerosJogo = array_map('intval', $numerosJogo);

            // Consulta SQL para obter os números sorteados do concurso
            $sqlSorteado = "SELECT * FROM resultados_lotofacil WHERE concurso = $concursoEscolhido";
            $resultSorteado = $conn->query($sqlSorteado);

            // Verifica se a consulta foi bem-sucedida
            if ($resultSorteado === false) {
                die("Erro na consulta: " . $conn->error);
            }

            $acertos11 = $acertos12 = $acertos13 = $acertos14 = $acertos15 = 0;

            while ($rowSorteado = $resultSorteado->fetch_assoc()) {
                $numerosSorteados = explode('-', $rowSorteado['numeros']);
                $numerosSorteados = array_map('intval', $numerosSorteados);

                // Comparar com os números sorteados
                $acertos = count(array_intersect($numerosJogo, $numerosSorteados));

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

            // Adiciona a condição para exibir somente os jogos com pelo menos 11 acertos
            if ($acertos11 > 0 || $acertos12 > 0 || $acertos13 > 0 || $acertos14 > 0 || $acertos15 > 0) {

                echo "<tr>
                        <td style='text-align: center;'>Usuario</td>
                        <td style='text-align: center;'>".$rowJogos['concurso_referente']."</td>
                        <td style='text-align: center;'>" . $rowJogos['qt_dez'] . "</td>
                        <td style='text-align: center;'>" . $acertos11 . "</td>
                        <td style='text-align: center;'>" . $acertos12 . "</td>
                        <td style='text-align: center;'>" . $acertos13 . "</td>
                        <td style='text-align: center;'>" . $acertos14 . "</td>
                        <td style='text-align: center;'>" . $acertos15 . "</td>
                    </tr>";

                //$ordem++; // Incrementa o número de ordem
            }
        } 
    } else {
        echo "<tr><td colspan='8'>Nenhum jogo encontrado para o concurso escolhido.</td></tr>";
    }
    echo "</table>";
    $conn->close();
}
?>
