<?php
    include('../../conexao.php');

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
    <!--<link rel="stylesheet" href="usuario_home.css">-->
    <style>
        @charset "UTF-8";
        /* Estilos para todos os dispositivos */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #fff;
            /*height: 60vh; /* Isso garante que o corpo ocupa 100% da altura da tela */
        }

        .cabecalho {
            background-color: chartreuse;
            display: flex; /* Ativa o layout flexível para os elementos filhos */
            justify-content: space-between; /* Distribui o espaço entre os elementos filhos */
            align-items: center; /* Alinha os elementos verticalmente no centro */
            }

            #titulo {
                flex: 1; /* Ocupa o espaço disponível restante */
            }

            .usuario #ola{
                display: flex; /* Ativa o layout flexível para os elementos filhos */
                align-items: center; /* Alinha os elementos verticalmente no centro */
                margin-top: -10px;
                margin-right: 10px;
            }

            .usuario #sair {
                display: flex; /* Ativa o layout flexível para os elementos filhos */
                align-items: right; /* Alinha os elementos verticalmente no centro */
                /*margin-top: -20px;*/
                margin-left: 80px;
            }

            .material-symbols-outlined {
                margin-right: 10px; /* Adiciona algum espaço entre os elementos span */
                cursor: pointer; /* Define o cursor para parecer um link clicável */
            }

            .material-symbols-outlined:last-child {
                margin-right: 0; /* Remove a margem à direita do último elemento span */
            }

            .material-symbols-outlined {
                font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
            }
            .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
            }


            footer {
                background: #333;
                color: #fff;
                padding: 10px 0;
                text-align: center;
            }

            footer ul {
                list-style: none;
                padding: 0;
            }

            footer ul li {
                display: inline;
                margin-right: 10px;
            }

            footer ul li a {
                color: #fff;
                text-decoration: none;
            }

            .bottom-bar {
                background: #222;
                padding: 5px 0;
                text-align: center;
            }

            .bottom-bar p {
                margin: 0;
            }

            /* Estilos para Links */
            a {
                color: #333;
                text-decoration: none;
            }

            a:hover {
                color: #555;
            }
        /* Estilos para notebooks e desktops */
        @media screen and (min-width: 768px) {
            .cabecalho {
            background-color: chartreuse;
            display: flex; /* Ativa o layout flexível para os elementos filhos */
            justify-content: space-between; /* Distribui o espaço entre os elementos filhos */
            align-items: center; /* Alinha os elementos verticalmente no centro */
            }

            #titulo {
                flex: 1; /* Ocupa o espaço disponível restante */
            }

            .usuario #ola{
                display: flex; /* Ativa o layout flexível para os elementos filhos */
                align-items: center; /* Alinha os elementos verticalmente no centro */
                margin-top: -10px;
                margin-right: 10px;
            }

            .usuario #sair {
                display: flex; /* Ativa o layout flexível para os elementos filhos */
                align-items: right; /* Alinha os elementos verticalmente no centro */
                /*margin-top: -20px;*/
                margin-left: 80px;
            }

            .material-symbols-outlined {
                margin-right: 10px; /* Adiciona algum espaço entre os elementos span */
                cursor: pointer; /* Define o cursor para parecer um link clicável */
            }

            .material-symbols-outlined:last-child {
                margin-right: 0; /* Remove a margem à direita do último elemento span */
            }

            .material-symbols-outlined {
                font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
            }
            .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
            }


            footer {
                background: #333;
                color: #fff;
                padding: 10px 0;
                text-align: center;
            }

            footer ul {
                list-style: none;
                padding: 0;
            }

            footer ul li {
                display: inline;
                margin-right: 10px;
            }

            footer ul li a {
                color: #fff;
                text-decoration: none;
            }

            .bottom-bar {
                background: #222;
                padding: 5px 0;
                text-align: center;
            }

            .bottom-bar p {
                margin: 0;
            }

            /* Estilos para Links */
            a {
                color: #333;
                text-decoration: none;
            }

            a:hover {
                color: #555;
            }
        }
        /* Estilos para Tablet */
        @media screen and (min-width: 768px) and (max-width: 1024px) {

        }
        /* Estilos para iPhone*/
        @media screen and (max-width: 767px)  {

        }

        /* Estilos para tablets e dispositivos com telas médias a grandes */
        @media screen and (min-width: 481px) and (max-width: 1024px) {
            
        }

        /* Estilos para dispositivos de alta resolução (como Retina) */
        @media screen and (-webkit-min-device-pixel-ratio: 2) {
            
        }


    </style>
    <script>
        //atualiza a pagian a cada 10 min
        /*setTimeout(function() {
            location.reload();
        }, 100000);
        
        // Função para carregar o conteúdo na div
        function abrirNaDiv(pagina) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("iconteudo").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", pagina, true);
            xhttp.send();
        }

        // Carregar a página de início ao carregar a página
        window.onload = function() {
            abrirNaDiv('inicio.php');
        }*/
    </script>
    <title>Meu Site</title>
</head>
<body>
    <div class="cabecalho">
        <div id="titulo">
            <H2>Jogo da Sorte</H2> 
        </div> 
        <div class="usuario">
            <div id="ola">
                <a> Olá, <?php echo $usuario['primeiro_nome']; ?></a>
                <span class="material-symbols-outlined">menu</span>                
            </div>
            <div id="sair">
                <span class="material-symbols-outlined">logout</span>              
            </div>
        </div>
    </div>
    <div class="DivMenu">
        <div class="menu" id="menu">
            <ul id="ilista" class="lista">
                <li><a href="#" onclick="abrirNaDiv('inicio.php');toggleMenu()">Inicío </a></li> 
                <li><a href="#" onclick="abrirNaDiv('perfil.php');toggleMenu()">Meu Perfil </a></li>              
                <li><a href="#" onclick="abrirNaDiv('CarregarMensalidades.php');toggleMenu()">Minhas Mensalidades</a></li>
                <li><a href="#" onclick="abrirNaDiv('Carregar_joia.php');toggleMenu()">Jóia</a></li>
                <li><a href="usuario_logout.php">Sair</a></li>
            </ul> 
        </div> 
 <a href="usuario_logout.php">Sair</a>
    </div> 

    <div class="container">
        <div class="conteudo" id="iconteudo">
            <!-- Conteúdo central (dados escolhidos) -->
        </div>
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
            <p>&copy; 2023 <?php echo 'Associação 40 Ribas';?>. Todos os direitos reservados.</p>
        </div>
    </footer>
</html>