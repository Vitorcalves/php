<?php

    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";
    
    // carregando os helpers
    require_once "helpers/Formulario.php";

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    // Buscar a lista de Produtos

    $data = $db->dbSelect(
        "SELECT p.*, pc.descricao AS categoriaDescricao
        FROM produto AS p 
        INNER JOIN produtocategoria as pc ON pc.id = p.produtocategoria_id
        WHERE p.id = ?",
        'first',
        [$_GET['id']]
    );

    ?>

    <div class="container mb-5">

        <h2 class="mt-5 mb-5">Detalhes do Produto</h2>

        <p><?= $data->descricao ?></p>

        <h4>Características</h4>
        <p><?= $data->caracteristicas ?></p>

        <p>Preço R$ <strong><?= Funcoes::valorBr($data->precoVenda) ?></strong></p>
        
        <img src="uploads/produto/<?= $data->imagem ?>" alt="..." class="img-responsive" width="200" height="200">

        <p class="mt-5 mb-5">
            <a href="produtos.php" title="Voltar">Voltar</a>
        </p>

    </div>  

    <?php

    require_once "comuns/rodape.php";