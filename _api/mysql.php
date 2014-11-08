<?
function F_mysql_table_seek($tablename, $dbname){
    $table_list = mysql_query("SHOW TABLES FROM `".$dbname."`");
    while ($row = mysql_fetch_row($table_list))
        if ($tablename==$row[0])
            return true;
    return false;
}
?>