<?php
    include('../../../../conexao.php');


    session_start();

    $msg = '';

    if(!isset($_SESSION['usuario'])){
        header("Location: ../../../../../index.php");
    } 

    if(count($_POST) > 0) {  

        $id= 1; 
        $id_usuario = $conn->escape_string($_POST['id_usuario']);
        $valor_15 = $conn->escape_string($_POST['valor_15']);
        $valor_16 = $conn->escape_string($_POST['valor_16']);
        $valor_17 = $conn->escape_string($_POST['valor_17']);
        $valor_18 = $conn->escape_string($_POST['valor_18']);
        $valor_19 = $conn->escape_string($_POST['valor_19']);
        $valor_20 = $conn->escape_string($_POST['valor_20']);
        $qt_concurso_confere = $conn->escape_string($_POST['qt_concurso_confere']);
        $qt_concurso_salva = $conn->escape_string($_POST['qt_concurso_salva']);

        $sql = $conn->query("SELECT * FROM config_lotofacil WHERE id = '$id'");
        $result = $sql->fetch_assoc();
        $registro = $sql->num_rows;

        if(($registro ) == 0) {

            // Insira o primeiro concurso no banco de dados
            $sql_code = "INSERT INTO config_lotofacil (id_usuario, valor_15, valor_16, valor_17, valor_18, valor_19, valor_20, qt_concurso_confere, qt_concurso_salva) 
            VALUES ('$id_usuario', '$valor_15', '$valor_16', '$valor_17', '$valor_18', '$valor_19', '$valor_20', '$qt_concurso_confere', '$qt_concurso_salva')";

            $deu_certo = $conn->query($sql_code) or die($conn->error);

            if($deu_certo) {

                //var_dump($_POST);

                $msg = "<h3><b>Dados atualizado com sucesso!!!</b></h3>";
                unset($_POST);
                header("refresh: 5; config_lotofacil.php");
            } else {
                $msg = "<h3><b>ERRO: $erro</b></h3>";
            }

        } else {
 
            $sql_code = "UPDATE config_lotofacil
            SET 
            id_usuario = '$id_usuario',
            valor_15 = '$valor_15',
            valor_16 = '$valor_16',
            valor_17 = '$valor_17',
            valor_18 = '$valor_18',
            valor_19 = '$valor_19',
            valor_20 = '$valor_20',
            qt_concurso_confere = '$qt_concurso_confere',
            qt_concurso_salva = '$qt_concurso_salva'
            WHERE id = '$id'";

            $deu_certo = $conn->query($sql_code) or die($conn->error);

            if($deu_certo) {
            
                //var_dump($_POST);

                $msg = "<h3><b>Dados atualizado com sucesso!!!</b></h3>";
                unset($_POST);
                header("refresh: 5; config_lotofacil.php");
            } else {
                $msg = "<h3><b>ERRO: $erro</b></h3>";
            }
        }  
    }
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
            margin-top: 30px;
        }
        #contador{
            color: blue;
        }
    </style>
    <title></title>
</head>
<body>
    <div>
        <span><?php echo $msg;?></span>
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
                window.location.href = 'config_lotofacil.php';
            }
        }

        // Chame a função para iniciar a contagem regressiva
        atualizarContagem(5);
    </script>
</body>
</html>

