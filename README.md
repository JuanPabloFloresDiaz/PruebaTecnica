# Prueba Técnica - API de Usuarios

Este repositorio alberga la prueba técnica solicitada para el puesto de **Desarrollador Backend Junior**.

## Instrucciones para el entorno

### Requisitos previos

1. **Servidor Web** (versión recomendada Apache 2.4.54)
2. **PHP** (versión recomendada 8.2 o superior)
3. **Base de datos MySQL o MariaDB** configurada correctamente.

### Instalación

1. **Clonar el repositorio:**

   git clone [<url_del_repositorio>](https://github.com/JuanPabloFloresDiaz/PruebaTecnica.git)
2. **Configurar la base de datos:**

Crea una base de datos llamada db_prueba_tecnica y asegúrate de que la configuración de la base de datos en el archivo config.php del proyecto sea la correcta, asegurate de tener las credenciales del archivo .env, en caso no tener estas, puede solicitarlas, o usar las credenciales predeterminadas para la configuración local, (SERVER=localhost, DATABASE=db_prueba_tecnica, USERNAME=root, PASSWORD=), puedes crear el archivo .env y poner las credenciales predeterminadas DB_SERVER=localhost DB_DATABASE=db_prueba_tecnica DB_USERNAME=root
 DB_PASSWORD=.

3. **Configuración de la base de datos**
Se debe importar el esquema de la base de datos desde el archivo SQL correspondiente.
[<url_del_repositorio>](https://github.com/JuanPabloFloresDiaz/BDPruebaTecnica.git)

### Uso de la API
La API es accesible a través de las siguientes rutas:
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=[acción]
Donde [acción] es la acción que deseas ejecutar (por ejemplo, createRow, updateRow, readAll, etc.).

**Peticiones GET vs POST**
***GET***: No se requiere enviar datos en el cuerpo de la solicitud, solo debes enviar la acción a través del parámetro action.

***POST***: Se deben enviar los datos necesarios en el cuerpo de la solicitud, por ejemplo, utilizando Postman o cURL.

### Métodos disponibles
A continuación se describen los diferentes métodos disponibles en la API, junto con ejemplos de cómo hacer las peticiones:

#### **Buscar registros de usuario (searchRows)**
***Método:*** POST

***Descripción:*** Permite buscar registros de usuarios basados en un término de búsqueda.

***Parámetros de entrada:***

search: Término de búsqueda (acepta nombre, correo, teléfono y dui).
***Ejemplo de URL:***
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=searchRows

***Respuesta:***

**Si hay resultados:**
{
    "status": 1,
    "message": "Existen 1 coincidencias",
    "dataset": [
        {
            "ID": "2",
            "NOMBRE": "ejemplo",
            "CORREO": "ejemplo@gmail.com",
            "TELÉFONO": "6012-6128",
            "DUI": "07011964-0",
            "DIRECCIÓN": "Soyapango",
            "NACIMIENTO": "2005-11-04",
            "REGISTRO": "2024-11-13 21:00:29",
            "ESTADO": "Activo",
            "VALOR_ESTADO": "1"
        }
    ],
    "error": null,
    "exception": null
}

**Si no hay resultados:**
{
    "status": 0,
    "message": null,
    "dataset": [],
    "error": "No hay coincidencias",
    "exception": null
}

#### **Crear un nuevo usuario (createRow)**
***Método:*** POST

***Descripción:*** Crea un nuevo registro de usuario.

***Parámetros de entrada:***

1. nombreUsuario: Nombre del usuario.
2. correoUsuario: Correo electrónico del usuario.
3. claveUsuario: Clave para el usuario.
4. telefonoUsuario: Teléfono del usuario.
5. duiUsuario: DUI del usuario.
6. nacimientoUsuario: Fecha de nacimiento del usuario.
7. direccionUsuario: Dirección del usuario.
8. confirmarClave: Confirmación de la clave.

***Ejemplo de URL:***
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=createRow

Respuesta:

**Si la creación es exitosa:**
{
    "status": 1,
    "message": "Usuario creado correctamente",
    "dataset": null,
    "error": null,
    "exception": null
}

**Si hay errores:**
{
    "status": 0,
    "message": null,
    "dataset": null,
    "error": "Ocurrió un problema al crear el Usuario",
    "exception": "El correo electrónico introducido ya existe"
}

#### **Actualizar datos de un usuario (updateRow)**
***Método:*** POST

***Descripción:*** Actualiza un registro de usuario existente.

***Parámetros de entrada:***

1. idUsuario: Identificador del usuario a actualizar.
2. nombreUsuario: Nombre del usuario.
3. correoUsuario: Correo electrónico del usuario.
4. telefonoUsuario: Teléfono del usuario.
5. duiUsuario: DUI del usuario.
6. nacimientoUsuario: Fecha de nacimiento del usuario.
7. direccionUsuario: Dirección del usuario.
8. estadoUsuario: Estado del usuario.

***Ejemplo de URL:***
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=updateRow


Respuesta:

**Si la modificación es correcta:**
{
    "status": 1,
    "message": "Usuario modificado correctamente",
    "dataset": null,
    "error": null,
    "exception": null
}

**Si hay errores:**
{
    "status": 0,
    "message": null,
    "dataset": null,
    "error": "Ocurrió un problema al modificar el Usuario",
    "exception": "El DUI introducido ya existe"
}


#### **Obtener todos los usuarios (readAll)**
***Método:*** GET

***Descripción:*** Obtiene todos los usuarios registrados.

***Parámetros de entrada:***
no se requiere enviar ningún parametro

***Ejemplo de URL:***
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=readAll

***Respuesta:***

**Si hay resultados:**
{
    "status": 1,
    "message": "Existen 3 registros",
    "dataset": [
        {
            "ID": "3",
            "NOMBRE": "ejemplo",
            "CORREO": "ejemplo@gmail.com",
            "TELÉFONO": "6012-6128",
            "DUI": "07011964-5",
            "DIRECCIÓN": "Soyapango",
            "NACIMIENTO": "2005-11-04",
            "REGISTRO": "2024-11-13 23:30:26",
            "ESTADO": "Activo",
            "VALOR_ESTADO": "1"
        },
        {
            "ID": "2",
            "NOMBRE": "julimox",
            "CORREO": "julimox@gmail.com",
            "TELÉFONO": "6012-6128",
            "DUI": "07011964-0",
            "DIRECCIÓN": "Soyapango",
            "NACIMIENTO": "2005-11-04",
            "REGISTRO": "2024-11-13 21:00:29",
            "ESTADO": "Activo",
            "VALOR_ESTADO": "1"
        },
        {
            "ID": "1",
            "NOMBRE": "jupadi",
            "CORREO": "pablojuanfd@gmail.com",
            "TELÉFONO": "6012-6129",
            "DUI": "07011964-1",
            "DIRECCIÓN": "Mejicanos",
            "NACIMIENTO": "2005-09-14",
            "REGISTRO": "2024-11-13 20:56:17",
            "ESTADO": null,
            "VALOR_ESTADO": null
        }
    ],
    "error": null,
    "exception": null
}

**Si no hay resultados:**
{
    "status": 0,
    "message": null,
    "dataset": false,
    "error": "No existen Usuarios registrados",
    "exception": null
}

#### **Obtener un usuario por ID (readOne)**
***Método:*** POST

***Descripción:*** Obtiene los detalles de un usuario específico por su ID.

***Parámetros de entrada:***

idUsuario: ID del usuario a consultar.

***Ejemplo de URL:***
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=readOne

***Respuesta:***

**Si hay resultados:**
{
    "status": 1,
    "message": null,
    "dataset": {
        "ID": "3",
        "NOMBRE": "ejemplo",
        "CORREO": "ejemplo@gmail.com",
        "TELÉFONO": "6012-6128",
        "DUI": "07011964-5",
        "DIRECCIÓN": "Soyapango",
        "NACIMIENTO": "2005-11-04",
        "REGISTRO": "2024-11-13 23:30:26",
        "ESTADO": "Activo",
        "VALOR_ESTADO": "1"
    },
    "error": null,
    "exception": null
}

**Si no hay resultados:**
{
    "status": 0,
    "message": null,
    "dataset": false,
    "error": "Usuario inexistente",
    "exception": null
}

#### **Eliminar un usuario (deleteRow)**
***Método:*** POST

***Descripción:*** Elimina un usuario específico.

***Parámetros de entrada:***

idUsuario: ID del usuario a eliminar.

***Ejemplo de URL:***
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=deleteRow

***Respuesta:***

**Si la eliminación es exitosa:**
{
    "status": 1,
    "message": "Usuario eliminado correctamente",
    "dataset": null,
    "error": null,
    "exception": null
}

**Si hay errores:**
{
    "status": 0,
    "message": null,
    "dataset": null,
    "error": "Ocurrió un problema al eliminar el usuario",
    "exception": "El usuario no existe"
}

#### **Cambiar estado de un usuario (changeState)**
***Método:*** POST

***Descripción:*** Cambia el estado (activo/inactivo) de un usuario.

***Parámetros de entrada:***

idUsuario: ID del usuario a modificar.

***Ejemplo de URL:***
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=changeState

***Respuesta:***

**Si el cambio de estado es exitoso:**
{
    "status": 1,
    "message": "Estado del usuario cambiado correctamente",
    "dataset": null,
    "error": null,
    "exception": null
}

**Si hay errores:**
{
    "status": 0,
    "message": null,
    "dataset": null,
    "error": "Ocurrió un problema al alterar el estado del Usuario",
    "exception": "El usuario no existe"
}