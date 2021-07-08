function getXhttp(){
    var xhttp = false;
    if (window.XMLHttpRequest) {
        // code for modern browsers
        xhttp = new XMLHttpRequest();
    } else {
        // code for old IE browsers
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    return xhttp;
}

function ajax(datos, contenedor, obj){
    divResultado = document.getElementById(contenedor);
    valor= obj.value;
    xhttp = getXhttp();
    xhttp.open("POST", datos, true);

    xhttp.onreadystatechange=function(){
        if(xhttp.readyState==1)
        {
            divResultado.innerHTML='cargando...';
        }
        else if(xhttp.readyState == 4){
            divResultado.innerHTML = xhttp.responseText;
        }
    }

    xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //enviando los valores
    xhttp.send("usu="+valor);
}

function ajaxjquery(pagina, contenedor, obj) {
    var selected = $("#libros option:selected").text();
    var selected2 = $("#capitulos option:selected").text();
    var content = $('#' + contenedor);
    $.ajax({
        type: "POST",
        url: "" + pagina,
        //data: {"selected=" + selected, "selected2=" + selected},
        data: {selected: selected, selected2: selected2 },
        //datatype: "json";
        success: function(data) {
            content.html(data);
        }
    });
                                          }