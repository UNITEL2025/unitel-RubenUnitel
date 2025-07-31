<?php
//Define es un array que se llama
//Donde se definen las posibles sugerencias de nombre que tenemos disponible
$a[] = "Ruben";
$a[] = "Anna";
$a[] = "Brittany";
$a[] = "Cinderella";
$a[] = "Diana";
$a[] = "Eva";
$a[] = "Fiona";
$a[] = "Gunda";
$a[] = "Hege";
$a[] = "Inga";
$a[] = "Johanna";
$a[] = "Kitty";
$a[] = "Linda";
$a[] = "Nina";
$a[] = "Ophelia";
$a[] = "Petunia";
$a[] = "Amanda";
$a[] = "Raquel";
$a[] = "Cindy";
$a[] = "Doris";
$a[] = "Eve";
$a[] = "Evita";
$a[] = "Sunniva";
$a[] = "Tove";
$a[] = "Unni";
$a[] = "Violet";
$a[] = "Liza";
$a[] = "Elizabeth";
$a[] = "Ellen";
$a[] = "Wenche";
$a[] = "Vicky";

// Obtener la variable $_GET que se llama "q"
//Ejemplo, si el usuario ha indicado la "a", $q = "a";
$q = $_REQUEST["q"];
//Varible de sugerencia, donde se guardarán las sugerencias que le daremos al usuario
$hint = "";

// Busca el/los nombre/s que se le pueden sugerir
//Comprubar que el string no esté vacío
if ($q !== "") {
  $q = strtolower($q);//Transforma el valor de q en minuscula (Redundante)
  $len=strlen($q);//Obtiene la longitud del string
  //Recorre el array de nombres
  foreach($a as $name) {
    //stristr devolverá el string completo si lo encuentra
    //En caso contrario devolverá false
    if (stristr($q, substr($name, 0, $len))) {
      //Si lo encuentra entra en el if
      //Si hint está vacío, añade el string
      if ($hint === "") {
        $hint = $name;
      //Si no está vacío, lo concateno
      } else {
        $hint .= ", $name";
      }
    }
  }
}

//Devolver $hint con la sugerencia
//Si $hint está vacío, devuelve la cadena de texto "sin sugerencias" 
//Si $hint no está vacío, devuelve la cadena que hemos montado: "Anna, Anabele"
echo $hint === "" ? "no suggestion" : $hint;


/**
 * Resumen de pasos:
 * 1) Ejecutamos el php y mostramos el html: vacío (no hay datos del user)
 * 2) Una vez cargado el HTML, el user interactúa
 * 3) El user escribe la letra "R"
 * 4) Se activa el evento onkeyup, que llama a la función de JS
 * 5) La función ejecuta un AJAX
 * 6) El AJAX ejecuta el archivo php, y este devuelve un valor: "Ruben, Raquel"
 * 7) En la misma función de JS, se sustituye el contenido en el HTML (dinámico)
 * QUIZ: No hemos tenido que recargar la página, sólo se ha modificado una parte
 */