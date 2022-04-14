<?php
header("X-Robots-Tag: none");
require_once "./../config/mysql.php";
$error = $_GET["error"];
switch($_GET["error"]){
    case '400':
        $msg = "Requisição invalida.";
        break;
    case '401':
        $msg = "Você não está autorizado para acessar essa pagina.";
        break;
    case '403':
        $msg = "O acesso dessa pagina atualmente está Proibida.";
        break;
    case '404':
        $msg = "A pagina que você está procurando não foi encontrado.";
        break;
    case '503':
        $msg = "Este serviço não está disponivel.";
        break;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <!-- Required meta tags -->
    <title><?php echo $error;?> - Fichas Ordem Paranormal</title>
    <link rel="stylesheet" href="https://fichasop.cf/assets/css/carousel.css">
    <?php
    require_once './../includes/head.html';
    ?>
</head>
<body class="bg-black text-light">
<?php
$a = false;
include_once "./../includes/top.php";?>

<div class="d-flex justify-content-center text-center">
    <div class="col-lg-4">
        <div class="card bg-black text-white border-light">
            <div class="card-body text-center">
                <h1 class="text-danger">Error - <?echo $error;?></h1>
                <div class="m-5">
                    <h4><?php echo $msg;?></h4>
                </div>
                <a href="/" class="d-grid btn btn-outline-secondary">Ir para o inicio</a>
             </div>
        </div>
    </div>
</div>

<footer class="container-fluid fixed-bottom text-white border-light border-top">
    <div class="clearfix">
        <div class="float-start text-start">
            Powered by Bootstrap
        </div>
        <div class="float-end text-end">
            Criado por <a href="mailto:ludafepi123456@gmail.com">Lucas</a>. Créditos ao <a href="https://twitch.tv/cellbit/">Cellbit</a>
        </div>
    </div>
</footer>
</body>
</html>