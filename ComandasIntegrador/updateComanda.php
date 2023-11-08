<?php

require_once "library/Database.php";

if (isset($_POST['MESA_ID_MESA'])) {

    $db = new Database();

    try {
        $result = $db->dbUpdate("UPDATE comanda 
                                SET DESCRICAO_COMANDA = ?, MESA_ID_MESA = ?",
                                [
                                    $_POST['DESCRICAO_COMANDA'],
                                    $_POST['MESA_ID_MESA'],
                                ]);

        if ($result) {
            return header("Location: index.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: index.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }

} else {
    // return header("Location: index.php");
}