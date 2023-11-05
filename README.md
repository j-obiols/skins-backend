## Skins Backend
Jump2Digital 2023 Backend Exercise 

**API** que permite a los usuarios **comprar Skins**, que se almacenarán en una base de datos. 

Las Skins disponibles y todos sus datos se leen desde un archivo JSON.  

Este archivo JSON puede ir creciendo, pero para el buen funcionamento de la API es imprescindible que no se eliminen Skins y que no se modifiquen sus códigos.

También es imprescindible que todos los campos estén definidos, aunque en la API se han creado métodos de control para evitar 
inconsistencia de datos. 

Solamente se almacenan las Skins compradas por los usuarios, con sus datos de estado: pagada, activa, status de color, status de gadget, 
más los datos de identificación necesarios.

Incluye tests de la mayoría de las funciones, aunque falta añadir tests de algunas casuísticas.

No incluye seeders.

Para testear todas las rutas en Postman:

### http://127.0.0.1:8000/api

## Endpoints 

### POST /register

> Abierto

> Permite registrar a un nuevo usuario.

> Campos a rellenar en body (form-data):

- email
- nickname (min:4)
- password (min:8)
- password_confirmation
  
> Devuelve un mensaje de confirmación.

### POST /login 

> Abierto

> Permite acceder a la aplicación a un usuario registrado.

> Campos a rellenar en body (form-data):

- email
- password
  
> Devuelve al usuario registrado junto con su access token.

### POST /logout

> Requiere autentificación.

> Desactiva el token del usuario.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json
  
> Campos a rellenar en body (form-data):

- submit (sin value)
  
> Devuelve un mensaje de confirmación.

### GET /skins/available

>  Ruta abierta a todo el público. 
 
>  Devuelve un listado de todas las Skins efectivamente disponibles con todos sus datos.

###  POST /skins/buy

> Requiere autentificación.

> Permite a un usuario autentificado comprar una Skin.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Campos a rellenar en body (form-data):

- code : _code de una de las Skins disponibles según listado, y que el usuario todavía no tenga._

> Devuelve un mensaje de confirmación.

###  GET /skins/myskins 

> Requiere autentificación.

> Permite obtener el listado de Skins del usuario autentificado.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Devuelve un listado de todas las Skins que ha adquirido un usuario, incluyendo todos sus datos, incluso los que no se guardan en la base de datos.

###  DEL /skins/delete/{id} 

> Requiere autentificación.

> Permite a un usuario autentificado borrar una de sus Skins.

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> La id debe ser la de una de las skins compradas por el usuario autentificado y guardadas en la base de datos.

> Devuelve un mensaje de confirmación.

###  GET /skin/getskin/{id} 

> Requiere autentificación.

> Permite a un usuario autentificado consultar una de sus Skins.

> Campos a rellenar en headers:

- Authorization : Bearer _aquí copiar token_
- Accept: application/json

> Devuelve la Skin consultada con todos sus datos, incluso los que no se guardan en la base de datos.

###  POST /skins/color (en rutas está definido PUT como establecía el enunciado)

> Requiere autentificación.

> Permite a un usuario autentificado cambiar el color de uno de sus Skins.

> Campos a rellenar en headers:

- Authorization : Bearer _aquí copiar token_
- Accept: application/json

> Campos a rellenar en body (form-data):

- code : _code de la Skin de la que se desa cambiar el color._
- color : _nuevo color según colores disponibles de esta Skin._
- _method: put
  
> Devuelve la Skin actualizada y con todos sus datos, incluso los que no se guardan en la base de datos.

###  POST /skins/gadget 

> Requiere autentificación.

> Permite a un usuario cambiar el estado de su gadget (visto/no visto).

> Campos a rellenar en headers:

- Authorization : Bearer <aquí copiar token>
- Accept: application/json

> Campos a rellenar en body (form-data):

- code : _code de la Skin de la que se desa cambiar el estado del gadget._
 
> Devuelve la Skin actualizada y con todos sus datos, incluso los que no se guardan en la base de datos.

## Acceso al proyecto

Descargar el repositorio.

En la terminal de Visual Studio Code terminal, escribir:

```composer install```

```cp .env.example .env``` 

Editar el .env file, añadiendo el nombre de la base de datos:

 ```DB_DATABASE = skins_backend ```

Crear una base de datos vacía en localhost con el mismo nombre.

```php artisan migrate``` 

```php artisan serve```

## Testeando desde Visual Studio Code

En la terminal, escribir:

```php artisan passport:install```

```php artisan test```

(después de testear, y antes de volver a testear, a veces es necesario: ```php artisan cache:clear```)

## Testeando desde Postman

Abrir la base de datos **skins_backend** en **phpMyAdmin** para poder ir haciendo consultas.
 
In terminal Visual Studio Code, run:

```php artisan migrate```

```php artisan passport:install```

```php artisan serve``` 

## Nota (*)

Si se desea testear el método que envia un **email con enlace de pago** cuando un usuario realizar una compra:

- descomentar el código correpondiente en el método **buy** de **SkinController** (está indicado).
- abrir cuenta propia en **Mailtrap**.
- configurar los campos relativos a Mail en el archivo **.env** con los datos  proporcionados por **Mailtrap**.
- ejecutar en Postman el endpoint **/skins/buy**, y confirmar en Mailtrap que se ha enviado el mail, donde se podrá también visualizar.

