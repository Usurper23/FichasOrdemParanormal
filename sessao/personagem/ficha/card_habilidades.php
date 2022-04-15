<div class="col-md pb-2 px-1" id="card_habilidades">
    <div class="card h-100 bg-black border-light">
        <div class="card-body p-0 font1">
            <div class="clearfix">
                <?php if ($edit){?>
                    <div class="float-end">
                        <button class="btn btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#edithab" title="Editar Habilidades">
                            <i class="fa-regular fa-pencil"></i>
                        </button>
                        <button class="btn btn-sm text-success" data-bs-toggle="modal" data-bs-target="#addhab" title="Adicionar Habilidade">
                            <i class="fa-regular fa-square-plus"></i>
                        </button>
                        <?php if (!isset($_GET["popout"])){?>
                            <button class="btn btn-sm text-white popout" title="PopOut">
                                <i class="fa-regular fa-rectangle-vertical-history"></i>
                            </button>
                        <?php }?>
                    </div>
                <?php }?>
            </div>
            <h1  class="font6 text-center">Habilidades</h1>
            <?php
                foreach ($s[2] as $r):
            ?>
                <div class="m-3 clearfix">
                    <label for="<?=$r["nome"];?>" class="fs-4"><?=$r["nome"];?></label>
                    <?php
                    if ($edit){?>
                    <button class="btn btn-sm fa fa-trash text-danger float-end" title="Apagar Habilidade '<?=$r["nome"];?>'" onclick="deletehab(<?=$r["id"];?>)"></button>
                    <?php }
                    ?>
                    <textarea id="<?=$r["nome"];?>" class="form-control bg-black text-light border-0 font7" disabled><?=$r["descricao"];?></textarea>
                </div>
            <?php
                endforeach;

            ?>
        </div>
    </div>
</div>