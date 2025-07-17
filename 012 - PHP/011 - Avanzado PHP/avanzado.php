<?php

//Añadir el archivo Car.php a este script
include "Car.php";
//require "Car2.php";

# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/011%20-%20Avanzado%20PHP/avanzado.php

//Fechas
echo "Today is " . date("Y/m/d") . "<br>";
echo "Today is " . date("Y.m.d") . "<br>";
echo "Today is " . date("Y-m-d") . "<br>";
echo "Today is " . date("l") . "<br>";

//Hora
echo "The time is " . date("H:i:s") . "<br>";;

//Convertir fecha de string a fecha
$d = strtotime("10:30pm April 15 2014");
echo "Created date is " . date("Y-m-d h:i:sa", $d) . "<br>";;

//Creación de fechas
$d=strtotime("tomorrow");
echo date("Y-m-d h:i:sa", $d) . "<br>";

$d=strtotime("next Saturday");
echo date("Y-m-d h:i:sa", $d) . "<br>";

$d=strtotime("+3 Months");
echo date("Y-m-d h:i:sa", $d) . "<br>";

//Cuenta atrás
$d1=strtotime("October 29");
$d2=ceil(($d1-time())/60/60/24);
echo "There are " . $d2 ." days until fin de curso." . "<br>";

//Include/Require
/**
 * require will produce a fatal error (E_COMPILE_ERROR) and stop the script
 * include will only produce a warning (E_WARNING) and the script will continue
 */
$myCar = new Car("Azul", "Ford");
echo "El coche es de color: ".$myCar->color."<br>";

//Lectura de archivo
echo  readfile("listado de codigos.txt");

//Apertura de archivo
$myfile = fopen("listado de codigos.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("listado de codigos.txt"));
fclose($myfile);

//Lectura de archivo línea a línea
echo "<br><br>";
$myfile = fopen("listado de codigos.txt", "r") or die("Unable to open file!");
//echo fgets($myfile);
$lineas = array();
if ($myfile) {
    while (($buffer = fgets($myfile, filesize("listado de codigos.txt"))) !== false) {
        $lineas[] = $buffer;
    }
    if (!feof($myfile)) {
        echo "Error: fgets() falló\n";
    }
    fclose($myfile);
}
//Imprimir el archivo línea a línea
foreach ($lineas as $key => $value) {
    echo $value."<br>";
}

//Crear y escribir un archivo
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);
echo "Archivo creado!<br>";

//Añadir texto al archivo
$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
$txt = "Donald Duck\n";
fwrite($myfile, $txt);
$txt = "Goofy Goof\n";
fwrite($myfile, $txt);
fclose($myfile);
echo "Archivo actualizado!<br>";

//Ejemplo de log
function addLog(string $str, int $severity = 0) : void
{
    $name_severity;
    switch ($severity)
    {
        case 0: 
            $name_severity = "INFO";
            break;
        case 1: 
            $name_severity = "PELIGRO";
            break;
        case 2: 
            $name_severity = "ERROR";
            break;
        case 3: 
            $name_severity = "CRITICAL";
            break;
    }

    //1. Abrir el archivo
    $myfile = fopen("log.txt", "a") or die("Unable to open file!");
    //2.Escribir
    fwrite($myfile, "[".date('d-m-Y H:i:s')."] "."[".$name_severity."] ".$str."\n");
    //3. Cerrar archivo
    fclose($myfile);
}

addlog("Hemos creado el primer registro del log.", 1);
addlog("Hemos añadido una nueva línea.", 0);

//Subida de archivos
//Directorio de subida
$target_dir = "uploads/";
//Path del archivo
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//Variable de control para php
$uploadOk = 1;
//Extensión del archivo
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    //Verificar que el archivo tiene tamaño > 0 bytes
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    //Si pasa el chequeo
    if($check !== false) {
        //Confirmamos la subida del archivo
        echo "<br>File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    //Imagen no correcta (corrupta, etc...)
    } else {
        echo "<br>File is not an image.";
        $uploadOk = 0;
    }
}
// Chequea si la imagen ya existe en el servidor
if (file_exists($target_file)) {
  echo "<br>Sorry, file already exists.";
  $uploadOk = 0;
}

// Chequea si el tamaño excede de lo permitido (variable de php)
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "<br>Sorry, your file is too large.";
  $uploadOk = 0;
}

// Comprueba si el tipo de archivo es una imagen
if($imageFileType != "jpg" && 
    $imageFileType != "png" &&
    $imageFileType != "jpeg" &&
    $imageFileType != "gif" ) {
        echo "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
}

//Guardar archivo en el servidor
//Si la variable de control es 0 => No se puede guardar
if ($uploadOk == 0) {
  echo "<br>Sorry, your file was not uploaded.";
// Si la variable de control es 1 => Se guarda la imagen
// Se muestra un mensjae de OK
} else {
    //Guardar imagen en servidor
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //Mensaje de OK
    echo "<br>The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    //Mensaje de KO
    //En este ejemplo, cuando puede ocurrir?
    //No tener permisos de escritura
    echo "<br>Sorry, there was an error uploading your file.";
  }
}