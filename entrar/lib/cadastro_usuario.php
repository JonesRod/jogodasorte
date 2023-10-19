<?php

    $msg1= false;
    $msg2= false;
    $minimo = 8;
    $maximo = 16;

    if(isset($_POST['confSenha']) || isset($_POST['email'])) {

        include('conexao.php');
        include('enviarEmail.php');

        $nome = $conn->escape_string($_POST['primeiro_nome']);
        $nome_completo = $conn->escape_string($_POST['nome_completo']);
        $nascimento = $conn->escape_string($_POST['nascimento']);
        $email = $conn->escape_string($_POST['email']);
        $senha1 = $conn->escape_string($_POST['senha']);
        $senha2 = $conn->escape_string($_POST['confSenha']);

        $hoje = new DateTime('now');
        $dataStr = $nascimento;
        $dataFormatada = DateTime::createFromFormat('d/m/Y', $dataStr);
        
        $nasc = $dataFormatada->format('Y-m-d');
        $idade = $hoje->diff($dataFormatada)->y;
        
        if(strlen($senha1) < $minimo ) {
            $msg1 = '';
            $msg2 = "Senha deve ter no minimo 8 digito.";
        }else if(strlen($senha1) > $maximo ) {
            $msg1 = '';
            $msg2 = "Senha deve ter no maximo 16 digito.";
        }else if(strlen($senha2) < $minimo) {
            $msg1 = '';
            $msg2 = "Campo Confirmar Senha deve ter no minimo 8 digito.";
        }else if(strlen($senha2) > $maximo) {
            $msg1 = '';
            $msg2 = "Campo Confirmar Senha deve ter no maximo 16 digito.";
        }else if($senha1 != $senha2){
            $msg1 = '';
            $msg2 = "As senhas estam diferentes!";
        }else if($idade < 18 ){
            $msg1 = '';
            $msg2 = "Você precisa ter no minimo 18 anos para abrir uma conta!";
        }else{  

            $sql_query = $conn->query("SELECT * FROM usuarios WHERE email = '$email'");
            $result = $sql_query->fetch_assoc();
            $registro = $sql_query->num_rows;

            if(($registro ) == 0) {

                $senha = $_POST['confSenha'];
                $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

                $sql_primeiro_registro = "SELECT * FROM usuarios";
                $totalregistros = $conn->query($sql_primeiro_registro) or die("Falha na execução do código SQL: " . $conn->error);
        
                // Verifica se existem registros na tabela 'socios'
                if ($totalregistros->num_rows == 0) {

                    $sql_usuario = "INSERT INTO usuarios (data, admin, primeiro_nome, nome_completo, data_nascimento, email, senha) 
                    VALUES(NOW(), '1', '$nome', '$nome_completo', '$nasc', '$email','$senha_criptografada')";
                    $conn->query($sql_usuario) or die($conn->error);

                    // Obtém o ID do último registro inserido
                    $id_admin = $conn->insert_id; 
                
                    // Agora, você pode usar $id_socio como necessário
                    // Por exemplo, para salvar o ID do admin
                    $sql_config_admin = "INSERT INTO config_admin (id, id_admin, data_alteracao, primeiro_nome, email)
                    VALUES('1', '$id_admin',NOW(), '$nome', '$email')";
                    $conn->query($sql_config_admin) or die($conn->error);

                    $sql_historico_config_admin = "INSERT INTO historico_config_admin (id_admin, data_alteracao, primeiro_nome, email)
                    VALUES('$id_admin',NOW(), '$nome','$email')";
                    $deu_certo = $conn->query($sql_historico_config_admin) or die($conn->error);

                    if($deu_certo){

                        enviar_email($email, "Registro de Cadastros.", "
                        <h1>Olá Sr. " . $nome . "</h1>
                        <p>Seja bem vindo!</p>
                        <p>Boa Sorte.</p>");

                        unset($_POST);
                        $msg1 = "Cadastrado com sucesso.";
                        $msg2 = '';
                        //Atualiza a pagina em 5s e redireciona apagina
                        header("refresh: 5; ../../index.php"); 
                    } else {
                        // Se houver um erro na consulta
                        die($conn->error); 
                    }
                }else{
                    $senha = $_POST['confSenha'];
                    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);
                        
                    $sql_usuario = "INSERT INTO usuarios (data, primeiro_nome, nome_completo, data_nascimento, email, senha) 
                    VALUES(NOW(), '$nome', '$nome_completo', '$nasc', '$email','$senha_criptografada')";
                    $deu_certo = $conn->query($sql_usuario) or die($conn->error);

                    if($deu_certo){

                        enviar_email($email, "Registro de Cadastros.", "
                        <h1>Olá Sr. " . $nome . "</h1>
                        <p>Seja bem vindo!</p>
                        <p>Boa Sorte.</p>");

                        unset($_POST);
                        $msg1 = "Cadastrado com sucesso.";
                        $msg2 = '';
                        //Atualiza a pagina em 5s e redireciona apagina
                        header("refresh: 5; ../../index.php"); 
                    } else {
                        // Se houver um erro na consulta
                        die($conn->error); 
                    }
                }


            }else if(($registro ) != 0) {
                $msg1 = '';
                $msg2 = "Já existe um Usuario cadastrado com esse E-mail!";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro.css">

    <script>
        function toggleSenha1() {
            var senhaInput1 = document.getElementById('senhaInput1');
            var toggleSenha2 = document.getElementById('toggleSenha1');

            if (senhaInput1.type === 'password') {
                senhaInput1.type = 'text';
                toggleSenha1.textContent = '👁️';
            } else {
                senhaInput1.type = 'password';
                toggleSenha1.textContent = '👁️';
            }
        }
        function toggleSenha2() {
            var senhaInput2 = document.getElementById('senhaInput2');
            var toggleSenha2 = document.getElementById('toggleSenha2');

            if (senhaInput2.type === 'password') {
                senhaInput2.type = 'text';
                toggleSenha2.textContent = '👁️';
            } else {
                senhaInput2.type = 'password';
                toggleSenha2.textContent = '👁️';
            }
        }
    </script>
    <title>Cadastro de Usuario</title>
</head>
<body>
    <form id="login" method="POST" action="" onsubmit="return validarFormulario()">
        <h1>Cadastre-se</h1>
        <span style="color: green;"><?php echo $msg1; ?></span>
        <span style="color: red;"><?php echo $msg2; ?></span>

        <p>
            <label for="primeiro_nome">Primeiro Nome:</label>
            <input required id="primeiro_nome" placeholder="Primeiro Nome" value="<?php if(isset($_POST['primeiro_nome'])) echo $_POST['primeiro_nome']; ?>" name="primeiro_nome" type="text"><br>
        </p>
        <p>
            <label for="nome_completo">Nome Completo:</label>
            <input required id="nome_completo" placeholder="Nome Completo" value="<?php if(isset($_POST['nome_completo'])) echo $_POST['nome_completo']; ?>" name="nome_completo" type="text"><br>
        </p>
        <p>
            <label for="nascimento">Data de Nascimento:</label>
            <input required id="nascimento" placeholder="00/00/0000" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" 
            name="nascimento" type="text" oninput="formatarData(this)" onblur="verificaData()"><br>
        </p>
        <p>
            <label for="email">E-mail:</label>
            <input required id="email" placeholder="E-mail" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email" type="email"><br>
        </p>
        <p>
            <div id="senhaInputContainer">
                <label for="">Senha: </label>
                <input required placeholder="Minimo 8 digitos" id="senhaInput1" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" type="password" name="senha">
                <span id="toggleSenha1" onclick="toggleSenha1()">👁️</span>

                <label for="">Confirmar Senha: </label>
                <input placeholder="Minimo 8 digitos" id="senhaInput2" value="<?php if(isset($_POST['confSenha'])) echo $_POST['confSenha']; ?>" type="password" name="confSenha">
                <span id="toggleSenha2" onclick="toggleSenha2()">👁️</span>
            </div>
        </p>
        <p>
            <a href="../../index.php">Voltar para tela de login</a>
            <button type="submit">Cadastrar</button>
        </p>
    </form>
    <script src="verifica_dados.js"></script>
</body>
</html> 
