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
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        .conteiner {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /*sombra*/

        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        #msg1 {
            color: blue;
        }
        #msg2 {
            color: blue;
        }
        #msg2 h3{
            color: #333;
        }

        #msg2 label {
            color: #333;
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            text-align: left;
            margin-left: 15px;
        }

        input{
            width: 85%;
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            text-align: left;
            display: block;
            margin-left: 15px;
        }

        button {
            padding: 10px 20px;
            margin: 20px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s, font-size 0.3s; 

        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

    </style>
    <script>
        function inicio_lotofacil_home() {
            window.location.href = 'inicio_lotofacil_home.php';
        }
    </script>
    <title>Add concurso da lotofacil</title>
</head>
<body>
    <div class="conteiner">
        <h2>Concursos a serem inseridos.</h2>
        <span id="msg1"><?php echo $msg; ?></span>

        <?php if(isset($msg_add) && $msg_add !== 0): ?>
            <span id="msg2"><?php echo $msg_add; ?>
                <form action="" method="post">
                    <h3>Preencha o formúlario conforme necessario</h3>
                    <p>
                        <label for="concurso">Concurso:</label>
                        <input required id="concurso" placeholder="0000" 
                        value="<?php if(isset($_POST['concurso'])) echo $_POST['concurso']; ?>" 
                        name="concurso" type="number"><br>
                    </p>
                    <p>
                        <label for="data">Data:</label>
                        <input required id="data" placeholder="00/00/0000" 
                        value="<?php if(isset($_POST['data'])) echo $_POST['data']; ?>" 
                        name="data" type="text"><br>
                    </p>
                    <p>
                        <label for="numeros">Numeros Sorteados:</label>
                        <input required id="numeros" placeholder="1,11,..." 
                        value="<?php if(isset($_POST['numeros'])) echo $_POST['numeros']; ?>" 
                        name="numeros" type="text"><br>
                    </p>
                    <p>
                        <label for="ganhadores_15_acertos">Ganhadores com 15 acertos:</label>
                        <input required id="ganhadores_15_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_15_acertos'])) echo $_POST['ganhadores_15_acertos']; ?>" 
                        name="ganhadores_15_acertos" type="number"><br>
                    </p>
                    <p>
                        <label for="cidade_uf">Cidade/uf:</label>
                        <input required id="cidade_uf" placeholder="Cidade/uf" 
                        value="<?php if(isset($_POST['cidade_uf'])) echo $_POST['cidade_uf']; ?>" 
                        name="cidade_uf" type="text" ><br>
                    </p>
                    <p>
                        <label for="rateio_15_acertos">Rateio 15 acertos:</label>
                        <input required id="rateio_15_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_15_acertos'])) echo $_POST['rateio_15_acertos']; ?>" 
                        name="rateio_15_acertos" type="text"><br>
                    </p>
                    <p>
                        <label for="ganhadores_14_acertos">Ganhadores com 14 acertos:</label>
                        <input required id="ganhadores_14_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_14_acertos'])) echo $_POST['ganhadores_14_acertos']; ?>" 
                        name="ganhadores_14_acertos" type="number"><br>
                    </p>
                    <p>
                        <label for="rateio_14_acertos">Rateio 14 acertos:</label>
                        <input required id="rateio_14_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_14_acertos'])) echo $_POST['rateio_14_acertos']; ?>" 
                        name="rateio_14_acertos" type="text" ><br>
                    </p>
                    <p>
                        <label for="ganhadores_13_acertos">Ganhadores com 13 acertos:</label>
                        <input required id="ganhadores_13_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_13_acertos'])) echo $_POST['ganhadores_13_acertos']; ?>" 
                        name="ganhadores_13_acertos" type="number"><br>
                    </p>
                    <p>
                        <label for="rateio_13_acertos">Rateio 13 acertos:</label>
                        <input required id="rateio_13_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_13_acertos'])) echo $_POST['rateio_13_acertos']; ?>" 
                        name="rateio_13_acertos" type="text"><br>
                    </p>
                    <p>
                        <label for="ganhadores_12_acertos">Ganhadores com 12 acertos:</label>
                        <input required id="ganhadores_12_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_12_acertos'])) echo $_POST['ganhadores_12_acertos']; ?>" 
                        name="ganhadores_12_acertos" type="number"><br>
                    </p>
                    <p>
                        <label for="rateio_12_acertos">Rateio 12 acertos:</label>
                        <input required id="rateio_12_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_12_acertos'])) echo $_POST['rateio_12_acertos']; ?>" 
                        name="rateio_12_acertos" type="text"><br>
                    </p>
                    <p>
                        <label for="ganhadores_11_acertos">Ganhadores com 11 acertos:</label>
                        <input required id="ganhadores_11_acertos" placeholder="" 
                        value="<?php if(isset($_POST['ganhadores_11_acertos'])) echo $_POST['ganhadores_11_acertos']; ?>" 
                        name="ganhadores_11_acertos" type="number"><br>
                    </p>
                    <p>
                        <label for="rateio_11_acertos">Rateio 11 acertos:</label>
                        <input required id="rateio_11_acertos" placeholder="" 
                        value="<?php if(isset($_POST['rateio_11_acertos'])) echo $_POST['rateio_11_acertos']; ?>" 
                        name="rateio_11_acertos" type="text"><br>
                    </p>
                    <p>
                        <label for="acumulado_15_acertos">Acumulado 15 acertos:</label>
                        <input required id="acumulado_15_acertos" placeholder="" 
                        value="<?php if(isset($_POST['acumulado_15_acertos'])) echo $_POST['acumulado_15_acertos']; ?>" 
                        name="acumulado_15_acertos" type="text"><br>
                    </p>
                    <p>
                        <label for="arrecadacao_total">Arrecadacao total:</label>
                        <input required id="arrecadacao_total" placeholder="" 
                        value="<?php if(isset($_POST['arrecadacao_total'])) echo $_POST['arrecadacao_total']; ?>" 
                        name="arrecadacao_total" type="text"><br>
                    </p>
                    <p>
                        <label for="valorAcumuladoConcursoEspecial">Acumulado para Sorteio Especial da Independência:</label>
                        <input required id="valorAcumuladoConcursoEspecial" placeholder="" 
                        value="<?php if(isset($_POST['valorAcumuladoConcursoEspecial'])) echo $_POST['valorAcumuladoConcursoEspecial']; ?>" 
                        name="valorAcumuladoConcursoEspecial" type="text"><br>
                    </p>
                    <p>
                        <label for="valorAcumuladoProximoConcurso">Estimativa de prêmio do próximo concurso:</label>
                        <input required id="valorAcumuladoProximoConcurso" placeholder="" 
                        value="<?php if(isset($_POST['valorAcumuladoProximoConcurso'])) echo $_POST['valorAcumuladoProximoConcurso']; ?>" 
                        name="valorAcumuladoProximoConcurso" type="text"><br>
                    </p>
                    <button onclick="inicio_lotofacil_home()">Inicio</button>
                    <button type="submit">Salvar</button>
                </form>
            </span>
        <?php endif; ?>
    </div>  
</body>
</html>