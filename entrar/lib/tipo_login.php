<?php
    include('conexao.php');

    if(!isset($_SESSION)){
        session_start();

        if(isset($_SESSION['usuario'])){
            $usuario = $_SESSION['usuario'];
            $admin = $_SESSION['admin'];  
            
            if($admin == 0){
                $_SESSION['usuario'];
                header("Location: paginas/usuarios/inicio_usuario/usuario_home.php"); 

            }else if($admin == 1){
                $usuario = $_SESSION['usuario'];
                $admin = $_SESSION['admin'];
                $_SESSION['usuario'];
                $_SESSION['admin']; 

                $id = $_SESSION['usuario'];
                $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
                $usuario = $sql_query->fetch_assoc(); 
                //header("Location: paginas/administrativo/admin_home.php");     
            }else{
                session_unset();
                session_destroy();
                header("Location: ../../../../index.php"); 
            }
        }else{
            // Destruir todas as variáveis de sessão
            session_unset();
            session_destroy();
            header("Location: ../../index.php");  
        }
    }else{
        if(isset($_SESSION['usuario'])){
            $usuario = $_SESSION['usuario'];
            $admin = $_SESSION['admin'];  
            
            if($admin == 0){
                $_SESSION['usuario'];
                header("Location: paginas/usuarios/inicio_usuario/usuario_home.php"); 

            }else if($admin == 1){
                $usuario = $_SESSION['usuario'];
                $admin = $_SESSION['admin'];
                $_SESSION['usuario'];
                $_SESSION['admin']; 

                $id = $_SESSION['usuario'];
                $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
                $usuario = $sql_query->fetch_assoc(); 
                //header("Location: paginas/administrativo/admin_home.php");     
            }else{
                session_unset();
                session_destroy();
                header("Location: ../../../../index.php"); 
            }
        }else{
            // Destruir todas as variáveis de sessão
            session_unset();
            session_destroy();
            header("Location: ../../index.php");  
        } 
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            text-align: center;
        }
        main{
            margin-top: 10%;
           /* margin-left: 40%;*/
        }
    </style>
    <title>Login</title>
</head>
<body>
    <main>
        <h2>Olá, <?php echo $usuario['primeiro_nome']; ?></h2>
        <h3>Escolha o tipo de login:</h3>
        <form id="escolherLoginForm" method="POST" action="paginas/administrativo/inicio_admin/admin_home.php" onsubmit="return resposta()">
            <label>
                <input type="radio" name="tipoLogin" value="1"> Admin
            </label>
            <label>
                <input type="radio" name="tipoLogin" value="0"> Usuário
            </label>
            <a id="resposta" href="outra-pagina.html" type="hidden"></a>

            <button type="submit" onclick="responder()">Logar</button><!---->
        </form>

    </main>
    <script>
        function responder() {
            var escolha = document.querySelector('input[name="tipoLogin"]:checked').value;
            //console.log(escolha);
            if (escolha === "1") {
                document.getElementById("resposta").href="paginas/administrativo/inicio_admin/admin_home.php";
                document.getElementById("resposta").click();
            } else if (escolha === "0") {
                document.getElementById("resposta").href="paginas/usuarios/inicio_usuario/usuario_home.php";
                document.getElementById("resposta").click();
            }
        }
        
        function resposta() {
            var radioSelecionado = document.querySelector('input[name="tipoLogin"]:checked');

            if (!radioSelecionado) {
                alert("Selecione uma opção antes de enviar o formulário.");
                return false; // Impede o envio do formulário
            }
            return true; // Permite o envio do formulário
        }

    </script>
</body>
</html>

