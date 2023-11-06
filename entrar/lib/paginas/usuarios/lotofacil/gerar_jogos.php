<?php

    include('../../../conexao.php');

    // Verifique se o último resultado foi registrado
    $resultado_existe = false;
    $msg =false;

    $sql = "SELECT * FROM resultados_lotofacil ORDER BY concurso DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $resultado_existe = true;
        $row = $result->fetch_assoc();

        // Existe um resultado no banco de dados
        $concurso = $row['concurso'];
        $data = $row['data']; // 2023/11/02

        // Converte a data para o formato brasileiro
        $data_formatada = date('d/m/Y', strtotime($data));


    }


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body{
            font-family: Arial, sans-serif;
        }
        .conteiner{
            margin: 10px;
            display: flex;
        }  
        .geradorJogos_listaMeusJogos, .listaResultados {
            flex: 1; /* Ambos os elementos ocupam o mesmo espaço disponível */
        }
        .geradorJogos_listaMeusJogos {
            /*margin-top: -18px;*/
            margin-right: 8px;
            /*padding: 0px; /* Adicionando margem para espaçamento */
            /*display: flex;
            align-items: center;*/
        }       
        .listaResultados{
            text-align: center;
            margin-left: 8px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2);
        }        
        #geradorJogos {
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2);
            padding-bottom: 1px;
        }
        #geradorJogos h3{
            margin: 0px 10px 20px 10px;
            padding-top: 18px;

        }
        #ultimoconcurso{
            font-weight: bold; /* Deixa o texto em negrito */
        }

        #geradorJogos p {
            display: flex;
            align-items: center;
            margin: 0px 10px 5px 10px;
            flex-wrap: wrap; /* Permite a quebra de linha se necessário */
        }
        
        #geradorJogos label {
            margin-right: 5px;
            /*flex-shrink: 0; /* Não deve encolher (não deve ocupar espaço extra) */
           /* width: auto;
            display: inline-block;
            /*box-sizing: border-box; /* Inclui a largura da borda e o preenchimento na largura total */
            word-break: break-word; /* Permite que a label quebre a linha se necessário */
        }
        #geradorJogos input {
            flex: 1; /* Deve ocupar todo o espaço disponível */
            width: auto;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            min-width: 50px; /* Define uma largura mínima para o input */
            margin-right: 5px;
        }
        input:focus {
            outline: none; /* Remove a borda de foco padrão */
        }

        #listaMeusJogos{
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2);
        }
        #primeirainstrucao{
            font-weight: bold; /* Deixa o texto em negrito */
            text-align: center;
            color: blue;
            /*margin: 0px 10px 20px 20px;*/
            padding-bottom: 20px;
        }
        #config_padrao{
            margin-bottom: 20px;
            border-radius: 10px;
            padding: 10px;
            /*display: block;*/
            width: 250px; /* Define a largura dos botões */
            height: 50px; /* Define a altura dos botões */
            margin: 5px;
            border: none;
            background-color: #4CAF50; /* Define a cor de fundo */
            color: white; /* Define a cor do texto */
            font-size: 16px; /* Define o tamanho da fonte */
            border-radius: 5px; /* Adiciona bordas arredondadas */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adiciona sombra 3D */
        }
        #config_padrao:hover{
            margin: 5px;
            padding: 5px;
            font-weight: bold;
            border-radius: 5px;
            background-color: rgba(244, 164, 6, 0.942);
            /*transform: scale(1.1);*/
            cursor: pointer;
        }
        #config_padrao button:hover {
            background-color: #45a049; /* Altera a cor de fundo ao passar o mouse */
            cursor: pointer;
        }

        #config_padrao:focus {
            outline: none; /* Remove o contorno ao focar no botão */
            
        }
        #config_padrao:active {
            /* Estilos quando o botão é clicado */
            box-shadow: 0 2px 10px rgba(0, 123, 255, 0.5);
        }
        #instrucao_final{
            display: flex;
            font-weight: bold; /* Deixa o texto em negrito */
            text-align: center;
            align-items: center;
            justify-content: center;
            color: blue;
            margin-top: 30px;
            padding-bottom: 30px;
        }

        .tooltip {
            position: relative;
            display: inline-block; /* Permite que o botão e a mensagem fiquem na mesma linha */
            width: 15px;
            height: 15px;
            text-align: center;
            align-items: center;
            border: 1px solid #000; /* Adiciona uma borda de 2 pixels */
            border-radius: 50%; /* Torna o elemento redondo */
            font-weight: bold; /* Deixa o texto em negrito */
            line-height: 15px; /* Alinha verticalmente o texto */
            cursor: help; /* Muda o cursor para indicar que há uma dica ao passar o mouse */
        }

        .tooltip::after {
            content: attr(value);
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            padding: 4px 8px;
            position: absolute;
            top: 30%;
            left: 100%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            width: 250px; /* Define a largura máxima */
        }
        .tooltip:hover::after {
            opacity: 1;
        }
        #gerar_jogo{
            margin-bottom: 20px;
            border-radius: 10px;
            padding: 10px;
            /*display: block;*/
            width: 250px; /* Define a largura dos botões */
            height: 50px; /* Define a altura dos botões */
            margin: 5px;
            margin-bottom: 20px;
            border: none;
            background-color: #4CAF50; /* Define a cor de fundo */
            color: white; /* Define a cor do texto */
            font-size: 16px; /* Define o tamanho da fonte */
            border-radius: 5px; /* Adiciona bordas arredondadas */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adiciona sombra 3D */
        }
        #gerar_jogo:hover{
            margin: 5px;
            padding: 5px;
            font-weight: bold;
            border-radius: 5px;
            background-color: rgba(244, 164, 6, 0.942);
            /*transform: scale(1.1);*/
            margin-bottom: 20px;
            cursor: pointer;
        }
        #gerar_jogo button:hover {
            background-color: #45a049; /* Altera a cor de fundo ao passar o mouse */
            cursor: pointer;
        }

        #gerar_jogo:focus {
            outline: none; /* Remove o contorno ao focar no botão */
        }
        #gerar_jogo:active {
            /* Estilos quando o botão é clicado */
            box-shadow: 0 2px 10px rgba(0, 123, 255, 0.5);
        }

        .consultar p {
            display: flex;
            align-items: center;
            margin: 0px 10px 5px 10px;
            flex-wrap: wrap; /* Permite a quebra de linha se necessário */
        }
        
        .consultar label {
            margin-right: 20px;
            /*flex-shrink: 0; /* Não deve encolher (não deve ocupar espaço extra) */
           /* width: auto;
            display: inline-block;
            /*box-sizing: border-box; /* Inclui a largura da borda e o preenchimento na largura total */
            word-break: break-word; /* Permite que a label quebre a linha se necessário */
        }
        .consultar input {
            /*flex: 1; /* Deve ocupar todo o espaço disponível */
            width: 20px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            min-width: 20px; /* Define uma largura mínima para o input */
            margin-right: 5px;
            max-width: 40px;
        }
        .consultar button {
            /*flex: 1; /* Deve ocupar todo o espaço disponível */
            width: 100px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            min-width: 20px; /* Define uma largura mínima para o input */
            margin-right: 10px;
            margin-left: 20px;
        }
        .consultar .tooltip {
            margin-right: 10px;
            margin-left: 10px;
        }

        .consultar #dezenas{
            min-width: 300px; /* Define uma largura mínima para o input */
            width: 500px;
        }
        .consultar{
            text-align: center;
            flex: 1;
            background-color: #45a049;
            margin: 50px;
            padding: 20px;
            border-radius: 10px;
            
        }
        .numeros button {
            width: 40px;
            height: 40px;
            margin: 0px;
            box-sizing: border-box;
            border-radius: 50px;
            
        }

        #dezenas{
            margin-top: 30px;
            margin-bottom: 30px;
            width: 100%;
            text-align: center;
            box-sizing: border-box;


        }
        .numeros {
            padding-left: 5%;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            justify-content: center;
        }
        .numeros button.selecionado {
            background-color: #FFD700; /* Cor de fundo quando selecionado */
        }
        .numeros button.active {
            background-color: #FFD700;
        }
    </style>
    <script>
        function config_padrao(){
            document.getElementById('inicio_jogo').value = '1';
            document.getElementById('final_jogo').value = '25';
            document.getElementById('dez_excluidas').value = '0';
            document.getElementById('qt_dezenas').value = '15';
        }


        
    </script>

    <title>Gerador Lotofácil</title>
</head>
<body onload="config_padrao()">
    <div class="conteiner">
        <div class="geradorJogos_listaMeusJogos">
            <div id="geradorJogos">
                <h3>Siga as instruções de como fazer seus jogos</h3>
                <p id="primeirainstrucao">Os jogos seram gerados conforme o ultimo concurso sorteado e não será gerado jogos ja sorteados 
                    iguais os concursos anteriores ja sorteados e permitindo repetidos apenas com 14 dezenas 
                    apontando as melheres jogadas ou conforme sua configuraçao para gerar seus jogos.
                </p>
                <label id="ultimoconcurso" for="">Ultimo concurso: <?php echo $concurso . " - " . $data_formatada; ?></label>
                <h3>Configure o estilo de seu(s) jogos</h3>

                <button id="config_padrao" onclick="config_padrao()">Configuração padrão</button>
                <span class="tooltip" value="Adiciona a configuração pedrão. Essa configuração inclui todos os tipos de jogadas ainda não sorteadas">i</span>
                <p>
                    <label for="inicio_jogo">Escolha a dezena inicial para geração do(s) seu(s) jogo(s). (Opcional)</label>
                    <input id="inicio_jogo" type="number">
                    <span class="tooltip" value="Determina a dezena inicial para geração do(s) seus jogos. Você pode escolher do 1 ao 7.">i</span>   
                <p>
                <p>
                    <label for="final_jogo">Escolha a dezena final para geração do(s) seu(s) jogo(s). (Opcional)</label>
                    <input id="final_jogo" type="number">
                    <span class="tooltip" value="Determina a dezena final para geração do(s) seus jogos. Você pode escolher do 19 ao 25.">i</span>   
                <p>
                <p>
                    <label for="dez_excluidas">Escolha quais dezenas você gostaria que não saissem no(s) jogo(s) (Opcional)</label>
                    <input id="dez_excluidas" type="number" placeholder="1,2,3,...">
                    <span class="tooltip" value="Você pode escolher até 7 dezenas para não sairem em seus jogos.">i</span>   
                <p>
                </p>
                <p>
                    <label for="qt_dezenas">Escolha com quantas dezenas você gostaria de gerar seu(s) jogo(s)? (Opcional)</label>
                    <input id="qt_dezenas" type="number"> 
                    <span class="tooltip" value="Você pode escolher entre 16 e 20 dezenas.">i</span>                   
                </p>
                <div id="instrucao_final">
                    As demais configurações existente ja estam incluidas na configuração padrão.
                </div>
                <button id="gerar_jogo" onclick="gerar_jogo()">Gerar Jogo</button>
                <div class="consultar">
                    <h3>Escolha de 15 a 20 dezenas.</h3>
                    <div class="numeros">
                        <button onclick="removerDezena(1)">1</button>
                        <button onclick="removerDezena(2)">2</button>
                        <button onclick="removerDezena(3)">3</button>
                        <button onclick="removerDezena(4)">4</button>
                        <button onclick="removerDezena(5)">5</button>

                        <button onclick="removerDezena(6)">6</button>
                        <button onclick="removerDezena(7)">7</button>
                        <button onclick="removerDezena(8)">8</button>
                        <button onclick="removerDezena(9)">9</button>
                        <button onclick="removerDezena(10)">10</button>

                        <button onclick="removerDezena(11)">11</button>
                        <button onclick="removerDezena(12)">12</button>
                        <button onclick="removerDezena(13)">13</button>
                        <button onclick="removerDezena(14)">14</button>
                        <button onclick="removerDezena(15)">15</button>

                        <button onclick="removerDezena(16)">16</button>
                        <button onclick="removerDezena(17)">17</button>
                        <button onclick="removerDezena(18)">18</button>
                        <button onclick="removerDezena(19)">19</button>
                        <button onclick="removerDezena(20)">20</button>

                        <button onclick="removerDezena(21)">21</button>
                        <button onclick="removerDezena(22)">22</button>
                        <button onclick="removerDezena(23)">23</button>
                        <button onclick="removerDezena(24)">24</button>
                        <button onclick="removerDezena(25)">25</button>
                    </div>
                    <input readonly id="dezenas" type="text">
                    <div id="contador"></div>
                    <button id="gerar_jogo" onclick="gerar_jogo()">Consultar Jogo</button> 
                </div>
            </div>
            <div id="listaMeusJogos">
                <h3>Lista de jogos gerados para o concurso escolhido</h3>
                <label for="">Concurso</label><input type="text"><button>Carregar</button>
            </div>

        </div>
        <div class="listaResultados">
            <h3>Lista de resultados do concurso escolhido</h3>
            <label for="">Concurso</label><input type="number"><button>Carregar</button>
        </div>
    </div>
    <script src="inclurir_dezenas.js"></script>
</body>
</html>