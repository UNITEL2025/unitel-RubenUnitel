<?php
    //http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/001%20-%20Intro%20PHP/basicos_php.php

    // Mi primera línea de php
    echo "My first PHP script!<br>";

    // Mostrar la versión del php en ejecución
    echo phpversion()."<br>";

    //Definición e inicilización de variables
    $color = "ROJO";
    echo "Mi color es: ".$color."<br>"; //Este es mi comentario
    
    //Variables
    $x = 5; //integer
    $y = "John"; //string

    //Salida de variables
    $txt = "W3Schools.com";
    echo "<br>I love $txt!";

    $txt = "W3Schools.com";
    echo "<br>I love " . $txt . "!";

    $x = 5;
    $y = 4;
    echo "<br>".$x + $y."<br>";

    //Tipo datos PHP
    /*
    String -> Cadena de texto
    Integer -> Número entero
    Float (floating point numbers - also called double) -> Decimales
    Boolean -> TRUE/FALSE
    Array -> Colección de datos
    Object -> Objetos
    NULL -> Nulo
    Resource -> Recursos
    */

    //Averiguar el tipo de variable
    $x = 5;
    var_dump($x);
    echo "<br>";
    $y = "5";
    var_dump($y);
    echo "<br>";
    $y = "5555555";
    var_dump($y);

    //Múltiples variables
    $i = $j = $z = 0;

    //Nivel variables
    /*
    local (función) -> Sólo existe en función
    local (archivo) -> Sólo existe en documento
    global -> Existen en todo el sistema
    static -> Variables que permanecen en memoria
    */
    //Ejemplo variable global
    $x = 5; // global scope

    function myTest() {
        // using x inside this function will generate an error
        echo "<p>Variable x inside function is: $x</p>";
    }
    myTest();

    echo "<p>Variable x outside function is: $x</p>";

    //Ejemplo local
    function myTest2() {
        $q = 7; // local scope
        echo "<p>Variable x inside function is: $q</p>";
    }
    myTest2();

    // using x outside the function will generate an error
    echo "<p>Variable x outside function is: $q</p>";

    //Ejemplo variable global
    $x1 = 5;
    $y1 = 10;

    function myTest3() {
        global $x1, $y1;
        $y1 = $x1 + $y1;
    }

    myTest3();
    echo $y1; // outputs 15

    // Estáticas
    function myTest4() {
        static $x2 = 0;
        echo "<br>Salida myTest4: ".$x2;
        $x2++;
    }

    myTest4();
    myTest4();
    myTest4();

    //Print
    print "Hello";
    //same as:
    print("Hello");

    //Resumen de impresion
    /*
    echo();
    var_dump();
    print();
    */

    //Definir array
    echo "<br>";
    $cars = array(); //Array vacío
    $cars = array(2,3,6,4,8);
    $cars = array(2.4, 8.7, 6.9, 4.1);
    $cars = array("Volvo","BMW","Toyota"); //Array inicilizado
    var_dump($cars);
    echo "<br>";
    echo $cars;
    echo "<br>";
    print($cars);

    //Definición de clases
    /**En programación estructurada, instanciar una clase significa crear un 
     * objeto a partir de una definición de clase. Es decir, tomar una plantilla 
     * (la clase) y generar una copia funcional (el objeto) que puede ser utilizada
     * en el programa.  */
    //Encapsulación de variables, métodos y funciones en una clase
    class Car {
        public $color_clase;
        public $model_clase;
        private $matricula = "4785TGR";

        public function __construct($color_input, $model_input) {
            $this->color_clase = $color_input;
            $this->model_clase = $model_input;
        }
    
        public function message() {
            return "My car is a " . $this->color_clase . " " . $this->model_clase . "!";
        }

        public function getColor() {
            return $this->color_clase;
        }

        public function getMatricula() {
            return $this->matricula;
        }

        public function setColor($color_setcolor) {
            $this->color_clase = $color_setcolor;
        }
    }

    //Instanciar una clase Car
    $myCar = new Car("red", "Volvo");
    echo "<br><br>";
    var_dump($myCar);
    //Salida esperada: object(Car)#1 (2) { ["color_clase"]=> string(3) "red" ["model_clase"]=> string(5) "Volvo" }

    //Llamar a la función message() de la clase Car
    $mensaje = $myCar->message();
    echo "<br><br>";
    var_dump($mensaje);
    //Salida esperada: string(22) "My car is a red Volvo!"

    //Obtener el color mediante la función get
    echo "<br><br>";
    var_dump($myCar->getColor());
    //Salida esperada: string(3) "red"

    //Función de salto de línea
    function salto($imprimir = "") {
        return "<br><br>".$imprimir;
    }

    //Obtener el color directamente (porque es público)
    echo salto();
    var_dump($myCar->color_clase);
    //Salida esperada: string(3) "red"

    //Obtener el matrícula directamente (es privada)
    //echo salto();
    //var_dump($myCar->matricula);

    //Obtener la matrícula (privada) desde función (pública)
    echo salto();
    var_dump($myCar->getMatricula());
    //Resultado esperado: string(7) "4785TGR"

    //Cambiar el color de la clase a través de una función
    //1) Tengo un coche ($myCar) con red y Volvo
    //2) Seteo el color a azul (lo cambio)
    echo salto();
    var_dump("Color antiguo: ".$myCar->color_clase);
    echo salto("Cambiando color...");
    $myCar->setColor("Azul");
    echo salto();
    var_dump("Color nuevo: ".$myCar->color_clase);

    //Función salto
    //Sin parámetro de entrada
    echo salto(); //Sólo retornorá un salto de línea

    //Con parámetro de entrada
    echo salto("Mi nuevo texto"); //Restornará un salto de línea más el texto que
    //le he indicado

    //Imprimir el color con función salto
    echo salto("Mi color es: ".$myCar->color_clase);

    //Cast (convertir variable de tipo)
    //Ej. de número a string
    $miNumero = 6; //Ahora es un integer
    echo salto();
    var_dump($miNumero);
    //Salida esperada: int(6)
    $miNumero = (string) $miNumero; //Convertir a string -> Ahora es un string
    echo salto();
    var_dump($miNumero);
    //Salida esperada: string(1) "6"

    //Funciones de string
    //Muestra la longitud de la cadena
    echo salto(strlen("Hello world!"));
    //Salida: 12

    //Cuenta las palabras de un string
    echo salto(str_word_count("Hello world!"));
    //Salida: 2

    //Indica la posición de inicio en la cadena del param indicado
    echo salto(strpos("Hello world!", "world"));
    //Salida: 6

    //Cambia el string a mayúsculas
    $x = "Hello World!";
    echo salto(strtoupper($x));
    //Salida: HELLO WORLD!

    $x = "HELLO WORLD!";
    echo salto(strtolower($x));
    //Salida: hello world!

    //Reemplazar caracteres
    $x = "Hello World!";
    echo salto(str_replace("World", "Dolly", $x));
    //Salida: Hello Dolly!

    //Otro ejemplo de reemplazar caracteres
    //URL Amigables
    $pagina = "Mi primera página en HTML";
    $url = str_replace(" ", "-", $pagina);
    echo salto($url);
    //Salida: Mi-primera-página-en-HTML

    //Dar la vuelta al string
    $x = "Hello World!";
    echo salto(strrev($x));

    //Eliminar espacios en blanco (sólo al inicio y al final)
    $x = " Hello World! ";
    echo salto(trim($x));

    //Convertir string en array
    $x = "Hello World!";
    $y = explode(" ", $x);

    echo salto();
    var_dump($y);
    //Salida: array(2) { [0]=> string(5) "Hello" [1]=> string(6) "World!" }

    //Concatenación de string
    $x = "Hello";
    $y = "World";
    $z = $x . $y;
    echo salto($z);
    //Salida: HelloWorld

    //Igual que anterior, añadiendo un espacio
    $x = "Hello";
    $y = "World";
    $z = $x . " " . $y;
    echo salto($z);
    //Salida: Hello World

    //Concatenación sin punto
    $x = "Hello";
    $y = "World";
    $z = "$x $y";
    echo salto($z);

    //Cortar un string
    $x = "Hello World!";
    echo salto(substr($x, 6, 5));
    //Salida: World

    //Igual que el anterior, pero coge el total de la longitud
    $x = "Hello World!";
    echo salto(substr($x, 6));
    //Salida: World!

    //Cortar desde el final
    $x = "Hello World!";
    echo salto(substr($x, -5, 3));
    //Salida: orl

    //Igual que el anterior con offset negativo
    $x = "Hi, how are you?";
    echo salto(substr($x, 5, -3));
    //Salida: ow are y

    //Escape de caracteres: Indicamos con la barra lateral invertida
    // que queremos imprimir el caracter que sigue a la barra
    $x = "We are the so-called \"Vikings\" from the north.";
    echo salto($x);

    //Impresión de constantes de integers
    echo salto("PHP_INT_MAX -> ".PHP_INT_MAX);
    echo salto("PHP_INT_MIN -> ".PHP_INT_MIN);
    echo salto("PHP_INT_SIZE -> ".PHP_INT_SIZE);

    //Chequear si la variable es integer
    /**
     * is_int()
     * is_integer() - alias of is_int()
     * is_long() - alias of is_int()
     */
    $x = 5985;
    echo salto();
    var_dump(is_int($x));
    //Salida: TRUE

    $x = 59.85;
    echo salto();
    var_dump(is_int($x));
    //Salida: FALSE

    //Constantes de float
    echo salto("PHP_FLOAT_MAX -> ".PHP_FLOAT_MAX);
    echo salto("PHP_FLOAT_MIN -> ".PHP_FLOAT_MIN);
    echo salto("PHP_FLOAT_DIG -> ".PHP_FLOAT_DIG);
    echo salto("PHP_FLOAT_EPSILON -> ".PHP_FLOAT_EPSILON);

    //Comprobar que el número sea un float
    $x = 10.365;
    echo salto();
    var_dump(is_float($x));
    //Salida: TRUE

    //Infinity -> Números muy grandes (exceden al límite de FLOAT)
    $x = 1.9e411;
    echo salto();
    var_dump($x);

    //Nan -> Para cálculos matemáticos imposibles
    $x = acos(8);
    echo salto();
    var_dump($x);

    //String numérico -> Son strings suceptibles de convertirse a var numérica
    echo salto("INTEGER");
    $x = 5985;
    var_dump(is_numeric($x));
    echo salto("CADENA");
    $x = "5985";
    var_dump(is_numeric($x));
    echo salto("FLOAT CADENA + INTEGER");
    $x = "59.85" + 100;
    var_dump(is_numeric($x));
    echo salto("CADENA");
    $x = "Hello";
    var_dump(is_numeric($x));

    //Convertir vars a enteros
    // Cast float to int
    echo salto();
    $x = 23465.768;
    $int_cast = (int) $x;
    echo $int_cast;

    echo "<br>";

    // Cast string to int
    $x = "23465.768";
    $int_cast = (int) $x;
    echo $int_cast;

    //Casting (transformar el tipo de dato)
    /**
     * (string) - Converts to data type String
     * (int) - Converts to data type Integer
     * (float) - Converts to data type Float
     * (bool) - Converts to data type Boolean
     * (array) - Converts to data type Array (implode/explode)
     * (object) - Converts to data type Object (serialize)
     * (unset) - Converts to data type NULL
     */
    //Cast a string
    $a = 5;       // Integer
    $b = 5.34;    // Float
    $c = "hello"; // String
    $d = true;    // Boolean
    $e = NULL;    // NULL

    $a = (string) $a;
    $b = (string) $b;
    $c = (string) $c;
    $d = (string) $d;
    $e = (string) $e;

    //To verify the type of any object in PHP, use the var_dump() function:
    echo salto();
    var_dump($a);
    echo salto();
    var_dump($b);
    echo salto();
    var_dump($c);
    echo salto();
    var_dump($d);
    echo salto();
    var_dump($e);

    //Cast a Integer
    $a = 5;       // Integer
    $b = 5.34;    // Float
    $c = "25 kilometers"; // String
    $d = "kilometers 25"; // String
    $e = "hello"; // String
    $f = true;    // Boolean
    $g = NULL;    // NULL

    $a = (int) $a;
    $b = (int) $b;
    $c = (int) $c;
    $d = (int) $d;
    $e = (int) $e;
    $f = (int) $f;
    $g = (int) $g;

    echo salto();
    var_dump($a);
    echo salto();
    var_dump($b);
    echo salto();
    var_dump($c);
    echo salto();
    var_dump($d);
    echo salto();
    var_dump($e);
    echo salto();
    var_dump($f);
    echo salto();
    var_dump($g);

    //Cast a float
    $a = 5;       // Integer
    $b = 5.34;    // Float
    $c = "25 kilometers"; // String
    $d = "kilometers 25"; // String
    $e = "hello"; // String
    $f = true;    // Boolean
    $g = NULL;    // NULL

    $a = (float) $a;
    $b = (float) $b;
    $c = (float) $c;
    $d = (float) $d;
    $e = (float) $e;
    $f = (float) $f;
    $g = (float) $g;

    echo salto();
    var_dump($a);
    echo salto();
    var_dump($b);
    echo salto();
    var_dump($c);
    echo salto();
    var_dump($d);
    echo salto();
    var_dump($e);
    echo salto();
    var_dump($f);
    echo salto();
    var_dump($g);

    //Cast a Boolean
    $a = 5;       // Integer
    $b = 5.34;    // Float
    $c = 0;       // Integer
    $d = -1;      // Integer
    $e = 0.1;     // Float
    $f = "hello"; // String
    $g = "";      // String
    $h = true;    // Boolean
    $i = NULL;    // NULL

    $a = (bool) $a;
    $b = (bool) $b;
    $c = (bool) $c;
    $d = (bool) $d;
    $e = (bool) $e;
    $f = (bool) $f;
    $g = (bool) $g;
    $h = (bool) $h;
    $i = (bool) $i;

    echo salto();
    var_dump($a);
    echo salto();
    var_dump($b);
    echo salto();
    var_dump($c);
    echo salto();
    var_dump($d);
    echo salto();
    var_dump($e);
    echo salto();
    var_dump($f);
    echo salto();
    var_dump($g);
    echo salto();
    var_dump($h);
    echo salto();
    var_dump($i);

    //Cast a array
    $a = 5;       // Integer
    $b = 5.34;    // Float
    $c = "hello"; // String
    $d = true;    // Boolean
    $e = NULL;    // NULL

    $a = (array) $a;
    $b = (array) $b;
    $c = (array) $c;
    $d = (array) $d;
    $e = (array) $e;

    echo salto();
    var_dump($a);
    echo salto();
    var_dump($b);
    echo salto();
    var_dump($c);
    echo salto();
    var_dump($d);
    echo salto();
    var_dump($e);

    //Ejemploo: Convertir la clase coche en array
    echo salto();
    $myCar = (array) $myCar;
    var_dump($myCar);

    //Cast a objeto
    $a = 5;       // Integer
    $b = 5.34;    // Float
    $c = "hello"; // String
    $d = true;    // Boolean
    $e = NULL;    // NULL

    $a = (object) $a;
    $b = (object) $b;
    $c = (object) $c;
    $d = (object) $d;
    $e = (object) $e;

    echo salto();
    var_dump($a);
    echo salto();
    var_dump($b);
    echo salto();
    var_dump($c);
    echo salto();
    var_dump($d);
    echo salto();
    var_dump($e);

    //Funciones matemáticas
    //PI
    echo salto("PI: ".pi());
    //Mín y Máx
    echo salto("MIN:");
    echo(min(0, 150, 30, 20, -8, -200));
    echo salto("MAX:");
    echo(max(0, 150, 30, 20, -8, -200));
    //ABS (Valor absoluto)
    echo salto("ABS:");
    echo(abs(-6.7));

    //Raíz cuadrada de un número
    echo salto("Raíz cuadrada de un número:");
    echo(sqrt(64));

    //Redondear
    echo salto("Redondeo:");
    echo(round(0.60));
    echo salto();
    echo(round(0.49));
    echo salto();
    echo(round(0.5));

    //Números aleatorios
    echo salto("Números aleatorios:");
    echo(rand());

    //Definición de constantes
    echo salto();
    define("_GREETING", "Welcome to W3Schools.com!");
    echo _GREETING;

    //Otra forma (lo mismo que lo anterior)
    echo salto();
    const MYCAR = "Volvo";
    echo MYCAR;
?>
