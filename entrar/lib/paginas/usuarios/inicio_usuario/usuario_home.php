<?php
    include('../../../conexao.php');

    if(!isset($_SESSION)){
        session_start(); 
    }

    if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        $id = $_SESSION['usuario'];
        $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
        $usuario = $sql_query->fetch_assoc(); 

    } else {
        // Se não houver uma sessão de usuário, redirecione para a página de login
        session_unset();
        session_destroy(); 
        header("Location: ../../../../index.php");  
        exit(); // Importante adicionar exit() após o redirecionamento
    }

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="usuario_home.css">
    <script>
        //atualiza a pagian a cada 10 min
        /*setTimeout(function() {
            location.reload();
        }, 100000);*/
        
        // Função para carregar o conteúdo na div
        function abrirNaDiv(pagina) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("conteudo").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", pagina, true);
            xhttp.send();
        }

        // Carregar a página de início ao carregar a página
        window.onload = function() {
            abrirNaDiv('usuario_inicio.php');
        }
        function toggleMenu() {
            $('#menu').toggleClass('aberto');
        }
        function abrirNaDiv(link) {
            var div = document.getElementById('conteudo');
            div.innerHTML = '<object type="text/html" data="' + link + '" style="width:100%; height:100%;">';
        }
        /*document.getElementById('logoutIcon').addEventListener('click', function() {
            window.location.href = 'usuario_logout.php';
        });*/
        function fazerLogout() {
            window.location.href = 'usuario_logout.php';
        }
        function atualizarPagina() {
            location.reload(); // Recarrega a página
        }

    </script>
    <title>Meu Site</title>
</head>
<body>
    <div class="cabecalho">
        <div id="titulo">
            <span class="material-symbols-outlined"  id="icoMenu" onclick="toggleMenu();">menu</span>  
            <H2 onclick="atualizarPagina()">Jogo da Sorte</H2> 
        </div> 
        <div class="usuario">
            <div id="ola">
                <a><strong> Olá, <?php echo $usuario['primeiro_nome']; ?></strong></a>          
            </div>
            <div id="sair">
                <span class="material-symbols-outlined" id="logoutIcon" onclick="fazerLogout()">logout</span>              
            </div>
        </div>
    </div>
    <div class="menu" id="menu">
        <ul id="lista" class="lista">
            <li><a href="#" onclick="abrirNaDiv('inicio.php');toggleMenu()">Inicío </a></li> 
            <li><a href="#" onclick="abrirNaDiv('perfil.php');toggleMenu()">Meu Perfil </a></li>              
        </ul> 
    </div> 
    <div class="container" id="conteudo">
        <!--conteudo á ser carregado-->
    </div>
    <script src="usuario_home.js"></script>
</body>
    <footer>
        <div class="container-rodape">
            <div class="row">
                <div class="col-md-6">
                    <h3>Links Úteis</h3>
                    <ul>
                        <li><a href="#">Sobre Nós</a></li>
                        <li><a href="#">Contato</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Redes Sociais</h3>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom-bar">
            <p>&copy; 2023 <?php echo 'Jogo da Sorte';?>. Todos os direitos reservados.</p>
        </div>
    </footer>
</html>