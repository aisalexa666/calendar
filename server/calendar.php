<?php
    include $_SERVER['DOCUMENT_ROOT'].'/_constant/mysql.php';
    global $C_MySQL_Host, $C_MySQL_login, $C_MySQL_Password, $C_MySQL_Name_Base;
    $link = mysql_connect($C_MySQL_Host, $C_MySQL_login, $C_MySQL_Password)or die(mysql_error());
    mysql_select_db($C_MySQL_Name_Base);
    mysql_set_charset("CP1251");
/*****************************
 * Структура ответа на лигитимный запрос
 *     1. Служебная информация (указание кодировки и проч)
 *     2. Разделитель
 *     3. Запрашиваемый контент.
*****************************/
//Служебная информация
    echo '<META http-equiv="content-type" content="text/html; charset=windows-1251">';
    echo '|destr|';//Разделитель
    echo 'Хай, %UserName%!';//%UserName% - это не переменная какая-нить, а хабростиль)
/*****************************
 * Формирование страницы ответа от сервера
 *     1. Сбор информации о запланированных задачах на указанную дату
 *     2. Если день не забит под завязку, то добавить в ответ форму создания задания
*****************************/
    mysql_Close($link);



?>