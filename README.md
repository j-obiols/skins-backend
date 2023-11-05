## Skins Backend
Jump2Digital 2023 Backend Exercise 

Skins Backend es una API que permite a los usuarios comprar Skins, que se almacenarán en una base de datos.
Las skins disponibles y todos sus datos se leen desde un archivo JSON. 
Este archivo puede ir creciendo, pero para el buen funcionamento de la API es necesario que no se eliminen Skins.
También es imprescindible que todos los campos estén definidos, aunque en la API se han creado métodos de control para evitar 
inconsistencia de datos.
Solamente se almacenan las Skins compradas por los usuarios, con los datos de estado: pagada, activa, status de color, status de gadget, 
más los datos de identificación necesarios.

Para testear todas las rutas en Postman:

### http://127.0.0.1:8000/api

## Endpoints 

#### POST /register

> Abierto

> Permite registrar a un nuevo usuario.

> Campos a rellenar en body (form-data):

- email
- nickname (min:4)
- password (min:8)
- password_confirmation
  
> Devuelve un mensaje de confirmación.

#### POST /login 

> Abierto

> Permite acceder a la aplicación a un usuario registrado.

> Campos a rellenar en body (form-data):

- email
- password
  
> Devuelve al usuario registrado junto con su access token.

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
 
>  Devuelve un listado de todas las Skins efectivamente disponibles con todos sus datos.

####  POST /skins/buy

> Requiere autentificación.

> Permite a un usuario autentificado comprar una Skin.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Campos a rellenar en body (form-data):

-code : code de una de las Skins disponibles según listado, y que el usuario todavía no tenga.

> Devuelve un mensaje de confirmación.

####  GET /skins/myskins 

> Requiere autentificación.

> Permite obtener el listado de Skins del usuario autentificado.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Devuelve un listado de todas las Skins que ha adquirido un usuario, incluyendo todos sus datos, incluso los que no se guardan en la base de datos.

####  DEL /skins/delete/{id} 

> Requiere autentificación.

> Permite a un usuario autentificado borrar una de sus Skins.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Devuelve un mensaje de confirmación.

####  GET /skin/getskin/{id} 

> Requiere autentificación.

> Permite a un usuario autentificado consultar una de sus Skins.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Devuelve la Skin consultada con todos sus datos, incluso los que no se guardan en la base de datos.

####  POST /skins/color (en rutas está definido PUT como establecía el enunciado)

> Requiere autentificación.

> Permite a un usuario autentificado cambiar el color de uno de sus Skins.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Campos a rellenar en body (form-data):

- code : code de la Skin de la que se desa cambiar el color.
- color : nuevo color según colores disponibles de esta Skin.
- _method: put
  
> Devuelve la Skin actualizada y con todos sus datos, incluso los que no se guardan en la base de datos.

####  POST /skins/gadget 

> Requiere autentificación.

> Permite a un usuario cambiar el estado de su gadget (visto/no visto).

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Campos a rellenar en body (form-data):

- code : code de la Skin de la que se desa cambiar el estado del gadget.
 
> Devuelve la Skin actualizada y con todos sus datos, incluso los que no se guardan en la base de datos.

### Instalación del proyecto 

Descargar el repositorio.

Abrir en Visual Studio Code.

En terminal VSC:

php... 

php artisan passport:install

php artisan serve

(*) Nota:

Si se desea testear el método que envia un email de pago al usuario al realizar la compra:

- descomentar código.
- abrir cuenta propia en Mailtrap.
- Configurar archivo .env con datos cuenta propia.
- Ejecutar endpoint buy y confirmar que se ha enviado el mail en Mailtrap.

