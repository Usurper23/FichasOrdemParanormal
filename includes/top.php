
<header class="font5 fixed-top border-bottom border-light bg-black" id="header">
    <div class="d-flex flex-wrap">
        <div class="col">
            <a class="btn btn-sm fw-bolder text-light" href='/'><i class="fa-regular fa-house-blank"></i> Inicio</a><!--
            --><a class="btn btn-sm fw-bolder text-light" href='/creditos'><i class="fa-regular fa-bars"></i> Créditos</a><!--
            --><a class="btn btn-sm fw-bolder text-white" data-bs-toggle="modal" data-bs-target="#doar"><i class="fa-regular fa-heart"></i> Doar</a>
            </div>
        <div class="col-auto d-none d-md-block">
            <?php if (isset($_SESSION["UserID"])) { ?>
                <a class="btn btn-sm fw-bolder text-warning" data-bs-toggle="modal" data-bs-target="#perfil"><i class="fa-regular fa-user"></i> Conta</a>
                <a class="btn btn-sm fw-bolder text-success" href='/sessao'><i class="fa-solid fa-dice-d10"></i> Sessões de RPG</a>
                <a class="btn btn-sm fw-bolder text-danger" href='/encerrar'><i class="fa-regular fa-user-xmark"></i> Encerrar Sessão</a>
            <?php } else { ?>
                <a class="btn btn-sm fw-bolder text-danger" data-bs-toggle="modal" data-bs-target="#cadastrar"><i class="fa-regular fa-user-plus"></i> Sou novo</a>
                <a class="btn btn-sm fw-bolder text-success" data-bs-toggle="modal" data-bs-target="#logar"><i class="fa-regular fa-user-check"></i> Entrar</a>
            <?php } ?>
            <a class="btn btn-sm fw-bolder text-light" href='https://discord.gg/QgKzg9FmUD'><i class="fa-regular fa-circle-question"></i> Ajuda</a>
        </div>

        <div class="col-auto dropdown d-md-none">
            <button title="Menu" class="btn btn-sm text-light" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-bars"></i></button>
            <div class="dropdown-menu dropdown-menu-dark" title="Menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item text-light" href='https://discord.gg/QgKzg9FmUD'><i class="fa-regular fa-circle-question"></i> Ajuda</a>
                <?php if (isset($_SESSION["UserID"])) { ?>
                    <a class="dropdown-item fw-bolder text-warning" data-bs-toggle="modal" data-bs-target="#perfil"><i class="fa-regular fa-user"></i> Conta</a>
                    <a class="dropdown-item fw-bolder text-success" href='/sessao'><i class="fa-solid fa-dice-d10"></i> Sessões de RPG</a>
                    <a class="dropdown-item fw-bolder text-danger" href='/encerrar'><i class="fa-regular fa-user-xmark"></i> Encerrar Sessão</a>
                <?php } else { ?>
                    <a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#cadastrar"><i class="fa-regular fa-user-plus"></i> Sou novo</a>
                    <a class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#logar"><i class="fa-regular fa-user-check"></i> Entrar</a>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<div class="modal fade" id="doar" tabindex="-1" aria-labelledby="titledoar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-black text-white border-success">
            <div class="modal-body">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="titledoar">Ajudar com doação</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Fechar"></button>
                </div>
                <div class="m-2 text-center">
                    <h3>Quem Sou eu?</h3>
                    <span>
                        Olá, o meu nome è Lucas, tenho 17 anos, e atualmente estou no 3º ano do ensino médio, o meu passatempo é programar, e tenho atualmente focado praticamente todo o tempo que eu tinha neste site.
                        Não recebo nenhuma remuneração do site, nem pretendo colocar propagandas, penso que vou criar sistema chamado membro elite, que terá funções extra, mas nem comecei.
                        Então... se quiser me dar uma força para manter este site online, a melhor forma de fazer isso é-me ajudando com doação.
                    </span>
                </div>
                <span>Não vou pedir nenhum valor, estará livre para doar qualquer quantia.</span>
                <div class="m-2 text-center">
                    <h3>Meu Pix</h3>
                    <p class="text-decoration-underline">d14f80f4-1567-4268-80d6-0abf7e572454</p>
                </div>
                <div class="m-2 text-center">
                    <h3>Bitcoin</h3>
                    <p class="text-decoration-underline">bc1q3yv7v4cemlg9wauxqnxsdc53nje6wyksvq58k5</p>
                    <span>Porque Criptomoedas?<br>A melhor resposta que eu tenho para essa pergunta: é que não é rastreavel, não possuí taxas ou juros do governo, e sem falar que o ‘bitcoin’ anda em ascensão ao longo dos vários anos</span>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require_once RootDir."/conta/login.php";
require_once RootDir."/conta/registrar.php";
?>