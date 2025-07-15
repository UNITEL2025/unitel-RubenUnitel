<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/002%20-%20Pr%C3%A1ctica%20Intro%20PHP/ejercicio.php

/**
 * ===============================
 * EJERCICIOS DE PRÁCTICA EN PHP
 * ===============================
 * */

//1. Crea dos variables, una con tu nombre y otra con tu edad. Muestra un mensaje como:
//   "Hola, me llamo Juan y tengo 30 años."
$nombre = "Rubén";
$edad = 30;
echo "Hola, me llamo ".$nombre." y tengo ".$edad." años";
// 2. Crea tres variables numéricas, súmalas y muestra el resultado.
$x1 = 3;
$x2 = 8;
$x3 = 2;
$suma = $x1 + $x2 + $x3;
echo "<br>La suma de las 3 variables es: ".$suma;
// 3. Declara una variable tipo string y muestra su longitud.
$txt = "Hace un calor de morirse";
echo "<br>La longitud de la cadena es: ".strlen($txt);
// 4. Declara una variable de cada tipo básico (int, float, bool, string, null) y
// usa var_dump() para ver su tipo.
$var_int = 8;
$var_float = 10.25;
$var_bool = true;
$var_str = "Esto es un string";
$var_null = null;

echo "<br>Var int: ";
var_dump($var_int);
echo "<br> Var Float: ";
var_dump($var_float);
echo "<br> Var Bool: ";
var_dump($var_bool);
echo "<br>Var str: ";
var_dump($var_str);
echo "<br>Var null: ";
var_dump($var_null);
// 5. Declara una cadena con varias palabras y muestra cuántas palabras contiene.
$frase = "Loremp Ipsum et selem";
echo "<br>La frase contiene: ".str_word_count($frase)." palabras.";
// 6. Crea una función con una variable local. Intenta acceder a esa variable desde
// fuera de la función. ¿Qué pasa?
function myfunction6() {
   $var_function = "PALABRA";
}
echo "<br>La variable local de la función myfunction6 es: ".$var_function;
//No se puede imprimir porque está fuera de su contexto.
//La variable local dentro de una función no es accesible desde fuera de la misma.

// 7. Crea dos variables globales. Usa global dentro de una función para modificarlas
// y muestra el resultado.
$x1 = 5;
$x2 = 16;
function myfunction7() {
   global $x1, $x2;
   return $x1 + $x2;
}
echo "<br>La suma de las dos variables globales es: ".myfunction7();

// 8. Crea una función con una variable static. Llama varias veces a la función y
// observa cómo cambia el valor.
function myfunction8() {
   static $contador = 0;
   echo "<br>El valor del contador es: ".$contador;
   $contador++;
}
myfunction8();
myfunction8();
myfunction8();

// 9. Crea una variable tipo string con un número. Comprueba si es numérica.
// Luego conviértela a int y súmale 10.
$intstr = "2589";
echo "<br>La variable es númerica?: ".is_numeric($intstr);
$intstr = (int) $intstr + 10;
echo "<br>El resultado final es: ".$intstr;

// 10. Convierte un número decimal a int y luego a string. Muestra el tipo de cada
// conversión.
echo "<br>Tipo de 85.98 (float): ";
$decimal = 85.98;
var_dump($decimal);
echo "<br>Tipo de 85.98 (entero): ";
$entero = (int) $decimal;
var_dump($entero);
echo "<br>Tipo de 85.98 (str): ";
$string = (string) $entero;
var_dump($string);

// 11. Declara un string y reemplaza una palabra.
$str = "La casa que es blanca está al fondo de la calle.";
$buscar = "blanca";
$reemplazo = str_replace($buscar, "azul", $str);
echo "<br>La frase final es: ".$reemplazo;

// 12. Declara un string con espacios al inicio y al final. Usa trim() y muestra ambos
// resultados. ¿Qué ocurre?
$str_con_espacios = " Nombre ";
$str_sin_espacios = "Nombre";
echo "<br>Número de caracteres (CON espacio): ".strlen($str_con_espacios);
echo "<br>Número de caracteres (SIN espacio): ".strlen($str_sin_espacios);
echo "<br>Número de caracteres (usando trim()): ".strlen(trim($str_con_espacios));

// 13. Declara un string y usa explode() para convertirlo en array. Luego imprime
// cada palabra por separado.
$str = "La casa que es blanca está al fondo de la calle.";
$explode = explode(" ", $str);
echo "<br>Impresión de conversión de string a array usando explode<br>:";
var_dump($explode);

//Imprimir sólo la palabra "blanca" del array
echo "<br>Mostrar la palabra blanca desde el array: ".$explode[4];

// 14. Concatena dos variables de texto con . y con "$var1 $var2" y compara los
// resultados.
$str1 = "John";
$str2 = "Flanigan";
echo "<br>Concatenamos ambos str con ., resultado: ".$str1." ".$str2;

echo "<br>Contatenamos ambos str son ., resultado: $str1 $str2";

// 15. Extrae una parte de un string.
$str = "La casa que es blanca está al fondo de la calle.";
$extraccion = substr($str, 10);
echo "<br>El sub string es: ".$extraccion;

// 16. Crea un array de nombres de coches. Usa var_dump() y luego imprime el primer
// coche del array.
$array = array("Volvo", "Renault", "Citroen");
echo "<br>El contenido del array es: <br>";
var_dump($array);
echo "<br>El primer coche del array es: ".$array[0];

// 17. Crea un array numérico y muestra el número mayor y menor.
$array = array(71,39,214,12,589,471,36,15);
echo "<br>El número MAYOR del array es: ".max($array);
echo "<br>El número MENOR del array es: ".min($array);

// 18. Crea una clase Persona con propiedades nombre y edad, un constructor y una
// función que devuelva un saludo. Instancia un objeto y llama al método.
class Persona {
   public $nombre;
   public $edad;

   public function __construct($nombre, $edad) {
      $this->nombre = $nombre;
      $this->edad = $edad;
   }

   public function getSaludo() {
      return "Hola ".$this->nombre;
   }
}
$persona1 = new Persona("Pepe", 15);
echo "<br>Mostramos el saludo de la clase: ".$persona1->getSaludo();

// 19. En la clase anterior, añade una propiedad privada dni. Usa métodos getDni() y
// setDni() para acceder y modificar su valor.
class Persona19 {
   public $nombre;
   public $edad;
   private $dni;

   public function __construct($nombre, $edad, $dni) {
      $this->nombre = $nombre;
      $this->edad = $edad;
      $this->dni = $dni;
   }

   public function getSaludo() {
      return "Hola ".$this->nombre;
   }

   public function getDni() {
      return $this->dni;
   }

   public function setDni($dni) {
      $this->dni = $dni;
   }
}
$persona1 = new Persona19("Pepe", 15, "00000000A");
echo "<br>El dni es: ".$persona1->getDni();
echo "<br>Modificamos el dni";
$persona1->setDni("00000000B");
echo "<br>El NUEVO dni es: ".$persona1->getDni();

// 20. Crea una variable de cada tipo (int, float, string, bool, null) y conviértelas
// a array, luego a objeto, mostrando los resultados con var_dump().
$var_int = 8;
$var_float = 10.25;
$var_bool = true;
$var_str = "Esto es un string";
$var_null = null;

$int_array = (array) $var_int;
$float_array = (array) $var_float;
$bool_array = (array) $var_bool;
$str_array = (array) $var_str;
$null_array = (array) $var_null;

echo "<br>Impresión cast int to array:";
var_dump($int_array);
echo "<br>Impresión cast float to array:";
var_dump($float_array);
echo "<br>Impresión cast bool to array:";
var_dump($bool_array);
echo "<br>Impresión cast str to array:";
var_dump($str_array);
echo "<br>Impresión cast null to array:";
var_dump($null_array);

echo "<br>Impresión cast int to array to object:";
var_dump((object) $int_array);
echo "<br>Impresión cast float to array to object:";
var_dump((object) $float_array);
echo "<br>Impresión cast bool to array to object:";
var_dump((object) $bool_array);
echo "<br>Impresión cast str to array to object:";
var_dump((object) $str_array);
echo "<br>Impresión cast null to array to object:";
var_dump((object) $null_array);

// 21. Extrae el dominio de un email (que sirva para cualquier longitud de email)
function getDomain($email) {
   //1. Localizar en qué posición está la @ del email
   $pos = strpos($email, "@") + 1;
   //2. Subtraer todo el string a partir de esa posición
   $dominio = substr($email, $pos);
   //3. Devolver el resultado
   return $dominio;

   //Versión resumida/compacta
   //return substr($email, strpos($email, "@") + 1);
}
echo "<br>Ej1. El dominio es: ".getDomain("info@dominio.es");
echo "<br>Ej2. El dominio es: ".getDomain("administracion@burgerking.es");

//Operadores lógicos
//También se puede usar: &&
echo "<br>TRUE AND TRUE: ".(TRUE AND TRUE);
echo "<br>TRUE AND FALSE: ".(TRUE AND FALSE);
echo "<br>FALSE AND TRUE: ".(FALSE AND TRUE);
echo "<br>FALSE AND FALSE: ".(FALSE AND FALSE);

//También se puede usar: ||
echo "<br>TRUE OR TRUE: ".(TRUE OR TRUE);
echo "<br>TRUE OR FALSE: ".(TRUE OR FALSE);
echo "<br>FALSE OR TRUE: ".(FALSE OR TRUE);
echo "<br>FALSE OR FALSE: ".(FALSE OR FALSE);

echo "<br>TRUE XOR TRUE: ".(TRUE XOR TRUE);
echo "<br>TRUE XOR FALSE: ".(TRUE XOR FALSE);
echo "<br>FALSE XOR TRUE: ".(FALSE XOR TRUE);
echo "<br>FALSE XOR FALSE: ".(FALSE XOR FALSE);

//Operadores de asignación condicional
// IF (condicion)
//    Código si se cumple
// else
//    Código si no se cumple

//Compacto 1
//$x = expr1 ? expr2 : expr3
$var1 = 5;
$var2 = 10;

$x = ($var1 == $var2) ? "Son iguales":"Son distintos";
echo "<br>Las variables son: ".$x;

//Si los transformo en un if completo, será:
if ($var1 == $var2) {
   $x = "Son iguales";
}
else{
   $x = "Son distintos";
}

//Compacto 2
//$x = expr1 ?? expr2
$x = 5;
$x = ($x == null) ?? ($x > 0);