<?php
    // Verifica se os dados foram recebidos corretamente
    if (isset($_POST['saldo_formatado'], $_POST['concurso_anterior'], $_POST['concurso_referente'], 
    $_POST['qt_dez'], $_POST['valor_jogo'], $_POST['referente_jogo'], $_POST['jogos'])) {
        // Recupera os dados
        $saldo_formatado = $_POST['saldo_formatado'];
        $concurso_anterior = $_POST['concurso_anterior'];
        $concurso_referente = $_POST['concurso_referente'];
        $qt_dez = $_POST['qt_dez'];
        $valor_jogo = $_POST['valor_jogo'];
        $referente_jogo = $_POST['referente_jogo'];
        $jogo = $_POST['jogos'];

        // Faça o que precisar com esses dados, como inserir no banco de dados, processar, etc.
    } else {
        // Se os dados não foram recebidos corretamente, emita um aviso
        echo "Erro: Dados não recebidos corretamente.";
    }

    include('../../../conexao.php');

    if(!isset($_SESSION)){
        session_start(); 
    }

    if(isset($_SESSION['usuario'])){
        $id = $_SESSION['usuario'];
        // Converte a string em um array de números
        $numeros = explode('-', $jogo);
        $numeros = array_map('intval', $numeros);

        // Consulta SQL para obter os números já registrados nos jogos
        $sql_jogos = "SELECT concurso_referente, referente_jogo, jogos FROM jogos WHERE id_usuario = $id ";
        $result_jogos = $conn->query($sql_jogos);

        // Arrays para armazenar a contagem de números repetidos com diferentes quantidades de dezenas
        $repeticoes_por_quantidade = array_fill(11, 5, 0);

        // Arrays para armazenar os números dos concursos repetidos com diferentes quantidades de dezenas
        $concurso_repetido_por_quantidade = array_fill(11, 5, array());

        // Verifica se a consulta foi bem-sucedida
        if ($result_jogos) {

            // Verifica se não há resultados (banco de dados vazio)
            if ($result_jogos->num_rows > 0) {
                // Extrai os números dos jogos registrados
                while ($row = $result_jogos->fetch_assoc()) { 
                    $id_usuario = $row['jogos'];
                    $numeros_jogos = explode('-', $row['jogos']);
                    $numeros_jogos = array_map('intval', $numeros_jogos);

                    if (isset($row['referente_jogo'])) {
                        $referente_jogo_bd = $row['referente_jogo'];
                    }

                    // Verifica a quantidade de números repetidos
                    $numeros_repetidos = array_intersect($numeros, $numeros_jogos);
                    $quantidade_repetidos = count($numeros_repetidos);

                    $qt_dez = intval($qt_dez);
                    $id = intval($id);
                    $id_usuario = intval($id_usuario);

                    // Atualiza o array de contagem de acordo com a quantidade de repetições
                    if ($quantidade_repetidos >= 15 && $qt_dez <= 17 && $referente_jogo_bd === $referente_jogo) {
                        echo '1';
                        exit;
                    }else if($quantidade_repetidos >= 16 && $qt_dez <= 18 && $referente_jogo_bd === $referente_jogo) {
                        echo '1';
                        exit;
                    }else if($quantidade_repetidos >= 17 && $qt_dez <= 19 && $referente_jogo_bd === $referente_jogo) {
                        echo '1';
                        exit;
                    }else if($quantidade_repetidos >= 18 && $qt_dez <= 20 && $referente_jogo_bd === $referente_jogo) {
                        echo '1';
                        exit;
                    }
                }                        
                //exit;
                // Consulta SQL para obter os números já registrados nos jogos
                $sql_resultados = "SELECT concurso, numeros FROM resultados_lotofacil";
                $result_resultados = $conn->query($sql_resultados);

                // Arrays para armazenar a contagem de números repetidos com diferentes quantidades de dezenas
                $repeticoes_por_quantidade = array_fill(11, 5, 0);

                // Arrays para armazenar os números dos concursos repetidos com diferentes quantidades de dezenas
                $concurso_repetido_por_quantidade = array_fill(11, 5, array());

                // Verifica se a consulta foi bem-sucedida
                if ($result_resultados) {
                    // Extrai os números dos jogos registrados
                    while ($row = $result_resultados->fetch_assoc()) {
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

                    $sql_jogos = "INSERT INTO jogos (data, id_usuario, concurso_anterior, concurso_referente, qt_dez, valor, referente_jogo, jogos) 
                    VALUES(NOW(), '$id', '$concurso_anterior', '$concurso_referente', '$qt_dez','$valor_jogo', '$referente_jogo', '$jogo')";
                    $deu_certo = $conn->query($sql_jogos) or die($conn->error);		

                    if($deu_certo){

                        // Remova os pontos e substitua vírgulas por pontos para garantir que o formato seja interpretado corretamente
                        //$saldo_formatado = str_replace(".", "", $saldo_formatado);
                        //$saldo_formatado = str_replace(",", ".", $saldo_formatado);
                        
                        //$valor_jogo = str_replace(".", "", $valor_jogo);
                        //$valor_jogo = str_replace(",", ".", $valor_jogo);

                        $numero1 = floatval($saldo_formatado);
                        $numero2 = floatval($valor_jogo);
                        
                        $creditos_restante = $numero1 - $numero2;
                        
                        // Formate o resultado de volta para a exibição
                        //$creditos_restante_formatado = number_format($creditos_restante, 2, ".");

                        $sql_creditos = "INSERT INTO controle_creditos(data, id_usuario, credito_atual, menos_creditos, referente_jogo, qt_dez, creditos_restante) 
                        VALUES(NOW(), '$id', '$saldo_formatado', '$valor_jogo', '$referente_jogo', '$qt_dez', '$creditos_restante')";
                        $conn->query($sql_creditos) or die($conn->error);

                        $sql_usuario = "UPDATE usuarios
                        SET 
                        creditos = '$creditos_restante_formatado'
                        WHERE id = '$id'";

                        $conn->query($sql_usuario) or die($conn->error);
                        
                    } else {
                        // Se houver um erro na consulta
                        die($conn->error); 
                    }
                } else {
                    // Tratamento de erro ao executar a consulta SQL
                    echo "Erro ao executar a consulta SQL: " . $conn->error;
                }  
            }else{
                // Consulta SQL para obter os números já registrados nos jogos
                $sql_resultados = "SELECT concurso, numeros FROM resultados_lotofacil";
                $result_resultados = $conn->query($sql_resultados);

                // Arrays para armazenar a contagem de números repetidos com diferentes quantidades de dezenas
                $repeticoes_por_quantidade = array_fill(11, 5, 0);

                // Arrays para armazenar os números dos concursos repetidos com diferentes quantidades de dezenas
                $concurso_repetido_por_quantidade = array_fill(11, 5, array());

                // Verifica se a consulta foi bem-sucedida
                if ($result_resultados) {
                    // Verifica se não há resultados (banco de dados vazio)
                    if ($result_resultados->num_rows > 0) {
                        // Extrai os números dos jogos registrados
                        while ($row = $result_resultados->fetch_assoc()) {
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

                        $sql_jogos = "INSERT INTO jogos (data, id_usuario, concurso_anterior, concurso_referente, qt_dez, valor, referente_jogo, jogos) 
                        VALUES(NOW(), '$id', '$concurso_anterior', '$concurso_referente', '$qt_dez','$valor_jogo', '$referente_jogo', '$jogo')";
                        $deu_certo = $conn->query($sql_jogos) or die($conn->error);		

                        if($deu_certo){
                            // Remova os pontos e substitua vírgulas por pontos para garantir que o formato seja interpretado corretamente
                            //$saldo_formatado = str_replace(".", "", $saldo_formatado);
                            //$saldo_formatado = str_replace(",", ".", $saldo_formatado);
                            
                            //$valor_jogo = str_replace(".", "", $valor_jogo);
                            //$valor_jogo = str_replace(",", ".", $valor_jogo);

                            $numero1 = floatval($saldo_formatado);
                            $numero2 = floatval($valor_jogo);
                            
                            $creditos_restante = $numero1 - $numero2;
                            
                            // Formate o resultado de volta para a exibição
                            $creditos_restante_formatado = number_format($creditos_restante, 2, ".");

                            $sql_creditos = "INSERT INTO controle_creditos(data, id_usuario, credito_atual, menos_creditos, referente_jogo, qt_dez, creditos_restante) 
                            VALUES(NOW(), '$id', '$saldo_formatado', '$valor_jogo', '$referente_jogo', '$qt_dez', '$creditos_restante')";
                            $conn->query($sql_creditos) or die($conn->error);

                            $sql_usuario = "UPDATE usuarios
                            SET 
                            creditos = '$creditos_restante_formatado'
                            WHERE id = '$id'";

                            $conn->query($sql_usuario) or die($conn->error);

                        } else {
                            // Se houver um erro na consulta
                            die($conn->error); 
                        }
                    }else{
                        // Tratamento de erro ao executar a consulta SQL
                        echo "Erro ao executar a consulta SQL ou lista vazia: " . $conn->error;
                    }
                } else {
                    // Tratamento de erro ao executar a consulta SQL
                    echo "Erro ao executar a consulta SQL: " . $conn->error;
                }
            }
        } else {
            // Tratamento de erro ao executar a consulta SQL
            echo "Erro ao executar a consulta SQL: " . $conn->error;
        }


    }
?>
