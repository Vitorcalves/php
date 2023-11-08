<?php
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    // Carrega cabeçalho HTML (header, nav, etc...)
    require_once "comuns/cabecalho.php";

    // carregando os helpers
    require_once "helpers/Formulario.php";

    if (!Funcoes::userLogado()) {
        return header("Location: viewLogin.php");
    }

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    // Buscar a lista de Rotas na base de dados

    $data = $db->dbSelect("SELECT * FROM rota ORDER BY descricao");

?>

    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Lista Rota de Viagem</h2>
            </div>
            <div class="col-2 text-end">
                <a href="formRota.php?acao=insert" class="btn btn-outline-success btn-sm" title="Novo">Nova</a>
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

        <table class="table table-striped table-hover table-bordered table-responsive-sm">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Descrição</th>
                    <th>Distância</th>
                    <th>Tempo de Viagem</th>
                    <th>Status</th>
                    <th>Opções</th>
                </tr>
            </<thead>
            <tbody>
                <?php
                    foreach ($data as $row) {
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['descricao'] ?></td>
                            <td><?= $row['distancia'] ?></td>
                            <td><?= $row['tempoViagem'] ?></td>
                            <td><?= getStatusDescricao($row['statusRegistro']) ?></td>
                            <td>
                                <a href="formRota.php?acao=update&id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração">Alterar</a>&nbsp;
                                <a href="formRota.php?acao=delete&id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                                <a href="formRota.php?acao=view&id=<?= $row['id'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
            
        </table>

    </main>

    <?php

    // Carrega o ropdapé HTML
    require_once "comuns/rodape.php";