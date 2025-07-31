<?php
//Obtener y transformar en integer el valor de la variable q
$q = intval($_GET['q']);

//Hace una conexión a la Base de datos
$con = mysqli_connect('localhost','root','');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
//Seleccionar la BD a usar
mysqli_select_db($con,"crm");
//Prepara el sql
$sql="SELECT * FROM customers WHERE id = ".$q;
//Obtenemos los datos del select
//result será un array asociativo
$result = mysqli_query($con,$sql);

//Imprimir la tabla con los resultados
echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";
//Recorrer los resultados fila a fila
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['firstname'] . "</td>";
  echo "<td>" . $row['lastname'] . "</td>";
  echo "<td>" . $row['phone'] . "</td>";
  echo "<td>" . $row['email'] . "</td>";
  echo "<td>" . $row['notes'] . "</td>";
  echo "</tr>";
}
echo "</table>";
//Cierre de conexión
mysqli_close($con);