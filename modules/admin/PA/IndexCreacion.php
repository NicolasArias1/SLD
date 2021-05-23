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
			header('Location: ../../../general/logout.php');
	}//end if
	
	$usrHTML = "<li><a href=\"../../user/index.php\" class=\"ast3\">Usar</a></li>";
	
	$btxt = "Servicio Pr&aacute;cticas Asistidas";
	
	$nombreEdit=$_GET['nombreEdit'];
	$atras=$_GET['atras'];
		if($atras != 1){ // Los datos vienen de la base de datos
		//Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		$query = "SELECT pcname,tipoSistema,tipoEsquema,parametros FROM sld_practices_data_2 WHERE pname='$nombreEdit'";
		$result = $sql->SQLQuery($query);
		$nombrePracticaEdit=$result[0]['pcname'];
		$tipoSistema=$result[0]['tipoSistema'];
	}
	else{ // los datos vienen del formulario posterior, hemos retrocedido con el boton atras
		$nombrePracticaEdit= $_GET['nomPractica'];
	
	}

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<script language="javascript" type="text/javascript"> /* Abrimos etiqueta de c�digo Javascript */
var miArray = new Array() ;
function procesarVariables(){
	var tabla = document.getElementById("tablaParametros");
}

/* Partimos por definir una variable llamada posicionCampo. Esta variable servir� como �ndices para marcar cuantos 
campos se han agregado din�micamente. La inicializamos en 1, ya que la primera llamada ocurrir� cuando no haya campos agregados */

var posicionCampo=1;

/* Declaramos la funci�n agregarParametro( ): Esta funcion es la encargada de a�adir y eliminar dinamicamente parametros que iran
dentro del modelo de simulink. Por defecto antes se a�adian las 3 ganancias del regulador Ki, Kd y Kp. Ahora ya no
puesto que se a�aden todos los par�metros din�micamente. */

function agregarParametro(){

	/* Declaramos una variable llamada nuevaFila y a ella le asignamos la recuperaci�n del elemento HTML designado por el id tablaParametros. 
	En este caso, la tabla en la que manejamos los campos din�micamente y llamamos a la funci�n insertRow para agregar una fila */

	nuevaFila = document.getElementById("tablaParametros").insertRow(-1);

	/* Asignamos a la propiedad id de nuevaFila el valor de posicionCampo, que inicializamos en 1 */

	nuevaFila.id=posicionCampo;

	/* Luego en otra variable llamada nuevaCelda, agregaremos una celda a la tabla, mediante la funci�n insertCell */

	nuevaCelda=nuevaFila.insertCell(-1);

	/* Con la celda creada, insertamos din�micamente un campo de texto, el cual almacenaremos en un array llamado nombre, 
	con una posici�n equivalente a la variable posicionCampo. Una vez terminado, repetimos la acci�n para la etiqueta, valor por defecto,
	valores minimo y maximo, asignandolos al array respectivo */

	nuevaCelda.innerHTML="<td><input type='text' class='required' size='15' name='nombre["+posicionCampo+"]' id='nombre["+posicionCampo+"]'></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td> <input type='text' class='required' size='10' name='etiqueta["+posicionCampo+"]' id='etiqueta["+posicionCampo+"]' ></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td> <input type='text' class='number' size='10' name='valorDefecto["+posicionCampo+"]' id='valorDefecto["+posicionCampo+"]' ></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td><input type='text' class='number' size='10' name='valorMinimo["+posicionCampo+"]' id='valorMinimo["+posicionCampo+"]'></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td><input type='text' class='number' size='10' name='valorMaximo["+posicionCampo+"]' id='valorMaximo["+posicionCampo+"]'></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td><input type='button' value='Eliminar' onclick='eliminarParametro(this)'></td>";
	
	/* Incrementamos el valor de posicionCampo para que empiece a contar de la fila siguiente */

	posicionCampo++;
	document.getElementById("numParametros").value=posicionCampo; // Los parametros que a�adamos m�s los ya existentes del PID
	
}

// Misma funcion que la anterior, pero esta recoge los par�metros de pr�cticas ya existentes en edici�n
function agregarParametroEdit(etiqueta,valorDefecto,valorMin,valorMax,nombreParam){

	/* Declaramos una variable llamada nuevaFila y a ella le asignamos la recuperaci�n del elemento HTML designado por el id tablaParametros. 
	En este caso, la tabla en la que manejamos los campos din�micamente y llamamos a la funci�n insertRow para agregar una fila */

	nuevaFila = document.getElementById("tablaParametros").insertRow(-1);

	/* Asignamos a la propiedad id de nuevaFila el valor de posicionCampo, que inicializamos en 1 */

	nuevaFila.id=posicionCampo;

	/* Luego en otra variable llamada nuevaCelda, agregaremos una celda a la tabla, mediante la funci�n insertCell */

	nuevaCelda=nuevaFila.insertCell(-1);

	/* Con la celda creada, insertamos din�micamente un campo de texto, el cual almacenaremos en un array llamado nombre, 
	con una posici�n equivalente a la variable posicionCampo. Una vez terminado, repetimos la acci�n para la etiqueta, valor por defecto,
	valores minimo y maximo, asignandolos al array respectivo */

	nuevaCelda.innerHTML="<td><input type='text' class='required' size='15' name='nombre["+posicionCampo+"]' id='nombre["+posicionCampo+"]' value="+nombreParam+"></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td> <input type='text' class='required' size='10' name='etiqueta["+posicionCampo+"]' id='etiqueta["+posicionCampo+"]' value="+etiqueta+"></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td> <input type='text' class='number' size='10' name='valorDefecto["+posicionCampo+"]' id='valorDefecto["+posicionCampo+"]' value="+valorDefecto+"></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td><input type='text' class='number' size='10' name='valorMinimo["+posicionCampo+"]' id='valorMinimo["+posicionCampo+"]' value="+valorMin+"></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td><input type='text' class='number' size='10' name='valorMaximo["+posicionCampo+"]' id='valorMaximo["+posicionCampo+"]' value="+valorMax+"></td>";

	nuevaCelda=nuevaFila.insertCell(-1);

	nuevaCelda.innerHTML="<td><input type='button' value='Eliminar' onclick='eliminarParametro(this)'></td>";
	
	/* Incrementamos el valor de posicionCampo para que empiece a contar de la fila siguiente */

	posicionCampo++;
	document.getElementById("numParametros").value=posicionCampo/*+3*/; // Los parametros que a�adamos m�s los ya existentes del PID

}

/* Definimos la funci�n eliminarParametro, la cual se encargar� de quitar la fila completa del formulario. Se recogera el 
parametro concreto enviado desde el formulario para la adici�n o eliminaci�n de par�metros de forma din�mica */

MultiArray = new Array(100);
var punteroArray=0;
function eliminarParametro(obj){
		var oTr = obj;
		while(oTr.nodeName.toLowerCase()!='tr'){
			oTr=oTr.parentNode;
		}
		// Se busca su nodo padre para eliminar toda la fila que hace referencia a ese objeto
		var root = oTr.parentNode;
		// Se elimina ese objeto
		root.removeChild(oTr);
		// Se decrementa la pila de elementos para su posterior tratamiento
		posicionCampo--;
		// Guardamos la posicion sabiendo que existen 3 parametros edicionales del PID
		document.getElementById("numParametros").value=posicionCampo; // Los parametros que a�adamos m�s los ya existentes del PID

}


function cambiaRadio(){ 
    if (document.f1.tipoPractica[0].checked){
		document.getElementById("parametrica").style.visibility="visible";
		
	}else
		document.getElementById("parametrica").style.visibility="hidden"; 
}

esquemasControl = new Array();
esquemasControl[0] = new Array('ControlOptimo');
esquemasControl[1] = new Array('ControlOptimo2','ControlOptimo');
var primeraEntrada=0;

// Se muestra una imagen u otra en funcion de si la practica se va a realizar con el sistema motor o con el sistema t�rmico
function cambiaValorSelectPractica(){ 
	// --- Par�metros para el select dependiente ---
	  var i = 0;
	  var vector = esquemasControl[document.f1.select1.selectedIndex];
	   if(vector.length)document.f1.select2.length=vector.length;
	  while(vector[i]){
		document.f1.select2.options[i].value = vector[i];
		document.f1.select2.options[i].text = vector[i];
		i++;
	  }
	  document.f1.select2.options[0].selected = 1;
	  
	  // --- Fin de Par�metros para el select dependiente ---
	  
	// Seleccion de los valores que llegan por la url para cambiar los combos (Edicion de practica ya existente)
	if(primeraEntrada == 0){
		var tipoSistema = cogerParametroUrl( 'tipoSistema' );
		if(tipoSistema == 1){
			document.f1.select1[0].selected = 1;
		}
		if(tipoSistema == 2){
			document.f1.select1[1].selected = 1;
		}
		
		
		
		var parametros = cogerParametroUrl( 'parametros' );
		var nombres = parametros.split(";");
		i=0;
		while(nombres[i] != "" ){
			nombreSinEspacios=nombres[i];
			while(nombreSinEspacios.indexOf("20")!=-1){
				nombreSinEspacios=nombreSinEspacios.replace("%20", " ");
			}
			nombreAponer=nombreSinEspacios;
			agregarParametroEdit(nombres[i+1],nombres[i+2],nombres[i+3],nombres[i+4],nombreSinEspacios);
			i=i+5;
		
		}
		
		
		var tipoEjecucion = cogerParametroUrl( 'tipoEjecucion' );
		if(tipoEjecucion == 1){
			document.f1.select3[0].selected = 1;
		}
		if(tipoEjecucion == 2){
			document.f1.select3[1].selected = 1;
		}
		if(tipoEjecucion == 3){
			document.f1.select3[2].selected = 1;
		}
	}
	primeraEntrada=1;
	// Fin de Seleccion de los valores que llegan por la url para cambiar los combos 
	
	
   	if(document.f1.select1[1].selected){
		document.images["imagen1"].src = "../../../img/motor_pid.JPG";
		document.getElementById("nombreImagen").value="motor_pid.JPG";
		seleccionada=1;
		document.down.action= "www/download/downloadmot.php";
		document.getElementById("nomPractica").value="";
	}
	else{
		document.images["imagen1"].src = "../../../img/sist_term.JPG";
		document.getElementById("nombreImagen").value="sist_term.JPG";
		seleccionada=2;
		document.down.action= "../../../download/downloadterm.php";
		document.getElementById("nomPractica").value="";
	}
}


MultiArray = new Array(20);

// Reconoce valor 
function cambiaValorSelect2Practica(name){
	// Se marcan los valores seleccionados del select box de tipo de parametro, para ser recogidos en el siguiente formulario
	var numvalores = document.f1[name].length;
	// Se recorren todos los valores y se marcan como true los seleccionados
	for (i=0;i<numvalores;i++){
		document.f1[name].selected = true;
	}
	
}

// Se establece el sistema t�rmico como pr�ctica por defecto
function cambiaValorSelectDefecto(){ 
	seleccionada=1;
	document.images["imagen1"].src = "imagenesSLD/sist_term.jpg";
	document.getElementById("nombreImagen").value="sist_term.JPG";
	document.getElementById("nomPractica").value="";
}

// Funcion que recoge los parametros de la url
function cogerParametroUrl( name )
{
  var regexS = "[\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var tmpURL = window.location.href;
  var results = regex.exec( tmpURL );
  if( results == null )
    return "";
  else
    return results[1];
}

function guardarVariables(tipoCreacion){
	if(tipoCreacion == 'crea'){
		document.getElementById("editCreate").value=1;
	}
	else{
		document.getElementById("editCreate").value=2;
	}
}

function reemplazarParams()
{
  //Location.url = 'funcionesPhp.php'; 
} 

</script>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Teoría</title>
  <link href="../../../css/styles.css" rel="stylesheet" type="text/css" />
  <script src="../../../libraries/jquery/jquery-3.6.0.min.js" type="text/javascript"></script>
	
	<script type="text/javascript">
	$(document).ready(function() {
		$("#commentForm").validate();
	});
	</script>

	<style type="text/css">
	#commentForm { width: 500px; }
	#commentForm label { width: 250px;color:#ff0000; }
	#commentForm label.error, #commentForm input.submit { margin-left: 10px; }
	</style>
</head>

<body onload="cambiaValorSelectPractica()">
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
						<li><a href="../../../general/logout.php " class="ast3">Logout</a></li>
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
		<h1>Seleccione la pr�ctica</h1>
		<!--Sustituir Action por action="Ajax/instantaneo/instantaneo/index2.php" -->
		<form name="f1" id="commentForm" action="index2.php" method="post">
		<fieldset>
		<legend align= "left"><b>Elija el dispositivo real para el que realizar&aacute; la pr&aacute;ctica</b></legend>
		  <p>
			<table width="100%" cellpadding="0" cellspacing="0" class="data" >
			<td align="left">
			 <select name="select1" size="1" onChange="cambiaValorSelectPractica();" value="<?php echo $tipoSistema; ?>">
			  <!--option value="1">Motor de corriente directa UCLV</option>
			  <option value="2">Brazo manipulador ASEA</option--> // Futuras ampliaciones del sistema
			  <option value="1">Sistema T&eacute;rmico UPM</option>
			  <option value="2">Motor de corriente continua UPM</option>
			</select>
			</td>
			<td align="left"><!-- Este select habra que recogerlo en el POST y tratarlo para seleccionar el tipo de plantilla -->
			<b>Tipo de esquema</b><select name="select2" size="1" onChange=""></select></td>
			
			</table>
		</p>
		</fieldset>
		<tr>
		<fieldset>
		<legend align= "left"><b>Tipo de pr&aacute;ctica a realizar</b></legend>
		  <p>
			<label>
			<table width="100%" cellpadding="0" cellspacing="0" class="data" >
			<tr>
			<td align="left">
			<input type="radio" name="tipoPractica" value="opci&oacute;n"  onclick="cambiaRadio()" checked="checked">
		  Param&eacute;trica</label>
			</td>
			<td width="330"></td>
			<td align="left">
			<b>Tipo de ejecucion</b>
			<select name="select3" size="1" onChange="">
			  <option value="1">Pr&aacute;ctica simulada</option>
			  <option value="2">Pr&aacute;ctica real</option>
			  <option value="3">Pr&aacute;ctica real y simulada</option>
			</select>
			</td>
			</tr>
			</table>
			<label>
		  </p>
		</fieldset>

		<fieldset >
		<legend align= "left"><b>Nombre de la Pr&aacute;ctica</b></legend>
		  <p>Nombre de la pr&aacute;ctica</p>
		  <p>
			<input type="text" class="required" name="nomPractica" value="<?php echo $nombrePracticaEdit; ?>">  
		</fieldset>
		 
		<fieldset id="parametrica">
		<legend align= "left"><b>Par&aacute;metros de la pr&aacute;ctica param&eacute;trica</b></legend>
		<table id="tablaParametros" name="tablaParams">

		<tr>

		<td width="175">Nombre del Par�metro</td>

		<td width="175">Etiqueta </td>

		<td width="175">Valor por defecto </td>

		<td width="100">Valor m�nimo</td>

		<td width="100">Valor m�ximo</td>

		<td width="100">Acci�n</td>


		<td align="right">
		<input type="button" onClick="agregarParametro()"
		value="A&ntilde;adir parametro" >

		</td>

		<!--td align="right">
		<input type='button' value='Eliminar' onclick='eliminarParametro()'>
		</td-->

		</tr>

		</table>
		</fieldset>

		<div class="centrar-imagen"><img src="imagenesSLD/sist_term.jpg" name="imagen1"></div>

		<h1>Descarga del fichero de simulink para su posterior edicion</h1>
		<fieldset >
		<legend align= "left"><b>Descarga del fichero de simulink para su posterior edicion</b></legend>
		<div class="content_r_data">
			<div class="content_r_data_t"></div>
			<div class="content_r_data_c">
			<table width="100%" cellpadding="0" cellspacing="0" class="form">
			  <tr>
				<td width="175" class="buttons"><input onClick="document.down.action='../../../download/downloadf.php'; document.down.submit();" type="button" name="Submit" value="Descargar" class="input_button" /></td>
			  </tr>
			</table>			 
		</fieldset>

		<br><br>
		<input class="submit" type="submit" value="Configurar" onClick="procesarVariables();">
		
		
		<td><input type="hidden" type='text' name='nombre[]' class="hide"></td>
		<td><input type="hidden" type='text' name='etiqueta[]' class="hide"></td>
		<td><input type="hidden" type='text' name='valorDefecto[]' class="hide"></td>
		<td><input type="hidden" type='text' name='valorMinimo[]' class="hide"></td>
		<td><input type="hidden" type='text' name='valorMaximo[]' class="hide"></td>
		<td><input type="hidden" type='text' name='select2[]' class="hide"></td>
		<td><input type="hidden" type='text' name='MultiArray[]' class="hide"></td>
		<td><input type="hidden" type="text" name="numParametros" id="numParametros" class="hide"></td>
		<td><input type="hidden" type="text" name="posicionesEliminadas" id="posicionesEliminadas" class="hide"></td>
		<td><input type="hidden" type="text" name="nombreImagen" id="nombreImagen" class="hide"></td>
		<input type="hidden" type='text' name="nombreEdit" value="<?php echo $_GET["nombreEdit"];?>"> 
		<input type="hidden" type='text' name="tipoSistema" value="<?php echo $_GET["tipoSistema"];?>"> 
		<input type="hidden" type='text' name="tipoEjecucion" value="<?php echo $_GET["tipoEjecucion"];?>">
		<input type="hidden" name="texto2" id="texto2" value="<?php echo $_GET["texto2"];?>" >
		<input type="hidden" name="descripcion" id="descripcion" value="<?php echo $_GET["descripcion"];?>" >
		</form>

		
		 <form name="down" action="" method="post" enctype="multipart/form-data">
		</form>
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
