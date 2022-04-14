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


$qs = $con->query("SELECT * FROM `fichas_personagem` WHERE `id` = '$id'");
if($qs->num_rows) {
    $rqs = mysqli_fetch_array($qs);
} else {
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
        $dados_missao = mysqli_fetch_array($qm);
    }
}

//Verifica se tem permissão para usar ficha
if ($_SESSION["UserAdmin"] || $dados_missao["mestre"] == $userid){
    $edit = true;
} else {
    if ($dados_missao === null and VerificarID($id) OR $dados_missao["status"] AND  VerificarID($id)) {
        $edit = true;
    } else {
        if (!$rqs["public"]) echo "<script>window.location.href='..'</script>";
    }
}


// Dados de quando atualiza a ficha ou quando altera.
require_once "./ficha/atualizar.php";


//Funções para fazer coisas simples.
require_once "./ficha/functions_ficha.php";


//Pega todos os dados da ficha: Principal

    if ($rqs != NULL){
        $nu = $con->query("SELECT * FROM `usuarios` WHERE `usuarios`.`id` = ".($rqs["usuario"]?:0));
        $usuario = (mysqli_fetch_assoc($nu))["nome"];
        $nome = $rqs["nome"];
        $nex = $rqs["nex"];
        $idade = $rqs["idade"]?:"Desconhecida.";
        $local = $rqs["local"];
        $historia = $rqs["historia"];
        $urlphoto = $rqs["foto"];
        if (intval($urlphoto) > 0){
        switch (intval($rqs["foto"])){
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
        switch($rqs["origem"]){
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
        switch($rqs["classe"]){
            default:
                $classe = "Não indentificado.";
                $trilha = "Não indentificada.";
                break;
            case 1:
                $classe = "Combatente";
                switch($rqs["trilha"]){
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
                switch($rqs["trilha"]){
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
                switch($rqs["trilha"]){
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
        $ppv = TirarPorcento($pva,$pv);
        $psan = TirarPorcento($sana,$san);
        $ppe = TirarPorcento($pea,$pe);
        $morrendo = $rqs["morrendo"];
        $enlouquecendo = $rqs["enlouquecendo"];

        $passiva = $rqs["passiva"];
        $bloqueio = $rqs["bloqueio"];
        $esquiva = $rqs["esquiva"];

        $fisica = $rqs["fisica"];
        $balistica = $rqs["balistica"];
        $insanidade = $rqs["sanidade"];
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

}
//pega todos os dados da ficha: Rituais
    $s[6] = $con->query("Select * From `rituais` where `id_ficha` = '$id';");

//pega todos os dados da ficha: Armas
    $s[1] = $con->query("Select * From `armas` where `id_ficha` = '$id';");
//Pega todos os dados da ficha: Habilidades
    $s[2] = $con->query("SELECT * FROM `habilidades` WHERE `id_ficha` = '".$id."';");
//Pega todos os dados da ficha: Proeficiencias
    $s[3] = $con->query("SELECT * FROM `proeficiencias` WHERE `id_ficha` = '".$id."';");
//pega todos os dados da ficha: Inventario
$s[4] = $con->query("Select * From `inventario` where `id_ficha` = '$id';");
$s[5] = $con->query("Select SUM(espaco) AS pesototal From `inventario` where `id_ficha` = '$id';");
    $ddinv = mysqli_fetch_array($s[5]);
    $espacosusados = $ddinv["pesototal"]?:0;

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
    <title><?php echo $nome ? : "Desconhecido";?> - Ficha OP</title>
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
                if (!isset($_GET["popout"])){
                    include_once "./ficha/card_detalhes.php";
                } else {
                    if ($_GET["popout"] == 'dados')
                        include_once "./ficha/card_detalhes.php";
                }
                ?>
            <!---------------------------Painel Principal----------------------------------->
                <?php

                if (!isset($_GET["popout"])){
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
            if (!isset($_GET["popout"])){
                include_once "./ficha/card_atributos.php";
            } else {
                if ($_GET["popout"] == 'atributos')
                    include_once "./ficha/card_atributos.php";
            }
            ?>
            <!-------------------Peripeças------------------------>
            <?php
            if (!isset($_GET["popout"])){
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
            if (!isset($_GET["popout"])){
                include_once "./ficha/card_habilidades.php";
            } else {
                if ($_GET["popout"] == 'habilidades')
                    include_once "./ficha/card_habilidades.php";
            }
            ?>
            <!-------------------Proeficiencias------------------------>
            <?php
            if (!isset($_GET["popout"])){
                include_once "./ficha/card_proeficiencias.php";
            } else {
                if ($_GET["popout"] == 'proeficiencias')
                    include_once "./ficha/card_proeficiencias.php";
            }
            ?>
        </div>

        <!-----------------------------------------------------------Inventario------------------------------------>

        <?php
        if (!isset($_GET["popout"])){
            include_once "./ficha/card_inventario.php";
        } else {
            if ($_GET["popout"] == 'inventario')
                include_once "./ficha/card_inventario.php";
        }
        ?>





        <?php
        if (!isset($_GET["rituais"])) {
            include_once "./ficha/card_rituais.php";
        } else {
            if ($_GET["popout"] == 'inventario')
                include_once "./ficha/card_rituais.php";
        }
        ?>

    </div>
</main>
<div id="modalsaki">
    <!---------Modals e Toasts--------------->
    <?php if ($edit){
        require_once "./ficha/modal_detalhes.php";
        require_once "./ficha/modal_principal.php";
        require_once "./ficha/modal_habilidades.php";
        require_once "./ficha/modal_atributos.php";
        require_once "./ficha/modal_pericias.php";
        require_once "./ficha/modal_inventario.php";
        require_once "./ficha/modal_dados.php";
        require_once "./ficha/modal_proeficiencias.php";
        require_once "./ficha/modal_rituais.php";
    }?>
</div>


    <script>
        <?php if ($edit){?>
            function deletehab(id){
                $.post({
                    url: '?id=<?php echo $id;?>',
                    data:{status:'delethab',hid:id}
                }).done(function () {
                    location.reload();
                })
            }// Deletar Habilidade
            function deletepro(id){
                $.post({
                    url: '?id=<?php echo $id;?>',
                    data:{status:'deletpro',pid:id}
                }).done(function () {
                    location.reload();
                })
            }// Deletar Proeficiencia
            function cleanedit(){
                $('#armadelet').html('');
                $('#deletarmaid').val('');
                $('#editarmatitle, #enome').html('');
                $('#etipo').html('');
                $('#eataque').html('');
                $('#ealcance').html('');
                $('#edano').html('');
                $('#ecritico').html('');
                $('#erecarga').html('');
                $('#eespecial').html('');
                $('#editarmaid').val('');
                $('#enom').html('');
                $('#edes').html('');
                $('#epes').html('');
                $('#epre').html('');
                $('#edititid').val('');
                $('#anom').html('');
                $('#ades').html('');
                $('#apes').html('');
                $('#apre').html('');
                $('#additemid').val('');
            }  // Resetar
            function deletearma(id) {
                $('#armadelet').html($("#armaid"+ id +" .arma").text());
                $('#deletarmaid').val(id);
            }//Deletar Arma
            function deleteitem(id) {
                $.post({
                    url:'?id=<?php echo $id;?>',
                    data:{status:'delitem',iid:id}
                }).done(function () {
                    location.reload();
                })
            }//Deletar Item
            function deleteritual(id) {
                $.post({
                    url:'?id=<?php echo $id;?>',
                    data:{status:'deleteritual',rid:id}
                }).done(function (data) {
                    console.log(data);
                    location.reload();
                })
            }//Deletar Item
            function editarma(id) {
                $('#editarmatitle, #enome').val($("#armaid"+ id +" .arma").text());
                $('#etipo').val($("#armaid"+ id +" .tipo").text());
                $('#eataque').val($("#armaid"+ id +" .ataque").text());
                $('#ealcance').val($("#armaid"+ id +" .alcance").text());
                $('#edano').val($("#armaid"+ id +" .dano").text());
                $('#ecritico').val($("#armaid"+ id +" .critico").text());
                $('#erecarga').val($("#armaid"+ id +" .recarga").text());
                $('#eespecial').val($("#armaid"+ id +" .especial").text());
                $('#editarmaid').val(id);
            }// Editar Arma
            function edititem(id) {
                $('#edititemtitle, #enom').val($("#itemid"+ id +" .nome").text());
                $('#edes').val($("#itemid"+ id +" .desc").text());
                $('#epes').val($("#itemid"+ id +" .espaco").text());
                $('#epre').val($("#itemid"+ id +" .prestigio").text());
                $('#edititid').val(id);
            }// Editar Item
            function updtvida(valor){
                $.post({
                    url: '?id=<?php echo $id;?>',
                    data: {status: 'upv',value: valor},
                }).done(function () {
                    $("#saude").load(location.href + " #saude>*");
                })
            }//Atualizar vida
            function updtsan(valor){
                $.post({
                    url: '?id=<?php echo $id;?>',
                    data: {status: 'usan',value: valor},
                }).done(function () {
                    $("#saude").load(location.href + " #saude>*");
                })
            }// Atualizar Sanidade
            function rolar(dado,dano=0){
                $.post({
                    beforeSend: function(){
                        $("main button").attr("disabled", true)
                        $("#valordados1,#valordados2,#valordados3").hide()
                    },
                    url: "./rolar.php",
                    data:{dado,dano},
                    dataType: "JSON",
                }).done(function(data){
                    var dados1 = data['d0'];
                    var dados2 = data['d1'];
                    var dados3 = data['d2'];
                    if (dados1){
                        $("#valordados1").show()
                        var dado1 = dados1['dado'];
                        let d1r1 = dados1[dado1]["d1"]? ' '+dados1[dado1]["d1"] : '';
                        let d1r2 = dados1[dado1]["d2"]?', '+dados1[dado1]["d2"] : '';
                        let d1r3 = dados1[dado1]["d3"]?', '+dados1[dado1]["d3"] : '';
                        let d1r4 = dados1[dado1]["d4"]?', '+dados1[dado1]["d4"] : '';
                        let d1r5 = dados1[dado1]["d5"]?', '+dados1[dado1]["d5"] : '';
                        let d1r6 = dados1[dado1]["d6"]?', '+dados1[dado1]["d6"] : '';
                        let d1r7 = dados1[dado1]["d7"]?', '+dados1[dado1]["d7"] : '';
                        let d1r8 = dados1[dado1]["d8"]?', '+dados1[dado1]["d8"] : '';
                        let d1r9 = dados1[dado1]["d9"]?', '+dados1[dado1]["d9"] : '';
                        let d1r0 = dados1[dado1]["d10"]?', '+dados1[dado1]["d10"] : '';
                        $("#dado1").html(dado1);
                        $("#valores1").html(d1r1+d1r2+d1r3+d1r4+d1r5+d1r6+d1r7+d1r8+d1r9+d1r0);
                    } else {
                        $('main button').attr('disabled',false);
                    }
                    if (dados2){
                        $("#valordados2").show()
                        const dado2 = dados2['dado'];
                        let d2r1 = dados2[dado2]["d1"]? ' '+dados2[dado2]["d1"] : '';
                        let d2r2 = dados2[dado2]["d2"]?', '+dados2[dado2]["d2"] : '';
                        let d2r3 = dados2[dado2]["d3"]?', '+dados2[dado2]["d3"] : '';
                        let d2r4 = dados2[dado2]["d4"]?', '+dados2[dado2]["d4"] : '';
                        let d2r5 = dados2[dado2]["d5"]?', '+dados2[dado2]["d5"] : '';
                        let d2r6 = dados2[dado2]["d6"]?', '+dados2[dado2]["d6"] : '';
                        let d2r7 = dados2[dado2]["d7"]?', '+dados2[dado2]["d7"] : '';
                        let d2r8 = dados2[dado2]["d8"]?', '+dados2[dado2]["d8"] : '';
                        let d2r9 = dados2[dado2]["d9"]?', '+dados2[dado2]["d9"] : '';
                        let d2r0 = dados2[dado2]["d10"]?', '+dados2[dado2]["d10"] : '';
                        $("#dado2").html(dado2);
                        $("#valores2").html(d2r1+d2r2+d2r3+d2r4+d2r5+d2r6+d2r7+d2r8+d2r9+d2r0);
                    }
                    if (dados3) {
                        $("#valordados3").show()
                        var dado3 = dados3['dado'];
                        let d3r1 = dados3[dado3]["d1"]? ' '+dados3[dado3]["d1"] : '';
                        let d3r2 = dados3[dado3]["d2"]?', '+dados3[dado3]["d2"] : '';
                        let d3r3 = dados3[dado3]["d3"]?', '+dados3[dado3]["d3"] : '';
                        let d3r4 = dados3[dado3]["d4"]?', '+dados3[dado3]["d4"] : '';
                        let d3r5 = dados3[dado3]["d5"]?', '+dados3[dado3]["d5"] : '';
                        let d3r6 = dados3[dado3]["d6"]?', '+dados3[dado3]["d6"] : '';
                        let d3r7 = dados3[dado3]["d7"]?', '+dados3[dado3]["d7"] : '';
                        let d3r8 = dados3[dado3]["d8"]?', '+dados3[dado3]["d8"] : '';
                        let d3r9 = dados3[dado3]["d9"]?', '+dados3[dado3]["d9"] : '';
                        let d3r0 = dados3[dado3]["d10"]?', '+dados3[dado3]["d10"] : '';
                        $("#dado3").html(dado1);
                        $("#valores3").html(d3r1 + d3r2 + d3r3 + d3r4 + d3r5 + d3r6 + d3r7 + d3r8 + d3r9 + d3r0);
                    }
                    $("#resultado").html(data.print);
                    new bootstrap.Toast($('#Toastdados')).show();
                }).fail(function (){
                    new bootstrap.Toast($('#Toastdados')).show();
                    $('#resultado,#dado1,#dado2,#dado3,#valores1,#valores2,#valores3').html('');
                    $('#valordados1,#valordados2,#valordados3').hide();
                    $('#resultado').html('FALHA AO RODAR DADO, VERIFICAR SE ESTÀ CORRETO!');
                    $('main button').attr('disabled',false);
                })
            }// Mostrar resultado dados

            $.fn.isValid = function(){
                return this[0].checkValidity()
            } // Função para checar validade de formularios
            $(document).ready(function() {

                $(".fa-dice-d20").hover(function () {
                    $(this).toggleClass("fa-spin");
                });

                $('#prev').html('<img class="position-absolute rounded-circle border border-light" style="max-width:100px;" src="' + $('#fotourl').val() + '">');
                $('#fotourl').on('input', function() {
                    var src = jQuery(this).val();

                    if(!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") && src !== "") {
                        $("#warning").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(.jpg, .png ...)!");
                        $('#prev').html('');
                        return false;
                    } else {
                        $("#warning").html("");
                        $('#prev').html('<img class="position-absolute rounded-circle border border-light" style="max-width:100px;" src="' + src + '">');
                    }

                })
                $('#foto').change(function(){
                    let fotovalor =  $('#foto').val()
                    console.log(fotovalor);
                    if (fotovalor == '9'){
                        $('#divfotourl').show();
                        $("#fotourl").attr("disabled", false)
                        console.log("show");
                    } else {
                        $('#divfotourl').hide();
                        $("#fotourl").attr("disabled", true)
                        console.log("hide");
                    }
                })

                $('#simbolourl').on('input', function() {
                    var src = jQuery(this).val();

                    if(!src.match("^https?://(?:[a-z\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|png|jpeg|webp)$") && src !== "") {
                        $("#warningsimbolo").html("Precisa ser HTTPS, e Terminar com com extensão de imagem(jpg,png,...)!");
                        $('#prevsimbolo').html(' <img src="https://fichasop.cf/assets/img/desconh.png" width="200" height="200" alt="Ritual">');
                        return false;
                    } else {
                        $("#warningsimbolo").html("");
                        $('#prevsimbolo').html('<img src="' + src + '" width="200" height="200" alt="Ritual">');
                    }

                })
                $('#fotosimbolo').change(function(){
                    let fotovalor =  $('#fotosimbolo').val()
                    console.log(fotovalor);
                    if (fotovalor == '2'){
                        $('#divfotosimbolourl').show();
                        $("#simbolourl").attr("disabled", false)
                    } else {
                        $('#divfotosimbolourl').hide();
                        $("#simbolourl").attr("disabled", true)
                    }
                })




                $('#addarmainvswitch').on('click', function () {
                    if ($(this).is(":checked")) {
                        $('#addarmainv input[type=text], #addarmainv input[type=number]').attr('disabled', false);
                    } else {
                        $('#addarmainv input[type=text], #addarmainv input[type=number]').attr('disabled', true);
                    }
                }) //Ativar/Desativar Inventario em adicionar arma

                $('#Toastdados').on('hidden.bs.toast', function () {
                    $('#resultado,#dado1,#dado2,#dado3,#valores1,#valores2,#valores3').html('');
                    $('#valordados1,#valordados2,#valordados3').hide();
                    $('main button').attr('disabled',false);
                })// Toast dos dados


                $("form").submit(function (event){
                    $(this).addClass('was-validated');
                    if (!$(this).isValid()) {
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        event.preventDefault();
                        $("#formaddarmas input").attr("readonly", true);
                        $("#formaddarmas button").attr("disabled", true);
                        $.post({
                            url: '?id=<?php echo $id;?>',
                            data: $(this).serialize(),
                        }).done(function (data) {
                            console.log(data);
                            location.reload();
                        })
                    }
                })// Enviar qualquer formulario via jquery


                $('#card_principal .popout').on('click',function () {
                    window.open("https://fichasop.cf/sessao/personagem?popout=principal&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
                    return false;
                })
                $('#card_dados .popout').on('click',function () {
                    window.open("https://fichasop.cf/sessao/personagem?popout=dados&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
                    return false;
                })
                $('#card_atributos .popout').on('click',function () {
                    window.open("https://fichasop.cf/sessao/personagem?popout=atributos&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
                    return false;
                })
                $('#card_inventario .popout').on('click',function () {
                    window.open("https://fichasop.cf/sessao/personagem?popout=inventario&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
                    return false;
                })
                $('#card_pericias .popout').on('click',function () {
                    window.open("https://fichasop.cf/sessao/personagem?popout=pericias&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
                    return false;
                })
                $('#card_habilidades .popout').on('click',function () {
                    window.open("https://fichasop.cf/sessao/personagem?popout=habilidades&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
                    return false;
                })
                $('#card_proeficiencias .popout').on('click',function () {
                    window.open("https://fichasop.cf/sessao/personagem?popout=proeficiencias&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
                    return false;
                })
                $('#card_rituais .popout').on('click',function () {
                    window.open("https://fichasop.cf/sessao/personagem?popout=rituais&id=<?php echo $id;?>", "yyyyy", "width=480,height=360,resizable=no,toolbar=no,menubar=no,location=no,status=no");
                    return false;
                })

                $('#pe input[type=checkbox]').change(function() {
                    var checkboxes = $('#pe input:checkbox:checked').length;
                    $.post({
                        url: '?id=<?php echo $id;?>',
                        data: {status: 'pe',value: checkboxes},
                    }).done(function () {
                        $( "#peatual" ).load( "index.php?id=<?php echo $id;?> #peatual" );
                    })
                });
                $('#morrendo').change(function(){
                    var x;
                    if ($('#morrendo').is(":checked")) {
                        x = 1;
                    } else {
                        x = 0;
                    }
                    $.post({
                        url: '?id=<?php echo $id;?>',
                        data: {status: 'morrendo',value: x},
                    }).done(function (data) {
                    })
                })
                $('#enlouquecendo').change(function(){
                    var y;
                    if ($('#enlouquecendo').is(":checked")) {
                        y = 1;
                    } else {
                        y = 0;
                    }
                    $.post({
                        url: '?id=<?php echo $id;?>',
                        data: {status: 'enlouquecendo',value: y},
                    }).done(function (data) {
                    })
                })
                $("#verp").click(function() {
                    $("#pericias .destreinado").toggle();
                    $( this ).toggleClass("fa-eye fa-eye-slash");
                });
                $("#vera").click(function() {
                    $('#inv .trocavision').toggle();
                    $( this ).toggleClass( "fa-eye fa-eye-slash" );
                });
            });
        <?php } else {?>
        $(document).ready(function() {
            $("#verp").click(function() {
                $("#pericias .destreinado").toggle();
                $( this ).toggleClass("fa-eye fa-eye-slash");
            });
            $("#vera").click(function() {
                $('#inv .trocavision').toggle();
                $( this ).toggleClass( "fa-eye fa-eye-slash" );
            });
        });
        <?php
        }?>
    </script>
</body>