<?php

    $msg1= false;
    $msg2= false;
    $minimo = 8;
    $maximo = 16;

if (isset($_POST['email']) || isset($_POST['senha_atual'])) 
{
    if(strlen($_POST['senha_atual']) == 0 ) {
        $msg1 = "Preencha sua senha Atual."; 

    } else if(strlen($_POST['nova_senha']) == 0 ) {
        $msg1 = "Preencha o campo Nova Senha.";

    }else if(strlen($_POST['nova_senha']) < $minimo ) {
        $msg1 = "Nova senha deve ter no minimo 8 digito.";
        
    }else if(strlen($_POST['nova_senha']) > $maximo ) {
        $msg1 = "Nona senha deve ter no maximo 16 digito.";

    }else if(strlen($_POST['conf_senha']) == 0 ) {
        $msg1 = "Preencha o campo confirmar Senha.";

    }else if(strlen($_POST['conf_senha']) < $minimo) {
        $msg1 = "Campo Confirmar Senha deve ter no minimo 8 digito.";

    }else if(strlen($_POST['conf_senha']) > $maximo) {
        $msg1 = "Campo Confirmar Senha deve ter no maximo 16 digito.";

    }else
    {

        include("conexao.php");
        include('enviarEmail.php');

        $email = $conn->escape_string($_POST['email']);//$mysqli->escape_string SERVE PARA PROTEGER O ACESSO 
        $senha = $conn->escape_string($_POST['senha_atual']);
        $novaSenha = $conn->escape_string($_POST['nova_senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $sql_query =$conn->query($sql_code) or die("Falha na execução do código SQL: " . $conn->error);
        $usuario = $sql_query->fetch_assoc();
        $quantidade = $sql_query->num_rows;//retorna a quantidade encontrado
       
        if(($quantidade ) == 1) {

            if(password_verify($senha, $usuario['senha'])) {

                $_SESSION['usuario'] = $usuario['id'];
                $nome = $usuario['primeiro_nome'];
                $_SESSION['admin'] = $usuario['admin'];

                $nova_senha_criptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

                $sql_code = "UPDATE usuarios
                SET senha = '$nova_senha_criptografada'
                WHERE email = '$email'";

                $editado = $conn->query($sql_code) or die($conn->error);

                if($editado) {   
                    $msg2 = "Nova senha definida com sucesso. Você será redirecionado para a tele de login.";
                    
                    enviar_email($email, "Sua nova senha de acesso da plataforma", "
                    <h1>Seja bem vindo " . $nome . "</h1>
                    <p><b>Seu E-mail de acesso é: </b> $email</p>
                    <p><b>Sua senha de acesso é: </b> $novaSenha</p>
                    <p><b>Para redefinir sua senha </b><a href='redefinir_senha.php'>clique aqui.</a></p>
                    <p><b>Para entrar </b><a href='../../index.php'>clique aqui.</a></p>");
                    
                    unset($_POST);

                    header("refresh: 5; paginas/usuarios/inicio_usuario/usuario_logout.php");
                }
                    
            }else{
            $msg1 = "Senha inválida!";
            }
        }else{
            $msg1 = "O e-mail informado não esta correto ou não está cadastrado!";
        }
    }      
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />    
    <title>redefinição de senha</title>
    <script>
        function toggleSenha_atual() {
            var senha = document.getElementById('senha_atual');
            var toggleSenha = document.getElementById('toggleSenha');

            if (senha.type === 'password') {
                senha.type = 'text';
                toggleSenha.textContent = 'visibility';
            } else {
                senha.type = 'password';
                toggleSenha.textContent = 'visibility_off';
            }
        }
        function toggleNova_senha() {
            var nova_senha = document.getElementById('nova_senha');
            var toggleNova_Senha = document.getElementById('toggleNova_Senha');

            if (nova_senha.type === 'password') {
                nova_senha.type = 'text';
                toggleNova_Senha.textContent = 'visibility';
            } else {
                nova_senha.type = 'password';
                toggleNova_Senha.textContent = 'visibility_off';
            }
        }

        function toggleConf_senha() {
            var conf_senha = document.getElementById('conf_senha');
            var toggleConf_Senha = document.getElementById('toggleConf_Senha');

            if (conf_senha.type === 'password') {
                conf_senha.type = 'text';
                toggleConf_Senha.textContent = 'visibility';
            } else {
                conf_senha.type = 'password';
                toggleConf_Senha.textContent = 'visibility_off';
            }
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        form {
            max-width: 400px;
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
        .dados {
            display: flex;
            align-items: center;
        }
        label {
            flex: 0 0 auto; /* A label não será flexível e manterá seu tamanho natural */
            margin-right: 0px; /* Espaço entre a label e o input */
            word-break: break-word; /* Permite que a label quebre a linha se necessário */
        }

        input {
            flex: 1; /* O input será flexível e ocupará o espaço restante disponível */
            min-width: 100px; /* Define uma largura mínima para o input */
            width: 95%;
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            text-align: left;
            display: flex;
            margin-left: 15px;
        }
        input:focus {
            outline: none; /* Remove o contorno ao focar no botão */
        }

        input {
            flex: 1; /* O input será flexível e ocupará o espaço restante disponível */
            min-width: 100px; /* Define uma largura mínima para o input */
            width: 95%;
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            text-align: left;
            display: flex;
            margin-left: 15px;
        }
        input:focus {
            outline: none; /* Remove o contorno ao focar no botão */
        }
        .material-symbols-outlined {
            margin-top: -25px;
            margin-left: 10px;
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
            transform: translateY(5px); /* Ajuste o valor conforme necessário */
        }
        .material-symbols-outlined:hover {
            cursor: pointer;
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
</head>
<body>
    
    <form action="" method="POST">
        <h3>Redefina sua nova Senha</h3>

        <span id="msg1"><?php echo $msg1; ?></span>
        <span id="msg2"><?php echo $msg2; ?></span>

        <p class="dados">
            <label for="">E-mail: </label>
            <input value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required type="text" name="email">
        </p>
        <p class="dados">
            <label for="senha_atual">Senha Atual: </label>
            <input required type="password" name="senha_atual" id="senha_atual" value="<?php if(isset($_POST['senhaAtual'])) echo $_POST['senhaAtual']; ?>">
            <span id="toggleSenha" class="material-symbols-outlined" onclick="toggleSenha_atual()">visibility_off</span>
        </p>
        <p class="dados">
            <label for="nova_senha">Nova Senha: </label>
            <input required placeholder="Minimo 8 digitos" type="password" id="nova_senha" name="nova_senha" value="<?php if(isset($_POST['novaSenha'])) echo $_POST['novaSenha']; ?>">
            <span id="toggleNova_Senha" class="material-symbols-outlined" onclick="toggleNova_senha()">visibility_off</span>
        </p>
        <p class="dados">
            <label for="conf_senha">Confirmar Senha: </label>
            <input required placeholder="Minimo 8 digitos" type="password" id="conf_senha" name="conf_senha" value="<?php if(isset($_POST['confSenha'])) echo $_POST['confSenha']; ?>">
            <span id="toggleConf_Senha" class="material-symbols-outlined" onclick="toggleConf_senha()">visibility_off</span>
        </p>
        <a href="paginas/usuarios/usuario_logout.php">Ir para login</a>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>