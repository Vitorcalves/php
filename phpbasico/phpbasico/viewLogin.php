<?php

    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";

    ?>

    <section class="about section-margin">

        <div class="container mt-5">
            <div class="row justify-content-center">

                <div class="col-6">
                    <div class="login_form_inner">

                        <h3 class="mb-4">Entre com seu Login</h3>

                        <form method="POST" class="row" action="login.php" id="contactForm">

                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'E-mail'" required>
                            </div>
                            <div class="col-md-12 form-group mt-2">
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Senha'" required>
                            </div>

                            <?php if (isset($_GET['msgError'])): ?>

                                <div class="col-12 mt-3">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong><?= $_GET['msgError'] ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <?php if (isset($_GET['msgSucesso'])): ?>

                                <div class="col-12 mt-3">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong><?= $_GET['msgSucesso'] ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <div class="col-12 form-group mt-3">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" value="submit" class="btn btn-outline-primary">Entrar</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <!--
                                        <a href="#">Esqueceu a senha?</a>
                                        -->
                                    </div>   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php

    // Carrega o ropdapé HTML
    require_once "comuns/rodape.php";