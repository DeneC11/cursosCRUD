<?php
session_start();
/**
 * genera y almacena un token CSRF en la sesion de usuario
 * @param none
 * @return string el toquen CSRF generado (64 caracteres hexadecimales) y si ya existe lo mantiene
 */
function generarToneknCSRF(){
    if(empty($_SESSION['csrfToken'])){
        $_SESSION['csrfToken']=bin2hex(random_bytes(32));
    }
    return $_SESSION['csrfToken'];
}
// genero token CSRF para usar en formularios
$csrfToken=generarToneknCSRF();
/**
 * valida el token CSRF enviado, comparandolo con el almacenado en la sesion(servidor)
 * utilizamos hash_equals para prevenir ataques timing
 * @param string $token, toquen CSRF recibido
 * @return bool true, si los tokens coinciden. false , en el caso contrario
 */
function validateCSRFToken($token){
    return isset($_SESSION['csrfToken']) && hash_equals($_SESSION['csrfToken'],$token);
}
/**
 * generar el registro de auditoria en la base de datos
 * @param $pdo, el pdo
 * @param string $action, la accion que de lo que haces en la auditoria CREATE,DELETE o UPDATE
 * @param string $tableName, el nombre de la tabla donde ira
 * @param string $datos, $datos=$stmt->fetch();
 * @return nothing, sube los datos introducidos al registro de auditoria de la DB
 */
function registroAuditoria($pdo,$action,$tableName,$datos){
    // devuelve el id de la ultima fila añadida
            $lastId=$pdo->lastInsertId();
            // auditoria
            $sql2="INSERT INTO auditoria (action,tableName,idRecord,data,ipAddress) VALUES (:action,:tableName,:id,:datos,:ip)";
            $log=$pdo->prepare($sql2);
            $log->execute([
                ':action'=>$action,
                ':tableName'=>$tableName,
                ':id'=>$lastId,
                ':datos'=>json_encode($datos,JSON_UNESCAPED_UNICODE),
                ':ip'=>$_SERVER['REMOTE_ADDR'],
            ]);
}
?>
<script>
/**
 * validacion de formulario unico de bootsrap
 * @param nothing, se aplica automaticamente a un formulario con una clase '.needs-validation'
 * @return nothing 
 */
function aplicarValidacionBootstrap() {
    'use strict';
    const form = document.querySelector('.needs-validation');
    if (!form) return;
    
    form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
}
</script>