<?php
require_once "./../../config/mysql.php";
$con = con();
$uid = $_SESSION["UserID"];
$id = intval($_GET["id"] ?: $_POST["id"]);
if (!$_SESSION["UserAdmin"]) {
    if ($id === 0 || !VerificarMestre($id)) {
        echo "<script>window.location.href='./../'</script>";
    }
}
$q = $con->query("Select * FROM `ligacoes` WHERE id_missao = '" . $id . "'");
if (isset($_POST["status"])) {
    $success = true;
    $msg = '';
    switch ($_POST["status"]) {
        case 'updtini':
            $data = [];
            $c = 0;
            while ($c != count($_POST["id"])) {
                $nome = $_POST['nome'][$c];
                $idi = intval($_POST['id'][$c]);
                $prioridade = intval($_POST['prioridade'][$c]);
                $iniciativa = minmax($_POST['iniciativa'][$c], -50, 50);
                $dano = minmax($_POST['dano'][$c], -999, 999);

                $z = $con->prepare("UPDATE iniciativas SET `nome`= ?,`iniciativa`= ?,`prioridade`= ?,`dano`= ? WHERE iniciativas.id = ?");
                $z->bind_param("siiii", $nome, $iniciativa, $prioridade, $dano, $idi);
                $z->execute();
                $c++;
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
            if ($success) {
                $z = $con->query("SELECT * FROM `usuarios` WHERE `email`='$email' AND `status` = 1"); // verifica se a conta existe
                if ($z->num_rows == 1) {
                    $a = mysqli_fetch_array($z);
                    $qa = $con->query("SELECT * FROM `ligacoes` WHERE `id_missao` = '$id' AND `id_usuario` = '" . $a["id"] . "' AND `id_ficha` IS NULL");
                    if (!$qa->num_rows > 0) {
                        $aq = $con->query("INSERT INTO `ligacoes`(`id_missao`,`id_usuario`) VALUES ('" . $id . "','" . $a["id"] . "') ");
                        if ($aq) {
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
                        $qa = $con->query("INSERT INTO `ligacoes`(`id_missao`,`id_usuario`,`id_ficha`) VALUES ('" . $id . "','" . $ba["id"] . "',NULL);"); //cria ligações
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
            $con->query("DELETE FROM `iniciativas` WHERE `id_missao`='" . $id . "' AND `id`='" . intval($_POST["iniciativa_id"]) . "';");
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
            $con->query("UPDATE `fichas_npc` SET `pva` = '" . $pva . "' WHERE `missao` = " . $id . " AND `id` = '" . $ficha_id . "';");
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
            $con->query("UPDATE `fichas_npc` SET `sana` = '" . $sana . "' WHERE `missao` = " . $id . " AND `id` = '" . $ficha_id . "';");
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
            $con->query("Update `fichas_npc` SET `pea` = '$pea' WHERE `id`='$npc' AND `missao`='$id';");
            break;
        case 'deletenpc':
            $npc = intval($_POST["npc"]);
            $con->query("DELETE FROM `fichas_npc` WHERE `missao` = '$id' AND `id` = '$npc';");
            break;
        case 'addnpc':
            $nome = test_input($_POST["nome"]);
            $pv = minmax($_POST["pv"], 0, 999);
            $san = minmax($_POST["san"], 0, 999);
            $pe = minmax($_POST["pe"], 0, 50);
            $for = minmax($_POST["forca"], -10, 10);
            $agi = minmax($_POST["agilidade"], -10, 10);
            $int = minmax($_POST["intelecto"], -10, 10);
            $pre = minmax($_POST["presenca"], -10, 10);
            $vig = minmax($_POST["vigor"], -10, 10);
            $passiva = minmax($_POST["passiva"], 0, 50);
            $bloqueio = minmax($_POST["bloqueio"], 0, 50);
            $esquiva = minmax($_POST["esquiva"], 0, 50);
            $morte = minmax($_POST["morte"], 0, 50);
            $sangue = minmax($_POST["sangue"], 0, 50);
            $energia = minmax($_POST["energia"], 0, 50);
            $conhecimento = minmax($_POST["conhecimento"], 0, 50);
            $fisica = minmax($_POST["fisica"], 0, 50);
            $balistica = minmax($_POST["balistica"], 0, 50);
            $mental = minmax($_POST["mental"], 0, 50);

            $atle = minmax($_POST["atletismo"], 0, 50);
            $atua = minmax($_POST["atualidades"], 0, 50);
            $cien = minmax($_POST["ciencia"], 0, 50);
            $dipl = minmax($_POST["diplomacia"], 0, 50);
            $enga = minmax($_POST["enganacao"], 0, 50);
            $fort = minmax($_POST["fortitude"], 0, 50);
            $furt = minmax($_POST["furtividade"], 0, 50);
            $inti = minmax($_POST["intimidacao"], 0, 50);
            $intu = minmax($_POST["intuicao"], 0, 50);
            $inve = minmax($_POST["investigacao"], 0, 50);
            $luta = minmax($_POST["luta"], 0, 50);
            $medi = minmax($_POST["medicina"], 0, 50);
            $ocul = minmax($_POST["ocultismo"], 0, 50);
            $perc = minmax($_POST["percepcao"], 0, 50);
            $pilo = minmax($_POST["pilotagem"], 0, 50);
            $pont = minmax($_POST["pontaria"], 0, 50);
            $pres = minmax($_POST["prestidigitacao"], 0, 50);
            $prof = minmax($_POST["profissao"], 0, 50);
            $refl = minmax($_POST["reflexos"], 0, 50);
            $reli = minmax($_POST["religiao"], 0, 50);
            $tati = minmax($_POST["tatica"], 0, 50);
            $tecn = minmax($_POST["tecnologia"], 0, 50);
            $vont = minmax($_POST["vontade"], 0, 50);
            if (strlen($nome) > 30) {
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
            while ($b < $a) {
                if (!empty($_POST["titulo"])) {
                    $tit = $_POST["titulo"][$b];
                    if (!preg_match("/^[áàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑa-zA-Z-' 0-9]*$/", $tit)) {
                        $tit = "Títulob";
                    }
                } else {
                    $tit = "Títuloa";
                }
                if (strlen($tit) > 30) {
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
        case 'roll':
            $dado = test_input($_POST["dado"]);
            $dado = DadoDinamico($dado,0,0,0,0,0);
            if(ClearRolar($dado)) {
                $data = Rolar($dado);
                $data["success"] = true;
            } else {
                $data = ClearRolar($dado,true);
            }
            echo json_encode($data);
            exit;
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <?php require_once "./../../includes/head.html"; ?>
        <title>Mestre - FichasOP</title>
    </head>
    <body class="bg-black text-white">
    <?php include_once "./../../includes/top.php"; ?>
    <main class="container-fluid mt-5">
        <div class="row g-2">
            <div class="col-md">
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
                            while ($ra = mysqli_fetch_assoc($q)) {
                                if ($ra["id_ficha"] > 0) {
                                    $qf = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '" . $ra["id_ficha"] . "'");
                                    $ficha = mysqli_fetch_assoc($qf);
                                    ?>
                                    <div class="col-md-6 card-body border-0" id="player<?= $ficha["id"] ?>">
                                        <div class="card bg-black border-light">
                                            <div class="card-header border-0">
                                                <a class="card-title fs-5"
                                                   href="./../personagem/?id=<?= $ficha["id"] ?>"><?= $ficha["nome"] ?></a>
                                            </div>
                                            <div class="card-body border-0">
                                                <div class="my-2">
                                                    <h5>Vida: <?= $ficha["pva"] ?>/<?= $ficha["pv"] ?></h5>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                                                             style="width: <?= ($ficha["pva"] / $ficha["pv"]) * 100; ?>%;"
                                                             role="progressbar" aria-valuenow="<?= $ficha["pva"] ?>"
                                                             aria-valuemin="0" aria-valuemax="<?= $ficha["pva"] ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="my-2">
                                                    <h5>Sanidade: <?= $ficha["sana"] ?>/<?= $ficha["san"] ?></h5>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                                             style="width: <?= ($ficha["sana"] / $ficha["san"]) * 100; ?>%;"
                                                             role="progressbar" aria-valuenow="<?= $ficha["sana"] ?>"
                                                             aria-valuemin="0" aria-valuemax="<?= $ficha["san"] ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="my-2">
                                                    <h5>Esforço: <?= $ficha["pe"] - $ficha["pea"]; ?>/<?= $ficha["pe"]; ?>
                                                        Usados</h5>
                                                </div>
                                                <div class="my-2">
                                                    <?php
                                                    $s = $con->query("Select SUM(espaco) AS pesototal From `inventario` where `id_ficha` = '$id';");
                                                    $ddinv = mysqli_fetch_array($s);
                                                    $espacosusados = $ddinv["pesototal"];
                                                    ?>
                                                    <span>Peso: <?= $espacosusados ?: "0" ?>/<?= 5 + (5 * $ficha["forca"]); ?></span>
                                                    - <span>Movimento: 9</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card h-100 w-100 bg-black border-light">
                    <div class="card-body p-0">
                        <div class="card-header border-0">
                            <div class="card-title fs-2 text-center">Iniciativas.</div>
                        </div>
                        <div class="container-fluid p-0">
                            <table class="table table-black text-white" id="iniciativa">
                                <input type="hidden" name="status" value="updtini">
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
                                $a = $con->query("SELECT * FROM `iniciativas` WHERE `id_missao` = '" . $id . "' ORDER BY prioridade");
                                if ($a->num_rows > 0) {
                                    $p = 1;
                                    while ($r = mysqli_fetch_array($a)) {
                                        ?>
                                        <tr class="drag">
                                            <input type="hidden" class="hidden" name="prioridade[]" value="<?= $p; ?>">
                                            <input type="hidden" name="id[]" value="<?= $r["id"]; ?>">
                                            <td class="p-0">
                                                <button type="button" class="btn up btn-sm text-info"><i
                                                            class="fa-solid fa-chevrons-up"></i></button>
                                            </td>
                                            <td class="index p-0">
                                                <?= $p ?>
                                            </td>
                                            <td class="iniciativa p-0">
                                                <input type="text" style="min-width: 40px" autocomplete="off"
                                                       class="bg-transparent text-white form-control border-0 form-control-sm"
                                                       name="nome[]" readonly value="<?= $r["nome"]; ?>">
                                            </td>
                                            <td class="iniciativa p-0">
                                                <input type="number" style="max-width: 70px" autocomplete="off"
                                                       class="bg-transparent text-white form-control border-0 form-control-sm"
                                                       name="iniciativa[]" readonly value="<?= $r["iniciativa"]; ?>">
                                            </td>
                                            <td class="iniciativa p-0">
                                                <input type="number" style="max-width: 45px" autocomplete="off"
                                                       class="bg-transparent text-white form-control border-0 form-control-sm"
                                                       name="dano[]" readonly value="<?= $r["dano"]; ?>">
                                            </td>
                                            <td class="p-0">
                                                <button type="button" class="btn down btn-sm text-info">
                                                    <i class="fa-solid fa-chevrons-down"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm text-danger"
                                                        onclick="deletariniciativa(<?= $r["id"] ?>)">
                                                    <i class="fa-regular fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $p++;
                                    }
                                } else { ?>
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
                        <span class="text-info"><i
                                    class="fa-regular fa-circle-info"></i> Clique duas vezes para editar.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100 m-0"></div>
            <div class="col-md">
                <div class="card h-100 w-100 bg-black border-light">
                    <div class="card-body p-0">
                        <div class="position-absolute end-0">
                            <button class="btn text-success fa-lg" data-bs-toggle="modal" data-bs-target="#addnpc">
                                <i class="fa-regular fa-square-plus"></i>
                            </button>
                        </div>
                        <div class="card-header border-0">
                            <div class="card-title fs-2 text-center">Fichas NPCs</div>
                        </div>
                        <div class="container-fluid p-0">
                            <div class="row m-2" id="fichasperson">
                                <?php
                                $fichanpcs = $con->query("SELECT * FROM `fichas_npc` WHERE `missao` = '$id';");
                                while ($r = mysqli_fetch_array($fichanpcs)) {
                                    ?>
                                    <div class="col-xxl-6 card-body border-0 text-center" id="npc<?= $r["id"] ?>">
                                        <div class="card bg-black border-light">
                                            <div class="clearfix">
                                                <button class="btn btn-sm float-end text-danger"
                                                        onclick="deletnpc(<?= $r["id"] ?>);"><i class="fa-regular fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="card-header border-0">
                                                <div class="card-title fs-5"><?= $r["nome"] ?></div>
                                            </div>
                                            <div class="my-2">
                                                <h4>Atributos</h4>
                                                <div class="row m-2 justify-content-center">
                                                    <?= $r["forca"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">FOR: ' . ($r["forca"] > 0 ? "+" . $r["forca"] : $r["forca"]) . '</span></div>' : "" ?>
                                                    <?= $r["agilidade"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">AGI: ' . ($r["agilidade"] > 0 ? "+" . $r["agilidade"] : $r["agilidade"]) . '</span></div>' : "" ?>
                                                    <?= $r["inteligencia"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">INT: ' . ($r["inteligencia"] > 0 ? "+" . $r["inteligencia"] : $r["inteligencia"]) . '</span></div>' : "" ?>
                                                    <?= $r["presenca"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">PRE: ' . ($r["presenca"] > 0 ? "+" . $r["presenca"] : $r["presenca"]) . '</span></div>' : "" ?>
                                                    <?= $r["vigor"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">VIG: ' . ($r["vigor"] > 0 ? "+" . $r["vigor"] : $r["vigor"]) . '</span></div>' : "" ?>
                                                </div>
                                            </div>
                                            <div class="card-body border-0">
                                                <div id="saude">
                                                    <div class="mt-4">
                                                        <h4>Vida</h4>
                                                        <div class="clearfix" style="height: 40px;" id="pv">
                                                            <div class="fs-4" style="text-align: center; height: 0px;"
                                                                 id="pvpva"><?= $r["pva"] ?>/<?= $r["pv"] ?></div>
                                                            <div class="float-start" style="height: 0px;">
                                                                <button class="btn btn-sm text-white"
                                                                        onclick="updtvida(-5,<?= $r["id"] ?>);"
                                                                        style="height: 40px;">
                                                                    <i class="fa-solid fa-chevrons-left"></i> -5
                                                                </button>
                                                                <button class="btn btn-sm text-white"
                                                                        onclick="updtvida(-1,<?= $r["id"] ?>);"
                                                                        style="height: 40px;">
                                                                    <i class="fa-solid fa-chevron-left"></i> -1
                                                                </button>
                                                            </div>
                                                            <div class="float-end" style="height: 0px;">
                                                                <button class="btn btn-sm text-white"
                                                                        onclick="updtvida(1,<?= $r["id"] ?>);"
                                                                        style="height: 40px;">
                                                                    +1 <i class="fa-solid fa-chevron-right"></i>
                                                                </button>
                                                                <button class="btn btn-sm text-white"
                                                                        onclick="updtvida(5,<?= $r["id"] ?>);"
                                                                        style="height: 40px;">
                                                                    +5 <i class="fa-solid fa-chevrons-right"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                                                                 style="width: <?= ($r["pva"] / $r["pv"]) * 100; ?>%;"
                                                                 role="progressbar" aria-valuenow="<?= $r["pva"] ?>"
                                                                 aria-valuemin="0" aria-valuemax="<?= $r["pva"] ?>"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($r["san"] > 0) {
                                                        ?>
                                                        <div class="mt-4">
                                                            <h4>Sanidade</h4>
                                                            <div class="clearfix" style="height: 40px;" id="san">
                                                                <div class="fs-4" style="text-align: center; height: 0px;"
                                                                     id="sansana"><?= $r["sana"] ?>/<?= $r["san"] ?></div>
                                                                <div class="float-start" style="height: 0px;">
                                                                    <button class="btn btn-sm text-white"
                                                                            onclick="updtsan(-5,<?= $r["id"] ?>);"
                                                                            style="height: 40px;"><i
                                                                                class="fa-solid fa-chevrons-left"></i> -5
                                                                    </button>
                                                                    <button class="btn btn-sm text-white"
                                                                            onclick="updtsan(-1,<?= $r["id"] ?>);"
                                                                            style="height: 40px;"><i
                                                                                class="fa-solid fa-chevron-left"></i> -1
                                                                    </button>
                                                                </div>
                                                                <div class="float-end" style="height: 0px;">
                                                                    <button class="btn btn-sm text-white"
                                                                            onclick="updtsan(1,<?= $r["id"] ?>);"
                                                                            style="height: 40px;">+1 <i
                                                                                class="fa-solid fa-chevron-right"></i></button>
                                                                    <button class="btn btn-sm text-white"
                                                                            onclick="updtsan(5,<?= $r["id"] ?>);"
                                                                            style="height: 40px;">+5 <i
                                                                                class="fa-solid fa-chevrons-right"></i></button>
                                                                </div>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                                                     style="width: <?= ($r["sana"] / $r["san"]) * 100; ?>%;"
                                                                     role="progressbar" aria-valuenow="<?= $r["sana"] ?>"
                                                                     aria-valuemin="0" aria-valuemax="<?= $r["san"] ?>"></div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if ($r["pe"] > 0) {
                                                    ?>
                                                    <div class="mt-4 pontos_esforco">
                                                        <h4>Esforço</h4>
                                                        <h6><?= $r["pe"] - $r["pea"]; ?>/<?= $r["pe"]; ?> Usados</h6>
                                                        <?php
                                                        $unchecked = max($r["pe"] - $r["pea"], 0);
                                                        $a = 0;
                                                        while ($a != $unchecked) {
                                                            $a += 1;
                                                            echo '<input type="checkbox" class="form-check-input m-1" checked onchange="updtpe(' . $r["id"] . ')" aria-label="" autocomplete="off">';
                                                        }
                                                        while ($a != $r["pe"]) {
                                                            $a += 1;
                                                            echo '<input type="checkbox" class="form-check-input m-1" onchange="updtpe(' . $r["id"] . ')" aria-label="" autocomplete="off">';
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if (!$r["morte"] == 0 and !$r["sangue"] == 0 and !$r["energia"] == 0 and !$r["conhecimento"] == 0 and !$r["mental"] == 0 and !$r["fisica"] == 0 and !$r["balistica"] == 0) {
                                                    ?>
                                                    <div class="my-2">
                                                        <h4>Resistências</h4>
                                                        <div class="row m-2 justify-content-center">
                                                            <?= $r["morte"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Morte: ' . $r["morte"] . '</span></div>' : "" ?>
                                                            <?= $r["sangue"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Sangue: ' . $r["sangue"] . '</span></div>' : "" ?>
                                                            <?= $r["energia"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Energia: ' . $r["energia"] . '</span></div>' : "" ?>
                                                            <?= $r["conhecimento"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Conhecimento: ' . $r["conhecimento"] . '</span></div>' : "" ?>
                                                            <?= $r["mental"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Mental: ' . $r["mental"] . '</span></div>' : "" ?>
                                                            <?= $r["fisica"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Física: ' . $r["fisica"] . '</span></div>' : "" ?>
                                                            <?= $r["balistica"] ? '<div class="col-auto"><span class="input-group-text bg-black text-white">Balística: ' . $r["balistica"] . '</span></div>' : "" ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="mt-4 pericias">
                                                    <h4>Perícias</h4>
                                                    <div class="row m-2 justify-content-center">
                                                        <?= $r["atletismo"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Atletismo: +" . $r["atletismo"] . "</span></div>" : "" ?>
                                                        <?= $r["atualidade"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Atualidades: +" . $r["atualidade"] . "</span></div>" : "" ?>
                                                        <?= $r["ciencia"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Ciências: +" . $r["ciencia"] . "</span></div>" : "" ?>
                                                        <?= $r["diplomacia"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Diplomacia: +" . $r["diplomacia"] . "</span></div>" : "" ?>
                                                        <?= $r["enganacao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Enganação: +" . $r["enganacao"] . "</span></div>" : "" ?>
                                                        <?= $r["fortitude"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Fortitude: +" . $r["fortitude"] . "</span></div>" : "" ?>
                                                        <?= $r["furtividade"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Furtividade: +" . $r["furtividade"] . "</span></div>" : "" ?>
                                                        <?= $r["intimidacao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Intimidação: +" . $r["intimidacao"] . "</span></div>" : "" ?>
                                                        <?= $r["intuicao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Intuição: +" . $r["intuicao"] . "</span></div>" : "" ?>
                                                        <?= $r["investigacao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Investigação: +" . $r["investigacao"] . "</span></div>" : "" ?>
                                                        <?= $r["luta"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Luta: +" . $r["luta"] . "</span></div>" : "" ?>
                                                        <?= $r["medicina"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Medicina: +" . $r["medicina"] . "</span></div>" : "" ?>
                                                        <?= $r["ocultismo"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Ocultismo: +" . $r["ocultismo"] . "</span></div>" : "" ?>
                                                        <?= $r["percepcao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Percepção: +" . $r["percepcao"] . "</span></div>" : "" ?>
                                                        <?= $r["pilotagem"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Pilotagem: +" . $r["pilotagem"] . "</span></div>" : "" ?>
                                                        <?= $r["pontaria"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Pontaria: +" . $r["pontaria"] . "</span></div>" : "" ?>
                                                        <?= $r["prestidigitacao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Prestidigitação: +" . $r["prestidigitacao"] . "</span></div>" : "" ?>
                                                        <?= $r["profissao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Profissão: +" . $r["profissao"] . "</span></div>" : "" ?>
                                                        <?= $r["reflexos"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Reflexos: +" . $r["reflexos"] . "</span></div>" : "" ?>
                                                        <?= $r["religiao"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Religião: +" . $r["religiao"] . "</span></div>" : "" ?>
                                                        <?= $r["tatica"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Tática: +" . $r["tatica"] . "</span></div>" : "" ?>
                                                        <?= $r["tecnologia"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Tecnologia: +" . $r["tecnologia"] . "</span></div>" : "" ?>
                                                        <?= $r["vontade"] ? "<div class='col-auto m-1'><span class='input-group-text bg-black text-white'>Vontade: +" . $r["vontade"] . "</span></div>" : "" ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md">
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
                                        <button class="nav-link" id="a<?= $r["id"] ?>-tab" data-bs-toggle="pill"
                                                data-bs-target="#a<?= $r["id"] ?>" type="button" role="tab"
                                                aria-controls="a<?= $r["id"] ?>" aria-selected="true"><?= $r["nome"] ?></button>
                                    </li>
                                <?php endforeach; ?>
                                <?php if ($nt->num_rows < 5) { ?>
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="btn text-success" onclick="addnote();"><i
                                                    class="fa-regular fa-square-plus"></i> Adicionar
                                        </button>
                                    </li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content" id="notes">
                                <?php foreach ($nt as $r): ?>
                                    <div class="tab-pane fade show" id="a<?= $r["id"] ?>" role="tabpanel"
                                         aria-labelledby="a<?= $r["id"] ?>-tab">
                                        <input type="hidden" name="id[]" value="<?= $r["id"] ?>"/>
                                        <div class="input-group">
                                            <input type="text" required class="note form-control bg-black text-light"
                                                   name="titulo[]" aria-label="Titulo" placeholder="Titulo" maxlength="30"
                                                   value="<?= $r["nome"] ?>"/>
                                            <button type="button" onclick="deletenote(<?= $r["id"] ?>)"
                                                    class="btn text-danger fa-regular fa-trash"></button>
                                        </div>
                                        <textarea aria-label="a<?= $r["id"] ?>" name="nota[]"
                                                  class="note form-control bg-black text-light"
                                                  maxlength="3000"><?= $r["notas"] ?></textarea>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="status" value="syncnotes"/>
                        </form>
                    </div>
                </div>
            </div>
            <div class="w-100 m-0"></div>
            <div class="col-md" id="card_rolar">
                <div class="card h-100 bg-black border-light">
                            <div class="card-body p-0 font1">
                                <div class="position-absolute end-0">
                                    <button class="btn btn-sm text-info" title="Como rolar dados. "  data-bs-toggle="modal" data-bs-target="#rolardados">
                                        <i class="fa-regular fa-circle-info"></i>
                                    </button>
                                </div>
                                <div class="container-fluid p-2 justify-content-center text-center">
                                    <label class="font6 fs-1" for="rolardadosinput">Criar Dados</label>
                                    <div id="returncusdados"></div>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-black text-white" id="rolardadosinput"/>
                                        <button class="btn btn-sm btn-outline-light fa-regular fa-paper-plane-top" id="rolardadosbutton">
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </main>
    <!-- Modal ATRIBUTOS-->
    <div class="modal fade" id="rolardados" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-black border-light">
                <div class="modal-body">
                    <div class="text-center">Como Criar/Rolar Dados.</h2></div>
                    <div class="m-3">
                        <h3>Principios Basicos</h3>
                        <p>Um dado é composto por <var>N</var> faces depedendo do dado, esse valor fica depois do <code>d</code>.<br>
                            Exemplo: Um dado de 20 lados, será "<code>d20</code>".</p>
                        <p>
                            Para Expressar quantidade de dados, nós colocamos o valor antes do "<code>d</code>".<br>
                            Exemplo: Para rolar 2 dados de 6 lados, será "<code>2d6</code>, 2 de quantidade de dados, e 6 de lados".<br>
                        </p>
                        <p>
                            Agora para poder adicionar um valor fixo depois do resultado do dado, devemos por um "<code>+</code>" depois de tudo.<br>
                            Exemplo: Rolar 1 dado de 20 lados e somar 5 do resultado, ficará "<code>1d20+5</code>" OU "<code>d20+5</code>"(é importante não ter espaços).
                        </p>
                        <h5>Aprofundado nos principios</h5>
                        <p>
                            Para rolar dois ou mais dados de lados diferentes, é só usar "<code>+</code>" Entre cada um, deixando a soma para o final.
                            Exemplo: Um dado de 6 lados, somado com um dado de 10 lados, ficará "<code>1d6+1d10</code>" OU "<code>d6+d10</code>".
                        </p>
                        <h5>Lembrando que:</h5>
                        <ol>
                            <li>Dados podem ter lados, quantidades, e soma customizados.</li>
                            <li>Não pode rolar mais de 10 dados em cada item. (Errado:"<code>15d10</code>" Certo:"<code>10d10+5d10</code>").</li>
                            <li>Não pode rolar dados com mais de 100 lados, o limite é 100.</li>
                            <li>Não pode somar mais de 30 absolutamente(Negativo ou possitivo)</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="addnpc" tabindex="-1" aria-hidden="true">
        <div class="modal-xl modal-dialog modal-dialog-centered">
            <form class="modal-content bg-black border-light" id="formaddnpc" method="post" autocomplete="off">
                <div class="card-header">
                    <ul class="nav nav-pills mb-3 row justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item col-auto" role="presentation">
                            <button class="nav-link active" id="pills-dados-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-dados" type="button" role="tab" aria-controls="pills-dados"
                                    aria-selected="true">Dados
                            </button>
                        </li>
                        <li class="nav-item col-auto" role="presentation">
                            <button class="nav-link" id="pills-attr-tab" data-bs-toggle="pill" data-bs-target="#pills-attr"
                                    type="button" role="tab" aria-controls="pills-attr" aria-selected="false">Atributos
                            </button>
                        </li>
                        <li class="nav-item col-auto" role="presentation">
                            <button class="nav-link" id="pills-per-tab" data-bs-toggle="pill" data-bs-target="#pills-per"
                                    type="button" role="tab" aria-controls="pills-per" aria-selected="false">Perícias
                            </button>
                        </li>
                        <li class="nav-item col-auto" role="presentation">
                            <button class="nav-link" id="pills-out-tab" data-bs-toggle="pill" data-bs-target="#pills-out"
                                    type="button" role="tab" aria-controls="pills-out" aria-selected="false">etc.
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-dados" role="tabpanel"
                             aria-labelledby="pills-dados-tab">
                            <h2 class="my-2">Principal</h2>
                            <div class="m-2">
                                <label class="fs-4" for="nome">Nome</label>
                                <input id="nome" class="form-control bg-black text-light" name="nome" type="text"
                                       maxlength="30" required/>
                                <div class="invalid-feedback">
                                    Precisa pelomenos do nome
                                </div>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="pv">Pontos de Vida</label>
                                <input id="pv" class="form-control bg-black text-light" name="pv" type="number" min="1"
                                       max="999" value="1"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="san">Pontos de Sanidade</label>
                                <input id="san" class="form-control bg-black text-light" name="san" type="number" min="0"
                                       max="999" value="0"/>
                            </div>
                            <div class="m-2">
                                <label class="fs-4" for="pe">Pontos de Esforço</label>
                                <input id="pe" class="form-control bg-black text-light" name="pe" type="number" min="0"
                                       max="50" value="0"/>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-attr" role="tabpanel" aria-labelledby="pills-attr-tab">
                            <div class="containera text-white" id="atributos" title="Atributos, clique para editar">
                                <input required
                                       class="atributos for form-control rounded-circle bg-transparent text-white font4"
                                       type="number" min="-10" max="10" value='0' name="forca" aria-label="Força"/>
                                <input required
                                       class="atributos agi form-control rounded-circle bg-transparent text-white font4"
                                       type="number" min="-10" max="10" value='0' name="agilidade" aria-label="Agilidade"/>
                                <input required
                                       class="atributos int form-control rounded-circle bg-transparent text-white font4"
                                       type="number" min="-10" max="10" value='0' name="intelecto" aria-label="Intelecto"/>
                                <input required
                                       class="atributos pre form-control rounded-circle bg-transparent text-white font4"
                                       type="number" min="-10" max="10" value='0' name="presenca" aria-label="Presença"/>
                                <input required
                                       class="atributos vig form-control rounded-circle bg-transparent text-white font4"
                                       type="number" min="-10" max="10" value='0' name="vigor" aria-label="Vigor"/>
                                <img src="https://fichasop.cf/assets/img/Atributos.png" alt="Atributos">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-per" role="tabpanel" aria-labelledby="pills-per-tab">
                            <h2 class="my-2">Perícias</h2>
                            <div class="row m-2">
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="atletismo">Atletismo</label>
                                        <input id="atletismo" class="input-group-text bg-black text-light" name="atletismo"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="atualidades">Atualidades</label>
                                        <input id="atualidades" class="input-group-text bg-black text-light"
                                               name="atualidades" type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="ciencia">Ciências</label>
                                        <input id="ciencia" class="input-group-text bg-black text-light" name="ciencia"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="diplomacia">Diplomacia</label>
                                        <input id="diplomacia" class="input-group-text bg-black text-light"
                                               name="diplomacia" type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="enganacao">Enganação</label>
                                        <input id="enganacao" class="input-group-text bg-black text-light" name="enganacao"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="fortitude">Fortitude</label>
                                        <input id="fortitude" class="input-group-text bg-black text-light" name="fortitude"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="furtividade">Furtividade</label>
                                        <input id="furtividade" class="input-group-text bg-black text-light"
                                               name="furtividade" type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="intimidacao">Intimidação</label>
                                        <input id="intimidacao" class="input-group-text bg-black text-light"
                                               name="intimidacao" type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="intuicao">Intuição</label>
                                        <input id="intuicao" class="input-group-text bg-black text-light" name="intuicao"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="investigacao">Investigação</label>
                                        <input id="investigacao" class="input-group-text bg-black text-light"
                                               name="investigacao" type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="luta">Luta</label>
                                        <input id="luta" class="input-group-text bg-black text-light" name="luta"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="medicina">Medicina</label>
                                        <input id="medicina" class="input-group-text bg-black text-light" name="medicina"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="ocultismo">Ocultismo</label>
                                        <input id="ocultismo" class="input-group-text bg-black text-light" name="ocultismo"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="percepcao">Percepção</label>
                                        <input id="percepcao" class="input-group-text bg-black text-light" name="percepcao"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="pilotagem">Pilotagem</label>
                                        <input id="pilotagem" class="input-group-text bg-black text-light" name="pilotagem"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="pontaria">Pontaria</label>
                                        <input id="pontaria" class="input-group-text bg-black text-light" name="pontaria"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="prestidigitacao">Prestidigitação</label>
                                        <input id="prestidigitacao" class="input-group-text bg-black text-light"
                                               name="prestidigitacao" type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="profissao">Profissão</label>
                                        <input id="profissao" class="input-group-text bg-black text-light" name="profissao"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="reflexos">Reflexos</label>
                                        <input id="reflexos" class="input-group-text bg-black text-light" name="reflexos"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="religiao">Religião</label>
                                        <input id="religiao" class="input-group-text bg-black text-light" name="religiao"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="tatica">Tática</label>
                                        <input id="tatica" class="input-group-text bg-black text-light" name="tatica"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light"
                                               for="tecnologia">Tecnologia</label>
                                        <input id="tecnologia" class="input-group-text bg-black text-light"
                                               name="tecnologia" type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <label class="input-group-text bg-black text-light" for="vontade">Vontade</label>
                                        <input id="vontade" class="input-group-text bg-black text-light" name="vontade"
                                               type="number" min="0" max="50" value="0"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-out" role="tabpanel" aria-labelledby="pills-out-tab">
                            <div>
                                <h2 class="my-2">Defesas</h2>
                                <div class="m-2">
                                    <label class="fs-4" for="passiva">Pássiva</label>
                                    <input id="passiva" class="form-control bg-black text-light" name="passiva"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="bloqueio">Bloqueio</label>
                                    <input id="bloqueio" class="form-control bg-black text-light" name="bloqueio"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="esquiva">Esquiva</label>
                                    <input id="esquiva" class="form-control bg-black text-light" name="esquiva"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                                <h2 class="my-2">Resistências</h2>
                                <div class="m-2">
                                    <label class="fs-4" for="morte">Morte</label>
                                    <input id="morte" class="form-control bg-black text-light" name="morte" type="number"
                                           min="0" max="50" value="0"/>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="sangue">Sangue</label>
                                    <input id="sangue" class="form-control bg-black text-light" name="sangue" type="number"
                                           min="0" max="50" value="0"/>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="energia">Energia</label>
                                    <input id="energia" class="form-control bg-black text-light" name="energia"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="conhecimento">Conhecimento</label>
                                    <input id="conhecimento" class="form-control bg-black text-light" name="conhecimento"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="fisica">Fisica</label>
                                    <input id="fisica" class="form-control bg-black text-light" name="fisica" type="number"
                                           min="0" max="50" value="0"/>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="balistica">Balistica</label>
                                    <input id="balistica" class="form-control bg-black text-light" name="balistica"
                                           type="number" min="0" max="50" value="0"/>
                                </div>
                                <div class="m-2">
                                    <label class="fs-4" for="mental">Mental</label>
                                    <input id="mental" class="form-control bg-black text-light" name="mental" type="number"
                                           min="0" max="50" value="0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <input type="hidden" name="status" value="addnpc"/>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="adicionar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content bg-black border-light" id="formadd" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="modal-header border-0 text-center">
                        <h4 class="modal-title" id="exampleModalLabel">Adicionar jogador</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="my-1" id="msgadd"></div>
                    <div class="container-fluid">
                        <p class="text-info">Se o jogador não tiver conta cadastrada, coloque-o email do mesmo, irá gerar um
                            link(que tambem será enviado via email), envie para o jogador.</p>
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
    <div class="position-fixed top-50 start-50 translate-middle p-3">
        <div id="Toastdados" class="toast align-items-center text-white bg-primary border-0" data-bs-autohide="false"
             role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <button type="button" class="btn-close btn-close-white me-2 m-auto float-end" data-bs-dismiss="toast"
                        aria-label="Fechar"></button>
                <span>Resultado:<span class="font6 fs-1" id="resultado"></span></span>
                <div id="valordados1">
                    <span id="dado1"></span>:<span id="valores1"></span>
                </div>
                <div id="valordados2">
                    <span id="dado2"></span>:<span id="valores2"></span>
                </div>
                <div id="valordados3">
                    <span id="dado3"></span>:<span id="valores3"></span>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./includes/scripts.php"; ?>
    </body>
</html>