<?php
    include('../../../../conexao.php');
    
    session_start(); 

    if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        $admin = $_SESSION['admin'];
        $_SESSION['usuario'];
        $_SESSION['admin']; 

        $id = $_SESSION['usuario'];
        $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
        $usuario = $sql_query->fetch_assoc(); 

        $id = '1';
        $dados = $conn->query("SELECT * FROM config_lotofacil WHERE id = '$id'") or die($conn->error);
        $registro = $dados->fetch_assoc();
        $quantidade = $dados->num_rows;

        if($quantidade > 0){
            $valor_15 = $registro['valor_15'];
            $valor_16 = $registro['valor_16'];
            $valor_17 = $registro['valor_17'];
            $valor_18 = $registro['valor_18'];
            $valor_19 = $registro['valor_19'];
            $valor_20 = $registro['valor_20'];
            $qt_concurso_confere = $registro['qt_concurso_confere'];
            $qt_concurso_salva = $registro['qt_concurso_salva'];
        }else{
            $valor_15 = '';
            $valor_16 = '';
            $valor_17 = '';
            $valor_18 = '';
            $valor_19 = '';
            $valor_20 = '';
            $qt_concurso_confere = '';
            $qt_concurso_salva = '';
        }
    }else{
        session_unset();
        session_destroy();
        header("Location: ../../../admin_logout.php");             
    }

    $conn->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <!--<link rel="stylesheet" href="config_lotofacil.css">-->
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        .conteiner {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /*sombra*/

        }

        h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }

        /*#msg1 {
            color: blue;
        }
        #msg2 {
            color: blue;
        }
        #msg2 h3{
            color: #333;
        }*/
        .moeda {
            display: flex;
            align-items: center;
        }
        label {
            flex: 0 0 auto; /* A label não será flexível e manterá seu tamanho natural */
            margin-right: 0px; /* Espaço entre a label e o input */
            word-break: break-word; /* Permite que a label quebre a linha se necessário */
        }

        input {
            flex: 1; /* O input será flexível e ocupará o espaço restante disponível */
            min-width: 100px; /* Define uma largura mínima para o input */
            width: 95%;
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
            outline: none; /* Remove o contorno ao focar no botão */
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
    <title>Configuração</title>
</head>
<body>
    <div class="conteiner">
        <form action="altera_config_lotofacil.php" method="post">
            <h3 id="titulo" >Configurações de valores por cada jogo da Lotofácil</h3>

            <input type="hidden" name="id_usuario" id="" value="<?php echo $usuario['id']; ?>">

            <p class="moeda">
                <label for="valor_15">Valor de cada jogo gerado com 15 dezenas: </label>
                <input required id="valor_15" name="valor_15" type="text" value="<?php echo $valor_15; ?>"
                oninput="calcularValores()">
            </p>
            <p class="moeda">
                <label for="valor_16">Valor de cada jogo gerado com 16 dezenas(16): </label>
                <input required id="valor_16"  name="valor_16" type="text" value="<?php echo $valor_16; ?>">
            </p>
            <p class="moeda">
                <label for="valor_17">Valor de cada jogo gerado com 17 dezenas(136): </label>
                <input required id="valor_17" name="valor_17" type="text" value="<?php echo $valor_17; ?>">
            </p>
            <p class="moeda">
                <label for="valor_18">Valor de cada jogo gerado com 18 dezenas(816): </label>
                <input required id="valor_18" name="valor_18" type="text" value="<?php echo $valor_18; ?>">
            </p>
            <p class="moeda">
                <label for="valor_19">Valor de cada jogo gerado com 19 dezenas(3.876): </label>
                <input required id="valor_19" name="valor_19" type="text" value="<?php echo $valor_19; ?>">
            </p>
            <p class="moeda">
                <label for="valor_20">Valor de cada jogo gerado com 20 dezenas(15.504): </label>
                <input required id="valor_20" name="valor_20" type="text" value="<?php echo $valor_20; ?>">
            </p>
            <p>
                <label for="qt_concurso_confere">Quantidade máxima de concursos que o usuario poderá conferir com os mesmos jogos: </label>
                <input required value="<?php echo $qt_concurso_confere; ?>"
                name="qt_concurso_confere" type="number">
            </p>
            <p>
                <label for="qt_concurso_salva">Quantidade máxima de ultimos concursos jogados que seram salvos: </label>
                <input required value="<?php echo $qt_concurso_salva; ?>"
                name="qt_concurso_salva" type="number">
            </p>
            <p>
                <a href="resetar_excluirDados/backup.php"  style="margin-left: 10px; margin-right: 10px;">Backup dos concursos da lotofácil</a>
                <a href="resetar_excluirDados/deletar_dados.php"  style="margin-left: 10px; margin-right: 10px;">Excluir Todos os concursos da Lotofácil</a>
                <a href="importar_exportar/importar.php"  style="margin-left: 10px; margin-right: 10px;">Importar</a>

                <button type="submit">Salvar</button>
            </p>   
        </form>
    </div>
    <script src="config_moeda.js"></script> 
</body>
</html>