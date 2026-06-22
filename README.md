# Trabajo Práctico N°1 - Auditoría de Sistemas

## Trazabilidad e integridad de la información

**Materia:** Auditoría de Sistemas
**Instituto Superior «Gaspar L. Benavento»**
**Docente:** Delfor Hernán Castro
**Alumnos:** Joaquin Garcia, Lara Vidoni

---

## Uso de la IA

- Consulta sobre el uso de `CURDATE()` en `index.php`:
  https://gemini.google.com/share/57fa1d44d532

- Utilizamos IA para saber dónde ubicar la comparación de hash, por eso terminamos haciéndolo en `index.php`, para volver a mostrar la datatable actualizada. También la utilizamos para realizar este archivo.

---

## Explicación del sistema

Tomamos un proyecto realizado el año pasado. Este tenía dos tablas y vistas de clientes y proveedores, y solo hacía consulta a la base de datos para mostrarla en una DataTable. En ese entonces, la DataTable no tenía botones; eso fue agregado para esta actividad, además de que solo conservamos la parte de Clientes.

### `estructura.sql`
Es el archivo que crea la base de datos desde cero. Crea dos tablas: `clientes` (donde viven los datos reales) y `auditoria_cliente` (donde se anota el historial de qué pasó con cada cliente).

### `includes/conexion.php`
Es la conexión a la base de datos MySQL. Lo usan todos los demás archivos PHP al principio, con un `include`.

### `includes/head.php`
Es el `<head>` del HTML: carga Bootstrap, los estilos propios, el ícono de la página.

### `includes/footer.php`
La parte de abajo de todas las páginas: carga jQuery, Bootstrap y los scripts de DataTables.

### `index.php`
Hace dos cosas:

1. Primero, antes de mostrar nada: recorre todos los clientes de la base y, para cada uno, recalcula su "código de seguridad" (hash) usando sus datos más una palabra secreta que solo conoce el sistema. Si ese código no coincide con el que está guardado, significa que alguien tocó ese cliente directamente en la base de datos (no desde el programa). En ese caso, anota un aviso en la tabla de auditoría.

2. Después: muestra la tabla con todos los clientes activos (los que no fueron dados de baja, soft delete), con botones para editar o borrar cada uno. El botón borrar lo hace directamente, el editar te redirige a la vista de editar.

**Limitación importante:** que solo se detecte que hubo una modificación por fuera del sistema quiere decir que si yo entro y modifico desde la base de datos, lo marcará como fraude (cualquier acción). Tampoco lo va a detectar si no hago un F5, o dejo de entrar al sistema, porque no se recalcula el hash hasta que se vuelve a cargar el listado.

### `nuevo.php`
El formulario para agregar un cliente nuevo. Solo tiene los campos (denominación, teléfono, email) y un botón "Guardar". Cuando se envía, los datos van a `procesar.php`, que es quien realmente los guarda.

### `editar.php`
Busca un cliente por su `id` (que llega por la URL) y muestra el mismo formulario que `nuevo.php`, pero ya completado con sus datos actuales. Al enviar (cuando terminamos de editar los datos deseados), también va a `procesar.php`.

### `procesar.php`
Recibe datos de los formularios y actúa según lo que le digan que hacer:

- **Si es "nuevo"**: calcula el código de seguridad del cliente nuevo y lo guarda en la base. Después anota en la auditoría que hubo un `alta`.
- **Si es "editar"**: recalcula el código con los datos nuevos y actualiza el cliente. Anota en la auditoría que hubo una `modificacion`.
- **Si es "borrar"**: no borra al cliente de verdad — solo le pone una fecha en `fecha_borrado` (por eso deja de aparecer en el listado, pero sus datos siguen ahí). Anota en la auditoría que hubo una `baja`.

Al terminar cualquiera de las tres acciones, vuelve a `index.php`.

### `recursos/css/estilos.css`
Los estilos visuales: fondos, colores, cómo se ve el formulario.

---

## Licencia

MIT License

## Consideraciones Particulares

1. El proyecto nos planteó la necesidad de desarrollar un sistema de registro y gestión de datos directamente sobre una base de datos, sin utilizar un framework que facilitara el intercambio de información entre la aplicación y el motor de base de datos.

2. Decidimos no incorporar validaciones de datos (por ejemplo, controlar que los campos no estén vacíos o que el `id` recibido por la URL exista realmente) para mantener el código simple y acorde al nivel de programación visto hasta el momento en la materia. Esto significa que, si se ingresan datos vacíos en un formulario o se accede a una URL con un `id` inexistente, el sistema no lo va a impedir ni va a mostrar un aviso de error.

