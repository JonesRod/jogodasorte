<?php

    include('../../../conexao.php');

    // Verifique se o último resultado foi registrado
    $resultado_existe = false;
    $msg =false;

    if(!isset($_SESSION)){
        session_start(); 
    }

    if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        $id = $_SESSION['usuario'];
        $sql_query = $conn->query("SELECT * FROM usuarios WHERE id = '$id'") or die($conn->error);
        $usuario = $sql_query->fetch_assoc(); 
        $saldo_str = $usuario ["creditos"];
        //echo $saldo_str;
        // Substitui ',' por '.' e converte para float
        /*$saldo = (float) str_replace(',', '.', $saldo_str);

        // Formata o saldo em moeda
        $saldo_formatado = number_format($saldo, 2, ',', '.');
        echo $saldo_formatado;*/

        $sql_config_lotofacil = $conn->query("SELECT * FROM config_lotofacil WHERE id = '1'") or die($conn->error);
        $valor = $sql_config_lotofacil->fetch_assoc();
        
        $valor_15 = $valor['valor_15'];
        $valor_16 = $valor['valor_16'];
        $valor_17 = $valor['valor_17'];
        $valor_18 = $valor['valor_18'];
        $valor_19 = $valor['valor_19'];
        $valor_20 = $valor['valor_20'];
        $qt_concurso_confere = $valor['qt_concurso_confere'];
        $qt_concurso_salva = $valor['qt_concurso_salva'];

    }/* else {
        // Se não houver uma sessão de usuário, redirecione para a página de login
        session_unset();
        session_destroy(); 
        header("Location: usuario_logout.php");  
        exit(); // Importante adicionar exit() após o redirecionamento
    }*/

    $sql = "SELECT * FROM resultados_lotofacil ORDER BY concurso DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $resultado_existe = true;
        $row = $result->fetch_assoc();

        // Existe um resultado no banco de dados
        $concurso = $row['concurso'];
        $data = $row['data']; // 2023/11/02
        $numeros = $row['numeros']; 

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
    <link rel="stylesheet" href="gerar_jogos.css?v=1.3">
    <!--<script src="excluir_dezenas.js?v=1.1"></script>-->

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
                <label id="ultimoconcurso" for="">Ultimo concurso: <?php echo $concurso . " - " . $data_formatada; ?></label><br>
                <input id="ultimo_concurso" type="hidden" value="<?php echo $concurso; ?>">
                <h4 id="numeros" for=""><?php echo $numeros ?></h4>
                <h3>Configure o estilo de seu(s) jogos</h3>

                <button id="config_padrao" onclick="config_padrao(), calcular()">Configuração padrão</button>
                <span class="tooltip" value="Adiciona a configuração pedrão. Essa configuração inclui todos os tipos de jogadas ainda não sorteadas">i</span>
                <div class="esc_excluir">
                    <h4 for="dez_excluidas">Escolha até 5 dezenas que você gostaria que não saissem no(s) jogo(s) (Opcional)</h4>
                    <div class="excluir">
                        <button>1</button>
                        <button>2</button>
                        <button>3</button>
                        <button>4</button>
                        <button>5</button>

                        <button>6</button>
                        <button>7</button>
                        <button>8</button>
                        <button>9</button>
                        <button>10</button>

                        <button>11</button>
                        <button>12</button>
                        <button>13</button>
                        <button>14</button>
                        <button>15</button>

                        <button>16</button>
                        <button>17</button>
                        <button>18</button>
                        <button>19</button>
                        <button>20</button>

                        <button>21</button>
                        <button>22</button>
                        <button>23</button>
                        <button>24</button>
                        <button>25</button>
                    </div>
                    <input readonly id="dezenas_excluidas" type="text">
                    <div id="contador1"></div>
                    <p>
                        <label for="qt_dezenas">Escolha com quantas dezenas você gostaria de gerar seu(s) jogo(s)? (Opcional)</label>
                        <input id="qt_dezenas" type="number"> 
                        <span class="tooltip" value="Você pode escolher entre 16 e 20 dezenas.">i</span>                         
                    </p>
                    <p>
                        <label for="qt_jogos">Quantos jogos você gostaria de fazer?</label>
                        <input id="qt_jogos" type="number">                         
                    </p>
                    <div id="instrucao_final">
                        As demais configurações existente ja estam incluidas na configuração padrão.
                    </div>

                    <input type="hidden" id="valor_15" value="<?php echo $valor_15 ;?>">
                    <input type="hidden" id="valor_16" value="<?php echo $valor_16 ;?>">
                    <input type="hidden" id="valor_17" value="<?php echo $valor_17 ;?>">
                    <input type="hidden" id="valor_18" value="<?php echo $valor_18 ;?>">
                    <input type="hidden" id="valor_19" value="<?php echo $valor_19 ;?>">
                    <input type="hidden" id="valor_20" value="<?php echo $valor_20 ;?>">
                    <input type="hidden" id="saldo_formatado" value="<?php echo $saldo_str ;?>">
                    <input type="hidden" id="valor_sem_formatacao">

                    <H3 id="valor"></H3>
                    <span id="alerta"></span>
                    <button id="gerar_jogo" onclick="gerar_jogo()">Gerar Jogo</button>
                </div>
                <div class="consultar">
                    <h3>Escolha de 15 a 20 dezenas.</h3>
                    <div class="numeros">
                        <button>1</button>
                        <button>2</button>
                        <button>3</button>
                        <button>4</button>
                        <button>5</button>

                        <button>6</button>
                        <button>7</button>
                        <button>8</button>
                        <button>9</button>
                        <button>10</button>

                        <button>11</button>
                        <button>12</button>
                        <button>13</button>
                        <button>14</button>
                        <button>15</button>

                        <button>16</button>
                        <button>17</button>
                        <button>18</button>
                        <button>19</button>
                        <button>20</button>

                        <button>21</button>
                        <button>22</button>
                        <button>23</button>
                        <button>24</button>
                        <button>25</button>
                    </div>
                    <input readonly id="dezenas" type="text">
                    <div id="contador2"></div>
                    <input id="qt_contador" type="hidden"></input>
                    <input id="valor_sem_milhar" type="hidden"></input>
                    <h3 id="valor_consulta"></h3>
                    <span id="alerta2"></span>
                    <button id="consultar_jogo" onclick="consultar_jogo()">Consultar Jogo</button> 
                </div>
            </div>
            <div class="listaMeusJogos">
                <h3>Lista de jogos gerados para o concurso escolhido</h3>
                <label for="lista_jogos">Concurso</label>
                <input type="text" id="lista_jogos">
                <button onclick="carregarJogos()">Carregar</button>
                <div id="tabelaJogos"></div>  
                <button onclick="compartilharlistaMeusJogos()">Compartilhar</button>                
            </div>
        </div>
        <div class="listaResultados">
            <h3>Lista de resultados do concurso escolhido</h3>
            <label for="">Concurso</label>
            <input type="text" id="lista_resultados">
            <button onclick="carregarResultados()">Carregar</button>
            <div id="tabelaResultados"></div>  
            <button onclick="compartilharlistaResultados()">Compartilhar</button>     
        </div>
    </div>
    <script>
        document.getElementById('qt_dezenas').addEventListener('input', function() {
            if (this.value < 15) {
                this.value = 15;
            }
            if (this.value > 20) {
                this.value = 20;
            }
        });
        document.getElementById('qt_jogos').addEventListener('input', function() {
            if (this.value < 1) {
                this.value = 1;
            }
        });
        
        document.getElementById('qt_dezenas').addEventListener('input', calcular);
        document.getElementById('qt_jogos').addEventListener('input', calcular);

        function compartilharlistaMeusJogos() {

            // Seu código para compartilhar dados
            //console.log("Compartilhando dados...");

            var tabelaResultados = document.getElementById("tabelaJogos").innerHTML;

            // Abra uma nova janela ou div para exibir a tabela
            var novaJanela = window.open('', '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
            novaJanela.document.write('<html><head><title>Tabela de jogos</title></head><body>');
            novaJanela.document.write('<h3>Lista de jogos</h3>');
            novaJanela.document.write(tabelaResultados);
            novaJanela.document.write('</body></html>');
            novaJanela.document.close();
        }
        function compartilharlistaResultados() {

            // Seu código para compartilhar dados
            //console.log("Compartilhando dados...");

            var tabelaResultados = document.getElementById("tabelaResultados").innerHTML;

            // Abra uma nova janela ou div para exibir a tabela
            var novaJanela = window.open('', '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
            novaJanela.document.write('<html><head><title>Tabela de Resultados</title></head><body>');
            novaJanela.document.write('<h3>Lista de resultados</h3>');
            novaJanela.document.write(tabelaResultados);
            novaJanela.document.write('</body></html>');
            novaJanela.document.close();
        }
    </script>

    <!--<script src="excluir_dezenas.js?v=1.1"></script>-->
    <script src="inclurir_dezenas.js?v=1.1"></script>
    <script src="carregar_jogos.js"></script>
    <script src="carregar_resultados.js"></script>
</body>
</html>