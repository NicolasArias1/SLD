
<?php
// Definicion de formato de la fecha
date_default_timezone_set('Europe/Madrid');
$fecha=date( "YmjHis" ); // Funcion de fecha --> Cambiar a Ymj (a�o/mes/dia)
$numParametros=0;

/*
Funci�n principal, encargada de llamar a otras para la gesti�n de los ficheros matlab y simulink
*/
function reemplazarParams(){
	// Se reciben por el POST todos los parametros necesarios para la correcta realizacion de la practica
	// Se declaran las variables globales, que van a ser utilizadas en otras funciones
	global $fecha,$nombrePracticaOriginal,$descripcionBrevePractica,$tituloPractica,$descripcionPractica,$cadenaParametrosWeb_user1,$cadenaParametrosWeb_user2,$file_plantilla_user,$nombreCortoPractica,$file_plantilla,$file_plantilla2,$cadenaParametrosWeb,$tipoPractica,$numParametros,$seleccionada, $file,$file2, $archivoMdl,$names,$valorDefectos,$etiquetas,$valorMinimos,$valorMaximos,$cadenaValidacion;
	global $cadenaParametrosInsert,$cadenaValoresParametrosInsert,$cadenaMaximosInsert,$cadenaMinimosInsert;
	// Parametros relacionados con la posibilidad de crear una practica real y simultanea a la par
	$realSimulada="";
	$practicaDoble = 0;
	$nombrePractica="";
	$nombrePractica2="";
	
	// Directorios
	$directorioRaizUsuario="d:/www/creacionPracticas/";
	$directorioRaizArchivos="d:/www/creacionPracticas/";
	$directorioRaizSimulink="d:/www/creacionPracticas/";
	$directorioFicheroZip="d:/www/creacionPracticas/";
	
	// Componente select que permite elegir que practica se desea, escogiendo una plantilla en funcion de este
	$seleccionada=$_POST["seleccionada"];
	// Si se trata de una pr�ctica real o simulada 
	$realSimulada=$_POST["realSimulada"];
	
	// 3 parametros del formulario AJAX: titulo, descripcion breve y descripcion larga
	$descripcionPractica=$_POST["descripcionPractica"];
	$descripcionBrevePractica=$_POST["descripcionBreve"];
	$tituloPractica = $_POST["tituloPractica"];
	$nombreEdit = $_POST["nombreEdit"];
	// Guardando cambios o creando por primera vez
	$tipoCreacion = $_POST["editCreate"];
	// Login del creador de la pr�ctica
	$ulogin = $_POST["ulogin"];
	// Selecci�n del fichero de plantilla deseada
	seleccionarPlantillas($realSimulada);
	// Nombre que tendran todos los archivos de la practica Nombre+fecha+r o Nombre+fecha+s
	$nombrePracticaOriginal=$tipoPractica.$fecha;
	// Plantilla a utilizar para la practica en funcion de su tipo
	$insertTipo="";
	
	if($realSimulada == 1){
		$nombrePractica=$tipoPractica.$fecha."s";
		$insertTipo="Simulada";
	}
	else if($realSimulada == 2){
		$nombrePractica=$tipoPractica.$fecha."r";
		$insertTipo="Real";
	}
	else{ // Practica real y simulada se crean simultaneamente
		$practicaDoble = 1;
		$nombrePractica=$tipoPractica.$fecha."s";
		$nombrePractica2=$tipoPractica.$fecha."r";
		$insertTipo="Simulada";
	}
	
	// Conexi�n sql
	$sql = new SQL();
	//Conectando con el servidor
	$sql->SQLConnection();
	$query = "SELECT * FROM sld_practices_data_2 where pname='$nombreEdit' ";
	$result = $sql->SQLQuery($query);
	$practicaExistente= $sql->count;
	$edicion = $result[$j]['enEdicion'];
	
	$nombreCortoPractica=$_POST["nomPractica"];
	$names = $_POST['nombre']; 
	$i=0;

	// Se crean vectores que contienen el parametro y su valor en forma vectorial para ser tratados eficientemente
	// en matlab
	$etiquetas = $_POST['etiqueta']; 
	$valorDefectos = $_POST['valorDefecto']; 
	$valorMinimos = $_POST['valorMinimo']; 
	$valorMaximos = $_POST['valorMaximo']; 
	
	// Se definen las cadenas necesarias, mediante el recorrido de los vectores anteriores
	// para su integracion en los ficheros web 
	definicionParametrosPrincipales($fp);
	
	// --- Tratamiento de ficheros mediante php ----------------------------------------------------------
	
	// Pr�ctica nueva o en edici�n.
	$enEdicion=1;
	if ($tipoCreacion == 1)
		$enEdicion=0;
	
	// Definici�n de los par�metros para la creaci�n de una nueva pr�ctica
	$tabla="sld_practices_data_2";
	$path="D:/www/creacionPracticas/$nombrePractica";
	$path2="creacionPracticas/$nombrePractica/";
	
	$path22 = substr($path2, 0, -2);
	$path22 = $path22."r/out/";
	
	$path2= $path2."out/";
	
	$nombrePractica2 = substr($nombrePractica, 0, -1);
	$nombrePractica2 = $nombrePractica2."r";
	
	$path21 = substr($path, 0, -1);
	$path21 = $path21."r";
	
	
	
	// Hay que tener en cuenta qu� pasa si creo una practica y
		// 1- No existia y se crea o edita por primera vez --> OK, se crean todos los archivos
	require ("creaZip.php");
	if(($tipoCreacion == 1 || $tipoCreacion == 2) && $practicaExistente == 0){
		crearNuevaPractica($practicaDoble,$nombrePractica,$file,
			$directorioRaizArchivos,$file_plantilla,$file_plantilla_user,
			$directorioRaizUsuario,$nombrePractica2,$file2,$file_plantilla2,
			$nombreCortoPractica,$path,$path2,$insertTipo,$seleccionada,$realSimulada,
			$cadenaParametrosInsert,$directorioRaizSimulink ,$tituloPractica,
			$descripcionBrevePractica,$descripcionPractica,$enEdicion,$ulogin,$path21,$path22);
			
		$sql->SQLConnection();
		$query = "SELECT * FROM sld_stations where sname='ServerUPM' ";
		$result = $sql->SQLQuery($query);
		
		$practicasServidor = $result[0]['practices'];
		$nombreSimuladoEnServidor=substr($nombrePractica, 0, -1).'s';
		$practicasServidor = $practicasServidor.";m_$nombreSimuladoEnServidor";
		$query="UPDATE sld_stations SET practices='$practicasServidor' WHERE sname= 'ServerUPM'";
		queryEnBaseDatos($tabla,$query);
		
		subirFicheroSimulink($texto,$nombrePractica,$directorioRaizSimulink);
		crearFicheroZip($nombrePractica,$directorioFicheroZip,$directorioRaizArchivos);
	}
	
	
	// Insert en base de datos de practica nueva no existente
	// 2- Ya existia --> DEBEN BORRARSE LOS ARCHIVOS ANTERIORES Y MODIFICARSE CON LOS NUEVOS DATOS
	if(($tipoCreacion == 1 || $tipoCreacion == 2) && $practicaExistente != 0){
		// Se recupera la informaci�n referente a la pr�ctica existente
		$nombrePractica = substr($result[0]['pname'], 2);
		$nombrePractica = substr($nombrePractica, 0, -1);
		$nombrePractica = $nombrePractica."s";
		$nombrePractica2 = substr($nombrePractica, 0, -1);
		$nombrePractica2 = $nombrePractica2."r";
		$path = $result[0]['path'];
		$path2 = $result[0]['stpath'];
		$path = substr($path, 0, -1);
		$path = $path."s";
		$path2 = substr($path2, 0, -6);
		$path2 = $path2."s/out/";
		
		$path21 = substr($path, 0, -1);
		$path21 = $path21."r";
		$path22 = substr($path2, 0, -6);
		$path22 = $path22."r/out/";
		// Si la practica es Real y Simulada se borra todo lo anterior y se crea de nuevo
		if($practicaDoble == 1){
			$practicaTempo=substr($nombrePractica, 0, -1);
			$practicaTempo = $practicaTempo."s";
			eliminarPractica($practicaTempo,$directorioRaizArchivos);
			
			$practicaTempo=substr($nombrePractica, 0, -1);
			$practicaTempo = $practicaTempo."r";
			eliminarPractica($practicaTempo,$directorioRaizArchivos);
			
			crearNuevaPractica($practicaDoble,$nombrePractica,
				$file,$directorioRaizArchivos,$file_plantilla,$file_plantilla_user,
				$directorioRaizUsuario,$nombrePractica2,$file2,$file_plantilla2,$nombreCortoPractica
				,$path,$path2,$insertTipo,$seleccionada,$realSimulada,$cadenaParametrosInsert,
				$directorioRaizSimulink ,$tituloPractica,$descripcionBrevePractica,$descripcionPractica,
				$enEdicion,$ulogin,$path21,$path22);
				
			subirFicheroSimulink($texto,$nombrePractica,$directorioRaizSimulink);
			crearFicheroZip($nombrePractica,$directorioFicheroZip,$directorioRaizArchivos);
		}else{ // Si la pr�ctica no es doble
			
			// Practica s�lamente simulada: Se borra la informaci�n posible de la real existente y se crea
			if($realSimulada == 1){
				$nombrePractica = substr($nombrePractica, 0, -1)."s";
				$path = substr($path, 0, -1);
				$path = $path."s";
				$path2 = substr($path2, 0, -6);
				$path2 = $path2."s/out/";
			
				$practicaTempo=substr($nombrePractica, 0, -1);
				$practicaTempo = $practicaTempo."r";
				eliminarDir("D:/www/creacionPracticas/".$practicaTempo );
				
			}// Practica s�lamente real: Se borra la informaci�n posible de la simulada existente y se crea
			if($realSimulada == 2){
				$nombrePractica = substr($nombrePractica, 0, -1)."r";
				$path = $path21;
				$path2 = substr($path2, 0, -6);
				$path2 = $path2."r/out/";

				$practicaTempo=substr($nombrePractica, 0, -1);
				$practicaTempo = $practicaTempo."s";
				eliminarDir("D:/www/creacionPracticas/".$practicaTempo );				
			}
			// Si se ha escogido una practica de solo un tipo (R o S) se oculta la del otro tipo
			//ocultarPracticaExistente($practicaTempo);
			// Se crean los archivos
			creacionArchivosPractica($nombrePractica,$file,$directorioRaizArchivos,
				$file_plantilla,$file_plantilla_user,$directorioRaizUsuario);
			// Se actualizan los datos de la pr�ctica, puesto que esta ya exist�a	
			actualizarPracticaExistente($nombrePractica,$nombreCortoPractica,
				$path,$path2,$insertTipo,$seleccionada,
				$realSimulada,$cadenaParametrosInsert,$tituloPractica,
				$descripcionBrevePractica,$descripcionPractica,$enEdicion,$nombreEdit);
				
			subirFicheroSimulink($texto,$nombrePractica,$directorioRaizSimulink);
			crearFicheroZip($nombrePractica,$directorioFicheroZip,$directorioRaizArchivos);
		}
	}
	// Se sube el fichero simulink, en caso de que no se seleccione ninguno el fichero ser� el �ltimo subido
	//subirFicheroSimulink($texto,$nombrePractica,$directorioRaizSimulink);
	// Se crea zip con todos los ficheros de la pr�ctica
	//crearFicheroZip($nombrePractica,$directorioFicheroZip,$directorioRaizArchivos);

	// Fin del codigo principal
}

function actualizarPracticaExistente($nombrePractica,$nombreCortoPractica,
				$path,$path2,$insertTipo,$seleccionada,
				$realSimulada,$cadenaParametrosInsert,$tituloPractica,
				$descripcionBrevePractica,$descripcionPractica,$enEdicion,$nombreEdit){
	$nombrePractica_m = "m_".$nombrePractica;
	$query="UPDATE sld_practices_data_2 SET sid='1',pname='$nombrePractica_m', pcname= '$nombreCortoPractica', categoria= 'Pr&aacute;cticas del sistema t&eacute;rmico', purl='', path='$path', stpath='$path2', nfiles=0, type='$insertTipo', visibilidad='visible',tipoSistema=$seleccionada,tipoEsquema=1,tipoEjecucion=$realSimulada,parametros='$cadenaParametrosInsert',tituloPractica='$tituloPractica',descripcionBreve='$descripcionBrevePractica',descripcionLarga='$descripcionPractica',enEdicion=$enEdicion WHERE pname= '$nombreEdit'";
	queryEnBaseDatos($tabla,$query);
	$query="UPDATE sld_practices_data SET sid='1',pname='$nombrePractica_m', pcname= '$nombreCortoPractica', categoria= 'Pr&aacute;cticas del sistema t&eacute;rmico', purl='', path='$path', stpath='$path2', nfiles=0, type='$insertTipo', visibilidad='oculta' WHERE pname= '$nombreEdit'";
	queryEnBaseDatos($tabla,$query);

}
// Se oculta una pr�ctica reconvertida de real <-> simulada
function ocultarPracticaExistente($practicaTempo){
	$query="UPDATE sld_practices_data_2 WHERE pname = '$practicaTempo' set visibilidad='oculta'";
	queryEnBaseDatos($tabla,$query);
	$query="UPDATE sld_practices_data WHERE pname = '$practicaTempo' set visibilidad='oculta'";
	queryEnBaseDatos($tabla,$query);
}

// Se crean los archivos necesarios para la pr�ctica
function creacionArchivosPractica($nombrePractica,$file,$directorioRaizArchivos,$file_plantilla,$file_plantilla_user,$directorioRaizUsuario){
	creacionFicheroPlantilla($nombrePractica,$file,$directorioRaizArchivos);
	creacionFicheroSalidaWeb($nombrePractica,$file_plantilla,$directorioRaizArchivos);
	creacionFicheroSalidaWebUser($nombrePractica,$file_plantilla_user,$directorioRaizUsuario);
}

// Se eliminan todas las referencias a una pr�ctica: Archivos y valores de la base de datos
function eliminarPractica($practicaTempo,$directorioRaizArchivos){
	$nombrePractica_m = "m_".$practicaTempo;
	eliminarDir($directorioRaizArchivos.$practicaTempo);
	$query="DELETE FROM sld_practices_data_2 WHERE pname = '$nombrePractica_m'";
	queryEnBaseDatos($tabla,$query);
	$query="DELETE FROM sld_practices_data WHERE pname = '$nombrePractica_m'";
	queryEnBaseDatos($tabla,$query);
}


// Proceso de crear una pr�ctica nueva, Simulada, Real o ambas
function crearNuevaPractica($practicaDoble,$nombrePractica,$file,$directorioRaizArchivos,$file_plantilla,$file_plantilla_user,$directorioRaizUsuario,$nombrePractica2,$file2,$file_plantilla2,$nombreCortoPractica,$path,$path2,$insertTipo,$seleccionada,$realSimulada,$cadenaParametrosInsert,$directorioRaizSimulink ,$tituloPractica,$descripcionBrevePractica,$descripcionPractica,$enEdicion,$ulogin,$path21,$path22){
	creacionArchivosPractica($nombrePractica,$file,$directorioRaizArchivos,
				$file_plantilla,$file_plantilla_user,$directorioRaizUsuario);
	
	$nombrePractica_m = "m_".$nombrePractica;
	$nombrePractica2_m = "m_".$nombrePractica2;
	
	$query="INSERT INTO sld_practices_data_2 (sid, pname, pcname, categoria, path, stpath, purl, nfiles, type, visibilidad,tipoSistema,tipoEsquema,tipoEjecucion,parametros,ficheroSimulink,tituloPractica,descripcionBreve,descripcionLarga,enEdicion,ulogin) VALUES ('1', '$nombrePractica_m', '$nombreCortoPractica', 'Pr&aacute;cticas del sistema t&eacute;rmico', '$path','$path2', '', 0, '$insertTipo', 'visible',$seleccionada,1,$realSimulada,'$cadenaParametrosInsert','$directorioRaizSimulink ','$tituloPractica','$descripcionBrevePractica','$descripcionPractica',$enEdicion,'$ulogin')";
	queryEnBaseDatos($tabla,$query);
	$query="INSERT INTO sld_practices_data (sid, pname, pcname, categoria, path, stpath, purl, nfiles, type, visibilidad) VALUES ('1', '$nombrePractica_m', '$nombreCortoPractica', 'Pr&aacute;cticas del sistema t&eacute;rmico', '$path','$path2', '', 0, '$insertTipo', 'oculta')";
	queryEnBaseDatos($tabla,$query);
	
	// Si la practica es doble y no existe, adem�s de la simulada se realizan las mismas acciones para crear los ficheros
	// de la real.
	if($practicaDoble == 1 ){
		creacionArchivosPractica($nombrePractica2,$file2,$directorioRaizArchivos,
				$file_plantilla2,$file_plantilla_user,$directorioRaizUsuario);
		
		$query="INSERT INTO sld_practices_data_2 (sid, pname, pcname, categoria, path, stpath, purl, nfiles, type, visibilidad,tipoSistema,tipoEsquema,tipoEjecucion,parametros,ficheroSimulink,tituloPractica,descripcionBreve,descripcionLarga,enEdicion,ulogin) VALUES ('1', '$nombrePractica2_m', '$nombreCortoPractica', 'Pr&aacute;cticas del sistema t&eacute;rmico', '$path21','$path22', '', 0, 'Real', 'oculta',$seleccionada,1,$realSimulada,'$cadenaParametrosInsert','$directorioRaizSimulink','$tituloPractica','$descripcionBrevePractica','$descripcionPractica',$enEdicion,'$ulogin')";
		queryEnBaseDatos($tabla,$query);
		$query="INSERT INTO sld_practices_data (sid, pname, pcname, categoria, path, stpath, purl, nfiles, type, visibilidad) VALUES ('1', '$nombrePractica2_m', '$nombreCortoPractica', 'Pr&aacute;cticas del sistema t&eacute;rmico', '$path21','$path22', '', 0, 'Real', 'oculta')";
		queryEnBaseDatos($tabla,$query);
	}
}

// Se crea fichero zip con todos los archivos de la pr�ctica
function crearFicheroZip($nombrePractica,$directorioFicheroZip,$directorioRaizArchivos){
	global $tipoPractica;
	$nombrePractica_m = "m_".$nombrePractica;
	$zip = new zip();
	$zip->add_dir("out");
	$zip->add_file($directorioFicheroZip."$nombrePractica/$nombrePractica.php","$nombrePractica.php");
	$zip->add_file($directorioFicheroZip."$nombrePractica/$nombrePractica.html","salida.html");
	$zip->add_file($directorioFicheroZip."$nombrePractica/$nombrePractica.mdl","$nombrePractica.mdl");
	$zip->add_file($directorioFicheroZip."$nombrePractica/$nombrePractica_m.m","$nombrePractica_m.m");
	
	if($tipoPractica == "ter")
		$zip->add_file("../../templates_termicos/simulada/out/sist_term.JPG","out/sist_term.JPG");
	else
		$zip->add_file("../../templates_termicos/simulada/out/motor_pid.JPG","out/motor_pid.JPG");
	
	$fileName = $directorioRaizArchivos.$nombrePractica."/".$nombrePractica.".zip";
	$fd = fopen ($fileName, "wb");
	$out = fwrite ($fd, $zip->file());
	fclose ($fd);
}

// Funcion de querys sobre la base de datos
function queryEnBaseDatos($tabla,$query){	
	$sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();
	$sql->SQLQuery($query);
}

// Se sube un fichero simulink con el nombre recibido por par�metro
function subirFicheroSimulink($texto,$nombrePractica,$directorioRaizSimulink){

	$texto = substr($_FILES['mdl']['name'],strlen($_FILES['mdl']['name'])-4,4);
	$iguales = strcmp($texto, ".mdl");
	if($iguales == 0){
		copy($_FILES['mdl']['tmp_name'],$directorioRaizSimulink."$nombrePractica/"."$nombrePractica.mdl");
		echo "El archivo MDL ha sido subido correctamente al servidor.<br>";
		$nom=$_FILES['mdl']['name'];
	}
	else{
		echo "El archivo subido no es un archivo mdl.<br>";
	}
}

// Se selecciona el fichero plantilla en funci�n del tipo de pr�ctica que se haya seleccionado en la pantalla
// Inicial
function seleccionarPlantillas($realSimulada){
	global $file_plantilla_user,$seleccionada, $file,$file2, $archivoMdl,$tipoPractica,$file_plantilla,$file_plantilla2; // No llega bien el parametro seleccionada
	// Switch para selecci�n de pr�ctica: t�rmico, motor...
	switch ($seleccionada)
	{
		case "1": // Caso de t�rmicos
			if($realSimulada == 1){ // Pr�ctica simulada
				$file = 'D:/www/templates_termicos/simulada/template_termicos.m';
				$archivoMdl ='termicos.mdl';
				$tipoPractica='ter';
				$imagen='imagen.JPG';
				$file_plantilla="D:/www/templates_termicos/simulada/template_simulado_salida.html";
				$file_plantilla_user="D:/www/templates_termicos/template_m_termicos.php";
			}
			if($realSimulada == 2){ // Pr�ctica real
				$file = 'D:/www/templates_termicos/real/template_termicor.m';
				$archivoMdl ='termicos.mdl';
				$tipoPractica='ter';
				$imagen='imagen.JPG';
				$file_plantilla="D:/www/templates_termicos/real/template_real_salida.html";
				$file_plantilla_user="D:/www/templates_termicos/template_m_termicos.php";
			}
			if($realSimulada == 3){ // se crea una practica por duplicado ( Real y simulada )
				$file = 'D:/www/templates_termicos/simulada/template_termicos.m';
				$archivoMdl ='termicos.mdl';
				$imagen='imagen.JPG';
				$file_plantilla="D:/www/templates_termicos/simulada/template_simulado_salida.html";
				
				$file2 = 'D:/www/templates_termicos/real/template_termicor.m';
				$file_plantilla2="D:/www/templates_termicos/real/template_real_salida.html";
				$file_plantilla_user="D:/www/templates_termicos/template_m_termicos.php"; // De momento hacemos q este sea el mismo para real y simulado
				$tipoPractica='ter';
			}
			break;
		case "2":	// Caso de motor
			$file = 'D:/www/templates_termicos/simulada/template_termicos.m';
			$archivoMdl ='termicosc.mdl';
			$tipoPractica='mot';
			$file_plantilla="D:/www/templates_termicos/simulada/template_simulado_salida.html";
			break;
		case "3":
			break;
		case "4":
			break;
	}
}

// Se crea un fichero .m con los par�metros principales y sus valores
function creacionFicheroPlantilla($nombrePractica,$file,$directorioRaizArchivos){
	global $cadenaValidacion,$numParametros,$tipoPractica,$fecha;

	// Se lee el contenido del fichero
	$current = file_get_contents ( $file );  
	// Se sustituye el texto parametrizado en el archivo por los valores reales introducidos en la configuracion de la
	// practica
	$bodytag = str_replace('%Nombre_practica',"%".$nombrePractica, $current);
	$nombreModificado="'".$nombrePractica."'";
	$bodytag = str_replace('%Nombre_corto_practica',$nombreModificado, $bodytag);
	$bodytag = str_replace('%Numero_parametros',$numParametros, $bodytag);
	$bodytag = str_replace('%Validacion_parametros',$cadenaValidacion, $bodytag);

	// Se crea un directorio con el nombre de la practica, dentro del cual se introduciran todos los archivos 
	// relacionados con esta.
	
	mkdir($directorioRaizArchivos.$nombrePractica, 0700);
	mkdir($directorioRaizArchivos.$nombrePractica."/out", 0700);
	// Se copia la imagen correspondiente en la carpeta /OUT
	if($tipoPractica == "ter")
		copy("../../templates_termicos/simulada/out/sist_term.jpg",$directorioRaizArchivos.$nombrePractica."/out/sist_term.jpg");
	else
		copy("../../templates_termicos/simulada/out/motor_pid.jpg",$directorioRaizArchivos.$nombrePractica."/out/motor_pid.jpg");
	
	// Se controla que la practica se haya creado de forma satisfactoria y se realiza el tratamiento necesario
	// para que los ficheros queden cerrados y guardados de forma correcta
	$control = fopen($directorioRaizArchivos.$nombrePractica."/m_".$nombrePractica.".m","w+");  
	if($control == false){  
	  die("No se ha podido crear el archivo.");  
	}

	// Se crea el fichero .m con las modificaciones necesarias
	$fileM = $directorioRaizArchivos.$nombrePractica."/m_".$nombrePractica.".m" ;
	file_put_contents ( $fileM , $bodytag ); 
	$fp = fopen($directorioRaizArchivos.$nombrePractica."/m_".$nombrePractica.".m","a");
	fwrite($fp, "Numero de parametros =".$numParametros." <---Este es ! " . PHP_EOL);
	fclose($fp); 
}


function creacionFicheroSalidaWeb($nombrePractica,$file,$directorioRaizArchivos){
	global $tituloPractica, $nombreCortoPractica,$file_plantilla,$cadenaValidacion,$numParametros,$tipoPractica,$fecha,$cadenaParametrosWeb;

	$current = file_get_contents ( $file_plantilla ); 
	$vectorParametrosSustituir = array ( '%Nombre_practica', '%Bucle_parametros','%Nombre_corto_practica');
	$vectorParametrosNuevos = array ( "$tituloPractica", "$cadenaParametrosWeb",$nombrePractica.".mat");
	$bodytag="";
	// Se sustituye el texto parametrizado en el archivo por los valores reales introducidos en la configuracion de la
	// practica
	$bodytag= sustituirParametros($current,$bodytag,$vectorParametrosSustituir,$vectorParametrosNuevos);
	
	$archivoACrear=$directorioRaizArchivos.$nombrePractica."/salida.html";
	crearArchivo($archivoACrear,$bodytag);
}

function creacionFicheroSalidaWebUser($nombrePractica,$file,$directorioRaizUsuario){
	global $nombrePracticaOriginal,$descripcionBrevePractica,$nombreCortoPractica,$file_plantilla_user,$cadenaParametrosWeb_user1,$cadenaParametrosWeb_user2,$descripcionPractica,$tituloPractica;

	$current = file_get_contents ( $file_plantilla_user ); 
	// Se sustituye el texto parametrizado en el archivo por los valores reales introducidos en la configuracion de la
	// practica
	$nombreSinTerminacion=substr($nombrePractica, 0, -1);
	$vectorParametrosSustituir = array ( '%Nombre_practica', '%Introduccion','%Nombre_corto_practica','%Bucle_parametros1','%Bucle_parametros2','%Descripcion_Practica' );
	$vectorParametrosNuevos = array ( "$tituloPractica", "$descripcionBrevePractica","$nombreSinTerminacion","$cadenaParametrosWeb_user1","$cadenaParametrosWeb_user2","$descripcionPractica");
	$bodytag="";
	$bodytag= sustituirParametros($current,$bodytag,$vectorParametrosSustituir,$vectorParametrosNuevos);
	
	$archivoACrear=$directorioRaizUsuario.$nombrePractica."/".$nombrePractica.".php";
	crearArchivo($archivoACrear,$bodytag);

}

// Se crea un archivo con la ruta especificada y el contenido recibido por par�metro
function crearArchivo($archivoACrear,$contenido){
	$control = fopen($archivoACrear,"w+");  
	if($control == false){  
	  die("No se ha podido crear el archivo.");  
	}

	// Se crea el fichero .m con las modificaciones necesarias
	file_put_contents ( $archivoACrear , $contenido ); 
}


function sustituirParametros($current,$bodytag,$vectorParametrosSustituir,$vectorParametrosNuevos){
	$i=0;
	while($vectorParametrosSustituir[$i] != null){
		if($i == 0){
			$bodytag = str_replace($vectorParametrosSustituir[$i],$vectorParametrosNuevos[$i], $current);
		}
		else{
			$bodytag = str_replace($vectorParametrosSustituir[$i],$vectorParametrosNuevos[$i], $bodytag);
		}
		$i++;
	}
	return $bodytag;

}

// Se definen los parametros a�adidos dinamicamente en el formato etiqueta = valorPorDefecto
function definicionParametrosPrincipales($fp){
	global $names,$valorDefectos,$etiquetas,$valorMinimos,$valorMaximos,$cadenaValidacion,$numParametros,$cadenaParametrosWeb,$cadenaParametrosWeb_user1,$cadenaParametrosWeb_user2;
	global $cadenaParametrosInsert,$cadenaValoresParametrosInsert,$cadenaMaximosInsert,$cadenaMinimosInsert;
	$cadenaValidacion="";
	$i=0;
	foreach($names as $name) { 
		if($i ==0)
			$simboloAnd="";
		else
			$simboloAnd=" &&";
		if($name != null){
			$valorDefecto1 = each($valorDefectos);
			$etiqueta = each($etiquetas);
			fwrite($fp,$etiqueta[1]."=".$valorDefecto1[1].";");
			
			if($valorDefecto1[1] == null){
				$valorDefecto1[1]=0;
			}
			$valorMinimo1=each($valorMinimos);
			if($valorMinimo1[1] == null){
				$valorMinimo1[1]=0;
			}
			$valorMaximo1=each($valorMaximos);
			if($valorMaximo1[1] == null){
				$valorMaximo1[1]=0;
			}
			$cadenaValidacion=$cadenaValidacion.$simboloAnd." ".$etiqueta[1]." >= ".$valorMinimo1[1]." && ".$etiqueta[1]." < ".$valorMaximo1[1];
			
			// Par�metros para la salida WEB
			$cadenaParametrosWeb=$cadenaParametrosWeb."<tr><td width='175'>".$name."</td><td width='70'>".$etiqueta[1]."=$".$etiqueta[1]."$</td></tr>";
			$cadenaParametrosWeb_user1=$cadenaParametrosWeb_user1." <tr><td>".$etiqueta[1]."</td><td><input name='".$etiqueta[1]."' type='text' class='input_field' value='".$valorDefecto1[1]."' size='15' /></td></tr>";
			$cadenaParametrosWeb_user2=$cadenaParametrosWeb_user2."<tr><td width='20'><span class='Estilo3'>".$etiqueta[1].":</span></td><td width='175'><span class='Estilo3'>".$name."</span></td></tr>";
			
			$cadenaParametrosInsert.=$name.";".$etiqueta[1].";".$valorDefecto1[1].";".$valorMinimo1[1].";".$valorMaximo1[1].";";
			$cadenaValoresParametrosInsert.=$valorDefecto1[1].";";
			$cadenaMaximosInsert.=$valorMaximo1[1].";";
			$cadenaMinimosInsert.=$valorMinimo1[1].";";
			
			$numParametros++;
		}
		$i++;
	}
}

function eliminarDir($carpeta){
	foreach(glob($carpeta."/*") as $archivos_carpeta) {
		//echo $archivos_carpeta;
		if(is_dir($archivos_carpeta))
			eliminarDir($archivos_carpeta);
		else
			unlink($archivos_carpeta);
	}
	rmdir($carpeta);
}

?>

