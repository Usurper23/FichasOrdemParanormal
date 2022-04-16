<?php
header("X-Robots-Tag: none");
header('Content-Type: application/json');
require_once "./ficha/functions_ficha.php";
if (!empty($_GET) || !empty($_POST)) echo json_encode(Rolar($_POST["dado"] ?: $_GET["dado"], $_POST["dano"] ?: $_GET["dano"]));
