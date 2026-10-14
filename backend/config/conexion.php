<?php 

//Configurar la conexion de la BD con las credenciales
$host = '127.0.0.1';
$db = 'sistema_roles_dinamico';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

//Opciones de seguridad de PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Reporta errores como excepciones editables
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Retornar arreglos asociativos de columnas
    PDO::ATTR_EMULATE_PREPARES => false, //Desactivar emulacion para mitigar SQL Injection de raíz
];
//header('Content-Type: application/json');
try{
    $pdo = new PDO ($dsn, $user, $pass, $options);
    /*echo json_encode([
        "status" => "success",
        "message" => "¡Conexion establecida correctamente con la base de datos!"
    ]);*/
}catch(\PDOException $e ){
    //no mostrar $e->getMesseg() en produccion, expone credenciales
    header ('Content-Type: application/json');
    echo json_encode(["Status"=> "error","message" => "Error interno del servidor."]);
}