<?php
session_start();
// validamos estrictamente que solo el administrador puede registar usuarios
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador' ){
    http_response_code(403);
    echo json_encode(["status " => "error", "message" => "Operaciones no permitidas"]);
    exit;
}

header('Content-Type: applicacion/json');
require '../config/conexion.php';

$entrada = json_decode(file_get_contents('php://input'), true);

$userPost = $entrada['usuario'] ?? '';
$passPost = $entrada['password'] ?? '';
$rolIdPost = $entrada['rol_id'] ?? '';

//validacion en servidor (por si burlan JavaScript)
if (empty($userPost) || empty($passPost) || empty($rolIdPost)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit;
}

try {
    /**
     * 1. Validacion contra usuarios duplicados
     * como la columna "usuario" es unique, consultamos previamente para enviar un mensaje limpio.
     */

    $checkStmt = $pdo -> prepare("SELECT id FROM usuario WHERE usuario = ?");
    $checkStmt -> execute([$userPost]);
    if ($checkStmt -> fetch()) {
        echo json_encode(["status" => "error", "message" => "El nombre de usuario ya esta registrado"]);
        exit;
    }

    /**
     * 2. CREACION DE HASH DE CONTRASEÑA SEGURO (Bcrypt)
     * PASSWORD_BCRYPT genera un string seguro de 60 caracteres incorporando una sal unica
     */
    $passWordHash = password_hash($passPost, PASSWORD_BCRYPT);

    /**
     * 3. INSERCION DE LOS DATOS MENDIANTE SENTENCIA PREPARADA
     */
    $sql = "INSERT INTO usuario (usuario, password, rol_id) VALUES (?, ?, ?)";
    $insertStmt = $pdo -> prepare($sql);
    $insertStmt -> execute([$userPost, $passWordHash, $rolIdPost]);

    echo json_encode(["status" => "succes", "message" => "¡Usuario '{$userPost}' registrado con exito"]);

} catch (\PDOException $e) {
    // Si la llave foranea falla (un id de rol alterado) o un error de base de db ocurre
    echo json_encode(["status" => "succes", "message" => "Error interno al procesar el registro"]);
}