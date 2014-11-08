<?
function Chek_string_of_mask($String, $Mask){
    $Lenght_String = strlen($String);
    if ($Lenght_String==0)
        return false;
    for ($i = 0; $i < ($Lenght_String); $i++)
        if (substr_count($Mask, $String[$i])==0)
            return false;
    return true;
}

?>