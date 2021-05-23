<?php

	require_once 'calendar_config.php';
	function selection_of_db()
	{
		//global variable declaration
		global $host, $user_name, $password, $database_name;
		//getting link of the MySQL connection
		$link = mysql_connect($host, $user_name, $password) or die("Could not connect : ".mysql_error());
		mysql_select_db($database_name, $link) or die("Could not find database on ".$host." : ".mysql_error());
		return $link;
	}
?>