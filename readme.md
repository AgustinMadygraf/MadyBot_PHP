# Proyecto de Gestión de URLs

Este proyecto es una aplicación para gestionar URLs, permitiendo su almacenamiento y recuperación desde una base de datos.

## Características

- Almacenamiento de URLs en una base de datos MySQL.
- Validación de URLs.
- Recuperación de la última URL almacenada.
- Interfaz de usuario para registrar y listar URLs.
- Registro de mensajes de depuración.

## Requisitos

- PHP 7.2.5 o superior
- Composer
- MySQL

## Instalación

1. Clona el repositorio:
    ```sh
    git clone https://github.com/AgustinMadygraf/MadyBot_PHP.git
    cd tu-repositorio
    ```

2. Instala las dependencias con Composer:
    ```sh
    composer install
    ```

3. Crea el archivo 

.env.production

 en la raíz del proyecto con el siguiente contenido:
    ```env
    APP_ENV_PRODUCTION=true
    DB_HOST=localhost
    DB_USER=tu_usuario
    DB_PASSWORD=tu_contraseña
    DB_NAME=nombre_de_tu_base_de_datos
    ```

4. Crea el archivo 

.env.development

 en la raíz del proyecto con el siguiente contenido:
    ```env
    APP_ENV_PRODUCTION=false
    DB_HOST=localhost
    DB_USER=tu_usuario
    DB_PASSWORD=tu_contraseña
    DB_NAME=nombre_de_tu_base_de_datos
    ```

5. Configura tu servidor web para que el directorio 

public

 sea el directorio raíz del servidor.

## Uso

1. Accede a la aplicación a través de tu navegador web.
2. Utiliza el formulario para registrar nuevas URLs.
3. Visualiza las URLs almacenadas en la lista.

## Estructura del Proyecto

- 

app

: Contiene la lógica de la aplicación.
- 

public

: Contiene los archivos accesibles públicamente.
- 

vendor

: Contiene las dependencias instaladas por Composer.

## Contribuciones

Las contribuciones son bienvenidas. Por favor, abre un issue o un pull request para discutir cualquier cambio que desees realizar.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT.