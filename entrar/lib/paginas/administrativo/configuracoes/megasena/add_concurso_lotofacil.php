<?php
    include('../../../../conexao.php');

    $msg = false;

    $sql = "SELECT * FROM resultados_lotofacil ORDER BY concurso DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $concurso = $row['concurso'];
        
        $primeiro_numero = 1;
        $ultimo_numero = $concurso;

        $numeros_registrados = array();
        
        // Consulta SQL para obter os números já registrados no banco de dados
        $sql_numeros = "SELECT concurso FROM resultados_lotofacil";
        $result_numeros = $conn->query($sql_numeros);

        while ($row = $result_numeros->fetch_assoc()) {
            $numeros_registrados[] = $row['concurso'];
        }

        $numeros_faltando = array_diff(range($primeiro_numero, $ultimo_numero), $numeros_registrados);

        if (!empty($numeros_faltando)) {
            $msg_add = "Concurso(s) que precisa(m) ser inserido(s) no banco de dados: " . implode(", ", $numeros_faltando) . ".";
        } else {
            $msg_add = "Todos os concursos estão registrados no banco de dados.";
        }
    } else {
        $msg = "Não há números registrados no banco de dados.";
    }

    $conn->close();

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" href="add_concurso_lotofacil.css">
    <title>Add concurso da lotofacil</title>
</head>
<body>
    <div class="conteiner">
        <h2>Concursos a serem inseridos.</h2>
        <span id="msg1"><?php echo $msg; ?></span>

        <?php if(isset($msg_add) && $msg_add !== 0): ?>
            <span id="msg2"><?php echo $msg_add; ?>
                <form action="add_concurso_lotofacil_salvar.php" method="post" onsubmit="return validarFormulario()">
                    <h3>Preencha o formúlario conforme necessario</h3>
                    <p class="dados">
                        <label for="concurso">Concurso:</label>
                        <input required id="concurso" placeholder="0000" 
                        value="<?php if(isset($_POST['concurso'])) echo $_POST['concurso']; ?>" 
                        name="concurso" type="number">
                    </p>
                    <p class="dados">
                        <label for="data">Data:</label>
                        <input required id="data" placeholder="00/00/0000" 
                        value="<?php if(isset($_POST['data'])) echo $_POST['data']; ?>" 
                        name="data" type="text" oninput="formatarData(this)" onblur="validarData()"><br>
                    </p>
                    <div>
                        <h4>Numeros Sorteados</h4>
                        <div class="conjunto">
                            <p class="dez">
                                <label for="dez_1">1° dez</label>
                                <input required id="dez_1" 
                                value="<?php if(isset($_POST['dez_1'])) echo $_POST['dez_1']; ?>" 
                                name="dez_1" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p>
                            <p class="dez">
                                <label for="dez_2">2° dez</label>
                                <input required id="dez_2" 
                                value="<?php if(isset($_POST['dez_2'])) echo $_POST['dez_2']; ?>" 
                                name="dez_2" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_3">3° dez</label>
                                <input required id="dez_3" 
                                value="<?php if(isset($_POST['dez_3'])) echo $_POST['dez_3']; ?>" 
                                name="dez_3" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_4">4° dez</label>
                                <input required id="dez_4" 
                                value="<?php if(isset($_POST['dez_4'])) echo $_POST['dez_4']; ?>" 
                                name="dez_4" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_5">5° dez</label>
                                <input required id="dez_5" 
                                value="<?php if(isset($_POST['dez_5'])) echo $_POST['dez_5']; ?>" 
                                name="dez_5" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p>                            
                        </div>
                        <div class="conjunto">
                            <p class="dez">
                                <label for="dez_6">6° dez</label>
                                <input required id="dez_6" 
                                value="<?php if(isset($_POST['dez_6'])) echo $_POST['dez_6']; ?>" 
                                name="dez_6" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p>
                            <p class="dez">
                                <label for="dez_7">7° dez</label>
                                <input required id="dez_7" 
                                value="<?php if(isset($_POST['dez_7'])) echo $_POST['dez_7']; ?>" 
                                name="dez_7" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_8">8° dez</label>
                                <input required id="dez_8" 
                                value="<?php if(isset($_POST['dez_8'])) echo $_POST['dez_8']; ?>" 
                                name="dez_8" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_9">9° dez</label>
                                <input required id="dez_9" 
                                value="<?php if(isset($_POST['dez_9'])) echo $_POST['dez_9']; ?>" 
                                name="dez_9" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_10">10° dez</label>
                                <input required id="dez_10" 
                                value="<?php if(isset($_POST['dez_10'])) echo $_POST['dez_10']; ?>" 
                                name="dez_10" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p>                             
                        </div>
                        <div class="conjunto">
                            <p class="dez">
                                <label for="dez_11">11° dez</label>
                                <input required id="dez_11" 
                                value="<?php if(isset($_POST['dez_11'])) echo $_POST['dez_11']; ?>" 
                                name="dez_11" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p>
                            <p class="dez">
                                <label for="dez_12">12° dez</label>
                                <input required id="dez_12" 
                                value="<?php if(isset($_POST['dez_12'])) echo $_POST['dez_12']; ?>" 
                                name="dez_12" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_13">13° dez</label>
                                <input required id="dez_13" 
                                value="<?php if(isset($_POST['dez_13'])) echo $_POST['dez_13']; ?>" 
                                name="dez_13" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_14">14° dez</label>
                                <input required id="dez_14" 
                                value="<?php if(isset($_POST['dez_14'])) echo $_POST['dez_14']; ?>" 
                                name="dez_14" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p> 
                            <p class="dez">
                                <label for="dez_15">15° dez</label>
                                <input required id="dez_15" 
                                value="<?php if(isset($_POST['dez_15'])) echo $_POST['dez_15']; ?>" 
                                name="dez_15" type="text" oninput="validarDezena(this)" onblur="verifi_dez_iguais(this)">
                            </p>                             
                        </div>   
                    </div>
                    <p class="dados">
                        <label for="ganhadores_15_acertos">Ganhadores com 15 acertos:</label>
                        <input required id="ganhadores_15_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_15_acertos'])) echo $_POST['ganhadores_15_acertos']; ?>" 
                        name="ganhadores_15_acertos" type="number">
                    </p>
                    <p class="dados">
                        <label for="cidade_uf">Cidade/uf:</label>
                        <input required id="cidade_uf" placeholder="Cidade/uf" 
                        value="<?php if(isset($_POST['cidade_uf'])) echo $_POST['cidade_uf']; ?>" 
                        name="cidade_uf" type="text">
                    </p>
                    <p class="dados">
                        <label for="rateio_15_acertos">Rateio 15 acertos:</label>
                        <input required id="rateio_15_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_15_acertos'])) echo $_POST['rateio_15_acertos']; ?>" 
                        name="rateio_15_acertos" type="text">
                    </p>
                    <p class="dados">
                        <label for="ganhadores_14_acertos">Ganhadores com 14 acertos:</label>
                        <input required id="ganhadores_14_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_14_acertos'])) echo $_POST['ganhadores_14_acertos']; ?>" 
                        name="ganhadores_14_acertos" type="number">
                    </p>
                    <p class="dados">
                        <label for="rateio_14_acertos">Rateio 14 acertos:</label>
                        <input required id="rateio_14_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_14_acertos'])) echo $_POST['rateio_14_acertos']; ?>" 
                        name="rateio_14_acertos" type="text">
                    </p>
                    <p class="dados">
                        <label for="ganhadores_13_acertos">Ganhadores com 13 acertos:</label>
                        <input required id="ganhadores_13_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_13_acertos'])) echo $_POST['ganhadores_13_acertos']; ?>" 
                        name="ganhadores_13_acertos" type="number">
                    </p>
                    <p class="dados">
                        <label for="rateio_13_acertos">Rateio 13 acertos:</label>
                        <input required id="rateio_13_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_13_acertos'])) echo $_POST['rateio_13_acertos']; ?>" 
                        name="rateio_13_acertos" type="text">
                    </p>
                    <p class="dados">
                        <label for="ganhadores_12_acertos">Ganhadores com 12 acertos:</label>
                        <input required id="ganhadores_12_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_12_acertos'])) echo $_POST['ganhadores_12_acertos']; ?>" 
                        name="ganhadores_12_acertos" type="number">
                    </p>
                    <p class="dados">
                        <label for="rateio_12_acertos">Rateio 12 acertos:</label>
                        <input required id="rateio_12_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_12_acertos'])) echo $_POST['rateio_12_acertos']; ?>" 
                        name="rateio_12_acertos" type="text">
                    </p>
                    <p class="dados">
                        <label for="ganhadores_11_acertos">Ganhadores com 11 acertos:</label>
                        <input required id="ganhadores_11_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_11_acertos'])) echo $_POST['ganhadores_11_acertos']; ?>" 
                        name="ganhadores_11_acertos" type="number">
                    </p>
                    <p class="dados">
                        <label for="rateio_11_acertos">Rateio 11 acertos:</label>
                        <input required id="rateio_11_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_11_acertos'])) echo $_POST['rateio_11_acertos']; ?>" 
                        name="rateio_11_acertos" type="text">
                    </p>
                    <p class="dados">
                        <label for="acumulado_15_acertos">Acumulado 15 acertos:</label>
                        <input required id="acumulado_15_acertos" placeholder="" 
                        value="<?php if(isset($_POST['acumulado_15_acertos'])) echo $_POST['acumulado_15_acertos']; ?>" 
                        name="acumulado_15_acertos" type="text">
                    </p>
                    <p class="dados">
                        <label for="arrecadacao_total">Arrecadacao total:</label>
                        <input required id="arrecadacao_total" placeholder="" 
                        value="<?php if(isset($_POST['arrecadacao_total'])) echo $_POST['arrecadacao_total']; ?>" 
                        name="arrecadacao_total" type="text">
                    </p>
                    <p class="dados_acumulado">
                        <label for="valorAcumuladoConcursoEspecial">Acumulado para Sorteio Especial da Independência:</label>
                        <input required id="valorAcumuladoConcursoEspecial" placeholder="" 
                        value="<?php if(isset($_POST['valorAcumuladoConcursoEspecial'])) echo $_POST['valorAcumuladoConcursoEspecial']; ?>" 
                        name="valorAcumuladoConcursoEspecial" type="text">
                    </p>
                    <p class="dados">
                        <label for="dataProximoConcurso">Data para o próximo concurso:</label><br>
                        <input required id="dataProximoConcurso" placeholder="00/00/0000" 
                        value="<?php if(isset($_POST['dataProximoConcurso'])) echo $_POST['dataProximoConcurso']; ?>" 
                        name="dataProximoConcurso" type="text" oninput="formatarData(this)" onblur="validarData()">
                    </p>
                    <p class="dados_acumulado">
                        <label for="valorAcumuladoProximoConcurso">Estimativa de prêmio do próximo concurso:</label><br>
                        <input required id="valorAcumuladoProximoConcurso" placeholder="" 
                        value="<?php if(isset($_POST['valorAcumuladoProximoConcurso'])) echo $_POST['valorAcumuladoProximoConcurso']; ?>" 
                        name="valorAcumuladoProximoConcurso" type="text">
                    </p>
                    <button onclick="config_lotofacil()">Add Depois</button>
                    <button type="submit">Salvar</button>
                    
                </form>
            </span>
        <?php endif; ?>
    </div>  
    <script src="verifica_dados.js"></script>
</body>
</html>