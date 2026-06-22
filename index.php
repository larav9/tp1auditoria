<?php
    include ('includes/conexion.php');
    include ('includes/head.php');
?>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="recursos/imagenes/favicon.ico" alt="Logo" width="30" height="24"> 
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Clientes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<?php
    //verificación de integridad 
    //se van a revisar todos los clientes antes de armar la tabla
  
    $llave_secreta = "trampita";
    $fecha_actual = date('Y-m-d H:i:s');

    $revision = $conexion->query("SELECT * FROM clientes");

    while ($dato_rev = $revision->fetch_assoc()) {

        // si fecha_borrado esta vacia, el cliente esta activo, si tiene fecha esta softdeletado
        if (is_null($dato_rev['fecha_borrado'])) {
            $estado_rev = 'activo';
        } else {
            $estado_rev = 'baja';
        }

        $hash_calculado = hash('sha256', $dato_rev['denominacion'] . $dato_rev['telefono'] . $dato_rev['email'] . $estado_rev . $llave_secreta);

        // si el hash no coincide, quiere decir que alguien modifico el registro desde afuera del sistema
        if ($hash_calculado != $dato_rev['hash']) {

            // Antes de avisar, nos fijamos si ya avisamos hoy de este mismo cliente.
            // CURDATE() nos da la fecha de hoy, asi no insertamos 100 veces el mismo aviso
            // cada vez que entramos al listado en el mismo dia.
            $check = $conexion->query("SELECT id_auditoria FROM auditoria_cliente WHERE id_cliente = " . $dato_rev['id'] . " AND accion = 'fraude!' AND DATE(fecha_modificacion) = CURDATE()");

            if ($check->num_rows == 0) {
                $conexion->query("INSERT INTO auditoria_cliente (id_cliente, accion, detalles, fecha_modificacion) VALUES (" . $dato_rev['id'] . ", 'fraude!', 'modificacion en base de datos', '$fecha_actual')");
            }
        }
    }
?>

    <div class="container-fluid mt-4 fondo2">
        <div class="row">
            <div class="col-4">
                <h2>Listado de Clientes</h2>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                <a class="btn btn-success" href="nuevo.php">
                    Agregar Cliente <i class="bi bi-back"></i>
                </a>
            </div>
        </div>
        
        <table id="tabla" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Denominación</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // aca mostramos la tabla
                $datos = $conexion->query("SELECT * FROM clientes");

                while($dato = $datos->fetch_assoc()) {

                    // Si el cliente no esta borrado, lo mostramos en la tabla , aca tuvimos q modificarlo porque sino mostraba los softdeleteados
                    if (is_null($dato['fecha_borrado'])) {
                ?>
                    <tr>
                        <td><?php echo $dato['id']; ?></td>
                        <td><?php echo $dato['denominacion']; ?></td>
                        <td><?php echo $dato['telefono']; ?></td>
                        <td><?php echo $dato['email']; ?></td>
                        <td class='text-end'>    
                            <a class='btn btn-warning' href='editar.php?id=<?php echo $dato['id']; ?>'>
                                <i class='bi bi-pencil-square'></i>
                            </a>   
                            <form action="procesar.php" method="POST" class="d-inline">
                                <input type="hidden" name="accion" value="borrar">
                                <input type="hidden" name="id" value="<?php echo $dato['id']; ?>">
                                <button type="submit" class="btn btn-danger">
                                    <i class='bi bi-trash2-fill'></i>
                                </button>
                            </form>
                        </td> 
                    </tr>
                <?php
                    }
                }
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

<?php include('includes/footer.php');?>