<?php include('includes/head.php'); ?>
<body class="fondo2">
    <div class="container formulario-cliente">  
        <div class="card">
            <div class="card-header text-white">
                <h4>Alta de Cliente</h4>
            </div>
            <div class="card-body">
                <form action="procesar.php" method="POST">
                    <input type="hidden" name="accion" value="nuevo">

                    <div class="mb-3">
                        <label for="denominacion" class="text-white">Denominación</label>
                        <input type="text" class="form-control" name="denominacion" id="denominacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="text-white">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="text-white">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="acciones mt-4">
                        <a href="index.php" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>