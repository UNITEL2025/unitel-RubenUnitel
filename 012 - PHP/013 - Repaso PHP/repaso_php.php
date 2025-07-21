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