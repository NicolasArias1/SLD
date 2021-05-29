<?php
include('../config/config.php');

include('../inc/db.class.php');
include('../inc/adldap.class.php');
include('../inc/useful.fns.php');
include('../inc/user.class.php');

$prevpage = $_SERVER['HTTP_REFERER'];

if ($prevpage == '') {
	header('Location: ../index.php');
	exit;
} //end if

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
	$login = $_POST['login'];
	$password = $_POST['passwd'];
	$domain = $_POST['domain'];
	$date = Date_Num();

	if ($login && $password && $domain) {
		//Creando objeto SQL
		$sql = new SQL();

		//Conectando con el servidor
		$sql->SQLConnection();

		//Creando objeto User
		$user = new UserSession();

		//Autentificaci�n por LDAP Server		  			
		if ($domain != "db" && LDAP_AUTH) {
			//Creando objeto LDAP
			$ldap = new adLDAP($options);

			//Autentificando datos
			$isUser = $ldap->authenticate($domain, $login, $password);

			$usrData = $ldap->user_info($login);

			//Cerrando conexi�n
			$ldap->__destruct();

			if ($isUser) {
				session_start();

				$samname = $usrData[0]["samaccountname"][0];
				$name = tildes(xmlspecialchars($usrData[0]["displayname"][0]));
				$mail = $usrData[0]["mail"][0];
				$memberof = $usrData[0]["memberof"][0];
				$department = $usrData[0]["department"][0];

				//Creando consulta
				$query = "SELECT id, name, password, mail, level FROM sld_users WHERE ((login='$login') AND (domain='$domain'))";

				//Ejecutando consulta y creando objeto Record
				$results = new RecordSet($sql->SQLQuery($query));

				if ($sql->count != 0) {
					if ($name && $name != $results->Celd(0, 'name')) {
						//Creando consulta
						$query = "UPDATE sld_users SET name='$name' WHERE ((id=" . $results->Celd(0, 'id') . ") AND (login='$login') AND (domain='$domain'))";

						//Creando consulta
						$sql->SQLQuery($query);
					} //end if

					if ($mail && $mail != $results->Celd(0, 'mail')) {
						//Creando consulta
						$query = "UPDATE sld_users SET mail='$mail' WHERE ((id=" . $results->Celd(0, 'id') . ") AND (login='$login') AND (domain='$domain'))";

						//Creando consulta
						$sql->SQLQuery($query);
					} //end if

					if (!$name) {
						$name = $results->Celd(0, 'name');
					} //end else if

					$uid = $results->Celd(0, 'id');


					

					$user->setUID($uid);
					$user->setName($name);
					$user->setLogin($login);
					$user->setEmail($mail);
					$user->setPriority($results->Celd(0, 'level'));
					$user->setDomain($domain);

					include('../utilities/setoutline.mod.php');
					include('../utilities/setonline.mod.php');
					//include('modules/writelog.mod.php');
				} //end if count
				else { //su profile no se ha guardado
					if (!$name)
						$name = $login;

					if (!$mail)
						$mail = $login . "@" . $strdn;

					//Creando consulta
					$query = "INSERT INTO sld_users (name, login, domain, mail, level, type, status, date, time, ip)
											VALUES ('$name', '$login', '$domain', '$mail', 3, 3, 'online', NOW(), NOW(), '" . $_SERVER['REMOTE_ADDR'] . "')";

					//Creando consulta
					$sql->SQLQuery($query);

					//Tomando el ID resultante de la operaci�n
					$uid = $sql->SQLInsertID();

					$user->setUID($uid);
					$user->setName($name);
					$user->setLogin($login);
					$user->setEmail($mail);
					$user->setPriority(3);
					$user->setDomain($domain);

					include('../utilities/setoutline.mod.php');
					//include('modules/writelog.mod.php');
				} //end else count
			
				if ($uid) {
					$urfolder = dirname(__FILE__) . "/results/" . $uid;

					if (!is_dir($urfolder)) {
						$urfolder = addslashes($urfolder);

						mkdir($urfolder, 0777);
					} //end if

					$_SESSION['user'] = serialize($user);
				
				
					header('Location: ../modules/user/index.php');
				} //end if
				else
					header('Location: ../index.php');
			} //end if isUser
			else { //no existe ese usuario 
				header('Location: ../index.php');
			} //end else isUser
		} //end if domain!=db
		else if (
			$domain == "db"
			//&& DB_AUTH
		) {
			//print_r(DB_AUTH);
			//print_r(die);
			//Autantificaci�n por Base de Datos.

			// Obtenemos la clave del usuario
			$query = "SELECT id, name, mail, level, password FROM sld_users WHERE login='$login'";
			$results = new RecordSet($sql->SQLQuery($query));

			// Verificamos que el usuario existe en la bdd
			if ($sql->count == 0) {
				echo '<script type="text/javascript">
						window.location.href="../index.php";
						alert("Usuario incorrecto");
					</script>';
			} else {
				$db_password = $results->Celd(0, 'password');

				// Verificamos si la contraseña es correcta
				if (!password_verify($password, $db_password)) {
					echo '<script type="text/javascript">
							window.location.href="../index.php";
							alert("Contraseña incorrecta");
						</script>';
				}else{
					session_start();

					$uid = $results->Celd(0, 'id');
					$name = $results->Celd(0, 'name');
					$mail = $results->Celd(0, 'mail');
					$level = $results->Celd(0, 'level');

					$user->setUID($uid);
					$user->setName($name);
					$user->setLogin($login);
					$user->setEmail($mail);
					$user->setPriority($level);
					$user->setDomain($domain);

					include('../utilities/setoutline.mod.php');
					include('../utilities/setonline.mod.php');
					//include('modules/writelog.mod.php');

					if ($uid) {
						$_SESSION['user'] = serialize($user);
						header('Location: ../modules/user/index.php');
					}
					else {
						header('Location: ../index.php');
					}
				}
			}
		} //end else domain db

		//Cerrando conexi�n
		$sql->SQLClose();
	} //end if login && password
	else {
		header('Location: ../index.php');
	} //end else login && password
} //end if POST
else {
	header('Location: ../index.php');
}//end else

?>