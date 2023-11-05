## Skins Backend
Jump2Digital 2023 Backend Exercise 

Skins Backend es una API que permite a los usuarios comprar Skins, que se almacenarán en una base de datos.
Las skins disponibles y todos sus datos se leen desde un archivo JSON. 
Este archivo puede ir creciendo, pero para el buen funcionamento de la API es necesario que no se eliminen registros.
También es necesario que todos los campos estén definidos, aunque en la API se definen métodos de control para evitar 
inconsistencia de datos.
Solamente se almacenan las skins compradas por los usuarios, con los datos de estado: pagada, activa, status de color, status de gadget, 
más los datos de identificación necesarios.

Para testear todas las rutas en Postman:

### http://127.0.0.1:8000/api

## Endpoints 

#### POST /register
> Abierto

> Permite registrar a un usuario.

> Campos a rellenar en body (form-data):

- email
- nickname (min:3)
- password (min:8)
- password_confirmation
  
> Devuelve un mensaje de confirmación.

#### POST /login 

> Abierto

> Permite acceder a un usuario registrado.

> Campos a rellenar en body (form-data):

- email
- password
  
> Devuelve al usuario registrado juto con su access token.

#### POST /logout
> Requiere autentificación.

> Desactiva el token del usuario.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json
  
> Campos a rellenar en body (form-data):

- submit (sin value)
  
> Devuelve un mensaje de confirmación.

#### GET /skins/available

>  Ruta abierta a todo el público. 
 
>  Devuelve un listado de las skins disponibles con todos sus datos.

####  POST /skins/buy

> Requiere autentificación.

> Permite comprar una Skin.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Campos a rellenar en body (form-data):

-code : code de una skin disponible según listado

> Devuelve un mensaje de confirmación.

####  GET /skins/myskins 

> Requiere autentificación.

> Permite obtener el listado de skins del usuario autentificado

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Devuelve un listado de todas las skins que ha adquirido un usuario, incluyendo todos sus datos, incluso los que no se guardan en la base de datos.

####  DEL /skins/delete/{id} 

> Requiere autentificación.

####  GET /skin/getskin/{id} 

> Requiere autentificación.

####  POST /skins/color 

> Requiere autentificación.

####  POST /skins/gadget 

> Requiere autentificación.

### Instalación del proyecto 

Descargar el repositorio.

Abrir en Visual Studio Code.

En terminal VSC:

php... 

php artisan passport:install



