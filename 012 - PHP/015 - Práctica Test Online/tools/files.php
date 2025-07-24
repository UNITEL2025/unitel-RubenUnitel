<?php

class files {
    // Comprueba si existe el archivo y no está vacío
    public static function check(string $filename): bool {
        return file_exists($filename) && filesize($filename) > 0;
    }

    // Lee un archivo y devuelve un array con las líneas
    public static function read(string $filename): array {
        $salida = [];

        if (!self::check($filename)) return $salida;

        $myfile = fopen($filename, "r") or die("Unable to open file!");
        while (($line = fgets($myfile)) !== false) {
            $line = trim($line);
            if ($line !== "") {
                $salida[] = $line;
            }
        }
        fclose($myfile);

        return $salida;
    }

    // Escribe un array de líneas JSON en el archivo
    public static function write(string $filename, array $items): void {
        $type = "w";
        if (!self::check($filename)) $type = "a";

        $fp = fopen($filename, $type) or die("No se pudo abrir el archivo!");
        foreach ($items as $item) {
            fwrite($fp, $item . "\n"); // $item ya es un JSON string
        }
        fclose($fp);
    }

    // Elimina el contenido del archivo
    public static function delete(string $filename): void {
        if (file_exists($filename)) {
            $myfile = fopen($filename, "w") or die("Unable to open file!");
            fclose($myfile);
        }
    }
}
