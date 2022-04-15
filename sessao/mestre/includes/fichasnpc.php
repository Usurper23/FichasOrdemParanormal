<div class="col-lg-6 my-2">
    <div class="card h-100 w-100 bg-black border-light">
        <div class="card-body p-0">
            <div class="position-absolute end-0">
                <button class="btn text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addnpc">
                    <i class="fa-regular fa-square-plus"></i>
                </button>
            </div>
            <div class="card-header border-0">
                <div class="card-title fs-2 text-center">Fichas NPCs</div>
            </div>
            <div class="container-fluid p-0">
                <div class="row m-2" id="fichasperson">
                    <?php
                    $fichanpcs = $con->query("SELECT * FROM `fichas_npc` WHERE `missao` = '$id';");
                    while ($r = mysqli_fetch_array($fichanpcs)) {
                        ?>
                        <div class="col-xxl-6 card-body border-0 text-center" id="npc<?= $r["id"] ?>">
                            <div class="card bg-black border-light">
                                <div class="clearfix">
                                    <button class="btn btn-sm float-end text-danger"
                                            onclick="deletnpc(<?= $r["id"] ?>);"><i class="fa-regular fa-trash"></i>
                                    </button>
                                </div>
                                <div class="card-header border-0">
                                    <div class="card-title fs-5"><?= $r["nome"] ?></div>
                                </div>
                                <div class="my-2">
                                    <h4>Atributos</h4>
                                    <div class="row m-2 justify-content-center">
                                        <?= $r["forca"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">FOR: ' . ($r["forca"] > 0 ? "+" . $r["forca"] : $r["forca"]) . '</span></div>' : "" ?>
                                        <?= $r["agilidade"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">AGI: ' . ($r["agilidade"] > 0 ? "+" . $r["agilidade"] : $r["agilidade"]) . '</span></div>' : "" ?>
                                        <?= $r["inteligencia"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">INT: ' . ($r["inteligencia"] > 0 ? "+" . $r["inteligencia"] : $r["inteligencia"]) . '</span></div>' : "" ?>
                                        <?= $r["presenca"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">PRE: ' . ($r["presenca"] > 0 ? "+" . $r["presenca"] : $r["presenca"]) . '</span></div>' : "" ?>
                                        <?= $r["vigor"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">VIG: ' . ($r["vigor"] > 0 ? "+" . $r["vigor"] : $r["vigor"]) . '</span></div>' : "" ?>
                                    </div>
                                </div>
                                <div class="card-body border-0">
                                    <div id="saude">
                                        <div class="mt-4">
                                            <h4>Vida</h4>
                                            <div class="clearfix" style="height: 40px;" id="pv">
                                                <div class="fs-4" style="text-align: center; height: 0px;"
                                                     id="pvpva"><?= $r["pva"] ?>/<?= $r["pv"] ?></div>
                                                <div class="float-start" style="height: 0px;">
                                                    <button class="btn btn-sm text-white"
                                                            onclick="updtvida(-5,<?= $r["id"] ?>);"
                                                            style="height: 40px;">
                                                        <i class="fa-solid fa-chevrons-left"></i> -5
                                                    </button>
                                                    <button class="btn btn-sm text-white"
                                                            onclick="updtvida(-1,<?= $r["id"] ?>);"
                                                            style="height: 40px;">
                                                        <i class="fa-solid fa-chevron-left"></i> -1
                                                    </button>
                                                </div>
                                                <div class="float-end" style="height: 0px;">
                                                    <button class="btn btn-sm text-white"
                                                            onclick="updtvida(1,<?= $r["id"] ?>);"
                                                            style="height: 40px;">
                                                        +1 <i class="fa-solid fa-chevron-right"></i>
                                                    </button>
                                                    <button class="btn btn-sm text-white"
                                                            onclick="updtvida(5,<?= $r["id"] ?>);"
                                                            style="height: 40px;">
                                                        +5 <i class="fa-solid fa-chevrons-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                                                     style="width: <?= ($r["pva"] / $r["pv"]) * 100; ?>%;"
                                                     role="progressbar" aria-valuenow="<?= $r["pva"] ?>"
                                                     aria-valuemin="0" aria-valuemax="<?= $r["pva"] ?>"></div>
                                            </div>
                                        </div>
                                        <?php
                                        if ($r["san"] > 0) {
                                            ?>
                                            <div class="mt-4">
                                                <h4>Sanidade</h4>
                                                <div class="clearfix" style="height: 40px;" id="san">
                                                    <div class="fs-4" style="text-align: center; height: 0px;"
                                                         id="sansana"><?= $r["sana"] ?>/<?= $r["san"] ?></div>
                                                    <div class="float-start" style="height: 0px;">
                                                        <button class="btn btn-sm text-white"
                                                                onclick="updtsan(-5,<?= $r["id"] ?>);"
                                                                style="height: 40px;"><i
                                                                    class="fa-solid fa-chevrons-left"></i> -5
                                                        </button>
                                                        <button class="btn btn-sm text-white"
                                                                onclick="updtsan(-1,<?= $r["id"] ?>);"
                                                                style="height: 40px;"><i
                                                                    class="fa-solid fa-chevron-left"></i> -1
                                                        </button>
                                                    </div>
                                                    <div class="float-end" style="height: 0px;">
                                                        <button class="btn btn-sm text-white"
                                                                onclick="updtsan(1,<?= $r["id"] ?>);"
                                                                style="height: 40px;">+1 <i
                                                                    class="fa-solid fa-chevron-right"></i></button>
                                                        <button class="btn btn-sm text-white"
                                                                onclick="updtsan(5,<?= $r["id"] ?>);"
                                                                style="height: 40px;">+5 <i
                                                                    class="fa-solid fa-chevrons-right"></i></button>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                                         style="width: <?= ($r["sana"] / $r["san"]) * 100; ?>%;"
                                                         role="progressbar" aria-valuenow="<?= $r["sana"] ?>"
                                                         aria-valuemin="0" aria-valuemax="<?= $r["san"] ?>"></div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if ($r["pe"] > 0) {
                                        ?>
                                        <div class="mt-4 pontos_esforco">
                                            <h4>Esforço</h4>
                                            <h6><?= $r["pe"] - $r["pea"]; ?>/<?= $r["pe"]; ?> Usados</h6>
                                            <?php
                                            $unchecked = max($r["pe"] - $r["pea"], 0);
                                            $a = 0;
                                            while ($a != $unchecked) {
                                                $a += 1;
                                                echo '<input type="checkbox" class="form-check-input m-1" checked onchange="updtpe(' . $r["id"] . ')" aria-label="" autocomplete="off">';
                                            }
                                            while ($a != $r["pe"]) {
                                                $a += 1;
                                                echo '<input type="checkbox" class="form-check-input m-1" onchange="updtpe(' . $r["id"] . ')" aria-label="" autocomplete="off">';
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (!$r["morte"] == 0 and !$r["sangue"] == 0 and !$r["energia"] == 0 and !$r["conhecimento"] == 0 and !$r["mental"] == 0 and !$r["fisica"] == 0 and !$r["balistica"] == 0) {
                                        ?>
                                        <div class="my-2">
                                            <h4>Resistências</h4>
                                            <div class="row m-2 justify-content-center">
                                                <?= $r["morte"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Morte: ' . $r["morte"] . '</span></div>' : "" ?>
                                                <?= $r["sangue"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Sangue: ' . $r["sangue"] . '</span></div>' : "" ?>
                                                <?= $r["energia"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Energia: ' . $r["energia"] . '</span></div>' : "" ?>
                                                <?= $r["conhecimento"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Conhecimento: ' . $r["conhecimento"] . '</span></div>' : "" ?>
                                                <?= $r["mental"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Mental: ' . $r["mental"] . '</span></div>' : "" ?>
                                                <?= $r["fisica"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Física: ' . $r["fisica"] . '</span></div>' : "" ?>
                                                <?= $r["balistica"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Balística: ' . $r["balistica"] . '</span></div>' : "" ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="mt-4 pericias">
                                        <h4>Perícias</h4>
                                        <div class="row m-2 justify-content-center">
                                            <?= $r["atletismo"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Atletismo: +" . $r["atletismo"] . "</span></div>" : "" ?>
                                            <?= $r["atualidade"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Atualidades: +" . $r["atualidade"] . "</span></div>" : "" ?>
                                            <?= $r["ciencia"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Ciências: +" . $r["ciencia"] . "</span></div>" : "" ?>
                                            <?= $r["diplomacia"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Diplomacia: +" . $r["diplomacia"] . "</span></div>" : "" ?>
                                            <?= $r["enganacao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Enganação: +" . $r["enganacao"] . "</span></div>" : "" ?>
                                            <?= $r["fortitude"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Fortitude: +" . $r["fortitude"] . "</span></div>" : "" ?>
                                            <?= $r["furtividade"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Furtividade: +" . $r["furtividade"] . "</span></div>" : "" ?>
                                            <?= $r["intimidacao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Intimidação: +" . $r["intimidacao"] . "</span></div>" : "" ?>
                                            <?= $r["intuicao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Intuição: +" . $r["intuicao"] . "</span></div>" : "" ?>
                                            <?= $r["investigacao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Investigação: +" . $r["investigacao"] . "</span></div>" : "" ?>
                                            <?= $r["luta"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Luta: +" . $r["luta"] . "</span></div>" : "" ?>
                                            <?= $r["medicina"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Medicina: +" . $r["medicina"] . "</span></div>" : "" ?>
                                            <?= $r["ocultismo"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Ocultismo: +" . $r["ocultismo"] . "</span></div>" : "" ?>
                                            <?= $r["percepcao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Percepção: +" . $r["percepcao"] . "</span></div>" : "" ?>
                                            <?= $r["pilotagem"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Pilotagem: +" . $r["pilotagem"] . "</span></div>" : "" ?>
                                            <?= $r["pontaria"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Pontaria: +" . $r["pontaria"] . "</span></div>" : "" ?>
                                            <?= $r["prestidigitacao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Prestidigitação: +" . $r["prestidigitacao"] . "</span></div>" : "" ?>
                                            <?= $r["profissao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Profissão: +" . $r["profissao"] . "</span></div>" : "" ?>
                                            <?= $r["reflexos"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Reflexos: +" . $r["reflexos"] . "</span></div>" : "" ?>
                                            <?= $r["religiao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Religião: +" . $r["religiao"] . "</span></div>" : "" ?>
                                            <?= $r["tatica"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Tática: +" . $r["tatica"] . "</span></div>" : "" ?>
                                            <?= $r["tecnologia"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Tecnologia: +" . $r["tecnologia"] . "</span></div>" : "" ?>
                                            <?= $r["vontade"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Vontade: +" . $r["vontade"] . "</span></div>" : "" ?>
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


<div class="modal" id="addnpc" tabindex="-1" aria-hidden="true">
    <div class="modal-xl modal-dialog modal-dialog-centered">
        <form class="modal-content bg-black border-light" id="formaddnpc" method="post" autocomplete="off">
            <div class="card-header">
                <ul class="nav nav-pills mb-3 row justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link active" id="pills-dados-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-dados" type="button" role="tab" aria-controls="pills-dados"
                                aria-selected="true">Dados
                        </button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-attr-tab" data-bs-toggle="pill" data-bs-target="#pills-attr"
                                type="button" role="tab" aria-controls="pills-attr" aria-selected="false">Atributos
                        </button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-per-tab" data-bs-toggle="pill" data-bs-target="#pills-per"
                                type="button" role="tab" aria-controls="pills-per" aria-selected="false">Perícias
                        </button>
                    </li>
                    <li class="nav-item col-auto" role="presentation">
                        <button class="nav-link" id="pills-out-tab" data-bs-toggle="pill" data-bs-target="#pills-out"
                                type="button" role="tab" aria-controls="pills-out" aria-selected="false">etc.
                        </button>
                    </li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-dados" role="tabpanel"
                         aria-labelledby="pills-dados-tab">
                        <h2 class="my-2">Principal</h2>
                        <div class="m-2">
                            <label class="fs-4" for="nome">Nome</label>
                            <input id="nome" class="form-control bg-black text-light" name="nome" type="text"
                                   maxlength="30" required/>
                            <div class="invalid-feedback">
                                Precisa pelomenos do nome
                            </div>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="pv">Pontos de Vida</label>
                            <input id="pv" class="form-control bg-black text-light" name="pv" type="number" min="1"
                                   max="999" value="1"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="san">Pontos de Sanidade</label>
                            <input id="san" class="form-control bg-black text-light" name="san" type="number" min="0"
                                   max="999" value="0"/>
                        </div>
                        <div class="m-2">
                            <label class="fs-4" for="pe">Pontos de Esforço</label>
                            <input id="pe" class="form-control bg-black text-light" name="pe" type="number" min="0"
                                   max="50" value="0"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-attr" role="tabpanel" aria-labelledby="pills-attr-tab">
                        <div class="containera text-white" id="atributos" title="Atributos, clique para editar">
                            <input required
                                   class="atributos for form-control rounded-circle bg-transparent text-white font4"
                                   type="number" min="-10" max="10" value='0' name="forca" aria-label="Força"/>
                            <input required
                                   class="atributos agi form-control rounded-circle bg-transparent text-white font4"
                                   type="number" min="-10" max="10" value='0' name="agilidade" aria-label="Agilidade"/>
                            <input required
                                   class="atributos int form-control rounded-circle bg-transparent text-white font4"
                                   type="number" min="-10" max="10" value='0' name="intelecto" aria-label="Intelecto"/>
                            <input required
                                   class="atributos pre form-control rounded-circle bg-transparent text-white font4"
                                   type="number" min="-10" max="10" value='0' name="presenca" aria-label="Presença"/>
                            <input required
                                   class="atributos vig form-control rounded-circle bg-transparent text-white font4"
                                   type="number" min="-10" max="10" value='0' name="vigor" aria-label="Vigor"/>
                            <img src="https://fichasop.cf/assets/img/Atributos.png" alt="Atributos">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-per" role="tabpanel" aria-labelledby="pills-per-tab">
                        <h2 class="my-2">Perícias</h2>
                        <div class="row m-2">
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="atletismo">Atletismo</label>
                                    <input id="atletismo" class="input-group-text bg-black text-light" name="atletismo"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="atualidades">Atualidades</label>
                                    <input id="atualidades" class="input-group-text bg-black text-light"
                                           name="atualidades" type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="ciencia">Ciências</label>
                                    <input id="ciencia" class="input-group-text bg-black text-light" name="ciencia"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="diplomacia">Diplomacia</label>
                                    <input id="diplomacia" class="input-group-text bg-black text-light"
                                           name="diplomacia" type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="enganacao">Enganação</label>
                                    <input id="enganacao" class="input-group-text bg-black text-light" name="enganacao"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="fortitude">Fortitude</label>
                                    <input id="fortitude" class="input-group-text bg-black text-light" name="fortitude"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="furtividade">Furtividade</label>
                                    <input id="furtividade" class="input-group-text bg-black text-light"
                                           name="furtividade" type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="intimidacao">Intimidação</label>
                                    <input id="intimidacao" class="input-group-text bg-black text-light"
                                           name="intimidacao" type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="intuicao">Intuição</label>
                                    <input id="intuicao" class="input-group-text bg-black text-light" name="intuicao"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="investigacao">Investigação</label>
                                    <input id="investigacao" class="input-group-text bg-black text-light"
                                           name="investigacao" type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="luta">Luta</label>
                                    <input id="luta" class="input-group-text bg-black text-light" name="luta"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="medicina">Medicina</label>
                                    <input id="medicina" class="input-group-text bg-black text-light" name="medicina"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="ocultismo">Ocultismo</label>
                                    <input id="ocultismo" class="input-group-text bg-black text-light" name="ocultismo"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="percepcao">Percepção</label>
                                    <input id="percepcao" class="input-group-text bg-black text-light" name="percepcao"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="pilotagem">Pilotagem</label>
                                    <input id="pilotagem" class="input-group-text bg-black text-light" name="pilotagem"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="pontaria">Pontaria</label>
                                    <input id="pontaria" class="input-group-text bg-black text-light" name="pontaria"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="prestidigitacao">Prestidigitação</label>
                                    <input id="prestidigitacao" class="input-group-text bg-black text-light"
                                           name="prestidigitacao" type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="profissao">Profissão</label>
                                    <input id="profissao" class="input-group-text bg-black text-light" name="profissao"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="reflexos">Reflexos</label>
                                    <input id="reflexos" class="input-group-text bg-black text-light" name="reflexos"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="religiao">Religião</label>
                                    <input id="religiao" class="input-group-text bg-black text-light" name="religiao"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="tatica">Tática</label>
                                    <input id="tatica" class="input-group-text bg-black text-light" name="tatica"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light"
                                           for="tecnologia">Tecnologia</label>
                                    <input id="tecnologia" class="input-group-text bg-black text-light"
                                           name="tecnologia" type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <label class="input-group-text bg-black text-light" for="vontade">Vontade</label>
                                    <input id="vontade" class="input-group-text bg-black text-light" name="vontade"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-out" role="tabpanel" aria-labelledby="pills-out-tab">
                        <div>
                            <h2 class="my-2">Defesas</h2>
                            <div class="m-2">
                                <label class="fs-4" for="passiva">Pássiva</label>
                                <input id="passiva" class="form-control bg-black text-light" name="passiva"
                                       type="number" min="0" max="50" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="bloqueio">Bloqueio</label>
                                <input id="bloqueio" class="form-control bg-black text-light" name="bloqueio"
                                       type="number" min="0" max="50" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="esquiva">Esquiva</label>
                                <input id="esquiva" class="form-control bg-black text-light" name="esquiva"
                                       type="number" min="0" max="50" value="0"/>
                            </div>
                            <h2 class="my-2">Resistências</h2>
                            <div class="m-2">
                                <label class="fs-4" for="morte">Morte</label>
                                <input id="morte" class="form-control bg-black text-light" name="morte" type="number"
                                       min="0" max="50" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="sangue">Sangue</label>
                                <input id="sangue" class="form-control bg-black text-light" name="sangue" type="number"
                                       min="0" max="50" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="energia">Energia</label>
                                <input id="energia" class="form-control bg-black text-light" name="energia"
                                       type="number" min="0" max="50" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="conhecimento">Conhecimento</label>
                                <input id="conhecimento" class="form-control bg-black text-light" name="conhecimento"
                                       type="number" min="0" max="50" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="fisica">Fisica</label>
                                <input id="fisica" class="form-control bg-black text-light" name="fisica" type="number"
                                       min="0" max="50" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="balistica">Balistica</label>
                                <input id="balistica" class="form-control bg-black text-light" name="balistica"
                                       type="number" min="0" max="50" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="mental">Mental</label>
                                <input id="mental" class="form-control bg-black text-light" name="mental" type="number"
                                       min="0" max="50" value="0"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <input type="hidden" name="status" value="addnpc"/>
            </div>
        </form>
    </div>
</div>
