<?
function loging($text){
    $file_name = $_SERVER['DOCUMENT_ROOT'].'/log/gl.log';
    $file = fopen($file_name,"a+");
    fwrite($file, add_length_string(date("Y-m-d H:i:s"),19).' => '.add_length_string($_SERVER['REMOTE_ADDR'], 16).' '.$_SERVER['PHP_SELF'].' сообщает: '.$text."\r\n");
    fclose($file);
}
function mysql_query_log($x){
    $res=mysql_query($x);
    $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/log/mysql.log', 'a+');
    fwrite($fp, $x.PHP_EOL);
    fclose($fp);
    return $res;
}
?>