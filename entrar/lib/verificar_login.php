<?php
    include("entrar/lib/conexao.php");
    // Conexão com o banco de dados (substitua os valores com os seus dados)
    /*$servername = "seu_servidor";
    $username = "seu_usuario";
    $password = "sua_senha";
    $dbname = "seu_banco_de_dados";

    $conn = new mysqli($servername, $username, $password, $dbname);*/

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Login bem-sucedido!";
    } else {
        echo "Usuário ou senha inválidos. <a href='cadastro.php'>Crie uma conta</a>.";
    }

    $conn->close();
?>
