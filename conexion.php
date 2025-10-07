<?php
require 'funciones.php'; //crea sesion + genera/compara token CSRF
$host='localhost';
$db='examenufcrud';
$user='mydnavarroac';
$pass='u7Uh5S5Y';
$charset='utf8mb4';
$dsn="mysql:host=$host;dbname=$db;charset=$charset";
// dsn=data source name
$option=[
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, //hace que el gestor de base de datos nos devuelva siempre arrays asociativos
    PDO::ATTR_EMULATE_PREPARES=>false, //desactiva la emulacion de sentencias preparadas
];
try{
    $pdo=new PDO($dsn,$user,$pass,$option);
}catch(PDOException $e){
    $mensaje=date("Y-m-d H:i:s")."- Error de conexion: ".$e->getMessage().PHP_EOL;
    if(!file_exists(__DIR__."/logs")){
        mkdir(__DIR__."/logs",0755,true);
    }
    error_log($mensaje,3,__DIR__.'/logs/errores.log');
    die('error de conexión');
}
?>