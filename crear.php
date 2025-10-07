<?php
require 'conexion.php';
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!validateCSRFToken($_POST['csrfToken']??'')){
        $errors[]='Error de seguridad: token CSRF invalido';
    }else{
        $titulo=trim($_POST['titulo']??'');
        $nivel=trim($_POST['nivel']??'');
        $fechaInicio=trim($_POST['fechaInicio']??'');
        $fechaFin=trim($_POST['fechaFin']??'');
        $duracionHoras=trim($_POST['duracionHoras']??'');
        $descripcion=trim($_POST['descripcion']??'');
        $publicado=$_POST['publicado'];
        // echo"<br> $titulo";
        // echo"<br> $nivel";
        // echo"<br> $fechaInicio";
        // echo"<br> $fechaFin";
        // echo"<br> $duracionHoras";
        // echo"<br> $descripcion";
        // echo"<br> $publicado";
        if(!$titulo)$errors[]='El titulo es obligatorio';
        if(!$fechaInicio)$errors[]='La fecha de inicio es obligatoria';
        if(!$fechaFin)$errors[]='La fecha de fin es obligatoria';
        if(!$duracionHoras)$errors[]='La duracion en horas es obligatoria';
        if(!$descripcion)$errors[]='La descripción es obligatoria';
        if(empty($errors)){
            date_default_timezone_set('Europe/Madrid'); // Ajusta la zona horaria si lo necesitas
            date('Y-m-d H:i:s');
            $sql="INSERT INTO cursos (titulo, descripcion, duracionHoras, nivel, fechaInicio, fechaFin, publicado, createdAt, updatedAt) VALUES (:titulo, :descripcion, :duracionHoras, :nivel, :fechaInicio, :fechaFin, :publicado, :createdAt, :updatedAt)";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                ':titulo'=>$titulo,
                ':descripcion'=>$descripcion,
                ':duracionHoras'=>$duracionHoras,
                ':nivel'=>$nivel,
                ':fechaInicio'=>$fechaInicio,
                ':fechaFin'=>$fechaFin,
                ':publicado'=>$publicado,
                ':createdAt'=>date('Y-m-d H:i:s'),
                ':updatedAt'=>date('Y-m-d H:i:s')
            ]);
            $lastId=$pdo->lastInsertId();
            $sql="SELECT * FROM cursos WHERE id=?";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$lastId]);
            $datos=$stmt->fetch();
            registroAuditoria($pdo,'CREATE','cursos',$datos);
            header("Location:index.php");
            exit;
        }
    }
}
?>
<!-- parte visual html -->
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- iconos botstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css" integrity="sha512-t7Few9xlddEmgd3oKZQahkNI4dS6l80+eGEzFQiqtyVYdvcSG2D3Iub77R20BdotfRPA9caaRkg1tyaJiPmO0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-dark text-white">
    <div class="container py-5">
        <h1 class="mb-4">
            Crear curso
        </h1>
        <!-- zona de errores -->
         <!--  
            <?php if ($errors): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <!-- Mensaje de error -->
                    <ul class="mb-0 list-unstyled">
                        <?php foreach($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
         -->
        <!-- formulario -->
        <form class="row g-3 needs-validation" novalidate method="post">
            <input type="hidden" name="csrfToken" value="<?= htmlspecialchars($csrfToken) ?>">
            <!-- id	titulo	descripcion	duracionHoras	nivel	fechaInicio	fechaFin	publicado	createdAt	updatedAt	 -->
            <!-- 1er campo -->
            <div class="col-md-8">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" value="<?= htmlspecialchars($_POST['titulo']??'') ?>" required name="titulo">
                <div class="invalid-feedback">
                    El titulo es oligatorio
                </div>
            </div>
            <!-- 2do campo -->
            <div class="col-md-4">
                <label for="nivel" class="form-label">Nivel</label>
                <select class="form-select" id="nivel" value="<?= htmlspecialchars($_POST['nivel']??'') ?>" required name="nivel">
                    <option value="BASICO">Básico</option>
                    <option value="MEDIO">Intermedio</option>
                    <option value="AVANZADO">Avanzado</option>
                </select>
                <div class="invalid-feedback">
                    El nivel es oligatorio
                </div>
            </div>
            <!-- 3er campo -->
            <div class="col-md-4">
                <label for="fechaInicio" class="form-label">Fecha inicio</label>
                <input type="date" class="form-control" id="fechaInicio" value="<?= htmlspecialchars($_POST['fechaInicio']??'') ?>" required name="fechaInicio">
                <div class="invalid-feedback">
                    La fecha de inicio es oligatoria
                </div>
            </div>
            <!-- 4to campo -->
            <div class="col-md-4">
                <label for="fechaFin" class="form-label">Fecha final</label>
                <input type="date" class="form-control" id="fechaFin" value="<?= htmlspecialchars($_POST['fechaFin']??'') ?>" required name="fechaFin">
                <div class="invalid-feedback">
                    La fecha de final es oligatoria
                </div>
            </div>
            <!-- 5to campo -->
            <div class="col-md-4">
                <label for="duracionHoras" class="form-label">Duración (en horas)</label>
                <input type="number" class="form-control" id="duracionHoras" value="<?= htmlspecialchars($_POST['duracionHoras']??'') ?>" required name="duracionHoras">
                <div class="invalid-feedback">
                    La duración es oligatoria
                </div>
            </div>
            <!-- 6to campo -->
            <div class="col-md-12">
                <label for="descripcion" class="form-label">Descripción del curso</label>
                <textarea  class="form-control" id="descripcion" required name="descripcion"><?= htmlspecialchars($_POST['descripcion']??'') ?></textarea>
                <div class="invalid-feedback">
                    La descripción del curso es oligatoria
                </div>
            </div>
            <!-- 7mo campo -->
            <div class="col-md-4">
                <input type="hidden" name="publicado" value="0">
                <input type="checkbox" class="form-check-input" id="publicado" value="1" name="publicado" <?= ($_POST['publicado'] ?? '') == '1' ? 'checked' : '' ?>>
                <label for="publicado" class="form-label">Curso activo</label>
            </div>
            
            <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-success" type="submit">
                    Crear
                </button>
                <a class="btn btn-secondary" href="index.php">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
    <script>
        // validacion boodstrap
        aplicarValidacionBootstrap();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>