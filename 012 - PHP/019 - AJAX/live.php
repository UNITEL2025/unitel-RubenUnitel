<?php
//Crear un objeto DOMDocument
//Clases especiales para trabajar con XML
$xmlDoc=new DOMDocument();
//carga el archivo XML
$xmlDoc->load("links.xml");
//Obtiene los datos de las etiquetas link
$x=$xmlDoc->getElementsByTagName('link');
//Obtiene el param q (GET)
$q=$_GET["q"];

//Crompueba si q tiene longitud
if (strlen($q)>0) {
  $hint=""; //Es donde se va a guardar el resultado
  //Recorrer el objeto DOMDocument
  //Tiene un ppdad: $x->length (longitud)
  for($i=0; $i < ($x->length); $i++) {
    $y=$x->item($i)->getElementsByTagName('title'); //Obtiene la etiqueta título
    $z=$x->item($i)->getElementsByTagName('url'); //Obtiene la etiqueta url
    if ($y->item(0)->nodeType==1) {//Si existe contenido en la etiq ueta title
      //Encuentra el link en sí, y monta el código HTML (enlace)
      if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
        if ($hint=="") {
          $hint="<a href='" .
          $z->item(0)->childNodes->item(0)->nodeValue .
          "' target='_blank'>" .
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        } else {
          $hint=$hint . "<br /><a href='" .
          $z->item(0)->childNodes->item(0)->nodeValue .
          "' target='_blank'>" .
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        }
      }
    }
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
  $response="no suggestion";
} else {
  $response=$hint;
}

//Devolución de la respuesta
echo $response;
?>