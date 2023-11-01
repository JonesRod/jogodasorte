<?php

    $msg1 = false;
    $msg2 = false;

    include('conexao.php');
    include('generateRandomString.php');
    include('enviarEmail.php');

if(isset($_POST['email'])) {

    $email = $conn->escape_string($_POST['email']);

    if(strlen($_POST['email']) == 0 ) {
        $msg1 = "Preencha ocampo E-mail.";
        $msg2 = '';
    } else {
        
        $sql_query = $conn->query("SELECT * FROM usuarios WHERE email = '$email'");
        $result = $sql_query->fetch_assoc();
        $registro = $sql_query->num_rows;

        //var_dump($_POST);
        if(($registro ) == 1) {

            if($result['id']) {

                $msg2 = "Já enviamos sua nova senha em seu E-mail.";
                $msg1 = '';

                $nova_senha = generateRandomString(8);
                $nova_senha_criptografada = password_hash($nova_senha, PASSWORD_DEFAULT);
                $id_usuario = $result['id'];

                $conn->query("UPDATE usuarios SET senha = '$nova_senha_criptografada' WHERE id = '$id_usuario'");
                enviar_email($email, "Recuperação de Senha", "
                <h1>Olá " . $result['primeiro_nome'] . "</h1>
                <p>Uma nova senha foi definida para a sua conta.</p>
                <p><b>Nova senha: </b>$nova_senha</p>
                <p><b>Para redefinir sua senha </b><a href='redefinir_senha.php'>clique aqui.</a></p>
                <p><b>Para entrar </b><a href='../../index.html'>clique aqui.</a></p>");

                header("refresh: 10; ../../index.html");
                
            }    
        }
        if(($registro ) == 0) {
            $msg1 = "Não existe nenhum Usuario cadastrado com esse e-mail!";
            $msg2 = '';
        }
    }  
}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        form {
            max-width: 300px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /*sombra*/

        }

        h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 50px;
        }

        #msg1 {
            color: red;
        }
        #msg2 {
            color: green;
        }
        .input-container {
        position: relative;
        margin-bottom: 20px;
    }

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.placeholder {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10px;
    color: #555;
    pointer-events: none;
    transition: top 0.3s, font-size 0.3s, color 0.3s;
}

input:focus + .placeholder, input:not(:placeholder-shown) + .placeholder {
    top: 0;
    font-size: 12px;
    color: #555;
}





        button {
            padding: 10px 20px;
            margin: 20px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s, font-size 0.3s; 
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }
    </style>
    <title>Recuperar Senha</title>
</head>
<body>
    <form action="" method="POST">
        <h1>Recupere sua Senha.</h1>
        <span style="color: green;"><?php echo $msg2; ?></span>
        <span style="color: red;"><?php echo $msg1; ?></span>
    
        <div class="input-container">
            <input type="email" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
            <label for="email" class="placeholder">E-mail cadastrado</label>
        </div>
        <a style="margin-right:40px;" href="../../index.php">Voltar</a> 
        <button type="submit">Enviar</button>
    </form>
</body>
</html>