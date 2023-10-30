<?php
    include('../../../../conexao.php');

    session_start();

    if (isset($_SESSION['usuario'])) {

        $id = $_SESSION['usuario'];
        $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
        $usuario = $sql_query->fetch_assoc();

        $id = '1';
        $sql_config = $conn->query("SELECT * FROM config_admin WHERE id = '$id'") or die($conn->error);
        $dados = $sql_config->fetch_assoc();
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body h2{
            text-align: center;
        }
        body form{
            text-align: center;
            border: 1px solid black;
            width: 95%;
            /*position: absolute;*/
            /*top: 50%;
            left: 50%;
            /*transform: translate(-50%, -50%);*/
            padding: 15px;
        }
        img{
            width: 50%;
            /*text-align: center;*/
            border-radius: 10px;
        }
        form label{
            margin: 10px;
            /*padding: 50px;*/
        }
        /*form label,*/
        form input {
            margin-bottom: 10px;
            max-width: 50%;
        }
        form .dados label {
            display: inline-block;
            width: 100%; /* Faz a label ocupar 100% da largura do contêiner pai */
            max-width: 20%; /* Define a largura máxima desejada */
            box-sizing: border-box; /* Inclui a largura da borda e o preenchimento na largura total */
        }
        form .dados input {
            width: 50%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form .dados select {
            width: 25%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form .endereco label {
            display: inline-block;
            width: 100%; /* Faz a label ocupar 100% da largura do contêiner pai */
            max-width: 20%; /* Define a largura máxima desejada */
            box-sizing: border-box; /* Inclui a largura da borda e o preenchimento na largura total */
        }
        form .endereco input {
            width: 50%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form .endereco select {
            width: 25%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form .contatos label {
            display: inline-block;
            width: 100%; /* Faz a label ocupar 100% da largura do contêiner pai */
            max-width: 20%; /* Define a largura máxima desejada */
            box-sizing: border-box; /* Inclui a largura da borda e o preenchimento na largura total */
        }
        form .contatos input {
            width: 50%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input{
            margin: 5px;
        }
        textarea {
            width: 95%; /* Define a largura do textarea */
            height: 150px; /* Define a altura do textarea */
            padding: 10px; /* Adiciona preenchimento interno */
            font-size: 16px; /* Define o tamanho da fonte */
            border: 1px solid #ccc; /* Adiciona uma borda de 1 pixel sólida com cor cinza */
            border-radius: 5px; /* Adiciona bordas arredondadas */
            background-color: #f8f8f8; /* Define a cor de fundo */
            color: #333; /* Define a cor do texto */
        }

        textarea:focus {
            outline: none; /* Remove a borda de foco padrão */
            border-color: #007bff; /* Define a cor da borda quando em foco */
        }
        /* Estilize o container do rádio */
        input[type="radio"]{
            
            margin-bottom: 0px;
            margin: 0;
        }
        label .radio{
            margin-left: 0px;
        }
        a{
            margin-left: 100px; 
            margin-right: 40px;
        }
    </style>
    <title>Meu Perfil</title>
</head>
<body>
    <form id="form" action="alterar_dados_perfil.php" method="POST" enctype="multipart/form-data" autocomplete="on" onsubmit="return validateForm()">
        
        <input id="" value="<?php echo $usuario['id']; ?>" name="id" type="hidden">
        <input required id="primeiro_nome" value="<?php echo $usuario['primeiro_nome']; ?>" name="primeiro_nome" type="hidden"><br>           
        <p>
            <label for="fantazia" >Nome Fantazia: </label>
            <input required id="fantazia" value="<?php echo $fantazia; ?>" name="fantazia" type="text"><br>
        </p>
        <p>
            <label for="razao" >Razão: </label>
            <input required id="razao" value="<?php echo $razao; ?>" name="razao" type="text"><br>
        </p>
        <p>
            <label for="cnpj" >CNPJ: </label>
            <input required id="cnpj" value="<?php echo $dados['cnpj']; ?>" name="cnpj" type="text" oninput="formatcnpj(this)" onblur="verificacnpj()"><br>
        </p>
        <p> 
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

                    $ufSelecionada = $dados['uf'];

                    echo '<option value="' . $ufSelecionada . '">' . $estados[$ufSelecionada] . '</option>';

                    foreach ($estados as $uf => $estado) {
                        if ($uf !== $ufSelecionada) {
                            echo '<option value="' . $uf . '">' . $estado . '</option>';
                        }
                    }           
                ?>

            </select>
        </p>
        <p>
            <label id="" for="cep">CEP: </label><br>
            <input required value="<?php echo $dados['cep']; ?>" name="cep" id="cep" type="text" maxlength="9" oninput="formatarCEP(this)" onblur="fetchCityByCEP()"><br>
        </p>
        <p>
            <label id="" for="cidade">Cidade Atual: </label><br>
            <input required value="<?php echo $dados['cidade']; ?>" name="cidade" id="cidade" type="text"><br>
        </p>
        <p>
            <label id="" for="celular">Celular: </label><br>
            <input required value="<?php echo $dados['celular']; ?>" name="celular" id="celular" type="text" placeholder="(00) 00000-0000" size="" oninput="formatarCelular(this)" onblur="verificaCelular()"><br>
        </p>
        <p>
            <label id="" for="email">E-mail:</label><br>
            <input required value="<?php echo $dados['email']; ?>" name="email" id="email" type="email"><br>
        </p>
        <p>
            <span id="msg"></span><br>
            <span id="msg2" type="hidden"></span><br>
            <a href="inicio.php" style="margin-left: 10px; margin-right: 10px;">Voltar</a><a href="../../redefinir_senha.php" style="margin-left: 10px; margin-right: 10px;">Redefinir Senha</a>
            <button id="" type="submit" style="margin-left: 10px;">Salvar</button>
        </p>
        <script src="perfil_verifica_dados.js"></script>
    </form>
</body>
</html>
