<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ajax_form = "localhost";
$database_ajax_form = "web36db2";
$username_ajax_form = "root";
$password_ajax_form = "";
$ajax_form = mysql_pconnect($hostname_ajax_form, $username_ajax_form, $password_ajax_form) or trigger_error(mysql_error(),E_USER_ERROR); 
?>