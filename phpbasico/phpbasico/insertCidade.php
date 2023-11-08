<?php

    if (isset($_POST['descricao'])) {

        try {

            $conn = new PDO(
                "mysql:host=localhost;dbname=phpbasico2023", 
                "root", 
                "",
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $data = $conn->prepare("INSERT INTO cidade 
                                    (nome, uf_id, statusRegistro)
                                    VALUES (?, ?, ?)");
            $data->execute([
                $_POST['nome'],
                $_POST['uf_id'],
                $_POST['statusRegistro']
            ]);

            if ($conn->lastInsertId() > 0) {
                return header("Location: listaCidade.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaCidade.php?msgError=Falha ao tentar inserir o registro.");
            }
            
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }

    } else {
        return header("Location: listaCidade.php");
    }