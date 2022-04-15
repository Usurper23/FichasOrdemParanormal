<div class="col-lg-6 my-2">
    <div class="card bg-black border-light h-100">
        <div class="card-body p-0">
            <div class="position-absolute end-0">
                <button class="btn btn-sm text-success fa-lg" data-bs-toggle="modal" data-bs-target="#adicionar">
                    <i class="fa-regular fa-square-plus"></i>
                </button>
                <button class="btn btn-sm text-primary fa-lg" id="refreshficha">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </button>
            </div>
            <div class="card-header border-0">
                <div class="card-title fs-2 text-center">Fichas Personagens</div>
            </div>
            <div class="row m-2" id="fichasperson">
                <?php
                while ($ra = mysqli_fetch_assoc($q)){
                    if($ra["id_ficha"]>0){
                        $qf = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '".$ra["id_ficha"]."'");
                        $ficha = mysqli_fetch_assoc($qf);
                        ?>
                        <div class="col-md-6 card-body border-0" id="player<?=$ficha["id"]?>">
                            <div class="card bg-black border-light">
                                <div class="card-header border-0">
                                    <a class="card-title fs-5" href="./../personagem/?id=<?=$ficha["id"]?>"><?=$ficha["nome"]?></a>
                                </div>
                                <div class="card-body border-0">
                                    <div class="my-2">
                                        <h5>Vida: <?=$ficha["pva"]?>/<?=$ficha["pv"]?></h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width: <?=($ficha["pva"]/$ficha["pv"])*100;?>%;" role="progressbar" aria-valuenow="<?=$ficha["pva"]?>" aria-valuemin="0" aria-valuemax="<?=$ficha["pva"]?>"></div>
                                        </div>
                                    </div>
                                    <div class="my-2">
                                        <h5>Sanidade: <?=$ficha["sana"]?>/<?=$ficha["san"]?></h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width: <?=($ficha["sana"]/$ficha["san"])*100;?>%;" role="progressbar" aria-valuenow="<?=$ficha["sana"]?>" aria-valuemin="0" aria-valuemax="<?=$ficha["san"]?>"></div>
                                        </div>
                                    </div>
                                    <div class="my-2">
                                        <h5>Esforço: <?=$ficha["pe"]-$ficha["pea"];?>/<?=$ficha["pe"];?> Usados</h5>
                                    </div>
                                    <div class="my-2">
                                        <?php
                                        $s = $con->query("Select SUM(espaco) AS pesototal From `inventario` where `id_ficha` = '$id';");
                                        $ddinv = mysqli_fetch_array($s);
                                        $espacosusados = $ddinv["pesototal"];
                                        ?>
                                        <span>Peso: <?=$espacosusados?:"0"?>/<?=5+(5*$ficha["forca"]);?></span> - <span>Movimento: 9</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }}?>
            </div>
        </div>
    </div>
</div>