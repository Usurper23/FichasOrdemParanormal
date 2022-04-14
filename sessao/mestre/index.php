<?php
require_once "./../../config/mysql.php";
$con = con();
$uid = $_SESSION["UserID"];
$id = intval($_GET["id"] ?:$_POST["id"]);
if(!$_SESSION["UserAdmin"]) {
    if ($id === 0 || !VerificarMestre($id)) {
        echo "<script>window.location.href='./../'</script>";
    }
}
$q = $con->query("Select * FROM `ligacoes` WHERE id_missao = '".$id."'");

if (isset($_POST["add"])){
    $type = 1;
    $success = true;
    if (!empty($_POST["email"])) {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Email inserido não é valido.";
            $success = false;
        }
    } else {
        $success = false;
        $msg = "Preencha o campo de email!";
    }
    if($success){
        $q = $con->query("SELECT * FROM `usuarios` WHERE `email`='$email' AND `status` = 1"); // verifica se a conta existe
        if($q->num_rows == 1){
            $a = mysqli_fetch_array($q);
            $qa = $con->query("SELECT * FROM `ligacoes` WHERE `id_missao` = '$id' AND `id_usuario` = '".$a["id"]."' AND `id_ficha` IS NULL");
            if (!$qa->num_rows>0){
            $aq = $con->query("INSERT INTO `ligacoes`(`id_missao`,`id_usuario`) VALUES ('".$id."','".$a["id"]."') ");
            if ($aq){
                $msg = "Jogador Adicionado! (Conta Existente)";
            } else {
                $success = false;
                $msg = "Falha ao Adicionar! (Erro na Database)";
            }
            } else {
                $msg = "Jogador Adicionado! (Conta Existente)";
            }
        } else {
            $qq = $con->query("SELECT * FROM `usuarios` WHERE `email`='$email' AND `status` = 0"); // verifica se está ativa
            if (!$qq->num_rows) {
                $aq = $con->query("INSERT INTO `usuarios` (`status`, `email`) VALUES ('0','$email');"); // cria conta
                $baa = $con->query("SELECT * FROM `usuarios` WHERE `email`='$email'"); // seleciona tudo da mesma conta
                $ba = mysqli_fetch_array($baa);
                $qa = $con->query("INSERT INTO `ligacoes`(`id_missao`,`id_usuario`,`id_ficha`) VALUES ('".$id."','".$ba["id"]."',NULL);"); //cria ligações
                if ($aq) {
                    $msg = "Jogador Adicionado! (Conta Inexistente) Link:";
                } else {
                    $success = false;
                    $msg = "Falha ao Adicionar! (Erro na Database)";
                }
            } else {
                $msg = "Jogador Adicionado! (Conta Inexistente) Link:";
            }
            $type = 2;
        }
    }
    $data["msg"] = $msg;
    $data["success"] = $success;
    $data["email"] = $email;
    $data["type"] = $type;
    echo json_encode($data);
    exit;
}
if (isset($_POST["ini"])){
    $data=[];
    $c = 0;
    while($c != count($_POST["id"])){
        $nome = $_POST['nome'][$c];
        $idi = intval($_POST['id'][$c]);
        $prioridade = intval($_POST['prioridade'][$c]);
        $iniciativa = minmax($_POST['iniciativa'][$c],-50,50);
        $dano = minmax($_POST['dano'][$c],-999,999);

        $q = $con->prepare("UPDATE iniciativas SET `nome`= ?,`iniciativa`= ?,`prioridade`= ?,`dano`= ? WHERE iniciativas.id = ?");
        $q->bind_param("siiii",$nome,$iniciativa,$prioridade,$dano,$idi);
        $q->execute();
        $c ++;
    }
    $data["missao"] = $id;
    $data["count"] = count($_POST["iniciativa"]);
    $data["post"] = $_POST;
}

if(isset($_POST["status"])){
    $success = true;
    $msg='';
    switch ($_POST["status"]){
        case 'criariniciativa':
            $a =$con->query("INSERT INTO `iniciativas` (`id_missao`) VALUES ('$id');");
            break;
        case 'deleteini':
            $a=$con->query("DELETE FROM `iniciativas` WHERE `id_missao`='".$id."' AND `id`='".intval($_POST["iniciativa_id"])."';");
            break;
        case 'upv':
            $ficha_id = intval($_POST["ficha"]);
            $sq = $con->query("Select * From `fichas_npc` where `missao` = '$id' AND `id` = '$ficha_id';");
            $rs = mysqli_fetch_array($sq);
            $pva = $rs["pva"] + intval($_POST["value"]);
            $ppva = $rs["pv"] + 20;
            if ($pva >= $ppva) {
                $pva = intval($rs["pv"] + 20);
            } elseif ($pva <= 0) {
                $pva = 0;
            }
            $s = $con->query("UPDATE `fichas_npc` SET `pva` = '".$pva."' WHERE `missao` = ".$id ." AND `id` = '".$ficha_id."';");
            if ($con->affected_rows) {
                $msg = "Vida alterada!";
            } else {
                $success = false;
                $msg = "Vida NÃO alterada!";
            }
            break;
        case 'usan':
            $ficha_id = intval($_POST["ficha"]);
            $sq = $con->query("Select * From `fichas_npc` where `missao` = '$id' AND `id` = '$ficha_id';");
            $rs = mysqli_fetch_array($sq);
            $sana = $rs["sana"] + intval($_POST["value"]);
            $psana = $rs["san"] + 20;
            if ($sana >= $psana) {
                $sana = intval($rs["san"] + 20);
            } elseif ($sana <= 0) {
                $sana = 0;
            }
            $s = $con->query("UPDATE `fichas_npc` SET `sana` = '".$sana."' WHERE `missao` = ".$id ." AND `id` = '".$ficha_id."';");
            if ($con->affected_rows) {
                $msg = "Sanidade alterada!";
            } else {
                $success = false;
                $msg = "Sanidade NÃO alterada!";
            }
            break;
        case 'pe':
            $npc = intval($_POST["npc"]);
            $sq = $con->query("Select `pe` From `fichas_npc` where `id` = '$npc' AND `missao`='$id';");
            $rs = mysqli_fetch_array($sq);
            $pea = $rs["pe"] - intval($_POST["value"]);
            $s = $con->query("Update `fichas_npc` SET `pea` = '$pea' WHERE `id`='$npc' AND `missao`='$id';");
            break;
        case 'deletenpc':
            $npc = intval($_POST["npc"]);
            $s = $con->query("DELETE FROM `fichas_npc` WHERE `missao` = '$id' AND `id` = '$npc';");
            break;
        case 'addnpc':
            $nome = test_input($_POST["nome"]);
            $pv = minmax($_POST["pv"],0,999);
            $san = minmax($_POST["san"],0,999);
            $pe = minmax($_POST["pe"],0,50);
            $for = minmax($_POST["forca"],-10,10);
            $agi = minmax($_POST["agilidade"],-10,10);
            $int = minmax($_POST["intelecto"],-10,10);
            $pre = minmax($_POST["presenca"],-10,10);
            $vig = minmax($_POST["vigor"],-10,10);
            $passiva = minmax($_POST["passiva"],0,50);
            $bloqueio = minmax($_POST["bloqueio"],0,50);
            $esquiva = minmax($_POST["esquiva"],0,50);
            $morte = minmax($_POST["morte"],0,50);
            $sangue = minmax($_POST["sangue"],0,50);
            $energia = minmax($_POST["energia"],0,50);
            $conhecimento = minmax($_POST["conhecimento"],0,50);
            $fisica = minmax($_POST["fisica"],0,50);
            $balistica = minmax($_POST["balistica"],0,50);
            $mental = minmax($_POST["mental"],0,50);
            
            $atle = minmax($_POST["atletismo"],0,50);
            $atua = minmax($_POST["atualidades"],0,50);
            $cien = minmax($_POST["ciencia"],0,50);
            $dipl = minmax($_POST["diplomacia"],0,50);
            $enga = minmax($_POST["enganacao"],0,50);
            $fort = minmax($_POST["fortitude"],0,50);
            $furt = minmax($_POST["furtividade"],0,50);
            $luta = minmax($_POST["luta"],0,50);
            $medi = minmax($_POST["medicina"],0,50);
            $ocul = minmax($_POST["ocultismo"],0,50);
            $perc = minmax($_POST["percepcao"],0,50);
            $pilo = minmax($_POST["pilotagem"],0,50);
            $pont = minmax($_POST["pontaria"],0,50);
            $pres = minmax($_POST["prestidigitacao"],0,50);
            $prof = minmax($_POST["profissao"],0,50);
            $refl = minmax($_POST["reflexos"],0,50);
            $reli = minmax($_POST["religiao"],0,50);
            $tati = minmax($_POST["tatica"],0,50);
            $tecn = minmax($_POST["tecnologia"],0,50);
            $vont = minmax($_POST["vontade"],0,50);
            $q = $con->query("INSERT INTO `fichas_npc`(`id`,`missao`,`nome`,`pv`,`pva`,`san`,`sana`,`pe`,`pea`,`forca`,`agilidade`,`inteligencia`,`presenca`,
                         `vigor`,`passiva`,`bloqueio`,`esquiva`,`morte`,`sangue`,`energia`,`conhecimento`,`balistica`,`fisica`,`mental`,
                         `atletismo`,`atualidade`,`ciencia`,`diplomacia`,`enganacao`,`fortitude`,`furtividade`,`luta`,`medicina`,`ocultismo`,`percepcao`,`pilotagem`,`pontaria`,`prestidigitacao`,`profissao`,
                         `reflexos`,`religiao`,`tatica`,`tecnologia`,`vontade`) VALUES 
                        ('','$id','$nome','$pv','$pv','$san','$san','$pe','$pe','$for','$agi','$int','$pre','$vig','$passiva','$bloqueio','$esquiva','$morte','$sangue','$energia','$conhecimento','$balistica','$fisica','$mental','$atle','$atua','$cien','$dipl','$enga','$fort','$furt','$luta','$medi','$ocul','$perc','$pilo','$pont','$pres','$prof','$refl','$reli','$tati','$tecn','$vont')");
            break;
        case 'syncnotes':
            $a = count($_POST["titulo"]);
            $b = 0;
            while ($b < $a){
                if (!empty($_POST["titulo"])) {
                    $tit = $_POST["titulo"][$b];
                    if (!preg_match("/^[áàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑa-zA-Z-' 0-9]*$/", $tit)){
                        $tit = "Títulob";
                    }
                } else {
                    $tit = "Títuloa";
                }
                if (strlen($tit) > 30){
                    $tit = "Títuloasc";
                }
                $des = test_input($_POST["nota"][$b]);
                $nota = intval($_POST["id"][$b]);
                $q = $con->query("UPDATE `notes` SET `nome` = '$tit', `notas` = '$des' WHERE `missao` = '$id' AND `id`='$nota';");
                $b++;
            }
            break;
        case 'addnote':
            $q = $con->query("INSERT INTO `notes`(`id`,`nome`,`notas`,`missao`) VALUES ('','Título','È Recomendado usar notas externas!','$id');");
            break;
        case 'deletenote':
            $nid = intval($_POST["note"]);
            $q = $con->query("DELETE FROM `notes` WHERE `id`='$nid' AND `missao`='$id' ");
            break;
    }
}
?>
<!DOCTYPE html>
<head>
    <?php require_once "./../../includes/head.html";?>
    <title>Mestre - FichasOP</title>
</head>
<body class="bg-black text-white">
<?php include_once "./../../includes/top.php";?>
<div class="modal" id="adicionar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content bg-black border-light" id="formadd" method="post" autocomplete="off">
            <div class="modal-body">
                <div class="modal-header border-0 text-center">
                    <h4 class="modal-title" id="exampleModalLabel">Adicionar jogador</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="my-1" id="msgadd"></div>
                <div class="container-fluid">
                    <p class="text-info">Se o jogador não tiver conta cadastrada, coloque-o email do mesmo, irá gerar um link(que tambem será enviado via email), envie para o jogador.</p>
                    <label class="fs-5 m-1" for="email">Email do jogador</label>
                    <input type="email" id="email" name="email" class="form-control bg-black text-light" required/>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <input type="hidden" name="add" value="sim"/>
            </div>
        </form>
    </div>
</div>
<div class="container-fluid">
    <div class="row mx-md-5">
        <div class="col-lg-6 my-2">
            <div class="card bg-black border-light h-100">
                <div class="card-body p-0">
                    <div class="position-absolute end-0">
                        <button class="float-end btn text-success" data-bs-toggle="modal" data-bs-target="#adicionar" ><i class="fa-lg fa-regular fa-square-plus"></i></button>
                        <button class="float-end btn text-primary" id="refreshficha"><i class="fa-lg fa-solid fa-arrow-rotate-left"></i></button>
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
        <div class="col-lg-6 my-2">
            <div class="card h-100 w-100 bg-black border-light">
                <div class="card-body p-0">
                    <div class="card-header border-0">
                        <div class="card-title fs-2 text-center">Iniciativas.</div>
                    </div>
                    <div class="container-fluid p-0">
                        <table class="table table-black text-white" id="iniciativa">
                            <input type="hidden" name="ini" value="true">
                            <thead>
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-sm text-success" onclick="adicionariniciativa();">
                                        <i class="fa-regular fa-square-plus"></i>
                                    </button>
                                </th>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Iniciativa</th>
                                <th>Dano</th>
                                <th style="min-width: 80px;">
                                    <button type="button" class="btn btn-sm text-primary" onclick="location.reload();">
                                        <i class="fa-solid fa-arrow-rotate-left"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="ui-drag">
                            <?php
                            $a = $con->query("SELECT * FROM `iniciativas` WHERE `id_missao` = '".$id."' ORDER BY prioridade");
                            if ($a->num_rows >0){
                                $p = 1;
                                while ($r = mysqli_fetch_array($a)){
                                    ?>
                                <tr class="drag">
                                    <input type="hidden" class="hidden" name="prioridade[]" value="<?=$p;?>">
                                    <input type="hidden" name="id[]" value="<?=$r["id"];?>">
                                    <td class="p-0">
                                        <button type="button" class="btn up btn-sm text-info"><i class="fa-solid fa-chevrons-up"></i></button>
                                    </td>
                                    <td class="index p-0">
                                        <?=$p?>
                                    </td>
                                    <td class="iniciativa p-0">
                                        <input type="text" style="min-width: 40px" autocomplete="off" class="bg-transparent text-white form-control border-0 form-control-sm" name="nome[]" readonly value="<?=$r["nome"];?>">
                                    </td>
                                    <td class="iniciativa p-0">
                                        <input type="number" style="max-width: 70px" autocomplete="off" class="bg-transparent text-white form-control border-0 form-control-sm" name="iniciativa[]" readonly value="<?=$r["iniciativa"];?>">
                                    </td>
                                    <td class="iniciativa p-0">
                                        <input type="number" style="max-width: 45px" autocomplete="off" class="bg-transparent text-white form-control border-0 form-control-sm" name="dano[]" readonly value="<?=$r["dano"];?>">
                                    </td>
                                    <td class="p-0">
                                        <button type="button" class="btn down btn-sm text-info">
                                            <i class="fa-solid fa-chevrons-down"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm text-danger" onclick="deletariniciativa(<?=$r["id"]?>)">
                                            <i class="fa-regular fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                    <?php $p++;}} else {?>
                                <tr>
                                    <td></td>
                                    <td class="index"></td>
                                    <td>Crie uma iniciativa</td>
                                    <td>adicionando um personagem.</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="card-footer border-0">
                            <span class="text-info"><i class="fa-regular fa-circle-info"></i> Clique duas vezes para editar.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 my-2">
            <div class="card h-100 w-100 bg-black border-light">
                <div class="card-body p-0">
                    <div class="position-absolute end-0">
                        <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#addnpc">
                            <i class="fa-lg fa-regular fa-square-plus"></i>
                        </button>
                    </div>
                    <div class="card-header border-0">
                        <div class="card-title fs-2 text-center">Fichas NPCs</div>
                    </div>
                    <div class="container-fluid p-0">
                        <div class="row m-2" id="fichasperson">
                            <?php include_once "./fichas/npc.php";?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 my-2">
            <div class="card h-100 w-100 bg-black border-light">
                <div class="card-body p-0">
                    <div class="card-header border-0">
                        <div class="card-title fs-2 text-center">Anotações <i id="syncnotes" class=""></i></div>
                    </div>
                    <form class="container-fluid p-0" id="noteform">
                        <ul class="nav nav-pills justify-content-center mb-3" id="notestitle" role="tablist">
                <?php $nt = $con->query("SELECT * FROM `notes` WHERE `missao` = '$id';");
                foreach ($nt as $r):?>
                            <li class="nav-item title" role="presentation">
                                <button class="nav-link" id="a<?=$r["id"]?>-tab" data-bs-toggle="pill" data-bs-target="#a<?=$r["id"]?>" type="button" role="tab" aria-controls="a<?=$r["id"]?>" aria-selected="true"><?=$r["nome"]?></button>
                            </li>
                <?php endforeach;?>
                            <?php if($nt->num_rows <5){?>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="btn text-success" onclick="addnote();"><i class="fa-regular fa-square-plus"></i> Adicionar</button>
                            </li>
                            <?php }?>
                        </ul>
                        <div class="tab-content" id="notes">
                <?php foreach ($nt as $r):?>
                            <div class="tab-pane fade show" id="a<?=$r["id"]?>" role="tabpanel" aria-labelledby="a<?=$r["id"]?>-tab">
                                <input type="hidden" name="id[]" value="<?=$r["id"]?>" />
                                <div class="input-group">
                                    <input type="text" required class="note form-control bg-black text-light" name="titulo[]" aria-label="Titulo" placeholder="Titulo" maxlength="30" value="<?=$r["nome"]?>" />
                                    <button type="button" onclick="deletenote(<?=$r["id"]?>)" class="btn text-danger fa-regular fa-trash"></button>
                                </div>
                                <textarea  aria-label="a<?=$r["id"]?>" name="nota[]" class="note form-control bg-black text-light" maxlength="3000"><?=$r["notas"]?></textarea>
                            </div>
                <?php endforeach;?>
                        </div>
                        <input type="hidden" name="status" value="syncnotes" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2500;  //time in ms, 5 seconds for example
    var $note = $('#notes .note');
    function updtvida(valor,ficha){
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'upv', ficha: ficha, value: valor},
        }).done(function (data) {
            $("#saude").load(location.href + " #saude>*");
        })
    }//Atualizar vida npc
    function updtsan(valor,ficha) {
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'usan', ficha: ficha, value: valor},
        }).done(function (data) {
            $("#saude").load(location.href + " #saude>*");
        })
    }//Atualizar Sanidade npc
    function adicionariniciativa(){
        $.post({
            data: {status: 'criariniciativa'},
            url: '?id=<?=$id;?>',
            dataType: ""
        }).done(function (data) {
            location.reload();
        })
    }
    function submitiniciativa(){
        $.post({
            url: '?id=<?=$id;?>',
            dataType: '',
            data: $('#iniciativa :input').serialize(),
            success: function(data) {
            }
        });
    }
    function deletariniciativa(iniciativa_id){
        $.post({
            data: {status: 'deleteini', iniciativa_id: iniciativa_id},
            url: '?id=<?=$id;?>',
        }).done(function () {
            location.reload();
        })
    }
    function deletnpc(id){
        $.post({
            data: {status: 'deletenpc', npc: id},
            url: '?id=<?=$id;?>',
        }).done(function () {
            location.reload();
        })
    }
    updateIndex = function(e, ui){
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i+1);
        });
        $('input.hidden', ui.item.parent()).each(function (i) {
            $(this).val(i + 1);
        });
        submitiniciativa();
    };
    function updtpe(id){
        var checkboxes = $('#npc'+id+' .pontos_esforco input:checkbox:checked').length;
        $.post({
            url: '?id=<?php echo $id;?>',
            data: {status: 'pe',value: checkboxes,npc:id},
        }).done(function () {
            $("#npc"+id+" .pontos_esforco").load( "?id=<?php echo $id;?> #npc"+id+" .pontos_esforco" );
        })
    }
    function doneTyping () {
        sync = $("#noteform").serialize();
        $.post({
            url: "",
            data: sync,
        }).done(function () {
            $("#syncnotes").attr("class","text-success fa-regular fa-cloud-check");
        }).fail(function () {
            $("#syncnotes").attr("class","text-danger fa-regular fa-cloud-x");
        })
    }
    function addnote(){
        $.post({
            data: {status: 'addnote'},
            url: "",
        }).done(function (data) {
            location.reload();
        });
    }
    function deletenote(id){
        $.post({
            data: {status: 'deletenote',note:id},
            url: "",
        }).done(function (data) {
            location.reload();
        });
    }
    $(document).ready(function(){
        $note.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $note.on('keydown', function () {
            clearTimeout(typingTimer);
            $("#syncnotes").attr("class","text-warning fa-solid fa-arrows-rotate fa-spin");
        });


        $('#formadd').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.post({
                beforeSend: function(){
                    $("#formadd input, #formadd button").attr('disabled', true);
                    $("#msgadd").html("<div class='alert alert-warning'>Aguarde enquanto verificamos os dados...</div>");
                },
                url: "",
                data: form.serialize(),
                dataType:"JSON",
                error:function(data){
                    $("#formadd input, #formadd button").attr('disabled', false);
                    $("#msgadd").html("<div class='alert alert-danger'>Houve um erro ao fazer a solicitação, contate um administrador!</div>");
                },
            }).done(function (data) {
                if (data.msg) {
                    if (!data.success){
                        $("#msgadd").html('<div class="alert alert-danger">' + data.msg + "</div>");
                        $("#formadd input, #formadd button").attr('disabled', false);
                    } else {
                        if(data.type == 1) {
                            $("#msgadd").html('<div class="alert alert-success">' + data.msg + '</div>');
                            setTimeout(function () {
                                $("#formadd input, #formadd button").attr('disabled', false);
                            }, 200)
                        } else {
                            $("#msgadd").html('<div class="alert alert-success">' + data.msg + ' <a href="https://fichasop.cf/?convite=1&email='+data.email+'">https://fichasop.cf/?convite=1&email=' +data.email + '</a></div>');
                            setTimeout(function () {
                                $("#formadd input, #formadd button").attr('disabled', false);
                            }, 200)
                        }
                    }
                }

            });
        });
        $(".iniciativa").dblclick(function () {
        $(this).children("input").attr('readonly', false).toggleClass('border-0').delay(200).focus();
    })
        $(".iniciativa input").focusout(function () {
        let attr = $(this).attr('readonly');
        if (typeof attr !== 'undefined' && attr !== false) {
            $(this).attr('readonly', true)
        } else {
            $(this).attr('readonly',true).toggleClass('border-0')
            submitiniciativa();
        }
    })
        $(".up,.down").click(function(){
            const item = $(this).parents("tr:first");
            const ui = {item};
            if ($(this).is(".up")) {
                item.insertBefore(item.prev());
            } else {
                item.insertAfter(item.next());
            }
            updateIndex('',ui);
        });
        $('#refreshficha').click(function(){
            $('#fichasperson').load('?id=<?php echo$id;?>'+' #fichasperson>*')
            $('#refreshficha').attr('disabled', true)
            setTimeout(function() {
                $('#refreshficha').attr("disabled", false)
            }, 2000);
        })
    });
</script>
</body>