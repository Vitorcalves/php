<?php

    require_once "helpers/protectUser.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    $db = new Database();

    $data = $db->dbSelect("SELECT * FROM produto WHERE ID_PRODUTOS = ?", 'first', [$_GET['id']]);

    // Verifica se há dados
    if (!empty($data)) {
        $item = $data; // Atribui o único item ao $item
?>


    <main>
        <div class="container container-fluid">
            <div class="card col-12 align-items-center text-center pt-3" id="card-<?= $item->ID_PRODUTOS ?>">
                <img src="uploads/produto/<?= $item->IMAGEM ?>" class="img-fluid" alt="..."
                    style="width: 200px; height: 200px; max-width: 200px; max-height: 200px;">
                <div class="card-body">
                    <h5 class="card-title"> <?= $item->DESCRICAO ?> </h5>
                    <p class="card-text"> R$ <strong><?= ($item->VALOR_UNITARIO) ?></strong> </p>
                    <p class="card-text"><?= $item->CARACTERISTICAS ?></p>
                    <p class="card-text">Quantidade em estoque: <b><?= $item->QTD_ESTOQUE ?></b></p>
                    <button class="btn btn-primary" onclick="goBack()">Voltar</button>
                </div>
            </div>
        </div>
    </main>
    <script>

        function goBack() {
            window.history.back();
        }

    </script>

    <?php

        } else {
            echo "Nenhum dado encontrado.";
        }

        require_once "comuns/rodape.php";
    ?>
