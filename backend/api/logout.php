<?php 
//Detruccion de la session
session_start();
$_SESSION = array(); //limpiar las variables en memoria 
// Borrar la cookie fisica del navegador 
if (ini_get("session.user_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

session_destroy(); //Destruir la session en el servidor
header("Location: ../../frontend/views/index.html");

exit;
