<?php
    require_once "library/Database.php";

    if (isset($_POST['descricao'])) {

        $db = new Database();

        try {

            $result = $db->dbInsert("INSERT INTO rota 
                                    (descricao, distancia, tempoViagem, statusRegistro)
                                    VALUES (?, ?, ?, ?)",
                                    [
                                        $_POST['descricao'],
                                        $_POST['distancia'],
                                        $_POST['tempoViagem'],
                                        $_POST['statusRegistro']
                                    ]);

            if ($result) {
                return header("Location: listaRota.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaRota.php?msgError=Falha ao tentar inserir o registro.");
            }
            
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }

    } else {
        return header("Location: listaRota.php");
    }