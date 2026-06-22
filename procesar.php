<?php
include('includes/conexion.php');
//traemos lo del form
$accion = $_POST['accion'];
$id = $_POST['id'];
$denominacion = $_POST['denominacion'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

$fecha_actual = date('Y-m-d H:i:s'); //guardamos la fecha
$llave_secreta = "trampita"; // La llave secreta para armar el hash

//ahora depende la accion es nuevo, edicion o borrado; se modifican las 2 tablas la de cliente y de auditoria 
if ($accion == 'nuevo') {

    // se arma el hash a mano, concatenando todos los datos mas la llave secreta
    $hash = hash('sha256', $denominacion . $telefono . $email . 'activo' . $llave_secreta);

    $conexion->query("INSERT INTO clientes (denominacion, telefono, email, hash, fecha_registro) VALUES ('$denominacion', '$telefono', '$email', '$hash', '$fecha_actual')");

    $id_nuevo = $conexion->insert_id;

    // Guardamos en auditoria que se dio de alta un cliente
    $detalles = "Alta: $denominacion";
    $conexion->query("INSERT INTO auditoria_cliente (id_cliente, accion, detalles, fecha_modificacion) VALUES ($id_nuevo, 'alta', '$detalles', '$fecha_actual')");

}

if ($accion == 'editar') {

    $res_viejo = $conexion->query("SELECT denominacion FROM clientes WHERE id = $id");
    $viejo = $res_viejo->fetch_assoc();

    $hash = hash('sha256', $denominacion . $telefono . $email . 'activo' . $llave_secreta);

    $detalles = "Se edito esto: " . $viejo['denominacion'] . " por esto: " . $denominacion;

    $conexion->query("UPDATE clientes SET denominacion='$denominacion', telefono='$telefono', email='$email', hash='$hash' WHERE id = $id");

    // Guardamos en auditoria que se modifico un cliente
    $conexion->query("INSERT INTO auditoria_cliente (id_cliente, accion, detalles, fecha_modificacion) VALUES ($id, 'modificacion', '$detalles', '$fecha_actual')");

}

if ($accion == 'borrar') {

    $res = $conexion->query("SELECT denominacion, telefono, email FROM clientes WHERE id = $id");
    $fila = $res->fetch_assoc();

    $hash_baja = hash('sha256', $fila['denominacion'] . $fila['telefono'] . $fila['email'] . 'baja' . $llave_secreta);

    // se hace el update ,guardamos la fecha de borrado
    $conexion->query("UPDATE clientes SET fecha_borrado='$fecha_actual', hash='$hash_baja' WHERE id = $id");

    // Guardamos en auditoria que se dio de baja un cliente
    $detalles = "Baja (soft)";
    $conexion->query("INSERT INTO auditoria_cliente (id_cliente, accion, detalles, fecha_modificacion) VALUES ($id, 'baja', '$detalles', '$fecha_actual')");

}

header("Location: index.php");
exit();
?>