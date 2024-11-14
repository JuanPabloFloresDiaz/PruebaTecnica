<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla usuario.
 */
class UsuariosHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $correo = null;
    protected $clave = null;
    protected $telefono = null;
    protected $dui = null;
    protected $nacimiento = null;
    protected $estado = null;
    protected $direccion = null;

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    //Función para buscar un usuario o varios.
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT * FROM vista_tabla_usuarios
        WHERE NOMBRE LIKE ? OR CORREO LIKE ? OR TELÉFONO LIKE ? OR DUI LIKE ?
        ORDER BY NOMBRE;';
        $params = array($value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

    //Función para insertar un usuario.
    public function createRow()
    {
        $sql = 'CALL insertar_usuario(?, ?, ?, ?, ?, ?, ?);';
        $params = array(
            $this->nombre,
            $this->correo,
            $this->clave,
            $this->telefono,
            $this->dui,
            $this->direccion,
            $this->nacimiento,
        );
        return Database::executeRow($sql, $params);
    }

    //Función para leer todos los usuario.
    public function readAll()
    {
        $sql = 'SELECT * FROM vista_tabla_usuarios
        ORDER BY NOMBRE;';
        return Database::getRows($sql);
    }

    //Función para leer un usuario.
    public function readOne()
    {
        $sql = 'SELECT * FROM vista_tabla_usuarios
        WHERE ID LIKE ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Función para actualizar un usuario.
    public function updateRow()
    {
        $sql = 'CALL actualizar_usuario(?,?,?,?,?,?,?,?);';
        $params = array(
            $this->id,
            $this->nombre,
            $this->correo,
            $this->telefono,
            $this->dui,
            $this->direccion,
            $this->nacimiento,
            $this->estado
        );
        return Database::executeRow($sql, $params);
    }

    //Función para eliminar un usuario.
    public function deleteRow()
    {
        $sql = 'CALL eliminar_usuario(?);';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Función para cambiar el estado de un usuario.
    public function changeState()
    {
        $sql = 'CALL actualizar_estado_usuario(?);';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
