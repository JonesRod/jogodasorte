<?php 

    include('../../../../../conexao.php');

    if(!isset($_SESSION)){
        session_start(); 

        if(isset($_SESSION['usuario'])){

            if (isset($_POST["tipoLogin"])) {
                $usuario_sessao = $_SESSION['usuario'];
                $valorSelecionado = $_POST["tipoLogin"];
                $admin = $valorSelecionado;

                if($admin != 1){
                    header("Location: ../../../usuarios/usuario_home.php");      
                } else {
                    $_SESSION['usuario'];
                    $_SESSION['admin'];  
                }
            }  

        } else {
            session_unset();
            session_destroy(); 
            header("Location: ../../../../../../index.php");  
        }
    } else {
        if(isset($_SESSION['usuario'])){

            if (isset($_POST["tipoLogin"])) {
                $usuario_sessao = $_SESSION['usuario'];
                $valorSelecionado = $_POST["tipoLogin"];
                $admin = $valorSelecionado;

                if($admin != 1){
                    header("Location: ../../../usuarios/usuario_home.php");      
                } else {
                    $_SESSION['usuario'];
                    $_SESSION['admin'];  
                }
            }  

        } else {
            session_unset();
            session_destroy(); 
            header("Location: ../../../../../../index.php");  
        }
 
    }

    $msg1= false;
    $msg2= false;

    if(isset($_POST['senha'])) {
        
        $senha_usuario = $conn->escape_string($_POST['senha']);
        
        if(strlen($_POST['senha']) == 0 ) {
            $msg1= true;
            $msg2= true;
            $msg1 = "";
            $msg2 = "Preencha sua senha.";
        } else {

            $sql_code = "SELECT * FROM usuarios WHERE admin = '1'";
            $sql_query =$conn->query($sql_code) or die("Falha na execução do código SQL: " . $conn->error);
            $usuario_sessao = $sql_query->fetch_assoc();
            $quantidade = $sql_query->num_rows;//retorna a quantidade encontrado

            if(($quantidade ) >= 1) {

                if(password_verify($senha_usuario, $usuario_sessao['senha'])) {
                
                    //pega os Nomes dos dados de acesso do banco
                    $localhost = $conn->real_escape_string($host);
                    $usuario_log = $conn->real_escape_string($usuario);
                    $senha_log = $conn->real_escape_string($senha);
                    $database = $conn->real_escape_string($banco);

                    $conn = new mysqli($localhost, $usuario_log, $senha_log, $database);

                    if ($conn->connect_error) {
                        die("Falha na conexão: " . $conn->connect_error);
                    }

                    $backupFile = 'backup_lotofacil_' . date('Y-m-d') . '.sql';
                    $database = $conn->real_escape_string($banco);

                    // Defina o caminho para o mysqldump (escolha um dos dois caminhos disponíveis)
                    $mysqldump_path = 'C:\xampp\mysql\bin\mysqldump.exe';
                    //$mysqldump_path = 'C:\Program Files\MySQL\MySQL Server 8.1\bin\mysqldump.exe';
                    
                    // Defina o caminho e nome do arquivo de backup
                    $backupFile = 'backup/backup_lotofacil_' . date('Y-m-d') . '.sql';
                    
                    // Comando para realizar o backup
                    $commandBackup = "$mysqldump_path --user=$usuario_log --password=$senha_log --host=$localhost $database > $backupFile";
                    
                    // Executa o comando de backup
                    exec($commandBackup, $output, $return);
                    
                    if ($return === 0) {
                        // Chame a função JavaScript para iniciar a contagem regressiva
                        $msg1 = "Backup realizado com sucesso.";
                        $msg2 = '<script>atualizarContagem(5);</script>';
                        //header("refresh: 5;../config_lotofacil.php"); 
                        
                    } else {
                        // Chame a função JavaScript para iniciar a contagem regressiva
                        $msg1 = '<script>atualizarContagem(5);</script>';
                        $msg2 = "Erro ao realizar o backup.";
                        //header("refresh: 5;../config_lotofacil.php"); 
                            
                    }
                    //die();  

                }else{
                    $msg1 = "";
                    $msg2 = "Senaha inválida!";   
                    //echo $msg;
                }
            }else{
                $msg = "";  
                //echo 'oii';
                // Fecha a conexão
                $mysqli->close();
            }
        }
    } 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Resetar Lotofácil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        #iform {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /*sombra*/

        }

        #ititulo {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        #msg1 {
            color: green;
        }

        #msg2 {
            color: red;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            text-align: left;
            margin-left: 15px;
        }

        #senha{
            width: 85%;
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            text-align: left;
            display: block;
            margin-left: 15px;
        }

        #senhaInputContainer {
            position: relative;
        }

        #toggleSenha {
            position: absolute;
            right: 0px;
            top: 75%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }
        #contador{
            color: blue;
        }
    </style>
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
        function atualizarPagina() {
            location.reload(); // Recarrega a página
        }
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
                window.location.href = '../config_lotofacil.php';
            }
        }
    </script>
</head>
<body>
    <form id ="iform" action="" method="POST" >
        <h1 id="ititulo">Confirmação para Backup</h1>
        <span id="contador"></span>
        <span id="msg1"><?php echo $msg1; ?></span>
        <span id="msg2"><?php echo $msg2; ?></span>
        <p>
            <div id="senhaInputContainer">
                <label for="">Senha do admin: </label>
                <input required placeholder="Senha" id="senha" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" type="password" name="senha">
                <span id="toggleSenha" class="material-symbols-outlined" onclick="toggleSenha()">visibility_off</span>
            </div>
        </p>
        <p>
            <button type="submit">Fazer Backup</button>
        </p>
    </form>
    <a href="../config_lotofacil.php"  style="margin-left: 10px; margin-right: 10px;">Voltar</a>
</body>
</html>