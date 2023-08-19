# Sistema de Gestión de Empleados

Este proyecto es una aplicación web que permite gestionar la información de empleados. Proporciona funcionalidades como la creación, edición, visualización y eliminación de empleados, así como la visualización de una lista de todos los empleados.
Se utilizan varias funcionalidades, desde cargas desde el servidor como peticiones por ajax. Se emplea Eloquent para los modelos, consultas y relaciones.

## Funcionalidades

- **Listado de Empleados**: Mostrar un listado de todos los empleados en una tabla, con detalles como nombre completo, apellido paterno, apellido materno, correo electrónico, puesto y compañía.

- **Creación de Empleados**: Proporciona un formulario para agregar nuevos empleados con campos como nombre completo, correo electrónico, puesto, compañía y fecha de ingreso.

- **Detalle de Empleado**: Al hacer clic en un empleado en la lista, se muestra una página con todos los detalles del empleado, incluyendo los campos mencionados anteriormente.

- **Edición de Empleados**: Permite editar la información de un empleado existente. Se pueden actualizar todos los campos de información.

- **Eliminación de Empleados**: Permite eliminar un empleado de la base de datos. La eliminación es lógica y se puede revertir.

## Requerimientos

- Laravel 10.x
- node
- MySQL
- Composer (para instalar las dependencias)

## Configuración

1. Clona este repositorio en tu máquina local.
2. Crea una base de datos en MySQL para la aplicación.
3. Copia el archivo `.env.example` y renómbralo a `.env`. Configura las variables de entorno para la conexión a la base de datos.
4. Ejecuta los siguientes comandos en la terminal:

```bash
# Instalar módulos de node
npm install --global yarn

# For Yarn
yarn

# For npm
npm install --legacy-peer-deps

# Instalar las dependencias de Composer
composer install

# Generar la clave de la aplicación
php artisan key:generate

# Ejecutar migraciones para crear las tablas
php artisan migrate

# Iniciar el servidor de desarrollo
php artisan serve
```

## Uso

Accede a la aplicación en tu navegador web en la URL proporcionada por el comando `php artisan serve`. Podrás utilizar las funcionalidades de creación, edición y eliminación de empleados.

## Estilo y Diseño

La interfaz de usuario ha sido diseñada de manera simple y amigable. Se han añadido estilos CSS básicos para mejorar la apariencia de la aplicación con base a una plantilla.
https://themeselection.com/license/

## Pruebas Unitarias

No se agregaron pruebas unitarias



---