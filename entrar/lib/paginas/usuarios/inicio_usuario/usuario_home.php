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
        $saldo_str = $usuario ["creditos"];
// Substitui ',' por '.' e converte para float
$saldo = (float) str_replace(',', '.', $saldo_str);

// Formata o saldo em moeda
$saldo_formatado = 'R$ ' . number_format($saldo, 2, ',', '.');
    } else {
        // Se não houver uma sessão de usuário, redirecione para a página de login
        session_unset();
        session_destroy(); 
        header("Location: usuario_logout.php");  
        exit(); // Importante adicionar exit() após o redirecionamento
    }

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background-color: chartreuse;
            float: left; /* Faz com que a div "titulo" flutue à esquerda */
            margin-top: 0px; /* Adicione margens conforme necessário */
            /*color: rgb(11, 141, 4);*/
            /*font-family: Verdana, Geneva, Tahoma, sans-serif;*/
            padding-top: 0px;
        }

        #titulo h2{
            color: #1e07f5;
            margin-top: 15px;
            margin-left: 15px;
        }
        #titulo h2:hover{
            cursor: pointer;
        }
        .usuario #ola{
            display: flex; /* Ativa o layout flexível para os elementos filhos */
            align-items: center; /* Alinha os elementos verticalmente no centro */
            /*margin: -40px 30px 10px 10px*/
            
        }

        .usuario #sair {
            display: flex; /* Ativa o layout flexível para os elementos filhos */
            align-items: center; /* Alinha os elementos verticalmente no centro */
            margin-top: 0px;
            margin-left: 10px;
            margin-right: 15px;
        }

        .material-symbols-outlined {
            margin: 0px 20px 0px 20px; /* Adiciona algum espaço entre os elementos span */
            cursor: pointer; /* Define o cursor para parecer um link clicável */
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
            transition: transform 0.3s, font-size 0.3s;           
        }

        .material-symbols-outlined:last-child {
            margin-right: 0; /* Remove a margem à direita do último elemento span */
        }

        .material-symbols-outlined:hover {
            transform: translateY(-3px); /* Move o ícone para cima 5 pixels */
        }
        .usuario {
            display: flex; /* Define um layout flexível */
            justify-content: center; /* Centraliza os itens ao longo do eixo principal (horizontal) */
            align-items: center; /* Centraliza os itens ao longo do eixo transversal (vertical) */
        }

        .usuario div {
            margin: 0 10px; /* Adiciona um pequeno espaço entre os elementos */
        }
        .usuario #saldo{
            display: flex; /* Ativa o layout flexível para os elementos filhos */
            align-items: center; /* Alinha os elementos verticalmente no centro */
            /*margin: -40px 15px 10px 10px;*/
            color: green; 
        }
        .usuario #saldo a{
            color: blue; 
        }
        .usuario #ola{
            display: flex; /* Ativa o layout flexível para os elementos filhos */
            align-items: center; /* Alinha os elementos verticalmente no centro */
           /* margin: -40px 15px 10px 10px*/
           text-decoration: none;
        } 
        .usuario #ola a{
            transition: transform 0.3s, font-size 0.3s;
        }           
        .usuario #ola a:hover{
            transform: translateY(-3px); /* Move o ícone para cima 5 pixels */
        }
        a{
            text-decoration: none;
        }

        .usuario #sair {
            display: flex; /* Ativa o layout flexível para os elementos filhos */
            align-items: center; /* Alinha os elementos verticalmente no centro */
            /*margin: -40px 15px 10px 10px*/
        }
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Adicionado para empilhar os elementos verticalmente */
        }

        .lista {
            height: 40px;
            margin-top: 0px;
            margin-bottom: 0px;
            list-style-type: none;
            display: flex;
            flex-direction: row;
            background-color: chartreuse /* Adicione a cor desejada aqui */
        }
        .lista li{
            list-style-type: none;
            font-size: 15px;
            margin-right: 20px;
            padding: 10px;
            text-decoration: none;
            position: relative;
            overflow: hidden; /* Esconder qualquer conteúdo que transborde */
        }
        .lista li a{
            list-style-type: none;
            text-decoration: none;
        }

        .lista li::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 5px;
            background-color: blue;
            transition: width 0.3s ease; /* Transição da largura */
        }

        .lista li:hover::before {
            width: 100%; /* Aumenta a largura ao passar o mouse */
        }

        .lista li.selecionada {
            border-bottom: 5px solid blue; /* Adicione a cor desejada aqui */
            border-radius: 20px;
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
    </style>
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
        document.addEventListener("DOMContentLoaded", function() {
            let listaItems = document.querySelectorAll(".lista li");

            listaItems.forEach(function(item) {
                item.addEventListener("click", function() {
                    listaItems.forEach(function(item) {
                        item.classList.remove("selecionada");
                    });
                    this.classList.add("selecionada");
                });
            });
        });

    </script>
    <title>Meu Site</title>
</head>
<body>
    <div class="cabecalho">
        <div id="titulo"> 
            <H2 onclick="atualizarPagina()">Jogo da Sorte</H2> 
        </div> 
        <div class="usuario">
            <div id="ola">
                <a href="#" onclick="abrirNaDiv('../meu_perfil/perfil.php');toggleMenu()">
                    <strong> Olá, <?php echo $usuario['primeiro_nome']; ?></strong>
                </a>          
            </div>
            <div id="saldo">
                <a><strong> Saldo <?php echo $saldo_formatado; ?></strong></a>       
            </div>
            <div id="sair">
                <span class="material-symbols-outlined" id="logoutIcon" onclick="fazerLogout()">logout</span>              
            </div>
        </div>
    </div>
    <div id="divLista">
        <ul id="lista" class="lista">
            <li><a href="#" onclick="abrirNaDiv('usuario_inicio.php');toggleMenu()">Inicio</a></li> 
            <li id="config_lotofacil" ><a href="#" onclick="abrirNaDiv('../lotofacil/lotofacil_home.php');">Lotofácil</a></li>
            <li><a href="#" onclick="abrirNaDiv('../megasena/megasena_home.php');">Mega Sena</a></li> 
            <li><a href="#" onclick="abrirNaDiv('');toggleMenu()">Quina</a></li>
            
            <!--<li><a href="#" onclick="abrirNaDiv('../configuracoes/lotofacil/resetar_excluirDados/deletar_dados.php');toggleMenu()">Excluir Todos os dados</a></li>
            <li><a href="#" onclick="abrirNaDiv('../configuracoes/lotofacil/importar_exportar/importar.php');toggleMenu()">Importar/Exportar</a></li>-->
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