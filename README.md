# API RESTful - PHP Slim 4 Framework
- Autor: `Alejandro Alberto Sánchez Iturriaga`
- Fecha de actualización: `03-09-2021`
- PHP versión: `7.4.10`
- Slim versión: `4.5`

___
### Requisitos para instalar la API
- Clonar proyecto con el nombre del repositorio por defecto. Si desea renombrarlo, debe cambiar la ruta base del archivo `App.php` ubicado en el directorio `src/App`, por el nuevo nombre.
- Crear una base de datos en Mysql con el nombre `crud`. Luego, debe importar el archivo `database.sql` ubicado en el directorio `resource`.
- Instalar los paquetes especificados en el fichero composer.json con:

	```text
	composer install
	```
	```text
	composer dump-autoload
	```

___
### Ejecución de la API
- Los endpoints disponibles en la API, estan definidos en el archivo `ENDPOINTS.md`.
- Para testear los endpoints directamente en Postman, debe importar el archivo `slim4-crud.postman_collection.json` ubicado en el directorio `resource`.

___
### Link de recursos
- (http://www.slimframework.com/)  Sitio oficial del framework Slim PHP.
- (https://php-di.org/)  Sitio oficial del contenedor de inyección de dependencia para humanos.
- (https://github.com/luispastendev/Slim4-Skeleton)  Esqueleto para el framework Slim 4.
- (https://github.com/Seldaek/monolog/)  Biblioteca para registrar errores, que cumple con el estándar PSR-3.