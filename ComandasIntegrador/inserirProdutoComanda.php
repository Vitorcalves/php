<?php

    require_once "helpers/protectUser.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();

    var_dump($_POST);
    $idComanda = (int)$_POST['idComanda'];
    $quantidade = (int)$_POST['quantidade'];
    $idProduto = (int)$_POST['idProduto'];
    $atualizadoBanco = false;
    $produtosComanda = $db->dbSelect("SELECT * FROM itens_comanda WHERE COMANDA_ID_COMANDA = ? ORDER BY COMANDA_ID_COMANDA" , 'all', [$_POST['idComanda']]);
    $produto = $db->dbSelect("SELECT * FROM produto WHERE ID_PRODUTOS = ?", 'fist', [$idProduto]);
    echo "<br>";
    $quantidadeEstoque = $produto->QTD_ESTOQUE - $quantidade;
    var_dump($quantidadeEstoque);
    echo "<br>";
    var_dump($produto);

    foreach ($produtosComanda as $item) {
        if($item['PRODUTOS_ID_PRODUTOS'] == $idProduto){
            $quantidade = $quantidade + $item['QUANTIDADE'];
            $db->dbUpdate("UPDATE itens_comanda SET QUANTIDADE = ? WHERE COMANDA_ID_COMANDA = ? AND PRODUTOS_ID_PRODUTOS = ?", [$quantidade, $idComanda, $idProduto]);
            $db->dbUpdate("UPDATE produto SET QTD_ESTOQUE = ? WHERE ID_PRODUTOS = ?", [$quantidadeEstoque, $idProduto]);
            header("Location: visualizarItensComanda.php?idComanda=$idComanda");
            $atualizadoBanco = true;
        }

    }

    if ($atualizadoBanco == false){
        $db->dbInsert("INSERT INTO itens_comanda (QUANTIDADE, COMANDA_ID_COMANDA, PRODUTOS_ID_PRODUTOS) VALUES (?, ?, ?)", [$quantidade, $idComanda, $idProduto]);
        $db->dbUpdate("UPDATE produto SET QTD_ESTOQUE = ? WHERE ID_PRODUTOS = ?", [$quantidadeEstoque, $idProduto]);
        header("Location: visualizarItensComanda.php?idComanda=$idComanda");
    }
    
    var_dump($produto["QTD_ESTOQUE"]);
    
    




