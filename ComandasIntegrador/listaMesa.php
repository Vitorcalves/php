<?php 

    require_once "helpers/protectNivel.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    $data = $db->dbSelect("SELECT 
        mesas.ID_MESA,
        mesas.DESCRICAO_MESA,
        mesas.SITUACAO_MESA,
        comanda.ID_COMANDA,
        comanda.SITUACAO_COMANDA,
        comanda.DESCRICAO_COMANDA,
        comanda.DATA_ABERTURA,
        comanda.DATA_FECHAMENTO
    FROM 
        mesas
    LEFT JOIN 
        comanda ON mesas.COMANDA_SITUACAO_COMANDA = comanda.ID_COMANDA");

?>

    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Lista de mesas utilizadas</h2>
            </div>
            <div class="col-2 text-end">
                <a href="formMesa.php?acao=insert" class="btn btn-outline-success btn-sm" title="Novo">Nova</a>
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

        <table id="tbListaProduto" class="table table-striped table-hover table-bordered table-responsive-sm mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Descrição</th>
                    <th>Situação Mesa</th>
                    <th>Comanda</th>
                    <th>Opções</th>
                </tr>
            </<thead>
            <tbody>
            <?php
            foreach ($data as $row) {
                ?>
                <tr>
                    <td><?= $row['ID_MESA'] ?></td>
                    <td><?= $row['DESCRICAO_MESA'] ?></td>
                    <td><?= situacaoMesa($row['SITUACAO_MESA']) ?></td>
                    <?php

                        $dataComanda = $db->dbSelect("SELECT ID_COMANDA, DATA_FECHAMENTO FROM comanda WHERE MESA_ID_MESA = ?", 'first', [$row['ID_MESA']]);

                        if ($dataComanda && $dataComanda->DATA_FECHAMENTO === null) {
                            $comandaId = $dataComanda->ID_COMANDA;
                        } else {
                            $comandaId = 'Sem comanda';
                        }

                        // Atualizar a coluna SITUACAO_COMANDA para "Sem comanda" se a data de fechamento não estiver definida
                        if ($comandaId === 'Sem comanda' && $row['SITUACAO_MESA'] !== 'Sem comanda') {
                            $db->dbUpdate("UPDATE mesas SET SITUACAO_MESA = '1' WHERE ID_MESA = ?", [$row['ID_MESA']]);
                        }
                    ?>
                    <td><?= $comandaId ?></td>
                    <td>
                        <a href="formMesa.php?acao=update&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração">Alterar</a>&nbsp;
                        <a href="formMesa.php?acao=delete&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                        <a href="formMesa.php?acao=view&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
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