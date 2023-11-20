<?php

    // se a sessão não estiver sido iniciada inicia a sessão
    if(!isset($_SESSION)) {
        session_start();
    }

    // carrega o formulário
    require_once "helpers/Formulario.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de comandas</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="/css/estiloComanda.css">

    <script src="assets/js/jquery-3.3.1.js"></script>
    <!-- Sem esse cdn o dropdown na navBarCollapese não funciona -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <!-- Adiciona o bootstrap a página -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- Adicione a biblioteca jQuery se ainda não estiver incluída -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" id="navbar">
        <div class="d-flex justify-content-around">
            <a href="listaComanda.php"><img src="/img/logo.png" alt="Imagem logo" style="width: 120; height: 90px; padding: 10px; margin-right: 50px;"> </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="listaComanda.php">Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="produtos.php">Produtos</a>
                    </li>

                    <!-- Se o usuário estiver no nivel administrador mostra esse dropdown com as área administrativa -->
                    <?php if (isset($_SESSION['userId']) && ($_SESSION['userNivel'] == 1)): ?>
                    <li class="nav-item dropdown">
                        <!-- mostra o nome do usuário logado -->
                        <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $_SESSION['userNome'] //. " " . getNivelDescricao($_SESSION['userNivel']) ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Relatorios.php">Relatórios</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="listaUsuario.php">Usuários</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="listaProdutoCategoria.php">Categoria de Produtos</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="listaProduto.php">Produtos/Serviços</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <!-- <li><a class="dropdown-item" href="listaMesa.php">Mesas</a></li> -->
                            <li><a class="dropdown-item" href="listaMesa.php">Mesas utilizadas</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="listaFormaPagamento.php">Formas de pagamento</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logoff.php">Sair</a></li>
                        </ul>
                    </li>

                    <!-- se não estiver logado é executado esse codigo -->
                    <?php elseif (!isset($_SESSION['userNome'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Área administrativa</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item">
                                <a class="dropdown-item" href="index.php">Fazer login</a>
                            </li>
                        </ul>
                    </li>

                    <!-- se o usuário não for um administrador do sistema ele só tem a opção de deslogar -->
                    <?php else : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $_SESSION['userNome']  //. " " . getNivelDescricao($_SESSION['userNivel']) ?></a>
                        <ul class="dropdown-menu">
                            <li class="nav-item">
                                <a class="dropdown-item" href="logoff.php">Sair</a>
                            </li>
                        </ul>
                    </li>
                    <!-- finaliza o if -->
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>