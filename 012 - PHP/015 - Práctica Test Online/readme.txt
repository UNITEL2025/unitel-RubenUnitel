Realizar un test online, que contenga:
1) 10 preguntas tipo test
2) Cada pregunta debe estar en una página
3) La info necesaria se guardará en una cookie
4) Si el test se queda a medias, debe ser posible recuperar el test
en su última parte ejecutada.
5) Debe mostrar una página final con el resultado del test:
5.1) Número de preguntas acertadas.
5.2) Porcentaje de aciertos.
5.3) Debe mostrar cuanto ha tardado en hacer el test completo.
6) Se debe crear una clase "test" que contenga los datos del test.
7) Se debe una clase que contenga que defina las preguntas.
8) Hay que solicitar el nombre del jugador.
9) Las clases deben ir fuera del archivo php principal.
10) Las partidas se deben almacenar en un archivo plano de texto.
11) Las preguntas deben estar almacenadas en un archivo txt.


LÓGICA DE CLASE PREGUNTA -> FUNCIÓN SAVE
===========================================================
1) Tengo id_pregunta?¿
1.1) Lo tenga -> Por tanto tengo que actualizar
1.2) Que sea null -> Por tanto, lo tengo que añadir al final

2) Leo todas las preguntas, obtengo un array de cadenas de texto formatedas en JSON
$items = array(
	{"id_pregunta":0,"pregunta":"\u00bfEsta es ...",
	{"id_pregunta":1,"pregunta":"\u00bfEsta es ..."
);

3) Acciones
3.1) Que este actualización -> Tengo que buscar la posición de la pregunta en el array
y sustuir
Si mi pregunta es la 1 y dispongo de este array:
$items = array(
	{"id_pregunta":0,"pregunta":"\u00bfEsta es ...",
	{"id_pregunta":1,"pregunta":"\u00bfEsta es ..."
);
Lo recorro, y cuando encuentre la pregunta con id = 1
$items[pos] = $this (transformar en JSON);
3.2) Que sea nueva
$items[] = $this;

4) Escribo de nuevo el archivo
file::escribir($items); A esta función se le pasa un array de cadenas JSON
$items = array(
	{"id_pregunta":0,"pregunta":"\u00bfEsta es ...",
	{"id_pregunta":1,"pregunta":"\u00bfEsta es ..."
);















