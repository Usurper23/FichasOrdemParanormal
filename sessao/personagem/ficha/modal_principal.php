<!-- Modal proeficiencias-->
<div class="modal fade" id="editprincipal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <form class="modal-body" id="formeditpri">
                <div class="clearfix">
                    <button type="button" class="btn-close btn-close-white me-2 m-auto float-end" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    <div class="float-start m-2">
                        <span class="text-info fa-solid fa-circle-info"> Os campos em azuis pode ser calculados automaticamente colocando 1.</span>
                    </div>
                </div>
                <h1 class="text-center">Editar Principal</h1>
                <div class="m-2">
                    <h4 class="text-center">Saúde</h4>
                    <div class="input-group input-group-sm m-1">
                        <label for="epvtotal" class="border-info input-group-text bg-black text-white border-end-0 ">Vida total</label>
                        <input id="epvtotal" class="border-info form-control bg-black text-white border-start-0" type="number" name="pv" value="<?php echo $pv;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="esantotal" class="input-group-text bg-black text-white border-end-0">Sanidade total</label>
                        <input id="esantotal" class="form-control bg-black text-white border-start-0" type="number" name="san" value="<?php echo $san;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="epetotal" class="border-info input-group-text bg-black text-white border-end-0">Esforço total</label>
                        <input id="epetotal" class="border-info form-control bg-black text-white border-start-0" type="number" name="pe" value="<?php echo $pe;?>"/>
                    </div>
                </div>
                <div class="m-2">
                    <h4 class="text-center">Defesas</h4>
                    <div class="input-group input-group-sm m-1">
                        <label for="epass" class="input-group-text bg-black text-white border-end-0">Passiva</label>
                        <input id="epass" class="form-control bg-black text-white border-start-0" type="number" name="passiva" value="<?php echo $passiva;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="ebloq" class="border-info input-group-text bg-black text-white border-end-0">Bloqueio</label>
                        <input id="ebloq" class="border-info form-control bg-black text-white border-start-0" type="number" name="bloqueio" value="<?php echo $bloqueio;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="eesqui" class="border-info input-group-text bg-black text-white border-end-0">Esquiva</label>
                        <input id="eesqui" class="border-info form-control bg-black text-white border-start-0" type="number" name="esquiva" value="<?php echo $esquiva;?>"/>
                    </div>
                </div>
                <div class="m-2">
                    <h4 class="text-center">Resistencias</h4>
                    <div class="input-group input-group-sm m-1">
                        <label for="ebal" class="input-group-text bg-black text-white border-end-0">Balística</label>
                        <input id="ebal" class="form-control bg-black text-white border-start-0" type="number" name="balistica" value="<?php echo $balistica;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="efis" class="input-group-text bg-black text-white border-end-0">Física</label>
                        <input id="efis" class="form-control bg-black text-white border-start-0" type="number" name="fisica" value="<?php echo $fisica;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="emor" class="input-group-text bg-black text-white border-end-0">Morte</label>
                        <input id="emor" class="form-control bg-black text-white border-start-0" type="number" name="morte" value="<?php echo $morte;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="econ" class="input-group-text bg-black text-white border-end-0">Conhecimento</label>
                        <input id="econ" class="form-control bg-black text-white border-start-0" type="number" name="conhecimento" value="<?php echo $conhecimento;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="esan" class="input-group-text bg-black text-white border-end-0">Sangue</label>
                        <input id="esan" class="form-control bg-black text-white border-start-0" type="number" name="sangue" value="<?php echo $sangue;?>"/>
                    </div>
                    <div class="input-group input-group-sm m-1">
                        <label for="eene" class="input-group-text bg-black text-white border-end-0">Energia</label>
                        <input id="eene" class="form-control bg-black text-white border-start-0" type="number" name="energia" value="<?php echo $energia;?>"/>
                    </div>
                    <input type="hidden" name="status" value="editpri"/>
                </div>
                <div class="clearfix m-2">
                    <button class="btn btn-outline-success float-start" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!---TROCAR DE PERFIL MODAL--->
<div class="modal fade" id="trocarficha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-black border-light">
            <div class="modal-body justify-content-center text-center">
                <h1>Trocar Rápido</h1>

                <?php
                $k = $con->query("SELECT * FROM `ligacoes` WHERE `id_usuario` = '".$_SESSION["UserID"]."' AND `id_ficha` IS NOT NULL;");
                if ($k->num_rows){
                    echo "<h5>Com missão</h5>";
                foreach ($k as $r):
                    $ks=$con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '".$r["id_ficha"]."'");
                    $rs = mysqli_fetch_array($ks);
                ?>
                    <div class="d-grid gap-2 m-2">
                        <a class="btn btn-primary" href="./?id=<?=$r["id_ficha"]?>"><?=$rs["nome"]?></a>
                    </div>
                <?php
                endforeach;
                }

                ?>
                <?php
                $k = $con->query("SELECT * FROM `fichas_personagem` WHERE `usuario` = '".$_SESSION["UserID"]."';");
                if ($k->num_rows){
                    echo "<h5>Todas as Fichas</h5>";
                foreach ($k as $r):
                ?>
                    <div class="d-grid gap-2 m-2">
                        <a class="btn btn-primary" href="./?id=<?=$r["id"]?>"><?=$r["nome"]?></a>
                    </div>
                <?php
                endforeach;
                }

                ?>
                <div class="clearfix">
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
