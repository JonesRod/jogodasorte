<?php 

    include('../../../../conexao.php');

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
            header("Location: ../../inicio_admin/admin_logout.php");  
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
            header("Location: ../../inicio_admin/admin_logout.php");  
        }
 
    }

    $msg1= false;
    $msg2= false;

    if(isset($_POST['excluir_dados'])) {
        
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

                    // Defina as credenciais do banco de dados
                    //$host = "localhost";
                    //$usuario = "root";
                    //$senha = "";
                    //$banco = "associacao_40ribas";

                    $conn = new mysqli($localhost, $usuario_log, $senha_log, $database);

                    if ($conn->connect_error) {
                        die("Falha na conexão: " . $conn->connect_error);
                    }

                    $backupFile = 'backup_' . date('Y-m-d') . '.sql';
                    $database = $conn->real_escape_string($banco);

                    //var_dump($usuario);
                    //var_dump($senha);
                    //var_dump($host);
                    //var_dump($database);
                    //var_dump($backupFile); 

                    // Defina o caminho para o mysqldump (escolha um dos dois caminhos disponíveis)
                    $mysqldump_path = 'C:\xampp\mysql\bin\mysqldump.exe';
                    //$mysqldump_path = 'C:\Program Files\MySQL\MySQL Server 8.1\bin\mysqldump.exe';
                    
                    // Defina o caminho e nome do arquivo de backup
                    $backupFile = 'backup/backup_' . date('Y-m-d') . '.sql';
                    
                    // Comando para realizar o backup
                    $commandBackup = "$mysqldump_path --user=$usuario_log --password=$senha_log --host=$localhost $database > $backupFile";
                    
                    // Executa o comando de backup
                    exec($commandBackup, $output, $return);
                    
                    if ($return === 0) {
                        // Excluir todos os dados das tabelas
                        $tables = $conn->query("SHOW TABLES");

                        while ($row = $tables->fetch_row()) {
                            $table = $row[0];
                            $conn->query("DELETE FROM $table");
                            $conn->query("ALTER TABLE $table AUTO_INCREMENT = 1");
                        }

                        $msg1 = "Backup criado e todos os dados foram excluídos e os IDs foram reiniciados.";
                        $msg2 = "";                     
                        
                        // Encerrar sessão
                        session_unset();
                        session_destroy();

                        //header("refresh: 5;");  
                        echo '<script>
                                setTimeout(function() {
                                    location.reload();
                                }, 5000);
                            </script>';

                        //header("refresh: 5;../inicio.php"); 

                    } else {
                        $msg1 = ""; 
                        $msg2 = "Erro ao realizar o backup.";
                        header("refresh: 5;../../inicio_admin/admin_inicio.php"); 
                    }

                }else{
                    $msg1 = "";
                    $msg2 = "Senaha inválida!";   
                    //echo $msg;
                }
            }else{
                $msg = "";  
                //echo 'oii';
                // Fecha a conexão
                $conn->close();
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
    <link rel="stylesheet" href="deletar_dados.css">
    <title>Resetar Dados</title>
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
    <form id ="iform" action="" method="POST" >
        <h1 id="ititulo">Excluir todos os dados</h1>
        <p>
            Você realmente deseja excluir todos os dados armazenado?
        </p>
        <p>
            Caso click confirme: Os dados serão todos apagados.
        </p>
        <span id="msg1"><?php echo $msg1; ?></span>
        <span id="msg2"><?php echo $msg2; ?></span>
        <p>
            <div id="senhaInputContainer">
                <label for="">Senha do admin: </label>
                <input required placeholder="Minimo 8 digitos" id="senha" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" type="password" name="senha">
                <span id="toggleSenha" class="material-symbols-outlined" onclick="toggleSenha()">visibility_off</span>
            </div>
        </p>
        <p>
            <button type="submit" name="excluir_dados">Excluir Todos os Dados</button>
        </p>
    </form>
    <a href="../configuracoes/config.php"  style="margin-left: 10px; margin-right: 10px;">Voltar</a>
</body>
</html>