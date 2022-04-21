<div class="col-md pb-2 px-1" id="card_atributos">
    <div class="card h-100 bg-black border-light">
        <div class="card-body p-0 font1">
            <?php if ($edit) { ?>
                <div class="clearfix">
                    <div class="p-1 float-start text-info">
                        <i class="fa-regular fa-circle-info"></i>
                        <span> clique para rolar dados</span>
                    </div>
                    <div class="float-end">
                        <button class="btn btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editatrr"
                                title="Editar Atributos">
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
            <h1 class="font6 text-center">Atributos</h1>
            <div class="container-fluid p-0 mb-2">
                <div class="containera mx-auto text-white">
                    <button class="atributos p-0 for btn rounded-circle text-white font4" <?=$edit?"onclick='rolar(".'"'.$dado["for"].'d20");'."'":'disabled'?>><?=$for?></button>
                    <button class="atributos p-0 agi btn rounded-circle text-white font4" <?=$edit?"onclick='rolar(".'"'.$dado["agi"].'d20");'."'":'disabled'?>><?=$agi?></button>
                    <button class="atributos p-0 int btn rounded-circle text-white font4" <?=$edit?"onclick='rolar(".'"'.$dado["int"].'d20");'."'":'disabled'?>><?=$int?></button>
                    <button class="atributos p-0 pre btn rounded-circle text-white font4" <?=$edit?"onclick='rolar(".'"'.$dado["pre"].'d20");'."'":'disabled'?>><?=$pre?></button>
                    <button class="atributos p-0 vig btn rounded-circle text-white font4" <?=$edit?"onclick='rolar(".'"'.$dado["vig"].'d20");'."'":'disabled'?>><?=$vig?></button>
                    <img src="https://fichasop.cf/assets/img/Atributos.png" alt="Atributos">
                </div>
            </div>
        </div>
    </div>
</div>