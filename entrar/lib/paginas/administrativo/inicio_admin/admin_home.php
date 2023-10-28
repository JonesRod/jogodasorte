<?php
    include('../../../conexao.php');
    //echo '1';
    //die();
    if(!isset($_SESSION)){
        session_start(); 
        //echo '2';
        //die();
        if($_SERVER["REQUEST_METHOD"] === "POST") {  
            //echo '3';
            if (isset($_POST["tipoLogin"])) {
                //echo '4';
                if(isset($_SESSION['usuario'])){ 
                    //echo '5';
                    // Obter o valor do input radio
                    $usuario = $_SESSION['usuario'];
                    $valorSelecionado = $_POST["tipoLogin"];
                    $admin = $valorSelecionado;

                    if($admin == 0){
                        //echo '6';
                        $_SESSION['usuario'];
                        header("Location: ../../usuarios/inicio_usuario/usuario_home.php");       
                    }else if($admin == 1){
                        //echo '7';
                        $usuario = $_SESSION['usuario'];
                        $admin = $_SESSION['admin'];
                        $_SESSION['usuario'];
                        $_SESSION['admin'];  
                        
                        $id = $_SESSION['usuario'];
                        $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->$error);
                        $usuario = $sql_query->fetch_assoc();    
                    }else{
                        //echo '8';
                        session_unset();
                        session_destroy();
                        header("Location: admin_logout.php"); 
                    }
                }else{

                    session_unset();
                    session_destroy();
                    header("Location: admin_logout.php"); 
                }    
            }else{

                session_unset();
                session_destroy();
                header("Location: admin_logout.php"); 
            }  
        }else if(isset($_SESSION['usuario'])){    
            //echo '3';
            //die();
            $usuario = $_SESSION['usuario'];
            $admin = $_SESSION['admin'];
            $_SESSION['usuario'];
            $_SESSION['admin'];  
    
            $id = $_SESSION['usuario'];
            $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
            $usuario = $sql_query->fetch_assoc();    
    
        }else{

            session_unset();
            session_destroy();
            header("Location: admin_logout.php"); 
        }
    }else if(isset($_SESSION['usuario'])){    
        //echo '3';
        //die();
        $usuario = $_SESSION['usuario'];
        $admin = $_SESSION['admin'];
        $_SESSION['usuario'];
        $_SESSION['admin'];  

        $id = $_SESSION['usuario'];
        $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
        $usuario = $sql_query->fetch_assoc();    

    }else{
        //echo '4';
        //die();
        if($_SERVER["REQUEST_METHOD"] === "POST") {  

            if (isset($_POST["tipoLogin"])) {
                // Obter o valor do input radio
                $usuario = $_SESSION['usuario'];
                $valorSelecionado = $_POST["tipoLogin"];
                $admin = $valorSelecionado;

                if($admin == 0){

                    $_SESSION['usuario'];
                    header("Location: ../usuario_home.php");       
                }else if($admin == 1){
                    $usuario = $_SESSION['usuario'];
                    $admin = $_SESSION['admin'];
                    $_SESSION['usuario'];
                    $_SESSION['admin'];  

                    $id = $_SESSION['usuario'];
                    $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
                    $usuario = $sql_query->fetch_assoc();    

                }else{

                    session_unset();
                    session_destroy();
                    header("Location: admin_logout.php"); 
                }
            }  
        }else{

            session_unset();
            session_destroy();
            header("Location: admin_logout.php"); 
        }
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
    <link rel="stylesheet" href="admin_home.css">
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
            abrirNaDiv('../configuracoes/lotofacil/inicio_lotofacil_home.php');
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
            window.location.href = 'admin_logout.php';
        }
        function atualizarPagina() {
            location.reload(); // Recarrega a página
        }
                // Adicione este script em uma tag <script> após o seu código HTML

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

        window.onload = function() {
            // Selecionar o elemento desejado
            var elemento = document.getElementById('config_lotofacil'); // Substitua 'seuElementoID' pelo ID do seu elemento

            // Verificar se o elemento foi encontrado
            if (elemento) {
                // Disparar um evento de clique no elemento
                elemento.click();
                abrirNaDiv('../configuracoes/lotofacil/inicio_lotofacil_home.php');
            }
        }

        function abrirNaDiv(link) {
            var div = document.getElementById('conteudo');
            div.innerHTML = '<object type="text/html" data="' + link + '" style="width:100%; height:100%;">';
        }
        /*document.getElementById('logoutIcon').addEventListener('click', function() {
            window.location.href = 'usuario_logout.php';
        });*/
        function fazerLogout() {
            window.location.href = 'admin_logout.php';
        }
        /*function atualizarPagina() {
            location.reload(); // Recarrega a página
        }*/

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
                <a><strong> Olá, <?php echo $usuario['primeiro_nome']; ?></strong></a>          
            </div>
            <div id="sair">
                <span class="material-symbols-outlined" id="logoutIcon" onclick="fazerLogout()">logout</span>              
            </div>
        </div>
    </div>
    <div id="divLista">
        <ul id="lista" class="lista">
            <li id="config_lotofacil" ><a href="#" onclick="abrirNaDiv('../configuracoes/lotofacil/inicio_lotofacil_home.php');">Configuração Lotofácil</a></li>
            <li><a href="#" onclick="abrirNaDiv('../configuracoes/megasena/config_megasena.php');">Configuração Mega Sena</a></li> 
            <li><a href="#" onclick="abrirNaDiv('../configuracoes/quina/config_quina.php');toggleMenu()">Configuração Quina</a></li>
        </ul> 
    </div>
    <div class="container" id="conteudo">
        <!--conteudo á ser carregado-->
    </div>
    <script src="admin_home.js"></script>
</body>
</html>