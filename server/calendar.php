<?php
    include $_SERVER['DOCUMENT_ROOT'].'/_constant/mysql.php';
    global $C_MySQL_Host, $C_MySQL_login, $C_MySQL_Password, $C_MySQL_Name_Base;
    $link = mysql_connect($C_MySQL_Host, $C_MySQL_login, $C_MySQL_Password)or die(mysql_error());
    mysql_select_db($C_MySQL_Name_Base);
    mysql_set_charset("CP1251");
/*****************************
 * ��������� ������ �� ���������� ������
 *     1. ��������� ���������� (�������� ��������� � ����)
 *     2. �����������
 *     3. ������������� �������.
*****************************/
//��������� ����������
    echo '<META http-equiv="content-type" content="text/html; charset=windows-1251">';
    echo '|destr|';//�����������
    echo '���, %UserName%!';//%UserName% - ��� �� ���������� �����-����, � ����������)
/*****************************
 * ������������ �������� ������ �� �������
 *     1. ���� ���������� � ��������������� ������� �� ��������� ����
 *     2. ���� ���� �� ����� ��� �������, �� �������� � ����� ����� �������� �������
*****************************/
    mysql_Close($link);



?>