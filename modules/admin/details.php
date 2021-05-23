<?php
	include('../../config/config.php');
	
	include('../../inc/db.class.php');
	include('../../inc/sch.class.php');
	include('../../inc/useful.fns.php');
	include('../../inc/user.class.php');
	
	session_start();
	
	$session = $_SESSION['user'];
	
	if(empty($session)) {
		header('Location: ../../index.php');
	}//end if
	
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	$_SESSION['user'] = serialize($user);
	
	if($level > 1) {
		if($level == 2)
			header('Location: ../operator/index.php');
		else if($level == 3)
			header('Location: ../user/index.php');
		else
			header('Location: ../../general/logout.php');
	}//end if
	
	$rid = $_GET['rid'];
	$alert = $_GET['alert'];
	$image = "../";
	$advuser = TRUE;
	$res = $_GET['res'];
	
	$usrHTML = "<li><a href=\"../user/index.php\" class=\"ast3\">Usar</a></li>";	

	if($alert) {
		switch($alert) {
			case 1:
				$atxt = "<strong>La operaci&oacute;n se realiz&oacute; con &eacute;xito:</strong> Su comentario fue recibido, ser&aacute; publicado luego de ser revisado.";
				break;
			case 2:
				$atxt = "<strong>No se puede realizar la operaci&oacute;n:</strong> Verifique su comentario, hay campos vacios.";
				break;
			case 3:
				$atxt = "<strong>No se puede realizar la operaci&oacute;n:</strong> Sus datos no se recibieron correctamente.";
				break;
		}//end switch
	}//end if
	
	if($res) {
		$path = "../../results/".$res."/";
		ob_start();
		include($path.'salida.html');
		$resHTML = ob_get_contents();
		ob_end_clean();
	}//end if
	
	include('../modules/details.mod.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Inicio</title>
	<link href="../../css/styles.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/asld.js" type="text/javascript"></script>
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../../img/logo.png" border="0" /></div>
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
					<li><a href="users.php">Usuarios</a></li>					
					<li><a href="TM/calendar.php">Reserva</a></li>
         			 <li><a href="configp.php">Configurar</a></li>
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
						<li><a href="../../general/logout.php" class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegaci&oacute;n</h1>
					<ul>
						<li><a href="index.php" class="ast3">Inicio</a></li>
						<li><a href="users.php" class="ast3">Usuarios</a></li>
						<li>Estad&iacute;sticas</li>
						<li>Configuraci&oacute;n</li>
						<li><a href="TM/calendar.php" class="ast3">Reserva</a></li>
            <li><a href="configp.php" class="ast3">Configurar Pr&aacute;cticas</a></li>
					</ul>
					<h1 class="content_l_hst1">Opciones</h1>
					<ul>
						<li><a href="index.php?body=revisadas" class="ast3">Pr&aacute;cticas revisadas</a></li>
						<li><a href="index.php?body=revisar" class="ast3">Pr&aacute;cticas por revisar</a></li>
						<li>Nueva pr&aacute;ctica</li>
					</ul>
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
				<?php if(!$res) {?><h1 class="content_r_hst1"><?php echo $btxt; ?></h1><?php } ?>
				<div id="results_box">
					<?php echo $resHTML; ?>
				</div>
				<?php
			if($vote && VOT_CONT) {
				?>
				<div id="vote_box">
					<p class="header">Calificaci&oacute;n</p>
						<form id="vote_form" name="vote_form" method="post" action="../../utilities/updatecontribution.mod.php" enctype="multipart/form-data">
							<select name="vote" class="form_field">
								<option value="5">5 (Muy Bien)</option>
								<option value="4">4 (Bien)</option>
								<option value="3">3 (Regular)</option>
								<option value="2">2 (Mal)</option>								
							</select> 
							<input id="rid" name="rid" type="hidden" value="<?php echo $rid; ?>">
							<input id="advuser" name="advuser" type="hidden" value="<?php echo $advuser; ?>">
							<input id="page" name="page" type="hidden" value="../admin/details.php?id=<?php echo $id; ?>">
							<input id="myvote" name="myvote" type="submit" class="form_button" value="Votar">
						</form>
				</div>
				<?php
				}//end if
					if($ncomments) {
					?>
					<div id="comments_box">
					  <?php
					  	echo $comHTML;
					  ?>
					</div>
					<?php			
				}//end if
				if(COM_CONT) {
					?>
					<div id="comment_form_box">
						<h1 class="content_r_hst2">Comentarios del profesor</h1>
						<p>
							Los comentarios que emitir&aacute; ser&aacute;n vistos por el estudiante, as&iacute; como su nota.
						</p>
						<form id="comment_form" name="comment_form" method="post" action="../../utilities/updatecontribution.mod.php " enctype="multipart/form-data">
							<input id="action" name="action" type="hidden" value="new">
							<input id="id" name="id" type="hidden">
							<input id="rid" name="rid" type="hidden" value="<?php echo $rid; ?>">
							<input id="advuser" name="advuser" type="hidden" value="<?php echo $advuser; ?>">
							<input id="page" name="page" type="hidden" value="../admin/details.php?res=<?php echo $res; ?>&rid=<?php echo $rid; ?>">
							<textarea id="comment_txt" name="comment_txt" cols="68" rows="3" class="input_field"></textarea>
							<input id="comsend" name="comsend" type="button" class="form_button" value="Guardar" onclick="saveComment()" />
							<input id="comreset" name="comreset" type="reset" class="form_button" value="Nuevo" onclick="newComment()" />
						</form>
					</div>
					<?php
				}//end if
				?>
			
		    <div id="comment_form_box">
						
						<p>
							Despu&eacute;s de haber revizado la pr&aacute;ctica oprima el bot&oacute;n Revizada.
						</p>
			       <form id="rev_form" name="rev_form" method="post" action="../../utilities/updatepracticesrev.mod.php " enctype="multipart/form-data">
                
                <input id="prev" name="prev" type="hidden" value="ok">							
							
								<input id="rid" name="rid" type="hidden" value="<?php echo $rid; ?>">
								
								<input id="page" name="page" type="hidden" value="../admin/details.php?res=<?php echo $res; ?>&rid=<?php echo $rid; ?>">
								
								<input id="comsend" name="comsend" type="button" class="form_button" value="Revizada" onclick="practicesrev()" />
							
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
