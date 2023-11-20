<?php

    require_once "helpers/protectUser.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";
    

    $db = new Database();

    var_dump($_POST);
    $idComanda = (int)$_POST['idComanda'];
    $quantidadeRemover = (int)$_POST['quantidadeRemover'];
    $idProduto = (int)$_POST['idProduto'];
    $atualizadoBanco = false;
    $produtosComanda = $db->dbSelect("SELECT * FROM itens_comanda WHERE COMANDA_ID_COMANDA = ? ORDER BY COMANDA_ID_COMANDA" , 'all', [$_POST['idComanda']]);
    $produto = $db->dbSelect("SELECT * FROM produto WHERE ID_PRODUTOS = ?", 'fist', [$idProduto]);
    echo "<br>";
    $quantidadeEstoque = $produto->QTD_ESTOQUE - $quantidadeRemover;
    var_dump($quantidadeEstoque);
    echo "<br>";
    var_dump($produto);

    
    foreach ($produtosComanda as $item) {
        if($item['PRODUTOS_ID_PRODUTOS'] == $idProduto){
            // Subtrai a quantidade a ser removida da quantidade existente no item
            $quantidadeRemover = $item['QUANTIDADE'] - $quantidadeRemover;
    
            // Atualiza a tabela itens_comanda com a nova quantidade
            $db->dbUpdate("UPDATE itens_comanda SET QUANTIDADE = ? WHERE COMANDA_ID_COMANDA = ? AND PRODUTOS_ID_PRODUTOS = ?", [$quantidadeRemover, $idComanda, $idProduto]);
    
            // Atualiza a tabela produto com a nova quantidade em estoque
            $db->dbUpdate("UPDATE produto SET QTD_ESTOQUE = ? WHERE ID_PRODUTOS = ?", [$quantidadeEstoque, $idProduto]);

            $qtdZero = $db->dbDelete(
                "DELETE FROM itens_comanda
                 WHERE PRODUTOS_ID_PRODUTOS = ? AND COMANDA_ID_COMANDA = ? AND QUANTIDADE = 0",
                [$idProduto, $idComanda]
            );
    
            header("Location: visualizarItensComanda.php?idComanda=$idComanda");
            $atualizadoBanco = true;
        }
    }
    
    if ($atualizadoBanco == false){
        $db->dbInsert("INSERT INTO itens_comanda (QUANTIDADE, COMANDA_ID_COMANDA, PRODUTOS_ID_PRODUTOS) VALUES (?, ?, ?)", [$quantidadeRemover, $idComanda, $idProduto]);
        $db->dbUpdate("UPDATE produto SET QTD_ESTOQUE = ? WHERE ID_PRODUTOS = ?", [$quantidadeEstoque, $idProduto]);
        header("Location: visualizarItensComanda.php?idComanda=$idComanda");
    }
    
    var_dump($produto["QTD_ESTOQUE"]);
    




