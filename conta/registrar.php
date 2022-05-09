<?php if (isset($_SESSION["UserID"])){ ?>
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