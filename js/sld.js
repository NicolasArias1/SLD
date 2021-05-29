
//Variables globales
var myRand = parseInt(Math.random()*999999999999999);
var ids = new Array();
var i = 0;
var j = 0;
var myUrl = '';
var vUrl = '';
var xmlHttp = getXMLHTTPRequest();

//Crear el objeto XMLHttpRequest
function getXMLHTTPRequest() {
	//Almacenar� la referencia al objeto XMLHttpRequest
  var xmlHttp;
  
  //Esto debe funcionar para todos los navegadores excepto IE6 y m�s antiguos
  try {
    //Intenta crear el objeto XMLHttpRequest
    xmlHttp = new XMLHttpRequest();
  }//end try
  catch(e) {
    //Asume IE6 o m�s antiguo
    var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
                                    "MSXML2.XMLHTTP.5.0",
                                    "MSXML2.XMLHTTP.4.0",
                                    "MSXML2.XMLHTTP.3.0",
                                    "MSXML2.XMLHTTP",
                                    "Microsoft.XMLHTTP");
    
    //Prueba cada id hasta que uno funciona
    for(var i=0; i < XmlHttpVersions.length && !xmlHttp; i++) {
      try { 
        //Prueba a crear el objeto XMLHttpRequest
        xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
      }//end try
      catch(e) {} //Ignora error potencial
    }//end for
  }//end catch
  
  //Devuelve el objeto creado o muestra un mensaje de error
	if(!xmlHttp)
    alert("Error al crear el objeto XMLHttpRequest.");
  else 
    return xmlHttp;
}//end function


//Enviar
function execute(ptype) {
	document.getElementById('mlmfile').value = ptype;
	document.getElementById('practice').submit();
}//end function

function nonexecute() {
	alert('Para poder ejecutar las pr�cticas tiene que autentificarse primero');
}//end function

//Crear cadena de IDs en la URL a partir de la selecci�n de los usuarios
function checkedItems(id, limit) {
	if(id == '*') { //Selecci�n multiple
		//Verificando selecci�n
		i=1;
		while(i <= limit) {
			if(document.getElementById(i) && document.getElementById(i).checked == true) {
				ids[j] = document.getElementById(i).value;
				j++;
			}//end if
			i=i+1;
		}//end while
		
		//Creando URL a partir de la selecci�n
		i=0;
		while(i < j) {
			myUrl += ids[i];
			if(i < (j-1))
				myUrl += ':';
			i=i+1;
		}//end while
		myUrl += '&rand='+myRand;
	}//end if
	else { //Selecci�n �nica
		j = 1;
		myUrl += id+'&rand='+myRand;
	}//end else	
}//end function

//Cargar la p�gina despu�s de procesar datos en el servidor
function reloadPage() {
	if(xmlHttp.readyState == 4) {
		if(xmlHttp.status == 200) {
			window.location.reload();
    }//end if
  }//end if
}//end function

//Color gris sobre el recurso
function colorOver(numBox) {
	if(!document.getElementById(numBox) || !document.getElementById(numBox).checked)
		document.getElementById('resource_'+numBox).style.background = "#EEEEEE";
}//end function

//Color blanco fuera del recurso
function colorOut(numBox) {
	if(!document.getElementById(numBox) || !document.getElementById(numBox).checked)
		document.getElementById('resource_'+numBox).style.background = "#FFFFFF";
}//end function

//Seleccionar recurso
function selectResource(numBox) {
	if(document.getElementById(numBox)) {
		if(!document.getElementById(numBox).checked) {
			document.getElementById(numBox).checked = true;
			document.getElementById('resource_'+numBox).style.background = "#EEEEEE";
		}//end if
		else if(document.getElementById(numBox).checked) {
			document.getElementById(numBox).checked = false;
			document.getElementById('resource_'+numBox).style.background = "#FFFFFF";
		}//end if
	}//end if
}//end function

//Mostrar opciones
function showOptions(idButton, idList) {
	document.getElementById(idButton).style.border = "1px solid #003366";
	document.getElementById(idButton).style.background = "#EEEEEE";
	document.getElementById(idList).style.display = "block";
}//end function

//Ocultar opciones
function hideOptions(idButton, idList) {
	document.getElementById(idButton).style.border = "1px solid #FFFFFF";
	document.getElementById(idButton).style.background = "#FFFFFF";
	document.getElementById(idList).style.display = "none";
}//end function

//Color sobre el elemento
function colorOverElement(idElement) {
	document.getElementById(idElement).style.background = "#EEEEEE";
}//end function

//Color fuera del elemento
function colorOutElement(idElement) {
	document.getElementById(idElement).style.background = "#FFFFFF";
}//end function

//Seleccionar todos los recursos
function checkAll(check, limit, lid, lopt) {
	for(i=1; i <= limit; i++) {
		if(check && document.getElementById(i)) {
			document.getElementById(i).checked = true;
			document.getElementById('resource_'+i).style.background = "#EEEEEE";
		}//end if
		if(!check && document.getElementById(i)) {
			document.getElementById(i).checked = false;
			document.getElementById('resource_'+i).style.background = "#FFFFFF";
		}//end if
	}//end for
	
	//Ocultar opciones
	hideOptions(lid, lopt);
}//end function

//Seleccionar solo los mios
function checkMine(check, limit, lid, lopt) {
	checkAll(false, limit, lid, lopt);
	
	for(var i=1; i <= limit; i++) {
		if(check && document.getElementById('mine_'+i)) {
			document.getElementById(i).checked = true;
			document.getElementById('resource_'+i).style.background = "#EEEEEE";
		}//end if
	}//end for
	
	//Ocultar opciones
	hideOptions(lid, lopt);
}//end function

//Seleccionar los nuevos
function checkNews(check, limit, lid, lopt) {
	checkAll(false, limit, lid, lopt);
	
	for(var i=1; i <= limit; i++) {
		if(check && document.getElementById('new_'+i)) {
			document.getElementById(i).checked = true;
			document.getElementById('resource_'+i).style.background = "#EEEEEE";
		}//end if
	}//end for
		
	//Ocultar opciones
	hideOptions(lid, lopt);
}//end function

//Cambiar preferencias
function schPreferences(page, schUrl, order, nelements, id) {
	myUrl = page+'?'+schUrl+'&order='+order+'&show='+nelements+'&page=1'+id;
	
	goPage(myUrl);
}//end function

//Ir a una pagina determinada
function goPage(page) {
	window.location = page;
}//end function

//Validar y salvar comentario
function saveComment() {
	if((document.getElementById('comment_txt').value != ''))
		document.getElementById('comment_form').submit();
  else
  	alert('No se puede realizar la operaci�n:\nVerifique sus datos, hay campos vac�os.');
}//end function

function newComment() {
	document.getElementById('id').value = '';
	document.getElementById('action').value = 'new';
}//end function
