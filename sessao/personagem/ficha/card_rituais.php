<div class="col-md pb-2 px-1" id="card_rituais">
    <div class="card h-100 bg-black border-light">
        <div class="card-body p-0 font1">
            <div class="clearfix">
                <?php if ($edit) { ?>
                    <div class="float-end">
                        <button class="btn btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editritual"
                                title="Editar Rituais">
                            <i class="fa-regular fa-pencil"></i>
                        </button>
                        <button class="btn btn-sm text-success" data-bs-toggle="modal" data-bs-target="#addritual"
                                title="Adicionar Ritual">
                            <i class="fa-regular fa-square-plus"></i>
                        </button>
                        <?php if (!isset($_GET["popout"])) { ?>
                            <button class="btn btn-sm text-white popout" title="PopOut">
                                <i class="fa-regular fa-rectangle-vertical-history"></i>
                            </button>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <h1 class="font6 text-center">Rituais</h1>
            <div class="row m-1 font4">
                <?php
                foreach ($s[6] as $r):?>
                    <div class="col text-center col-md-6">
                        <img src="<?php
                        if ($r["foto"] == 1) {
                            echo "https://fichasop.cf/assets/img/desconh.png";
                        } else {
                            echo $r["foto"];
                        }
                        ?>" width="200" height="200" alt="Ritual">
                        <div class="container-fluid ">
                            <div class="clearfix">
                                <button class="float-end btn btn-sm text-danger"
                                        onclick="deleteritual(<?= $r["id"] ?>);">
                                    <i class="fa-regular fa-trash"></i>
                                </button>
                            </div>
                            <span class="form-control form-control-sm bg-black text-white m-1">Ritual: <?= $r["nome"] ?></span>
                            <?= $r["circulo"] ? '<span class="form-control form-control-sm bg-black text-white m-1">Circulo: ' . $r["circulo"] . '</span>' : "" ?>
                            <?= $r["elemento"] ? '<span class="form-control form-control-sm bg-black text-white m-1">Elemento: ' . $r["elemento"] . '</span>' : "" ?>
                            <?= $r["conjuracao"] ? '<span class="form-control form-control-sm bg-black text-white m-1">Conjuração: ' . $r["conjuracao"] . '</span>' : "" ?>
                            <?= $r["alvo"] ? '<span class="form-control form-control-sm bg-black text-white m-1">Alvo: ' . $r["alvo"] . '</span>' : "" ?>
                            <?= $r["duracao"] ? '<span class="form-control form-control-sm bg-black text-white m-1">Duração: ' . $r["duracao"] . '</span>' : "" ?>
                            <?= $r["alcance"] ? '<span class="form-control form-control-sm bg-black text-white m-1">Alcance: ' . $r["alcance"] . '</span>' : "" ?>
                            <?= $r["resistencia"] ? '<span class="form-control form-control-sm bg-black text-white m-1">Resistência: ' . $r["resistencia"] . '</span>' : "" ?>
                            <textarea aria-label="Descrição"
                                      class="form-control form-control-sm bg-black text-white m-1"
                                      disabled>Efeito: <?= $r["efeito"] ?></textarea>
                        </div>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>