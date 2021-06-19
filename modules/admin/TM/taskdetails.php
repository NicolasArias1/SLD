<?php ob_start();?>

<?php
	include('../../inc/useful.fns.php');
	include('../../inc/user.class.php');
	
	session_start();
	
	$session = $_SESSION['user'];

	if(empty($session)) {
		header('Location: ../index.php');
	}//end if
	
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	$_SESSION['user'] = serialize($user);
	
	$btxt = "Reserva de Laboratorio";
	
	
?>
<?php


// Copyright 2004 Time Management  http://schedulingmanagement.com
// This is 100% Free Software, you have not resell or redistribute this software.

if(isset($_GET['todaysdate']))
{
	$display_date=$_GET['todaysdate'];
	$date=$_GET['todaysdate'];
}
	if(!empty($_POST))
	{
	if ($_POST['btnSave']=='Editar')
	{
		require_once 'mysqlfunctions.php';
		$database_link = selection_of_db();
		$date = strtotime($_POST['txtStartTime']);
		$date=date("Y-m-d",$date);
		$time_units = explode(":", trim($_POST['txtStartTime']) );
		$hours = $time_units[0];
		$mins = $time_units[1];
		if( $_POST['startAMPM'] == 'AM' && $hours == 12) {
		   $hours = "00";
		}
		if( $_POST['startAMPM'] == 'PM' && $hours != 12) {
		   $hours += 12;
		}
		$newStartDateTime = "$date $hours:$mins:00";
		$time_units = explode(":", trim($_POST['txtEndTime']) );
		$hours = $time_units[0];
		$mins = $time_units[1];
		if( $_POST['endAMPM'] == 'AM' && $hours == 12) {
		   $hours = "00";
		}
		if( $_POST['endAMPM'] == 'PM' && $hours != 12) {
		   $hours += 12;
		}
		$newEndDateTime = "$date $hours:$mins:00";
		if((!empty($_POST['txtStartTime']))&&(!empty($_POST['txtEndTime'])))
			$update_task_query = "update calendar_tasks set id=".$uid.",description='$_POST[txtDescription]', startdatetime='$newStartDateTime', enddatetime='$newEndDateTime', priority='$_POST[selPriority]' where taskid=$_POST[modify_taskid]";
		else if(!empty($_POST['txtStartTime']))
			$update_task_query = "update calendar_tasks set id=".$uid.",description='$_POST[txtDescription]', startdatetime='$newStartDateTime', enddatetime=NULL, priority='$_POST[selPriority]' where taskid=$_POST[modify_taskid]";
		mysql_query($update_task_query, $database_link) or die("Query Failed : " . mysql_error());
		header("Location: calendar.php");	
		mysql_close($database_link);
		exit;
	}
	elseif ($_POST['btnSave']=='Aceptar')
	{
		require_once 'mysqlfunctions.php';
		$database_link = selection_of_db();
		$time_units = explode(":", trim($_POST['txtStartTime']) );
		$hours = $time_units[0];
		$mins = $time_units[1];
		if( $_POST['startAMPM'] == 'AM' && $hours == 12) {
		   $hours = "00";
		}
		if( $_POST['startAMPM'] == 'PM' && $hours != 12) {
		   $hours += 12;
		}
		$today= getdate(); 
		$month = $today['mon']; 
		$mday = $today['mday']; 
		$year = $today['year'];
		$sdate=strftime($year. "-".$month ."-". $mday);		
		$newStartDateTime =$sdate." " .$hours.":".$mins.":"."00"; //"$_POST[txtDate] $hours:$mins:00";
		$time_units = explode(":", trim($_POST['txtEndTime']) );
		$hours = $time_units[0];
		$mins = $time_units[1];
		if( $_POST['endAMPM'] == 'AM' && $hours == 12) {
		   $hours = "00";
		}
		if( $_POST['endAMPM'] == 'PM' && $hours != 12) {
		   $hours += 12;
		}
		$today= getdate(); //$_POST['txtDate'];
		$month = $today['mon']; 
		$mday = $today['mday']; 
		$year = $today['year'];
		$sdate=strftime($year. "-".$month ."-". $mday);
		$newEndDateTime = $sdate." " .$hours.":".$mins.":"."00"; //"$_POST[txtDate] $hours:$mins:00";

		
		if((!empty($_POST['txtStartTime']))&&(!empty($_POST['txtEndTime'])))
			$insert_task_query = "insert into calendar_tasks values ('',".$uid.",'','".$_POST['txtDescription']."','".$_POST['txtDate']."','".$newStartDateTime ."','".$newEndDateTime."','$_POST[selPriority]','0','$_POST[workrelated]')";
		else if(!empty($_POST['txtStartTime']))
			$insert_task_query = "insert into calendar_tasks values ('',".$uid.",'','".$_POST['txtDescription']."','".$_POST['txtDate']."','".$newStartDateTime ."',NULL,'$_POST[selPriority]','0','$_POST[workrelated]')";
		else
			$insert_task_query = "insert into calendar_tasks values ('',".$uid.",'','".$_POST['txtDescription']."','".$_POST['txtDate']."',NULL,NULL,'$_POST[selPriority]','0','$_POST[workrelated]')";
	

		mysql_query($insert_task_query, $database_link) or die("Query Failed : " . mysql_error());
		header("Location: calendar.php");
		mysql_close($database_link);
		die();
	}
	}
	if(!empty($_GET))
	{
	if (isset($_GET['taskid']))
	{
		require_once 'calendar_functions.php';
		$database_link = selection_of_db();
		$select_task_query = "select entryDate,DATE_FORMAT(startdatetime,'%Y-%m-%d') as Start_Date, description, TIME_FORMAT(startdatetime,'%h:%i') as Start_Time , TIME_FORMAT(enddatetime,'%h:%i') as End_Time, priority, TIME_FORMAT(startdatetime, '%H') as start_hour, TIME_FORMAT(enddatetime, '%H') as end_hour from calendar_tasks where taskid like '$_GET[taskid]'";
		$result = mysql_query($select_task_query, $database_link) or die("Query Failed : " . mysql_error());
		$task_row = mysql_fetch_array($result);
		$date = strtotime($task_row['entryDate']);
		$date=date("d M Y",$date);
		mysql_close($database_link);
		
	}
	else
	{
		$array_date = explode("-",$_SESSION['calendar_show_date']);
		$date="$array_date[2]-$array_date[1]-$array_date[0]";
	}

		$display_date=$date;//("d M Y",strtotime($date));
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Reserva de Laboratorio : : Inicio</title>
  <link href="../../styles.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="../../img/aicon.gif" />
  <script language='javascript'>

			function validate()
			{
				if((checkForBlank(document.forms[0].txtDescription, "Description")))
					return false;
				else
					return true;
			}
		</script>
	
</head>

<body onload='document.forms[0].txtDescription.focus();' leftmargin=0 topmargin=0>
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
					<li><a href="../../user/users.php">Usuarios</a></li>
					<li><a href="../../user/notavaible.php">Estad&iacute;sticas</a></li>
					<li><a href="../../user/notavaible.php">Configuraci&oacute;n</a></li>
					<li><a href="../../user/notavaible.php">Reserva de Laboratorio</a></li>
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
						<li><a href="../../user/users.php" class="ast3">Usuarios</a></li>
						<li>Estad&iacute;sticas</li>
						<li>Configuraci&oacute;n</li>
						<li><a href="TM/calendar.php" class="ast3">Reserva de Laboratorio</a></li>
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
					<form action="taskdetails.php" method = "post" onsubmit="return validate();">
					<!-- hidden control to store taskid -->

						<input type="hidden" name="modify_taskid" value='<?php print $_GET['taskid']?>'>
						<table border="0" align="left" valgin="top" cellpadding="3">
							
							<tr>
								<td colspan=4>
									<table border="0" width="100%" cellspacing=6>
										<tr>
											<td align="right"><font face=verdana><b>Fecha:</b>&nbsp;&nbsp;&nbsp;</td>
											<td align="left">
												<!-- hidden control to store currently selected date -->
												<input type="hidden" name="txtDate" value='<?php print $date;?>'>
												<input type="text" name="" class="textclass" readonly value='<?php print $display_date;?>'>
											</td>
											</tr>
											<tr>
											<td align="right"><font face=verdana><b>Estaci&oacute;n:</b>&nbsp;&nbsp;&nbsp;</td>
											<td align="left">
												<select name="selPriority">
													<option value="MotorCD_UCLV" <?php if (isset($_POST['priority']))if($task_row['priority']=="MotorCD_UCLV") print "selected"; ?>>MotorCD UCLV</option>
													<option value="Brazo_Manipulador_ASEA" <?php if (isset($_POST['priority']))if ($task_row['priority']=="Brazo_Manipulador_ASEA") print "selected"; ?>>Brazo Manipulador ASEA</option>
													<option value="Sistema_Termico_UPM" <?php if (isset($_POST['priority']))if ($task_row['priority']=="Sistema_Termico_UPM") print "selected"; ?>>Sistema Termico UPM</option>
													<option value="MotorCD_UPM" <?php if (isset($_POST['priority']))if ($task_row['priority']=="MotorCD_UPM") print "selected"; ?>>MotorCD UPM</option>
												</select>
											</td>
											</tr>		
																					
										<tr>
											<td align="right"><font face=verdana><b>Descripci&oacute;n:</b>&nbsp;&nbsp;&nbsp;</td>
											<td align="left" colspan=3><textarea name="txtDescription" rows=2 cols=42><?php if (isset($task_row['description']))print "$task_row[description]";?></textarea></td>
										</tr>
										<tr>
											<td align="right"><font face=verdana><b>Inicia:</b>&nbsp;&nbsp;&nbsp;</td>
											<td align="left" valign="middle">
												<input type="textbox" class="textclass" name="txtStartTime" size=5 maxlength=5 value='<?php if(isset($task_row['Start_Time'])) print "$task_row[Start_Time]";?>'>
												<select name="startAMPM">
													<option value="AM" <?php if(isset($task_row['start_hour'])) if($task_row['start_hour'] < 12) print "selected"; ?>>AM</option>
													<option value="PM" <?php if(isset($task_row['start_hour'])) if($task_row['start_hour'] > 11) print "selected"; ?>>PM</option>
												</select>
												<br>
												(<b>hh:mm</b> format)
											</td>
										</tr>	
											<td align="right"><font face=verdana><b>Termina:</b>&nbsp;&nbsp;&nbsp;</td>
											<td align="left">
												<input type="textbox" class="textclass" name="txtEndTime" size=5 maxlength=5 value='<?php if(isset($task_row['End_Time'])) print "$task_row[End_Time]";?>'>
												<select name="endAMPM">
													<option value="AM" <?php if(isset($task_row['end_hour']))if($task_row['end_hour'] < 12) print "selected"; ?>>AM</option>
													<option value="PM" <?php if(isset($task_row['end_hour']))if($task_row['end_hour'] > 11) print "selected"; ?>>PM</option>
												</select>
												<br>
												(<b>hh:mm</b> format)
											</td>
										</tr>
										<tr><td>&nbsp;</td></tr>

										<tr>
											
											<td align="center" colspan=4><input type="submit" class="input_button" name="btnSave" value="<?php if (isset($_GET['taskid'])) print "Editar"; else print "Aceptar"; ?>">
											<input type="button" class="input_button" name="btnBack" value='Atras' onclick="javascript:history.back()"></td>
											
										</tr>
									</table>
								</td>
							</tr>
						</table>
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
