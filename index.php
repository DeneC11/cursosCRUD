<?php
require 'conexion.php'; //incliye conexion--> generar/comparar CSRF
$sql = "SELECT * FROM cursos ORDER BY id DESC";
$stmt = $pdo->query($sql);
$cursos = $stmt->fetchAll();
// echo'<pre>';
// print_r($cursos);
// echo'</pre>';
// exit;
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabla de cursos CRUD</title>
    <!-- bootstrap base -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- datatable css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">
    <!-- responsive datatable -->
     <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
     <meta name="viewport" content="width=device-width" />
</head>

<body class=" bg-dark text-white">
    <div class="container py-5">
        <h1 class="text-center">Cursos</h1>
        <div class="text-end mb-3">
            <a href="crear.php" class="btn btn-success">
                Crear nuevo curso
            </a>
        </div>
        <div class="table-responsive">
        <table id="cursosTable" class="table table-striped table-hover border display nowrap">
            <thead>
                <!-- id	titulo	descripcion	duracionHoras	nivel	fechaInicio	fechaFin	publicado	createdAt	updatedAt	 -->
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Titulo</th>
                    <th>Descripción</th>
                    <th>Duración</th>
                    <th>Nivel</th>
                    <th>Fecha inicio</th>
                    <th>Fecha final</th>
                    <th>Publicado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $curs): ?>
                    <tr>
                        <!-- <td><?= htmlspecialchars($curs['id']) ?></td> -->
                        <td><?= htmlspecialchars($curs['titulo']) ?></td>
                        <td><?= htmlspecialchars($curs['descripcion']) ?></td>
                        <td><?= htmlspecialchars($curs['duracionHoras'] . ' horas') ?></td>
                        <td><?= htmlspecialchars($curs['nivel']) ?></td>
                        <td><?= htmlspecialchars($curs['fechaInicio']) ?></td>
                        <td><?= htmlspecialchars($curs['fechaFin']) ?></td>
                        <td><?= htmlspecialchars($curs['publicado'] ? 'si' : 'no') ?></td>
                        <td class="d-flex justify-content-center">
                            <!-- editar -->
                            <a href="editar.php?id=<?= $curs['id'] ?>"><i class="btn btn-outline-success btn-sm me-2">Editar</i></a>
                            <!-- borrar -->
                            <form action="borrar.php" method="POST" onsubmit="return confirm('Estas seguro que quieres eliminar el usuario <?= htmlspecialchars($curs['titulo']) ?>')">
                                <input type="hidden" name="csrfToken" value="<?= $csrfToken ?>">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($curs['id']) ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm d-inline-block text-center">Borrar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011-04-25</td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>Garrett Winters</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                    <td>63</td>
                    <td>2011-07-25</td>
                    <td>$170,750</td>
                </tr> -->
            </tbody>
        </table>
        </div>
        <form action="regenerar.php" method="post" onsubmit="return confirm('¿Estás seguro de que quieres regenerar la tabla? Se perderán los cambios.')">
            <button type="submit" class="btn btn-warning">🔄 Regenerar tabla</button>
        </form>
    </div>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- datatable -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script>
        // import DataTable from 'datatables.net';
        // import language from 'datatables.net-plugins/i18n/es-ES.mjs';
        var table = new DataTable('#cursosTable', {
            language: {
                url: './es-ES.json',
            },
            responsive: true
        });
    </script>
</body>

</html>