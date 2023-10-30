
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="usuario_inicio.css">
    <title>Inicio</title>
</head>
<body>
    <div class="container" id="conteudo">
        <h3>Istruções do site</h3>
        <p>
            Este site foi criado com o intuito de gerar jogos e encontrar as melhores jogados para
             aumentar as chances de acertos no jogos das loteria. Não garantimos e nem prometemos gerar 
             jogos ganhadores, mas sim, essa seria sim nossa inteção. Serão geradas jogadas calculadas e 
             monitoradas e excluido todos os jogos ja sorteados para que não sejam mais apostados.
        </p>
        <div class="conteudo" id="conteudo">
            
        </div>
        <div class="botoes">
            <button onclick="abrirPaginaLotofacil()">Lotofácil</button>
            <button onclick="abrirPaginaMegaSena()">Mega Sena</button>            
        </div>
    </div>
    <script>
        function abrirPaginaLotofacil() {
            window.location.href = '../lotofacil/lotofacil_home.php';
        }
        function abrirPaginaMegaSena() {
            window.location.href = '../megasena/megasena_home.php';
        }
    </script>
</body>
</html>