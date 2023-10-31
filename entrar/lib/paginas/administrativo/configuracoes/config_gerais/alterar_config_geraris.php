<?php
    include('../../../../conexao.php');
        $msg1 = '';
        $msg2 = '';

    if(count($_POST) > 0) { 
        session_start();

        //if (isset($_SESSION['usuario'])) {

            $id_admin = $conn->escape_string($_POST['id']);
            $primeiro_nome = $conn->escape_string($_POST['primeiro_nome']);
            $fantazia = $conn->escape_string($_POST['fantazia']);
            $razao = $conn->escape_string($_POST['razao']);
            $cnpj = $conn->escape_string($_POST['cnpj']);
            $uf = $conn->escape_string($_POST['uf']);
            $cep = $conn->escape_string($_POST['cep']);
            $cidade = $conn->escape_string($_POST['cidade']);    
            $celular = $conn->escape_string($_POST['celular']);
            $email = $conn->escape_string($_POST['email']);
            $creditos = $conn->escape_string($_POST['creditos']);
            $termos = $conn->escape_string($_POST['termos']);

            $sql_code = "UPDATE config_admin
            SET 
            id_admin = '$id_admin',
            data_alteracao = NOW(),
            primeiro_nome ='$primeiro_nome',
            fantazia = '$fantazia', 
            razao = '$razao',
            cnpj = '$cnpj',
            uf = '$uf',
            cep = '$cep',
            cidade = '$cidade',       
            celular = '$celular',
            email = '$email',
            termos = '$termos',
            credito_cadastro = '$creditos'
            WHERE id = '1'";

            $conn->query($sql_code) or die($conn->error);

            $historico_config_admin = "INSERT INTO historico_config_admin (id_admin, data_alteracao, 
            primeiro_nome, fantazia, razao, cnpj, uf, cep, cidade, celular, email, termos, credito_cadastro) 
            VALUES('$id_admin', NOW(), '$primeiro_nome', '$fantazia', '$razao', '$cnpj','$uf', '$cep', 
            '$cidade', '$celular', '$email', '$termos', '$creditos')";

            $deu_certo = $conn->query($historico_config_admin) or die($conn->error);
            
            if($deu_certo) {
                $msg1 = "<p><b>Dados atualizado com sucesso!!!</b></p>";
                $msg2 = "<script>atualizarContagem(5);</script>";
                unset($_POST);
            }
        //}   

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
        <span><?php echo $msg1;?></span>
        <span><?php echo $msg2;?></span>
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
                window.location.href = 'config_gerais.php';
            }
        }

        // Chame a função para iniciar a contagem regressiva
        atualizarContagem(5);
    </script>
</body>
</html>