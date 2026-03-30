<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de IMC</title>
</head>
<body>
    <div style="max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ccc;">
        <h1>Calculadora de IMC</h1>
        
        <?php
        // Função para calcular IMC
        function calcularIMC($peso, $altura) {
            return $peso / ($altura * $altura);
        }
        
        // Função para classificar IMC
        function classificarIMC($imc) {
            if ($imc < 16) {
                return "Magreza grave";
            } elseif ($imc >= 16 && $imc < 17) {
                return "Magreza moderada";
            } elseif ($imc >= 17 && $imc < 18.5) {
                return "Magreza leve";
            } elseif ($imc >= 18.5 && $imc < 25) {
                return "Saudável";
            } elseif ($imc >= 25 && $imc < 30) {
                return "Sobrepeso";
            } elseif ($imc >= 30 && $imc < 35) {
                return "Obesidade Grau I";
            } elseif ($imc >= 35 && $imc < 40) {
                return "Obesidade Grau II (severa)";
            } else {
                return "Obesidade Grau III (mórbida)";
            }
        }
        
        // Função para obter cor da classificação
        function corClassificacao($imc) {
            if ($imc < 18.5) {
                return "#ff6b6b"; // Vermelho claro - magreza
            } elseif ($imc < 25) {
                return "#51cf66"; // Verde - saudável
            } elseif ($imc < 30) {
                return "#ffd43b"; // Amarelo - sobrepeso
            } else {
                return "#ff4757"; // Vermelho - obesidade
            }
        }
        
        $resultado = '';
        $erro = '';
        
        if ($_POST) {
            $peso = filter_input(INPUT_POST, 'peso', FILTER_VALIDATE_FLOAT);
            $altura = filter_input(INPUT_POST, 'altura', FILTER_VALIDATE_FLOAT);
            
            if ($peso !== false && $altura !== false && $altura > 0) {
                $imc = calcularIMC($peso, $altura);
                $classificacao = classificarIMC($imc);
                $resultado = number_format($imc, 2, ',', '.') . ' - ' . $classificacao;
            } else {
                $erro = 'Por favor, insira valores válidos (peso em kg e altura em metros).';
            }
        }
        ?>
        
        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label for="peso">Peso (kg):</label><br>
                <input type="number" id="peso" name="peso" step="0.1" min="0" 
                       value="<?php echo isset($_POST['peso']) ? $_POST['peso'] : ''; ?>" 
                       style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="altura">Altura (m):</label><br>
                <input type="number" id="altura" name="altura" step="0.01" min="0" 
                       value="<?php echo isset($_POST['altura']) ? $_POST['altura'] : ''; ?>" 
                       style="width: 100%; padding: 8px; margin-top: 5px;">
                <small>Ex: 1.75 para 1,75m</small>
            </div>
            
            <button type="submit" style="width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer;">
                Calcular IMC
            </button>
        </form>
        
        <?php if ($erro): ?>
            <div style="color: #dc3545; background: #f8d7da; padding: 10px; margin: 15px 0; border: 1px solid #f5c6cb;">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($resultado): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; margin: 20px 0; border: 1px solid #c3e6cb; 
                        border-left: 5px solid <?php echo corClassificacao(calcularIMC(filter_input(INPUT_POST, 'peso', FILTER_VALIDATE_FLOAT), filter_input(INPUT_POST, 'altura', FILTER_VALIDATE_FLOAT))); ?>;">
                <h3 style="margin: 0 0 10px 0;">Seu IMC: <strong><?php echo $resultado; ?></strong></h3>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border: 1px solid #dee2e6;">
            <h3>Tabela de Classificação IMC</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #007bff; color: white;">
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Classificação</th>
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">IMC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background: #ffeaa7;">
                        <td style="padding: 8px; border: 1px solid #ddd;">Magreza grave</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">&lt; 16</td>
                    </tr>
                    <tr style="background: #fab1a0;">
                        <td style="padding: 8px; border: 1px solid #ddd;">Magreza moderada</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">16 - 16,99</td>
                    </tr>
                    <tr style="background: #fdcb6e;">
                        <td style="padding: 8px; border: 1px solid #ddd;">Magreza leve</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">17 - 18,49</td>
                    </tr>
                    <tr style="background: #00b894;">
                        <td style="padding: 8px; border: 1px solid #ddd;">Saudável</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">18,5 - 24,99</td>
                    </tr>
                    <tr style="background: #fd79a8;">
                        <td style="padding: 8px; border: 1px solid #ddd;">Sobrepeso</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">25 - 29,99</td>
                    </tr>
                    <tr style="background: #e17055;">
                        <td style="padding: 8px; border: 1px solid #ddd;">Obesidade Grau I</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">30 - 34,99</td>
                    </tr>
                    <tr style="background: #d63031;">
                        <td style="padding: 8px; border: 1px solid #ddd;">Obesidade Grau II (severa)</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">35 - 39,99</td>
                    </tr>
                    <tr style="background: #a29bfe;">
                        <td style="padding: 8px; border: 1px solid #ddd;">Obesidade Grau III (mórbida)</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">≥ 40</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
