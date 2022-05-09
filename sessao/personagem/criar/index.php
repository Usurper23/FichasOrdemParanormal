<?php
header("X-Robots-Tag: none");
require_once "./../../../config/mysql.php";
$con = con();
if (!isset($_SESSION['UserID'])) {
    echo "<script>window.location.href='/'</script>";
}
$id = intval($_GET["missao"]);
?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <?php require_once "./../../../includes/head.html";?>
        <title>Criar Personagem - Fichas OP</title>
    </head>
    <body class="bg-black text-white">
        <main class="container-fluid my-5" id="tudo">
            <div class="card bg-black border-light">
                <div class="card-body">
                    <form class="needs-validation" method="post" novalidate autocomplete="off" id="criar">
                        <div class="card-title text-center font6"><h1>Criar um Novo Personagem</h1></div>
                        <div class="row">
                            <div class="col-lg p-1 mx-lg-1 my-1 card bg-black border-light">
                                <div class="card-body">
                                    <div class="card-title text-center font6"><h2>Detalhes e Historia</h2></div>
                                    <div class="pt-3">
                                        <label for="foto" class="fs-4 fw-bold">Estilo de foto.</label>
                                        <select class="form-select bg-black text-light border-light" id="foto" name="foto">
                                            <option value="1">Desconhecido - Masculino</option>
                                            <option value="2">Desconhecido - Feminino</option>
                                            <option value="3">Mauro Nunes</option>
                                            <option value="4">Maya Shiruze</option>
                                            <option value="5">Bruna Sampaio</option>
                                            <option value="6">Leandro Weiss</option>
                                            <option value="7">Jaime Orthuga</option>
                                            <option value="8">Aniela Ukryty</option>
                                            <option value="9">Customizada</option>
                                        </select>
                                    </div>
                                    <div class="pt-3" id="divfotourl" style="display: none;">
                                        <label for="fotourl" class="fs-4 fw-bold">Link da imagem</label>
                                        <div class="row">
                                            <div class="col-8">
                                                <input id="fotourl" class="form-control bg-black text-light border-light"
                                                       name="fotourl" type="url" required disabled/>
                                                <div class="invalid-feedback">A Imagem precisa ser valida</div>
                                            </div>
                                            <div id="prev" class="col-4 d-flex align-items-center"></div>
                                        </div>
                                        <div id="warning"></div>
                                    </div>
                                    <div class="pt-3">
                                        <label class="fs-4 fw-bold" for="nome">Nome do Personagem</label>
                                        <input class="form-control bg-black text-light border-light" id="nome" name="nome"
                                               required="required"/>
                                        <div class="invalid-feedback">
                                            Coloque o Nome do seu personagem.(Apenas letras e espaços)
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label class="fs-4 fw-bold" for="idade">Idade</label>
                                        <input class="form-control bg-black text-light border-light" type="number" min="0"
                                               max="65" id="idade" name="idade" required="required"/>
                                        <div class="invalid-feedback">
                                            Coloque a idade do seu personagem.
                                            Coloque 0 Para Desconhecido.
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label for="localnascimento" class="fs-4 fw-bold">Local de Nascimento(Opcional)</label>
                                        <input id="localnascimento" class="form-control bg-black text-light border-light"
                                               name="local"/>
                                        <div class="invalid-feedback">
                                            Coloque o Local de nascimento.
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label class="fs-4 fw-bold" for="origem">Origem</label><span>(Depedendo da escolha, irá gerar uma classe padrão.)</span>
                                        <select class="form-select bg-black text-light border-light" id="origem" name="origem"
                                                required="required">
                                            <option value="0" selected>Desconhecido</option>
                                            <option value="1">Acadêmica</option>
                                            <option value="7">Artista</option>
                                            <option value="2">Atleta</option>
                                            <option value="3">Exorcista</option>
                                            <option value="4">Mercenária</option>
                                            <option value="5">Profissional da Saúde</option>
                                            <option value="6">T.I.</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Selecione a Origem do seu Personagem.
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <div class="row">
                                            <div class="col">
                                                <label class="fs-4 fw-bold" for="classe">Classe</label>
                                                <select class="form-select bg-black text-light border-light" id="classe"
                                                        name="classe" required>
                                                    <option value="0" selected>Desconhecido</option>
                                                    <option value="1">Combatente</option>
                                                    <option value="2">Especialista</option>
                                                    <option value="3">Ocultista</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Selecione a Classe do seu Personagem.
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label class="fs-4 fw-bold" for="trilha">Trilha</label>
                                                <select class="form-select bg-black text-light border-light" id="trilha"
                                                        name="classe" disabled required>
                                                    <option value="0" selected>Em breve</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Selecione a Trilha do seu Personagem.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label for="nex" class="fs-4 fw-bold">Nivel de Exposição Paranormal (NEX)</label>
                                        <input class="form-control bg-black text-light border-light" id="nex" type="number"
                                               min="0" max="99" name="nex" required/>
                                        <div class="invalid-feedback">
                                            Providencie um nivel de exposição paranormal.
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label for="patente" class="fs-4 fw-bold">Patente</label>
                                        <select class="form-select bg-black text-light border-light" id="patente" name="patente"
                                                required>
                                            <option value="0">Desconhecido</option>
                                            <option value="1">Recruta</option>
                                            <option value="2">Agente</option>
                                            <option value="3">Operador</option>
                                            <option value="4">Veterano</option>
                                            <option value="5">Elite</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Selecione a Patente do seu personagem
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label class="fs-4 fw-bold" for="historia">Resumo da História de como entrou para ordem
                                            (Opcional)</label>
                                        <textarea class="form-control bg-black text-light border-light" id="historia"
                                                  name="historia"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg p-1 mx-lg-1 my-1 card bg-black border-light">
                                <div class="card-body p-0">
                                    <div class="card-title text-center font6"><h2>Atributos e Saúde</h2></div>
                                    <div class="container p-0">
                                        <i class="text-info"><i class="fa-regular fa-circle-info"></i> Clique nos circulos</i>
                                        <div class="containera text-white" id="atributos" title="Atributos, clique para editar">
                                            <input required
                                                   class="atributos for form-control rounded-circle bg-transparent text-white font4"
                                                   type="number" min="-5" max="5" value=0 name="forca" aria-label="Força"/>
                                            <input required
                                                   class="atributos agi form-control rounded-circle bg-transparent text-white font4"
                                                   type="number" min="-5" max="5" value=0 name="agilidade"
                                                   aria-label="Agilidade"/>
                                            <input required
                                                   class="atributos int form-control rounded-circle bg-transparent text-white font4"
                                                   type="number" min="-5" max="5" value=0 name="intelecto"
                                                   aria-label="Intelecto"/>
                                            <input required
                                                   class="atributos pre form-control rounded-circle bg-transparent text-white font4"
                                                   type="number" min="-5" max="5" value=0 name="presenca"
                                                   aria-label="Presença"/>
                                            <input required
                                                   class="atributos vig form-control rounded-circle bg-transparent text-white font4"
                                                   type="number" min="-5" max="5" value=0 name="vigor" aria-label="Vigor"/>
                                            <img src="../../../assets/img/Atributos.png" alt="Atributos">
                                        </div>
                                        <div class="p-2 m-1">
                                            <label for="pv" class="fs-4 fw-bold">Vida Maxima (PV)</label><span
                                                    title="Depende do Arquétipo, olhe a wiki oficial">(Deixe 1 para calcular automaticamente)</span>
                                            <input class="form-control bg-black text-light border-light" id="pv" type="number"
                                                   min="1" max="999" value="0" name="pv" required/>
                                            <div class="invalid-feedback">Preencha sua vida.</div>
                                            <label class="fs-4 fw-bold" for="san">Sanidade Maxima (SAN)</label>
                                            <input class="form-control bg-black text-light border-light" id="san" type="number"
                                                   min="1" max="999" value="0" name="san" required/>
                                            <div class="invalid-feedback">
                                                Coloque sua sanidade maxima.
                                            </div>
                                            <label for="pe" class="fs-4 fw-bold">Pontos de Esforço (PE)</label><span
                                                    title="Depende do Arquétipo, olhe a wiki oficial">(Deixe 1 para calcular automaticamente)</span>
                                            <input id="pe" class="form-control bg-black text-light border-light" type="number"
                                                   min="1" max="999" value="0" name="pe" required/>
                                            <div class="invalid-feedback">
                                                Adiciona um total de Pontos de Esforço.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success d-grid" id="submit">Enviar e Criar Personagem</button>
                        </div>
                        <input type="hidden" value="<?php echo $id; ?>" name="missao">
                    </form>
                </div>
            </div>
        </main>
        <div class="modal fade" id="modal" aria-hidden="true" aria-labelledby="titulomodal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-black border-light text-white">
                    <div class="modal-body">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="titulomodal">Criar Personagem</h5>
                        </div>
                        <div id="msg"></div>
                        <div id="status"></div>
                        <div class="modal-footer border-0" id="modalfooter">
                            <button class="btn btn-success">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once "./../../../includes/scripts.html";?>
        <?php require_once "./../../../includes/top.php";?>
        <script>
            $('#fotourl').on('input', function () {
                var src = jQuery(this).val();

                if (!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") && src != "") {
                    $("#warning").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(.jpg, .png ...)!");
                    $('#prev').html('');
                    return false;
                } else {
                    $("#warning").html("");
                    $('#prev').html('<img class="position-absolute rounded-circle border border-light" style="max-width:100px;" src="' + src + '">');
                }

            })
            $('#foto').change(function () {
                let fotovalor = $('#foto').val()
                console.log(fotovalor);
                if (fotovalor == '9') {
                    $('#divfotourl').show();
                    $("#fotourl").attr("disabled", false)
                    console.log("show");
                } else {
                    $('#divfotourl').hide();
                    $("#fotourl").attr("disabled", true)
                    console.log("hide");
                }
            })
            var formu = document.getElementById('criar');
            var myModal = new bootstrap.Modal(document.getElementById('modal'), {
                keyboard: false
            })
            $('#modalfooter').html('');
            $('#criar').submit(function (event) {
                formu.classList.add('was-validated');
                if (!formu.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                } else {
                    $("#tudo").hide()
                    event.preventDefault();
                    $.post({
                        url: "salvar.php",
                        data: $(this).serialize(),
                        dataType: "JSON",
                    }).done(function (data) {
                        console.log(data);
                        if (data.msg) {
                            if (data.success) {
                                $('#msg').html('<div class="alert alert-success">' + data.msg + '</div>');
                                $('#status').html('<div class="alert alert-warning">' + data.status + '</div>');
                                $('#modalfooter').html('<a class="btn btn-success" href="./../?id=' + data.id + '" >Abrir Ficha</a><a class="btn btn-success">Fechar</a>');
                                $("#submit input").attr('disabled', true);
                                myModal.show();
                            } else {
                                $("#tudo").show();
                                $('#msg').html('<div class="alert alert-danger">' + data.msg + '</div>');
                                $("#submit input").attr('disabled', false);
                                myModal.show();
                            }
                        }
                    }).fail(function (data) {
                        console.log(data);
                        myModal.show();
                        $("#tudo").show();
                        $('#msg').html('<div class="alert alert-danger">Falha ao criar personagem, contate um administrador!</div>');
                    })
                }
            })

        </script>
    </body>
</html>