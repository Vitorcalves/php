<?php

    /**
     * subTitulo
     *
     * @param string $acao 
     * @return string
     */
    function subTitulo($acao)
    {
        if ($acao == "insert") {
            return " - Inclusão";
        } elseif ($acao == "update") {
            return " - Alteração";
        } elseif ($acao == "delete") {
            return " - Exclusão";
        } elseif ($acao == "view") {
            return " - Visualização";
        }
    }

    /**
     * getNivelDescricao
     *
     * @param int $nivel 
     * @return string
     */
    function getNivelDescricao($nivel)
    {
        if ($nivel == 1) {
            return "Administrador";
        } elseif ($nivel == 2) {
            return "Usuário";
        } else {
            return "...";
        }
    }

    /**
     * getStatusDescricao
     *
     * @param int $status 
     * @return string
     */
    function getStatusDescricao($status)
    {
        if ($status == 1) {
            return "Aberta";
        } elseif ($status == 2) {
            return "Fechada";
        } else {
            return "...";
        }
    }

    /**
     * datatables
     *
     * @param string $idTable 
     * @return string
     */
    function datatables($idTable)
    {
        return '
            <script src="assets/DataTables/datatables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#' . $idTable . '").DataTable({
                        language:   {
                                        "sEmptyTable":      "Nenhum registro encontrado",
                                        "sInfo":            "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                        "sInfoEmpty":       "Mostrando 0 até 0 de 0 registros",
                                        "sInfoFiltered":    "(Filtrados de _MAX_ registros)",
                                        "sInfoPostFix":     "",
                                        "sInfoThousands":   ".",
                                        "sLengthMenu":      "_MENU_ resultados por página",
                                        "sLoadingRecords":  "Carregando...",
                                        "sProcessing":      "Processando...",
                                        "sZeroRecords":     "Nenhum registro encontrado",
                                        "sSearch":          "Pesquisar",
                                        "oPaginate": {
                                            "sNext":        "Próximo",
                                            "sPrevious":    "Anterior",
                                            "sFirst":       "Primeiro",
                                            "sLast":        "Último"
                                        },
                                        "oAria": {
                                            "sSortAscending":   ": Ordenar colunas de forma ascendente",
                                            "sSortDescending":  ": Ordenar colunas de forma descendente"
                                        }
                                    }
                    });
                });
            </script>';
    }

    /**
     * getMensagem
     *
     * @return string
     */
    function getMensagem()
    {
        if (isset($_GET['msgSucesso'])) {
            return '<div class="row">
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>' . $_GET['msgSucesso'] . '</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>';
        }

        if (isset($_GET['msgError'])) {
            return '<div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>' . $_GET['msgError'] . '</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>';
        }
    }