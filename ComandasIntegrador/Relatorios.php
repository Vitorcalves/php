<?php
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    $dataAtual = date('Y-m-d');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Data</title>
</head>
<body>
    <h2>Informe o Período de Busca</h2>

    <form method="post" action="RelatorioSQL.php">
        <label for="data_inicial">Data Inicial:</label>
        <input type="date" id="data_inicial" name="data_inicial" value="<?php echo $dataAtual; ?>" required>

        <label for="data_final">Data Final:</label>
        <input type="date" id="data_final" name="data_final" value="<?php echo $dataAtual; ?>" required>

        <div class="container row mt-3">
            <div class="card text-center col-6">
                <div class="card-header col-6">
                    Relátorio de produtos vendidos
                </div>
        
                <div class="card-footer text-body-secondary col-6">
                    <button type="submit">Confirmar</button>
                </div>
            </div>
        </div>

        <div class="container row mt-3">
            <div class="card text-center col-6">
                <div class="card-header col-6">
                    Relátorio de faturamento no periodo
                </div>
        
                <div class="card-footer text-body-secondary col-6">
                    <button type="submit">Confirmar</button>
                </div>
            </div>
        </div>
    </form>


</body>
</html>