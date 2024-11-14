<?php
// Encabezado para permitir solicitudes de cualquier origen.
header('Access-Control-Allow-Origin: *');
// Se establece la zona horaria local para la fecha y hora del servidor.
date_default_timezone_set('America/El_Salvador');
// Constantes para establecer las credenciales de conexión con el servidor de bases de datos.
define('SERVER', 'localhost');
define('DATABASE', 'db_prueba_tecnica');
define('USERNAME', 'root'); //Por seguridad se debe crear un usuario para la base de datos y no usar root
define('PASSWORD', ''); // Asignar una clave para el usuario, en caso de no utilizar root
?>