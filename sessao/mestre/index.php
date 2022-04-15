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

if(isset($_POST["status"])){
    $success = true;
    $msg='';
    switch ($_POST["status"]){
        case 'updtini':
            $data=[];
            $c = 0;
            while($c != count($_POST["id"])){
                $nome = $_POST['nome'][$c];
                $idi = intval($_POST['id'][$c]);
                $prioridade = intval($_POST['prioridade'][$c]);
                $iniciativa = minmax($_POST['iniciativa'][$c],-50,50);
                $dano = minmax($_POST['dano'][$c],-999,999);

                $z = $con->prepare("UPDATE iniciativas SET `nome`= ?,`iniciativa`= ?,`prioridade`= ?,`dano`= ? WHERE iniciativas.id = ?");
                $z->bind_param("siiii",$nome,$iniciativa,$prioridade,$dano,$idi);
                $z->execute();
                $c ++;
            }
            $data["missao"] = $id;
            $data["count"] = count($_POST["iniciativa"]);
            $data["post"] = $_POST;
    break;
        case 'addplayer':
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
                $z = $con->query("SELECT * FROM `usuarios` WHERE `email`='$email' AND `status` = 1"); // verifica se a conta existe
                if($z->num_rows == 1){
                    $a = mysqli_fetch_array($z);
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
            break;
        case 'criariniciativa':
            $con->query("INSERT INTO `iniciativas` (`id_missao`) VALUES ('$id');");
            break;
        case 'deleteini':
            $con->query("DELETE FROM `iniciativas` WHERE `id_missao`='".$id."' AND `id`='".intval($_POST["iniciativa_id"])."';");
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
            $con->query("UPDATE `fichas_npc` SET `pva` = '".$pva."' WHERE `missao` = ".$id ." AND `id` = '".$ficha_id."';");
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
            $con->query("UPDATE `fichas_npc` SET `sana` = '".$sana."' WHERE `missao` = ".$id ." AND `id` = '".$ficha_id."';");
            if ($con->affected_rows) {
                $msg = "Sanidade alterada!";
            } else {
                $success = false;
                $msg = "Sanidade NÃO alterada!";
            }
            break;
        case 'pe':
            $npc = intval($_POST["npc"]);
            $con->query("Select `pe` From `fichas_npc` where `id` = '$npc' AND `missao`='$id';");
            $rs = mysqli_fetch_array($sq);
            $pea = $rs["pe"] - intval($_POST["value"]);
            $con->query("Update `fichas_npc` SET `pea` = '$pea' WHERE `id`='$npc' AND `missao`='$id';");
            break;
        case 'deletenpc':
            $npc = intval($_POST["npc"]);
            $con->query("DELETE FROM `fichas_npc` WHERE `missao` = '$id' AND `id` = '$npc';");
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
            $inti = minmax($_POST["intimidacao"],0,50);
            $intu = minmax($_POST["intuicao"],0,50);
            $inve = minmax($_POST["investigacao"],0,50);
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
            if(strlen($nome)>30){
                $nome = "NPC";
            }
            $con->query("INSERT INTO `fichas_npc`(`id`,`missao`,`nome`,`pv`,`pva`,`san`,`sana`,`pe`,`pea`,`forca`,`agilidade`,`inteligencia`,`presenca`,
                         `vigor`,`passiva`,`bloqueio`,`esquiva`,`morte`,`sangue`,`energia`,`conhecimento`,`balistica`,`fisica`,`mental`,
                         `atletismo`,`atualidade`,`ciencia`,`diplomacia`,`enganacao`,`fortitude`,`furtividade`,`intimidacao`,`intuicao`,`investigacao`,`luta`,`medicina`,`ocultismo`,`percepcao`,`pilotagem`,`pontaria`,`prestidigitacao`,`profissao`,
                         `reflexos`,`religiao`,`tatica`,`tecnologia`,`vontade`) VALUES 
                        ('','$id','$nome','$pv','$pv','$san','$san','$pe','$pe','$for','$agi','$int','$pre','$vig','$passiva','$bloqueio','$esquiva','$morte','$sangue','$energia','$conhecimento','$balistica','$fisica','$mental','$atle','$atua','$cien','$dipl','$enga','$fort','$furt','$inti','$intu','$inve','$luta','$medi','$ocul','$perc','$pilo','$pont','$pres','$prof','$refl','$reli','$tati','$tecn','$vont')");
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
                $y = $con->query("UPDATE `notes` SET `nome` = '$tit', `notas` = '$des' WHERE `missao` = '$id' AND `id`='$nota';");
                $b++;
            }
            break;
        case 'addnote':
            $y = $con->query("INSERT INTO `notes`(`id`,`nome`,`notas`,`missao`) VALUES ('','Título','È Recomendado usar notas externas!','$id');");
            break;
        case 'deletenote':
            $nid = intval($_POST["note"]);
            $y = $con->query("DELETE FROM `notes` WHERE `id`='$nid' AND `missao`='$id' ");
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="br">
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
                    <input type="hidden" name="status" value="addplayer"/>
                </div>
            </form>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mx-md-5">
            <?php include_once "./includes/fichasplayer.php";?>
            <?php include_once "./includes/iniciativas.php";?>
            <?php include_once "./includes/fichasnpc.php";?>
            <?php include_once "./includes/anotacoes.php";?>
        </div>
    </div>
    <?php require_once "./includes/scripts.php";?>
    </body>
</html>