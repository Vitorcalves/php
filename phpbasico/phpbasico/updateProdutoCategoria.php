<?php
    require_once "library/Database.php";

    if (isset($_POST['descricao'])) {

        $db = new Database();

        try {
            $result = $db->dbUpdate("UPDATE produtocategoria 
                                    SET descricao = ?, tipo = ?, statusRegistro = ?
                                    WHERE id = ?",
                                    [
                                        $_POST['descricao'],
                                        $_POST['tipo'],
                                        $_POST['statusRegistro'],
                                        $_POST['id']
                                    ]);

            if ($result) {
                return header("Location: listaProdutoCategoria.php?msgSucesso=Registro alterado com sucesso.");
            } else {
                return header("Location: listaProdutoCategoria.php?msgError=Falha ao tentar alterar o registro.");
            }
            
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }

    } else {
        return header("Location: listaProdutoCategoria.php");
    }