<?php
// Cargar las variables de entorno desde el archivo .env
function cargarVariablesEnv($archivo) {
    if (!file_exists($archivo)) {
        die("El archivo .env no existe ". $archivo);
    }

    $variables = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($variables as $variable) {
        // Se ignoran los comentarios (líneas que comienzan con #)
        if (strpos(trim($variable), '#') === 0) {
            continue;
        }

        // Dividir la línea en clave y valor
        list($clave, $valor) = explode('=', $variable, 2);
        $clave = trim($clave);
        $valor = trim($valor);

        // Establecer las variables de entorno
        if (!empty($clave)) {
            putenv("$clave=$valor");
        }
    }
}

// Cargar las variables desde el archivo .env
cargarVariablesEnv(__DIR__ . '/.env');

// Encabezado para permitir solicitudes de cualquier origen.
header('Access-Control-Allow-Origin: *');
// Se establece la zona horaria local para la fecha y hora del servidor.
date_default_timezone_set('America/El_Salvador');

// Definir las constantes usando las variables de entorno cargadas
define('SERVER', getenv('DB_SERVER'));
define('DATABASE', getenv('DB_DATABASE'));
define('USERNAME', getenv('DB_USERNAME')); 
define('PASSWORD', getenv('DB_PASSWORD')); 
?>
