//  Vamos a presuponer que el usuario es una persona inteligente...
var isIE = false;
//  Creamos una variable para el objeto XMLHttpRequest
var req;
//  Creamos una funcion para cargar los datos en nuestro objeto.
//  Logicamente, antes tenemos que crear el objeto.
//  Vease que la sintaxis varia dependiendo de si usamos un navegador decente
//  o Internet Explorer
function cargaXML(url) {
    //  Primero vamos a ver si la URL es una URL :)
    if(url==''){
        return;
    }
    //  Usuario inteligente...
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processReqChange;
        req.open("GET", url, true);
        req.send(null);
    //  ...y usuario de Internet Explorer Windows
    } else if (window.ActiveXObject) {
        isIE = true;
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url, true);
            req.send();
        }
    }
}

function processReqChange(){
    //    Referencia a nuestro DIV con ID unica:
    var detalles = document.getElementById("detalles");
    //    Si se ha completado la carga de datos, los mostramos en el DIV...
    if(req.readyState == 4){
        detalles.innerHTML = req.responseText;
    } else {
        //    ...en caso contrario, le diremos al usuario que los estamos cargando:
        detalles.innerHTML = '<img src="loading.gif" align="absmiddle" /> Cargando...';
    }
}