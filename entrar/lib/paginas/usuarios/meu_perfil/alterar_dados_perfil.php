<?php
    include('../../../conexao.php');

    $erro = false;
    $msg1 ='';
    $msg2 = '';

    if(!isset($_SESSION))
        session_start();
        
    if(!isset($_SESSION['usuario'])){
        header("Location: ../../../../index.php");
    }

    if(count($_POST) > 0) { 
        
        //$arq = $_FILES['imageInput'];
        $id = intval($_POST['id']);
        $primeiro_nome = $conn->escape_string($_POST['primeiro_nome']);
        $nome_completo = $conn->escape_string($_POST['nome_completo']);
        $cpf = $conn->escape_string($_POST['cpf']);
        $nascimento = $conn->escape_string($_POST['nascimento']);
        $uf = $conn->escape_string($_POST['uf']);
        $uf = $conn->escape_string($_POST['uf']);
        $cep = $conn->escape_string($_POST['cep']);
        $cidade = $conn->escape_string($_POST['cidade']);    
        $celular = $conn->escape_string($_POST['celular']);
        $email = $conn->escape_string($_POST['email']);
    
        //$hoje = new DateTime('now');
        $dataStr = $nascimento;
        $dataFormatada = DateTime::createFromFormat('d/m/Y', $dataStr);

        $nasc = $dataFormatada->format('Y-m-d');

        if($erro) {
            $msg1 = '';
            $msg2 = "<p><b>ERRO: $erro</b></p>";
        } else {
    
            $sql_code = "UPDATE usuarios
            SET 
            primeiro_nome ='$primeiro_nome',
            nome_completo = '$nome_completo', 
            cpf = '$cpf',
            data_nascimento = '$nasc',
            uf = '$uf',
            cep = '$cep',
            cidade = '$cidade',       
            celular = '$celular',
            email = '$email'
            WHERE id = '$id'";

            //var_dump($_POST);

            $deu_certo = $conn->query($sql_code) or die($conn->error);
            
            if($deu_certo) {
                $msg1 = "<p><b>Dados atualizado com sucesso!!!</b></p>";
                unset($_POST);
                $msg2 = '<script>atualizarContagem(5);</script>';
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
            text-align: center;
            margin-top: 30px;
        }
    </style>
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
                window.location.href = '../inicio_usuario/usuario_inicio.php';
            }
        }
    </script>
    <title></title>
</head>
<body>
    <div>
        <span><?php echo $msg1;?></span>
        <span id="contador"></span>
        <span><?php echo $msg2;?></span>
    </div>
</body>
</html>
