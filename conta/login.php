<?php if (!isset($_SESSION["UserID"])) {?>
    <div class="modal fade" id="logar" tabindex="-1">
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
                    <div class="row mx-2">
                        <div class="form-check form-switch col-6">
                            <input class="form-check-input" type="checkbox" role="switch" id="lembrardemim" name="lembrar">
                            <label class="form-check-label" for="lembrardemim">Lembrar-me</label>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-sm btn-outline-info float-end" type="button" data-bs-toggle="modal" data-bs-target="#passr">Recuperar senha</button>
                        </div>
                    </div>
                    <div class="modal-footer border-0" id="footerlogin">
                        <input type="hidden" name="logar" value="1">
                        <button type="submit" class="btn btn-success">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="passr" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white border-success">
                <form class="modal-body" id="passr" method="post">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Recuperar senha(Não Funcional)</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-toggle="modal" data-bs-target="#login"></button>
                    </div>
                    <div id="passrmsg"></div>
                    <div class="row">
                        <div class="col-md input-group my-1">
                            <label class="input-group-text bg-black text-white border-light border-end-0" for="remail">Email:</label>
                            <input class="form-control bg-black text-white border-light border-start-0" id="remail" name="email" type="text"/>
                        </div>
                    </div>
                    <div class="modal-footer border-0" id="footerpassr">
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
        $('#passr').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            //var url = form.attr('action');
            $.post({
                beforeSend: function () {
                    $("#footerpassr").hide();
                    $("#passrmsg").html("<div class='alert alert-warning'>Aguarde...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType: "JSON",
                error: function () {
                    $("#footerpassr").show();
                    $("#passrmsg").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                if (data.msg) {
                    if (!data.success) {
                        $("#footerpassr").show();
                        $("#passrmsg").html('<div class="alert alert-danger">' + data.msg + "</div>");
                    } else {
                        $("#passrmsg").html('<div class="alert alert-success">' + data.msg + '</div>');
                        window.location.href = "./";
                        $("#footerpassr").hide();
                    }
                }

            });
        });
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
<?php }