1) Crear un programa que contenga un formulario de datos:
Nombre, Apellidos, Tlf, Email, Notas, fecha de creación y fecha de actualización.
2) Crear otra página para mostrar el listado de clientes.

PSEUDOCÓDIGO
==============================================
1) Definimos el objeto "cliente", dentro de la clase, necesitamos:
1.1) Definir sus propias variables de la clase.
1.2) Definir el constructor.
1.3) Guardar/Actualizar un cliente.
1.4) Eliminar un cliente.
1.5) Obtener la lista completa de clientes.
1.6) Obtener un sólo cliente por su id.

2) Hay que hacer el HTML de cliente, contiene un formulario con sus campos:
2.1) NUEVO: Si el cliente no existe, los campos saldrán vacíos.
2.2) EDITAR: Si el cliente existe, hay que rellenar el formulario con su datos.
2.3) ELIMINAR: Eliminar al cliente y devuelve al listado de clientes.

3) Hay que hacer el HTML del listado de clientes, contiene:
3.1) Una tabla con todos los clientes.
3.2) Botón (al final de cada fila) que permita editar al cliente.