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
        body{
            text-align: center;
        }
    </style>
    <title>Recuperar Senha</title>
</head>
<body>
    <h1>Recupere sua Senha.</h1>
    <span style="color: green;"><?php echo $msg2; ?></span>
    <span style="color: red;"><?php echo $msg1; ?></span>
    <form action="" method="POST">
        <p>  
            <label for="">Digite E-mail cadastrado</label>
            <input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
        </p>
        <a style="margin-right:40px;" href="../../index.html">Voltar</a> 
        <button type="submit">Enviar</button>
    </form>
</body>
</html>