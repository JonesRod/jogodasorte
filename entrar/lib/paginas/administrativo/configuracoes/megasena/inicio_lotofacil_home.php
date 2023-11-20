<?php

    include('../../../../conexao.php');

    if(!isset($_SESSION)){
        session_start(); 

        if(isset($_SESSION['usuario'])){

            if (isset($_POST["tipoLogin"])) {
                $usuario_sessao = $_SESSION['usuario'];
                $valorSelecionado = $_POST["tipoLogin"];
                $admin = $valorSelecionado;

                if($admin != 1){
                    header("Location: ../../../usuarios/usuario_home.php");      
                } else {
                    $_SESSION['usuario'];
                    $_SESSION['admin'];  
                }
            }  

        } else {
            session_unset();
            session_destroy(); 
            header("Location: ../../inicio_admin/admin_logout.php");  
        }
    } else {
        if(isset($_SESSION['usuario'])){

            if (isset($_POST["tipoLogin"])) {
                $usuario_sessao = $_SESSION['usuario'];
                $valorSelecionado = $_POST["tipoLogin"];
                $admin = $valorSelecionado;

                if($admin != 1){
                    header("Location: ../../../usuarios/usuario_home.php");      
                } else {
                    $_SESSION['usuario'];
                    $_SESSION['admin'];  
                }
            }  

        } else {
            session_unset();
            session_destroy(); 
            header("Location: ../../inicio_admin/admin_logout.php");  
        }

    }

    // Verifique se o último resultado foi registrado
    $resultado_existe = false;
    $msg =false;

    $sql = "SELECT * FROM resultados_lotofacil ORDER BY concurso DESC LIMIT 1";
    $result = $conn->query($sql);
    function obterConcursoAtual() {
        $url = 'https://servicebus2.caixa.gov.br/portaldeloterias/api/lotofacil';
        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        // Adicione esta linha para desativar a verificação SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        
        if($response === false) {
            //$msg = 'Erro ao obter dados da API: ' . curl_error($ch);
            return null;
        }
        
        $data = json_decode($response, true);
        
        if ($data === null) {
            //$msg = 'Erro ao decodificar JSON da API';
            return null;
        }else if($data !== null) {
            $concurso = $data['numero'];
            $dataConcurso = $data['dataApuracao'];
            $numeros = implode(',', $data['listaDezenas']);

            // Lista de Rateio de Prêmio
            $listaRateioPremio = $data['listaRateioPremio'];

            // Filtrar para obter apenas os dados com 15 acertos
            /*$dados15Acertos = array_filter($listaRateioPremio, function($item) {
                return $item['descricaoFaixa'] == '15 acertos';
            });

            // Variáveis para numeroDeGanhadores e valorPremio
            $totalGanhadores14Acertos = $dados15Acertos[0]['numeroDeGanhadores'];*/

            $numeroDeGanhadores_1 = $listaRateioPremio[0]['numeroDeGanhadores'];
            $valorPremio_1 = $listaRateioPremio[0]['valorPremio'];

            $numeroDeGanhadores_2 = $listaRateioPremio[1]['numeroDeGanhadores'];
            $valorPremio_2 = $listaRateioPremio[1]['valorPremio'];

            $numeroDeGanhadores_3 = $listaRateioPremio[2]['numeroDeGanhadores'];
            $valorPremio_3 = $listaRateioPremio[2]['valorPremio'];

            $numeroDeGanhadores_4 = $listaRateioPremio[3]['numeroDeGanhadores'];
            $valorPremio_4 = $listaRateioPremio[3]['valorPremio'];

            $numeroDeGanhadores_5 = $listaRateioPremio[4]['numeroDeGanhadores'];
            $valorPremio_5 = $listaRateioPremio[4]['valorPremio']; 

            // Lista de Município e UF de Ganhadores
            $listaMunicipioUFGanhadores = $data['listaMunicipioUFGanhadores'];

            // Iterar sobre a lista e construir a string desejada
            $cidades = array();
            foreach ($listaMunicipioUFGanhadores as $item) {
                $cidade = $item['municipio'] . '/' . $item['uf'];
                $cidades[] = $cidade;
            }

            // Converter o array de cidades em uma string com ponto e vírgula como separador
            $cidades_string = implode('; ', $cidades);

            $acumulado = $data['acumulado'];
            $valorArrecadado = $data['valorArrecadado'];
            $valorAcumuladoConcurso_0_5 = $data['valorAcumuladoConcurso_0_5'];
            $valorAcumuladoConcursoEspecial = $data['valorAcumuladoConcursoEspecial'];
            $dataProximoConcurso = $data['dataProximoConcurso'];
            $valorAcumuladoProximoConcurso = $data['valorAcumuladoProximoConcurso'];
            $valorEstimadoProximoConcurso = $data['valorEstimadoProximoConcurso'];
            $valorSaldoReservaGarantidora = $data['valorSaldoReservaGarantidora'];
            $valorTotalPremioFaixaUm = $data['valorTotalPremioFaixaUm'];
            $observacao = $data['observacao'];

            return array(
                'data' => $dataConcurso,
                'concurso' => $concurso,
                'numeros' => $numeros,
                'numeroDeGanhadores_1' => $numeroDeGanhadores_1,
                'cidades_string' => $cidades_string,
                'valorPremio_1' => $valorPremio_1,
                'numeroDeGanhadores_2' => $numeroDeGanhadores_2,
                'valorPremio_2' => $valorPremio_2,
                'numeroDeGanhadores_3' => $numeroDeGanhadores_3,
                'valorPremio_3' => $valorPremio_3,
                'numeroDeGanhadores_4' => $numeroDeGanhadores_4,
                'valorPremio_4' => $valorPremio_4,
                'numeroDeGanhadores_5' => $numeroDeGanhadores_5,
                'valorPremio_5' => $valorPremio_5,
                'acumulado' => $acumulado,
                'valorArrecadado' => $valorArrecadado,
                'valorAcumuladoConcurso_0_5' => $valorAcumuladoConcurso_0_5,
                'valorAcumuladoConcursoEspecial' => $valorAcumuladoConcursoEspecial,
                'dataProximoConcurso' => $dataProximoConcurso,
                'valorAcumuladoProximoConcurso' => $valorAcumuladoProximoConcurso,
                'valorEstimadoProximoConcurso' => $valorEstimadoProximoConcurso,
                'valorSaldoReservaGarantidora' => $valorSaldoReservaGarantidora,
                'valorTotalPremioFaixaUm' => $valorTotalPremioFaixaUm,
                'observacao' => $observacao
            );
        } else {
            //$msg = 'Não foi possível obter o primeiro concurso.';
            return null;
        }
        
        curl_close($ch);
    }

    if ($result->num_rows > 0) {
        $resultado_existe = true;
        $row = $result->fetch_assoc();

        // Existe um resultado no banco de dados
        $concurso = $row['concurso'];

        // Obtenha o primeiro concurso através da API (substitua com sua lógica de API)
        $numero_concurso = obterConcursoAtual();

        $dataStr = $numero_concurso['data'];
        $dataFormatada = DateTime::createFromFormat('d/m/Y', $dataStr);
        $dataConcurso = $dataFormatada->format('Y-m-d');

        $concurso_resultado = $numero_concurso['concurso'];

        $numeros = $numero_concurso['numeros'];
        $numeros_formatados = str_replace(',', '-', $numeros);
        $numeros_array = explode('-', $numeros_formatados);

        $numeroDeGanhadores_1 = $numero_concurso['numeroDeGanhadores_1'];
        $cidades_string = $numero_concurso['cidades_string'];
        $valorPremio_1 = $numero_concurso['valorPremio_1'];
        $numeroDeGanhadores_2 = $numero_concurso['numeroDeGanhadores_2'];
        $valorPremio_2 = $numero_concurso['valorPremio_2'];
        $numeroDeGanhadores_3 = $numero_concurso['numeroDeGanhadores_3'];
        $valorPremio_3 = $numero_concurso['valorPremio_3'];
        $numeroDeGanhadores_4 = $numero_concurso['numeroDeGanhadores_4'];
        $valorPremio_4 = $numero_concurso['valorPremio_4'];
        $numeroDeGanhadores_5 = $numero_concurso['numeroDeGanhadores_5'];
        $valorPremio_5 = $numero_concurso['valorPremio_5'];
        $acumulado = $numero_concurso['acumulado'];
        $valorArrecadado = $numero_concurso['valorArrecadado'];
        $valorAcumuladoConcurso_0_5 = $numero_concurso['valorAcumuladoConcurso_0_5'];
        $valorAcumuladoConcursoEspecial = $numero_concurso['valorAcumuladoConcursoEspecial'];
        $valorAcumuladoProximoConcurso = $numero_concurso['valorAcumuladoProximoConcurso'];

        $dataProx= $numero_concurso['dataProximoConcurso'];
        $dataProxFormatada = DateTime::createFromFormat('d/m/Y', $dataProx);
        $dataProximoConcurso = $dataProxFormatada->format('Y-m-d');

        $valorEstimadoProximoConcurso = $numero_concurso['valorEstimadoProximoConcurso'];
        $valorSaldoReservaGarantidora = $numero_concurso['valorSaldoReservaGarantidora'];
        $valorTotalPremioFaixaUm = $numero_concurso['valorTotalPremioFaixaUm'];
        $observacao = $numero_concurso['observacao'];

        if($concurso != $concurso_resultado){
            // Insira o primeiro concurso no banco de dados
            $sql = "INSERT INTO resultados_lotofacil (concurso, data, numeros, dez_1, dez_2, 
            dez_3, dez_4, dez_5, dez_6, dez_7, 
            dez_8, dez_9, dez_10, dez_11, dez_12, 
            dez_13, dez_14, dez_15, ganhadores_15_acertos, cidade_uf, 
            rateio_15_acertos, ganhadores_14_acertos, rateio_14_acertos, ganhadores_13_acertos, rateio_13_acertos, 
            ganhadores_12_acertos, rateio_12_acertos, ganhadores_11_acertos, rateio_11_acertos, acumulado_15_acertos, 
            arrecadacao_total, valorAcumuladoConcurso_0_5, valorAcumuladoConcursoEspecial, dataProximoConcurso, valorAcumuladoProximoConcurso, 
            estimativa_premios, valorSaldoReservaGarantidora, valorTotalPremioFaixaUm, obs) 
            VALUES ('$concurso_resultado', '$dataConcurso', '$numeros_formatados', '$numeros_array[0]', '$numeros_array[1]', 
            '$numeros_array[2]', '$numeros_array[3]', '$numeros_array[4]', '$numeros_array[5]', '$numeros_array[6]', 
            '$numeros_array[7]', '$numeros_array[8]', '$numeros_array[9]', '$numeros_array[10]', '$numeros_array[11]', 
            '$numeros_array[12]', '$numeros_array[13]', '$numeros_array[14]', '$numeroDeGanhadores_1', '$cidades_string', 
            '$valorPremio_1', '$numeroDeGanhadores_2', '$valorPremio_2', '$numeroDeGanhadores_3', '$valorPremio_3', 
            '$numeroDeGanhadores_4', '$valorPremio_4', '$numeroDeGanhadores_5', '$valorPremio_5','$acumulado', 
            '$valorArrecadado', '$valorAcumuladoConcurso_0_5', '$valorAcumuladoConcursoEspecial', '$dataProximoConcurso', '$valorAcumuladoProximoConcurso', 
            '$valorEstimadoProximoConcurso', '$valorSaldoReservaGarantidora', '$valorTotalPremioFaixaUm', '$observacao')";

            if ($conn->query($sql) === TRUE) {
                $msg = "Concurso registrado com sucesso.";
                unset($_POST);
                header("refresh: 5; url=add_concurso_lotofacil.php");
            } else {
                $msg = "Erro ao registrar o primeiro concurso: " . $conn->error;
            } 
        }else{
            $msg = "Concurso $concurso_resultado ja existe no banco!";
            unset($_POST);
            header("refresh: 5; url=add_concurso_lotofacil.php");
        }
    }else{
        // Obtenha o primeiro concurso através da API (substitua com sua lógica de API)
        $numero_concurso = obterConcursoAtual();

        $dataStr = $numero_concurso['data'];
        $dataFormatada = DateTime::createFromFormat('d/m/Y', $dataStr);
        $dataConcurso = $dataFormatada->format('Y-m-d');

        $concurso_resultado = $numero_concurso['concurso'];

        $numeros = $numero_concurso['numeros'];
        $numeros_formatados = str_replace(',', '-', $numeros);
        $numeros_array = explode('-', $numeros_formatados);

        $numeroDeGanhadores_1 = $numero_concurso['numeroDeGanhadores_1'];
        $cidades_string = $numero_concurso['cidades_string'];
        $valorPremio_1 = $numero_concurso['valorPremio_1'];
        $numeroDeGanhadores_2 = $numero_concurso['numeroDeGanhadores_2'];
        $valorPremio_2 = $numero_concurso['valorPremio_2'];
        $numeroDeGanhadores_3 = $numero_concurso['numeroDeGanhadores_3'];
        $valorPremio_3 = $numero_concurso['valorPremio_3'];
        $numeroDeGanhadores_4 = $numero_concurso['numeroDeGanhadores_4'];
        $valorPremio_4 = $numero_concurso['valorPremio_4'];
        $numeroDeGanhadores_5 = $numero_concurso['numeroDeGanhadores_5'];
        $valorPremio_5 = $numero_concurso['valorPremio_5'];
        $acumulado = $numero_concurso['acumulado'];
        $valorArrecadado = $numero_concurso['valorArrecadado'];
        $valorAcumuladoConcurso_0_5 = $numero_concurso['valorAcumuladoConcurso_0_5'];
        $valorAcumuladoConcursoEspecial = $numero_concurso['valorAcumuladoConcursoEspecial'];
        $valorAcumuladoProximoConcurso = $numero_concurso['valorAcumuladoProximoConcurso'];

        $dataProx= $numero_concurso['dataProximoConcurso'];
        $dataProxFormatada = DateTime::createFromFormat('d/m/Y', $dataProx);
        $dataProximoConcurso = $dataProxFormatada->format('Y-m-d');

        $valorEstimadoProximoConcurso = $numero_concurso['valorEstimadoProximoConcurso'];
        $valorSaldoReservaGarantidora = $numero_concurso['valorSaldoReservaGarantidora'];
        $valorTotalPremioFaixaUm = $numero_concurso['valorTotalPremioFaixaUm'];
        $observacao = $numero_concurso['observacao'];

        // Insira o primeiro concurso no banco de dados
        $sql = "INSERT INTO resultados_lotofacil (concurso, data, numeros, dez_1, dez_2, 
        dez_3, dez_4, dez_5, dez_6, dez_7, 
        dez_8, dez_9, dez_10, dez_11, dez_12, 
        dez_13, dez_14, dez_15, ganhadores_15_acertos, cidade_uf, 
        rateio_15_acertos, ganhadores_14_acertos, rateio_14_acertos, ganhadores_13_acertos, rateio_13_acertos, 
        ganhadores_12_acertos, rateio_12_acertos, ganhadores_11_acertos, rateio_11_acertos, acumulado_15_acertos, 
        arrecadacao_total, valorAcumuladoConcurso_0_5, valorAcumuladoConcursoEspecial, dataProximoConcurso, valorAcumuladoProximoConcurso, 
        estimativa_premios, valorSaldoReservaGarantidora, valorTotalPremioFaixaUm, obs) 
        VALUES ('$concurso_resultado', '$dataConcurso', '$numeros_formatados', '$numeros_array[0]', '$numeros_array[1]', 
        '$numeros_array[2]', '$numeros_array[3]', '$numeros_array[4]', '$numeros_array[5]', '$numeros_array[6]', 
        '$numeros_array[7]', '$numeros_array[8]', '$numeros_array[9]', '$numeros_array[10]', '$numeros_array[11]', 
        '$numeros_array[12]', '$numeros_array[13]', '$numeros_array[14]', '$numeroDeGanhadores_1', '$cidades_string', 
        '$valorPremio_1', '$numeroDeGanhadores_2', '$valorPremio_2', '$numeroDeGanhadores_3', '$valorPremio_3', 
        '$numeroDeGanhadores_4', '$valorPremio_4', '$numeroDeGanhadores_5', '$valorPremio_5','$acumulado', 
        '$valorArrecadado', '$valorAcumuladoConcurso_0_5', '$valorAcumuladoConcursoEspecial', '$dataProximoConcurso', '$valorAcumuladoProximoConcurso', 
        '$valorEstimadoProximoConcurso', '$valorSaldoReservaGarantidora', '$valorTotalPremioFaixaUm', '$observacao')";

        if ($conn->query($sql) === TRUE) {
            $msg = "Concurso registrado com sucesso.";
            unset($_POST);
            header("refresh: 5; url=add_concurso_lotofacil.php");
        } else {
            $msg = "Erro ao registrar o primeiro concurso: " . $conn->error;
            unset($_POST);
            header("refresh: 5; url=add_concurso_lotofacil.php");
        } 
    }

    $conn->close();

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
            color: blueviolet;
        }
        div {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /*sombra*/
        }
    </style>

    <title></title>
</head>
<body>
    <div>
        <h2><?php echo $msg; ?></h2>
        <span id="contador"></span>
    </div>
    <script>
        // Função para atualizar a contagem regressiva
        function atualizarContagem(tempo) {
            var contadorElemento = document.getElementById('contador');

            if (tempo > 0) {
                contadorElemento.innerHTML = 'Redirecionando em ' + tempo + ' segundos...';
                setTimeout(function() {
                    atualizarContagem(tempo - 1);
                }, 1000);
            } else {
                contadorElemento.innerHTML = 'Redirecionando...';
                // Redirecionar após a contagem regressiva
                window.location.href = 'add_concurso_lotofacil.php';
            }
        }

        // Chame a função para iniciar a contagem regressiva
        atualizarContagem(5);
    </script>
</body>
</html>