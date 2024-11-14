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

Crea una base de datos llamada db_prueba_tecnica y asegúrate de que la configuración de la base de datos en el archivo config.php sea la correcta, asegurate de tener las credenciales del archivo .env, en caso no tener estas, puede solicitarlas, o usar las credenciales predeterminadas para la configuración local, (SERVER=localhost, DATABASE=db_prueba_tecnica, USERNAME=root, PASSWORD=).

3. **Configuración de la base de datos**
Se debe importar el esquema de la base de datos desde el archivo SQL correspondiente.
https://github.com/JuanPabloFloresDiaz/BDPruebaTecnica.git

### Uso de la API
La API es accesible a través de las siguientes rutas:
http://localhost/PruebaTecnica/api/services/usuarios/usuarios.php?action=[acción]
Donde [acción] es la acción que deseas ejecutar (por ejemplo, createRow, updateRow, readAll, etc.).

**Peticiones GET vs POST**
***GET***: No se requiere enviar datos en el cuerpo de la solicitud, solo debes enviar la acción a través del parámetro action.

***POST***: Se deben enviar los datos necesarios en el cuerpo de la solicitud, por ejemplo, utilizando Postman o cURL.

### Métodos disponibles
A continuación se describen los diferentes métodos disponibles en la API, junto con ejemplos de cómo hacer las peticiones:

**Buscar registros de usuario (searchRows)**
***Método:*** GET

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
            "NOMBRE": "julimox",
            "CORREO": "julimox@gmail.com",
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

** **
** **
** **
** **
** **
** **
** **
** **