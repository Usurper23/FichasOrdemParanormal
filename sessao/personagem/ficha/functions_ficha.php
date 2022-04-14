<?php

require_once __dir__ . "./../../../config/mysql.php";



function ValorParaMostrarNoAtributo($Atributo){
    if($Atributo > 0){
        return ("+".$Atributo);
    } else {
        return $Atributo;
    }
}
function ValorParaRolarDado($Atributo){
    if ($Atributo >= 0){
        return ($Atributo + 1);
    } else {
        return ((abs($Atributo) + 1)* -1);
    }
}
function TirarPorcento($Valor_Atual,$Valor_Maximo){
    return minmax((($Valor_Atual/$Valor_Maximo)*100),0,100);
}




