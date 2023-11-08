<?php 

    require_once "comuns/cabecalho.php";
    require_once "helpers/Formulario.php";
    require_once "library/Database.php";

     // Criando o objeto Db para classe de base de dados
     $db = new Database();

     // Buscar a lista de Rotas na base de dados
 
     $data = $db->dbSelect("SELECT * FROM comanda ORDER BY ID_COMANDA");
?>

    <main class="container mt-5">
        <div class="row">
            <div class="col-10">
                <h2>Lista de comandas</h2>
            </div>
            <div class="col-2 text-end">
                <a href="formComanda.php?acao=insert" class="btn btn-outline-success btn-sm" title="Novo">Nova</a>
            </div>

        </div>

        <?= getMensagem() ?>

        <table id="tbListaComandas" class="table table-striped table-hover table-bordered table-responsive-sm">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Data abertura</th>
                    <th>Data fechamento</th>
                    <th>Cliente</th>
                    <th>Mesa</th>
                    <th>Status</th>
                    <th>Opções</th>
                </tr>
            </<thead>
            <tbody>
                <?php
                    foreach ($data as $row) {
                        ?>
                        <tr>
                            <td><?= $row['ID_COMANDA'] ?></td>
                            <td><?= $row['DATA_ABERTURA'] ?></td>
                            <td><?= $row['DATA_FECHAMENTO'] ?></td>
                            <td><?= $row['DESCRICAO_COMANDA'] ?></td>
                            <td><?= $row['MESA_ID_MESA'] ?></td>
                            <td><?= getStatusDescricao($row['SITUACAO_COMANDA']) ?></td>
                            <td>
                                <a href="formComanda.php?acao=update&id=<?= $row['ID_COMANDA'] ?>" class="btn btn-outline-primary btn-sm" title="Alteração">Alterar</a>&nbsp;
                                <a href="formComanda.php?acao=delete&id=<?= $row['ID_COMANDA'] ?>" class="btn btn-outline-danger btn-sm" title="Exclusão">Excluir</a>&nbsp;
                                <a href="formComanda.php?acao=view&id=<?= $row['ID_COMANDA'] ?>" class="btn btn-outline-secondary btn-sm" title="Visualização">Visualizar</a>
                                
                                
                                <button id="alterar_status" class="btn btn-outline-primary btn-sm" title="Alteração" onclick="alterar_status()"> <?= isset($row['SITUACAO_COMANDA']) ? ($row['SITUACAO_COMANDA'] == 1  ? "Fechar" : "Abrir") : "ERRO"?> </button>

                            </td>
                        </tr>
                        <script>
                            function alterar_status(){
                                let Status = <?= $row['SITUACAO_COMANDA'] ?>;
                                let id = <?= $row['ID_COMANDA'] ?>;
                                if(Status == 1){
                                    Status = 2;
                                }else{
                                    Status = 1;
                                }
                                window.location.href = "alterarStatusComanda.php?status="+Status+"&id="+id;
                                }
                        </script>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </main>

<?php

    echo datatables("tbListaComandas");

    // Carrega o ropdapé HTML
    require_once "comuns/rodape.php";
?>
