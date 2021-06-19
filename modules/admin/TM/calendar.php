<?php ob_start(); ?>
<?php
include('../../inc/useful.fns.php');
include('../../inc/user.class.php');
include('../../inc/db.class.php');
include('../../config/config.php');

session_start();

$session = $_SESSION['user'];

if (empty($session)) {
	header('Location: ../index.php');
} //end if

$user = unserialize($session);
$uid = $user->getUID();
$name = $user->getName();
$login = $user->getLogin();
$mail = $user->getEMail();
$domain = $user->getDomain();
$level = $user->getPriority();

//echo $uid."\n";
//echo $level."\n";

$_SESSION['user'] = serialize($user);

$btxt = "Reserva de Laboratorio";

if ($level == 1)

	require_once 'calendar_functions.php';

if (!isset($_SESSION['calendar_show_date']))

	$_SESSION['calendar_show_date'] = date("j-n-Y", time());
else if (isset($_GET['date']))
	$_SESSION['calendar_show_date'] = $_GET['date'];
$current_date = explode("-", $_SESSION['calendar_show_date']);
$database_link = selection_of_db();

if (isset($_POST['btnDelete'])) {
	if ($_POST['btnDelete'] == "Eliminar") {
		if (isset($_POST['chkDelete'])) {
			$taskID_string = "'" . implode("','", $_POST['chkDelete']) . "'";
			$delete_tasks_query = "delete from calendar_tasks where taskid in($taskID_string)";
			mysql_query($delete_tasks_query, $database_link) or die("delete_tasks_query Failed : " . mysql_error());
		}
	}
}
if (isset($_POST['btnUpdate'])) {
	if ($_POST['btnUpdate'] == "Update") {
		if (isset($_POST['chkIsComplete'])) {
			$taskID_string = "'" . implode("','", $_POST['chkIsComplete']) . "'";
			$update_iscomplete_set_query = "update calendar_tasks set isCompleted=1 where taskid in($taskID_string)";
			mysql_query($update_iscomplete_set_query, $database_link) or die("update_iscomplete_set_query Failed : " . mysql_error());
			$update_iscomplete_unset_query = "update calendar_tasks set isCompleted=0 where id=$uid and taskid not in($taskID_string)";
			mysql_query($update_iscomplete_unset_query, $database_link) or die("update_iscomplete_unset_query Failed : " . mysql_error());
		} else {
			//update query to set all tasks for that user as incompleted
			$update_iscomplete_unset_all_query = "update calendar_tasks set isCompleted=0 where id=$uid";
			mysql_query($update_iscomplete_unset_all_query, $database_link) or die("update_iscomplete_unset_all_query Failed : " . mysql_error());
		}
		if (isset($_POST['chkIsworkrelated'])) {
			$taskID_string = "'" . implode("','", $_POST['chkIsworkrelated']) . "'";
			$update_iscomplete_set_query = "update calendar_tasks set task_workrelated=1 where taskid in($taskID_string)";
			mysql_query($update_iscomplete_set_query, $database_link) or die("update_iscomplete_set_query Failed : " . mysql_error());
			$update_iscomplete_unset_query = "update calendar_tasks set isCompleted=0 where id=$uid and taskid not in($taskID_string)";
			mysql_query($update_iscomplete_unset_query, $database_link) or die("update_iscomplete_unset_query Failed : " . mysql_error());
		} else {
			$update_iscomplete_unset_all_query = "update calendar_tasks set task_workrelated=0 where id=$uid";
			mysql_query($update_iscomplete_unset_all_query, $database_link) or die("update_iscomplete_unset_all_query Failed : " . mysql_error());
		}
	}
}
mysql_close($database_link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Reserva de Laboratorio : : Inicio</title>
	<link href="../../styles.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="../../img/aicon.gif" />

</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><a href="http://garp.fie.uclv.edu.cu" target="_blank"><img src="../../img/logo.png" border="0" /></a></div>
				<div id="header_t_r"><?php echo Date_Time(); ?></div>
			</div>
			<div id="header_b">
				<div id="header_l"></div>
				<div id="header_c">
					<h1 class="logo">SLD<span class="w_txt">WEB</span></h1>
					<h4 class="txt">Sistema de Laboratorios a Distancia</h4>
				</div>
				<div id="header_r"></div>
			</div>
		</div>
		<div id="navigator">
			<div id="nav_l"></div>
			<div id="nav_c">
				<ul>
					<li><a href="../index.php">Inicio</a></li>
					<li><a href="../../admin/users.php">Usuarios</a></li>
					<li><a href="../../admin/notavaible.php">Estad&iacute;sticas</a></li>
					<li><a href="../../admin/notavaible.php">Configuraci&oacute;n</a></li>
					<li><a href="../../admin/notavaible.php">Reserva de Laboratorio</a></li>
				</ul>
			</div>
			<div id="nav_r"></div>
		</div>
		<div id="content">
			<div id="content_l">
				<div id="content_l_t"></div>
				<div id="content_l_c">
					<h1 class="content_l_hst1">Usuario</h1>
					<ul>
						<li><strong><?php echo $name; ?></strong></li>
						<?php echo $usrHTML; ?>
						<li><a href="../../logout.php" class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegaci&oacute;n</h1>
					<ul>
						<li><a href="../index.php" class="ast3">Inicio</a></li>
						<li><a href="../../admin/users.php" class="ast3">Usuarios</a></li>
						<li>Estad&iacute;sticas</li>
						<li>Configuraci&oacute;n</li>
						<li><a href="calendar.php" class="ast3">Reserva de Laboratorio</a></li>
					</ul>
					<h1 class="content_l_hst1">Opciones</h1>
					<ul>
						<li><a href="../index.php?body=revisadas" class="ast3">Pr&aacute;cticas revisadas</a></li>
						<li><a href="../index.php?body=revisar" class="ast3">Pr&aacute;cticas por revisar</a></li>
						<li>Nueva pr&aacute;ctica</li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<h1 class="content_r_hst1"><?php echo $btxt; ?></h1>
				<div id="results_box">
					<form action='calendar.php' method='post'>
						<center>

							<table>
								<tr>
									<td colspan="4" height="50 px" align="center" valign="bottom">
										<h3>
											<?php
											$date = getdate(mktime(0, 0, 0, $current_date[1], 1, 1970));
											print "$date[month] $current_date[2]"
											?>
										</h3>
									</td>
								</tr>
								<tr>
									<td align="center">
										<a class='ast5' href="<?php $year = $current_date[2] - 1;
																print "$_SERVER[PHP_SELF]?date=$current_date[0]-$current_date[1]-$year"; ?>">A&ntilde;o Anterior</a>
									</td>
									<td align="center">
										<a class='ast5' href="<?php $month = $current_date[1] - 1;
																print "$_SERVER[PHP_SELF]?date=$current_date[0]-$month-$current_date[2]";	?>">Mes Anterior</a>
									</td>
									<td align="center">
										<a class="ast5" href="<?php $month = $current_date[1] + 1;
																print "$_SERVER[PHP_SELF]?date=$current_date[0]-$month-$current_date[2]"; ?>">Proximo Mes</a>
									</td>
									<td align="center">
										<a class="ast5" href="<?php $year = $current_date[2] + 1;
																print "$_SERVER[PHP_SELF]?date=$current_date[0]-$current_date[1]-$year"; ?>">Proximo A&ntilde;o</a>
									</td>
								</tr>
								<tr>
									<td colspan="4" height="160 px" align="center" valign="middle">
										<?php
										//display the month table
										display_month($current_date[0], $current_date[1], $current_date[2]);
										?>
									</td>
								</tr>
								<tr>
									<td colspan="4">&nbsp;</td>
								</tr>
								<tr>
									<td colspan=4>
										<table border="0" width="100%">
											<tr>
												<td align="center">
													<font face=verdana><b>Reservas para: <?php print  " $current_date[0]-$date[month]-$current_date[2]" ?>
												</td>
											</tr>
										</table>
										<br>
									</td>
								</tr>
								<tr>
									<td colspan=4>
										<?php
										//displaying tasks
										$temp_date = "$current_date[0]-$current_date[1]-$current_date[2]";
										$third_parameter = "asc"; //($_POST['selSort']) ? $_POST['selSort'] : "priority";
										display_tasks($uid, $temp_date, $third_parameter);
										?>
									</td>
								</tr>
							</table>
						</center>
					</form>
				</div>
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2009 GARP - Facultad de Ingenier&iacute;a El&eacute;ctrica<br />
			Universidad Central &quot;Marta Abreu&quot; de Las Villas.
		</div>
	</div>
</body>

</html>