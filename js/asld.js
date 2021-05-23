//Selecci�n del privilegio
function usersLevel(level) {
	if(document.getElementById('domain')) {
		if(level == '1') {
			document.getElementById('administrador').checked = true;
		}//end if
		else if(level == '2') {
			document.getElementById('operador').checked = true;
		}//end else if
		else {
			document.getElementById('usuario').checked = true;
		}//end else
	}//end if
}//function

//Validar y enviar datos de usuarios
function saveUser(act) {
	//alert('holaaaaaaaaa');
	if((document.getElementById('name').value != '') && (document.getElementById('login').value != '') && (document.getElementById('mail').value != '') && (document.getElementById('domain').value != '')) {
		var valid = false;
		var validEmail = document.getElementById('mail').value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.biz)|(\.inf)|(\.int)|(\.cat)|(\.pro)|(\..{2,2}))$)\b/gi);
		//var validEmail = document.getElementById('mail').value.match(/\b(^(\S+@).+((\..{4,4})|(\..{3,3})|(\..{2,2}))$)\b/gi);			
		
		if(act == 'new' && document.getElementById('password').value != '' && document.getElementById('confirm').value != '' && (document.getElementById('password').value == document.getElementById('confirm').value))
			valid = true;
		else if(act == 'new')
			alert('No se puede realizar la operaci�n:\nVerifique su usuario, las contrase�as no se han entrado o no coinciden.');
		
		if(act == 'edit') {
			if(document.getElementById('domain').value == 'db') {
				if(document.getElementById('password') && document.getElementById('confirm')) {
					if(document.getElementById('password').value == document.getElementById('confirm').value)	
						valid = true;
					else
						alert('No se puede realizar la operaci�n:\nVerifique su usuario, las contrase�as no se han entrado o no coinciden.');
				}//end if
				else
					valid = true;
			}//end if
			else
				valid = true;
		}//end if
		
		if(valid) {
			if(validEmail)
				document.getElementById('frmuser').submit();
			else
				alert('No se puede realizar la operaci�n:\nVerifique su usuario, la direcci�n de correo no es correcta.');
		}//end if
  }//end if
 	else {
  	alert('No se puede realizar la operaci�n:\nVerifique su usuario, hay campos vac�os.');
	}//end else
}//function

//Validar y enviar datos de usuarios
function saveRegistration() {
	if((document.getElementById('uname').value != '') && (document.getElementById('ulogin').value != '') && (document.getElementById('umail').value != '') && document.getElementById('upassword').value != '' && document.getElementById('uconfirm').value != '') {
		var valid = false;
		var validEmail = document.getElementById('umail').value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi);
		
		if(document.getElementById('upassword').value == document.getElementById('uconfirm').value)
			valid = true;
		else
			alert('No se puede realizar la operaci�n:\nVerifique su usuario, las contrase�as no coinciden.');
		
		if(valid) {
			if(validEmail)
				document.getElementById('frmuser').submit();
			else
				alert('No se puede realizar la operaci�n:\nVerifique sus datos, la direcci�n de correo no es correcta.');
		}//end if
  }//end if
 	else {
  	alert('No se puede realizar la operaci�n:\nVerifique sus datos, hay campos vac�os.');
	}//end else
}//function

function savePersonalData() {
	if((document.getElementById('name').value != '') && (document.getElementById('login').value != '') && (document.getElementById('mail').value != '')) {
		var valid = false;
		var validEmail = document.getElementById('mail').value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi);		
		
		if(document.getElementById('password').value != '' && document.getElementById('confirm').value != '') {
			if(document.getElementById('password').value == document.getElementById('confirm').value)
				valid = true;
			else
				alert('No se puede realizar la operaci&oacute;n:\nVerifique su usuario, las contrase�as no coinciden.');
		}//end if
		else if((document.getElementById('password').value != '' && document.getElementById('confirm').value == '') || (document.getElementById('password').value == '' && document.getElementById('confirm').value != ''))
			alert('No se puede realizar la operaci&oacute;n:\nVerifique sus datos, hay campos vac&iacute;os.');
		else if(document.getElementById('password').value == '' && document.getElementById('confirm').value == '')
			valid = true;
		
		if(valid) {
			if(validEmail)
				document.getElementById('frmuser').submit();
			else
				alert('No se puede realizar la operaci&oacute;n:\nVerifique sus datos, la direcci&oacute;n de correo no es correcta.');
  	}//end if
  }//end if
 	else {
  	alert('No se puede realizar la operaci&oacute;n:\nVerifique sus datos, hay campos vac&iacute;os.');
	}//end else
}//function


//Nueva �rea de trabajo
function newArea(ncategories) {
	document.getElementById('name').value = "";
	document.getElementById('description').value = "";
	document.getElementById('id').value = "";
	
	for(i=1; i <= ncategories; i++) {
		document.getElementById('c_'+i).checked = false;
	}//end for
}//end function

//Editar �rea de trabajo
function editArea(id, lid, name, description) {
	selectResource(lid);
	
	document.getElementById('name').value = name;
	document.getElementById('description').value = description;
	document.getElementById('id').value = id;
	
	myUrl = '../../utilities/updateconfiguration.mod.php?action=select&id='+id+'&rand='+myRand;
	
	xmlHttp.open('GET', myUrl, true);
	xmlHttp.onreadystatechange = getUserList;
	xmlHttp.send(null);
}//function

//Seleccionar �rea
function selectArea(id, lid, lopt) {
	myUrl = '../../utilities/updateusers.mod.php?action=select&id='+id+'&rand='+myRand;
	
	xmlHttp.open('GET', myUrl, true);
	xmlHttp.onreadystatechange = getCategories;
	xmlHttp.send(null);
	
	hideOptions(lid, lopt);
}//function

//Recargar categorias
function getUserList() {
	if(xmlHttp.readyState == 4) {
		if(xmlHttp.status == 200) {
			var resHTML = xmlHttp.responseText;
			if(document.getElementById('user_list'))
				document.getElementById('user_list').innerHTML = resHTML;
		}//end if    
  }//end if
}//end function

//Borrar �rea
function deleteArea(id, limit, order, show, page) {
	myUrl = '../../utilities/updateconfiguration.mod.php?action=delete&order='+order+'&show='+show+'&page='+page+'&id=';
	checkedItems(id, limit);
	
	if(j != 0 && j > 1)
		rs = confirm('Est&aacute; seguro que desea eliminar estas &aacute;reas de trabajo?');
	else if(j != 0)
		rs = confirm('Est&aacute; seguro que desea eliminar esta &aacute;rea de trabajo?');
	else
		rs = false;
	
	xmlHttp.open('GET', myUrl, true);
	xmlHttp.onreadystatechange = getContent;
	xmlHttp.send(null);
}//function

//Validar y enviar datos de �rea
function validArea(ncategories) {
	var valid = false;
	if(document.getElementById('name') && document.getElementById('description')) {
		for(var i=1; i <= ncategories; i++) {
			if(document.getElementById('c_'+i).checked) {
				valid = true;
				i = ncategories;
			}//end if
		}//end for
		
		if(valid)
			document.getElementById('frmarea').submit();
		else
			alert('No se puede realizar la operaci&oacute;n:\nVerifique su &aacute;rea, hay campos vac&iacute;os.');
	}//end if
}//end if

//Validar y salvar practica revisada
function practicesrev() {
	
		document.getElementById('rev_form').submit();
 
}//end function

//Validar y salvar practica a revisar
function revisar() {
	
		document.getElementById('revisar_form').submit();
 
}//end function