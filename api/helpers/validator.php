<?php
/*
 *	Clase para validar todos los datos de entrada del lado del servidor.
 */
class Validator
{
    /*
     *   Atributos para manejar algunas validaciones.
     */
    private static $filename = null;
    private static $search_value = null;
    private static $password_error = null;
    private static $file_error = null;
    private static $search_error = null;

    // Método para obtener el error al validar una contraseña.
    public static function getPasswordError()
    {
        return self::$password_error;
    }

    // Método para obtener el nombre del archivo validado.
    public static function getFilename()
    {
        return self::$filename;
    }

    // Método para obtener el error al validar un archivo.
    public static function getFileError()
    {
        return self::$file_error;
    }

    // Método para obtener el valor de búsqueda.
    public static function getSearchValue()
    {
        return self::$search_value;
    }

    // Método para obtener el error al validar una búsqueda.
    public static function getSearchError()
    {
        return self::$search_error;
    }

    /*
     *   Método para sanear todos los campos de un formulario (quitar los espacios en blanco al principio y al final).
     *   Parámetros: $fields (arreglo con los campos del formulario).
     *   Retorno: arreglo con los campos saneados del formulario.
     */
    public static function validateForm($fields)
    {
        foreach ($fields as $index => $value) {
            $value = trim($value);
            $fields[$index] = $value;
        }
        return $fields;
    }
    /*
     *   Método para validar un número natural, como una llave primaria o llave foránea.
     *   El número debe ser un entero mayor o igual a 1.
     *   Parámetros:
     *       $value (int): el número a validar.
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateNaturalNumber($value)
    {
        // Se verifica que el valor sea un número entero mayor o igual a uno.
        if (filter_var($value, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)))) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un número positivo.
     *   El número debe ser un valor mayor o igual a 0.
     *   Parámetros:
     *       $value (int/float): el número a validar.
     *   Retorno: booleano (true si el valor es positivo o false en caso contrario).
     */
    public static function validatePositiveNumber($value)
    {
        // Se verifica que el valor sea un número mayor o igual a 0.
        if ($value >= 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un número positivo dentro de un rango específico.
     *   El número debe ser mayor a 0 y menor a 100.
     *   Parámetros:
     *       $value (int/float): el número a validar.
     *   Retorno: booleano (true si el valor es mayor a 0 y menor a 100, false en caso contrario).
     */
    public static function validatePositiveNumber2($value)
    {
        // Se verifica que el valor sea un número mayor a 0 y menor a 100.
        if ($value > 0 && $value < 100) {
            return true;
        } else {
            return false;
        }
    }

    /*
         *   Método para validar un archivo de imagen.
         *   Parámetros: $file (archivo de un formulario) y $dimension (medida mínima para la imagen).
         *   Retorno: booleano (true si el archivo es correcto o false en caso contrario).
         */
    public static function validateImageFile($file, $dimension)
    {
        if (is_uploaded_file($file['tmp_name'])) {
            // Se obtienen los datos de la imagen.
            $image = getimagesize($file['tmp_name']);
            // Se comprueba si el archivo tiene un tamaño mayor a 2MB.
            if ($file['size'] > 2097152) {
                self::$file_error = 'El tamaño de la imagen debe ser menor a 2MB';
                return false;
            } elseif ($image['mime'] == 'image/jpeg' || $image['mime'] == 'image/png') {
                // Se obtiene la extensión del archivo (.jpg o .png) y se convierte a minúsculas.
                $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                // Se establece un nombre único para el archivo.
                self::$filename = uniqid() . '.' . $extension;
                return true;
            } else {
                self::$file_error = 'El tipo de imagen debe ser jpg o png';
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un correo electrónico.
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un dato booleano.
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateBoolean($value)
    {
        if ($value == 1 || $value == 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar una cadena de texto (letras, digitos, espacios en blanco y signos de puntuación).
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateString($value)
    {
        // Se verifica el contenido y la longitud de acuerdo con la base de datos.
        if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\,\;\.]+$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar si un array contiene exactamente 6 elementos numéricos.
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el array es válido o false en caso contrario).
     */
    public static function validateNumberArray($value)
    {
        // Verifica si el valor es un array y tiene exactamente 6 elementos.
        if (is_array($value) && count($value) === 6) {
            // Recorre el array para verificar que cada elemento sea un número.
            foreach ($value as $item) {
                if (!is_numeric($item)) {
                    return false; // Si algún elemento no es numérico, retorna false.
                }
            }
            return true; // Si todos los elementos son numéricos y hay 6, retorna true.
        } else {
            return false; // Si no es un array o no tiene exactamente 6 elementos, retorna false.
        }
    }

    /*
    *   Método para validar una cadena de texto (letras, dígitos, espacios en blanco, signos de puntuación y guiones).
    *   Parámetros: $value (dato a validar).
    *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
    */
    public static function validateStringText($value)
    {
        // Se verifica el contenido y la longitud de acuerdo con la base de datos.
        if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\,\;\.\-\+]+$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /* 
 *   Método para validar una cadena de texto (letras, dígitos, espacios en blanco, signos de puntuación y guiones).
 *   Parámetros: $value (dato a validar).
 *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
 */
    public static function validateTextOrtograpic($value)
    {
        if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\,\;\.\-\+\/\¿\?\)\!]*$/', $value)) {
            return true;
        } else {
            return false;
        }
    }


    /*
     *   Método para validar un dato alfabético (letras y espacios en blanco).
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateAlphabetic($value)
    {
        // Se verifica el contenido y la longitud de acuerdo con la base de datos.
        if (preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]+$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un dato alfanumérico (letras, dígitos y espacios en blanco).
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateAlphanumeric($value)
    {
        // Se verifica el contenido y la longitud de acuerdo con la base de datos.
        if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s]+$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar la longitud de una cadena de texto.
     *   Parámetros: $value (dato a validar), $min (longitud mínima) y $max (longitud máxima).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateLength($value, $min, $max)
    {
        // Se verifica la longitud de la cadena de texto.
        if (strlen($value) >= $min && strlen($value) <= $max) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un dato monetario.
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateMoney($value)
    {
        // Se verifica que el número tenga una parte entera y como máximo dos cifras decimales.
        if (preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar una contraseña.
     *   La contraseña debe cumplir con los siguientes criterios:
     *   - Tener una longitud mínima de 8 caracteres y máxima de 72 caracteres.
     *   - No contener espacios en blanco.
     *   - Incluir al menos un carácter especial, un dígito, una letra minúscula y una letra mayúscula.
     *   - No contener subcadenas de 3 caracteres o más de información sensible del usuario (nombre, apellido, fecha de nacimiento, teléfono, correo electrónico).
     *   Parámetros:
     *       $value (string): la contraseña a validar.
     *       $name (string): nombre del usuario.
     *       $birthday (string): fecha de nacimiento del usuario.
     *       $phone (string): número de teléfono del usuario.
     *       $email (string): correo electrónico del usuario.
     *   Retorno: booleano (true si la contraseña es válida o false en caso contrario, con un mensaje de error específico en self::$password_error).
     */
    public static function validatePassword($value, $name, $birthday, $phone, $email)
    {
        // Se verifica la longitud mínima.
        if (strlen($value) < 8) {
            self::$password_error = 'Clave menor a 8 caracteres';
            return false;
        } elseif (strlen($value) > 72) {
            self::$password_error = 'Clave mayor a 72 caracteres';
            return false;
        } elseif (preg_match('/\s/', $value)) {
            self::$password_error = 'Clave contiene espacios en blanco';
            return false;
        } elseif (!preg_match('/\W/', $value)) {
            self::$password_error = 'Clave debe contener al menos un carácter especial';
            return false;
        } elseif (!preg_match('/\d/', $value)) {
            self::$password_error = 'Clave debe contener al menos un dígito';
            return false;
        } elseif (!preg_match('/[a-z]/', $value)) {
            self::$password_error = 'Clave debe contener al menos una letra en minúsculas';
            return false;
        } elseif (!preg_match('/[A-Z]/', $value)) {
            self::$password_error = 'Clave debe contener al menos una letra en mayúsculas';
            return false;
        }

        // Verificación de subcadenas de datos personales en la contraseña.
        $sensitiveData = [
            'nombre' => $name,
            'fecha de nacimiento' => $birthday,
            'teléfono' => $phone,
            'email' => $email
        ];

        $valueLower = strtolower($value); // Convertir la contraseña a minúsculas para evitar problemas con mayúsculas/minúsculas

        foreach ($sensitiveData as $dataLabel => $data) {
            if ($data) {
                $dataLower = strtolower($data); // Convertir también el dato personal a minúsculas
                // Verificar si alguna subcadena de 3 caracteres o más del dato personal está en la contraseña.
                for ($i = 0; $i <= strlen($dataLower) - 3; $i++) {
                    $substring = substr($dataLower, $i, 3); // Extraer una subcadena de 3 caracteres
                    if (strpos($valueLower, $substring) !== false) {
                        self::$password_error = "Clave contiene parte del $dataLabel del usuario: '$substring'";
                        return false;
                    }
                }
            }
        }

        return true; // La contraseña es válida si pasa todas las verificaciones.
    }


    /*
     *   Método para validar el formato del DUI (Documento Único de Identidad).
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateDUI($value)
    {
        // Se verifica que el número tenga el formato 00000000-0.
        if (preg_match('/^[0-9]{8}[-][0-9]{1}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un número telefónico.
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validatePhone($value)
    {
        // Se verifica que el número tenga el formato 0000-0000 y que inicie con 2, 6 o 7.
        if (preg_match('/^[2,6,7]{1}[0-9]{3}[-][0-9]{4}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar una fecha.
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateDate($value)
    {
        // Se dividen las partes de la fecha y se guardan en un arreglo con el siguiene orden: año, mes y día.
        $date = explode('-', $value);
        if (checkdate($date[1], $date[2], $date[0])) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un valor de búsqueda.
     *   El valor de búsqueda debe cumplir con los siguientes criterios:
     *   - No estar vacío.
     *   - No contener más de 3 palabras.
     *   - Contener únicamente caracteres válidos según la función `validateString`.
     *   Parámetros:
     *       $value (string): el valor a validar.
     *   Retorno: booleano (true si el valor es válido o false en caso contrario, con un mensaje de error específico en self::$search_error).
     */
    public static function validateSearch($value)
    {
        if (trim($value) == '') {
            self::$search_error = 'Ingrese un valor para buscar'; // Error si el valor está vacío.
            return false;
        } elseif (str_word_count($value) > 3) {
            self::$search_error = 'La búsqueda contiene más de 3 palabras'; // Error si hay más de 3 palabras.
            return false;
        } elseif (self::validateString($value)) {
            self::$search_value = $value; // Asigna el valor de búsqueda si es válido.
            return true;
        } else {
            self::$search_error = 'La búsqueda contiene caracteres prohibidos'; // Error si contiene caracteres no permitidos.
            return false;
        }
    }

    /*
     *   Método para validar un valor de búsqueda.
     *   El valor de búsqueda debe cumplir con los siguientes criterios:
     *   - No estar vacío.
     *   - No contener más de 3 palabras.
     *   - Contener únicamente caracteres válidos según la función `validateStringText`.
     *   Parámetros:
     *       $value (string): el valor a validar.
     *   Retorno: booleano (true si el valor es válido o false en caso contrario, con un mensaje de error específico en self::$search_error).
     */
    public static function validateSearch2($value)
    {
        if (trim($value) == '') {
            self::$search_error = 'Ingrese un valor para buscar'; // Error si el valor está vacío.
            return false;
        } elseif (str_word_count($value) > 3) {
            self::$search_error = 'La búsqueda contiene más de 3 palabras'; // Error si hay más de 3 palabras.
            return false;
        } elseif (self::validateStringText($value)) {
            self::$search_value = $value; // Asigna el valor de búsqueda si es válido.
            return true;
        } else {
            self::$search_error = 'La búsqueda contiene caracteres prohibidos'; // Error si contiene caracteres no permitidos.
            return false;
        }
    }


    /*
     *   Método para validar un archivo al momento de subirlo al servidor.
     *   Parámetros: $file (archivo), $path (ruta del archivo) y $name (nombre del archivo).
     *   Retorno: booleano (true si el archivo fue subido al servidor o false en caso contrario).
     */
    public static function saveFile($file, $path)
    {
        if (!$file) {
            return false;
        } elseif (move_uploaded_file($file['tmp_name'], $path . self::$filename)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar el cambio de un archivo en el servidor.
     *   Parámetros: $file (archivo), $path (ruta del archivo) y $old_filename (nombre del archivo anterior).
     *   Retorno: booleano (true si el archivo fue subido al servidor o false en caso contrario).
     */
    public static function changeFile($file, $path, $old_filename)
    {
        if (!self::saveFile($file, $path)) {
            return false;
        } elseif (self::deleteFile($path, $old_filename)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para validar un archivo al momento de borrarlo del servidor.
     *   Parámetros: $path (ruta del archivo) y $filename (nombre del archivo).
     *   Retorno: booleano (true si el archivo fue borrado del servidor o false en caso contrario).
     */
    public static function deleteFile($path, $filename)
    {
        if ($filename == 'default.png') {
            return true;
        } elseif (@unlink($path . $filename)) {
            return true;
        } else {
            return false;
        }
    }    
    
    /*
    *   Método para validar el tiempo de inactividad de una sesión.
    *   La función verifica si el tiempo de inactividad de la sesión ha superado un límite especificado.
    *   Si el tiempo de inactividad es mayor al permitido, la sesión se destruye y el script finaliza.
    *   En caso contrario, se actualiza el tiempo de la sesión.
    *   Parámetros: ninguno.
    *   Retorno: booleano (true si la sesión sigue activa, no retorna nada si la sesión ha expirado y se destruye).
    */
   public static function validateSessionTime()
   {
       // Tiempo en segundos para dar vida a la sesión.
       $inactivo = 300; // Tiempo en segundos.

       // Calculamos el tiempo de inactividad de la sesión.
       $vida_session = time() - $_SESSION['tiempo'];

       // Comparación para verificar si la vida de la sesión supera el tiempo máximo de inactividad permitido.
       if ($vida_session > $inactivo) {
           session_destroy(); // Destruye la sesión si ha expirado.
           exit(); // Finaliza el script.
       } else { // Si la sesión no ha caducado, se actualiza el tiempo de la sesión.
           $_SESSION['tiempo'] = time(); // Actualiza el tiempo de la última actividad.
           return true; // Retorna true indicando que la sesión sigue activa.
       }
   }


    /*
     *   Método para validar un formato de hora (HH:MM).
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateTime($value)
    {
        // Expresión regular para verificar el formato de hora HH:MM[:SS], donde los segundos son opcionales
        if (preg_match('/^(2[0-3]|[01][0-9]):([0-5][0-9])(?::([0-5][0-9]))?$/', $value, $matches)) {
            $hour = $matches[1];
            $minute = $matches[2];
            $second = isset($matches[3]) ? $matches[3] : '00'; // Si los segundos no están presentes, se asigna '00'

            // Retorna la hora en formato HH:MM:SS
            return "$hour:$minute:$second";
        }

        // Si no cumple con el formato, retorna false
        return false;
    }


    /*
     *   Método para validar una fecha (mayor a 18 años).
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validateDateBirthday($value)
    {
        // Se dividen las partes de la fecha y se guardan en un arreglo en el siguiene orden: año, mes y día.
        $datev = strtotime($value);
        $datem = strtotime('-18 years', time());
        $datea = strtotime('-122 years', time());
        if ($datev > $datem) {
            return false;
        } elseif ($datev < $datea) {
            return false;
        } else {
            $date = explode('-', $value);
            if (checkdate($date[1], $date[2], $date[0])) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     *   Método para validar un número decimal positivo.
     *   Parámetros: $value (dato a validar).
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario).
     */
    public static function validatePositiveDecimal($value)
    {
        // Se verifica que el valor sea un número decimal positivo.
        if (filter_var($value, FILTER_VALIDATE_FLOAT) && $value > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function validatePlayerDateBirthday($value)
    {
        // Se dividen las partes de la fecha y se guardan en un arreglo en el siguiene orden: año, mes y día.
        $datev = strtotime($value);
        $datem = strtotime('-4 years', time());
        $datea = strtotime('-30 years', time());
        if ($datev > $datem) {
            return false;
        } elseif ($datev < $datea) {
            return false;
        } else {
            $date = explode('-', $value);
            if (checkdate($date[1], $date[2], $date[0])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function validatePositiveDecimal2($value)
    {
        // Se verifica que el valor sea un número decimal positivo.
        if (filter_var($value, FILTER_VALIDATE_FLOAT) && $value > 0 && $value < 11) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *   Método para un dato de tipo DATETIME
     *   Prametros: $value (dato a validar)
     *   Retorno: booleano (true si el valor es correcto o false en caso contrario)
     *   Este método valida el formato de la fecha y la hora en formato ISO 8601
     */
    public static function validateDateTime($value)
    {
        // Verifica que el formato sea correcto usando expresiones regulares: YYYY-MM-DDTHH:MM[:SS]
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})T(2[0-3]|[01][0-9]):([0-5][0-9])(?::([0-5][0-9]))?$/', $value, $matches)) {
            // Extrae las partes de la fecha y la hora
            $year = $matches[1];
            $month = $matches[2];
            $day = $matches[3];
            $hour = isset($matches[4]) ? $matches[4] : '01';
            $minute = isset($matches[5]) ? $matches[5] : '00';
            // Si los segundos no están presentes, se asigna '00'
            $second = isset($matches[6]) ? $matches[6] : '00';

            // Verifica la validez de la fecha
            if (checkdate($month, $day, $year)) {
                // Retorna la fecha en el formato que MySQL acepta: YYYY-MM-DD HH:MM:SS
                return "$year-$month-$day $hour:$minute:$second";
            }
        }
        return false;
    }
}
