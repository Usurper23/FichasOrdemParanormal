<?php
header("X-Robots-Tag: none");
require_once "./../../../config/mysql.php";
$con = con();
/*
 * Armas->X
 * habilidades->X
 * Inventario->X
 * Proeficiencias->X
 * Principal->nome,origem,classe,nex,patente,idade,local,historia//
 * Atributos-> forca,agilidade,intelecto,presenca,vigor//
 * Defesas-> passiva,bloqueio,esquiva//
 * Pericias->...
 * Resistencia->Sanidade,sangue,morte,energia,conhecimento,fisica,balistica//
 * Saude->PV,SAN,PE//
 */
$msg = [];
$sucesso = true;
if(isset($_SESSION["UserID"])) {
    $iduser = $_SESSION["UserID"];
    $missao = intval($_POST["missao"] ?: $_GET["missao"]);
        if (!empty($_POST["nome"])) {
            $nome = test_input($_POST["nome"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
                $msg = "Apenas Letras e Espaços são permitidos no nome!";
                $sucesso = false;
            }
        } else {
            $sucesso = false;
            $msg = "Preencha o nome do seu personagem!";
        }
        $fotos = intval($_POST["foto"]);
        $fotourl= $_POST["fotourl"];
        if ($fotos > 0 AND $fotos < 10){
            if($fotos == 9){
                if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp)$/', $fotourl)){
                    $foto = $fotourl;
                }
            } else {
                $foto = $fotos;
            }
        } else {
            $sucesso = false;
            $msg = "Foto escolhida não existe.";
        }
        $origem = minmax($_POST["origem"], 0, 5);
        $classe = minmax($_POST["classe"], 0, 3);
        $trilha = minmax($_POST["trilha"], 0, 9);
        $nex = minmax($_POST["nex"], 0, 99);
        $patente = minmax($_POST["patente"], 0, 5);
        $idade = intval($_POST["idade"] ?: 0);
        if ($idade < 18 and $idade > 0) {
            $sucesso = false;
            $msg = "Seu personagem não pode ser menor de idade!(coloque 0 para desconhecido)";
        }

        $local = test_input($_POST["local"] ?: 'Desconhecido');
        $historia = test_input($_POST["historia"] ?: '');
        $forca = intval($_POST["forca"]);
        $agilidade = intval($_POST["agilidade"]);
        $intelecto = intval($_POST["intelecto"]);
        $presenca = intval($_POST["presenca"]);
        $vigor = intval($_POST["vigor"]);
        $pv = minmax($_POST["pv"], 1, 999);
        $san = minmax($_POST["san"], 1, 999);
        $pe = minmax($_POST["pe"], 1, 999);


        if ($pv <= 0 || $san <= 0 || $pe <= 0) {
            $sucesso = false;
            $msg = "Confira seus pontos de saude.";
        }
        if ($pv == 1){
            $pv = calcularvida($nex,$classe,$vigor);
        }
        if ($pe == 1){
            $pe = calcularpe($nex,$classe,$vigor);
        }

        $sangue = minmax($_POST["sangue"], 0, 99);
        $morte = minmax($_POST["morte"], 0, 99);
        $conhecimento = minmax($_POST["conhecimento"], 0, 99);
        $energia = minmax($_POST["energia"], 0, 99);
        $sanidade = minmax($_POST["sanidade"], 0, 99);
        $fisico = minmax($_POST["fisico"], 0, 99);
        $balistico = minmax($_POST["balistico"], 0, 99);
        $atletismo = minmax($_POST["atletismo"], 0, 99);
        $atualidades = minmax($_POST["atualidades"], 0, 99);
        $ciencia = minmax($_POST["ciencia"], 0, 99);
        $diplomacia = minmax($_POST["diplomacia"], 0, 99);
        $enganacao = minmax($_POST["enganacao"], 0, 99);
        $fortitude = minmax($_POST["fortitude"], 0, 99);
        $furtividade = minmax($_POST["furtividade"], 0, 99);
        $intimidacao = minmax($_POST["intimidacao"], 0, 99);
        $intuicao = minmax($_POST["intuicao"], 0, 99);
        $investigacao = minmax($_POST["investigacao"], 0, 99);
        $luta = minmax($_POST["luta"], 0, 99);
        $medicina = minmax($_POST["medicina"], 0, 99);
        $ocultismo = minmax($_POST["ocultismo"], 0, 99);
        $percepcao = minmax($_POST["percepcao"], 0, 99);
        $pilotagem = minmax($_POST["pilotagem"], 0, 99);
        $pontaria = minmax($_POST["pontaria"], 0, 99);
        $prestidigitacao = minmax($_POST["prestidigitacao"], 0, 99);
        $profissao = minmax($_POST["profissao"], 0, 99);
        $reflexo = minmax($_POST["reflexo"], 0, 99);
        $religiao = minmax($_POST["religiao"], 0, 99);
        $tatica = minmax($_POST["tatica"], 0, 99);
        $tecnologia = minmax($_POST["tecnologia"], 0, 99);
        $vontade = minmax($_POST["vontade"], 0, 99);
        $passiva = minmax($_POST["passiva"],0,99);
        $bloqueio = minmax($_POST["bloqueio"],0,99);
        $esquiva = minmax($_POST["esquiva"],0,99);

        if($bloqueio == 1 AND $luta > 0){$bloqueio = $passiva + $luta + $forca;} else {$bloqueio = 0;}
        if($esquiva == 1 AND $reflexo > 0){$esquiva = $passiva + $reflexo + $agilidade;} else {$esquiva = 0;}
        if ($sucesso) {
            $vp = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `usuario` = ? AND `nome` = ?");
            $vp->bind_param("is", $iduser, $nome);
            $vp->execute();
            $rvp = $vp->get_result();
            if ($rvp->num_rows == 0) {
                $vapo = $con->query("SELECT * FROM `fichas_personagem` WHERE `usuario` = '$iduser'");
                $vl = $con->query("SELECT * FROM `ligacoes` WHERE `id_usuario`='$iduser' AND `id_missao` = '".$missao."' AND `id_ficha` is null");
                if($vl->num_rows or $vapo->num_rows<1) {
                    $qp = $con->prepare("INSERT INTO `fichas_personagem` (`id`, `public`, `usuario`, `nome`, `foto`, `origem`, `classe`, `trilha`, `nex`, `patente`, `idade`, `local`, `historia`, `forca`, `agilidade`, `inteligencia`, `presenca`, `vigor`, `pv`, `pva`, `san`, `sana`, `pe`, `pea`, `morrendo`, `enlouquecendo`, `passiva`, `bloqueio`, `esquiva`, `mental`, `sangue`, `morte`, `energia`, `conhecimento`, `fisica`, `balistica`) VALUES ('', '1', ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , 0 , 0 , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? );");
                    $qp->bind_param("issiiiiiissiiiiiiiiiiiiiiiiiiiii", $iduser, $nome, $foto, $origem, $classe, $trilha, $nex, $patente, $idade, $local, $historia, $forca, $agilidade, $intelecto, $presenca, $vigor, $pv, $pv, $san, $san, $pe, $pe, $passiva, $bloqueio, $esquiva, $sanidade, $sangue, $morte, $energia, $conhecimento, $fisico, $balistico);
                    $sucesso = $qp->execute();
                    $id = mysqli_insert_id($con);
                    switch ($origem){
                        default:
                            $habnam = "";
                            $habdes = "";
                            break;
                        case 1: //academica
                            $habnam = "Estudo Rigoroso (Origem)";
                            $habdes = "Uma vez por cena, quando for fazer um teste usando Intelecto, você pode usar 2 PE receber +5 no teste.";
                            break;
                        case 2:// atleta
                            $habnam = "110% (Origem)";
                            $habdes = "Uma vez por cena, quando fizer um teste de perícia usando Força ou Agilidade (exceto testes de ataque) você pode usar 2 PE para receber +5 no teste.";
                            break;
                        case 3: // exorcista
                            $habnam = "Exorcismo (Origem)";
                            $habdes = "Seu contato com o Outro Lado faz com que você saiba lidar com traumas na alma. Você pode usar Ocultismo no lugar de Diplomacia para fazer uma ação de “Terapia”.";
                            break;
                        case 4: // mercenaria
                            $habnam = "A Melhor Defesa é o Ataque (Origem)";
                            $habdes = "começo de uma Cena de Ação, você pode usar 2 PE para receber uma ação padrão adicional no seu primeiro turno.";
                            break;
                        case 5: // prof saude
                            $habnam = "Técnicas Medicinais (Médico)";
                            $habdes = "Sempre que você curar um personagem, você adiciona seu Intelecto no total de PV curados.";
                            break;
                        case 6: // ti
                            $habnam = "Motor de Busca (Origem)";
                            $habdes = "A critério do Mestre, você pode gastar 2 PE para substituir qualquer teste de Perícia por um teste de Tecnologia";
                            break;
                        case 7: // artista
                            $habnam = "Magnum-opus(Origem)";
                            $habdes = "Por ser um artista famoso, uma vez por missão, o jogador pode determinar, em uma cena de interação, que um personagem o reconheça por seu trabalho, recebendo +10 em Diplomacia, Enganação, Intuição e Intimidação com aquele personagem.";
                            break;
                    }
                    if (!empty($habnam)) {
                        $dp = $con->query("INSERT INTO `habilidades`(`id_ficha`,`nome`,`descricao`,`id`) VALUES ('$id','$habnam','$habdes','')");
                    }
                    $al = $con->query("UPDATE `ligacoes` SET `id_ficha` = '" . $id . "' WHERE `ligacoes`.`id_missao` = '" . $missao . "' AND `ligacoes`.`id_usuario` = '" . $iduser . "';");
                    $msg = $sucesso ? "Personagem Criado com sucesso!" : "Houve uma falha ao adicionar personagem na database, contate um administrador!";
                } else {
                    $sucesso = false;
                    $msg = 'Você não foi convidado para essa missão!(Verifique se o id que o mestre adicionou na missão é o mesmo de sua conta.)';
                }
            } else {
                $sucesso = false;
                $msg = 'Já Existe um Personagem seu com esse mesmo nome!(Provavelmente houve duplicação ao salvar, então só ir para pagina do seu personagem.)';
            }
        }
} else {
    $sucesso = false;
    $msg="Sua sessão expirou, faça login novamente.";
}
$data["id"] = $id;
$data["msg"] = $msg;
$data["success"] = $sucesso;
echo json_encode($data);