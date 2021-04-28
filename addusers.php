<?php
	//include('config/config.php');
	
	include('inc/db.class.php');
	include('inc/frm.class.php');
	include('inc/sch.class.php');
	include('inc/useful.fns.php');
	include('inc/user.class.php');
	
	$alert = $_GET['alert'];
	$error = explode(":", $_GET['error']);
	
	if(!SOLICIT_AUTH && !REGISTER_AUTH && $rfpage) {
		header('Location: '.$rfpage);
		exit;
	}//end if
	else if(!SOLICIT_AUTH && !REGISTER_AUTH) {
		header('Location: index.php');
		exit;
	}//end else if
	
	if(SOLICIT_AUTH) {
		$btxt = "Solicitar";
		$type = 2;
	}//end if
	else if(REGISTER_AUTH) {
		$btxt = "Registrar";
		$type = 1;
	}//end if
	
	if($alert) {
		switch($alert) {
			case 1:
				if(SOLICIT_AUTH)
					$atxt = "La operaci&oacute;n se realiz&oacute; con &eacute;xito: <span class=\"text\">Los datos se introdujeron correctamente, si es aprobada su solicitud se le comunicar&aacute; por su correo electr&oacute;nico.</span>";
				else if(REGISTER_AUTH)
					$atxt = "La operaci&oacute;n se realizó con &eacute;xito: <span class=\"text\">Los datos se introdujeron correctamente.</span>";
				break;
			case 2:
				$efname = array('Nombre', 'Nombre de Usuario', 'EMail');
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">ya existe un usuario con algunos de esos datos.</span><br />Datos repetidos: <span class=\"text\">";
				for($i=0; $i < count($error); $i++) {
					$atxt .= $efname[$error[$i]];
					if($i < (count($error)-1))
						$atxt .= ", ";
					else
						$atxt .= ".";
				}//end for
				$atxt .= "</span>";
				break;
			case 3:
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Verifique sus datos, hay campos vacios.</span>";
				break;
			case 4:
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Sus datos no se recibieron correctamente.</span>";
				break;
		}//end switch
	}//end if
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Inicio</title>
    <link href="styles.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/asld.js" type="text/javascript"></script>
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="img/logo.png" border="0" /></div>
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
					<li><a href="index.php">Inicio</a></li>
					<li><a href="theory.php">Teor&iacute;a</a></li>
					<li><a href="practices.php">Pr&aacute;cticas</a></li>
					<li><a href="platform.php">Plataforma</a></li>					
				</ul>
			</div>
			<div id="nav_r"></div>
		</div>
		<div id="content">
			<div id="content_l">
				<div id="content_l_t"></div>
				<div id="content_l_c">
					<form action="login.php" method="post" enctype="multipart/form-data">
						<h1 class="content_l_hst1">Autentificaci&oacute;n</h1>
						<div class="input_celd">Nombre de usuario<br />
						  <input name="login" type="text" size="15" class="input_field" />
						</div>
						<div class="input_celd">Contrase&ntilde;a<br />
						  <input name="passwd" type="password" size="15" class="input_field" />
						</div>
						<div style="display:none;" class="input_celd">Dominio<br />
						  <select name="domain" id="domain" class="input_field">						    
						    <option>db</option>
					    </select>
						</div>
						<div class="input_celd">
						  <input type="submit" name="Submit" value="Enviar" class="input_button" />
						</div>
					</form>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<?php
					if($alert) {
						?>
						<p class="alert"><?php echo $atxt; ?></p>
						<?php
					}//end if
				?>
				<form id="frmuser" name="frmuser" method="post" action="modules/userregistration.mod.php" enctype="multipart/form-data">
					<table width="67%" height="181" cellpadding="0" cellspacing="0" class="form">
					  <tr>
							<td width="148"><div align="left"><img src="img/aarrow.gif" alt="Obligatorio" /> Nombre completo:</div></td>
						  <td width="249">						    <input id="uname" name="uname" type="text" class="input_field" size="30" autocomplete="off" />						    </td>
					  </tr>
						<tr>
						  <td><img src="img/aarrow.gif" alt="Obligatorio" /> Nombre de usuario:</td>
					    <td>					      <input id="ulogin" name="ulogin" type="text" class="input_field" size="30" autocomplete="off" />					      </td>
					  </tr>
					  <tr>
						  <td><img src="img/aarrow.gif" alt="Obligatorio" /> EMail:</td>
					    <td>					      <input id="umail" name="umail" type="text" class="input_field" size="30" autocomplete="off" />					      </td>
					  </tr>
					  <tr>
						  <td><img src="img/aarrow.gif" alt="Obligatorio" /> Contrase&ntilde;a:</td>
					    <td>					      <input id="upassword" name="upassword" type="password" class="input_field" size="30" maxlength="12" autocomplete="off" />					      </td>
					  </tr>
					  <tr>
						  <td><img src="img/aarrow.gif" alt="Obligatorio" /> Confirmar:</td>
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
