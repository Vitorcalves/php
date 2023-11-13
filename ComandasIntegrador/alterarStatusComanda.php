<?php
    require_once "library/Database.php";
    require_once "library/Funcoes.php";
    if (isset($_GET['status'])) {

        $db = new Database();

        try {
            $id = $_GET['id'];
            $status = $_GET['status'];
            

            if ($status == 2) {
                $horario = date('Y-m-d H:i:s');

                $result = $db->dbUpdate("UPDATE comanda
                                        SET SITUACAO_COMANDA = ?,
                                        DATA_FECHAMENTO = ?
                                        WHERE ID_COMANDA = ?",

                                        [
                                            $status,
                                            $horario,
                                            $id
                                            
                                        ]);
    
                if ($result) {
                    header("Location: listaComanda.php");
                } else {
                    echo "Erro ao alterar o status da comanda";
                }

            } else {
                $result = $db->dbUpdate("UPDATE comanda
                                        SET SITUACAO_COMANDA = ?,
                                        DATA_FECHAMENTO = ?
                                        WHERE ID_COMANDA = ?",

                                        [
                                            $status,
                                            null,
                                            $id
                                            
                                        ]);
    
                if ($result) {
                    header("Location: listaComanda.php");
                } else {
                    echo "Erro ao alterar o status da comanda";
                }
            }

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }