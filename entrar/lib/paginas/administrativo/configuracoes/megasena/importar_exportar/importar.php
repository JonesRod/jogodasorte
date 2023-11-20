<?php
session_start(); // Iniciar a sessão
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            text-align: center;
        }
        #conteiner {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /*sombra*/
            font-family: Arial, sans-serif;
        }
    </style>
    <title>Importar Excel csv e salvar no BD</title>
</head>
<body>
    <div id="conteiner">
        <h1>Importar Excel .csv</h1>

        <h3>Antes de importar, retire da lista os dados de quem ja esta  no outro 
            banco e verifique a ordem e a deixe na seguite seguência:
        </h3>

        <p>(Concurso, Data Sorteio, Bola1, Bola2, Bola3, Bola4, Bola5, Bola6, Bola7, Bola8, Bola9, Bola10, 
            Bola11, Bola12, Bola13, Bola14, Bola15, Ganhadores 15 acertos, Cidade / UF,	Rateio 15 acertos, 
            Ganhadores 14 acertos, Rateio 14 acertos, Ganhadores 13 acertos, Rateio 13 acertos, 
            ganhadores 12 acertos, ateio 12 acertos, Ganhadores 11 acertos, Rateio 11 acertos, 
            Acumulado 15 acertos, Arrecadacao Total, Estimativa Prêmio, 
            Acumulado sorteio especial Lotofácil da Independência, Observação)
        </p>
        <?php
        // Apresentar a mensagem de erro ou sucesso
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <!-- Formulario para enviar arquivo .csv -->
        <form method="POST" action="processa.php" enctype="multipart/form-data">
            <label>Arquivo: </label>
            <input type="file" name="arquivo" id="arquivo" accept="text/csv"><br><br>
            <a href="../config_lotofacil.php"  style="margin-left: 10px; margin-right: 10px;">Voltar</a>
            <input type="submit" value="Enviar">
        </form>            
    </div>

    
</body>
</html>