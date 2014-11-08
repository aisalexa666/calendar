<?php
//PEAR style
    include $_SERVER['DOCUMENT_ROOT'].'/_constant/mysql.php';
    global $C_MySQL_Host, $C_MySQL_login, $C_MySQL_Password, $C_MySQL_Name_Base;
    $link = mysql_connect($C_MySQL_Host, $C_MySQL_login, $C_MySQL_Password)or die(mysql_error());
    if (!mysql_select_db($C_MySQL_Name_Base, $link))
        if (mysql_errno($link) == 1049){
//Первый запуск: создание БД и таблиц
            mysql_query('CREATE DATABASE IF NOT EXISTS `'.$C_MySQL_Name_Base.'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;');
            mysql_select_db($C_MySQL_Name_Base);
            mysql_set_charset("CP1251");
            header('Location: index.php?location=general');
            mysql_Close($link);
            exit;
        }
    mysql_select_db($C_MySQL_Name_Base);
    mysql_set_charset("CP1251");
//Определим-ка переменные + проверим
    include $_SERVER['DOCUMENT_ROOT'].'/_constant/engine.php';
    $location=$_GET['location'];
    global $c_array_location;
    if (!in_array($location, $c_array_location))
        header('Location: index.php?location=general');
    include $_SERVER['DOCUMENT_ROOT'].'/_constant/char.php';
    include $_SERVER['DOCUMENT_ROOT'].'/_api/processe_data.php';
    $day = date('j');
    if ($_GET['m']=='')
        $month = date('n');
    else{
        $month = $_GET['m'];
    }
    if ($_GET['y']=='')
        $year = date('Y');
    else{
        $year = $_GET['y'];
    }
    $now_day = date('Y-m-d');
//Если нижеследующий код выполняется, то проверка данных прошла
//Работа)
    echo '<!DOCTYPE html lang="ru" xml:lang="ru">';
    echo '<title>Календарь</title>';
    echo '<META http-equiv="content-type" content="text/html; charset=windows-1251">';
    echo '<link rel="stylesheet" href="css/calendar.css">';
    echo '<block class="text" id="hallo">Сегодня ', $day, '.', $month, '.', $year, '</block>';
    switch ($location) {
        case 'general':
//Карта-календарь на текущий месяц.
//Резиновая вёрстка.
//Рядом с названием месяца указано количество предстоящих мероприятий
//Дни с запланированными предприятиями - выделены цветом
            include $_SERVER['DOCUMENT_ROOT'].'/_constant/lang.php';
            $num_cell_after_calendar = 0;
            $count_day = date('t', mktime(0,0,0,$month,1,$year));
            $num_cell_before_calendar = date('w', mktime(0,0,0,$month,$num_day,$year));
            $name_mounth = $C_lang_month[$month - 1];
            echo '<block class="text month">';
            echo '<center><mounth onclick="calendar_click_mounth('.$month.')">', $name_mounth, '</mounth></center><br>';
            echo '<table id="month', $num_month, '"><tr>';
            for ($i = 1; $i <= ($num_cell_before_calendar); $i++)
                echo '<td> </td>';
            for ($num_day = 1; $num_day <= $count_day; $num_day++){
                echo '<td class="';
//Блок набора параметров классов
                if (date('N', mktime(0,0,0,$month,$num_day,$year))>=6)
                    echo 'free ';
                else
                    echo 'no-free ';
//огромный ИФ в котором идёт сравнение дат. Сравнение дат обычными средствами было почему-то забаговано(
                if ($year < date('Y'))
                    echo 'after ';
                else{
                    if ($year == date('Y')){
                        if ($month<date('n'))
                            echo 'after ';
                        else{
                            if ($month==date('n')){
                                if ($num_day < $day)
                                    echo 'after ';
                                if ($num_day > $day)
                                    echo 'before ';
                                if ($num_day == date('j'))
                                    echo 'yes ';
                            }
                            if ($month>date('n'))
                                echo 'before ';
                        }
                    }
                    if ($year > date('Y'))
                        echo 'before ';
                }
                echo '"><day onclick="calendar_click_day('.$num_day.')">', $num_day, '</day></td>';
                if (date('w', mktime(0,0,0,$month,$num_day,$year))==0)
                    echo '</tr><tr>';
            }
            $num_cell_after_calendar = date('N', mktime(0,0,0,$month,$num_day,$year)) - 1;
            echo '</td></tr></table>';
            echo '</block>';
        break;
        case 'new':
//Окно редактирования\создания\удаления\мероприятия
            echo '<block class="text" id="location">'.$location.'</block>';
        break;
    }

    mysql_Close($link);



  













?>