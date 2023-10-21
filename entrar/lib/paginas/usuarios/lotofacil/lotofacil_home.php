<?php

    include('../../../conexao.php');

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
            $numeros = implode(',', $data['listaDezenas']);
            $dataConcurso = $data['dataApuracao'];
            $listaMunicipioUFGanhadores = $data['listaMunicipioUFGanhadores'];
            $listaRateioPremio = $data['listaRateioPremio'];
            $acumulado = $data['acumulado'];
            $valorArrecadado = $data['valorArrecadado'];
            $valorAcumuladoConcurso_0_5 = $data['valorAcumuladoConcurso_0_5'];
            $valorAcumuladoConcursoEspecial = $data['valorAcumuladoConcursoEspecial'];
            $valorAcumuladoProximoConcurso = $data['valorAcumuladoProximoConcurso'];
            $valorEstimadoProximoConcurso = $data['valorEstimadoProximoConcurso'];
            $valorSaldoReservaGarantidora = $data['valorSaldoReservaGarantidora'];
            $valorTotalPremioFaixaUm = $data['valorTotalPremioFaixaUm'];
            
            return array(
                'data' => $dataConcurso,
                'concurso' => $concurso,
                'numeros' => $numeros
                
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
        $data = $row['data'];
        $numeros = $row['numeros'];

        // Obtenha o primeiro concurso através da API (substitua com sua lógica de API)
        $numero_concurso = obterConcursoAtual();

        
        $dataStr = $numero_concurso['data'];
        $dataFormatada = DateTime::createFromFormat('d/m/Y', $dataStr);
        $dataConcurso = $dataFormatada->format('Y-m-d');

        $numeros = $numero_concurso['numeros'];
        $numeros_formatados = str_replace(',', '-', $numeros);
        $numeros_array = explode('-', $numeros_formatados);

        if($concurso != $numero_concurso['concurso']){
            // Insira o primeiro concurso no banco de dados
            $sql = "INSERT INTO resultados_lotofacil (concurso, data, numeros,
            dez_1, dez_2, dez_3, dez_4, dez_5, dez_6, dez_7, dez_8, dez_9, dez_10, 
            dez_11, dez_12, dez_13, dez_14, dez_15) VALUES ('$concurso[concurso]', 
            '$dataConcurso', '$numeros_formatados', '$numeros_array[0]', 
            '$numeros_array[1]', '$numeros_array[2]', '$numeros_array[3]', '$numeros_array[4]', 
            '$numeros_array[5]', '$numeros_array[6]', '$numeros_array[7]', '$numeros_array[8]', 
            '$numeros_array[9]', '$numeros_array[10]', '$numeros_array[11]', '$numeros_array[12]', 
            '$numeros_array[13]', '$numeros_array[14]')" ;

            if ($conn->query($sql) === TRUE) {
                $msg = "Concurso registrado com sucesso.";
            } else {
                $msg = "Erro ao registrar o concurso: " . $conn->error;
            } 
        }else{
            $msg = "concurso ja existe no banco!";
        }
    }else{
        // Obtenha o primeiro concurso através da API (substitua com sua lógica de API)
        $numero_concurso = obterConcursoAtual();

        $dataStr = $numero_concurso['data'];
        $dataFormatada = DateTime::createFromFormat('d/m/Y', $dataStr);
        $dataConcurso = $dataFormatada->format('Y-m-d');
/*echo $dataConcurso;
die();*/
        $numeros = $numero_concurso['numeros'];
        $numeros_formatados = str_replace(',', '-', $numeros);
        $numeros_array = explode('-', $numeros_formatados);

        // Insira o primeiro concurso no banco de dados
        $sql = "INSERT INTO resultados_lotofacil (concurso, data, numeros,
        dez_1, dez_2, dez_3, dez_4, dez_5, dez_6, dez_7, dez_8, dez_9, dez_10, 
        dez_11, dez_12, dez_13, dez_14, dez_15) 
        VALUES ('$numero_concurso[concurso]', '$dataConcurso', '$numeros_formatados', 
        '$numeros_array[0]', '$numeros_array[1]', '$numeros_array[2]', '$numeros_array[3]', 
        '$numeros_array[4]', '$numeros_array[5]', '$numeros_array[6]', '$numeros_array[7]', 
        '$numeros_array[8]', '$numeros_array[9]', '$numeros_array[10]', '$numeros_array[11]', 
        '$numeros_array[12]', '$numeros_array[13]', '$numeros_array[14]')" ;

        if ($conn->query($sql) === TRUE) {
            $msg = "Concurso registrado com sucesso.";
        } else {
            $msg = "Erro ao registrar o primeiro concurso: " . $conn->error;
        } 
    }


    $conn->close();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function obterPrimeiroConcurso() {
            // Suponha que a API de lotofácil tenha um ponto de acesso que retorna o primeiro concurso
            const apiEndpoint = 'https://api-lotofacil.com/concursos/primeiro';
            
            // Faça uma requisição para a API usando o fetch ou outro método
            return fetch(apiEndpoint)
                .then(response => response.json())
                .then(data => {
                    // Assumindo que a API retorna um objeto com o número do concurso e os números sorteados
                    return {
                        concurso: data.numero,
                        numeros: data.numeros_sorteados
                    };
                })
                .catch(error => {
                    console.error('Erro ao obter dados da API:', error);
                    return null; // Retornar null em caso de erro
                });
        }

    </script>
    <title>Lotofácil</title>
</head>
<body>
    <span><?php echo $msg; ?></span>
    <div>

    </div>
</body>
</html>
