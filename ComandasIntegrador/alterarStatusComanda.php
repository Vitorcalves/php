<?php
    require_once "library/Database.php";
    require_once "library/Funcoes.php";
    var_dump($_GET['status'], $_GET['id']);
    if (isset($_GET['status'])) {

        $db = new Database();

        try {
            $id = $_GET['id'];
            $status = $_GET['status'];

            $result = $db->dbUpdate("UPDATE comanda
                                    SET SITUACAO_COMANDA = ?
                                    WHERE ID_COMANDA = ?",
                                    [
                                        $status,
                                       $id
                                    ]);

            if ($result) {
                header("Location: index.php");
            } else {
                echo "Erro ao alterar o status da comanda";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }