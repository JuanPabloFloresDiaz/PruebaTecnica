<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/usuarios_handler.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla usuarioes.
 */
class UsuariosData extends UsuariosHandler
{
    // Atributo genérico para manejo de errores.
    private $data_error = null;
    // Atributo para almacenar el nombre del archivo de imagen.
    private $filename = null;

    /*
     *  Métodos para validar y asignar valores de los atributos.
     */
    // Validación y asignación del ID del usuario.
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del usuario es incorrecto';
            return false;
        }
    }

    // Validación y asignación del nombre del usuario.
    public function setNombre($value, $min = 2, $max = 100)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El nombre debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Validación y asignación del correo del usuario.
    public function setCorreo($value, $min = 8, $max = 100)
    {
        if (!Validator::validateEmail($value)) {
            $this->data_error = 'El correo electronico no es válido';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->correo = $value;
            return true;
        } else {
            $this->data_error = 'El correo debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Validación y asignación de laW clave del usuario.
    public function setClave($value, $name, $birthday, $phone, $email)
    {
        if (Validator::validatePassword($value, $name, $birthday, $phone, $email)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            $this->data_error = Validator::getPasswordError();
            return false;
        }
    }

    // Validación y asignación del teléfono del usuario.
    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            $this->data_error = 'El teléfono debe tener el formato (2, 6, 7)###-####';
            return false;
        }
    }
    // Validación y asignación del DUI del usuario.
    public function setDUI($value)
    {
        // Validar si el DUI tiene el formato correcto.
        if (!Validator::validateDUI($value)) {
            $this->data_error = 'El DUI debe tener el formato ########-#';
            return false;
        } else {
            $this->dui = $value;
            return true;
        }
    }


    // Validación y asignación de la fecha de nacimiento del usuario.
    public function setNacimiento($value, $min = 18, $max = 122)
    {
        if (Validator::validateDateBirthday($value, $min, $max)) {
            $this->nacimiento = $value;
            return true;
        } else {
            $this->data_error = 'La fecha de nacimiento no es valida, debe ser mayor a ' . $min . ' y menor a ' . $max . ' años';
            return false;
        }
    }

    // Validación y asignación de la dirección del usuario.
    public function setDireccion($value, $min = 2, $max = 200)
    {
        if (!Validator::validateTextOrtograpic($value)) {
            $this->data_error = 'La dirección contiene caracteres prohibidos';
            return false;
        } elseif(Validator::validateLength($value, $min, $max)) {
            $this->direccion = $value;
            return true;
        } else {
            $this->data_error = 'La dirección debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Validación y asignación del estado del usuario.
    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            $this->data_error = 'El estado debe ser 1 o 0';
            return false;
        }
    }


    // Método para obtener el error de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }

    // Método para obtener el nombre del archivo de imagen.
    public function getFilename()
    {
        return $this->filename;
    }

}
