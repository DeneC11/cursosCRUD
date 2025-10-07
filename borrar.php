<?php
require 'conexion.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!validateCSRFToken($_POST['csrfToken'])??''){
        exit("Error de seguridad: token CSRF no valido");
    }
    $id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
    if($id){
        // obtener los datos del usuario antes de borrarlo
        $sql="SELECT * FROM cursos WHERE id=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        $deletedUser=$stmt->fetch(); //usuario borrado
        // Array(
        //     [id] => 7
        //     [nombre] => hola
        //     [apellidos] => caracola
        //     [telefono] => 77s77s777
        //     [email] => hosola@caracola.com
        //     [fechaCreacion] => 2025-09-22 11:17:34
        // )
        if($deletedUser){
            $sql="DELETE FROM cursos WHERE id=?";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$id]);
            // registro en tabla de auditoria del usuario borrado
            registroAuditoria($pdo,'DELETE','cursos',$deletedUser);
        }
    }
}
header("Location:index.php");
exit;
?>