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
$id = intval($_GET["id"] ? : 0);

// Se o ‘id’ for nulo/não existir, levar para pagina inicial...
if ($id == 0 ){
    echo "<script>window.location.href='..'</script>";
}

//Pega dados como ‘id’ do usuario e missao
$lig = $con->query("SELECT * FROM `ligacoes` WHERE `id_ficha` = ".$id);
if ($lig->num_rows == 1){
    // põe em uma variavel
    $ligacoes = mysqli_fetch_array($lig);

    //Pega dados da missão
    $qm = $con->query("SELECT * FROM `missoes` WHERE `id` = '".$ligacoes["id_missao"]."'");
    if ($qm->num_rows == 1){
        //Põe dados da missao em uma variavel
        $missao = mysqli_fetch_array($qm);
    }
}

//Verifica se tem permissão para usar ficha
if ($_SESSION["UserAdmin"]){
    $edit = true;
} else {
    if ($missao["status"])
        $edit = VerificarID($id);
}
if ($edit) {
// Dados de quando atualiza a ficha ou quando altera.
    require_once "./ficha/atualizar.php";
}
//Funções para fazer coisas simples.
require_once "./ficha/functions_ficha.php";


//Pega todos os dados da ficha: Principal
$s[1] = $con->query("Select * From `principal` where `id` = '$id';");
$rs["principal"] = mysqli_fetch_array($s[1]);
if ($rs["principal"] != NULL){
    //Pode ser substituido!
    $nu = $con->query("SELECT * FROM `usuarios` WHERE `usuarios`.`id` = ".($rs["principal"]["usuario"]?:0));
    $usuario = (mysqli_fetch_assoc($nu))["nome"];
    $nome = $rs["principal"]["nome"];
    $nex = $rs["principal"]["nex"];
    $idade = $rs["principal"]["idade"];
    $local = $rs["principal"]["local"];
    $historia = $rs["principal"]["historia"];
    switch (intval($rs["principal"]["foto"])){
        default:
            $urlphoto = $rs["pricipal"]["foto"];
            break;
        case 1:
            $urlphoto = 'https://fichasop.cf/sessao/personagem/Man.png';
            break;
        case 2:
            $urlphoto = 'https://fichasop.cf/sessao/personagem/woman.png';
            break;
        case 3:
            $urlphoto = 'https://fichasop.cf/sessao/personagem/Mauro%20-%20up%20.png';
            break;
        case 4:
            $urlphoto = 'https://fichasop.cf/sessao/personagem/Maya%20-%20Upscale.png';
            break;
        case 5:
            $urlphoto = 'https://fichasop.cf/sessao/personagem/Bruna%20-%20Upscale.png';
            break;
        case 6:
            $urlphoto = 'https://fichasop.cf/sessao/personagem/Leandro%20-%20Upscale.png';
            break;
        case 7:
            $urlphoto = 'https://fichasop.cf/sessao/personagem/Jaime%20-%20Upscale.png';
            break;
        case 8:
            $urlphoto = 'https://fichasop.cf/sessao/personagem/Aniela%20-%20Upscale.png';
            break;
    }
    switch($rs["principal"]["origem"]){
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
            $origem = "T.I.";
            break;
    }
    switch($rs["principal"]["classe"]){
        default:
            $classe = "Não indentificado.";
            $trilha = "Não indentificada.";
            break;
        case 1:
            $classe = "Combatente";
            switch($rs["principal"]["trilha"]){
                default:
                    $trilha = "Não indentifica.";
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
            switch($rs["principal"]["trilha"]){
                default:
                    $trilha = "Não indentifica.";
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
            switch($rs["principal"]["trilha"]){
                default:
                    $trilha = "Não indentifica.";
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
    switch ($rs["principal"]["patente"]) {
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
}

//pega todos os dados da ficha: Atributos
$s[2] = $con->query("Select * From `atributos` where `id` = '$id';");
$rs["atributos"] = mysqli_fetch_array($s[2]);
if ($rs["atributos"] != NULL){

    //Atributos Brutos
    $forca = $rs["atributos"]["forca"];
    $agilidade = $rs["atributos"]["agilidade"];
    $intelecto = $rs["atributos"]["intelecto"];
    $presenca = $rs["atributos"]["presenca"];
    $vigor = $rs["atributos"]["vigor"];


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

}

//pega todos os dados da ficha: Saude
$s[3] = $con->query("Select * From `saude` where `id` = '$id';");
$rs["saude"] = mysqli_fetch_array($s[3]);
if ($rs["saude"] != NULL){
    $pv = $rs["saude"]["pv"];
    $pva = $rs["saude"]["pva"];
    $san = $rs["saude"]["san"];
    $sana = $rs["saude"]["sana"];
    $pe = $rs["saude"]["pe"];
    $pea = $rs["saude"]["pea"];
    $ppv = TirarPorcento($pva,$pv);
    $psan = TirarPorcento($sana,$san);
    $ppe = TirarPorcento($pea,$pe);
    $morrendo = $rs["saude"]["morrendo"];
    $enlouquecendo = $rs["saude"]["enlouquecendo"];
}

//pega todos os dados da ficha: Defesas
$s[4] = $con->query("Select * From `defesas` where `id` = '$id';");
$rs["defesa"] = mysqli_fetch_array($s[4]);
if ($rs["defesa"] != NULL){
    $passiva = $rs["defesa"]["passiva"];
    $bloqueio = $rs["defesa"]["bloqueio"];
    $esquiva = $rs["defesa"]["esquiva"];
}

//pega todos os dados da ficha: Resistencias
$s[5] = $con->query("Select * From `resistencias` where `id` = '$id';");
$rs["resistencias"] = mysqli_fetch_array($s[5]);
if ($rs["resistencias"] != NULL){
    $fisica = $rs["resistencias"]["fisica"];
    $balistica = $rs["resistencias"]["balistica"];
    $insanidade = $rs["resistencias"]["sanidade"];
    $sangue = $rs["resistencias"]["sangue"];
    $conhecimento = $rs["resistencias"]["conhecimento"];
    $energia = $rs["resistencias"]["energia"];
    $morte = $rs["resistencias"]["morte"];
}

//pega todos os dados da ficha: Pericias
$s[6] = $con->query("Select * From `pericias` where `id` = '$id';");
$rs["pericias"] = mysqli_fetch_array($s[6]);
if ($rs["pericias"] != NULL){
    $atletismo = $rs["pericias"]["atletismo"];
    $atualidades = $rs["pericias"]["atualidades"];
    $ciencia = $rs["pericias"]["ciencia"];
    $diplomacia = $rs["pericias"]["diplomacia"];
    $enganacao = $rs["pericias"]["enganacao"];
    $fortitude = $rs["pericias"]["fortitude"];
    $furtividade = $rs["pericias"]["furtividade"];
    $intimidacao = $rs["pericias"]["intimidacao"];
    $intuicao = $rs["pericias"]["intuicao"];
    $investigacao = $rs["pericias"]["investigacao"];
    $luta = $rs["pericias"]["luta"];
    $medicina = $rs["pericias"]["medicina"];
    $ocultismo = $rs["pericias"]["ocultismo"];
    $percepcao = $rs["pericias"]["percepcao"];
    $pilotagem = $rs["pericias"]["pilotagem"];
    $pontaria = $rs["pericias"]["pontaria"];
    $prestidigitacao = $rs["pericias"]["prestidigitacao"];
    $profissao = $rs["pericias"]["profissao"];
    $reflexos = $rs["pericias"]["reflexo"];
    $religiao = $rs["pericias"]["religiao"];
    $tatica = $rs["pericias"]["tatica"];
    $tecnologia = $rs["pericias"]["tecnologia"];
    $vontade = $rs["pericias"]["vontade"];
}

//pega todos os dados da ficha: Armas
$s[7] = $con->query("Select * From `armas` where `id_ficha` = '$id' ORDER BY `prioridade`;");
$rs["arma"] = mysqli_fetch_array($s[7]);

//Pega todos os dados da ficha: Habilidades
$s[8] = $con->query("SELECT * FROM `habilidades` WHERE `id_ficha` = '".$id."' ORDER BY `prioridade`;");
//Pega todos os dados da ficha: Proeficiencias
$s[9] = $con->query("SELECT * FROM `proeficiencias` WHERE `id_ficha` = '".$id."' ORDER BY `prioridade`;");
//pega todos os dados da ficha: Inventario
$s[10] = $con->query("Select * From `inventario` where `id_ficha` = '$id';");
$ddinv = mysqli_fetch_array($s[10]);
$tempvar = 0;
$espacosusados = 0;
while ($s[10] > $tempvar){
    $espacosusados += intval($ddinv["espaco"]);
    $tempvar += 1;
}

//Pega todos os dados da ficha:...

?>
<html lang="br">
<head>
    <?php
    require_once './../../includes/head.html';
    ?>
    <meta charset="UTF-8">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title><?php echo $nome ? : "Desconhecido";?> - Ficha</title>
    <style>
        @font-face {
            font-family: 'daisywheelregular';
            src: url('../../../assets/css/daisywhl-webfont.woff2') format('woff2'),
            url('../../../assets/css/daisywhl-webfont.woff') format('woff');

        }
        .daisy{
            font-family: 'daisywheelregular';
        }
        .image-container {
            width: 695px;
            height: 982px;
            overflow: hidden;
            position: sticky;
        }
        .image-container img{
            width: 695px;
            height: 982px;
        }
        .nome {
            position: absolute;
            text-align: left;
            width: auto;
            margin: 7% 0 0  26%;
            font-size: 20px;
        }
        .principal {
            position: absolute;
            text-align: left;
            width: 115px;
            font-size: 10px;
            font-weight: bold;
        }
        .origem {
            margin-top: 20%;
            margin-left: 21%;
        }
        .nex {
            margin-top: 23%;
            margin-left: 21%;
        }
        .classe {
            margin-top: 20%;
            margin-left: 45.5%;
        }
        .patente {
            margin-top: 23%;
            margin-left: 45.5%;
        }
    /*ATRIBUTOS*/
        .atributos {
            width: 70px;
            height: 70px;
            position: absolute;
            text-align: center;
            font-weight: bolder;
            font-size: 35px;
        }
        .agi {
            margin: 34.5%  0 0 33.15%;
        }
        .for {
            margin: 43.6%  0 0 20.6%;
        }
        .int {
            margin: 43.6% 0 0  46%;
        }
        .pre {
            margin: 58.75%  0 0 24.7%;
        }
        .vig {
            margin: 58.75%  0 0 41.5%;
        }
    /*Saúde*/
        .saude {
            position: absolute;
            text-align: center;
            width: 5%;
            font-weight: bold;
            font-size: 18px;
        }
        .PV {
            margin: 82%  0 0 25.7%;
        }
        .SAN {
            margin: 87% 0 0  25.7%;
        }
        .PE {
            margin: 92% 0 0  25.7%;
        }
    /*Defesas*/
        .defesas{
            position: absolute;
            text-align: center;
            font-weight: bold;
            width: 5%;
            font-size: 18px;
        }
        .passiva {
            margin: 82% 0 0  56.5%;
        }
        .bloqueio {
            margin: 86.9%  0 0 56.5%;
        }
        .esquiva {
            margin: 92%  0 0 56.5%;
        }
    /*Resistencias a Dano*/
        .resistencias{
            position: absolute;
            text-align: center;
            font-weight: bold;
            width: 5%;
            font-size: 17px;

        }
        .fisica {
            margin: 100.7% 0 0  46%;
        }
        .balistica {
            margin: 100.7%  0 0 52.59%;
        }
        .sangue {
            margin: 107.6% 0 0  33.21%;
        }
        .morte {
            margin: 107.6%  0 0 39.75%;
        }
        .energia {
            margin: 107.6% 0 0 46.25%;
        }
        .conhecimento {
            margin: 107.6% 0 0  52.75%;
        }
        .mental {
            margin: 107.6% 0 0 25.6%;
        }
    /*Pericias*/
        .pericia {
            margin-left: 81%;
            font-size: 12px;
            font-weight: bold;
            width: 3.5%;
        }
        .treinado{
            position: absolute;
            text-align: center;
            margin-left: 85%;
        }
        .atletismo {
            position: absolute;
            text-align: center;
            margin-top: 40%;
        }
        .atualidade {
            position: absolute;
            text-align: center;
            margin-top: 43.13%;
        }
        .ciencia {
            position: absolute;
            text-align: center;
            margin-top: 46.26%;
        }
        .diplomacia {
            position: absolute;
            text-align: center;
            margin-top: 49.39%;
        }
        .enganacao {
            position: absolute;
            text-align: center;
            margin-top: 52.52%;
        }
        .fortitude {
            position: absolute;
            text-align: center;
            margin-top: 55.65%;
        }
        .furtividade {
            position: absolute;
            text-align: center;
            margin-top: 58.78%;
        }
        .intimidacao {
            position: absolute;
            text-align: center;
            margin-top: 61.91%;
        }
        .intuicao {
            position: absolute;
            text-align: center;
            margin-top: 65.04%;
        }
        .investigacao {
            position: absolute;
            text-align: center;
            margin-top: 68.17%;
        }
        .luta {
            position: absolute;
            text-align: center;
            margin-top: 71.3%;
        }
        .medicina {
            position: absolute;
            text-align: center;
            margin-top: 74.43%;
        }
        .ocultismo {
            position: absolute;
            text-align: center;
            margin-top: 77.56%;
        }
        .percepcao {
            position: absolute;
            text-align: center;
            margin-top: 80.69%;
        }
        .pilotagem {
            position: absolute;
            text-align: center;
            margin-top: 83.82%;
        }
        .pontaria {
            position: absolute;
            text-align: center;
            margin-top: 86.95%;
        }
        .prestidigitacao {
            position: absolute;
            text-align: center;
            margin-top: 90.08%;
        }
        .profissao {
            position: absolute;
            text-align: center;
            margin-top: 93.21%;
        }
        .reflexos {
            position: absolute;
            text-align: center;
            margin-top: 96.34%;
        }
        .religiao {
            position: absolute;
            text-align: center;
            margin-top: 99.47%;
        }
        .tatica {
            position: absolute;
            text-align: center;
            margin-top: 102.6%;
        }
        .tecnologia {
            position: absolute;
            text-align: center;
            margin-top: 105.73%;
        }
        .vontade {
            position: absolute;
            text-align: center;
            margin-top: 108.86%;
        }
    /*Armas*/
        .Slot1 {
            position: absolute;
            margin-top: 121.2%;
        }
        .Slot2 {
            position: absolute;
            margin-top: 123.9%;
        }
        .Slot3 {
            position: absolute;
            margin-top: 126.8%;
        }
        .Slot4 {
            position: absolute;
            margin-top: 129.5%;
        }
        .Arma {
            text-align: center;
            font-size: 12px;
            margin-left: 14.2%;
            width: 11.75%;
        }
        .Tipo{
            margin-left: 26.9%;
            font-size: 12px;
            width: 14.5%;
        }
        .Ataque{
            margin-left: 42.36%;
            font-size: 12px;
            width: 6.2%;
        }
        .Alcance{
            margin-left: 49.8%;
            font-size: 12px;
            width: 8.5%;
        }
        .Dano{
            margin-left: 59.3%;
            font-size: 12px;
            width: 6.1%;
        }
        .Critico{
            margin-left: 67%;
            font-size: 12px;
        }
        .Recarga{
            margin-left: 74.6%;
            font-size: 12px;
            width: 6.25%;
        }
        .Especial{
            margin-left: 82.1%;
            font-size: 12px;
            width: 8.5%;
        }
        .Proeficiencias{
            position: absolute;
            text-align: center;
            width: 40%;
            margin: 14% 0 0 7.5%;
            font-size: 14px;
        }
        .Habilidades{
            position: absolute;
            text-align: center;
            width: 35%;
            margin: 14% 0 0 50%;
            font-size: 14px;
        }
        .Inventario{
            letter-spacing: -0.4rem;
            word-spacing: -1rem;
            font-size: 100px;
            font-weight: lighter;
        }
        .Inv1 {
            position: absolute;
            margin-top: 47.5%;
        }
        .Inv2 {
            position: absolute;
            margin-top: 50.25%;
        }
        .Inv3 {
            position: absolute;
            margin-top: 53%;
        }
        .Inv4 {
            position: absolute;
            margin-top: 55.75%;
        }
        .Inv5 {
            position: absolute;
            margin-top: 58.5%;
        }
        .Inv6 {
            position: absolute;
            margin-top: 61.25%;
        }
        .Inv7 {
            position: absolute;
            margin-top: 64%;
        }
        .Inv8 {
            position: absolute;
            margin-top: 66.75%;
        }
        .Inv9 {
            position: absolute;
            margin-top: 69.5%;
        }
        .Inv10 {
            position: absolute;
            margin-top: 72.25%;
        }
        .Inv11 {
            position: absolute;
            margin-top: 75%;
        }
        .Item {
            margin-left: 8.75%;
            text-align: center;
            width: 22.5%;
        }
        .Detalhes {
            margin-left: 31.25%;
            width: 35%;
            text-align: left;
            letter-spacing: +5px;
            word-spacing: +5px;
        }
        .Espacos {
            margin-left: 67.5%;
            text-align: center;
            width: 9%;
        }
        .Prestigio {
            margin-left: 77.25%;
            text-align: center;
            width: 9%;
        }
        .Espaco {
            position: absolute;
            text-align: right;
            width: 25%;
            margin: 39.9% 0 0 58%;
            font-size: 85px;
        }
    </style>
</head>
    <body>
    <!------------HTML----------------------->
        <div class="container-fluid">
            <div class="row">
                <div class="col my-4">
                    <div class="image-container">
                        <div class="nome">Lucas Daniel</div>
                        <div>
                            <span class="principal origem">Profissional da Saúde</span>
                            <span class="principal classe">Combatente</span>
                            <span class="principal nex">55%</span>
                            <span class="principal patente">Veterano</span>
                        </div>
                        <div>
                            <span class="atributos for rounded-circle">+99</span>
                            <span class="atributos agi rounded-circle">+99</span>
                            <span class="atributos int rounded-circle">+99</span>
                            <span class="atributos vig rounded-circle">+99</span>
                            <span class="atributos pre rounded-circle">+99</span>
                        </div>
                        <div>
                            <span class="saude PV">+99</span>
                            <span class="saude PE">+99</span>
                            <span class="saude SAN">+99</span>
                        </div>
                        <div>
                            <span class="defesas passiva">+99</span>
                            <span class="defesas bloqueio">+99</span>
                            <span class="defesas esquiva">+99</span>
                        </div>
                        <div>
                            <span class="resistencias mental">+99</span>
                            <span class="resistencias sangue">+99</span>
                            <span class="resistencias morte">+99</span>
                            <span class="resistencias energia">+99</span>
                            <span class="resistencias conhecimento">+99</span>
                            <span class="resistencias fisica">+99</span>
                            <span class="resistencias balistica">+99</span>
                        </div>
                        <div>
                            <span class="pericia atletismo">+5</span><span class="pericia treinado atletismo">Treinado</span>
                            <span class="pericia atualidade">+5</span><span class="pericia atualidade treinado">Treinado</span>
                            <span class="pericia ciencia">+5</span><span class="pericia treinado ciencia">Treinado</span>
                            <span class="pericia diplomacia">+5</span><span class="pericia treinado diplomacia">Treinado</span>
                            <span class="pericia enganacao">+5</span><span class="pericia treinado enganacao">Treinado</span>
                            <span class="pericia fortitude">+5</span><span class="pericia treinado fortitude">Treinado</span>
                            <span class="pericia furtividade">+5</span><span class="pericia treinado furtividade">Treinado</span>
                            <span class="pericia intimidacao">+5</span><span class="pericia treinado intimidacao">Treinado</span>
                            <span class="pericia intuicao">+5</span><span class="pericia treinado intuicao">Treinado</span>
                            <span class="pericia investigacao">+5</span><span class="pericia treinado investigacao">Treinado</span>
                            <span class="pericia luta">+5</span><span class="pericia treinado luta">Treinado</span>
                            <span class="pericia medicina">+5</span><span class="pericia treinado medicina">Treinado</span>
                            <span class="pericia ocultismo">+5</span><span class="pericia treinado ocultismo">Treinado</span>
                            <span class="pericia percepcao">+5</span><span class="pericia treinado percepcao">Treinado</span>
                            <span class="pericia pilotagem">+5</span><span class="pericia treinado pilotagem">Treinado</span>
                            <span class="pericia pontaria">+5</span><span class="pericia treinado pontaria">Treinado</span>
                            <span class="pericia prestidigitacao">+5</span><span class="pericia treinado prestidigitacao">Treinado</span>
                            <span class="pericia profissao">+5</span><span class="pericia treinado profissao">Treinado</span>
                            <span class="pericia reflexos">+5</span><span class="pericia treinado reflexos">Treinado</span>
                            <span class="pericia religiao">+5</span><span class="pericia treinado religiao">Treinado</span>
                            <span class="pericia tatica">+5</span><span class="pericia treinado tatica">Treinado</span>
                            <span class="pericia tecnologia">+55</span><span class="pericia treinado tecnologia">Treinado</span>
                            <span class="pericia vontade">+55</span><span class="pericia treinado vontade">Treinado</span>
                        </div>
                        <div>
                            <span class="Slot1 Arma">Katana</span>
                            <span class="Slot1 Tipo">Duas mão</span>
                            <span class="Slot1 Ataque">+5</span>
                            <span class="Slot1 Alcance">Adjacente</span>
                            <span class="Slot1 Dano">4d20</span>
                            <span class="Slot1 Critico">20/2d</span>
                            <span class="Slot1 Recarga">5/Mov</span>
                            <span class="Slot1 Especial">Discreta</span>
                        </div>
                        <div>
                            <span class="Slot2 Arma">Katana</span>
                            <span class="Slot2 Tipo">Duas mão</span>
                            <span class="Slot2 Ataque">+5</span>
                            <span class="Slot2 Alcance">Adjacente</span>
                            <span class="Slot2 Dano">4d20</span>
                            <span class="Slot2 Critico">20/2d</span>
                            <span class="Slot2 Recarga">5/Mov</span>
                            <span class="Slot2 Especial">Discreta</span>
                        </div>
                        <div>
                            <span class="Slot3 Arma">Katana</span>
                            <span class="Slot3 Tipo">Duas mão</span>
                            <span class="Slot3 Ataque">+5</span>
                            <span class="Slot3 Alcance">Adjacente</span>
                            <span class="Slot3 Dano">4d20</span>
                            <span class="Slot3 Critico">20/2d</span>
                            <span class="Slot3 Recarga">5/Mov</span>
                            <span class="Slot3 Especial">Discreta</span>
                        </div>
                        <div>
                            <span class="Slot4 Arma">Katana</span>
                            <span class="Slot4 Tipo">Duas mão</span>
                            <span class="Slot4 Ataque">+5</span>
                            <span class="Slot4 Alcance">Adjacente</span>
                            <span class="Slot4 Dano">4d20</span>
                            <span class="Slot4 Critico">20/2d</span>
                            <span class="Slot4 Recarga">5/Mov</span>
                            <span class="Slot4 Especial">Discreta</span>
                        </div>
                        <img alt="Ficha frontal" src="../../assets/img/Ficha%20frontal.png" />
                    </div>
                </div>
                <div class="col my-4">
                    <div class="image-container">
                        <div>
                            <span class="Proeficiencias">Armas de fogo(Curto e Médias)</span>
                        </div>
                        <div>
                            <span class="Habilidades"><span class="fw-bold">Ataque Poderoso:</span> Antes de atacar, Gaste 2 PE para ter +5 nos teste de AGILIDADE, FORÇA OU VIGOR, Ou +5 no DANO</span>
                        </div>
                        <div>
                            <span class="Habilidades"><span class="fw-bold">Ataque Poderoso:</span> Antes de atacar, Gaste 2 PE para ter +5 nos teste de AGILIDADE, FORÇA OU VIGOR, Ou +5 no DANO</span>
                        </div>
                        <img alt="Ficha frontal" src="../../assets/img/Ficha%20traseira%201.png" />
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>