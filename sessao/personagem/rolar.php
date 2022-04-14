<?php
header("X-Robots-Tag: none");
header('Content-Type: application/json');
function Rolar($dado,$dano = false): array
{
    $result = [];
    $dado = str_replace("-", "+-", $dado);
    $a = explode('+',$dado);
    foreach ($a as $nome => $dados) {
        if (!empty($dados)) {
            $b = explode('d', $dados);
            $b[0] = intval($b[0]);
            if ($b[0] == 0 AND isset($b[1])) {
                $b[0] = 1;
            } else
                if ($b[0] < 0 and isset($b[1])) {
                    $b[0] = abs($b[0]);
                    $negative = true;
                }
            if (!empty($b[1])) {
                $roll = $b[0];
                $rice = $b[1];
                if(!$dano){
                    while ($result["d" . $nome]["TotalRolls"] != $roll) {
                        $result["d" . $nome]["TotalRolls"] += 1;
                        $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]] = rand(1, $rice);
                    }
                    $result["d" . $nome]["dado"] = "d" . $rice;
                    $result["d" . $nome]["bestroll"] = max($result["d" . $nome]["d" . $rice]);
                    $result["d" . $nome]["worstroll"] = min($result["d" . $nome]["d" . $rice]);
                    if ($negative) {
                        $result["result"] += $result["d" . $nome]["worstroll"];
                        $result["print"] .= "+" . $result["d" . $nome]["worstroll"];
                        $result["d" . $nome]["result"] += $result["d" . $nome]["worstroll"];
                    } else {
                        $result["result"] += $result["d" . $nome]["bestroll"];
                        $result["print"] .= "+" . $result["d" . $nome]["bestroll"];
                        $result["d" . $nome]["result"] += $result["d" . $nome]["bestroll"];
                    }
                } else {
                    while ($result["d" . $nome]["TotalRolls"] != $roll) {
                        $result["d" . $nome]["TotalRolls"] += 1;
                        $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]] = rand(1, $rice);
                        $result["result"] += $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]];
                        $result["print"] .= "+".$result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]];
                    }
                    $result["d" . $nome]["dado"] = "d" . $rice;
                }
            } else {
                if ($b[0]>0){
                    $b[0] = '+'.$b[0];
                }
                $result["result"] += $b[0];
                $result["print"] .= $b[0];
                $result["soma"] = $b[0];
            }
        }
    }
    return ($result);
}

if (!empty($_GET) || !empty($_POST))echo json_encode(Rolar($_POST["dado"]?:$_GET["dado"],$_POST["dano"]?:$_GET["dano"]));
