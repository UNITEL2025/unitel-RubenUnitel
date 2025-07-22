<?php

//Los archivos php deben tener extensión php
//La primera línea del archivo debe comenzar por: <?php
//PHP es un lenguaje que se ejecuta en máquina servidor
//PHP es un lenguaje interpretado (no compilado)
//PHP necesita un servidor como xampp para ejecutar (interprar) el archivo
//Si usamos XAMPP, el archivo debe estar en la carpeta "htdocs"

//Variables PHP
/** Nombre de las variables
* Las variables son datos que se almacenan en un un tipo de dato específico
* Se almacenan en memoria (no persistente)
* Es decir, cuando se apaga el servidor o se cierra el script, desaparece de memoria
* Las variables se nombran con "$" y el nombre de la variable, ejemplo: $mi_variable
* El nombre de las variables son case sensitive (distinguen mayúsculas de minúsculas)
* No es lo mismo $mi_variable que $MI_VARIABLE
*/
//Tipos de variables
/**
 * String -> Cadenas de texto (se entrecomillan con comillas dobles)
 * Integer -> Números enteros (positivos o negativos)
 * Float -> Números decimales (positivos o negativos)
 * Arrays -> Son matrices de NxM, por ejemplo: de 1x10 (1 columna y 10 filas)
 * Objetos -> Son tipo objeto
 * Boolean -> Tipo booleano, sólo puede valor true (1) o false (0)
 * NULL -> Valor especial de una variable, valor nulo (distinto de vacío)
 * Resource -> Son recursos del sistema (buffer de datos, otra clase php, etc...)
 */
//PHP no necesita declarar el tipo de dato al que pertenece una variable
//Es decir, interpreta según el valor, que tipo de variable es
//Por ejemplo, si asigno un número entero a la variable, php interpreta
// que es de tipo integer
//Otro ejemplo: Si asigno una cadena de texto, interpreta que es un string
//Para obtener el tipo de variable se usa "var_dump($nombre);"
//Nos indicará con que tipo ha declarado php a la variable
//Ejemplo: Declaramos una cadena de texto y consultamos como lo ha declarado php
$mi_cadena_de_texto = "Esta es mi primera frase";
var_dump($mi_cadena_de_texto);
//Resultado: string(24) "Esta es mi primera frase"

//Ejemplos de definición de variables
$mi_primer_integer = 5; //Ejemplo: Declaración de integer
$mi_primer_float = 10.52; //Ejemplo: Declaración de float
$mi_primer_boolean = true;
$mi_primer_array = array("Blanco", "Rojo", "Azul", "Verde");

//Ejercicio 1:
/**
 * 1) Crea una variable string, integer, float, boolean y array
 * 2) Imprimelas en pantalla para que aparezca el tipo de variable y su valor
 */
$str = "Mi primer string";
var_dump($str);
$int = 8;
var_dump($int);
$float = 84.36;
var_dump($float);
$bool = false;
var_dump($bool);
$array = array("Blanco", "Negro");
var_dump($array);

//Ámbito de las variables
/** Las variables tienen distintos ámbitos de actuación, se pueden limitar a
 * una zona de ejecución concreta.
 * Tipos:
 * local -> La que se ejecuta en una función/método, o en un archivo php concreto.
 * Sólo es accesible desde ese trozo de código.
 * global -> Accesible desde todo el sistema.
 * static -> Son variables locales que funcionan como globales.
 */

/** Ejemplo variable global */
$x = 5; // Definir una variable global

//Definimos una función
function myTest1() {
  // Dentro de la función NO se puede usar la variable global
  echo "<p>Variable x inside function is: $x</p>";
}
myTest1(); //Llamamos a la función para que ejecute

//Como la variable es global, también podemos llamarla desde fuera de la función
echo "<p>Variable x outside function is: $x</p>";

/** Ejemplo de variable local */
//Declaramos una función
function myTest2() {
  $x = 5; // Definimos una variable local
  //Imprimimos la variable
  echo "<p>Variable x inside function is: $x</p>";
}
myTest2(); //Llamamos a la función

// Llamamos a la variable desde fuera de la función, da error, ya que no es accesible
echo "<p>Variable x outside function is: $x</p>";

/** Ejemplo de variable global definida desde una función */
$x = 5; //Definimos una variable global 1
$y = 10; //Definimos una variable global 2

//Definimos una función
function myTest3() {
  global $x, $y; //Indicamos que las variables globales las permita usar dentro de
  //la función
  $y = $x + $y; //usamos las variables
}
myTest3(); //Llamamos a la función
echo $y; // Imprimimos el resultado

/** Ejemplo de variable estática */
//Definimos una función
function myTest4() {
  static $xz = 0; //Definimos una variable local y estática
  echo $xz; //Imprimo
  $xz++; //La sumo 1
}
//Ejecuto la función.
/** Al ser la variable local (sólo se puede usar dentro de la función)
 * interna de la función estática
 * no se destruye en memoria
 * por tanto, cada vez que se llama a la función, mantiene el valor anterior
 * Permite reutilizar el valor de la variable, dentro de la función.
 */
myTest4();
myTest4();
myTest4();

/**Impresión por pantalla */
/** Podemos usar "echo" para imprimir información en texto plano por pantalla
 * Tipos (es lo mismo):
 * echo "Hello";
 * echo("Hello");
 */
echo "Hello";
echo("Hello");

/** Impresión por pantalla de variables */
$txt1 = "Learn PHP"; //Definimos una variable
$txt2 = "W3Schools.com"; //Definimos otra variable

//Se pueda imprimir la variable directamente poniendo el nombre de la variable
//en la cadena de texto
//IMPORTANTE! Siempre que esté con entrecomillado doble
echo "<h2>$txt1</h2>"; 
echo "<p>Study PHP at $txt2</p>";

/** Impresión de variables */
$txt1 = "Learn PHP"; //Definimos una variable
$txt2 = "W3Schools.com"; //Definimos otra variable

//Si la cadena de texto está entrecomillada con comillas simples
//Debemos concatenar las cadenas de texto y las variables con un "."
echo '<h2>' . $txt1 . '</h2>';
echo '<p>Study PHP at ' . $txt2 . '</p>';

/** Impresión con comando print */
/** También se puede imprimir por pantalla con "print" 
 * Ambas formas son iguales
*/
print "Hello";
print("Hello");

/** Objetos
 * Clases y objetos son dos conceptos fundamentales en la programación orientada a objetos
 * La clase es una plantilla para el objeto
 * Y el objeto, es la instancia (creación) de la clase
 * Ejemplo:
 * Clase: Coche (color, modelo, etc..)
 * Objeto: Coche (Amarillo, Volvo, etc...)
 */
//Definimos la clase "coche"
/** Dentro de la clase se define:
 * 1) Atributos/Propiedades de la clase
 * 2) Método "constructor"
 * 3) Funciones que contendrá la clase
 */
//Definimos una clase llamada "Car"
class Car {
    /** Dentro de la clase, definimos los atributos/propiedades que contendrá esta
     * En nuestro ejemplo: color y modelo
     * Podemos añadir cualquier tipo de dato, y tantos atributos de clase como queramos
     * Los atributos pueden tener dos ámbitos:
     * 1) Público (public): Es accesible desde fuera de la clase.
     * 2) Privado (private): Sólo es accesible desde dentro de la clase.
     */
  public $color;
  public $model;
  /** Definimos una función "especial" que se llama el constructor
   * Se llama: __construct()
   * Sus parámetros funcionan como en el resto de funciones
   * En este ejemplo los parámetros son obligatorios (también pueden ser opcionales)
   */
  public function __construct($color, $model) {
    /** Dentro del constructor
     * Asignamos las variables (parámetros de entrada de la función)
     * A los atributos/propiedades de la clase
     * $this->color => Se refiere al atributo de la clase
     * $color => Se refiere al parámetro de la función
     */
    $this->color = $color;
    $this->model = $model;
  }
  /** Las clases pueden tener funciones */
  /** El objetivo de esta función es imprimir una frase indicando el color y el modelo*/
  public function message() {
    return "My car is a " . $this->color . " " . $this->model . "!";
  }
}

/** Instanciamos un objeto de clase "Car" 
 * $myCar es la variable (tipo objeto) donde se guardará el objeto
 * new Car(); => Es la forma para instanciar el objeto, o crear el objeto de la clase "Car"
 * Como el constructor de la clase indica que necesita dos parámetros obligatorios
 * le debemos indicar: color, modelo
*/
$myCar = new Car("red", "Volvo");
var_dump($myCar); //Imprimir el objeto

/** Ejercicio 2:
 * 1) Crea una clase llamada "ordenador"
 * 2) El ordenador puede tener: cpu, ram, hdd y so
 * 3) Crea una función que imprima el resumen de las características del ordenador
 * 4) Instancia un ordenador e imprime sus características
 */
//Definimos la clase
class ordenador {
    //Definimos los atributos de la clase
    public $cpu;
    public $ram;
    public $hdd;
    public $so;
    //Definimos el constructor
    public function __construct($cpu, $ram, $hdd, $so) {
        //Asigno los valores de los parámetros a los atributos de la clase
        $this->cpu = $cpu;
        $this->ram = $ram;
        $this->hdd = $hdd;
        $this->so = $so;
    }
    //Definimos la función "mensaje" con return
    public function msg1() {
        return "Las características del ordenador son:<br>".
            "CPU: ".$this->cpu."<br>".
            "RAM: ".$this->ram."<br>".
            "HDD: ".$this->hdd."<br>".
            "Sistema Operativo: ".$this->so;
    }

    //Definimos la función "mensaje" SIN return (que imprima directamente)
    public function msg2() {
        echo "Las características del ordenador son:<br>".
            "CPU: ".$this->cpu."<br>".
            "RAM: ".$this->ram."<br>".
            "HDD: ".$this->hdd."<br>".
            "Sistema Operativo: ".$this->so;
    }
}
//Creo una instancia de la clase (creo un objeto de la clase ordenador)
$myOrdenador = new ordenador("Intel", "20 GB", "1 TB", "Windows");
//Imprimos el mensaje1 de la clase (devuelve una cadena de texto)
$mensaje = $myOrdenador->msg1(); //Guardar cadena de texto en variable $mensaje
echo $mensaje; //Imprimo la cadena de texto
//Imprimo el mensaje2 de la clase (no devuelve nada, imprime directamente)
echo "<br>";
$myOrdenador->msg2();

/** Funciones NATIVAS de PHP 
 * PHP tiene funciones nativas (predefinidas) que hacen "cosas"
 * Cada una tiene su nombre y no se puede cambiar (se llaman como indique la documentación)
*/
/** Funciones de PHP para strings */
echo strlen("Hello world!"); //Indica el número de caracteres de la cadena.
echo str_word_count("Hello world!"); //Indica el número de palabras de la cadena.
//Indica la primera posición de la palabra a buscar
//En PHP, los índices comienzan en cero
//1 param: Cadena de texto donde quiero buscar
//2 param: Es la palabra que quiero encontrar
echo strpos("Hello world!", "world");
echo strtoupper("Hello World!"); //Cambia la cadena de texto a mayúsculas
echo strtolower("HELLO WORLD!"); //Cambia la cadena de texto a minúsculas
//Reemplaza cadenas de texto
//1 param: Palabra a reemplazar
//2 param: Palabra de reemplazo
//3 param: Cadena de texto a tratar
//En este caso busca "World" en la cadena de texto y lo sustituye por "Dolly"
/** Ejemplo de utilidad:
 * Disponemos de una cadena de texto que queremos usar como url
 * Cadena = "mi primera pagina web"
 * Necesito (url): "mi-primera-pagina-web"
 * echo str_replace(" ", "-", "mi primera pagina web");
 */
echo str_replace("World", "Dolly", "Hello World!");
echo strrev("Hello World!"); //Invierte el orden de la cadena de texto
//Elimina espacios en blanco SÓLO por delante y detrás de la cadena de texto
//Los espacios intermedios NO los borra
echo trim(" Hello World! ");
//Convierte un string en un array
//1 param: Caracter por donde queremos cortar el string, ene ste caso, un espacio
//2 param: Indica el string a convertir
$y = explode(" ", "Hello World!"); //Obtenemos el array en la variable $y
print_r($y); //Imprimos el array
//Extrae un substring del string principal
//1 param: String a cortar (original)
//2 param: La posición donde empiezo a cortar
//3 param: Es la longitud que voy a cortar (si no lo indico, será hasta el final)
//En este ejemplo, desde la posición 6, obtiene 5 caracteres.
echo "<br>".substr("Hello World!", 6, 5);

/** Números */
//Comprobar qué tipo de número es
/** Enteros (Integers) 
 * Se usa la función: is_int()
*/
$x = 5985; //Definimos un integer
var_dump(is_int($x)); //Preguntamos si es integer -> Resultado: TRUE

$x = 59.85; //Definimos un float
var_dump(is_int($x)); //Preguntamos si es un integer -> Resultado: FALSE

/** Decimales (Floats) 
 * Se usa la función: is_float()
*/
$x = 10.365; //Definimos un float
var_dump(is_float($x)); //Preguntamos si es un float -> Resultado: TRUE

/** NaN
 * Son valores No numéricos
 */
$x = acos(8);
var_dump($x);

/** Comprobar si la variable es numérica: INT o un FLOAT */
$x = 5985; //Definimos un entero
var_dump(is_numeric($x)); //Preguntamos si es numérico -> Resultado: TRUE

/** CAST (Convertir números)
 * Podemos convertir un tipo de número en otro, reasignando el valor a la variable
 * e indicando que nuevo tipo será
 * Sintaxis: $var_nueva = (nuevo_tipo_dato) $var_vieja
 */
$float = 50.598; //Definimos un float
$int = (int) $float; //Convertimos de float a integer -> Resultado: 50

// Se pueden convertir todos los tipos de datos
/** Ejemplo:
 * > de string a int 
 * > de int a string
 * > de array a objeto
 * etc...
 * */

/** Funciones Nativas Matemáticas */
echo(pi()); //Imprime el número PI
echo(min(0, 150, 30, 20, -8, -200)); //Imprime el mínimo de un conjunto de números
echo(max(0, 150, 30, 20, -8, -200)); //Imprime el máximo de un conjunto de números
echo(abs(-6.7)); //Imprime el número en valor absoluto
echo(sqrt(64)); //Imprime la raíz cuadrada del valor
echo(round(0.49)); //Imprime el redondeo del valor
echo(rand()); //Imprime un número aleatorio
//Si se le dan parámetros, imprime números aleatorios en ese rango.
//En este ejemplo, imprime un número aleatorio entre 0 y 10
echo(rand(0, 10));

/** Constantes
 * Son variables que no pueden cambiar su valor
 * Se definen una sóla vez y duran durante todo el programa.
 * Pueden ser de cualquier tipo de dato (int, float, string, array...)
 * Son de ámbito global (accesibles desde cualquier parte)
 * Se pueden declarar de dos formas:
 * 1) define(nombre, valor);
 * 2) const nombre = valor;
 */
//Ejemplo 1:
define("GREETING", "Welcome to W3Schools.com!");
echo GREETING;
//Ejemplo 2:
const MYCAR = "Volvo";
echo MYCAR;

/** Constantes Mágicas
 * Son constantes predefinidas por PHP (son constantes nativas)
 * Tipos:
 * __CLASS__	Si se usa dentro de una clase, devuelve el nombre de la clase.
 * __DIR__	El directorio del archivo en ejecución en ese momento.
 * __FILE__	El nombre del archivo (path completo).
 * __FUNCTION__	Dentro de una función, devuelve el nombre de la función.
 * __LINE__	Devuelve la línea actual de ejecución.
 * __METHOD__	Si se usa dentro de una función, devuelve la clase y la función.
 * __NAMESPACE__	Dentro de un namespace, devuelve el nombre del namespace
 * __TRAIT__	Dentro de un trait, devuelve el nombre del trait.
 * ClassName::class	Devuelve el nombre de la clase (no es necesario estar dentro de la clase)
 */

/** Estructuras condicionales */
/** IF */
if (5 > 1) //Compruebo si se cumple la condición
//Si es cierta (TRUE), se ejecuta el código entre llaves
{
    echo "Es mayor";
}
/** IF...ELSE */
/** La ejecución de los bloques son excluyentes
 * Que sólo se ejecutará uno de ellos
 */
echo "<br>";
if (5 > 10) //Comprueba la condición
//Si SI es cierta (TRUE), ejecuta el bloque de código
{
    echo "Es mayor";
}
//Si NO es cierta (FALSE), ejecuta el bloque de código
else
{
    echo "No es mayor";
}

/** IF...ELSEIF...ELSE */
if (5 > 10) //Compueba la condición
//SI es cierta, ejecuta el bloque, sino comprueba la siguiente condición
{}
//Comprueba la condición, si es cierta ejecuta el bloque, sino pasa al siguiente
//Pueden existir infinitos bloques ELSEIF
elseif (5 > 6)
{}
else //Ejecución por defecto, cuando no se cumple ninguna condición anterior
{}

/** IF comprimido */
$a = 13; //Definimos una variable
//Estructura: $var_salida = (condicion) ? TRUE:FALSE;
$b = ($a < 10) ? "Hello" : "Good Bye";
echo $b;

/** Switchs
 * Estructura de control por casos
 */
/**
 * switch (expression) { => Se comprueba la condición
 * case label1: => Casos (puede haber tantos como queramos)
 *  En caso de que se cumpla la condición, se ejecuta el bloque de código,
 *   //code block 
 *   break; => Palabra clave, provoca que se finalice el bloque completo
 * case label2:
 *   //code block;
 *   break;
 * case label3:
 *   //code block
 *   break;
 * default: => Si no se cumple ninguna condición, ejecuta el bloque
 *   //code block
 * }
 */
$favcolor = "red"; //Definimos una variable string

switch ($favcolor) { //Condición por la que se filtran los casos
  case "blue": //¿$favcolor (red) == blue? -> No, se comprueba el siguiente caso
    echo "Your favorite color is blue!";
    break;
  case "red": //¿$favcolor (red) == red? -> Sí, se ejecuta el código
    echo "Your favorite color is red!"; //=> Se ejecuta
    break; //=> Fuerza la salida del switch
  case "green": //Este bloque ya no se ejecuta
    echo "Your favorite color is green!";
    break;
  default:  //Este bloque ya no se ejecuta
    echo "Your favorite color is neither red, blue, nor green!";
}

//Otro ejemplo, uso de default
$favcolor = "black";

switch ($favcolor) {
  case "red": //No cumple la condición, no se ejecuta
    echo "Your favorite color is red!";
    break;
  case "blue":  //No cumple la condición, no se ejecuta
    echo "Your favorite color is blue!";
    break;
  case "green"://No cumple la condición, no se ejecuta
    echo "Your favorite color is green!";
    break;
  default: //Al no cumplir la condición en ninguno de los casos
  //Se ejecuta el bloque default y se acaba el switch
    echo "Your favorite color is neither red, blue, nor green!";
}

/** While (bucles) */
/** Los bucles son iteraciones de código que se ejecutan hasta
 * que se deja de cumplir la condición */

$i = 1; //Se define un contador
//Se comprueba la condición, si es cierta, entra en el bucle
//Si no es cierta, no se ejecuta el bloque de código
while ($i < 6) { 
  echo $i; //Imprimir el contador (o ejecutar el código que corresponda)
  $i++; //Se incrementa el contador en 1 unidad
}

/**Proceso de iteraciones
 * Iteración 1: ¿Es $i (1) < 6? => Sí, se ejecuta el bloque y se aumenta $i en 1 unidad.
 * Iteración 2: ¿Es $i (2) < 6? => Sí, se ejecuta el bloque y se aumenta $i en 1 unidad.
 * Iteración 3: ¿Es $i (3) < 6? => Sí, se ejecuta el bloque y se aumenta $i en 1 unidad.
 * Iteración 4: ¿Es $i (4) < 6? => Sí, se ejecuta el bloque y se aumenta $i en 1 unidad.
 * Iteración 5: ¿Es $i (5) < 6? => Sí, se ejecuta el bloque y se aumenta $i en 1 unidad.
 * Iteración 6: ¿Es $i (6) < 6? => No, se sale del bloque while
 */

/** Palabra clave: break;
 * Se puede romper el bucle internamente con la palabra "break;"
 */
$i = 1; //Definimos un contador
while ($i < 6) { //Se comprueba la condición
  //Si se cumple la condición interna, con la palabra clave "break;"
  //Se para la ejecución del bucle, y se sale del WHILE
  //Si no se cumple la condición, continúa las iteraciones
  if ($i == 3) break; 
  echo $i;
  $i++;
}

//** Proceso de iteraciones:
// Iteración 1: ¿Es $i (1) menor que 6 => Sí, ¿Es $i (1) igual a 3? => No,
// por tanto, continúa el bucle.
// Iteración 2: ¿Es $i (2) menor que 6 => Sí, ¿Es $i (2) igual a 3? => No,
// por tanto, continúa el bucle.
// Iteración 3: ¿Es $i (3) menor que 6 => Sí, ¿Es $i (3) igual a 3? => Sí,
// se sale del bloque WHILE.
// */

/** Palabra clave: continue 
 * Indica si el bloque en ejecución debe continuar bajo la premisa que se le indique
*/
$i = 0; //Defino un contador
while ($i < 6) { //Compruebo la condición
  $i++;//Aumento el contador en 1 unidad
  //Compruebo la 2da condición, si se cumple, continúa el bucle
  if ($i == 3) continue;
  echo $i;
}

/** Proceso de iteración:
 * Iteración 1: ¿Es $i (0) menor que 6? => Sí, se aumenta el contador en 1 unidad.
 * ¿Es $i (1) igual a 3? => No, no entra en el bloque IF y continua.
 * Imprime el contador
 * Iteración 2: ¿Es $i (1) menor que 6? => Sí, se aumenta el contador en 1 unidad.
 * ¿Es $i (2) igual a 3? => No, no entra en el bloque IF y continua.
 * Imprime el contador
 * Iteración 3: ¿Es $i (2) menor que 6? => Sí, se aumenta el contador en 1 unidad.
 * ¿Es $i (3) igual a 3? => Sí, se ejecuta el bloque IF y continua.
 * Imprime el contador
 * Iteración 4: ¿Es $i (3) menor que 6? => Sí, se aumenta el contador en 1 unidad.
 * ¿Es $i (4) igual a 3? => No, no entra en el bloque IF y continua.
 * Imprime el contador
 * Iteración 5: ¿Es $i (4) menor que 6? => Sí, se aumenta el contador en 1 unidad.
 * ¿Es $i (5) igual a 3? => No, no entra en el bloque IF y continua.
 * Imprime el contador
 * Iteración 6: ¿Es $i (5) menor que 6? => Sí, se aumenta el contador en 1 unidad.
 * ¿Es $i (6) igual a 3? => No, no entra en el bloque IF y continua.
 * Imprime el contador
 * Iteración 7: ¿Es $i (6) menor que 6? => No, se sale del bloque WHILE.
 */

/**DO..WHILE
 * Es un bucle, la diferencia con el bloque WHILE, es que siempre ejecutará la
 * primera iteración
 */
$i = 1; //Defino un contador

do { //Ejecuta la 1ra iteración (Sí o Sí)
  echo $i; //Imprime el contador
  $i++; //Aumenta el contador en 1 unidad
} while ($i < 6); //Se comprueba la condición, si es cierta, repite otra iteración
//Si no es cierta, se sale del bloque DO-WHILE

/**Proceso de iteración:
 * Iteración 1: Imprime el contador y Aumenta el contador en 1 unidad 
 * Comprueba la condición: ¿Es $i (2) menor que 6? => Sí, se reinicia el bucle.
 * Iteración 2: Imprime el contador y Aumenta el contador en 1 unidad 
 * Comprueba la condición: ¿Es $i (3) menor que 6? => Sí, se reinicia el bucle.
 * Iteración 3: Imprime el contador y Aumenta el contador en 1 unidad 
 * Comprueba la condición: ¿Es $i (4) menor que 6? => Sí, se reinicia el bucle.
 * Iteración 4: Imprime el contador y Aumenta el contador en 1 unidad 
 * Comprueba la condición: ¿Es $i (5) menor que 6? => Sí, se reinicia el bucle.
 * Iteración 5: Imprime el contador y Aumenta el contador en 1 unidad 
 * Comprueba la condición: ¿Es $i (6) menor que 6? => No, se sale del bucle DO-WHILE.
 */

/** Bloque FOR
 * Es un bloque de iteración
 */
/**
 * $x es el contador
 * 1er param: es el inicio del contador
 * 2do param: es la condición de continuidad
 * 3er param: es el incremento del contador
 */
for ($x = 0; $x <= 5; $x++) {
  echo "The number is: $x <br>";
}
/** Proceso de iteración:
 * Iteración 1: Contador vale 0 y es menor o igual a 5.
 * Imprime el contador, aumenta en 1 unidad el contador y se reinicia el bucle.
 * Iteración 2: Contador vale 1 y es menor o igual a 5.
 * Imprime el contador, aumenta en 1 unidad el contador y se reinicia el bucle.
 * Iteración 3: Contador vale 2 y es menor o igual a 5.
 * Imprime el contador, aumenta en 1 unidad el contador y se reinicia el bucle.
 * Iteración 4: Contador vale 3 y es menor o igual a 5.
 * Imprime el contador, aumenta en 1 unidad el contador y se reinicia el bucle.
 * Iteración 5: Contador vale 4 y es menor o igual a 5.
 * Imprime el contador, aumenta en 1 unidad el contador y se reinicia el bucle.
 * Iteración 6: Contador vale 5 y es menor o igual a 5.
 * Imprime el contador, aumenta en 1 unidad el contador y se reinicia el bucle.
 * Iteración 7: Contador vale 6 y NO es menor o igual a 5.
 * Se sale del bloque FOR
 */

/** Bloque FOREACH
 * Es un bucle sin contador, recorre los elementos de tipos de datos que sean iterables
 */
//Definimos un array
$colors = array("red", "green", "blue", "yellow");

/**
 * 1er param: Es la variable iterable.
 * 2do param: Es el elemento de la variable iterable en esa iteración
 */
foreach ($colors as $x) {
  echo "$x <br>";
}
/**Proceso de iteración:
 * Iteración 1: Coge el elemento 0 del array, lo extrae a la variable $x
 * Imprime el elemento: "red"
 * Iteración 2: Coge el elemento 1 del array, lo extrae a la variable $x
 * Imprime el elemento: "green"
 * Iteración 3: Coge el elemento 2 del array, lo extrae a la variable $x
 * Imprime el elemento: "blue"
 * Iteración 4: Coge el elemento 3 del array, lo extrae a la variable $x
 * Imprime el elemento: "yellow" y se sale del bucle FOREACH.
 */

/**Otra forma de FOREACH 
 * Permiten manejar la key (llave) y el value (valor) de un array asociativo
*/
//Definimos un array asociativo
$members = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

/**
 * 1er param: Es el array asociativo que queremos recorrer
 * 2do param: Es la llave del elemento de la iteración
 * 3er param: Es el valor del elemento de la iteración
 */
foreach ($members as $key => $value) {
  echo "$key : $value <br>";
}
/**Proceso de iteración:
 * Iteración 1: Coge el elemento 0, y asigna los valores.
 * $key vale "Peter", y el $value vale "35". Imprime la cadena
 * Iteración 2: Coge el elemento 1, y asigna los valores.
 * $key vale "Ben", y el $value vale "37". Imprime la cadena
 * Iteración 3: Coge el elemento 2, y asigna los valores.
 * $key vale "Joe", y el $value vale "43". Imprime la cadena
 * Al no haber más elementos iterables, se sale del bloque FOREACH
 */

/** Modificación de variables dentro de un bucle
 * Por defecto, las variables que se iteran en un bucle, no son modificables
 * a nivel internao (del bucle)
 * Para poder modificar un elemento de la variable durante la iteración
 * debemos modificar la estructura
 */
//Definimos un array
$colors = array("red", "green", "blue", "yellow");

//Delante de la variable de la iteración en curso ($item) se pone el símbolo "&"
foreach ($colors as &$item) {
  if ($item == "blue") $item = "pink";
}
var_dump($colors);
/**Proceso de iteración:
 * Iteración 1: Coge el elemento 0 del array, y lo asigna a $item
 * Comprueba la condición: ¿Es $item (red) igual a blue? => No, reinicia el bucle.
 * Iteración 2: Coge el elemento 1 del array, y lo asigna a $item
 * Comprueba la condición: ¿Es $item (green) igual a blue? => No, reinicia el bucle.
 * Iteración 3: Coge el elemento 2 del array, y lo asigna a $item
 * Comprueba la condición: ¿Es $item (blue) igual a blue? => Sí,
 * cambia el valor de $item por pink, y el cambio se mantiene en el array original.
 * Iteración 4: Coge el elemento 3 del array, y lo asigna a $item
 * Comprueba la condición: ¿Es $item (yellow) igual a blue? => No
 * Finaliza el bloque FOREACH porque no hay más elementos iterables.
 */

/** FUNCIONES/MÉTODOS
 * Son trozos de código que se pueden ejecutar repetidas veces durante la ejecución
 * PHP tiene más de 1.000 funciones predefinidas
 */
/**
 * function => Palabra clave que define el bloque de código como función
 * nombre => Nombre que le queremos dar a la función, no se pueden repetir nombres de
 * funciones
 * param1, param2... => Son los parámetros de entrada(inputs)
 * Puede tener tantos parámetros de entrada como queramos
 * Los param de entrada pueden ser: obligatorios u opcionales
 * Si hay params obligatorios y opcionales al mismo tiempo, se deben ordenar
 * 1ro se ponen los obligatorios y después los opcionales
 * return => Es una palabra clave, que indica que devolverá un dato,
 * que es el param3 (output)
 * tipo_dato_salida => Indica que tipo de dato será el param3, puede ser cualquier tipo.
 * Si no hay param3 (no hay return), se indica con "void"
 */
// function nombre(param1, param2) : tipo_dato_salida {
//   código a ejecutar...
//   return param3;
// }
//Se define la función
function myMessage() {
  echo "Hello world!";
}

myMessage(); //Se llama a la función


/** Arrays
 * Hay dos tipos de arrays: índices y asociativos
 */
//Ejemplo de array de índices
$cars = array("Volvo", "BMW", "Toyota");
//Ejemplo de array asociativo
$coche = array("model" => "Volvo", "color" => "red");

//Acceso a arrays (índice)
$cars[1]; //Imprime la posición 1 del array (BMW)
//Acceso a arrays (asociativo)
$coche["color"]; //Imprime el valor de la llave "color", que es "red"

//Modificación de elementos de un array (índice)
$cars[1] = "Citroen"; //Modifica el valor de la posición 1 con "Citroen"
//Modificación de elementos de un array (asociativo)
$coche["color"] = "blue"; //Modifica el valor de la llave "color" por el valor "blue"

/** Eliminar elementos de un array */
$cars = array("Volvo", "BMW", "Toyota"); //Definimos un array
unset($cars[1]); //Eliminamos el elemento de la posición 1 (BMW)

/** Ordenación arrays */
// sort() - Ordena un array de índices en orden ascendente
// rsort() - Ordena un array de índices en orden DEScendente
// asort() - Ordena un array asociativo, en orden ascendente, según el valor
// ksort() - Ordena un array asociativo, en orden ascendente, según la llave
// arsort() - Ordena un array asociativo, en orden DEScendente, según el valor
// krsort() - Ordena un array asociativo, en orden DEScendente, según la llave

//Ejemplo:
$cars = array("Volvo", "BMW", "Toyota"); //Definimos un array
sort($cars); //Ordenamos el array en orden ascendente según su valor

/**Arrays multidimensionales
 * Son arrays contenidos en otros arrays
 */
//$cars es el array principal con 4 elementos
$cars = array (
  array("Volvo",22,18), //Array secundario con 3 elementos
  array("BMW",15,13),
  array("Saab",5,2),
  array("Land Rover",17,15)
);

//Para acceder a arrays multidimensionales, en este caso, de dos, se necesitan 2 índices
$cars[0][2]; //Imprime 18 (del array secundario con posición 0, la posición 2 del mismo)

//Recorrer arrays multidimensionales
//Count() indica el número de elementos que tiene un array
//¿Cuántos elementos tiene $cars? Se desconoce
//Llamamos a la función count() y devuelve un integer
//En este caso devuelve: 4
//Este código: for ($i=0; $i < count($cars); $i++) {
//Es lo mismo que: for ($i=0; $i < 3; $i++) {
for ($i=0; $i < count($cars); $i++) { //Recorrer el array principal
  for ($j=0; $j < count($cars[$i]); $j++) { //Recorer cada uno de los arrays secundarios
    //Imprime el valor del array secundario $i, el elemento con posición $j
    echo $cars[$i][$j];
  }
}
/**Proceso de iteración:
 * Iteración 1 (for 1):
    * Iteración 1 (for 2):
    * echo $cars[0][0]; => Imprime "Volvo"
    * Iteración 2 (for 2):
    * echo $cars[0][1]; => Imprime 22
    * Iteración 3 (for 2):
    * echo $cars[0][2]; => Imprime 18
 * Iteración 2 (for 1):
    * Iteración 1 (for 2):
    * echo $cars[1][0]; => Imprime "BMW"
    * Iteración 2 (for 2):
    * echo $cars[1][1]; => Imprime 15
    * Iteración 3 (for 2):
    * echo $cars[1][2]; => Imprime 13
* Iteración 3 (for 1):
    * Iteración 1 (for 2):
    * echo $cars[2][0]; => Imprime "Saab"
    * Iteración 2 (for 2):
    * echo $cars[2][1]; => Imprime 5
    * Iteración 3 (for 2):
    * echo $cars[2][2]; => Imprime 2
* Iteración 4 (for 1):
    * Iteración 1 (for 2):
    * echo $cars[3][0]; => Imprime "Land Rover"
    * Iteración 2 (for 2):
    * echo $cars[3][1]; => Imprime 17
    * Iteración 3 (for 2):
    * echo $cars[3][2]; => Imprime 15
*/
//Otra forma
//$cars es el array completo
//$car es 1 elemento del array $cars
//$item es 1 elemento del array $car
foreach ($cars as $car) { //Obtenemos del array principal, 1 sólo coche en cada iteración
  foreach ($car as $item) { //Recorre cada uno de los arrays secundarios
    echo $item; //En cada iteración imprime el valor del array secundario
  }
}
/**Proceso de iteración:
 * Iteración 1 (for 1):
 *    Coge el elemento 0 del array $cars
 *    Iteración 1 (for 2):
 *    echo $item; Imprime "Volvo"
 *    Iteración 2 (for 2):
 *    echo $item; Imprime 22
 *    Iteración 3 (for 2):
 *    echo $item; Imprime 18
 * Iteración 2 (for 1):
 *    Coge el elemento 1 del array $cars
 *    Iteración 1 (for 2):
 *    echo $item; Imprime "BMW"
 *    Iteración 2 (for 2):
 *    echo $item; Imprime 15
 *    Iteración 3 (for 2):
 *    echo $item; Imprime 13
 * ....continua 
 */

/** Funcio de arrays 
 * Son funciones nativos de PHP
 */
//array_diff() => Compara dos arrays y muestra las diferencias
echo "<br><br>Diff arrays: <br>";
$array1 = array(5,8,2); //Defino un array
$array2 = array(5,8,1); //Defino un array
var_dump(array_diff($array1, $array2)); //Imprimo las diferencias entre arrays
//Salida: array(1) { [2]=> int(2) }

//array_fill() => Rellenar un array
//Creará un array con 100 posiciones, de 0 a 100, e insertará en cada posición el valor:
//"Contenido del array"
$array = array_fill(0, 100, "Contenido del array");

//array_keys() -> Retorna las llaves de un array asociativo
$cars = array("model" => "Citroen", "color" => "blue");
//Imprime un array con las llaves del array indicado: model y color
var_dump(array_keys($cars));

//array_pop() -> Elimina el último de un elemento de un array
$cars = array("citroen", "bmw", "ford");
array_pop($cars); //Elimina la posición 3 (ford)

//array_push() -> Añade un elemento al final del array
$cars = array("citroen", "bmw", "ford");
array_push($cars, "bmw"); //Inserta en la última posición el valor "bmw"

//array_unique() -> Elimina los valores duplicados de un array
$cars = array("citroen", "bmw", "ford", "citroen");
$salida = array_unique($cars); //Elimina un "citroen"

//count() -> Devuelve el número de elementos de un array
$cars = array("citroen", "bmw", "ford");
$total_elementos = count($cars); //Devuelve 3

//shuffle() -> Reordena aleatoriamente un array
$cars = array("citroen", "bmw", "ford");
$exito = shuffle($cars);
/**
 * $exito indica si ha sido posible la ejecución (TRUE/FALSE)
 * Salida ejemplo: array("citroen", "ford", "bmw");
 */

/**Variables superglobales 
 * Son variables del sistema, predefinidas por PHP
 * Tipos:
 * $GLOBALS => Info general de la conexión
   $_SERVER => Info del servidor
   $_REQUEST => Info de la petición
   $_POST => Donde se almacena los datos de los formularios de HTML
   $_GET => Donde se almacena los datos de los formularios de HTML
   $_FILES => Donde se almacena los archivos de los formularios de HTML
   $_ENV => Info del entorno
   $_COOKIE => Archivo que se guarda en el ordenador del cliente, nos permite añadir info
   y recuperarla
   $_SESSION => Info que se almacena en el servidor en base a la sesión del usuario,
   nos permite guardar info y recuperarla
*/

//** Función date()
// Devuelve la fecha y la hora, según se especifique en el argumento de entrada
// Devolverá según los datos del servidor */
echo "Today is " . date("d/m/Y H:i:s") . "<br>";

/** Include y require
 * Son los palabras clave que permiten anexionar un script PHP a otro
 * > include: Permite la ejecución aunque exista un fallo
 * (por ejemplo, no encuentre el archivo a cargar)
 * > require: Si hay un error o no encuentra el archivo, para la ejecución del script
 */
//include "tools.php"
//require "tools.php"

/** Manejar ficheros */
//Lectura de ficheros
//echo readfile("file.txt"); //Imprime el contenido del archivo

//Otra forma de leer archivos
//Abre el archivo indicado, en modo lectura (r) y guarda el recurso en una variable,
//en caso contrario da un error y para el script PHP
//$myfile = fopen("file.txt", "r") or die("Unable to open file!");
//Leer el recurso (contenido del archivo)
//echo fread($myfile,filesize("file.txt"));
//Cierra el recurso
//fclose($myfile);

//Lectura de una sóla línea del archivo
// $myfile = fopen("file.txt", "r") or die("Unable to open file!");
// echo fgets($myfile); //Obtiene sólo la primera línea
// fclose($myfile);

//Fin de archivo
//$myfile = fopen("file.txt", "r") or die("Unable to open file!");
// Imprime cada línea del archivo hasta que llega al feof
//feof indica el fin del archivo
// while(!feof($myfile)) {
//   echo fgets($myfile) . "<br>";
// }
// fclose($myfile);

//Escribir en un archivo
//Creamos un archivo nuevo, con la opción "w"
// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
// $txt = "John Doe\n"; //Creamos una cadena de texto
// fwrite($myfile, $txt); //Escribimos en el archivo
// fclose($myfile); //Cerramos el archivo

//Reescritura de un archivo
//Abrimos el el archivo con opción "w"
// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
// $txt = "Mickey Mouse\n"; //Creamos una cadena de texto
// fwrite($myfile, $txt);//Escribimos en el archivo
// fclose($myfile);//Cerramos el archivo

//Añadir texto a un archivo
//Abrimos el el archivo con opción "a"
// $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
// $txt = "Donald Duck\n"; //Creamos una cadena de texto
// fwrite($myfile, $txt); //Escribimos añadiendo al archivo
// fclose($myfile); //Cerramos el archivo

//Comprobar si existe un archivo
// Check if file already exists
//$target_file => Nombre del archivo
//file_exists() => Función que comprueba si existe el archivo indicado
//Devuelve TRUE si existe, FALSE si no existe
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

/** Cookies */
$cookie_name = "user"; //Nombre de la cookie
$cookie_value = "John Doe"; //Valor de la cookie
//Seteamos la cookie en el cliente
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

/**Sessión */
session_start(); //Iniciamos la sesión
$_SESSION["favcolor"] = "green"; //Seteamos un valor de la sesión
$_SESSION["favanimal"] = "cat"; //Seteamos un valor de la sesión

/** Filtros
 * Es una función que permite chequear datos de variables
 */
//Check IPv6
//Definimos una Ipv6
$ip = "2001:0db8:85a3:08d3:1319:8a2e:0370:7334";

//Se pasa por el filtro
//FILTER_VALIDATE_IP => Es una constante, que indica que es una IP
//FILTER_FLAG_IPV6 => Es una constante, que indica que la IP tiene que ser v6
//EN el primer bloque la IP es válida
if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
  echo("$ip is a valid IPv6 address");
//En el 2do bloque la IP no es válida
} else {
  echo("$ip is not a valid IPv6 address");
}

//Check URL
//Definimos una url
$url = "https://www.w3schools.com";

//Filtramos por url
//FILTER_VALIDATE_URL => Es una constante que filtra por url
//FILTER_FLAG_QUERY_REQUIRED => Es una constante, que indica que la url debe
//contener una parte de query
if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED) === false) {
  //Salida si es válida
  echo("$url is a valid URL with a query string");
//Salida si No es válida
} else {
  echo("$url is not a valid URL with a query string");
}

/**Limpiar un string */
//Limpia los caracteres que no son legibles
$str = "<h1>Hello World!</h1>"; //Definimos un string
$newstr = filter_var($str, FILTER_SANITIZE_STRING);
echo $newstr;

//Check Ipv4
$ip = "127.0.0.1";

if (!filter_var($ip, FILTER_VALIDATE_IP) === false) {
  echo("$ip is a valid IP address");
} else {
  echo("$ip is not a valid IP address");
}

/**Callback
 * Son llamadas autorecursivas
 */
//Definimos una fuención, que devuelve la longitud del string que se le pasa
//como argumento
function my_callback($item) {
  return strlen($item);
}

//Definimos un array
$strings = ["apple", "orange", "banana", "coconut"];
//Guardamos en un array, la longitud de cada elemento del array
//array_map => Es una función que recorre todo el array (similar a un foreach)
//"my_callback" => Nombre de la función a la que queremos llamar
//$strings => Es el array origen
$lengths = array_map("my_callback", $strings);
//$lengths => El array de salida, donde se guardan la longitudes de string calculadas
print_r($lengths); //Imprime

/**Callback definidos por el usuario */
//Definimos una función
function exclaim($str) {
  return $str . "! ";
}
//Definimos otra función
function ask($str) {
  return $str . "? ";
}
//Definimos una función que llame a las otras
//1er param: El string a formatear
//2do param: Es el nombre de la función que queremos llamar
function printFormatted($str, $format) {
  echo $format($str); //Devolución del string formateado
}
// Pass "exclaim" and "ask" as callback functions to printFormatted()
printFormatted("Hello world", "exclaim");
printFormatted("Hello world", "ask");

/** JSON
 * Son cadenas de texto con estructura
 * Permite almacenar variables complejas (array) en una cadena de texto
 */
//Defino un array asociativo
$age = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo json_encode($age); //Codifico el array en formato JSON

//Defino una cadena de texto con estructura JSON
echo "<br><br>Conversión JSON:";
$json = '{"Peter":35,"Ben":37,"Joe":43}';
echo "<br><br>De JSON a Objeto:";
var_dump(json_decode($json)); //Descodifico la cadena JSON en un objeto std (estándar)
//Descodifico la cadena JSON en un array
echo "<br><br>De JSON a Array:";
var_dump(json_decode($json, true));
//Alternativa
echo "<br><br>De JSON a Array (v2):";
var_dump((array) json_decode($json));

/** Excepciones
 * Son trozos de código que provocan un error el cual no permite continuar la ejecución
 * Estas excepciones, se puedan capturar, para tramitar el error
 */
//Defino una función que divide
function divide($dividend, $divisor) {
  //Compruebo si el divisor es zero
  if($divisor == 0) {
    //Si el divisor es zero, lanzo una excepción con un mensaje
    //Se acaba la ejecución
    throw new Exception("Division by zero");
  }
  return $dividend / $divisor;
}
//Definimos un bloque de captura de excepciones: TRY...CATCH
//El bloque TRY intenta ejecutar el código
//Pueden ocurrir dos cosas:
//1) Que se ejecute correctamente y continua al siguiente punto de ejecución
try {
  echo divide(5, 0);
//2) Que falle la ejecución, entonces se activa el bloque CATCH
//Permite seguir ejecutando al siguiente punto
} catch(Exception $e) {
  echo "Unable to divide.";
}