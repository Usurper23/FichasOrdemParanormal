
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

<?php if (!isset($_SESSION["UserID"])) {?>
    <div class="modal fade" id="logar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white border-success">
                <form class="modal-body" id="login" method="post">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Fazer Login</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                    </div>
                    <div id="messagelogin"></div>
                    <div class="row">
                        <div class="col-md input-group my-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="llogin">Login:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="llogin"
                                   name="login" type="text"/>
                        </div>
                        <div class="col-md input-group my-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="lsenha">Senha:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="lsenha"
                                   name="senha" type="password"/>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="lembrardemim" name="lembrar">
                        <label class="form-check-label" for="lembrardemim">Lembrar-me</label>
                    </div>
                    <div class="modal-footer border-0" id="footerlogin">
                        <input type="hidden" name="logar" value="1">
                        <button type="submit" class="btn btn-success">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cadastrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-black text-white border-success">
                <form class="modal-body" id="cadastro" method="post">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Criar uma conta</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                    </div>
                    <div id="messagecadastro"></div>
                    <div class="row">
                        <div class="col-md input-group m-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="cnome">Nome:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="cnome"
                                   name="nome" type="text"/>
                        </div>
                        <div class="col-md input-group m-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="clogin">Login:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="clogin"
                                   name="login" type="text"/>
                        </div>
                        <?php if (isset($_GET["email"])) { ?>
                            <div class="col-md input-group m-1">
                                <label class="input-group-text bg-black text-white border-light border-end-0"
                                       for="cemail">Email:</label>
                                <input class="form-control bg-black text-white border-light border-start-0" disabled
                                       id="cemail" type="email" value="<?php echo ($_GET["email"]) ?: ''; ?>"/>
                            </div>

                            <input name="email" type="hidden" value="<?php echo ($_GET["email"]) ?: ''; ?>"/>
                        <?php } else { ?>
                            <div class="col-md input-group m-1">
                                <label class="input-group-text bg-black text-white border-light border-end-0"
                                       for="cemail">Email:</label>
                                <input class="form-control bg-black text-white border-light border-start-0" id="cemail"
                                       name="email" type="email"/>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col-md input-group m-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="csenha">Senha:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="csenha"
                                   name="senha" type="password"/>
                        </div>
                        <div class="col-md input-group m-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="ccsenha">Repetir
                                senha:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="ccsenha"
                                   name="csenha" type="password"/>
                        </div>
                    </div>
                    <div class="modal-footer border-0" id="footercadastro">
                        <input type="hidden" name="cadastrar" value="1">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#cadastro').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            //var url = form.attr('action');
            $.post({
                beforeSend: function () {
                    $("#footercadastro").hide();
                    $("#messagecadastro").html("<div class='alert alert-warning'>Aguarde enquanto criamos sua conta...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType: "JSON",
                error: function () {
                    $("#footercadastro").show();
                    $("#messagecadastro").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                if (data.msg) {
                    if (!data.success) {
                        $("#footercadastro").show();
                        $("#messagecadastro").html('<div class="alert alert-danger">' + data.msg + "</div>");
                    } else {
                        $("#messagecadastro").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                        $("#footercadastro").hide();
                    }
                }

            });
        });
        $('#login').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function () {
                    $("#footerlogin").hide();
                    $("#messagelogin").html("<div class='alert alert-warning'>Aguarde enquanto fazemos um rolamento no login...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType: "JSON",
                error: function () {
                    $("#footerlogin").show();
                    $("#messagelogin").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                if (data.msg) {
                    if (!data.success) {
                        $("#footerlogin").show();
                        $("#messagelogin").html('<div class="alert alert-danger">' + data.msg + "</div>");
                    } else {
                        $("#messagelogin").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                        $("#footercadastro").hide();
                        $("#footerlogin").hide();
                    }
                }

            });
        });

        <?php if (isset($_GET["convite"]) && $_GET["convite"] == 1){ ?>
        var modalperfil = new bootstrap.Modal(document.getElementById('cadastrar'), {
            keyboard: false
        })
        modalperfil.show()
        <?php }?>
    </script>
<?php } else { ?>
    <div class="modal fade" id="perfil" tabindex="-1" aria-label="Perfil Modal" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black text-white border-success">
                <div class="clearfix card-header m-2">
                    <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <h1 class="text-center my-3">Perfil</h1>
                <div class="p-4 text-center" id="alertboxperfil"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card bg-black text-white border-light m-3">
                                <div class="card-header text-center text-warning">
                                    <h3>Editar informações da conta</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid">
                                        <button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal"
                                                data-bs-target="#trocarlogin">Trocar Login
                                        </button>
                                        <button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal"
                                                data-bs-target="#trocaremail">Trocar Email
                                        </button>
                                        <button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal"
                                                data-bs-target="#trocarsenha">Trocar Senha
                                        </button>
                                        <button class="btn btn-sm btn-outline-light my-2 d-grid" data-bs-toggle="modal"
                                                data-bs-target="#trocarnome">Trocar Nome
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($_SESSION["UserAdmin"]) { ?>
                            <div class="col-lg-6">
                                <div class="card bg-black text-white border-light m-3">
                                    <div class="card-header text-center text-success">
                                        <h3>Missões e fichas</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid col-md-10">
                                            <div class="form-check form-switch text-center m-2">
                                                <input class="form-check-input float-end" type="checkbox" role="switch"
                                                       id="">
                                                <label class="form-check-label" for="">Tornar fichas privadas</label>
                                            </div>
                                            <div class="form-check form-switch text-center m-2">
                                                <input class="form-check-input float-end" type="checkbox" role="switch"
                                                       checked disabled id="">
                                                <label class="form-check-label" for="">Tornar missões privadas</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->
    <div class="modal fade" id="configfichas" tabindex="-1" aria-label="Configurações da ficha - Modal">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black text-white border-success">
                <div class="clearfix card-header">
                    <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                            data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                    </button>
                    <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <h1 class="text-center">Configurações de fichas</h1>
                <div class="card-body p-3">
                    <div class="form-check form-switch text-center">
                        <input class="form-check-input float-end" type="checkbox" role="switch" id="">
                        <label class="form-check-label" for=""></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->
    <div id="updateforms">
        <div class="modal fade" id="trocarlogin" tabindex="-1" aria-label="Trocar login - Modal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black text-white border-success">
                    <div class="clearfix card-header">
                        <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                                data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form class="modal-body text-center" novalidate autocomplete="off">
                        <h3 class="text-center">Trocar Login</h3>
                        <div class="input-group p-3">
                            <input class="form-control bg-black text-white" readonly
                                   value='Login Atual: <?= $_SESSION["UserLogin"] ?>' aria-label="Login Antigo."/>
                        </div>
                        <div class="input-group p-3">
                            <label for="newlogin" class="input-group-text bg-black text-white border-end-0">Login
                                novo:</label>
                            <input id="newlogin" name="login" class="form-control bg-black text-white border-start-0"
                                   required/>
                        </div>
                        <ul>
                            <li>Letras maiusculas e minusculas não faram diferença no login.</li>
                            <li>Só pode ter letras, pontos, e numeros no login.</li>
                        </ul>
                        <input type="hidden" name="update" value="login">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success text-center">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="trocaremail" tabindex="-1" aria-label="Trocar Email - Modal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black text-white border-success">
                    <div class="clearfix card-header">
                        <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                                data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form class="modal-body text-center" novalidate>
                        <h3 class="text-center">Trocar Email</h3>
                        <div class="input-group p-3">
                            <input class="form-control bg-black text-white" disabled
                                   value='Email Atual: <?= $_SESSION["UserEmail"] ?>' aria-label="Nome label antiga"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="newemail" class="input-group-text bg-black text-white border-end-0">Email
                                novo:</label>
                            <input id="newemail" name="email" class="form-control bg-black text-white border-start-0"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="connewemail" class="input-group-text bg-black text-white border-end-0">Repetir
                                email:</label>
                            <input id="connewemail" name="conemail"
                                   class="form-control bg-black text-white border-start-0"/>
                        </div>
                        <ul>
                            <!--<li>Como existe a hipótese do novo email já ter sido chamado para uma missão, agora é necessário confirmar email</li>-->
                            <li>Não é possivel, ainda, alterar email para um que foi chamado para a missão, em breve
                                resolveremos isso.
                            </li>
                        </ul>
                        <input type="hidden" name="update" value="email">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success text-center">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="trocarsenha" tabindex="-1" aria-label="Trocar senha Modal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black text-white border-success">
                    <div class="clearfix card-header">
                        <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                                data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form class="modal-body text-center" novalidate>
                        <h3 class="text-center">Trocar Senha</h3>
                        <div class="input-group p-3">
                            <label for="newpass" class="input-group-text bg-black text-white border-end-0">Nova
                                Senha</label>
                            <input id="newpass" name="pass" class="form-control bg-black text-white border-start-0"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="connewpass" class="input-group-text bg-black text-white border-end-0">Repetir
                                Senha</label>
                            <input id="connewpass" name="conpass"
                                   class="form-control bg-black text-white border-start-0"/>
                        </div>
                        <span>Para nova senha é necessário alguns requisitos:</span>
                        <ul>
                            <li>Precisa ter pelomenos 1 letra maiuscula.</li>
                            <li>Precisa ter pelomenos 1 letra minusculas.</li>
                            <li>Precisa ter pelomenos um número na senha.</li>
                            <li>Precisa ter no mínimo de 8 caracteres.</li>
                        </ul>
                        <input type="hidden" name="update" value="senha">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success text-center">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="trocarnome" tabindex="-1" aria-label="Trocar Nome - Modal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black text-white border-success">
                    <div class="clearfix card-header">
                        <button type="button" class="btn float-start text-warning" data-bs-toggle="modal"
                                data-bs-target="#perfil"><i class="fa-solid fa-left"></i> Voltar
                        </button>
                        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <h3 class="text-center">Trocar Nome</h3>
                    <form class="modal-body text-center" novalidate>
                        <h3 class="text-center">Trocar Login</h3>
                        <div class="input-group p-3">
                            <input class="form-control bg-black text-white" disabled
                                   value='Nome da conta Atualmente: <?= $_SESSION["UserName"] ?>'
                                   aria-label="Nome label antiga"/>
                        </div>
                        <div class="input-group p-3">
                            <label for="newname" class="input-group-text bg-black text-white border-end-0">Novo
                                nome:</label>
                            <input id="newname" name="nome" class="form-control bg-black text-white border-start-0"
                                   required/>
                        </div>
                        <ul>
                            <li>Somente letras e espaços</li>
                            <li>Ideal é ter apenas nome e sobrenome</li>
                            <li>Nome sempre começa com letra maiuscula. ;)</li>
                        </ul>
                        <input type="hidden" name="update" value="nome">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success text-center">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->
    <script>
        const modalperfil = new bootstrap.Modal(document.getElementById('perfil'));
        $.fn.isValid = function () {
            return this[0].checkValidity()
        } // Função para checar validade de formularios
        $("#updateforms form").submit(function (event) {
            const ThisForm = $(this);
            const ThisFormInput = ThisForm.children("div");
            if (!ThisForm.isValid()) {
                ThisForm.addClass('was-validated');
                event.preventDefault()
                event.stopPropagation()
            } else {
                ThisForm.addClass('was-validated');
                event.preventDefault();
                ThisFormInput.children("input").attr("readonly", true);
                ThisFormInput.children("button").attr("disabled", true);
                $.post({
                    url: '?id=<?php echo $id;?>',
                    data: ThisForm.serialize(),
                    dataType: "JSON",
                    beforeSend() {
                        modalperfil.toggle();
                    }
                }).done(function (data) {
                    $('.modal').modal('hide');
                    $('#perfil').modal('show');
                    if (data.msg) {
                        if (data.success) {
                            $("#alertboxperfil").html('<div class="alert alert-success">' + data.msg + '</div>');
                        } else {
                            $("#alertboxperfil").html('<div class="alert alert-danger">' + data.msg + "</div>");
                            ThisFormInput.children("input").attr("readonly", false);
                            ThisFormInput.children("button").attr("disabled", false);
                        }
                    } else {
                        $("#alertboxperfil").html('<div class="alert alert-warning">Não houve retorno do servidor, verifique se houve mudanças desejadas, e/ou contate um administrador</div>');
                    }
                });
            }
        })

    </script>
    <?php }?>
