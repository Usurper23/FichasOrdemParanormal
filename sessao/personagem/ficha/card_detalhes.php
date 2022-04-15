<div class="col-md pb-2 px-1" id="card_dados">
    <div class="card h-100 bg-black border-light">
        <div class="card-body p-0">
            <?php if ($edit){?>
                <div class="clearfix">
                    <div class="float-end">
                        <button class="btn btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editdetalhes" title="Editar">
                            <i class="fa-regular fa-pencil"></i>
                        </button>
                        <?php if (!isset($_GET["popout"])){?>
                        <button class="btn btn-sm text-white popout" title="PopOut">
                            <i class="fa-regular fa-rectangle-vertical-history"></i>
                        </button>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
            <div class="card-title">
                <h1 class="font6 text-center">Detalhes Pessoais</h1>
            </div>
            <div class="m-2">
                <label class="fs-4" for="nome">Nome</label>
                <input id="nome" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$nome?>"/>
                <label class="fs-4" for="jogador">Jogador</label>
                <input id="jogador" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$usuario?>"/>
                <label class="fs-4" for="nex">Nivel de Exposição Paranormal.</label>
                <input id="nex" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$nex?>%"/>
                <label class="fs-4" for="classe">Classe</label>
                <input id="classe" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$classe?>"/>
                <label class="fs-4" for="trilha">Trilha</label>
                <input id="trilha" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$trilha?>"/>
                <label class="fs-4" for="origem">Origem</label>
                <input id="origem" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$origem?>"/>
                <label class="fs-4" for="patente">Patente</label>
                <input id="patente" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$patente?>"/>
                <label class="fs-4" for="idade">Idade</label>
                <input id="idade" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$idade?>"/>
                <label class="fs-4" for="local">Local de nascimento</label>
                <input id="local" class="form-control bg-black text-decoration-underline text-light border-0" disabled value="<?=$local?>"/>
                <?php
                if(!empty($historia)){?>
                    <label class="fs-4" for="historia">História</label>
                    <textarea id="historia" class="form-control bg-black text-light border-0" disabled><?=$historia;?></textarea>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>