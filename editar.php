<?php 
include('includes/conexion.php');

include('includes/head.php');

$id = $_GET['id'];
$resultado = $conexion->query("SELECT * FROM clientes WHERE id = $id");
$cliente = $resultado->fetch_assoc();

?>
<body class="fondo2">
    <div class="container formulario-cliente">
        <div class="card">
            <div class="card-header text-white">
                <h4>Editar Cliente</h4>
            </div>
            <div class="card-body">
                <form action="procesar.php" method="POST">
                    <input type="hidden" name="accion" value="editar">
                    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

                    <div class="mb-3">
                        <label for="denominacion" class="text-white">Denominación</label>
                        <input type="text" class="form-control" name="denominacion" value="<?php echo $cliente['denominacion']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="text-white">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" value="<?php echo $cliente['telefono']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="text-white">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $cliente['email']; ?>" required>
                    </div>
                    <div class="acciones mt-4">
                        <a href="index.php" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>