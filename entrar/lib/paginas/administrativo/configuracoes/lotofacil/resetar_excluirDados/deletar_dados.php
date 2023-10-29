<?php 

    include('../../../../../conexao.php');

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

                    $tabela = 'resultados_lotofacil';
                    // Caminho e nome do arquivo de backup
                    $arquivo_backup = 'backup/backup_concursos_lotofacil' . date('Y-m-d') . '.sql';
                    
                    // Verifica se existem dados na tabela
                    $verificar_query = "SELECT COUNT(*) as total FROM $tabela";
                    $result = $conn->query($verificar_query);
                    $row = $result->fetch_assoc();
                    $total_registros = $row['total'];

                    if ($total_registros > 0) {
                        
                        // Comando SQL para exportar a tabela
                        //$query = "SELECT * INTO OUTFILE '$arquivo_backup' FROM $tabela";
                        
                        //if ($conn->query($query) === TRUE) {
                            // Excluir todos os dados da tabela e resetar o AUTO_INCREMENT
                            $conn->query("DELETE FROM $tabela");
                            $conn->query("ALTER TABLE $tabela AUTO_INCREMENT = 1");
                        
                            $msg1 = "Backup da tabela $tabela realizado com sucesso e todos os concursos da Lotofacil foram excluídos.";
                            $msg2 = '<script>atualizarContagem(5);</script>';    
                            // Chame a função JavaScript para iniciar a contagem regressiva

                        /*} else {
                            $msg1 = '';
                            $msg2 = "Erro ao fazer o backup da tabela: " . $conn->error;
                        }*/
                    } else {
                        $msg1 = '';
                        $msg2 = "Não há dados na tabela $tabela para fazer backup.";
                    }
                }else{
                    $msg1 = "";
                    $msg2 = "Senaha inválida!";   
                    //echo $msg;
                }
            }else{
                $msg1 = "";  
                $msg2 = "";  
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
        <h1 id="ititulo">Excluir todos os Concursos</h1>
        <p>
            Você realmente deseja excluir todos os dados armazenado?
        </p>
        <p>
            Caso click confirme: Os dados serão todos apagados.
        </p>
        <span id="msg1"><?php echo $msg1; ?></span>
        <span id="msg2"><?php echo $msg2; ?></span>
        <span id="contador"></span>
        <p>
            <div id="senhaInputContainer">
                <label for="">Senha do admin: </label>
                <input required placeholder="Minimo 8 digitos" id="senha" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" type="password" name="senha">
                <span id="toggleSenha" class="material-symbols-outlined" onclick="toggleSenha()">visibility_off</span>
            </div>
        </p>
        <p>
            <button type="submit" name="excluir_dados">Excluir Todos os Concursos</button>
        </p>
    </form>
    <a href="../config_lotofacil.php"  style="margin-left: 10px; margin-right: 10px;">Voltar</a>
</body>
</html>