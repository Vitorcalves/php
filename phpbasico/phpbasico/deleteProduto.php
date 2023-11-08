<?php
    require_once "library/Database.php";

    if (isset($_POST['id'])) {

        $db = new Database();

        try {
            $result = $db->dbDelete("DELETE FROM produto 
                                    WHERE id = ?",
                                    [$_POST['id']]
                                );

            if ($result) {

                // unlink, ele excluí a imagem fisicamente no servidor
                if (file_exists('uploads/produto/' . $_POST['excluirImagem'])) {
                    unlink('uploads/produto/' . $_POST['excluirImagem']);
                }

                return header("Location: listaProdutoCategoria.php?msgSucesso=Registro excluído com sucesso.");
            } else {
                return header("Location: listaProdutoCategoria.php?msgError=Falha ao tentar excluír o registro.");
            }
            
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }

    } else {
        return header("Location: listaProduto.php");
    }