<?php

//OOP => Programación Orientada a objetos

//Definimos la clase fruta (que es la plantilla para el objeto)
class Fruit {
    // Propiedad => Propiedades/Atributos de la clase
    public $name; //Nombre
    public $color; //Color
    protected $type;
    private $size;

    //Accesibilidad
    //Se usa para las propiedades y para los métodos
    //public => La de por defecto, y permite acceder tanto a la ppdad como al método
    //desde DENTRO y FUERA de la clase
    //protected => Es accesible desde DENTRO de la clase y sus derivados
    //private => Sólo es accesible desde la PROPIA clase

    //Si tu creas un constructor, la clase llamará de manera automática al constructor
    function __construct($name, $color) {
        $this->name = $name;
        $this->color = $color;
    }

    //Si tu creas el destructor, la clase llamará de manera automática al destructor
    //cuando se finaliza el script
    function __destruct() {
        echo "The fruit is {$this->name}.";
    }

    // Métodos => Son funciones reutilizables (dentro de la clase)
    //Setear/Poner el nombre
    function set_name($name) {
        $this->name = $name;
    }

    //Obtener o recuperar el nombre
    function get_name() {
        return $this->name;
    }

    //Cuando me quiero referir a una propiedad/atributo DENTRO de la clase
    //Llamo a la variable con $this->variable

    public function intro() {
        echo "The fruit is {$this->name} and the color is {$this->color}.";
    }
}

//Definir el objeto en base a la clase(plantilla)
/*$apple = new Fruit(); //Instancio/Creo una clase fruta => Manzana
$banana = new Fruit(); //Instancio/Creo una clase fruta => Banana
$apple->set_name('Apple'); //Asignamos su nombre
$banana->set_name('Banana'); //Asignamos su nombre

echo $apple->get_name(); //Recuperamos el nombre
echo "<br>";
echo $banana->get_name(); //Recuperamos el nombre*/

//Cómo las propiedades de la clase, en este ejemplo, son públicas
//Puedo acceder directamente desde FUERA de la clase
//$apple->name = "Apple";

//Para determinar qué tipo de clase es, usamos instanceof
//var_dump($apple instanceof Fruit);

//Comprobamos la accesibilidad de las propiedades
/*echo "<br>".$apple->name; //Imprimirá
echo "<br>".$apple->type; //Da un error (xk estoy fuera de la clase)
echo "<br>".$apple->size; //Da un error (xk estoy fuera de la clase)*/

//La Herencia, es crear clases dependientes, por ejemplo,
//Tenemos la clase FRUTA, que sería la clase padre
//Tenemos las clases: Pera, Manzana, etc..., que serían las clases hijas
//Por tanto, dependientes de la padre
//Las hijas pueden acceder a las ppdes y métodos de la clase padre (superior)

// Fresa hereda de fruta
/*class Strawberry extends Fruit {
  public function message() {
    echo "Am I a fruit or a berry? ";
  }
}
$strawberry = new Strawberry("Strawberry", "red");
$strawberry->message();
$strawberry->intro();*/

//Sobreescrituras/Override
//Sobre escribir aspectos de otra clase
//Ejemplo: La clase tiene una función message();
//Pero la clase hija puede sobreescribir la función message();
//Cuál se ejecutará? La del hijo xk sustituye a la del padre
class Strawberry extends Fruit {
  public $weight;
  public function __construct($name, $color, $weight) {
    $this->name = $name;
    $this->color = $color;
    $this->weight = $weight;
  }
  public function intro() {
    echo "The fruit is {$this->name}, the color is {$this->color}, and the weight is {$this->weight} gram.";
  }
}

//Ejecuta el constructor de la clase FRESA (hija)
$strawberry = new Strawberry("Strawberry", "red", 50);
$strawberry->intro(); //Se ejecuta la función de la clase FRESA (hija)

class Banana extends Fruit {
}
//Ejecuta el constructor de la clase FRUTA (padre)
$banana = new Banana("Banana", "yellow");
$banana->intro(); //Ejecuta la función de la clase FRUTA (padre)

//Palabra clave: final
//Evita que se pueda heredar ni sobrescribir la clase, si se intenta heredar dará un error
/*final class Fruit {
  // some code
}*/

//Constantes: Son como las variable pero no son modificables
class Goodbye {
  const LEAVING_MESSAGE = "Thank you for visiting W3Schools.com!";

  public function byebye() {
    echo self::LEAVING_MESSAGE; //Llamar desde DENTRO de la clase
  }
}

echo Goodbye::LEAVING_MESSAGE; //Llamar a la constante desde FUERA de la clase

//Clases y Métodos Abstractos
//Las clases y métodos abstractos son la plantilla de la clase que implementa el objeto
//Es decir, son la plantilla (abstracta) de la plantilla(clase) del objeto

//Conceptos:
//Definición (ppdes o métodos) => Que indica la cabecera
//Implementación: El código que añadimos dentro de cada función

//Las clases abstractas definen pero no implementan
//Sintaxis
/*abstract class ParentClass {
    //Está devuelve el objeto según el id indicado
    //Input: (int) id
    //Output: object (puede retornar null si no se encuentra)
    abstract public function getById(int $id) : object;
    //Guarda los param en BBDD
    abstract public function save($name, $color) : bool;
    //Devuelve un array de todos los objetos de la clase
    abstract public function getAll() : array;
}*/
// Parent class
abstract class Car {
  public $name;
  //Define e implementa el constructor
  public function __construct($name) {
    $this->name = $name;
  }
  //Define la función (no realiza la implementación)
  abstract public function intro() : string;
}

// Creamos la clase hija
class Audi extends Car {
    //Implemento la función que se indica en la clase abstracta
    //Si no se implementa dará un error
    public function intro() : string {
        return "Choose German quality! I'm an $this->name!";
    }
}

$audi = new audi("Audi");
echo $audi->intro();//Ejecuta la función de la hija

//Interfaces
//Las interfaces te permiten especificar qué métodos de la clase deberán ser implementados
//Sintaxis
/*interface InterfaceName {
  public function someMethod1();
  public function someMethod2($name, $color);
  public function someMethod3() : string;
}*/
interface Animal {
  public function makeSound();
}

class Cat implements Animal {
  public function makeSound() {
    echo "Meow";
  }
}

$animal = new Cat();
$animal->makeSound(); //Ejecuta la función hija

//Rasgos (traits)
//Permiten declarar métodos para que puedan ser usados en múltiples clases
//Sintaxis
/*trait TraitName {
  // some code...
}*/

//Sintaxis: Uso de trait
/*class MyClass {
  use TraitName;
}*/

trait message1 {
    public function msg1() {
        echo "OOP is fun! ";
    }
}

class Welcome {
  use message1;
}

class Bye {
  use message1;
}

$obj = new Welcome();
$obj->msg1(); //Permite llamar a la función del trait

$obj = new Bye();
$obj->msg1();//Permite llamar a la función del trait

//Métodos estáticos
//Se les pueda llamar directamente SIN NCESIDAD de instanciar la clase
//Sintaxis
/*class ClassName {
  public static function staticMethod() {
    echo "Hello World!";
  }
}
ClassName::staticMethod();*/
class greeting {
  public static function welcome() {
    echo "Hello World!";
  }

  public function __construct() {
    self::welcome(); //LLamar al método estático desde DENTRO de la clase
  }
}

greeting::welcome(); //Lamar a un método estático desde FUERA de la clase

//Como llamar a métodos estáticos, de la clase padre desde la clase hija
class domain {
  protected static function getWebsiteName() {
    return "W3Schools.com";
  }
}

class domainW3 extends domain {
  public $websiteName;
  public function __construct() {
    //Llamar a la función estática del padre, desde la hija (parent)
    $this->websiteName = parent::getWebsiteName();
  }
}

$domainW3 = new domainW3();
echo $domainW3->websiteName;

//Propiedades estáticas
//Se pueden llamar sin necesidad de instanciar la clase
/*class ClassName {
  public static $staticProp = "W3Schools";
}
ClassName::$staticProp;*/

class pi {
  public static $value = 3.14159;
}

echo pi::$value;

//Namespace
//1) Permiten una mejor organización agrupando clases que trabajan juntas
//para mejorar la tarea
//2) Permiten que puedan ser usadas al mismo tiempo por más de una clase.
//Es decir, conjunto de clases que tienen algo en común
//Ejemplo: Clases controladoras de base de datos (PDO, mySqli, Oracle...)
//Su namespce podría ser: connection
//Sintaxis:
//IMPORTANTE! Deben ir al principio del archivo
//namespace Html;

namespace Html; //Declaración del namespace
class Table { //Declaración de la clase (crear tablas)
  public $title = "";
  public $numRows = 0;
  public function message() {
    echo "<p>Table '{$this->title}' has {$this->numRows} rows.</p>";
  }
}
$table = new Table();
$table->title = "My table";
$table->numRows = 5;
?>

<!DOCTYPE html>
<html>
    <body>
        <?php $table->message();?>
    </body>
</html>

<?php 
    namespace html;
    $table = new Html\Table();
    $row = new Html\Row();

    //Iterables
    //Son tipos de datos que pueden iterar: arrays y los iteradores
    //Arrays ya los conocemos
    //Los iteradores son "cosas" que permiten iterar el dato
    //Los iterables nos permiten definir tipo de datos que puedan iterar
?>