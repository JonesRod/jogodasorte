<?php

    include('../../../../conexao.php');

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

    }


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            margin: 0px;
            border: 0px;
            padding: 0px;
        }
        .conteiner{
            margin: 10px;
            display: flex;
        }  
        .geradorJogos_listaMeusJogos, .listaResultados {
            flex: 1; /* Ambos os elementos ocupam o mesmo espaço disponível */
        }
        .geradorJogos_listaMeusJogos {
            margin-top: -18px;
            margin-right: 8px;
            /*padding: 0px; /* Adicionando margem para espaçamento */
        }        
        .listaResultados{
            margin-left: 8px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2);
        }        
        #geradorJogos {
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2);
        }

        #listaMeusJogos{
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2), 0 0 8px rgba(0,0,0,0.2);
        }

        .tooltip {
            position: relative;
            display: inline-block; /* Permite que o botão e a mensagem fiquem na mesma linha */
            width: 15px;
            height: 15px;
            text-align: center;
            align-items: center;
            border: 2px solid #000; /* Adiciona uma borda de 2 pixels */
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
 
    </style>

    <title>Gerador Lotofácil</title>
</head>
<body>
    <div class="conteiner">
        <div class="geradorJogos_listaMeusJogos">
            <div id="geradorJogos">
                <h3>Siga as instruções de como fazer seus jogos</h3>
                <p>Os jogos seram gerados conforme o ultimo concurso sorteado e não será gerado jogos ja sorteados 
                    iguais os concursos anteriores ja sorteados e permitindo repetidos apenas com 14 dezenas 
                    apontando as melheres ou conforme sua configuraçao para gerar seus jogos.
                </p>
                <label for="">Ultimo concurso: <?php echo $concurso; ?></label>
                <h3>Configure o estilo de seu(s) jogos</h3>

                <button>Configuração padrão</button>
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
                <p>
                    As demais configurações existente ja estam incluidas na configuração padrão.
                </p>
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
</body>
</html>