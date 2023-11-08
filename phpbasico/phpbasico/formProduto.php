<?php

require_once "helpers/Formulario.php";
require_once "comuns/cabecalho.php";
require_once "library/Database.php";
require_once "library/Funcoes.php";

if (!Funcoes::userLogado()) {
    return header("Location: viewLogin.php");
}

$db = new Database();
$dados = [];

$aCategoria = $db->dbSelect("SELECT * FROM produtocategoria ORDER BY descricao");

/*
*   Se for alteração, exclusão ou visualização busca a UF pelo ID que foi recebido via método GET
*/
if ($_GET['acao'] != "insert") {

    $dados = $db->dbSelect("SELECT * FROM produto WHERE id = ?", 'first', [$_GET['id']]);

}
?>

    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Produtos/Serviço<?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaProduto.php" class="btn btn-outline-secondary btn-sm" title="Voltar">Voltar</a>
            </div>

        </div>

        <!--
            action => recebe a ação que foi adicionada no hyperlink da lista (insert, update, delete) mais Uf.php
        -->

        <form class="g-3" action="<?= $_GET['acao'] ?>Produto.php" method="POST" 
            enctype="multipart/form-data">

            <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

            <div class="row">

                <div class="col-12">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" 
                        id="descricao" placeholder="Descriçào da categoria" required maxlength="50"
                        value="<?= isset($dados->descricao) ? $dados->descricao : "" ?>">
                </div>

                <div class="col-6">
                    <label for="produtocategoria_id" class="form-label">Categoria</label>
                    <select name="produtocategoria_id" id="produtocategoria_id" class="form-control" required>
                        <option value=""  <?= isset($dados->produtocategoria_id) ? $dados->produtocategoria_id == "" ? "selected" : "" : "" ?>>...</option>

                        <?php foreach ($aCategoria as $item): ?>
                            <option value="<?= $item['id'] ?>" <?= (isset($dados->produtocategoria_id) ? ($item['id'] == $dados->produtocategoria_id ?  "selected" : "" ) : "") ?>><?= $item['descricao'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-6">
                    <label for="statusCadastro" class="form-label">Status</label>
                    <select name="statusCadastro" id="statusCadastro" class="form-control" required>
                        <option value=""  <?= isset($dados->statusCadastro) ? $dados->statusCadastro == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->statusCadastro) ? $dados->statusCadastro == 1  ? "selected" : "" : "" ?>>Ativo</option>
                        <option value="2" <?= isset($dados->statusCadastro) ? $dados->statusCadastro == 2  ? "selected" : "" : "" ?>>Inativo</option>
                    </select>
                </div>

                <div class="col-4">
                    <label for="qtdeEmEstoque" class="form-label">Qtde Em Estoque</label>
                    <input type="text" class="form-control" name="qtdeEmEstoque" id="qtdeEmEstoque"  dir="rtl"
                            value="<?= isset($dados->qtdeEmEstoque) ? $dados->qtdeEmEstoque : '0,000' ?>">
                </div>

                <div class="col-4">
                    <label for="custoTotal" class="form-label">Custo Total Estoque</label>
                    <input type="text" class="form-control" name="custoTotal" id="custoTotal" dir="rtl" 
                            value="<?= isset($dados->custoTotal) ? $dados->custoTotal : '0,00' ?>">
                </div>

                <div class="col-4">
                    <label for="precoVenda" class="form-label">Preço de Venda</label>
                    <input type="text" class="form-control" name="precoVenda" id="precoVenda" dir="rtl"
                            value="<?= isset($dados->precoVenda) ? $dados->precoVenda : '0,00' ?>">
                </div>

                <div class="col-12">
                    <label for="caracteristicas" class="form-label">Características</label>
                    <textarea class="form-control" name="caracteristicas" id="caracteristicas"><?= isset($dados->caracteristicas) ? $dados->caracteristicas : "" ?></textarea>
                </div>
                
            </div>

            <h4 class="mt-3 mb-3">Imagem do Produto</h4>

            <?php if ($_GET['acao'] != "insert"): ?>
                <div class="row">
                    <div class="form-group col-12">
                        <img src="uploads/produto/<?= $dados->imagem ?>" alt="..." class="img-thumbnail" width="200" height="200">
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mt-3">
                <div class="form-group col-12 col-md-4">
                    <label for="imagem" class="form-label font-weight-bold">Imagem<span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file" name='imagem' id="imagem" accept="image/png, image/jpeg, image/jpg" <?= $_GET['acao'] == 'insert' ? 'required' : '' ?>>
                </div>
            </div>

            <input type="hidden" name="id" id="id" value="<?= (isset($dados->id) ? $dados->id : "") ?>">
            <input type="hidden" name="excluirImagem" id="excluirImagem" value="<?= (isset($dados->imagem) ? $dados->imagem : "") ?>">

            <div class="col-auto mt-5">
                <a href="listaProduto.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
                <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm">Gravar</button>
                <?php endif; ?>
            </div>
        </form>

    </main>

    <script src="assets/ckeditor5/ckeditor5-build-classic/ckeditor.js"></script>

    <script type="text/javascript">

        $(document).ready( function() { 
            $('#qtdeEmEstoque').mask('##.###.###.##0,000', {reverse: true});
            $('#custoTotal').mask('##.###.###.##0,00', {reverse: true});
            $('#precoVenda').mask('##.###.###.##0,00', {reverse: true});
        })

        ClassicEditor
            .create(document.querySelector('#caracteristicas'))
            .catch( error => {
                console.error(error);
            });

    </script>

    <?php

    require_once "comuns/rodape.php";