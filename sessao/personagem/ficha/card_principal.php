<div class="col-md pb-2 px-1">
    <div class="card h-100 bg-black border-light" id="card_principal">
        <div class="card-body p-0">
            <?php if ($edit) { ?>
                <div class="clearfix">
                    <div class="float-end">
                        <button class="btn btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editprincipal"
                                title="Editar">
                            <i class="fa-regular fa-pencil"></i>
                        </button>
                        <?php if (!isset($_GET["popout"])) { ?>
                            <button class="btn btn-sm text-white popout" title="PopOut">
                                <i class="fa-regular fa-rectangle-vertical-history"></i>
                            </button>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <div class="row m-0">
                <div class="col text-center">
                    <img data-bs-toggle="modal" data-bs-target="#trocarficha" alt="Foto perfil" src="<?= $urlphoto; ?>"
                         width="150" height="150"
                         class="<?php if (intval($rqs["foto"]) > 0 && intval($rqs["foto"]) < 3) echo "bg-secondary"; ?> rounded-circle mx-3 border border-1 border-white"/>
                </div>
                <div class="col d-flex align-self-center flex-column">
                    <div class="m-2">
                        <input type="checkbox" class="btn-check" id="morrendo" <?php if ($morrendo) echo "checked ";
                        if (!$edit) {
                            echo "disabled";
                        } ?> autocomplete="off">
                        <label class="d-grid btn btn-outline-danger fw-bolder" for="morrendo">Morrendo</label>
                    </div>
                    <div class="m-2">
                        <input type="checkbox" class="btn-check"
                               id="enlouquecendo" <?php if ($enlouquecendo) echo "checked ";
                        if (!$edit) {
                            echo "disabled";
                        } ?> autocomplete="off">
                        <label class="d-grid btn btn-outline-primary fw-bolder"
                               for="enlouquecendo">Enlouquecendo</label>
                    </div>
                </div>
            </div>
            <div class="m-2">
                <div id="saude">
                    <label class="font6 pt-4 fs-4 fw-bold" for="progresspv">Vida</label>
                    <div class="clearfix" style="height: 40px;" id="pv">
                        <div class="fs-4" style="text-align: center; height: 0px;" id="pvpva"><?= $pva; ?>
                            /<?= $pv; ?></div>
                        <?php if ($edit) { ?>
                            <div class="float-start" style="height: 0px;">
                                <button class="btn btn-sm text-white" onclick="updtvida(-5);" style="height: 40px;">
                                    <i class="fa-solid fa-chevrons-left"></i> -5
                                </button>
                                <button class="btn btn-sm text-white" onclick="updtvida(-1);" style="height: 40px;">
                                    <i class="fa-solid fa-chevron-left"></i> -1
                                </button>
                            </div>
                            <div class="float-end" style="height: 0px;">
                                <button class="btn btn-sm text-white" onclick="updtvida(1);" style="height: 40px;">
                                    +1 <i class="fa-solid fa-chevron-right"></i></button>
                                <button class="btn btn-sm text-white" onclick="updtvida(5);" style="height: 40px;">
                                    +5 <i class="fa-solid fa-chevrons-right"></i></button>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="progress h-auto bg-dark fw-bolder" id="barrapv" style="height: 150%;zoom:200%;">
                        <div class="progress-bar bg-danger text-end" id="progresspv" role="progressbar" title="Vida"
                             style="width:<?= $ppv; ?>%;height: 10px" aria-valuenow="<?= $pva ?>" aria-valuemin="0"
                             aria-valuemax="<?= $pv ?>"></div>
                    </div>
                    <label for="progresssan" class="font6 pt-4 fs-4 fw-bold">Sanidade</label>
                    <div class="clearfix" style="height: 40px;" id="san">
                        <div class="fs-4" style="text-align: center; height: 0px;" id="sansana"><?= $sana; ?>
                            /<?= $san; ?></div>
                        <?php if ($edit) { ?>
                            <div class="float-start" style="height: 0px;">
                                <button class="btn btn-sm text-white" onclick="updtsan(-5);" style="height: 40px;">
                                    <i class="fa-solid fa-chevrons-left "></i> -5
                                </button>
                                <button class="btn btn-sm text-white" onclick="updtsan(-1);" style="height: 40px;">
                                    <i class="fa-solid fa-chevron-left"></i> -1
                                </button>
                            </div>
                            <div class="float-end" style="height: 0px;">
                                <button class="btn btn-sm text-white" onclick="updtsan(1);" style="height: 40px;">
                                    +1 <i class="fa-solid fa-chevron-right"></i></button>
                                <button class="btn btn-sm text-white" onclick="updtsan(5);" style="height: 40px;">
                                    +5 <i class="fa-solid fa-chevrons-right"></i></button>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="progress h-auto bg-dark fw-bolder" id="barrasan" style="height: 100%;zoom:200%;">
                        <div class="progress-bar bg-primary text-end" id="progresssan" role="progressbar"
                             title="Sanidade Mental" style="height: 10px;width: <?= $psan ?>%"
                             aria-valuenow="<?= $sana ?>" aria-valuemin="0" aria-valuemax="<?= $san ?>"></div>
                    </div>
                </div>
                <?php
                if ($passiva > 0 or $bloqueio > 0 or $esquiva > 0) {
                    ?>
                    <h4 class="font6 pt-4">Defesas</h4>
                    <div class="row">
                        <?php if ($passiva > 0) { ?>
                            <div class="col input-group">
                                <span class="input-group-text bg-black text-light fw-bolder">Passiva: <?= $passiva; ?></span>
                            </div>
                        <?php }
                        if ($bloqueio > 0) {
                            ?>
                            <div class="col input-group">
                                <span class="input-group-text bg-black text-light fw-bolder">Bloqueio: <?= $bloqueio; ?></span>
                            </div>
                        <?php }
                        if ($esquiva > 0) {
                            ?>
                            <div class="col input-group">
                                <span class="input-group-text bg-black text-light fw-bolder">Esquiva: <?= $esquiva; ?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }

                if ($balistica > 0 or $fisica > 0 or $conhecimento > 0 or $morte > 0 or $sangue > 0 or $energia > 0) {
                    ?>
                    <h4 class="font6 pt-4">Resistencias</h4>
                    <div class="row">
                        <?php
                        if ($balistica > 0) {
                            ?>
                            <div class="col-auto">
                                <span class="input-group-text bg-black text-light fw-bolder">Balistica: <?= $balistica; ?></span>
                            </div>
                            <?php
                        }
                        if ($fisica > 0) {
                            ?>
                            <div class="col-auto">
                                <span class="input-group-text bg-black text-light fw-bolder">Físico: <?= $fisica; ?></span>
                            </div>
                            <?php
                        }
                        if ($conhecimento) {
                            ?>
                            <div class="col-auto">
                                <span class="input-group-text bg-black text-light fw-bolder">Conhecimento: <?= $conhecimento; ?></span>
                            </div>
                            <?php
                        }
                        if ($morte) {
                            ?>
                            <div class="col-auto">
                                <span class="input-group-text bg-black text-light fw-bolder">Morte: <?= $morte; ?></span>
                            </div>
                            <?php
                        }
                        if ($sangue) {
                            ?>
                            <div class="col-auto">
                                <span class="input-group-text bg-black text-light fw-bolder">Sangue: <?= $sangue; ?></span>
                            </div>
                            <?php
                        }
                        if ($energia) {
                            ?>
                            <div class="col-auto">
                                <span class="input-group-text bg-black text-light fw-bolder">Energia: <?= $energia; ?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <h4 class="font6 pt-4">Esforço</h4>
                <span id="peatual" class="fs-4"><?= $pe - ($pe - $pea) ?></span><span>/<?= $pe ?> Livres</span>
                <div id="pe" style="Zoom: 150%;">
                    <?php
                    if ($edit) {
                        $unchecked = max($pe - $pea, 0);
                        $a = 0;
                        while ($a != $unchecked) {
                            $a += 1;
                            echo '<input type="checkbox" class="form-check-input m-1" checked aria-label="" autocomplete="off">';
                        }
                        while ($a != $pe) {
                            $a += 1;
                            echo '<input type="checkbox" class="form-check-input m-1" aria-label="" autocomplete="off">';
                        }
                    } else {
                        $unchecked = max($pe - $pea, 0);
                        $a = 0;
                        while ($a != $unchecked) {
                            $a += 1;
                            echo '<input type="checkbox" class="form-check-input m-1" checked disabled aria-label="" autocomplete="off">';
                        }
                        while ($a != $pe) {
                            $a += 1;
                            echo '<input type="checkbox" class="form-check-input m-1" disabled aria-label="" autocomplete="off">';
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>