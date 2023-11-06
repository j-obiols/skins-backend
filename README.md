## Skins Backend
Jump2Digital 2023 Backend Exercise 


**Skins Backend** es una **API** que permite a los usuarios **comprar Skins**, que se almacenarán en una base de datos. 

Las Skins disponibles y todos sus datos se leen desde un archivo **JSON**, que podrá ir ampliándose.
Para el buen funcionamento de la API es imprescindible que no se eliminen Skins, y que no se modifiquen sus códigos.

También es imprescindible que todos los campos de cada registro estén definidos. En la API se han creado algunos métodos de control para evitar 
inconsistencia de datos.

En la base de datos se almacenan los **Users** y las **Skins compradas por los User**, con una relación de **Uno a Muchos**.
Las Skins se almacenan solamente con sus datos de estado: pagada ('paid'), activa ('active'), status de color ('colostatus'), status de gadget ('gadgetstatus'), 
más los datos de identificación necesarios ('id', 'code', 'user_id'). Los otros datos de las Skins se leen directamente desde el archivo JSON, y no se almacenan por dos motivos:
a) si solamente hubiera la tabla de Skins compradas, en ésta aparecerían muchos campos repetidos, ya que una misma Skin puede ser comprada por muchos usuarios y por lo tanto aparecerá en muchos registros.
b) si se creara una tercera tabla Skins para almacenar las **Skins Disponibles** con sus datos, y la tabla **Skins compradas por los User** pasara a ser una tabla intermedia, habría que ir insertando las nuevas Skins o ir actualizando dicha tabla mediante lecturas del JSON. Parece más lógico y más seguro obtener los datos siempre actualizados directamente desde el archivo JSON. 

Cuando un User adquiriera una Skin, ésta quedaría registrada con los atributos 'paid' y 'active' en 'false', y la API enviaría automáticamente al User un **mail con un enlace de pago.**
La idea es que cuando el admin (todavía no definido en este punto del proyecto) recibiera la notificación de pago recibido, 
cambiara estos dos atributos mediante otro endpoint (tampoco definido), para que pasaran a 'true', y así la Skin quedara activada. Si en un plazo de X horas, no se recibiera el pago,
la Skin quedaría eliminada de la base de datos. La API sí que incluye tanto el método para enviar el mail como el propio mail, y se ha testeado el correcto funcionamiento del método en Mailtrap.   

Incluye **tests** de la mayoría de las funciones.

**No incluye seeders**.

Para testear todas las rutas en **Postman**:

### http://127.0.0.1:8000/api

## Endpoints 

### POST /register

> No requiere autentificación.

> Permite registrar a un nuevo usuario.

> Campos a rellenar en body (form-data):

- email
- nickname (min:4)
- password (min:8)
- password_confirmation
  
> Devuelve un mensaje de confirmación.

### POST /login 

> No requiere autentificación.

> Permite acceder a la aplicación a un usuario registrado.

> Campos a rellenar en body (form-data):

- email:  _email de un usuario registrado_
- password:  _password de dicho usuario_
  
> Devuelve al usuario registrado junto con su access token.

### POST /logout

> Requiere autentificación.

> Desactiva el token del usuario.

> Campos a rellenar en headers:

- Authorization : Bearer  _aquí copiar token_
- Accept: application/json
  
> Campos a rellenar en body (form-data):

- submit (sin value)
  
> Devuelve un mensaje de confirmación.

### GET /skins/available

> No requiere autentificación.
 
>  Devuelve un listado de todas las Skins efectivamente disponibles con todos sus datos.

###  POST /skins/buy

> Requiere autentificación.

> Permite a un usuario autentificado comprar una Skin.

> Campos a rellenar en headers:

- Authorization : Bearer  _aquí copiar token_
- Accept: application/json

> Campos a rellenar en body (form-data):

- code : _code de una de las Skins disponibles según listado, y que el usuario todavía no tenga._

> Devuelve un mensaje de confirmación.

###  GET /skins/myskins 

> Requiere autentificación.

> Permite obtener el listado de Skins del usuario autentificado.

> Campos a rellenar en headers:

- Authorization : Bearer  _aquí copiar token_
- Accept: application/json

> Devuelve un listado de todas las Skins que ha adquirido un usuario, incluyendo todos sus datos, incluso los que no se guardan en la base de datos.

###  DEL /skins/delete/{id} 

> Requiere autentificación.

> Permite a un usuario autentificado borrar una de sus Skins.

> Campos a rellenar en headers:

- Authorization : Bearer  _aquí copiar token_
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

- Authorization : Bearer  _aquí copiar token_
- Accept: application/json

> Campos a rellenar en body (form-data):

- code : _code de la Skin de la que se desa cambiar el estado del gadget._
 
> Devuelve la Skin actualizada y con todos sus datos, incluso los que no se guardan en la base de datos.

## Acceso al proyecto

Descargar el repositorio.

**MUY IMPORTANTE: Localizar el archivo skins.json y trasladarlo dentro de la carpeta public, ubicada dentro de storage/app.
Si no, no se podrá acceder a los datos de las Skins.**

En la terminal de Visual Studio Code terminal, escribir:

```composer install```

```cp .env.example .env``` 

Editar el .env file, añadiendo el nombre de la base de datos:

 ```DB_DATABASE = skins_backend ```

Crear una base de datos vacía en localhost con el mismo nombre.

Ejecutar:

```php artisan migrate``` 

```php artisan passport:install```

```php artisan serve```

## Testeando desde Visual Studio Code

En la terminal, escribir si es necesario:

```php artisan passport:install```

Para ejecutar todos los tests:

```php artisan test```

(después de testear, y antes de volver a testear, a veces es necesario: ```php artisan cache:clear```)

## Testeando desde Postman

Abrir la base de datos **skins_backend** en **phpMyAdmin** para poder ir haciendo consultas.
 
En la terminal de Visual Studio Code, escribir si es necesario:

```php artisan migrate```

```php artisan passport:install```

```php artisan serve``` 

Acceder a Postman y testear los endpoints.

## Nota (*)

Si se desea testear el método que envia un **email con enlace de pago** cuando un usuario realiza una compra, hay que:
- abrir cuenta propia en **Mailtrap**.
- configurar los campos relativos a Mail en el archivo **.env** con los datos  proporcionados por **Mailtrap**.
- descomentar el código correpondiente en el método **buy** de **SkinController** (está indicado).
- ejecutar en Postman el endpoint **/skins/buy**, y confirmar en Mailtrap que se ha enviado el mail, donde se podrá también visualizar.

