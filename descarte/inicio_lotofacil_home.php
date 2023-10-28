<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #fff;            
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
            font-size: 20px;
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
        .container {
            height: 100vh;
            /*display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Adicionado para empilhar os elementos verticalmente */
        }
    </style>
    <script>
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

        // Carregar a página de início ao carregar a página
        window.onload = function() {
            abrirNaDiv('gerar_jogos.php');
        }
        /*function toggleMenu() {
            $('#menu').toggleClass('aberto');
        }*/
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
    <title>Lotofácil</title>
</head>
<body>
    <div id="divLista">
        <ul id="lista" class="lista">
            <li><a href="#" onclick="abrirNaDiv('config_lotofacil.php');">Configuração Lotofácil</a></li>
            <li><a href="#" onclick="abrirNaDiv('config_megasena.php');toggleMenu()">Configuração Mega Sena</a></li> 
            <!--<li><a href="#" onclick="abrirNaDiv('../paginas_div/configuracoes/config.php');toggleMenu()">Configurações</a></li> -->
        </ul> 
    </div>
    <div class="container" id="conteudo">
        <!--conteudo á ser carregado-->
    </div>
    <script src="ex.js"></script>
</body>
</html>