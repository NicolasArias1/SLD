<?php
	//Variables de conxion con MySQL server
	define("DB_SERVER", "localhost");
	define("DB_NAME", "web36db2");
	//define("DB_USER", "web36u2");
	//define("DB_PASSWD", "kg94n7g93");
	define("DB_USER", "root");
	define("DB_PASSWD", "");
	
	//Variables de conexion con LDAP server
	//define("LDAP_SERVER", "10.12.1.1");
	//define("LDAP_PORT", "389");
	//define("LDAP_DN", "DC=uclv,DC=edu,DC=cu");
	
	//Variables de autentificacion
	$db = 1;
	$nt = 1;
	define("REGISTER_AUTH", 1);
	define("SOLICIT_AUTH", 0);
	//$domains = array("uclv", "db");
	$domains = array("db");
?>