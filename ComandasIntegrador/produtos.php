<?php 

    require_once "library/Database.php";
    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    // verifica se a $_GET['search está vazio']
    if(!empty($_GET['search']))     
    {
        // atribui o valor de search a $dados
        $dados = $_GET['search'];

        // select de produtos de acordo com o id daquela categoria de produtos
        $data = $db->dbSelect("SELECT * FROM produto WHERE (VALOR_UNITARIO LIKE '%$dados%' OR descricao LIKE '%$dados%') ORDER BY descricao");

        // verifica se o objeto resultante $data não retornou nenhuma linha
        if (count($data) <= 0) {
            // retorna a mensagem de erro
            header("Location: produtos.php?msgError=Nenhum produto encontrado");
            exit(); // para o script

            // recupera todos os itens
            $data = $db->dbSelect("SELECT p.*, pc.descricao_categoria AS categoriaDescricao FROM produto AS p INNER JOIN produto_categoria as pc ON pc.ID_CATEGORIA = p.produtocategoria_id AND p. STATUS_PRODUTO = 1
            ORDER BY p.descricao");

    
        }

    } else
        {
        // se search for vazio recupera todos os itens pc.descricao = capa
        $data = $db->dbSelect(
            "SELECT p.*, pc.descricao_categoria AS categoriaDescricao
            FROM produto AS p 
            INNER JOIN produto_categoria as pc ON pc.ID_CATEGORIA = p.produtocategoria_id AND p.STATUS_PRODUTO = 1
            ORDER BY p.descricao"
        );
    }

    // carrega o cabecalho
    require_once "comuns/cabecalho.php";
    // carrega as funcoes
    require_once "library/Funcoes.php";
    // carregando os helpers
    require_once "helpers/Formulario.php";
?>

    <!-- inicio da página -->
    <main>
        <!-- exibe mensagem de erro ou sucesso se a mesma existir -->
        <div class="row">
            <div class="col-2 ms-2 mt-2">
            <?php if (isset($_GET['msgError'])): ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?= $_GET['msgError'] ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php endif; ?>
            </div>

        </div>

        <!-- barra de pesquisa -->
        <div class="box-search col-12">
            <input class="form-control mb-2 mt-4" id="pesquisarProduto" type="search" placeholder="Pesquisar">
            <button onclick="searchData()" class="btn btn-outline-secondary mb-2">Pesquisar</button>
        </div>
        <!-- fim da barra de pesquisa -->
        
        <!-- inicio dos cards -->
        <div class="container container-fluid mt-3">      
            <div class="row row-cols-md-3 g-4">
                <!-- recupera os dados do array $data e armazena cada linha na variável $item -->
                <?php foreach ($data as $item): ?> 
                    <div id="card-<?= $item['ID_PRODUTOS'] ?>" class="col-3">  
                        <img src="uploads/produto/<?= $item['imagem'] ?>" class="img-fluid" alt="..." style="width: 200px; height: 200px; max-width: 200px; max-height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title"> <?= $item['descricao'] ?> </h5>
                            <p class="card-text"> R$ <strong><?= Funcoes::valorBr($item['VALOR_UNITARIO']) ?></strong> </p>
                            <p class="card-text"><?= substr($item['caracteristicas'], 0, 70) ?></p>
                            <a href="produtosDetalhes.php?id=<?= $item['ID_PRODUTOS'] ?>" class="btn btn-primary">Mais detalhes</a>
                        </div>
                    </div>
            <!-- encerra o laço foreach -->
                <?php endforeach; ?>
            </div>
        </div> 
        <!-- fim dos cards -->
    </main>
    <!-- fim da página -->

    <script>
        // cria uma variavel search que busca o elemento que contem o id pesquisar
        var search = document.getElementById('pesquisarProduto');

        // captura o evento de click na tecla enter e chama a function searchData();
        search.addEventListener("keydown", function(event){
            if(event.key === "Enter")
            {
                searchData();
            }
        });

        // função serachData
        function searchData() 
        {
            // se a variavel search for verdadeira manda o valor de search para a url da página
            if (search) {
                window.location = 'produtos.php?search=' + search.value;

                // redirectPageSearch(capa);
            }
        }
    </script>
             
    <?php

    // Carrega o ropdapé HTML
    require_once "comuns/rodape.php";

    ?>
