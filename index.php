<?php
    include("entrar/lib/conexao.php");

    if(!isset($_SESSION)) {
        session_start(); 
    }

    if(isset($_SESSION['usuario']) && isset($_SESSION['admin'])) {
        $usuario = $_SESSION['usuario'];
        $admin = $_SESSION['admin'];

        if($admin == 1 ){
            header("Location: entrar/lib/paginas/administrativo/admin_home.php");       
            exit(); // Importante adicionar exit() após o redirecionamento
        } else {
            header("Location: entrar/lib/paginas/usuarios/usuario_home.php");
            exit(); // Importante adicionar exit() após o redirecionamento
        }
    }
        
    $msg= false;

   if(isset($_POST['email']) || isset($_POST['senha'])) {

        $email = $conn->escape_string($_POST['email']);//$mysqli->escape_string SERVE PARA PROTEGER O ACESSO 
        $cpf = $conn->escape_string($_POST['email']);
        $senha = $conn->escape_string($_POST['senha']);
        var_dump($_POST);

        //echo "oii";
        /*if(isset($_SESSION['email']) || isset($_POST['senha'])){
            $email = $_SESSION['email'];
            $senha = password_hash($_SESSION['senha'], PASSWORD_DEFAULT);
            //$conn->query("INSERT INTO senha (email, senha, cpf) VALUES('$email','$senha','$cpf')");*/

            $verifica = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
            $sql_verifiva =$conn->query($verifica) or die("Falha na execução do código SQL: " . $conn->error);
            $usuario = $sql_verifiva->fetch_assoc();
            $quantidade = $sql_verifiva->num_rows;//retorna a quantidade encontrado

            if(($quantidade ) == 1) {

                if(password_verify($senha, $usuario['senha'])) {

                    $admin = $usuario['admin'];

                    if($admin == 1){
                        $_SESSION['usuario'] = $usuario['id'];
                        $_SESSION['admin'] = $admin;
                        //$msg = "1";
                        unset($_POST);
                        header("Location: entrar/lib/tipo_login.php");
                    }else if($admin != 1){
                        $_SESSION['usuario'] = $usuario['id'];
                        $_SESSION['admin'] = $admin;
                        //$msg = "2";
                        unset($_POST);
                        header("Location: entra/lib/paginas/usuarios/usuario_home.php");
                    }    
                }else{
                    $msg= true;
                    $msg = "Usúario ou Senha estão inválidos!";    
                    //echo $msg;
                }
            }else{
                $msg = "O Usúario informado não esta correto ou não está cadastrado!";
                $conn->close();
            }
        //}
    }
    //$mysqli->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />    <link rel="stylesheet" href="entrar/lib/css/index.css">
    <title>Tela de Login</title>
    <script>
        function toggleSenha() {
            var senhaInput = document.getElementById('senha');
            var toggleSenha = document.getElementById('toggleSenha');

            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                toggleSenha.textContent = 'visibility';
            } else {
                senhaInput.type = 'password';
                toggleSenha.textContent = 'visibility_off';
            }
        }
    </script>
    
</head>
<body>
    <div class="cabecalho">
        <div class="titulo">
            <h2>Jogo da Sorte</h2>
        </div> 
        <div class="login">
            <form action="" method="POST">
                <label>Login</label>
                <input class="email" id="email" type="email" name="email" placeholder="E-mail" required>
                <input class="senha" id="senha" type="password" name="senha" placeholder="Senha" required>
                <span id="toggleSenha" class="material-symbols-outlined" onclick="toggleSenha()">visibility_off</span>
                <button class="entrar" type="submit">Entrar</button>
            </form>
            <span><?php echo $msg; ?></span>
            <p>
                <a class="Esq-Cri" href="entrar/lib/Recupera_Senha.php">Esqueci minha Senha!</a> 
                <a class="Esq-Cri" href="entrar/lib/cadastro_usuario.php">Criar Conta.</a>
            </p>
        </div>
    </div>
    <div class="container">
        <div>
            <p>Istruções</p>
            <p>hhhh</p>
            <p>gggg</p>
        </div>
        <button>Lotofácil</button>
        <button>Mega Sena</button>
    </div>
</body>
</html>
