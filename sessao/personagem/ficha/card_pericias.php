<div class="col-md pb-2 px-1" id="card_pericias">
    <div class="card h-100 bg-black border-light">
        <div class="card-body p-0 font1">
            <?php if ($edit){?>
            <div class="clearfix">
                <div class="float-start text-center p-1">
                    <span class="text-success">Treinadas</span><br>
                    <span class="text-danger">Não treinadas</span>
                </div>
                    <div class="float-end">
                        <button class="btn btn-sm text-info fa-regular fa-eye" title="Visualisar todos" id="verp"></button>
                        <button class="btn btn-sm text-warning fa-regular fa-pencil" data-bs-toggle="modal" data-bs-target="#editper" title="Editar Pericias"></button>
                        <?php if (!isset($_GET["popout"])){?>
                            <button class="btn btn-sm text-white popout" title="PopOut">
                                <i class="fa-regular fa-rectangle-vertical-history"></i>
                            </button>
                        <?php }?>
                    </div>
            </div>
            <?php }?>
            <h1  class="font6 text-center">Pericias</h1>
            <div class="mt-2 container-fluid" id="pericias" disabled>
                <div class="row">
                    <div class="<?php if ($atletismo > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center " style="display: <?php if ($atletismo > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["for"];?>d20+<?=$atletismo;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$atletismo;?></span></button>
                        <h3 class="text-<?php if ($atletismo>0){echo"success";}else{echo"danger";}?>">Atletismo</h3>
                    </div>
                    <div class="<?php if ($atualidades > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($atualidades > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$atualidades;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$atualidades;?></span></button>
                        <h3 class="text-<?php if ($atualidades>0){echo"success";}else{echo"danger";}?>">Atualidades</h3>
                    </div>
                    <div class="<?php if ($ciencia > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($ciencia > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$ciencia;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$ciencia;?></span></button>
                        <h3 class="text-<?php if ($ciencia>0){echo"success";}else{echo"danger";}?>">Ciência</h3>
                    </div>
                    <div class="<?php if ($diplomacia > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($diplomacia > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["pre"];?>d20+<?=$diplomacia;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$diplomacia;?></span></button>
                        <h3 class="text-<?php if ($diplomacia>0){echo"success";}else{echo"danger";}?>">Diplomacia</h3>
                    </div>
                    <div class="<?php if ($enganacao > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($enganacao > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["pre"];?>d20+<?=$enganacao;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$enganacao;?></span></button>
                        <h3 class="text-<?php if ($enganacao>0){echo"success";}else{echo"danger";}?>">Enganação</h3>
                    </div>
                    <div class="<?php if ($fortitude > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($fortitude > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["for"];?>d20+<?=$fortitude;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$fortitude;?></span></button>
                        <h3 class="text-<?php if ($fortitude>0){echo"success";}else{echo"danger";}?>">Fortitude</h3>
                    </div>
                    <div class="<?php if ($furtividade > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($furtividade > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["agi"];?>d20+<?=$furtividade;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$furtividade;?></span></button>
                        <h3 class="text-<?php if ($furtividade>0){echo"success";}else{echo"danger";}?>">Furtividade</h3>
                    </div>
                    <div class="<?php if ($intimidacao > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($intimidacao > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["pre"];?>d20+<?=$intimidacao;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$intimidacao;?></span></button>
                        <h3 class="text-<?php if ($intimidacao>0){echo"success";}else{echo"danger";}?>">Intimidação</h3>
                    </div>
                    <div class="<?php if ($intuicao > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($intuicao > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["pre"];?>d20+<?=$intuicao;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$intuicao;?></span></button>
                        <h3 class="text-<?php if ($intuicao>0){echo"success";}else{echo"danger";}?>">Intuição</h3>
                    </div>
                    <div class="<?php if ($investigacao > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($investigacao > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$investigacao;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$investigacao;?></span></button>
                        <h3 class="text-<?php if ($investigacao>0){echo"success";}else{echo"danger";}?>">Investigação</h3>
                    </div>
                    <div class="<?php if ($luta > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($luta > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["vig"];?>d20+<?=$luta;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$luta;?></span></button>
                        <h3 class="text-<?php if ($luta>0){echo"success";}else{echo"danger";}?>">Luta</h3>
                    </div>
                    <div class="<?php if ($medicina > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($medicina > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$medicina;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$medicina;?></span></button>
                        <h3 class="text-<?php if ($medicina>0){echo"success";}else{echo"danger";}?>">Medicina</h3>
                    </div>
                    <div class="<?php if ($ocultismo > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($ocultismo > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["pre"];?>d20+<?=$ocultismo;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$ocultismo;?></span></button>
                        <h3 class="text-<?php if ($ocultismo>0){echo"success";}else{echo"danger";}?>">Ocultismo</h3>
                    </div>
                    <div class="<?php if ($percepcao > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($percepcao > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$percepcao;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$percepcao;?></span></button>
                        <h3 class="text-<?php if ($percepcao>0){echo"success";}else{echo"danger";}?>">Percepção</h3>
                    </div>
                    <div class="<?php if ($pilotagem > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($pilotagem > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["agi"];?>d20+<?=$pilotagem;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$pilotagem;?></span></button>
                        <h3 class="text-<?php if ($pilotagem>0){echo"success";}else{echo"danger";}?>">Pilotagem</h3>
                    </div>
                    <div class="<?php if ($pontaria > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($pontaria > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["agi"];?>d20+<?=$pontaria;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$pontaria;?></span></button>
                        <h3 class="text-<?php if ($pontaria>0){echo"success";}else{echo"danger";}?>">Pontaria</h3>
                    </div>
                    <div class="<?php if ($prestidigitacao > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($prestidigitacao > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["agi"];?>d20+<?=$prestidigitacao;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$prestidigitacao;?></span></button>
                        <h3 class="text-<?php if ($prestidigitacao>0){echo"success";}else{echo"danger";}?>">Prestidigitação</h3>
                    </div>
                    <div class="<?php if ($profissao > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($profissao > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$profissao;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$profissao;?></span></button>
                        <h3 class="text-<?php if ($profissao>0){echo"success";}else{echo"danger";}?>">Profissão</h3>
                    </div>
                    <div class="<?php if ($reflexos > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($reflexos > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["agi"];?>d20+<?=$reflexos;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$reflexos;?></span></button>
                        <h3 class="text-<?php if ($reflexos>0){echo"success";}else{echo"danger";}?>">Reflexo</h3>
                    </div>
                    <div class="<?php if ($religiao > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($religiao > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$religiao;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$religiao;?></span></button>
                        <h3 class="text-<?php if ($religiao>0){echo"success";}else{echo"danger";}?>">Religião</h3>
                    </div>
                    <div class="<?php if ($tatica > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($tatica > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$tatica;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$tatica;?></span></button>
                        <h3 class="text-<?php if ($tatica>0){echo"success";}else{echo"danger";}?>">Tática</h3>
                    </div>
                    <div class="<?php if ($tecnologia > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($tecnologia > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["int"];?>d20+<?=$tecnologia;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$tecnologia;?></span></button>
                        <h3 class="text-<?php if ($tecnologia>0){echo"success";}else{echo"danger";}?>">Tecnologia</h3>
                    </div>
                    <div class="<?php if ($vontade > 0){echo "treinado";}else{echo"destreinado";}?> col-auto text-center" style="display: <?php if ($vontade > 0){echo "unset";}else{echo"none";}?>;">
                        <button <?php if (!$edit){echo"disabled";}?> onclick="rolar('<?=$dado["pre"];?>d20+<?=$vontade;?>');" class="btn btn-lg text-info"><i class=" fa-thin fa-dice-d20 fa-2x"></i><span> +<?=$vontade;?></span></button>
                        <h3 class="text-<?php if ($vontade>0){echo"success";}else{echo"danger";}?>">Vontade</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>