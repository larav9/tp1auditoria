    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    
    <!-- PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.8/b-3.2.6/b-html5-3.2.6/datatables.min.js"></script>
    
    <!-- Tabla -->
    <script>
    $(document).ready(function () {
        $('#tabla').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/2.1.7/i18n/es-ES.json"
            },
            layout: {
                bottomStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    });
    </script>  
</body>
</html>