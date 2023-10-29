<?php
    include('../../../../../conexao.php');
    session_start(); // Iniciar a sessão

    // Limpar o buffer de saída
    ob_start();

    // Incluir a conexão com banco de dados
    //include_once "conexao.php";

    // Receber o arquivo do formulário
    $arquivo = $_FILES['arquivo'];
    //var_dump($arquivo);

    // Variáveis de validação
    $primeira_linha = true;
    $linhas_importadas = 0;
    $linhas_nao_importadas = 0;
    $usuarios_nao_importado = "";

    // Verificar se é arquivo csv
    if($arquivo['type'] == "text/csv"){

        // Ler os dados do arquivo
        $dados_arquivo = fopen($arquivo['tmp_name'], "r");

        // Percorrer os dados do arquivo
        while($linha = fgetcsv($dados_arquivo, 1000, ";")){

            // Como ignorar a primeira linha do Excel
            if($primeira_linha){
                $primeira_linha = false;
                continue;
            }

            // Atribui os valores a variáveis
            $concurso_resultado = $linha[0];
            $dataConcurso = $linha[1];
            $numeros_array[0] = $linha[2];
            $numeros_array[1] = $linha[3];
            $numeros_array[2] = $linha[4];
            $numeros_array[3] = $linha[5];
            $numeros_array[4] = $linha[6];
            $numeros_array[5] = $linha[7];
            $numeros_array[6] = $linha[8];
            $numeros_array[7] = $linha[9];
            $numeros_array[8] = $linha[10];
            $numeros_array[9] = $linha[11];
            $numeros_array[10] = $linha[12];
            $numeros_array[11] = $linha[13];
            $numeros_array[12] = $linha[14]; 
            $numeros_array[13] = $linha[15];
            $numeros_array[14] = $linha[16];
            $numeros_formatados = $numeros_array[0] . '-' . $numeros_array[1] . '-' . $numeros_array[2] . '-' . $numeros_array[3] . '-' . $numeros_array[4]
            . '-' . $numeros_array[5] . '-' . $numeros_array[6] . '-' . $numeros_array[7] . '-' . $numeros_array[8] . '-' . $numeros_array[9]
             . '-' . $numeros_array[10] . '-' . $numeros_array[11] . '-' . $numeros_array[12] . '-' . $numeros_array[13] . '-' . $numeros_array[14];
            $numeroDeGanhadores_1 = $linha[17];
            $cidades_string = $linha[18];
            $valorPremio_1 = $linha[19];
            $numeroDeGanhadores_2 = $linha[20];
            $valorPremio_2 = $linha[21];
            $numeroDeGanhadores_3 = $linha[22];
            $valorPremio_3 = $linha[23];
            $numeroDeGanhadores_4 = $linha[24];
            $valorPremio_4 = $linha[25];
            $numeroDeGanhadores_5 = $linha[26];
            $valorPremio_5 = $linha[27];
            $acumulado = $linha[28];
            $valorArrecadado = $linha[29];
            $valorAcumuladoConcursoEspecial = $linha[30]; 
            $valorEstimadoProximoConcurso = $linha[31];
            $observacao = $linha[32];

            // Convertendo a data no formato d/m/Y para Y-m-d
            $data = date("Y-m-d", strtotime(str_replace('/', '-', $dataConcurso)));
            //$nascimento = date("Y-m-d", strtotime(str_replace('/', '-', $nascimento)));

            // Insira o primeiro concurso no banco de dados
            $sql = "INSERT INTO resultados_lotofacil (concurso, data, numeros,
            dez_1, dez_2, dez_3, dez_4, dez_5, dez_6, dez_7, dez_8, dez_9, dez_10, 
            dez_11, dez_12, dez_13, dez_14, dez_15, ganhadores_15_acertos, cidade_uf, rateio_15_acertos, 
            ganhadores_14_acertos, rateio_14_acertos, ganhadores_13_acertos, rateio_13_acertos, 
            ganhadores_12_acertos, rateio_12_acertos, ganhadores_11_acertos, rateio_11_acertos,
            acumulado_15_acertos, arrecadacao_total, valorAcumuladoConcursoEspecial, estimativa_premios, obs) 
            VALUES ('$concurso_resultado', '$data', '$numeros_formatados', '$numeros_array[0]', 
            '$numeros_array[1]', '$numeros_array[2]', '$numeros_array[3]', '$numeros_array[4]', 
            '$numeros_array[5]', '$numeros_array[6]', '$numeros_array[7]', '$numeros_array[8]', 
            '$numeros_array[9]', '$numeros_array[10]', '$numeros_array[11]', '$numeros_array[12]', 
            '$numeros_array[13]', '$numeros_array[14]', '$numeroDeGanhadores_1', '$cidades_string', 
            '$valorPremio_1', '$numeroDeGanhadores_2', '$valorPremio_2', '$numeroDeGanhadores_3', 
            '$valorPremio_3', '$numeroDeGanhadores_4', '$valorPremio_4', '$numeroDeGanhadores_5', '$valorPremio_5',
            '$acumulado', '$valorArrecadado', '$valorAcumuladoConcursoEspecial', 
            '$valorEstimadoProximoConcurso', '$observacao')";

            // Executar a query
            $result = $conn->query($sql);

            if($result){
                $linhas_importadas++;
            }else{
                $linhas_nao_importadas++;

                if($linhas_nao_importadas == 1){
                    $concursos_nao_importado = ($linha[0] ?? "NULL"); 
                }else{
                    $concursos_nao_importado .= ", " . ($linha[0] ?? "NULL");  
                }
             
            }
        }

        fclose($dados_arquivo);

        // Criar a mensagem com os CPF dos usuários não cadastrados no banco de dados
        if(!empty($concursos_nao_importado)){
            $concursos_nao_importado = "Concursos não importados: $concursos_nao_importado.";
        }

        // Mensagem de sucesso
        $_SESSION['msg'] = "<p style='color: green;'>$linhas_importadas linha(s) importa(s), $linhas_nao_importadas linha(s) não importada(s). $concursos_nao_importado</p>";

        // Redirecionar o usuário
        header("Location: importar.php");

    }else{

        // Mensagem de erro
        $_SESSION['msg'] = "<p style='color: #f00;'>Necessário enviar arquivo csv!</p>";

        // Redirecionar o usuário
        header("Location: importar.php");
    }
?>
