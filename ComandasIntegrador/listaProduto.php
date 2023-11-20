<?php

    require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    // Carrega cabeçalho HTML (header, nav, etc...)
    require_once "comuns/cabecalho.php";

    // carregando os helpers
    require_once "helpers/Formulario.php";

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    // ... Seu código anterior ...

    if (!isset($_GET['idComanda'])) {
        // Buscar a lista de Categorias de Produtos na base de dados
        $produtos = $db->dbSelect(
            "SELECT p.*, pc.descricao_categoria AS categoriaDescricao FROM produto AS p INNER JOIN produto_categoria as pc ON pc.ID_CATEGORIA = p.produtocategoria_id ORDER BY p.descricao"
        );
        
    } else {
        if ($_GET['acao'] == 'insert') {
            // Adicionar item à comanda: listar todos os produtos disponíveis
            $produtos = $db->dbSelect(
                "SELECT p.*, pc.descricao_categoria AS categoriaDescricao FROM produto AS p INNER JOIN produto_categoria as pc ON pc.ID_CATEGORIA = p.produtocategoria_id ORDER BY p.descricao"
            );
        } else if ($_GET['acao'] == 'delete') {
            // Remover item da comanda: listar apenas os produtos na comanda
            $produtos = $db->dbSelect(
                "SELECT 
                    p.*, 
                    pc.descricao_categoria AS categoriaDescricao,
                    COALESCE(SUM(ic.QUANTIDADE), 0) as totalQuantidade
                FROM 
                    produto AS p
                INNER JOIN 
                    produto_categoria as pc ON pc.ID_CATEGORIA = p.produtocategoria_id
                LEFT JOIN 
                    itens_comanda ic ON ic.PRODUTOS_ID_PRODUTOS = p.ID_PRODUTOS AND ic.COMANDA_ID_COMANDA = ?
                WHERE 
                    ic.COMANDA_ID_COMANDA IS NOT NULL
                GROUP BY 
                    p.ID_PRODUTOS
                ORDER BY 
                    p.descricao",
                'all',
                [$_GET['idComanda']]
            );
        }
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
                <?php foreach ($produtos as $produto) :  ?>
            
                    <tr>
                        <td><?= $produto['ID_PRODUTOS'] ?></td>
                        <td><?= $produto['descricao'] ?></td>
                        <td class="text-end"><?= number_format($produto['VALOR_UNITARIO'], 2, ",", ".") ?></td>
                        <td><?= $produto['QTD_ESTOQUE'] ?></td>
                        <td><?= $produto['categoriaDescricao'] ?></td>
                        <td>
                            <?php if (isset($_GET["idComanda"]) && $_GET['acao'] == 'insert') : ?>
                                <form class="g-3" action="inserirProdutoComanda.php" method="post" enctype="multipart/form-data">
                                    <label for="quantidade" class="form-label">Quantidade Adicionada</label>
                                    <select name="quantidade" id="quantidade" class="form-control" required>
                                        <option value="">...</option>
                                        <?php for ($i = 1; $i <= $produto['QTD_ESTOQUE']; $i++) { ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php }; ?>
                                    </select>
                                    <input type="hidden" name="idProduto" value="<?= $produto['ID_PRODUTOS'] ?>">
                                    <input type="hidden" name="idComanda" value="<?= $_GET['idComanda'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Adicionar</button>
                                </form>
                            <?php endif; ?>

                            <?php if (isset($_GET["idComanda"]) && $_GET['acao'] == 'delete') : ?>
                                <form class="g-3" action="deleteProdutoComanda.php" method="post" enctype="multipart/form-data">
                                    <label for="quantidadeRemover" class="form-label">Remover quantidade</label>
                                    <select name="quantidadeRemover" id="quantidadeRemover" class="form-control" required>
                                        <option value="">...</option>
                                        <?php for ($i = 1; $i <= $produto['totalQuantidade']; $i++) : ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <input type="hidden" name="idProduto" value="<?= $produto['ID_PRODUTOS'] ?>">
                                    <input type="hidden" name="idComanda" value="<?= $_GET['idComanda'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Remover</button>
                                </form>
                            
                            <?php endif; ?>

                            <?php if (!isset($_GET["idComanda"])) : ?>
                                <a href="formProduto.php?acao=update&id=<?= $produto['ID_PRODUTOS'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração">Alterar</a>&nbsp;
                                <a href="formProdutoComanda.php?acao=delete&id=<?= $produto['ID_PRODUTOS'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                                <a href="formProduto.php?acao=view&id=<?= $produto['ID_PRODUTOS'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
                           
        </table>

        <?php if (isset($_GET["idComanda"])) : /* botão gravar não é exibido na visualização dos dados */ ?>
            <button class="btn btn-primary" onclick="goBack()">Voltar</button>
        <?php endif; ?>

    </main>


    <script>

        function goBack() {
            window.history.back();
        }

    </script>

    <?php

        echo datatables("tbListaProduto");

        // Carrega o ropdapé HTML
        require_once "comuns/rodape.php";
