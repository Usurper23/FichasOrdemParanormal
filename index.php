<?php
require_once "./config/mysql.php";
is_user_logged_in();
header("X-Robots-Tag: all");
?><!doctype html>
<html lang="br">
    <head>
        <!-- Required meta tags -->
        <title>Fichas Ordem Paranormal</title>
        <link rel="stylesheet" href="https://fichasop.cf/assets/css/carousel.css">
        <?php
        require_once './includes/head.html';
        ?>
    </head>
    <body class="bg-black text-light">
        <?php require_once __DIR__ . "/includes/top.php";?>
        <main>

            <!-- Marketing messaging and featurettes
            ================================================== -->
            <!-- Wrap the rest of the page in another container to center all the content. -->

            <div class="container marketing">

                <!-- Three columns of text below the carousel -->
                <div class="row">
                    <div class="col-lg-4">
                        <img src="https://fichasop.cf/assets/img/Mauro%20-%20up%20.webp" width="150" height="150"
                             class="rounded-circle mx-3 border border-1 border-white">

                        <h2>Fichas Pré-Prontas.</h2>
                        <p>Para ja começar de jeito, disponibilizamos fichas de exeplo, onde poderá editar tudo ao seu
                            gosto!</p>
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <img src="https://fichasop.cf/assets/img/Man.webp" width="150" height="150"
                             class="bg-dark rounded-circle mx-3 border border-1 border-white">

                        <h2>Anonimato.</h2>
                        <p>Mantenha sua ficha privada, para não ser acessada ou vista por ninguêm.</p>
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <img src="https://fichasop.cf/assets/img/foto.webp" width="150" height="150"
                             class="bg-dark rounded-circle mx-3 border border-1 border-white">
                        <h2>Melhorando</h2>
                        <p>Há muita coisa à ser feita, estamos apenas começando, qualquer doação já é muito para ajudar! ^-^</p>
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->


                <!-- START THE FEATURETTES -->
                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">UI Limpa e minimalista</h2>
                        <p class="lead">Tudo isso para você se sentir o mais confortavel.</p>
                    </div>
                    <div class="col-md-5">
                        <img src="https://fichasop.cf/assets/img/atributo.webp" width="500" height="500"
                             class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">
                    </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7 order-md-2">
                        <h2 class="featurette-heading">Não tem como errar</h2>
                        <p class="lead">tudo é bem autoexplicativo e pensado em ajudar-lhe a usar.</p>
                    </div>
                    <div class="col-md-5 order-md-1">
                        <img src="https://fichasop.cf/assets/img/saude.webp" width="500" height="500"
                             class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">
                    </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">E por fim... <span class="text-muted"></span></h2>
                        <p class="lead">Não tem como deixar o principal de lado, sistema de rolar dados completissimo para
                            você.</p>
                    </div>
                    <div class="col-md-5">
                        <video src="https://fichasop.cf/assets/img/rolar.webm" width="500" height="500" playsinline autoplay muted loop
                             class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">

                    </div>
                </div>

            </div>
        </main>
        <footer class="container-fluid fixed-bottom text-white border-light border-top">
            <div class="clearfix">
                <div class="float-start text-start">
                    <a href="https://getbootstrap.com/" class="text-decoration-none"><img src="assets/img/bootstrap-logo.svg"
                                                                                          height="25" width="32" alt="..."/>
                        Bootstrap.</a>
                </div>
                <div class="float-end text-end">
                    Criado por <a href="mailto:ludafepi123456@gmail.com">Lucas</a>. Créditos ao <a
                            href="https://twitch.tv/cellbit/">Cellbit</a>
                </div>
            </div>
        </footer>
    </body>
</html>