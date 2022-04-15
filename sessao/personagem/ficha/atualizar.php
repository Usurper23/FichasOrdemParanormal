<?php
require_once __dir__ . "./../../../config/mysql.php";
$con = con();
$success = true;

if ($edit) {
    if (isset($_POST['status'])) {
        switch ($_POST['status']) {
            case 'addritual':
                $foto = intval($_POST["foto"]);
                if ($foto == 2) {
                    $foto = test_input($_POST["simbolourl"]);
                }
                $ritual = test_input($_POST["ritual"]);
                $cir = test_input($_POST["circulo"]);
                $conj = test_input($_POST["conjuracao"]);
                $ele = test_input($_POST["elemento"]);
                $efe = test_input($_POST["efeito"]);
                $dur = test_input($_POST["duracao"]);
                $alc = test_input($_POST["alcance"]);
                $alv = test_input($_POST["alvo"]);
                $res = test_input($_POST["resistencia"]);
                $rr = $con->prepare("INSERT INTO `rituais`(`id`,`foto`,`id_ficha`,`nome`,`circulo`,`conjuracao`,`efeito`,`elemento`,`duracao`,`alcance`,`resistencia`, `alvo`) VALUES ('', ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? )");
                $rr->bind_param("sisssssssss", $foto, $id, $ritual, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alv);
                $rr->execute();
                break;
            case 'editritual':
                $c = 0;
                while ($c != count($_POST["ritualid"])) {
                    $foto = intval($_POST["foto"][$c]);
                    $rid = intval($_POST["ritualid"][$c]);
                    if ($foto == 2) {
                        $foto = test_input($_POST["simbolourl"][$rid]);
                    }
                    $ritual = test_input($_POST["ritual"][$c]);
                    $cir = test_input($_POST["circulo"][$c]);
                    $conj = test_input($_POST["conjuracao"][$c]);
                    $ele = test_input($_POST["elemento"][$c]);
                    $efe = test_input($_POST["efeito"][$c]);
                    $dur = test_input($_POST["duracao"][$c]);
                    $alc = test_input($_POST["alcance"][$c]);
                    $alv = test_input($_POST["alvo"][$c]);
                    $res = test_input($_POST["resistencia"][$c]);
                    $rr = $con->prepare("UPDATE `rituais` SET  `nome` = ?, `foto` = ? , `circulo` = ? , `conjuracao` = ? , `efeito` = ? , `elemento` = ? , `duracao` = ? , `alcance` = ? , `resistencia` = ?, `alvo` = ? WHERE `id_ficha` = ? AND `id` = ? ;");
                    $rr->bind_param("ssssssssssii", $ritual, $foto, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alv, $id, $rid);
                    $rr->execute();
                    $c++;
                }
                break;
            case 'addarma':
                $desc = test_input($_POST["desc"]);
                $peso = test_input($_POST["peso"]);
                $pres = test_input($_POST["prestigio"]);
                $n = test_input($_POST["nome"]);
                $t = test_input($_POST["tipo"]);
                $at = minmax(intval($_POST["ataque"]), -20, 20);
                $al = test_input($_POST["alcance"]);
                $d = test_input($_POST["dano"]);
                $c = test_input($_POST["critico"]);
                $r = test_input($_POST["recarga"]);
                $e = test_input($_POST["especial"]);
                $rr = $con->prepare("INSERT INTO `armas`(`id_ficha`,`arma`,`tipo`,`ataque`,`alcance`,`dano`,`critico`,`recarga`,`especial`,`id`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?,'');");
                $rr->bind_param("ississsss", $id, $n, $t, $at, $al, $d, $c, $r, $e);
                $rr->execute();
                if ($_POST["opc"] == 'addinvtoo') {
                    $p = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`prestigio`,`espaco`,`quantidade`,`id`) VALUES ( ?, ?, ?, ?, ?, 1, '');");
                    $p->bind_param("issii", $id, $n, $desc, $pres, $peso);
                    $p->execute();
                }
                if ($con->affected_rows) {
                    $msg = "Sucesso ao adicionar itens";
                }
                break;
            case 'additem':
                $nome = test_input($_POST["nome"]);
                $desc = test_input($_POST["descricao"]);
                $peso = test_input($_POST["peso"]);
                $pres = test_input($_POST["prestigio"]);
                $rr = $con->prepare("INSERT INTO `inventario`(`id`,`id_ficha`,`nome`,`descricao`,`espaco`,`prestigio`) VALUES ( '' , ? , ? , ? , ? , ?)");
                $rr->bind_param("issii", $id, $nome, $desc, $peso, $pres);
                $rr->execute();
                break;
            case 'addhab':
                $habname = test_input($_POST["hab"]);
                $habdesc = test_input($_POST["desc"]);
                $con->query("INSERT INTO `habilidades` (`id`, `id_ficha`, `nome`, `descricao`) VALUES (NULL, '$id', '$habname', '$habdesc');");
                break;
            case 'edithab':
                $c = 0;
                while ($c != count($_POST['hid'])) {
                    $habname = test_input($_POST["nome"][$c]);
                    $hid = test_input($_POST["hid"][$c]);
                    $habdesc = test_input($_POST["desc"][$c]);
                    $con->query("UPDATE `habilidades` SET `nome` = '$habname', `descricao` = '$habdesc' WHERE `id_ficha` = '$id' AND `id` = '$hid';");
                    $c++;
                }
                break;
            case 'addpro':
                $pronome = test_input($_POST["pro"]);
                //$prodesc = test_input($_POST["desc"]);
                $con->query("INSERT INTO `proeficiencias` (`id`, `id_ficha`, `nome`) VALUES (NULL, '" . $id . "', '" . $pronome . "');");
                $success = $con->affected_rows;
                break;
            case 'delarma':
                $aid = intval($_POST["aid"]);
                $a = $con->query("DELETE FROM `armas` WHERE `armas`.`id` = '$aid' AND `id_ficha` = '$id';");
                break;
            case 'delitem':
                $iid = intval($_POST["iid"]);
                $con->query("DELETE FROM `inventario` WHERE `inventario`.`id` = '$iid' AND `id_ficha` = '$id';");
                break;
            case 'delethab':
                $hid = intval($_POST["hid"]);
                $con->query("DELETE FROM `habilidades` WHERE `habilidades`.`id` = '$hid' AND `id_ficha` = '$id';");
                break;
            case 'deletpro':
                $pid = intval($_POST["pid"]);
                $con->query("DELETE FROM `proeficiencias` WHERE `proeficiencias`.`id` = '$pid' AND `id_ficha` = '$id';");
                break;
            case 'deleteritual':
                $rid = intval($_POST["rid"]);
                $con->query("DELETE FROM `rituais` WHERE `rituais`.`id` = '$rid' AND `id_ficha` = '$id';");
                echo $con->affected_rows;
                exit;
                break;
            case 'editarma':
                $aid = intval($_POST["aid"]);
                $n = test_input($_POST["nome"]);
                $t = test_input($_POST["tipo"]);
                $at = test_input($_POST["ataque"]);
                $al = test_input($_POST["alcance"]);
                $d = test_input($_POST["dano"]);
                $c = test_input($_POST["critico"]);
                $r = test_input($_POST["recarga"]);
                $e = test_input($_POST["especial"]);
                $rr = $con->prepare("UPDATE `armas` SET `arma` = ?, `tipo` = ?, `ataque` = ?, `alcance` = ?, `dano` = ?, `critico` = ?, `recarga` = ?, `especial` = ? WHERE `armas`.`id` = ? AND `id_ficha` = '$id';;");
                $rr->bind_param("ssisssssi", $n, $t, $at, $al, $d, $c, $r, $e, $aid);
                $rr->execute();
                $success = $rr;
                break;
            case 'edititem':
                $iid = intval($_POST["iid"]);
                $nome = test_input($_POST["nome"]);
                $desc = test_input($_POST["descricao"]);
                $peso = test_input($_POST["peso"]);
                $pres = test_input($_POST["prestigio"]);
                $rr = $con->prepare("UPDATE `inventario` SET `nome` = ? , `descricao` = ?, `espaco` = ?, `prestigio` = ? WHERE `inventario`.`id` = ? AND `id_ficha` = '$id';;");
                $rr->bind_param("ssiii", $nome, $desc, $peso, $pres, $iid);
                $rr->execute();
                $success = $rr;
                break;
            case 'editdet':
                $nome = test_input($_POST["nome"]);
                $fotos = intval($_POST["foto"]);
                $fotourl = test_input($_POST["fotourl"]);
                if ($fotos > 0 and $fotos < 10) {
                    if ($fotos == 9) {
                        if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp)$/', $fotourl)) {
                            $foto = $fotourl;
                        }
                    } else {
                        $foto = $fotos;
                    }
                } else {
                    $sucesso = false;
                    $msg = "Foto escolhida não existe.";
                }
                $nex = minmax($_POST["nex"], 0, 100);
                $origem = minmax($_POST["origem"], 0, 7);
                $trilha = 0;//minmax($_POST["trilha"],0,9);
                $classe = minmax($_POST["classe"], 0, 3);
                $patente = minmax($_POST["patente"], 0, 5);
                $idade = minmax($_POST["idade"], 0, 65);
                $local = test_input($_POST["local"]);
                $historia = test_input($_POST["historia"]);
                $rr = $con->prepare("UPDATE `fichas_personagem` SET `nome` = ? , `foto` = ? , `nex` = ? , `classe` = ? , `trilha` = ? , `origem` = ? , `patente` = ? , `idade` = ? , `local` = ? , `historia` = ? WHERE `id` = '$id';");
                $rr->bind_param("ssiiiiiiss", $nome, $foto, $nex, $classe, $trilha, $origem, $patente, $idade, $local, $historia);
                $rr->execute();
                break;
            case 'editpri':
                $a = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = " . $id);
                $ra = mysqli_fetch_array($a);

                //Saúde
                $pv = minmax(intval($_POST["pv"]), 1, 999);
                if ($pv == 1) $pv = calcularvida($ra["nex"], $ra["classe"], $ra["vigor"]);

                $pe = minmax(intval($_POST["pe"]), 1);
                if ($pe == 1) $pe = calcularpe($ra["nex"], $ra["classe"], $ra["presenca"]);

                $san = minmax(intval($_POST["san"]), 1, 999);

                //Defesas
                $pa = minmax(intval($_POST["passiva"]));

                $bl = minmax(intval($_POST["bloqueio"]));
                if ($bl == 1) {
                    $bl = calcularblo($pa, $ra["luta"]);
                }

                $es = minmax(intval($_POST["esquiva"]));
                if ($es == 1) {
                    $es = calcularesq($pa, $ra["agilidade"]);
                }

                //Resistencias
                $fis = minmax(intval($_POST["fisica"]), 0);
                $bal = minmax(intval($_POST["balistica"]), 0);
                $morte = minmax(intval($_POST["morte"]), 0);
                $sangue = minmax(intval($_POST["sangue"]), 0);
                $conh = minmax(intval($_POST["conhecimento"]), 0);
                $energia = minmax(intval($_POST["energia"]), 0);

                $b = $con->query("UPDATE `fichas_personagem` SET `passiva`= '$pa', `bloqueio` = '$bl',`esquiva` = '$es',`fisica`= '$fis', `balistica` = '$bal',`morte`= '$morte', `sangue` = '$sangue',`conhecimento`= '$conh', `energia` = '$energia',`pv`= " . $pv . ", `pva` = " . $pv . ", `pe` = " . $pe . ", `pea` = " . $pe . ",`san` = " . $san . ", `sana` = " . $san . " WHERE `id` = '$id'");
                $success = $con->affected_rows;

                break;
            case 'editattr':
                if ($edit) {
                    $forca = minmax($_POST["forca"], -5, 5);
                    $agilidade = minmax($_POST["agilidade"], -5, 5);
                    $intelecto = minmax($_POST["intelecto"], -5, 5);
                    $presenca = minmax($_POST["presenca"], -5, 5);
                    $vigor = minmax($_POST["vigor"], -5, 5);
                    $con->query("UPDATE `fichas_personagem` SET `forca` = '$forca', `agilidade` = '$agilidade',`inteligencia` = '$intelecto',`presenca` = '$presenca',`vigor` = '$vigor' WHERE `id` = '$id';");
                }
                break;
            case 'editper':
                $atl = minmax($_POST["atletismo"], 0, 99);
                $atu = minmax($_POST["atualidades"], 0, 99);
                $cie = minmax($_POST["ciencia"], 0, 99);
                $dip = minmax($_POST["diplomacia"], 0, 99);
                $eng = minmax($_POST["enganacao"], 0, 99);
                $fort = minmax($_POST["fortitude"], 0, 99);
                $fur = minmax($_POST["furtividade"], 0, 99);
                $inti = minmax($_POST["intimidacao"], 0, 99);
                $intu = minmax($_POST["intuicao"], 0, 99);
                $inv = minmax($_POST["investigacao"], 0, 99);
                $lut = minmax($_POST["luta"], 0, 99);
                $med = minmax($_POST["medicina"], 0, 99);
                $ocu = minmax($_POST["ocultismo"], 0, 99);
                $perc = minmax($_POST["percepcao"], 0, 99);
                $pilo = minmax($_POST["pilotagem"], 0, 99);
                $pont = minmax($_POST["pontaria"], 0, 99);
                $pres = minmax($_POST["prestidigitacao"], 0, 99);
                $prof = minmax($_POST["profissao"], 0, 99);
                $ref = minmax($_POST["reflexo"], 0, 99);
                $rel = minmax($_POST["religiao"], 0, 99);
                $tat = minmax($_POST["tatica"], 0, 99);
                $tec = minmax($_POST["tecnologia"], 0, 99);
                $von = minmax($_POST["vontade"], 0, 99);
                $con->query("UPDATE `fichas_personagem` SET `atletismo`='$atl', `atualidades` = '$atu', `ciencia`='$cie', `diplomacia`='$dip', `enganacao`='$eng', `fortitude`='$fort', `furtividade`='$fur', `intimidacao`='$inti', `intuicao`='$intu', `investigacao`='$inv', `luta`='$lut', `medicina`='$med', `ocultismo`='$ocu', `percepcao`='$perc', `pilotagem`='$pilo', `pontaria`='$pont', `prestidigitacao`='$pres', `profissao`='$prof', `reflexos`='$ref', `religiao`='$rel', `tatica`='$tat', `tecnologia`='$tec', `vontade`='$von' WHERE `id` = '$id';");
                $success = $con->affected_rows;
                $msg = $con->affected_rows ? "Sucesso" : "Falha";
                break;
            case 'enlouquecendo':
                $s = $con->query("UPDATE `fichas_personagem` SET `enlouquecendo` = " . intval($_POST["value"]) . " WHERE `id` = " . $id . ";");
                if ($s) {
                    $success = true;
                    $msg = "Enlouquecendo alterado!";
                } else {
                    $success = false;
                    $msg = "Enlouquecendo NÃO alterado!";
                }
                break;
            case 'morrendo':
                $s = $con->query("UPDATE `fichas_personagem` SET `morrendo` = " . intval($_POST["value"]) . " WHERE `id` = " . $id . ";");
                if ($s) {
                    $success = true;
                    $msg = "Morrendo alterado!";
                } else {
                    $success = false;
                    $msg = "Morrendo NÃO alterado!";
                }
                break;
            case 'upv':
                $sq = $con->query("Select * From `fichas_personagem` where `id` = '$id';");
                $rs["saude"] = mysqli_fetch_array($sq);
                $pva = $rs["saude"]["pva"] + intval($_POST["value"]);
                $ppva = $rs["saude"]["pv"] + 20;
                if ($pva >= $ppva) {
                    $pva = intval($rs["saude"]["pv"] + 20);
                } elseif ($pva <= 0) {
                    $pva = 0;
                }
                $s = $con->query("UPDATE `fichas_personagem` SET `pva` = " . $pva . " WHERE `id` = " . $id . ";");
                if ($con->affected_rows) {
                    $success = true;
                    $msg = "Vida alterada!";
                } else {
                    $success = false;
                    $msg = "Vida NÃO alterada!";
                }
                break;
            case 'usan':
                $sq = $con->query("Select * From `fichas_personagem` where `id` = '$id';");
                $rs["saude"] = mysqli_fetch_array($sq);
                $sana = $rs["saude"]["sana"] + intval($_POST["value"]);
                $psana = 120 * ($rs["saude"]["san"] / 100);
                if ($sana >= $psana) {
                    $sana = intval(($rs["saude"]["san"] / 100) * 120);
                } elseif ($sana <= 0) {
                    $sana = 0;
                }
                $s = $con->query("UPDATE `fichas_personagem` SET `sana` = " . $sana . " WHERE `id` = " . $id . ";");
                if ($s) {
                    $success = true;
                    $msg = "Sanidade alterada!";
                } else {
                    $success = false;
                    $msg = "Sanidade NÃO alterada!";
                }
                break;
            case 'pe':
                $sq = $con->query("Select * From `fichas_personagem` where `id` = '$id';");
                $rs["saude"] = mysqli_fetch_array($sq);
                $pea = $rs["saude"]["pe"] - intval($_POST["value"]);

                $s = $con->query("Update `fichas_personagem` SET `pea` = " . $pea . " WHERE `id` = " . $id . ";");
                if ($s) {
                    $success = true;
                    $msg = "PE(Atual) alterado!";
                } else {
                    $success = false;
                    $msg = "PE(Atual) NÃO alterado!";
                }
                break;
        }
    }
}

