<?php
// Se incluye la clase del modelo.
require_once('../../models/data/usuarios_data.php');

// Definición de constantes para los nombres de los campos de entrada.
const POST_ID = "idUsuario";
const POST_NOMBRE = "nombreUsuario";
const POST_CORREO = "correoUsuario";
const POST_CLAVE = "claveUsuario";
const POST_TELEFONO = "telefonoUsuario";
const POST_DUI = "duiUsuario";
const POST_NACIMIENTO = "nacimientoUsuario";
const POST_ESTADO = "estadoUsuario";
const POST_DIRECCION = "direccionUsuario";
const POST_CLAVE_CONFIRMAR = "confirmarClave";
const POST_BUSCAR = "search";

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se instancia la clase correspondiente.
    $usuario = new UsuariosData;

    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null);

    // Se compara la acción a realizar según la petición del controlador.
    switch ($_GET['action']) {
        // Buscar
        case 'searchRows':
            // Validación del valor de búsqueda mediante un validador.
            if (!Validator::validateSearch2($_POST[POST_BUSCAR])) {
                // Si la validación falla, se guarda el error en el resultado.
                $result['error'] = Validator::getSearchError();
            } elseif ($result['dataset'] = $usuario->searchRows()) {
                // Si se encuentran coincidencias, se almacenan los datos y el mensaje de éxito.
                $result['status'] = 1;
                $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
            } else {
                // Si no se encuentran resultados, se devuelve un mensaje de error.
                $result['error'] = 'No hay coincidencias';
            }
            break;

        // Agregar
        case 'createRow':
            // Se validan los datos del formulario de entrada.
            $_POST = Validator::validateForm($_POST);

            // Se comprueba que todos los campos estén correctamente establecidos.
            if (
                !$usuario->setNombre($_POST[POST_NOMBRE]) or
                !$usuario->setClave(
                    $_POST[POST_CLAVE],
                    $_POST[POST_NOMBRE],
                    $_POST[POST_NACIMIENTO],
                    $_POST[POST_TELEFONO],
                    $_POST[POST_CORREO]
                ) or
                !$usuario->setCorreo($_POST[POST_CORREO]) or
                !$usuario->setTelefono($_POST[POST_TELEFONO]) or
                !$usuario->setDUI($_POST[POST_DUI]) or
                !$usuario->setDireccion($_POST[POST_DIRECCION]) or
                !$usuario->setNacimiento($_POST[POST_NACIMIENTO])
            ) {
                // Si algún campo es inválido, se obtiene el mensaje de error y se devuelve.
                $result['error'] = $usuario->getDataError();
            } elseif ($_POST[POST_CLAVE] != $_POST[POST_CLAVE_CONFIRMAR]) {
                // Si las contraseñas no coinciden, se devuelve un mensaje de error.
                $result['error'] = 'Contraseñas diferentes';
            } elseif ($usuario->createRow()) {
                // Si la inserción es exitosa, se devuelve un mensaje de éxito.
                $result['status'] = 1;
                $result['message'] = 'Usuario creado correctamente';
            } else {
                // Si ocurre un problema durante la creación, se devuelve un error.
                $result['error'] = 'Ocurrió un problema al crear el Usuario';
            }
            break;

        // Actualizar
        case 'updateRow':
            // Se validan los datos del formulario de entrada.
            $_POST = Validator::validateForm($_POST);

            // Se comprueba que todos los campos estén correctamente establecidos.
            if (
                !$usuario->setId($_POST[POST_ID]) or
                !$usuario->setNombre($_POST[POST_NOMBRE]) or
                !$usuario->setCorreo($_POST[POST_CORREO]) or
                !$usuario->setTelefono($_POST[POST_TELEFONO]) or
                !$usuario->setDUI($_POST[POST_DUI]) or
                !$usuario->setDireccion($_POST[POST_DIRECCION]) or
                !$usuario->setNacimiento($_POST[POST_NACIMIENTO])
            ) {
                // Si algún campo es inválido, se obtiene el mensaje de error y se devuelve.
                $result['error'] = $usuario->getDataError();
            } elseif ($usuario->updateRow()) {
                // Si la actualización es exitosa, se devuelve un mensaje de éxito.
                $result['status'] = 1;
                $result['message'] = 'Usuario modificado correctamente';
            } else {
                // Si ocurre un problema durante la actualización, se devuelve un error.
                $result['error'] = 'Ocurrió un problema al modificar el Usuario';
            }
            break;

        // Ver todos
        case 'readAll':
            // Se obtienen todos los registros de usuarios.
            if ($result['dataset'] = $usuario->readAll()) {
                // Si se encuentran registros, se devuelve un mensaje de éxito con los datos.
                $result['status'] = 1;
                $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
            } else {
                // Si no hay registros, se devuelve un mensaje de error.
                $result['error'] = 'No existen Usuarioes registrados';
            }
            break;

        // Ver uno
        case 'readOne':
            // Se valida el ID del usuario.
            if (!$usuario->setId($_POST[POST_ID])) {
                $result['error'] = 'Usuario incorrecto';
            } elseif ($result['dataset'] = $usuario->readOne()) {
                // Si el usuario existe, se devuelve la información.
                $result['status'] = 1;
            } else {
                // Si el usuario no existe, se devuelve un error.
                $result['error'] = 'Usuario inexistente';
            }
            break;

        // Eliminar
        case 'deleteRow':
            // Se valida el ID del usuario a eliminar.
            if (
                !$usuario->setId($_POST[POST_ID])
            ) {
                // Si el ID es inválido, se devuelve un mensaje de error.
                $result['error'] = $usuario->getDataError();
            } elseif ($usuario->deleteRow()) {
                // Si la eliminación es exitosa, se devuelve un mensaje de éxito.
                $result['status'] = 1;
                $result['message'] = 'Usuario eliminado correctamente';
            } else {
                // Si ocurre un problema durante la eliminación, se devuelve un error.
                $result['error'] = 'Ocurrió un problema al eliminar el Usuario';
            }
            break;

        // Cambiar estado
        case 'changeState':
            // Se valida el ID del usuario.
            if (
                !$usuario->setId($_POST[POST_ID])
            ) {
                // Si el ID es inválido, se devuelve un mensaje de error.
                $result['error'] = $usuario->getDataError();
            } elseif ($usuario->changeState()) {
                // Si el cambio de estado es exitoso, se devuelve un mensaje de éxito.
                $result['status'] = 1;
                $result['message'] = 'Estado del usuario cambiado correctamente';
            } else {
                // Si ocurre un problema durante el cambio de estado, se devuelve un error.
                $result['error'] = 'Ocurrió un problema al alterar el estado del Usuario';
            }
            break;

        // Acción no disponible
        default:
            // Si la acción no es válida, se devuelve un mensaje de error.
            $result['error'] = 'Acción no disponible';
    }

    // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
    $result['exception'] = Database::getException();

    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('Content-type: application/json; charset=utf-8');

    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    // Si no se ha definido una acción, se devuelve un mensaje de error.
    print(json_encode('Recurso no disponible'));
}
