<?php

/**
 * JUEGO
 * 
 * Definir atributos
 * Constructor
 * GetAll(todo)
 * GetById(devuelve 1 id concreto)
 * toJson (transforma el objeto a JSON)
 * save(guarda/actualiza 1 juego)
 * deleteAll(borra todos los juegos)
 */

//Comprobar que el archivo existe

//TODA la clase en estática
class file {
    

    //Funcion --- Comprueba el esta del archivo
    public static function estadoArc(string $filename) {
        return (file_exists($filename) && filesize($filename) > 0);

        //Devolverá true si existe el archivo y tiene contenido
    }
    

    //Funcion --- Leer el archivo linea a linea
    public static function leerArc(string $filename) {

        $lineas = array();

        //Si no existe el archivo
        if (!self::estadoArc($filename))
        {
            return $lineas;
        }

        $myfile = fopen($filename, "r") or die ("Imposible abrir el archivo");       

        if ($myfile) {

            while (($buffer = fgets($myfile)) !== false) {
                $blimpio = trim($buffer); //Elimina espacios antes y después
                if ($blimpio != "") $lineas[] = $blimpio;
            }

            if (!feof($myfile)) {
                echo "Error: fgets() fallo\n";
            }
            fclose($myfile);
        }

        return $lineas;

        /*foreach ($lineas as $key => $value) {
            echo $value."<br>";
        }*/

    }

    //Funcion --- Escribir en el archivo
    //El input es un array de cadenas de texto estructuradas en JSON
    public static function escribirArc(string $filename, array $lineas) {

        //Si el archivo no existe -> Modo de apertura es "w"
        //Si el archivo existe: El modo de apertura es "a"
        $tipo = "w";
        if (self::estadoArc($filename)) $tipo = "a";

        //Abre el archivo
        $myfile = fopen($filename,$tipo) or die ("Imposible abrir el archivo");
        //Escribe en el archivo y mete un salto de linea
        foreach ($lineas as $linea) {
            fwrite($myfile, $linea. PHP_EOL);
        }
        
        //Cierra el archivo
        fclose($myfile);
        
    }

    //Funcion --- Eliminar contenido
    public static function eliminarArch(string $filename) {
        if (self::estadoArc($filename))
        {
            //Borra el contenido del archivo
            //file_put_contents($this->archivo, "");
            //Imprime un mensaje que indica que se ha borrado el contenido
            //echo "Archivo borrado correctamente";
            $myfile = fopen($filename, "w") or die ("Imposible abrir el archivo");            
            //Cierra el archivo
            fclose($myfile);
        }       
    }

    //Va en preguintas
    /*public function save(Pregunta $pregunta) {

        $linea = $pregunta->alinea();
        file_put_contents($this->archivo, $linea .PHP_EOL);
        echo "Pregunta guardada correctamente";

    }*/

}