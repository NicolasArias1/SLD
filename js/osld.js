//Borar recursos
function deleteResources(id, limit, body, order, show, page, level, rpage, called) {
	vUrl = rpage+'?body='+body+'&order='+order+'&show='+show+'&page='+page;
	myUrl = '../../utilities/updatepractices.mod.php?action=delete&body='+body+'&order='+order+'&show='+show+'&page='+page+'&level='+level+'&id=';
	checkedItems(id, limit);
	//prompt('url', myUrl);
	if(j != 0 && j > 1)
		rs = confirm('Esta seguro que desea eliminar estos recursos?');
	else if(j != 0)
		rs = confirm('Esta seguro que desea eliminar este recurso?');
	else
		rs = false;
	
	if(rs) {
		xmlHttp.open('GET', myUrl, true);
		if(called == 'edit')
			xmlHttp.onreadystatechange = reloadContent;
		else
			xmlHttp.onreadystatechange = getContent;
		xmlHttp.send(null);
		location.reload();
	}//end if	
	location.reload();
}//function

//Recargar contenido
function getContent() {
	if(xmlHttp.readyState == 4) {
		if(xmlHttp.status == 200) {
			var resHTML = xmlHttp.responseText;
			if(document.getElementById('results_box'))
			 document.getElementById('results_box').innerHTML = resHTML;
		}//end if    
  }//end if
}//end function

//Recargar p�gina
function reloadContent() {
	if(xmlHttp.readyState == 4) {
		if(xmlHttp.status == 200) {
			goPage(vUrl);
    }//end if    
  }//end if
}//end function

function deleteUsers(id, limit, body, order, show, page) {
	myUrl = '../../utilities/updateusers.mod.php?action=delete&body='+body+'&order='+order+'&show='+show+'&page='+page+'&id=';
	checkedItems(id, limit);
	
	if(j != 0 && j > 1)
		rs = confirm('Est� seguro que desea eliminar estos usuarios?');
	else if(j != 0)
		rs = confirm('Est� seguro que desea eliminar este usuario?');
	else
		rs = false;
	
	if(rs) {
		xmlHttp.open('GET', myUrl, true);
		xmlHttp.onreadystatechange = getContent;
		xmlHttp.send(null);		
		location.reload();
	}//end if
	location.reload();
}//end function

//Abrir comentario
function openComment(id, numBox) {
	if(id) {
		document.getElementById('id').value = id;
		document.getElementById('action').value = 'edit';
		
		myUrl = '../../utilities/updatecontribution.mod.php?action=select&id='+id+'&rand='+myRand;
		selectResource(numBox);
		
		xmlHttp.open('GET', myUrl, true);
		xmlHttp.onreadystatechange = getComment;
		xmlHttp.send(null);
	}//end if
}//end function

//Recargar comentarios
function getComment() {
	if(xmlHttp.readyState == 4) {
		if(xmlHttp.status == 200) {
			var comment = xmlHttp.responseText;
			document.getElementById('comment_txt').value = comment;
    }//end if    
  }//end if
}//end function

//Borrar comentarios
function deleteComments(id, rid, advuser, limit) {
	myUrl = '../../utilities/updatecontribution.mod.php?action=delete&advuser='+advuser+'&rid='+rid+'&id=';
	checkedItems(id, limit);
	
	if(j != 0 && j > 1)
		rs = confirm('Est� seguro que desea eliminar estos comentarios?');
	else if(j != 0)
		rs = confirm('Est� seguro que desea eliminar este comentario?');
	else
		rs = false;
	
	if(rs) {
		xmlHttp.open('GET', myUrl, true);
		xmlHttp.onreadystatechange = getCommentsBox;
		xmlHttp.send(null);
	}//end if
}//end function

//Recargar caja de comentarios
function getCommentsBox() {
	if(xmlHttp.readyState == 4) {
		if(xmlHttp.status == 200) {
			var comments = xmlHttp.responseText;
			if(comments)
				document.getElementById('comments_box').innerHTML = comments;
			else
				document.getElementById('comments_box').style.display = 'none';
    }//end if    
  }//end if
}//end function

//Aceptar comentarios
function acceptComments(id, rid, limit) {
	myUrl = '../../utilities/updatecontribution.mod.php?&action=accept&rid='+rid+'&id=';
	checkedItems(id, limit);
	
	if(j != 0 && j > 1)
		rs = confirm('Está seguro que desea publicar estos comentarios?');
	else if(j != 0)
		rs = confirm('Está seguro que desea publicar este comentario?');
	else
		rs = false;
	
	if(rs) {
		xmlHttp.open('GET', myUrl, true);
		xmlHttp.onreadystatechange = reloadPage;
		xmlHttp.send(null);
	}//end if
}//end function