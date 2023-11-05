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
> Camos a rellenas en headers:
- Authorization : Bearer <aquí copiar token>
- Accept: application/json
> Campos a rellenar en body (form-data):
- submit (sin value)
> Devuelve mensaje de confirmación.

#### GET /skins/available

 Devuelve una lista de todas las skins disponibles.

 Ruta abierta a todo el público. 

####  POST /skins/buy

####  GET /skins/myskins

####  DEL /skins/delete/{id}

####  GET /skin/getskin/{id}

####  POST /skins/color

####  POST /skins/gadget

### Instalación del proyecto 

Descargar el repositorio.


