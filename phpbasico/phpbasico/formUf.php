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

if ($_GET['acao'] != "insert") {

    $dados = $db->dbSelect("SELECT * FROM uf WHERE id = ?", 'first', [$_GET['id']]);

};
?>

    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>UF<?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaUf.php" class="btn btn-outline-secondary btn-sm" title="Voltar">Voltar</a>
            </div>

        </div>

        <!--
            action => recebe a ação que foi adicionada no hyperlink da lista (insert, update, delete) mais Uf.php
        -->

        <form class="g-3" action="<?= $_GET['acao'] ?>Uf.php" method="POST">

            <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

            <div class="row">

                <div class="col-2">
                    <label for="sigla" class="form-label">Sigla</label>
                    <input type="text" class="form-control" name="sigla" id="sigla" 
                        placeholder="Sigla da UF" required autofocus
                        value="<?= isset($dados->sigla) ? $dados->sigla : "" ?>">
                </div>

                <div class="col-6">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" 
                        id="descricao" placeholder="Descriçào da UF" required
                        value="<?= isset($dados->descricao) ? $dados->descricao : "" ?>">
                </div>

                <div class="col-2">
                    <label for="statusRegistro" class="form-label">Status</label>
                    <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                        <option value=""  <?= isset($dados->statusRegistro) ? $dados->statusRegistro == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 1  ? "selected" : "" : "" ?>>Ativo</option>
                        <option value="2" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 2  ? "selected" : "" : "" ?>>Inativo</option>
                    </select>
                </div>

            </div>

            <div class="col-auto mt-5">
                <a href="listaUf.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
                <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm">Gravar</button>
                <?php endif; ?>
            </div>
        </form>

    </main>

    <?php

    require_once "comuns/rodape.php";