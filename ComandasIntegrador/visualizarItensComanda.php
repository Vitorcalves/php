<?php

    require_once "helpers/protectUser.php";
    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();
    $dados = [];


    $dados = $db->dbSelect("SELECT * FROM comanda WHERE ID_COMANDA = ?", 'first', [$_GET['idComanda']]);



    // $produtosComanda = $db->dbSelect("SELECT * FROM itens_comanda WHERE COMANDA_ID_COMANDA = ?", 'all', [$_GET['id']]);
    $produtos = $db->dbSelect("SELECT * FROM produto ORDER BY descricao");
    
    // $produtosComanda = $db->dbSelect("SELECT itens_comanda.*, produtos.DESCRICAO
    // FROM itens_comanda
    // INNER JOIN produtos ON itens_comanda.PRODUTOS_ID_PRODUTOS = produtos.ID_PRODUTO ORDER BY produtos.DESCRICAO");

    $produtosComanda = $db->dbSelect("SELECT itens_comanda.*, produto.*, produto.DESCRICAO, produto.VALOR_UNITARIO 
    FROM itens_comanda
    INNER JOIN produto ON itens_comanda.PRODUTOS_ID_PRODUTOS = produto.ID_PRODUTOS
    WHERE COMANDA_ID_COMANDA = ? 
    ORDER BY produto.DESCRICAO", 'all', [$_GET['idComanda']]);

    
?>
    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Produtos Comanda</h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaProduto.php?acao=insert&idComanda=<?= $_GET['idComanda'] ?>" class="btn btn-outline-success btn-sm" title="Nova">Novo</a>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <?php if (isset($_GET['msgSucesso'])): ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgSucesso'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                <?php endif; ?>

                <?php if (isset($_GET['msgError'])): ?>

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
                    <th>Numero Mesa</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Unidade</th>
                    <th>Valor Total Produto</th>
                    <th>Opções</th>
                </tr>
            </<thead>
            <tbody>
                <?php
                    $contador = 0;
                    foreach ($produtosComanda as $row) {
                        $contador++;
                ?>
                        <tr>
                            <td><?= $dados->MESA_ID_MESA ?></td>
                            <td><?= $row['DESCRICAO'] ?></td>
                            <td><?= $row['QUANTIDADE'] ?></td>
                            <td><?= $row['VALOR_UNITARIO'] ?> </td>
                            <td><?= total_valor($row["QUANTIDADE"],$row["VALOR_UNITARIO"]) ?></td>
                            <td>
                                <!-- <a href="formProdutoComanda.php?acao=update&id_produtos=<?= $row['PRODUTOS_ID_PRODUTOS'] ?>&idComanda=<?= $row['COMANDA_ID_COMANDA'] ?>" class="btn btn-outline-primary btn-sm"   title="Alteração">Alterar</a>&nbsp; -->
                                <!-- <a href="listaProduto.php?acao=delete&id_produtos=<?= $row['PRODUTOS_ID_PRODUTOS'] ?>&idComanda=<?= $row['COMANDA_ID_COMANDA'] ?>" class="btn btn-outline-danger btn-sm"    title="Exclusão">Excluir</a>&nbsp; -->
                                <a href="produtos.php?acao=view&id_produtos=<?= $row['PRODUTOS_ID_PRODUTOS'] ?>&idComanda=<?= $row['COMANDA_ID_COMANDA'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a></td>
                        </tr>
                    
                <?php
                        $total= $total + total_valor($row["QUANTIDADE"],$row["VALOR_UNITARIO"]);
                    }
                    var_dump($total)
                ?>
                
            </tbody>
            <th>Valor Total</th>
            <td>R$ <?= $total ?></td>
            
        </table>
     
            <a class="btn btn-primary" href="listaComanda.php">Voltar</a>

    </main>

    <?php

    echo datatables("tbListaProduto");

    // Carrega o ropdapé HTML
    require_once "comuns/rodape.php";