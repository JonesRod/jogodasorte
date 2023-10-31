<?php
    //codigo da sessão
    include('../../../conexao.php');

    if(!isset($_SESSION))
        session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location: ../../../../../index.php");
    }
    if(isset($_SESSION['email'])){

        $email = $_SESSION['email'];
        $senha = password_hash($_SESSION['senha'], PASSWORD_DEFAULT);
        $conn->query("INSERT INTO senha (email, senha) VALUES('$email','$senha')");
    
    }
    
    $id = $_SESSION['usuario'];
    $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
    $usuario = $sql_query->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        #form {
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
            margin-bottom: 20px;
        }
        #msg {
            color:red;
        }
        #msg1 {
            color: blue;
        }
        #msg2 {
            color: blue;
        }
        #msg2 h3{
            color: #333;
        }
        .dados {
            display: flex;
            align-items: center;
        }

        .dados label {
            flex: 0 0 auto; /* A label não será flexível e manterá seu tamanho natural */
            margin-right: 10px; /* Espaço entre a label e o input */
        }

        .dados input {
            flex: 1; /* O input será flexível e ocupará o espaço restante disponível */
        }
        #msg2 label{
            color: #333;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            margin-bottom: 5px;
            text-align: left;
            margin-left: 15px;
        }

        input{
            width: 85%;
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
            outline: none; /* Remove a borda de foco padrão */
        }
        select{
            width: 85%;
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            text-align: left;
            display: flex;
            margin-left: 15px;
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
    <title>Meu Perfil</title>
</head>
<body>
    <form id="form" action="alterar_dados_perfil.php" method="POST" enctype="multipart/form-data" autocomplete="on" onsubmit="return validateForm()">
        <h3>Meus Dados</h3>
        <input id="" value="<?php echo $usuario['id']; ?>" name="id" type="hidden">

        <p class="dados">
            <label for="primeiro_nome" >Primeiro nome ou Apelido: </label>
            <input required id="primeiro_nome" value="<?php echo $usuario['primeiro_nome']; ?>" name="primeiro_nome" type="text"><br>
        </p>            
        <p class="dados">
            <label for="nome_completo" >Nome Completo: </label>
            <input required id="nome_completo" value="<?php echo $usuario['nome_completo']; ?>" name="nome_completo" type="text"><br>
        </p>
        <p class="dados">
            <label for="cpf" >CPF: </label>
            <input required id="cpf" value="<?php echo $usuario['cpf']; ?>" name="cpf" type="text" oninput="formatCPF(this)" onblur="verificaCpf()"><br>
        </p>
        <p class="dados">
            <label for="nascimento" >Data de Nascimento: </label>
            <?php
                // Suponha que $usuario seja um array contendo os dados do banco de dados, incluindo o campo "data_nascimento"
                $dataNascimento = $usuario['data_nascimento'];

                // Formate a data para o formato brasileiro (dd/mm/yyyy)
                $dataNascimentoFormatada = date('d/m/Y', strtotime($dataNascimento));
            ?>
            <input required id="nascimento" value="<?php echo $dataNascimentoFormatada; ?>" name="nascimento" type="text"  oninput="formatarData(this)" onblur="validarData()"><br>
        </p>
        <p class="dados"> 
            <label for="uf">Estado Atual: </label>
            <select required name="uf" id="uf" value="">
                <?php
                    $estados = array(
                    'AC' => 'Acre',
                    'AL' => 'Alagoas',
                    'AP' => 'Amapá',
                    'AM' => 'Amazonas',
                    'BA' => 'Bahia',
                    'CE' => 'Ceará' ,
                    'DF' => 'Distrito Federal',
                    'ES' => 'Espírito Santo',
                    'GO' => 'Goiás',
                    'MA' => 'Maranhão',
                    'MS' => 'Mato Grosso do Sul',
                    'MT' => 'Mato Grosso',
                    'MG' => 'Minas Gerais',
                    'PA' => 'Pará',
                    'PB' => 'Paraíba',
                    'PR' => 'Paraná',
                    'PE' => 'Pernambuco',
                    'PI' => 'Piauí',
                    'RJ' => 'Rio de Janeiro',
                    'RN' => 'Rio Grande do Norte',
                    'RS' => 'Rio Grande do Sul',
                    'RO' => 'Rondônia',
                    'RR' => 'Roraima',
                    'SC' => 'Santa Catarina',
                    'SP' => 'São Paulo',
                    'SE' => 'Sergipe',
                    'TO' => 'Tocantins'
                    );

                    $ufSelecionada = $usuario['uf'];

                    echo '<option value="' . $ufSelecionada . '">' . $estados[$ufSelecionada] . '</option>';

                    foreach ($estados as $uf => $estado) {
                        if ($uf !== $ufSelecionada) {
                            echo '<option value="' . $uf . '">' . $estado . '</option>';
                        }
                    }           
                ?>

            <!-- Adicione mais opções para outros estados aqui -->
            </select>
        </p>
        <p class="dados">
            <label id="" for="cep">CEP: </label><br>
            <input required value="<?php echo $usuario['cep']; ?>" name="cep" id="cep" type="text" maxlength="9" oninput="formatarCEP(this)" onblur="fetchCityByCEP()"><br>
        </p>
        <p class="dados">
            <label id="" for="cidade">Cidade Atual: </label><br>
            <input required value="<?php echo $usuario['cidade']; ?>" name="cidade" id="cidade" type="text"><br>
        </p>
        <p class="dados">
            <label id="" for="celular">Celular: </label><br>
            <input required value="<?php echo $usuario['celular']; ?>" name="celular" id="celular" type="text" placeholder="(00) 00000-0000" size="" oninput="formatarCelular(this)" onblur="verificaCelular()"><br>
        </p>
        <p class="dados">
            <label id="" for="email">E-mail:</label><br>
            <input required value="<?php echo $usuario['email']; ?>" name="email" id="email" type="email"><br>
        </p>
        <p class="dados">
            <span id="msg"></span><br>
            <span id="msg2" type="hidden"></span><br>
            <a href="inicio.php" style="margin-left: 10px; margin-right: 10px;">Voltar</a><a href="../../redefinir_senha.php" style="margin-left: 10px; margin-right: 10px;">Redefinir Senha</a>
            <button id="" type="submit" style="margin-left: 10px;">Salvar</button>
        </p>
        <script src="perfil_verifica_dados.js"></script>
    </form>
</body>
</html>

