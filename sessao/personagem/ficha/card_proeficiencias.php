<div class="col-md pb-2 px-1" id="card_proeficiencias">
    <div class="card h-100 bg-black border-light">
        <div class="card-body p-0 font1">
            <div class="clearfix">
                <?php if ($edit){?>
                    <div class="float-end">
                        <button class="btn btn-sm text-success" data-bs-toggle="modal" data-bs-target="#addpro" title="Adicionar Proeficiência">
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
            <h1 class="font6 text-center clearfix">Proeficiências</h1>
            <?php foreach ($s[3] as $r):?>
                <div class="mx-4 my-3">
                    <div class="input-group">
                        <input id="<?=$r["nome"];?>" aria-label="<?=$r["nome"];?>" class="form-control bg-black text-decoration-underline text-light" disabled value="<?=$r["nome"];?>"/>
                        <?php
                        if($edit){
                        ?>
                        <button class="btn btn-sm text-danger btn-outline-light" title="Apagar Proeficiencia: '<?=$r["nome"];?>'" onclick="deletepro(<?=$r["id"];?>)">
                            <i class="fa-regular fa-trash"></i>
                        </button>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
</div>