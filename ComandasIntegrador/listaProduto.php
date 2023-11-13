<?php

require_once "library/Database.php";

// Carrega cabeçalho HTML (header, nav, etc...)
require_once "comuns/cabecalho.php";

// carregando os helpers
require_once "helpers/Formulario.php";

// Criando o objeto Db para classe de base de dados
$db = new Database();

if (!isset($_GET['idComanda'])) {
    // Buscar a lista de Categorias de Produtos na base de dados
    $produtos = $db->dbSelect(
        "SELECT p.*, pc.descricao_categoria AS categoriaDescricao FROM produtos AS p INNER JOIN categoria as pc ON pc.ID_CATEGORIA = p.CATEGORIA_ID_CATEGORIA ORDER BY p.descricao"
    );
} else {
    $produtos = $db->dbSelect(
        "SELECT p.*, pc.descricao_categoria AS categoriaDescricao 
        FROM produtos AS p 
        INNER JOIN categoria as pc ON pc.ID_CATEGORIA = p.CATEGORIA_ID_CATEGORIA
        WHERE p.QTD_ESTOQUE >= 1
        ORDER BY p.descricao"
    );
}
?>

<main class="container mt-5">

    <div class="row">
        <div class="col-10">
            <h2>Lista Produtos/Serviços</h2>
        </div>
        <div class="col-2 text-end">
            <a href="formProduto.php?acao=insert" class="btn btn-outline-success btn-sm" title="Novo">Nova</a>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <?php if (isset($_GET['msgSucesso'])) : ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?= $_GET['msgSucesso'] ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php endif; ?>

            <?php if (isset($_GET['msgError'])) : ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?= $_GET['msgError'] ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php endif; ?>
        </div>
    </div>

    <table id="tbListaProduto" class="table table-striped table-hover table-bordered table-responsive-sm">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Qtd Estoque</th>
                <th>Categoria</th>
                <th>Opções</th>
            </tr>
            </<thead>
        <tbody>
            <?php
            foreach ($produtos as $row) {
            ?>
                <tr>
                    <td><?= $row['ID_PRODUTOS'] ?></td>
                    <td><?= $row['DESCRICAO'] ?></td>
                    <td class="text-end"><?= number_format($row['VALOR_UNITARIO'], 2, ",", ".") ?></td>
                    <td><?= $row['QTD_ESTOQUE'] ?></td>
                    <td><?= $row['categoriaDescricao'] ?></td>
                    <!-- <td><?= getStatusDescricao($row['STATUS_PRODUTO']) ?></td> -->
                    <td>
                        <?php if (isset($_GET["idComanda"])) : /* botão gravar não é exibido na visualização dos dados */ ?>
                            <!-- <button type="submit" class="btn btn-primary btn-sm">adicionar</button> -->
                            <form class="g-3" action="inserirProdutoComanda.php" method="post" enctype="multipart/form-data">
                                <label for="quantidade" class="form-label">Quantidade Adicionada</label>
                                <select name="quantidade" id="quantidade" class="form-control" required>
                                    <option value="">...</option>
                                    <?php for ($i = 1; $i <= $row['QTD_ESTOQUE']; $i++) {?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php }; ?>
                                </select>
                                <input type="hidden" name="idProduto" value="<?= $row['ID_PRODUTOS'] ?>">
                                <input type="hidden" name="idComanda" value="<?= $_GET['idComanda'] ?>">
                                <button type="submit" class="btn btn-primary btn-sm">adicionar</button>
                            </form>
                            <!-- <a href="inserirProdutoComanda.php?idProduto=<?= $row['ID_PRODUTOS'] ?>&idComanda=<?= $_GET['idComanda'] ?>" class="btn btn-primary btn-sm">adicionar</a> -->

                        <?php endif; ?>
                        <?php if (!isset($_GET["idComanda"])) : ?>

                            <a href="formProduto.php?acao=update&id=<?= $row['ID_PRODUTOS'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração">Alterar</a>&nbsp;
                            <a href="formProduto.php?acao=delete&id=<?= $row['ID_PRODUTOS'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                            <a href="formProduto.php?acao=view&id=<?= $row['ID_PRODUTOS'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>

    </table>

</main>

<?php

echo datatables("tbListaProduto");

// Carrega o ropdapé HTML
require_once "comuns/rodape.php";
