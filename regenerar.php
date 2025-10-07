<?php
include 'conexion.php'; // Aquí se define $pdo

// Mostrar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Eliminar todos los cursos
    $pdo->exec("DELETE FROM cursos");

    // Insertar cursos originales
    $cursos = [
        ["CDmon", "curso muy complicado de CDmon", "100 horas", "AVANZADO", "2025-10-01", "2025-10-12", "no"],
        ["css", "curso de css basico", "30 horas", "BASICO", "2025-09-26", "2025-09-30", "si"],
        ["java script", "curso java script avanzado", "60 horas", "AVANZADO", "2025-09-26", "2025-09-30", "no"],
        ["php", "curso de php intermedio", "55 horas", "MEDIO", "2025-09-26", "2025-09-30", "si"]
    ];

    $stmt = $pdo->prepare("INSERT INTO cursos (titulo, descripcion, duracionHoras, nivel, fechaInicio, fechaFin, publicado) VALUES (:titulo, :descripcion, :duracionHoras, :nivel, :fechaInicio, :fechaFin, :publicado)");

    foreach ($cursos as $curso) {
        $stmt->execute([
            ':titulo' => $curso[0],
            ':descripcion' => $curso[1],
            ':duracionHoras' => $curso[2],
            ':nivel' => $curso[3],
            ':fechaInicio' => $curso[4],
            ':fechaFin' => $curso[5],
            ':publicado' => $curso[6]
        ]);
    }
    // $sql = "INSERT INTO cursos (titulo, descripcion, duracionHoras, nivel, fechaInicio, fechaFin, publicado, createdAt, updatedAt) VALUES (:titulo, :descripcion, :duracionHoras, :nivel, :fechaInicio, :fechaFin, :publicado, :createdAt, :updatedAt)";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([
    //     ':titulo' => $titulo,
    //     ':descripcion' => $descripcion,
    //     ':duracionHoras' => $duracionHoras,
    //     ':nivel' => $nivel,
    //     ':fechaInicio' => $fechaInicio,
    //     ':fechaFin' => $fechaFin,
    //     ':publicado' => $publicado,
    // ]);

    echo "✅ Tabla regenerada correctamente.";
    header("Location:index.php");
    exit;
} catch (PDOException $e) {
    $mensaje = date("Y-m-d H:i:s") . "- Error de conexion: " . $e->getMessage() . PHP_EOL;
    if (!file_exists(__DIR__ . "/logs")) {
        mkdir(__DIR__ . "/logs", 0755, true);
    }
    error_log($mensaje, 3, __DIR__ . '/logs/errores.log');
    die('error de conexión');
}
