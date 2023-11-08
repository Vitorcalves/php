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

/*
*   Se for alteração, exclusão ou visualização busca a UF pelo ID que foi recebido via método GET
*/
if ($_GET['acao'] != "insert") {

    $dados = $db->dbSelect("SELECT * FROM rota WHERE id = ?", 'first', [$_GET['id']]);

}
?>

    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Rota de Viagem<?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaRota.php" class="btn btn-outline-secondary btn-sm" title="Voltar">Voltar</a>
            </div>

        </div>

        <!--
            action => recebe a ação que foi adicionada no hyperlink da lista (insert, update, delete) mais Uf.php
        -->

        <form class="g-3" action="<?= $_GET['acao'] ?>Rota.php" method="POST">

            <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

            <div class="row">

                <div class="col-8">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" 
                        id="descricao" placeholder="Descriçào da Rota de viagem" required
                        value="<?= isset($dados->descricao) ? $dados->descricao : "" ?>">
                </div>

                <div class="col-4">
                    <label for="statusRegistro" class="form-label">Status</label>
                    <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                        <option value=""  <?= isset($dados->statusRegistro) ? $dados->statusRegistro == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 1  ? "selected" : "" : "" ?>>Ativo</option>
                        <option value="2" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 2  ? "selected" : "" : "" ?>>Inativo</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="distancia" class="form-label">Distância (km)</label>
                    <input type="number" class="form-control" name="distancia" 
                        id="distancia" placeholder="Distância (km)" required
                        min="0" max="99999"
                        value="<?= isset($dados->distancia) ? $dados->distancia : "" ?>">
                </div>

                <div class="col-6">
                    <label for="tempoViagem" class="form-label">Tempo viagem (horas)</label>
                    <input type="number" class="form-control" name="tempoViagem" 
                        id="tempoViagem" placeholder="Tempo viagem (horas)" 
                        required min="0" max="10000"
                        value="<?= isset($dados->tempoViagem) ? $dados->tempoViagem : "" ?>">
                </div>

            </div>

            <div class="col-auto mt-5">
                <a href="listaRota.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
                <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm">Gravar</button>
                <?php endif; ?>
            </div>
        </form>

    </main>

    <?php

    require_once "comuns/rodape.php";