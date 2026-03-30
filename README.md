<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de IMC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.2em;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 1.1em;
        }

        input[type="number"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
        }

        .resultado {
            margin-top: 30px;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            font-size: 1.2em;
            font-weight: 600;
            display: none;
        }

        .imc-abaixo { background: #ffeaa7; color: #2d3436; }
        .imc-normal { background: #00b894; color: white; }
        .imc-sobrepeso { background: #fdcb6e; color: #2d3436; }
        .imc-obesidade { background: #e17055; color: white; }
        .imc-obesidade-grave { background: #d63031; color: white; }

        .imc-value {
            font-size: 2.5em;
            font-weight: bold;
            margin: 10px 0;
        }

        .tabela-imc {
            margin-top: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            font-size: 0.9em;
        }

        .tabela-imc h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .tabela-imc table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabela-imc th, .tabela-imc td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .tabela-imc th {
            background: #667eea;
            color: white;
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px;
                margin: 10px;
            }
            
            h1 {
                font-size: 1.8em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🩺 Calculadora de IMC</h1>
        
        <form method="POST" id="formImc">
            <div class="form-group">
                <label for="peso">Peso (kg):</label>
                <input type="number" id="peso" name="peso" step="0.1" min="0" required placeholder="Ex: 70.5">
            </div>
            
            <div class="form-group">
                <label for="altura">Altura (m):</label>
                <input type="number" id="altura" name="altura" step="0.01" min="0" required placeholder="Ex: 1.75">
            </div>
            
            <button type="submit">Calcular IMC</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $peso = floatval($_POST['peso']);
            $altura = floatval($_POST['altura']);
            
            if ($peso > 0 && $altura > 0) {
                $imc = $peso / ($altura * $altura);
                $classificacao = classificarIMC($imc);
                
                echo "<div class='resultado {$classificacao['classe']}'>";
                echo "<div class='imc-value'>IMC: " . number_format($imc, 2, ',', '.') . "</div>";
                echo "<div>{$classificacao['texto']}</div>";
                echo "</div>";
            }
        }

        function classificarIMC($imc) {
            if ($imc < 18.5) {
                return [
                    'classe' => 'imc-abaixo',
                    'texto' => 'Abaixo do peso'
                ];
            } elseif ($imc < 25) {
                return [
                    'classe' => 'imc-normal',
                    'texto' => 'Peso normal'
                ];
            } elseif ($imc < 30) {
                return [
                    'classe' => 'imc-sobrepeso',
                    'texto' => 'Sobrepeso'
                ];
            } elseif ($imc < 35) {
                return [
                    'classe' => 'imc-obesidade',
                    'texto' => 'Obesidade grau I'
                ];
            } elseif ($imc < 40) {
                return [
                    'classe' => 'imc-obesidade',
                    'texto' => 'Obesidade grau II'
                ];
            } else {
                return [
                    'classe' => 'imc-obesidade-grave',
                    'texto' => 'Obesidade grau III'
                ];
            }
        }
        ?>

        <div class="tabela-imc">
            <h3>📊 Tabela de Classificação IMC</h3>
            <table>
                <thead>
                    <tr>
                        <th>IMC</th>
                        <th>Classificação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>< 18,5</td><td>Abaixo do peso</td></tr>
                    <tr><td>18,5 - 24,9</td><td>Peso normal</td></tr>
                    <tr><td>25,0 - 29,9</td><td>Sobrepeso</td></tr>
                    <tr><td>30,0 - 34,9</td><td>Obesidade I</td></tr>
                    <tr><td>35,0 - 39,9</td><td>Obesidade II</td></tr>
                    <tr><td>≥ 40,0</td><td>Obesidade III</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Validação em tempo real
        document.getElementById('formImc').addEventListener('submit', function(e) {
            const peso = parseFloat(document.getElementById('peso').value);
            const altura = parseFloat(document.getElementById('altura').value);
            
            if (peso <= 0 || altura <= 0) {
                e.preventDefault();
                alert('Por favor, insira valores válidos para peso e altura.');
            }
        });
    </script>
</body>
</html>
