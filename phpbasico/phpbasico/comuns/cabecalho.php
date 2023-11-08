<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>PHP Básico</title>

        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <script src="assets/js/jquery-3.3.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/jqueryMask.js"></script>

    </head>
    <body>

        <head class="container-fluid">

            <ul class="nav">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aempresa.php">Á empresa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produtos.php">Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="servicos.php">Serviços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="faleConosco.php">Fale Conosco</a>
                </li>

                <?php if (isset($_SESSION['userId'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $_SESSION['userNome'] ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="logoff.php">Logoff</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="listaUsuario.php">Usuário</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="listaUf.php">UF</a></li>
                            <li><a class="dropdown-item" href="listaCidade.php">Cidade</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="listaProdutoCategoria.php">Categoria de Produtos</a></li>
                            <li><a class="dropdown-item" href="listaProduto.php">Produtos/Serviços</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="listaRota.php">Rota</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="viewLogin.php">Área Administrativa</a>
                    </li>
                <?php endif; ?>

            </ul>

        </head>