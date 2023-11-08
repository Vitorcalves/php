<?php
    require_once "library/Database.php";

    if (isset($_POST['descricao'])) {

        $db = new Database();

        try {
            $result = $db->dbUpdate("UPDATE rota 
                                    SET descricao = ?, distancia = ?, tempoViagem = ?, statusRegistro = ?
                                    WHERE id = ?",
                                    [
                                        $_POST['descricao'],
                                        $_POST['distancia'],
                                        $_POST['tempoViagem'],
                                        $_POST['statusRegistro'],
                                        $_POST['id']
                                    ]);

            if ($result) {
                return header("Location: listaRota.php?msgSucesso=Registro alterado com sucesso.");
            } else {
                return header("Location: listaRota.php?msgError=Falha ao tentar alterar o registro.");
            }
            
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }

    } else {
        return header("Location: listaRota.php");
    }