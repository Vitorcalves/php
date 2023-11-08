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
        WHERE pc.tipo = 2 AND p.statusCadastro = 1
        ORDER BY p.descricao"
    );

    ?>

    <div class="container mb-5">

        <h2 class="mt-5 mb-5">Serviços</h2>

        <div class="row">

            <?php foreach ($data as $item): ?>

                <div class=" col-4">
                    <div class="card" style="width: 18rem;">
                        <img src="uploads/produto/<?= $item['imagem'] ?>" alt="..." class="card-img-top" width="200" height="200">
                        <div class="card-body">
                            <h6 class="card-title"><?= $item['descricao'] ?></h5>
                            <h4>R$ <strong><?= Funcoes::valorBr($item['precoVenda']) ?></strong></h4>
                            <p class="card-text"><?= substr($item['caracteristicas'], 0, 70) ?></p>
                            <a href="produtosDetalhes.php?id=<?= $item['id'] ?>" class="btn btn-primary">Mais detalhes</a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    </div>
    
    <?php

    // Carrega o ropdapé HTML
    require_once "comuns/rodape.php";