<?php
    /*****************************
     * Служеюная инфа
     *     1. Код форматируется сервисом http://beta.phpformatter.com со след параметрами
     *         a. Indentation style: PEAR style
     *         b. Indent with: Spaces
     *         c. Starting indentation: 4
     *         d. Indentation: 4
     *         e. птички везде кроме "Remove all comments" и "Remove empty lines"
     *     2. Каждый более-менее крупный логическицельный блок комментируется. Хорошие имена функций и переменных это одно, но комменты не помешают)
     *         a. Думаю никто не будет против даже мата в комментах :)
     *     3. Приятного кодинга, коллега!
     *****************************/
    include $_SERVER[ 'DOCUMENT_ROOT' ] . '/_constant/mysql.php';
    global $C_MySQL_Host, $C_MySQL_login, $C_MySQL_Password, $C_MySQL_Name_Base;
    $link = mysql_connect( $C_MySQL_Host, $C_MySQL_login, $C_MySQL_Password ) or die( mysql_error() );
    if ( !mysql_select_db( $C_MySQL_Name_Base, $link ) )
        if ( mysql_errno( $link ) == 1049 ) { //Если таблицы не существует, то создаётся новая
            mysql_query( 'CREATE DATABASE IF NOT EXISTS `' . $C_MySQL_Name_Base . '` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;' );
            mysql_select_db( $C_MySQL_Name_Base );
            mysql_set_charset( "CP1251" );
            header( 'Location: index.php?location=general' );
            mysql_Close( $link );
            exit;
        }
    mysql_select_db( $C_MySQL_Name_Base );
    mysql_set_charset( "CP1251" );
    //Блок определения переменных и проверки входящих данных.
    include $_SERVER[ 'DOCUMENT_ROOT' ] . '/_constant/engine.php';
    include $_SERVER[ 'DOCUMENT_ROOT' ] . '/_constant/char.php';
    include $_SERVER[ 'DOCUMENT_ROOT' ] . '/_api/processe_data.php';
    $location = $_GET[ 'location' ];
    global $c_array_location;
    if ( !in_array( $location, $c_array_location ) )
        header( 'Location: index.php?location=general' );
    //TODO необходимо дописать проверку входящих данных
    $day = date( 'j' );
    if ( $_GET[ 'm' ] == '' )
        $month = date( 'n' );
    else {
        $month = $_GET[ 'm' ];
    }
    if ( $_GET[ 'y' ] == '' )
        $year = date( 'Y' );
    else {
        $year = $_GET[ 'y' ];
    }
    $now_day = date( 'Y-m-d' );
    //Вывод. Если ниже следующий кож выполняется, то проверка ВСЕХ данных завершена
    echo '<!DOCTYPE html lang="ru" xml:lang="ru">';
    echo '<title>Календарь</title>';
    echo '<META http-equiv="content-type" content="text/html; charset=windows-1251">';
    echo '<link rel="stylesheet" href="css/calendar.css">';
    echo '<script src="js/jquery.min.js"></script>';
    echo '<script src="js/calendar.js"></script>';
    echo '<block class="text" id="hallo">Сегодня ', $day, '.', $month, '.', $year, '</block>';
    /*****************************
     * Задумано 3 "страницы"
     *     1. general Отображение месяца. (От 28 до 31 дня)
     *     2. map Отображение года (списком выводится 12 месяцев, разными стилями указывается текущий, 
     *              прошедший и ещё не наступивший. В скобках указано количество событий)
     *     3. day Отображение дня. (Отображаем все запланированный события на этот день, списком.
     *              Если событие одно, то сразу редиректим на него.)
     *****************************/
    switch ( $location ) {
        case 'general':
            include $_SERVER[ 'DOCUMENT_ROOT' ] . '/_constant/lang.php';
            $num_cell_after_calendar  = 0;
            $num_cell_before_calendar = date( 'w', mktime( 0, 0, 0, $month, $num_day, $year ) );
            //Эти две переменный содержат количество пустых ячеек в начале календаря.
            //Вроде, работает. Менять не желательно.
            $count_day                = date( 't', mktime( 0, 0, 0, $month, 1, $year ) );
            $name_mounth              = $C_lang_month[ $month - 1 ];
            echo '<block class="text month">';
            echo '<center><mounth onclick="calendar_click_mounth(' . $month . ')">', $name_mounth, '</mounth></center><br>';
            echo '<table id="month', $num_month, '"><tr>';
            for ( $i = 1; $i <= ( $num_cell_before_calendar ); $i++ )
                echo '<td> </td>';
            for ( $num_day = 1; $num_day <= $count_day; $num_day++ ) {
                echo '<td class="'; { // В этом блоке через множество условных операторов на вывод подаются названия классов
                    if ( date( 'N', mktime( 0, 0, 0, $month, $num_day, $year ) ) >= 6 )
                        echo 'free ';
                    else
                        echo 'no-free ';
                    //огромный ИФ в котором идёт сравнение дат. Сравнение дат обычными средствами было почему-то забаговано(
                    if ( $year < date( 'Y' ) )
                        echo 'after ';
                    else {
                        if ( $year == date( 'Y' ) ) {
                            if ( $month < date( 'n' ) )
                                echo 'after ';
                            else {
                                if ( $month == date( 'n' ) ) {
                                    if ( $num_day < $day )
                                        echo 'after ';
                                    if ( $num_day > $day )
                                        echo 'before ';
                                    if ( $num_day == date( 'j' ) )
                                        echo 'yes ';
                                }
                                if ( $month > date( 'n' ) )
                                    echo 'before ';
                            }
                        }
                        if ( $year > date( 'Y' ) )
                            echo 'before ';
                    }
                }
                echo '"><day onclick="calendar_click_day(' . $num_day . ')">', $num_day, '</day></td>';
                if ( date( 'w', mktime( 0, 0, 0, $month, $num_day, $year ) ) == 0 ) //После того, как отрисовали воскресенье переходим на новую строку
                    echo '</tr><tr>';
            }
            $num_cell_after_calendar = date( 'N', mktime( 0, 0, 0, $month, $num_day, $year ) ) - 1;
            echo '</td></tr></table>';
            echo '</block>';
            break;
        case 'day':
            break;
    }
    mysql_Close( $link );
?>