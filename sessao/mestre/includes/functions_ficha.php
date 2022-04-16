<?php

require_once __dir__ . "./../../../config/mysql.php";

function ClearRolar($dado,$Return_Error = false)
{
    $success = true;

    if (!empty($dado)) {
        if(preg_match('/^[d0-9+-]+\S$/', $dado)) {
            if ($success) {
                $dado = str_replace("-", "+-", $dado);
                $a = explode('+', $dado);
                foreach ($a as $dados):
                    if ($success) {
                        if (!empty($dados)) {
                            $b = explode('d', $dados);
                            $b[0] = intval($b[0]);
                            if (($b[0] > 10 || $b[0] < -10) and isset($b[1])) {
                                $success = false;
                                $msg = "Não pode rolar mais de 10 dados de uma vez.";
                            }
                            if (($b[0] > 30 || $b[0] < -30) and !isset($b[1])) {
                                $success = false;
                                $msg = "Não pode somar além de 30 absolutamente.";
                            }
                            if ($b[1] > 100) {
                                $success = false;
                                $msg = "Não pode rolar dados com mais de 100 Lados.";
                            }
                        }
                    }
                endforeach;
            }
        } else {
            $success = false;
            $msg = "Preencha o campo de forma devida!";
        }
    }else {
        $success = false;
        $msg = "Preencha o campo!";
    }
    $data["success"] = $success;
    $data["msg"] = $msg;
    if($Return_Error){
        return $data;
    }else{
        return $success;
    }
}

function Rolar($dado, $dano = false): array
{
    $result = [];
    $dado = str_replace("-", "+-", $dado);
    $a = explode('+', $dado);
    foreach ($a as $nome => $dados) {
        if (!empty($dados)) {
            $b = explode('d', $dados);
            $b[0] = intval($b[0]);
            if ($b[0] == 0 and isset($b[1])) {
                $b[0] = 1;
            } else
                if ($b[0] < 0 and isset($b[1])) {
                    $b[0] = abs($b[0]);
                    $negative = true;
                }
            if (!empty($b[1])) {
                $roll = $b[0];
                $rice = $b[1];
                if (!$dano) {
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
                        $result["print"] .= "+" . $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]];
                    }
                    $result["d" . $nome]["dado"] = "d" . $rice;
                }
            } else {
                if ($b[0] > 0) {
                    $b[0] = '+' . $b[0];
                }
                $result["result"] += $b[0];
                $result["print"] .= $b[0];
                $result["soma"] = $b[0];
            }
        }
    }
    return ($result);
}
function ValorParaMostrarNoAtributo($Atributo)
{
    if ($Atributo > 0) {
        return ("+" . $Atributo);
    } else {
        return $Atributo;
    }
}

function ValorParaRolarDado($Atributo)
{
    if ($Atributo >= 0) {
        return ($Atributo + 1);
    } else {
        return ((abs($Atributo) + 1) * -1);
    }
}

function TirarPorcento($Valor_Atual, $Valor_Maximo)
{
    return minmax((($Valor_Atual / $Valor_Maximo) * 100), 0, 100);
}




