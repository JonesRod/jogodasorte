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
    <form id="iform" action="alterar_dados_perfil.php" method="POST" enctype="multipart/form-data" autocomplete="on" onsubmit="return validateForm()">
        
        <input id="" value="<?php echo $usuario['id']; ?>" name="id" type="hidden">
        <fieldset class="dados">
            <legend>Meus Dados</legend>
            <p>
                <label for="nome_completo" >Nome Completo: </label>
                <input required id="nome_completo" value="<?php echo $usuario['nome_completo']; ?>" name="nome_completo" type="text"><br>
            </p>
            <p>
                <label for="primeiro_nome" >Apelido: </label>
                <input required id="primeiro_nome" value="<?php echo $usuario['primeiro_nome']; ?>" name="primeiro_nome" type="text"><br>
            </p>
            <p>
                <label for="cpf" >CPF: </label>
                <input required id="cpf" value="<?php echo $usuario['cpf']; ?>" name="cpf" type="text" oninput="formatCPF(this)" onblur="verificaCpf()"><br>
            </p>
            <p>
                <label for="nascimento" >Data de Nascimento: </label>
                <?php
                    // Suponha que $usuario seja um array contendo os dados do banco de dados, incluindo o campo "data_nascimento"
                    $dataNascimento = $usuario['data_nascimento'];

                    // Formate a data para o formato brasileiro (dd/mm/yyyy)
                    $dataNascimentoFormatada = date('d/m/Y', strtotime($dataNascimento));
                ?>
                <input required id="nascimento" value="<?php echo $dataNascimentoFormatada; ?>" name="nascimento" type="text"  oninput="formatarData(this)" onblur="verificaData()"><br>
            </p>
        </fieldset>
        <fieldset class="sexo">
            <legend>Sexo</legend>
            <p>
                <?php
                    // Suponha que $usuario seja um array contendo os dados do banco de dados, incluindo o campo "sexo"
                    $sexoMasculino = ($usuario['sexo'] == 'MASCULINO') ? 'checked' : '';
                    $sexoFeminino = ($usuario['sexo'] == 'FEMININO') ? 'checked' : '';
                    $sexoOutro = ($usuario['sexo'] == 'OUTROS') ? 'checked' : '';
                ?>
                <input type="radio" name="sexo" id="masc" value="MASCULINO" <?php echo $sexoMasculino; ?>><label for="masc">Masculino</label> 
                <input type="radio" name="sexo" id="femi" value="FEMININO" <?php echo $sexoFeminino; ?>><label for="femi">Feminino</label> 
                <input type="radio" name="sexo" id="out" value="OUTROS" <?php echo $sexoOutro; ?>><label for="out">Outros</label>

            </p>
        </fieldset>
        <fieldset class="endereco">
            <legend>Região</legend>
            <p> 
                <label for="uf_atual">Estado Atual: </label>
                <select required name="uf_atual" id="uf_atual" value="">
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
            <p>
                <label id="" for="cep">CEP: </label><br>
                <input required value="<?php echo $usuario['cep']; ?>" name="cep" id="cep" type="text" maxlength="9" oninput="formatarCEP(this)" onblur="fetchCityByCEP()"><br>
            </p>
            <p>
                <label id="" for="cid_atual">Cidade Atual: </label><br>
                <input required value="<?php echo $usuario['cid_atual']; ?>" name="cid_atual" id="cid_atual" type="text"><br>
            </p>
        </fieldset>
        <fieldset class="contatos">
            <legend>Contatos</legend>
            <p>
                <label id="" for="celular1">Celular 1: </label><br>
                <input required value="<?php echo $usuario['celular1']; ?>" name="celular1" id="celular1" type="text" placeholder="(00) 00000-0000" size="" oninput="formatarCelular1(this)" onblur="verificaCelular1()"><br>
            </p>
            <p>
                <label id="" for="celular2">Celular 2: Opcional </label><br>
                <input value="<?php echo $usuario['celular2']; ?>" name="celular2" id="celular2" type="text" placeholder="(00) 00000-0000" size="" oninput="formatarCelular2(this)" onblur="verificaCelular2()"><br>
            </p>
            <p>
                <label id="" for="email">E-mail:</label><br>
                <input required value="<?php echo $usuario['email']; ?>" name="email" id="email" type="email"><br>
            </p>
        </fieldset>
        <p>
            <span id="imgAlerta"></span><br>
            <span id="imgAlerta2" type="hidden"></span><br>
            <a href="inicio.php" style="margin-left: 10px; margin-right: 10px;">Voltar</a><a href="../../redefinir_senha.php" style="margin-left: 10px; margin-right: 10px;">Redefinir Senha</a>
            <button id="" type="submit" style="margin-left: 10px;">Salvar</button>
        </p>
        <script src="perfil_verifica_dados.js"></script>
    </form>
</body>
</html>

