<?php
    include('../../../../conexao.php');

    $msg = false;

    if (isset($_POST['concurso'])) {
        
        $concurso = $conn->escape_string($_POST['concurso']);

        $sql = $conn->query("SELECT * FROM resultados_lotofacil WHERE concurso = '$concurso'");
        $result = $sql->fetch_assoc();
        $registro = $sql->num_rows;

        if(($registro ) == 0) {

            $data = $conn->escape_string($_POST['data']);

            $dez_1 = $conn->escape_string($_POST['dez_1']);
            $dez_2 = $conn->escape_string($_POST['dez_2']);
            $dez_3 = $conn->escape_string($_POST['dez_3']);
            $dez_4 = $conn->escape_string($_POST['dez_4']);
            $dez_5 = $conn->escape_string($_POST['dez_5']);

            $dez_6 = $conn->escape_string($_POST['dez_6']);
            $dez_7 = $conn->escape_string($_POST['dez_7']);
            $dez_8 = $conn->escape_string($_POST['dez_8']);
            $dez_9 = $conn->escape_string($_POST['dez_9']);
            $dez_10 = $conn->escape_string($_POST['dez_10']);
            
            $dez_11 = $conn->escape_string($_POST['dez_11']);
            $dez_12 = $conn->escape_string($_POST['dez_12']);
            $dez_13 = $conn->escape_string($_POST['dez_13']);
            $dez_14 = $conn->escape_string($_POST['dez_14']);
            $dez_15 = $conn->escape_string($_POST['dez_15']);

            $numeros = $dez_1 .'-'. $dez_2 .'-'. $dez_3 .'-'. $dez_4 .'-'. $dez_5 .'-'
            . $dez_6 .'-'. $dez_7 .'-'. $dez_8 .'-'. $dez_9 .'-'. $dez_10 .'-'
            . $dez_11 .'-'. $dez_12 .'-'. $dez_13 .'-'. $dez_14 .'-'. $dez_15;

            $ganhadores_15_acertos = $conn->escape_string($_POST['ganhadores_15_acertos']);
            $cidade_uf = $conn->escape_string($_POST['cidade_uf']);

            $rateio_15_acertos = $conn->escape_string($_POST['rateio_15_acertos']);
            $ganhadores_14_acertos = $conn->escape_string($_POST['ganhadores_14_acertos']);
            $rateio_14_acertos = $conn->escape_string($_POST['rateio_14_acertos']);
            $ganhadores_13_acertos = $conn->escape_string($_POST['ganhadores_13_acertos']);
            $rateio_13_acertos = $conn->escape_string($_POST['rateio_13_acertos']);

            $ganhadores_12_acertos = $conn->escape_string($_POST['ganhadores_12_acertos']);
            $rateio_12_acertos = $conn->escape_string($_POST['rateio_12_acertos']);
            $ganhadores_11_acertos = $conn->escape_string($_POST['ganhadores_11_acertos']);
            $rateio_11_acertos = $conn->escape_string($_POST['rateio_11_acertos']);
            $acumulado_15_acertos = $conn->escape_string($_POST['acumulado_15_acertos']);

            $arrecadacao_total = $conn->escape_string($_POST['arrecadacao_total']);
            $valorAcumuladoConcursoEspecial = $conn->escape_string($_POST['valorAcumuladoConcursoEspecial']);
            $dataProximoConcurso = $conn->escape_string($_POST['dataProximoConcurso']);
            $valorAcumuladoProximoConcurso = $conn->escape_string($_POST['valorAcumuladoProximoConcurso']);

            // Insira o primeiro concurso no banco de dados
            $sql = "INSERT INTO resultados_lotofacil (concurso, data, numeros,dez_1, dez_2, 
            dez_3, dez_4, dez_5, dez_6, dez_7, 
            dez_8, dez_9, dez_10, dez_11, dez_12, 
            dez_13, dez_14, dez_15, ganhadores_15_acertos, cidade_uf, 
            rateio_15_acertos, ganhadores_14_acertos, rateio_14_acertos, ganhadores_13_acertos, rateio_13_acertos, 
            ganhadores_12_acertos, rateio_12_acertos, ganhadores_11_acertos, rateio_11_acertos,acumulado_15_acertos, 
            arrecadacao_total, valorAcumuladoConcursoEspecial, dataProximoConcurso, valorAcumuladoProximoConcurso) 
            VALUES ('$concurso', '$data', '$numeros', '$dez_1', '$dez_2', 
            '$dez_3', '$dez_4', '$dez_5', '$dez_6', '$dez_7', 
            '$dez_8', '$dez_9', '$dez_10', '$dez_11', '$dez_12', 
            '$dez_13', '$dez_14', '$dez_15', '$ganhadores_15_acertos', '$cidade_uf', 
            '$rateio_15_acertos', '$ganhadores_14_acertos', '$rateio_14_acertos', '$ganhadores_13_acertos', '$rateio_13_acertos', 
            '$ganhadores_12_acertos', '$rateio_12_acertos', '$ganhadores_11_acertos', '$rateio_11_acertos','$acumulado_15_acertos', 
            '$arrecadacao_total', '$valorAcumuladoConcursoEspecial', '$dataProximoConcurso', '$valorAcumuladoProximoConcurso')";

            if ($conn->query($sql) === TRUE) {
                $msg = "Concurso registrado com sucesso.";
                unset($_POST);
                header("refresh: 5; add_concurso_lotofacil.php");
            } else {
                $msg = "Erro ao registrar o concurso: " . $conn->error;
                unset($_POST);
                header("refresh: 5; add_concurso_lotofacil.php");
            } 
        } else {
            $msg = 'Este concurso ja foi registrados anteriormente!';
            unset($_POST);
            header("refresh: 5; add_concurso_lotofacil.php");
        }
    }else{
        $msg = 'Erro ao registrar concurso!';
        unset($_POST);
        header("refresh: 5; add_concurso_lotofacil.php");
    }

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            margin-top: 100px;
            text-align: center;
            font-size: 25px;
        }
    </style>
    <title></title>
</head>
<body>
    <span><?php echo $msg; ?></span>
</body>
</html>