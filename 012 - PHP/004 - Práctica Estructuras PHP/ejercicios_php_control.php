<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/004%20-%20Pr%C3%A1ctica%20Estructuras%20PHP/ejercicios_php_control.php

/**  ===========================================
   * EJERCICIOS DE ESTRUCTURAS DE CONTROL EN PHP
   * ===========================================
*/

// 1. Declara una variable $edad. Si es mayor o igual a 18, imprime "Eres mayor de edad".
$edad = 20;
if ($edad >= 18) echo "<br> Eres mayor de edad.";

// 2. Declara una variable $nota. Si es mayor o igual a 5, imprime "Aprobado", si no,
// imprime "Suspendido".
$nota = 10;
if ($nota >= 5) echo "<br>Estás APROBADO.";
else echo "<br>Estás SUSPENSO.";

// 3. Crea un script que evalúe la temperatura:
//    - Si es menor a 0: "Hace mucho frío".
//    - Si está entre 0 y 20: "Hace fresco".
//    - Si es mayor a 20: "Hace calor".
$temp = -10;
if ($temp < 0) echo "<br>Hace mucho frío.";
elseif ($temp >= 0 && $temp <= 20) echo "<br>Hace fresco.";
else echo "<br>Hace calor.";

switch ($temp)
{
   case ($temp <0):
      echo "<br>Hace mucho frío.";
      break;
   case ($temp >= 0 && $temp <= 20):
      echo "<br>Hace fresco.";
      break;
   case ($temp > 20):
      echo "<br>Hace calor.";
      break;
}
   
// 4. Declara una variable $dia con un número entre 1 y 7. Usando switch, muestra el
// nombre del día correspondiente.
$dia = 10;
switch ($dia)
{
   case 1:
      echo "<br>Lunes";
      break;
   case 2:
      echo "<br>Martes";
      break;
   case 3:
      echo "<br>Miércoles";
      break;
   case 4:
      echo "<br>Jueves";
      break;
   case 5:
      echo "<br>Viernes";
      break;
   case 6:
      echo "<br>Sábado";
      break;
   case 7:
      echo "<br>Domingo";
      break;
   default:
      echo "<br>Error el día $dia no existe.";
      break;
}

// 5. Crea un menú con opciones A, B y C. Según la opción seleccionada, muestra:
//    - A => "Has elegido café"
//    - B => "Has elegido té"
//    - C => "Has elegido agua"
//    - Otra => "Opción no válida"
$opt = "ax";
switch(strtoupper($opt))
{
   case "A":
      echo "<br>Has elegido café";
      break;
   case "B":
      echo "<br>Has elegido té";
      break;
   case "C":
      echo "<br>Has elegido agua";
      break;
   default:
      echo "<br>Opción no válida";
      break;
}

// 6. Crea una variable $contador con valor 1. Usando while, imprime los números
// del 1 al 10.
$contador = 1;
while ($contador <= 10)
{
   echo "<br>Ej 6. El número es $contador";
   $contador++;
}

// 7. Usando while, imprime solo los números pares del 1 al 20.
$i = 1;
while ($i <= 20)
{
   if ($i % 2 == 0)
   {
      echo "<br>Números pares: $i";
   }
   $i++;
}

// 8. Usa do-while para imprimir "Bienvenido" al menos una vez, aunque una variable
// $mostrar esté en false.
$mostrar = false;
do {
   echo "<br>Bienvenido!";
} while($mostrar == true);

// 9. Crea un contador con do-while que sume números del 1 al 5 y muestre el
// resultado final.
$contador = 1;
$suma = 0;
do {
   $suma += $contador;
   $contador++;
} while ($contador <= 5);

echo "<br>La suma do-while es $suma";

// 10. Pide al usuario (simulado con variable $intento) que adivine un número secreto.
// Usa while o do-while para repetir hasta que adivine correctamente.
// Usa if para dar pistas ("muy alto", "muy bajo").
$intento = 0; //Variable con el número de intento
$secreto = 75; //Variable que contiene el número a adivinar.
$i = 0; //Contador, para determinar cuántas iteraciones ha necesitado el bucle.
do {
   $intento = rand(-100, 200); //Obtenemos un número aleatorio
   $resultado = ""; //Sub string para indicar si se acerca o no al número secreto
   //Aviso si está por debajo del número secreto
   if ($intento < $secreto) $resultado = " => Muy Bajo";
   //Aviso si está por encima del número secreto
   elseif ($intento > $secreto) $resultado = " => Muy Alto";
   //Aviso y fin del bucle, cuando se acierta el número secreto
   elseif ($intento == $secreto)
   {
      echo "<br>Has acertado! El número a adivinar es: $intento";
      break;
   }
   //Concatenamos la frase de salida junto con el substring
   echo "<br>El número a probar es el: $intento".$resultado;
   //Aumentamos el contador en una unidad
   $i++;
} while (true);

//Aviso final indicando el número de intentos que ha necesitado el sistema
echo "<br>Has necesitado $i intentos.";

// 21. Comprueba la probabilidad que existe de ocurrencia de aleatoriedad en un
// conjunto de 1 millón de números aleatorios del 1 al 10
//1. Inicializamos un array vacío para guardar las veces que sale cada número en el bucle
$resultado = array();
//2. Inicializamos el array con el número de entradas que necesitamos (en este caso 10)
for ($i = 1; $i <= 10; $i++)
{
   $resultado[$i] = 0;
}
//3. Obtengo 1 millón de números aletaroios entre 1 y 10
// Guardo el resultado en el array de $resultado
for ($i = 0; $i <= 1000000; $i++)
{
   $resultado[rand(1, 10)] ++;
}
//4. Calculo porcentajes y muestro en pantalla
echo "<br>==========================================";
echo "<br>============= LOTERÍA ====================";
echo "<br>==========================================";
echo "<br>Número de tiradas: 1.000.000 veces.";
echo "<br>==========================================";
$porc_total = 0;
for ($i = 1; $i <= 10; $i++)
{
   //Número de veces que ha salido el número
   $veces = $resultado[$i];
   //Total de veces que jugamos
   $total = 1000000;
   //Porcentaje de veces que ha salido el número
   $porcentaje = ($veces * 100)/$total;
   //Sumamos el porcentaje parcial al total (para verificar que sale 100%)
   $porc_total += $porcentaje;
   echo "<br>El número $i ha aparecido un $porcentaje %";
}
echo "<br>==========================================";
echo "<br>La suma de los porcentajes es: $porc_total %";

