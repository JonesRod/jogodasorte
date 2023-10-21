
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inicio_usuario.css">
    <title>Inicio</title>
</head>
<body>
    <div class="container" id="conteudo">
        <div class="conteudo" id="conteudo">
            <p>Istruções do site</p>
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