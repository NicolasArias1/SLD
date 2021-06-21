<?php
//include('config/config.php');

require_once('../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;

include('../inc/db.class.php');
include('../inc/frm.class.php');
include('../inc/sch.class.php');
include('../inc/useful.fns.php');
include('../inc/user.class.php');
include('../config/config.php');

$alert = isset($_GET['alert']);
$error = explode(":", isset($_GET['alert']));

if (!SOLICIT_AUTH && !REGISTER_AUTH && $rfpage) {
	header('Location: ' . $rfpage);
	exit;
} //end if
else if (!SOLICIT_AUTH && !REGISTER_AUTH) {
	header('Location: ../index.php');
	exit;
} //end else if

if (SOLICIT_AUTH) {
	$btxt = "Solicitar";
	$type = 2;
} //end if
else if (REGISTER_AUTH) {
	$btxt = "Registrar";
	$type = 1;
} //end if

if ($alert) {
	switch ($alert) {
		case 1:
			if (SOLICIT_AUTH)
				$atxt = "La operaci&oacute;n se realiz&oacute; con &eacute;xito: <span class=\"text\">Los datos se introdujeron correctamente, si es aprobada su solicitud se le comunicar&aacute; por su correo electr&oacute;nico.</span>";
			else if (REGISTER_AUTH)
				$atxt = "La operaci&oacute;n se realizó con &eacute;xito: <span class=\"text\">Los datos se introdujeron correctamente.</span>";
			break;
		case 2:
			$efname = array('Nombre', 'Nombre de Usuario', 'EMail');
			$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">ya existe un usuario con algunos de esos datos.</span><br />Datos repetidos: <span class=\"text\">";
			for ($i = 0; $i < count($error); $i++) {
				$atxt .= $efname[$error[$i]];
				if ($i < (count($error) - 1))
					$atxt .= ", ";
				else
					$atxt .= ".";
			} //end for
			$atxt .= "</span>";
			break;
		case 3:
			$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Verifique sus datos, hay campos vacios.</span>";
			break;
		case 4:
			$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Sus datos no se recibieron correctamente.</span>";
			break;
	} //end switch
} //end if

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require_once('css/libcss.php'); ?>
	<script language="JavaScript" src="../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../js/asld.js" type="text/javascript"></script>
	<link rel="stylesheet" href="css/addusers.css">

</head>

<body>
	<div id="wrapper">
		<!-- Page Content -->
		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<?php require_once('../structure/mainHeader.php'); ?>

			<div id="content">

				<div id="content2" class="container-fluid p-0 px-lg-0 px-md-0">

					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">
								<div id="content_r" style="width:700px;border: 1px solid #cecece; border-radius: 3px; padding: 30px 100px;">

									<h1 class="content_r_hst1">Registrarse</h1>
									<?php
									if ($alert) {
									?>
										<p class="alert alert-info" style="font-size:14px;"><?php echo $atxt; ?></p>
									<?php
									} //end if
									?>
									<form id="frmuser" name="frmuser" method="post" action="../utilities/userregistration.mod.php" enctype="multipart/form-data">



										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Nombre completo:</label>
											<div class="col-sm-8 std">
												<input id="uname" name="uname" type="text" class="form-control" placeholder="Nombre completo" value="" size="30" autocomplete="off">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Nombre de usuario:</label>
											<div class="col-sm-8 std">
												<input id="ulogin" name="ulogin" type="text" class="form-control" placeholder="Nombre de usuario" value="" size="30" autocomplete="off">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Email:</label>
											<div class="col-sm-8 std">
												<input id="umail" name="umail" type="text" class="form-control" placeholder="Email" value="" size="30" autocomplete="off">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Contraseña:</label>
											<div class="col-sm-8 std">
												<input id="upassword" name="upassword" type="password" class="form-control" placeholder="Contraseña" value="" size="30" maxlength="12" autocomplete="off">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Confirmar contraseña:</label>
											<div class="col-sm-8 std">
												<input id="uconfirm" name="uconfirm" type="password" class="form-control" placeholder="Confirmar contraseña" value="" size="30" maxlength="12" autocomplete="off">
											</div>
										</div>

										<div class="form-group row secbtnGuardar">
											<input id="type" name="type" type="hidden" value="<?php echo $type; ?>" />
											<input id="save" name="save" type="button" class="btnGuardar" value="Enviar" onClick="saveRegistration()" />
										</div>

									</form>



								</div>
							</div>
						</div>

					</div>
					<!-- /.container-fluid -->

				</div>



			</div>
		</div>
		<!-- /#page-content-wrapper -->

	</div>
</body>

<?php require_once('js/libjs.php'); ?>


</html>



<!--

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Inicio</title>
    <link href="../css/styles.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../js/asld.js" type="text/javascript"></script>
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../img/logo.png" border="0" /></div>
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
					<li><a href="theory.php">Teor&iacute;a</a></li>
					<li><a href="practices.php">Pr&aacute;cticas</a></li>
					<li><a href="platform.php">Plataforma</a></li>					
				</ul>
			</div>
			<div id="nav_r"></div>
		</div>
		<div id="content">

			<div id="content_r">
				<?php
				if ($alert) {
				?>
						<p class="alert"><?php echo $atxt; ?></p>
						<?php
					} //end if
						?>
				<form id="frmuser" name="frmuser" method="post" action="../utilities/userregistration.mod.php" enctype="multipart/form-data">
					<table width="67%" height="181" cellpadding="0" cellspacing="0" class="form">
					  <tr>
							<td width="148"><div align="left"><img src="../img/aarrow.gif" alt="Obligatorio" /> Nombre completo:</div></td>
						  <td width="249">						    <input id="uname" name="uname" type="text" class="input_field" size="30" autocomplete="off" />						    </td>
					  </tr>
						<tr>
						  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> Nombre de usuario:</td>
					    <td>					      <input id="ulogin" name="ulogin" type="text" class="input_field" size="30" autocomplete="off" />					      </td>
					  </tr>
					  <tr>
						  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> EMail:</td>
					    <td>					      <input id="umail" name="umail" type="text" class="input_field" size="30" autocomplete="off" />					      </td>
					  </tr>
					  <tr>
						  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> Contrase&ntilde;a:</td>
					    <td>					      <input id="upassword" name="upassword" type="password" class="input_field" size="30" maxlength="12" autocomplete="off" />					      </td>
					  </tr>
					  <tr>
						  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> Confirmar:</td>
					    <td>					      <input id="uconfirm" name="uconfirm" type="password" class="input_field" size="30" maxlength="12" autocomplete="off" />					      </td>
					  </tr>
					  <tr>
						  <td><input id="type" name="type" type="hidden" value="<?php echo $type; ?>" /></td>
					    <td><input id="save" name="save" type="button" class="input_button" value="Guardar" onClick="saveRegistration()" /></td>
					  </tr>
				  </table>
				</form>
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
 -->