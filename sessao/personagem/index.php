<?php
header("X-Robots-Tag: none");
// Importante para o funcionamento Geral!
require_once("./../../config/mysql.php");
$con = con();


//Importante para evitar futuros ERROS!
$edit = false;
$missao = 0;
$userid = $_SESSION["UserID"];

//Importante para evitar XSS INJECTIOn e um bucado de coisa
$id = intval($_GET["id"] ?: 0);

// Se o ‘id’ for nulo/não existir, levar para pagina inicial...
if ($id == 0) {
    header("Location: ./..");
}


$qs = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '$id'");
if ($qs->num_rows) {
    $rqs = mysqli_fetch_array($qs);
} else {
    header("Location: ./..");
    exit;
}


//Pega dados como ‘id’ do usuario e missao
$lig = $con->query("SELECT * FROM `ligacoes` WHERE `id_ficha` = " . $id);
if ($lig->num_rows == 1) {
    // põe em uma variavel
    $ligacoes = mysqli_fetch_array($lig);

    //Pega dados da missão
    $qm = $con->query("SELECT * FROM `missoes` WHERE `id` = '" . $ligacoes["id_missao"] . "'");
    if ($qm->num_rows == 1) {
        //Põe dados da missao em uma variavel
        $dados_missao = mysqli_fetch_array($qm);
    }
}

//Verifica se tem permissão para usar ficha
if ($_SESSION["UserAdmin"] || (isset($dados_missao) and $dados_missao["mestre"] == $userid)) {
    $edit = true;
} else {
    if ((isset($dados_missao) && $dados_missao["status"]) || VerificarID($id)) {
        $edit = true;
    } else {
        if (isset($rqs) and !$rqs["public"]) {
            header("Location: ./..");
        }
    }
}


// Dados de quando atualiza a ficha ou quando altera.
require_once "./ficha/atualizar.php";


//Funções para fazer coisas simples.
require_once "./ficha/functions_ficha.php";


//Pega todos os dados da ficha: Principal

if (isset($rqs)) {
    $nu = $con->query("SELECT * FROM `usuarios` WHERE `usuarios`.`id` = " . ($rqs["usuario"] ?: 0));
    $usuario = (mysqli_fetch_assoc($nu))["nome"];
    $nome = $rqs["nome"];
    $nex = $rqs["nex"];
    $idade = $rqs["idade"] ?: "Desconhecida.";
    $local = $rqs["local"];
    $historia = $rqs["historia"];
    $urlphoto = $rqs["foto"];
    if (intval($urlphoto) > 0) {
        switch (intval($rqs["foto"])) {
            case 1:
                $urlphoto = 'https://fichasop.cf/assets/img/Man.png';
                break;
            case 2:
                $urlphoto = 'https://fichasop.cf/assets/img/Woman.png';
                break;
            case 3:
                $urlphoto = 'https://fichasop.cf/assets/img/Mauro%20-%20up%20.png';
                break;
            case 4:
                $urlphoto = 'https://fichasop.cf/assets/img/Maya%20-%20Upscale.png';
                break;
            case 5:
                $urlphoto = 'https://fichasop.cf/assets/img/Bruna%20-%20Upscale.png';
                break;
            case 6:
                $urlphoto = 'https://fichasop.cf/assets/img/Leandro%20-%20Upscale.png';
                break;
            case 7:
                $urlphoto = 'https://fichasop.cf/assets/img/Jaime%20-%20Upscale.png';
                break;
            case 8:
                $urlphoto = 'https://fichasop.cf/assets/img/Aniela%20-%20Upscale.png';
                break;
        }
    }
    switch ($rqs["origem"]) {
        default:
            $origem = "Não indentificada";
            break;
        case 1:
            $origem = "Acadêmica.";
            break;
        case 2:
            $origem = "Atleta.";
            break;
        case 3:
            $origem = "Exorcista.";
            break;
        case 4:
            $origem = "Mercenária.";
            break;
        case 5:
            $origem = "Profissional da Saúde.";
            break;
        case 6:
            $origem = "Tecnologia da Informação.";
            break;
        case 7:
            $origem = "Artista";
            break;
    }
    switch ($rqs["classe"]) {
        default:
            $classe = "Não indentificado.";
            $trilha = "Não indentificada.";
            break;
        case 1:
            $classe = "Combatente";
            switch ($rqs["trilha"]) {
                default:
                    $trilha = "Não indentificada.";
                    break;
                case 1:
                    $trilha = "Comandante";
                    break;
                case 2:
                    $trilha = "Duelista";
                    break;
                case 3:
                    $trilha = "Robusto";
                    break;
            }
            break;
        case 2:
            $classe = "Especialista";
            switch ($rqs["trilha"]) {
                default:
                    $trilha = "Não indentificada.";
                    break;
                case 1:
                    $trilha = "Artista Marcial";
                    break;
                case 2:
                    $trilha = "Atirador de Elite";
                    break;
                case 3:
                    $trilha = "Infiltrador";
                    break;
                case 4:
                    $trilha = "Socorrista";
                    break;
            }
            break;
        case 3:
            $classe = "Ocultista";
            switch ($rqs["trilha"]) {
                default:
                    $trilha = "Não indentificada.";
                    break;

                case 1:
                    $trilha = "Combate";
                    break;
                case 2:
                    $trilha = "Flagelador";
                    break;
                case 3:
                    $trilha = "Intuitivo";
                    break;
                case 4:
                    $trilha = "Sagaz";
                    break;
            }
            break;
    }
    switch ($rqs["patente"]) {
        default:
            $patente = "Não indentificada.";
            break;
        case 1:
            $patente = "Recruta";
            break;
        case 2:
            $patente = "Agente";
            break;
        case 3:
            $patente = "Operador";
            break;
        case 4:
            $patente = "Veterano";
            break;
        case 5:
            $patente = "Elite";
            break;
    }

    $forca = $rqs["forca"];
    $agilidade = $rqs["agilidade"];
    $intelecto = $rqs["inteligencia"];
    $presenca = $rqs["presenca"];
    $vigor = $rqs["vigor"];


    //valores para mostrar no atributos
    $for = ValorParaMostrarNoAtributo($forca);
    $agi = ValorParaMostrarNoAtributo($agilidade);
    $int = ValorParaMostrarNoAtributo($intelecto);
    $pre = ValorParaMostrarNoAtributo($presenca);
    $vig = ValorParaMostrarNoAtributo($vigor);

    //Valores para rolar dados

    $dado["for"] = ValorParaRolarDado($forca);
    $dado["int"] = ValorParaRolarDado($intelecto);
    $dado["agi"] = ValorParaRolarDado($agilidade);
    $dado["pre"] = ValorParaRolarDado($presenca);
    $dado["vig"] = ValorParaRolarDado($vigor);

    $pv = $rqs["pv"];
    $pva = $rqs["pva"];
    $san = $rqs["san"];
    $sana = $rqs["sana"];
    $pe = $rqs["pe"];
    $pea = $rqs["pea"];
    $ppv = TirarPorcento($pva, $pv);
    $psan = TirarPorcento($sana, $san);
    $ppe = TirarPorcento($pea, $pe);
    $morrendo = $rqs["morrendo"];
    $enlouquecendo = $rqs["enlouquecendo"];

    $passiva = $rqs["passiva"];
    $bloqueio = $rqs["bloqueio"];
    $esquiva = $rqs["esquiva"];

    $fisica = $rqs["fisica"];
    $balistica = $rqs["balistica"];
    $insanidade = $rqs["mental"];
    $sangue = $rqs["sangue"];
    $conhecimento = $rqs["conhecimento"];
    $energia = $rqs["energia"];
    $morte = $rqs["morte"];

    $atletismo = $rqs["atletismo"];
    $atualidades = $rqs["atualidades"];
    $ciencia = $rqs["ciencia"];
    $diplomacia = $rqs["diplomacia"];
    $enganacao = $rqs["enganacao"];
    $fortitude = $rqs["fortitude"];
    $furtividade = $rqs["furtividade"];
    $intimidacao = $rqs["intimidacao"];
    $intuicao = $rqs["intuicao"];
    $investigacao = $rqs["investigacao"];
    $luta = $rqs["luta"];
    $medicina = $rqs["medicina"];
    $ocultismo = $rqs["ocultismo"];
    $percepcao = $rqs["percepcao"];
    $pilotagem = $rqs["pilotagem"];
    $pontaria = $rqs["pontaria"];
    $prestidigitacao = $rqs["prestidigitacao"];
    $profissao = $rqs["profissao"];
    $reflexos = $rqs["reflexos"];
    $religiao = $rqs["religiao"];
    $tatica = $rqs["tatica"];
    $tecnologia = $rqs["tecnologia"];
    $vontade = $rqs["vontade"];

} else {
    header("Location: ./..");
}
//pega todos os dados da ficha: Rituais
$s[6] = $con->query("Select * From `rituais` where `id_ficha` = '$id';");

//pega todos os dados da ficha: Armas
$s[1] = $con->query("Select * From `armas` where `id_ficha` = '$id';");
//Pega todos os dados da ficha: Habilidades
$s[2] = $con->query("SELECT * FROM `habilidades` WHERE `id_ficha` = '" . $id . "';");
//Pega todos os dados da ficha: Proeficiencias
$s[3] = $con->query("SELECT * FROM `proeficiencias` WHERE `id_ficha` = '" . $id . "';");
//pega todos os dados da ficha: Inventario
$s[4] = $con->query("Select * From `inventario` where `id_ficha` = '$id';");
$s[5] = $con->query("Select SUM(espaco) AS pesototal From `inventario` where `id_ficha` = '$id';");
$ddinv = mysqli_fetch_array($s[5]);
$espacosusados = $ddinv["pesototal"] ?: 0;

//Pega todos os dados da ficha:...
if ($edit) {
// Dados de quando atualiza a ficha ou quando altera.
    require_once "./ficha/atualizar.php";
}
?>
<!DOCTYPE html>
<html lang="br">
<head>
    <?php
    require_once './../../includes/head.html';
    ?>
    <meta charset="UTF-8">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title><?php echo $nome?: "Desconhecido"; ?> - Ficha OP</title>
</head>
<body class="bg-black text-light font7">

<?php
if (!isset($_GET["popout"])) {
    include_once "./../../includes/top.php";
}
?>
<!---------HTML----------------->
<main>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-------------Detalhes Pessoais--------------->
            <?php
            if (!isset($_GET["popout"])) {
                include_once "./ficha/card_detalhes.php";
            } else {
                if ($_GET["popout"] == 'dados')
                    include_once "./ficha/card_detalhes.php";
            }
            ?>
            <!---------------------------Painel Principal----------------------------------->
            <?php

            if (!isset($_GET["popout"])) {
                include_once "./ficha/card_principal.php";
            } else {
                if ($_GET["popout"] == 'principal')
                    include_once "./ficha/card_principal.php";
            }
            ?>
        </div>
        <div class="row justify-content-center">
            <!---------------Atributos--------------------->
            <?php
            if (!isset($_GET["popout"])) {
                include_once "./ficha/card_atributos.php";
            } else {
                if ($_GET["popout"] == 'atributos')
                    include_once "./ficha/card_atributos.php";
            }
            ?>
            <!-------------------Peripeças------------------------>
            <?php
            if (!isset($_GET["popout"])) {
                include_once "./ficha/card_pericias.php";
            } else {
                if ($_GET["popout"] == 'pericias')
                    include_once "./ficha/card_pericias.php";
            }
            ?>
        </div
                <!---------------Habilidades--------------------->
        <div class="row justify-content-center">
            <?php
            if (!isset($_GET["popout"])) {
                include_once "./ficha/card_habilidades.php";
            } else {
                if ($_GET["popout"] == 'habilidades')
                    include_once "./ficha/card_habilidades.php";
            }
            ?>
            <!-------------------Proeficiencias------------------------>
            <?php
            if (!isset($_GET["popout"])) {
                include_once "./ficha/card_proeficiencias.php";
            } else {
                if ($_GET["popout"] == 'proeficiencias')
                    include_once "./ficha/card_proeficiencias.php";
            }
            ?>
        </div>

        <!-----------------------------------------------------------Inventario------------------------------------>

        <div class="row justify-content-center">
        <?php
        if (!isset($_GET["popout"])) {
            include_once "./ficha/card_inventario.php";
        } else {
            if ($_GET["popout"] == 'inventario')
                include_once "./ficha/card_inventario.php";
        }
        ?>
        </div>

        <div class="row justify-content-center">
        <?php
        if (!isset($_GET["rituais"])) {
            include_once "./ficha/card_rituais.php";
        } else {
            if ($_GET["popout"] == 'inventario')
                include_once "./ficha/card_rituais.php";
        }
        ?>
        </div>
        <div class="row justify-content-center">
        <?php
        if (!isset($_GET["rolardados"])) {
            include_once "./ficha/card_rolardados.php";
        } else {
            if ($_GET["popout"] == 'rolardados')
                include_once "./ficha/card_rolardados.php";
        }
        ?>
        </div>
    </div>
</main>
<div id="modalsaki">
    <!---------Modals e Toasts--------------->
    <?php if ($edit) {
        require_once "./ficha/modal_detalhes.php";
        require_once "./ficha/modal_principal.php";
        require_once "./ficha/modal_habilidades.php";
        require_once "./ficha/modal_atributos.php";
        require_once "./ficha/modal_pericias.php";
        require_once "./ficha/modal_inventario.php";
        require_once "./ficha/modal_dados.php";
        require_once "./ficha/modal_proeficiencias.php";
        require_once "./ficha/modal_rituais.php";
    } ?>
</div>

<?php require_once "./ficha/scripts.php"; ?>
</body>