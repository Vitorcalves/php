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
          comanda ON mesas.COMANDA_ID_COMANDA = comanda.ID_COMANDA");

    // $data = $db->dbSelect("SELECT * FROM mesas");

    // $data = $db->dbSelect("SELECT 
    //     mesas.ID_MESA,
    //     mesas.DESCRICAO_MESA,
    //     mesas.SITUACAO_MESA,
    //     mesas.COMANDA_ID_COMANDA, 
    //     comanda.ID_COMANDA
    // FROM 
    //     mesas
    // INNER JOIN 
    //     comanda ON mesas.COMANDA_ID_COMANDA = comanda.ID_COMANDA;
    // ");

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

        <table id="tbListaProduto" class="table table-striped table-hover table-bordered table-responsive-sm">
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
                var_dump($row['ID_COMANDA']);
                ?>
                <tr>
                    <td><?= $row['ID_MESA'] ?></td>
                    <td><?= $row['DESCRICAO_MESA'] ?></td>
                    <td><?= situacaoMesa($row['SITUACAO_MESA']) ?></td>
                    <td><?= ($row['ID_COMANDA'] !== null) ? $row['ID_COMANDA'] : 'Sem comanda' ?></td>
                    <td>
                        <a href="formMesa.php?acao=update&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração">Alterar</a>&nbsp;
                        <a href="formMesa.php?acao=delete&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                        <a href="formMesa.php?acao=view&id=<?= $row['ID_MESA'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                    </td>
                </tr>

                

                <?php
            }
                
                
                $dataMesa = $db->dbSelect("SELECT 
                c.ID_COMANDA,
                c.SITUACAO_COMANDA,
                c.DESCRICAO_COMANDA,
                c.DATA_ABERTURA,
                c.DATA_FECHAMENTO,
                m.ID_MESA,
                m.DESCRICAO_MESA,
                m.SITUACAO_MESA
                FROM 
                    comanda c
                INNER JOIN 
                    mesas m ON c.MESA_ID_MESA = m.ID_MESA");
                    
                foreach ($dataMesa as $comandaRow) {
                    // Aqui, use $comandaRow para acessar os resultados da segunda consulta
                    $novaSituacao = ($comandaRow['SITUACAO_COMANDA'] == 2) ? 1 : 2;
                    $db->dbUpdate("UPDATE mesas SET SITUACAO_MESA = ? WHERE ID_MESA = ?", [$novaSituacao, $comandaRow['ID_MESA']]);
                    // Adicione mensagens de debug
                    echo "Mesa ID: " . $comandaRow['ID_MESA'] . ", Situação Comanda: " . $comandaRow['SITUACAO_COMANDA'] . "<br>";
                }
                
         
            // Saída para debug
            echo "Atualização concluída.";

            ?>
            </tbody>
        </table>
    </main>

    <?php

        echo datatables("tbListaProduto");

        // Carrega o ropdapé HTML
        require_once "comuns/rodape.php";