<?php
	include('../../../config/config.php');
	include('../../../inc/db.class.php');
	include('../../../inc/sch.class.php');
	include('../../../inc/useful.fns.php');
	include('../../../inc/user.class.php');
	
	session_start();
	
	$session = $_SESSION['user'];

	if(empty($session)) {
		header('Location: ../../../index.php');
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
			header('Location: ../../operator/index.php');
		else if($level == 3)
			header('Location: ../../user/index.php');
		else
			header('Location: ../../../logout.php');
	}//end if
	
	$usrHTML = "<li><a href=\"../../user/index.php\" class=\"ast3\">Usar</a></li>";
	
	$btxt = "Servicio Pr&aacute;cticas Asistidas";
?>
<?php
	// Previo a todo esto, va el c�digo de Iv�n, referente a funciones de matlab, fecha actual etc, de las cuales no se dispon�a
	// a la hora de implementar este c�digo
	 $seleccionada=$_POST["seleccionada"]; // Se recoge el nombre de la practica seleccionada
	 $realSimulada=$_POST["realSimulada"];
		
	switch ($seleccionada)
	{
	case "1":
	$nombreImagen="sist_term.JPG";
	$valorSeleccionada="1";
	$nombreSeleccionada="Motor de corriente directa UCLV";
	$file = 'template_termicos.m';
	break;
	case "2":
	$nombreImagen="motor_pid.JPG";
	$valorSeleccionada="2";
	$nombreSeleccionada="Brazo manipulador ASEA";
	break;
	case "3":
	$valorSeleccionada="3";
	$nombreSeleccionada="Sistema T�rmico UPM";
	break;
	case "4":
	$valorSeleccionada="4";
	$nombreSeleccionada="Motor de corriente directa UPM";
	break;
	}
	
	$seleccionada2=$_POST["select2"];	// Tipos de par�metro que se han a�adido
	$numParametros=$_POST["numParametros"];	 // numero total de par�metros
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<script language="javascript" type="text/javascript">
// Llamada a las funciones de php para la edicion de todos los ficheros de matlab y simulink relacionados con la practica
// por medio de c�digo php
function reemplazarParams()
{
  //Location.url = 'funcionesPhp.php'; 
} 
function cargarValoresDefecto(){
		/*alert(oldHTML);
		var newHTML = "<span style='color:#ffffff'>" + oldHTML + "</span>";
		document.getElementById('texto2').innerHTML = newHTML;*/
		
		
		//document.getElementById("texto").innerHTML=texto1;

}

</script>

		
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Teor&iacute;a</title>
  <link href="../../../css/styles.css" rel="stylesheet" type="text/css" />
</head>
	<body>
	<div id="page">
	<?php
	include 'funcionesPhp.php';
	
	?>
	<script>
	// Funcion javascript que hace una llamada a una funcion php para tratar el fichero .m
	function reemplazarParams(){
	//var variableJscript = "<? echo reemplazarParams()?>";
	//document.write("<br>llamada a funcion Php desde Javascript : "+variableJscript);

	}
	
	function cambiarClass(){
		document.getElementById("texto").class="";
		document.getElementById("texto").readonly="readonly";
	}
	
	function insertEnBd(){
		insertarPracticaEnBD();
	}
	
	</script>
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
						<li><a href="../../user/index.php">Inicio</a></li>
						<li><a href="../../user/theory.php">Teor&iacute;a</a></li>
						<li><a href="../../user/practices.php">Pr&aacute;cticas</a></li>
						<li><a href="../../user/platform.php">Plataforma</a></li>					
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
						<li><?php echo $name; ?></li>
						<?php echo $usrHTML; ?>
						<li><a href="../../../general/logout.php" class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegaci&oacute;n</h1>
					<ul>
						<li><a href="../../user/index.php" class="ast3">Inicio</a></li>
						<li><a href="../../user/theory.php" class="ast3">Teoria</a></li>
						<li><a href="../../user/practices.php" class="ast3">Pr&aacute;cticas</a></li>
						<li><a href="../../user/practicas_creadas.php" class="ast3">Pr&aacute;cticas creadas</a></li>
						<li><a href="../../user/platform.php" class="ast3">Plataforma</a></li>
						<li><a href="../../user/mypractices.php" class="ast3">Mis Pr&aacute;cticas</a></li>
						<li><a href="indexCreacion.php" class="ast3">Crear Nueva Pr&aacute;ctica</a></li>
						<li><a href="mailto:sldadm@hotmail.com">Contacto</a></li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			</div>
			
			<div id="content_r">
    <div style="border: 5px solid #D3ECFF;">
      <h1><span id="texto"  name="texto">
      
	  <?php
		echo $_POST["tituloPractica"];
	  ?>
      </span></h1>
    </div>

	<div style="border: 5px solid #D3ECFF;">
      <span id="texto2">
      <?php
		echo $_POST["descripcionBreve"];
	  ?>
      </span>
    </div>
	<hr>
	<div class="centrar-imagen"><img src="../../../img/<?php echo $nombreImagen; ?>" name="imagen1"></div>
	<span id="descripcion" name="descripcion">
		<?php
		echo $_POST["descripcionPractica"];
	  ?>
	</span>
	<p></p>
	<hr>
	<form id="practice" name="practice" action="practicas_creadas.php" method="post" enctype="multipart/form-data" >

							<h1 class="content_r_hst3">Simbolog&iacute;a:</h1>
							<table width="100%" cellpadding="0" cellspacing="0" class="data" BORDER="1">
							<tr>

							<td width="175">Nombre del Par�metro</td>

							<td width="175">Etiqueta </td>

							<td width="175">Valor por defecto </td>

							<td width="100">Valor m�nimo</td>

							<td width="100">Valor m�ximo</td>

							
							
							</tr>
							<?php 
									$names = $_POST['nombre']; 
									$etiquetas = $_POST['etiqueta']; 
									$valorDefectos = $_POST['valorDefecto']; 
									$valorMinimos = $_POST['valorMinimo']; 
									$valorMaximos = $_POST['valorMaximo']; 
									
									$i=0;
									if($names != null){
									foreach($names as $name) { 
										$i++;
										$etiqueta = each($etiquetas);
										//$valorDefecto = each($valorDefectos);
										$valorMinimo = each($valorMinimos);
										$valorMaximo = each($valorMaximos);
										$valorDefecto = each($valorDefectos);
										if($name != null){
								?>
										<tr>
										
										<td WIDTH="10"><b><?php echo $name;?></b></td> <td><?php echo $etiqueta[1];?></td>
										<td><?php echo $valorDefecto[1];?></td><td><?php echo $valorMinimo[1];?></td>
										<td><?php echo $valorMaximo[1];?></td>
										
										<input type="hidden"  name="nombre[]" value="<?php echo $name;?>">
										<input type="hidden"  name="etiqueta[]" value="<?php echo $etiqueta[1];?>">
										<input type="hidden"  name="valorDefecto[]" value="<?php echo $valorDefecto[1];?>">
										<input type="hidden"  name="valorMinimo[]" value="<?php echo $valorMinimo[1];?>">
										<input type="hidden"  name="valorMaximo[]" value="<?php echo $valorMaximo[1];?>">
										</tr>
								<?php }}} ?>			  			  
							  
							</table>
							
				<div class="content_r_data_b"></div>
						
		
					<input type="hidden" name="nomPractica" value="<?php echo $_POST["nomPractica"]; ?>" class="hide">  
					<input type="submit" value="Finalizar" onClick="insertEnBd();" />
					<input type="hidden" name="nomPractica" value="<?php echo $_POST["nomPractica"]; ?>" />  
				</form>
    <script type="text/javascript" src="../../AjaxSLD/instantedit.js"></script>
  <script type="text/javascript"> 
    setVarsForm("pageID=profileEdit&userID=11"); 
  </script>
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

