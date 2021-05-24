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
			header('Location: ../../operator/index.php');
		else if($level == 3)
			header('Location: ../../user/index.php');
		else
			header('Location: ../../logout.php');
	}//end if
	
	$usrHTML = "<li><a href=\"../../user/index.php\" class=\"ast3\">Usar</a></li>";
	
	$btxt = "Servicio Pr&aacute;cticas Asistidas";
	
	
	//Creando objeto SQL
	$sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();
	$nombreEdit=$_POST['nombreEdit'];
	$query = "SELECT tituloPractica,descripcionBreve,descripcionLarga  FROM sld_practices_data_2 WHERE pname='$nombreEdit'";
	$result = $sql->SQLQuery($query);
	$tituloPractica=$result[0]['tituloPractica'];
	$descripcionBreve=$result[0]['descripcionBreve'];
	$descripcionLarga=$result[0]['descripcionLarga'];
	
?>
<?php

	 $seleccionada=$_POST["select1"]; // Se recoge el nombre de la practica seleccionada
	 $realSimulada=$_POST["select3"]; // seleccion de practica simulada o real
	 
	//Restriccion por tiempo
	$permbytime = 0;
	$hora = Date(H);
	$diaweek = Date(w);
	if ($hora >= 9 && $hora < 21 && $diaweek > 0 && $diaweek < 6 ){
		$permbytime = 1;}
		
	
	switch ($seleccionada)
	{
	case "1":
	$valorSeleccionada="1";
	$nombreSeleccionada="Motor de corriente directa UCLV";
	$file = 'template_termicos.m';
	break;
	case "2":
	$valorSeleccionada="2";
	$nombreSeleccionada="Brazo manipulador ASEA";
	break;
	case "3":
	$valorSeleccionada="3";
	$nombreSeleccionada="Sistema Térmico UPM";
	break;
	case "4":
	$valorSeleccionada="4";
	$nombreSeleccionada="Motor de corriente directa UPM";
	break;
	}
	
	$seleccionada2=$_POST["select2"];	// Tipos de parámetro que se han añadido
	$numParametros=$_POST["numParametros"];	 // numero total de parámetros
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<script language="javascript" type="text/javascript">
// Llamada a las funciones de php para la edicion de todos los ficheros de matlab y simulink relacionados con la practica
// por medio de código php
function reemplazarParams()
{
  //Location.url = 'funcionesPhp.php'; 
} 


</script>

	
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Teor&iacute;a</title>
  <link href="../../styles.css" rel="stylesheet" type="text/css" />
</head>
	<body>
		<div id="page">
			<?php
			///include 'funcionesPhp.php';
			?>
			<script>
			// Funcion javascript que hace una llamada a una funcion php para tratar el fichero .m
			
			
			function cambiarClass(){
				document.getElementById("texto").class="";
				document.getElementById("texto").readonly="readonly";
			}
			var texto1;
			

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
						<li><a href="../index.php">Inicio</a></li>
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
						<li><a href="logout.php" class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegaci&oacute;n</h1>
					<ul>
						<li><a href="../index.php" class="ast3">Inicio</a></li>
						<li><a href="practicas_creadas.php" class="ast3">Pr&aacute;cticas creadas</a></li>
						<li><a href="indexCreacion.php" class="ast3">Nueva pr&aacute;ctica</a></li>
						<li><a href="mailto:sldadm@hotmail.com">Contacto</a></li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			</div>
			
			
			<div id="content_r">
			<div style="border: 5px solid #D3ECFF;" id="textoPrimero">
			  <h1><span id="texto"  name="texto" ><?php 
				echo $_POST["nomPractica"];
			  ?></span></h1>
			</div>
			<input type="hidden" type='text' name="texto1" id="texto1">
			<div style="border: 5px solid #D3ECFF;">
			  <span id="texto2" class="editText" name="texto2"><?php
			  if($_POST['texto2'] ==""){
			    if ($descripcionBreve != null)
					echo stripslashes($descripcionBreve);
				else
					echo stripslashes("Descripción breve de la practica");
			  }
			  else{
				echo $_POST['texto2'];
			  }
			    ?></span>
			</div>
			<hr>
			<div class="centrar-imagen"><img src="../../img/<?php echo $_POST["nombreImagen"]; ?>" name="imagen1"></div>
			<span id="descripcion" class="editText" name="descripcion"><?php 
			  if($_POST['descripcion'] ==""){
			    if ($descripcionLarga != null)
					echo $descripcionLarga;
				else
					echo "Introduzca los parámetros del regulador PID que se desea ensayar. La estructura implementada para el regulador es de la forma suma de ganancias proporcional (Kp), integral (Ki) y derivativa (Kd). La entrada de referencia (Temperatura deseada) es igual a 5 V. (15ºC).
La opción Simular permite ver la evolución de la temperatura con el regulador ajustado sobre un modelo simulado del sistema térmico. La opción Real implementa el regulador ajustado sobre el sistema térmico real.
La duración del ensayo con la opción Simular es instantánea; con la opción Real es de aproximadamente 2 minutos.";
			    }
			 else{
				echo $_POST['descripcion'];
			  }
				?></span>
			<p></p>
			<hr>
			<form id="practice" name="practice" action="Index3.php" method="post" enctype="multipart/form-data">
		
								<!--div class="content_r_data_t"></div-->
								<!--div class="content_r_data_c"-->
									<h1 class="content_r_hst3">Simbolog&iacute;a:</h1>
									<table width="100%" cellpadding="0" cellspacing="0" class="data" BORDER="1">
									<tr>

									<td width="175">Nombre del Parámetro</td>

									<td width="175">Etiqueta </td>

									<td width="175">Valor por defecto </td>

									<td width="100">Valor mínimo</td>

									<td width="100">Valor máximo</td>

									
									
									</tr>
									<?php 
											$names = $_POST['nombre']; 
											$etiquetas = $_POST['etiqueta']; 
											$valorDefectos = $_POST['valorDefecto']; 
											$valorMinimos = $_POST['valorMinimo']; 
											$valorMaximos = $_POST['valorMaximo']; 
											
											$i=0;
											foreach($names as $name) { 
												$i++;
												$etiqueta = each($etiquetas);
												//$valorDefecto = each($valorDefectos);
												$valorMinimo = each($valorMinimos);
												$valorMaximo = each($valorMaximos);
												$valorDefecto = each($valorDefectos);
												if($name != null){
												$cadenaParametrosInsert.=$name.";".$etiqueta[1].";".$valorDefecto[1].";".$valorMinimo[1].";".$valorMaximo[1].";";
												
										?>
												<tr>
												
												<td WIDTH="10"><b><?php echo $name;?></b></td> <td><?php echo $etiqueta[1];?></td>
												<td><?php echo $valorDefecto[1];?></td><td><?php echo $valorMinimo[1];?></td>
												<td><?php echo $valorMaximo[1];?></td>
												
												<input type="hidden" type='text' name="nombre[]" value="<?php echo $name;?>">
												<input type="hidden" type='text' name="etiqueta[]" value="<?php echo $etiqueta[1];?>">
												<input type="hidden" type='text' name="valorDefecto[]" value="<?php echo $valorDefecto[1];?>">
												<input type="hidden" type='text' name="valorMinimo[]" value="<?php echo $valorMinimo[1];?>">
												<input type="hidden" type='text' name="valorMaximo[]" value="<?php echo $valorMaximo[1];?>">
												</tr>
										<?php }} ?>			  			  
									  
									</table>
								<!--/div-->
								
								
			
				<div class="content_r_data_b"></div>
							<input  type="hidden" name="nomPractica" value="<?php echo $_POST["nomPractica"]; ?>" >  
							<input  type="hidden" name="ulogin" value="<?php echo $login; ?>">  
							<input  type="hidden" name="nomPractica" value="<?php echo $_POST["nomPractica"]; ?>">  
							 
							<h1 class="content_l_hst1">Seleccione el archivo simulink modificado para usar en la práctica</h1>
				<input type="file" name="mdl"><br>
				<input  type="hidden" name="nomPractica" value="<?php echo $_POST["nomPractica"]; ?>">  
				<script>
					function llamarPagina(nomPractica,atras,nombreEdit,tipoSistema,parametros,tipoEjecucion){
					var texto2= document.getElementById("texto2").innerHTML;
					var descripcion= document.getElementById("descripcion").innerHTML;
					window.location.href = "IndexCreacion.php?nomPractica="+nomPractica+"&atras="+1+"&nombreEdit="+nombreEdit+"&tipoSistema="+tipoSistema+"&parametros="+parametros+"&tipoEjecucion="+tipoEjecucion+"&texto2="+texto2+"&descripcion="+descripcion;
					}
					function guardarVariables(tipoCreacion){
				
					//alert("entro en tipo");
					//texto1= "pruebaTexto1";//document.getElementById("texto").innerHTML;
					//alert(texto1);
					document.getElementById("tituloPractica").value=document.getElementById("texto").innerHTML;
					document.getElementById("descripcionBreve").value=document.getElementById("texto2").innerHTML;
					document.getElementById("descripcionPractica").value=document.getElementById("descripcion").innerHTML;
					
					if(tipoCreacion == 'crea'){
						//alert("crea");
						document.getElementById("editCreate").value=1;
					}
					if(tipoCreacion == 'edit'){
						//alert("edito");
						document.getElementById("editCreate").value=2;
					}
					}
				
				</script>
				<input type="submit" value="Enviar" onClick="guardarVariables('crea');" >
				<input type="submit" value="Guardar formulario actual" onClick="guardarVariables('edit');" >
				<a href="IndexCreacion.php?nomPractica=<?php echo $_POST['nomPractica']; ?>&atras=1&nombreEdit=<?php echo $_POST['nombreEdit']; ?>&tipoSistema=<?php echo $_POST["select1"];?>&parametros=<?php echo $cadenaParametrosInsert;?>&tipoEjecucion=<?php echo $_POST["select3"];?>">Atr&aacute;s</a>
				<input type="hidden"  name="seleccionada" value="<?php echo $_POST["select1"];?>"> 								
				<button type="button" onclick="llamarPagina('<?php echo $_POST['nomPractica']; ?>','1','<?php echo $_POST['nombreEdit']; ?>','<?php echo $_POST['select1']; ?>','<?php echo $cadenaParametrosInsert; ?>','<?php echo $_POST['select3']; ?>');">Atrás</button>
				<input type="hidden"  name="realSimulada" value="<?php echo $_POST["select3"];?>"> 		
				<script > 
				document.write("<input type='hidden'  name='tituloPractica' id='tituloPractica' />"); 
				document.write("<input type='hidden'  name='descripcionBreve' id='descripcionBreve' />");
				document.write("<input type='hidden'  name='descripcionPractica' id='descripcionPractica'/>"); 
				document.write("<input type='hidden'  name='editCreate' id='editCreate'/>"); 
				</script> 
				<input  type="hidden"  name="variable" value="<?php echo $variable;?>">
				<input  type="hidden"  name="nombreEdit" value="<?php echo $_POST["nombreEdit"];?>"> 
			</form>
			
			<script type="text/javascript" src="../../AjaxSLD/javascript/instantedit.js"></script>
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

