# Lista de Tareas y Subtareas para Mejorar la Arquitectura SOLID

A continuación, se detallan las tareas y subtareas necesarias para mejorar la arquitectura del proyecto, indicando los archivos que deben ser modificados o creados. Las descripciones explican el propósito y los pasos principales de cada tarea.

---

## 2. Crear interfaces para el acceso a datos (ISP y DIP)

### Descripción:
Definir interfaces para abstraer el acceso a datos, separando la lógica concreta del modelo. Esto facilita futuros cambios en la implementación (como cambiar la base de datos).

### Archivos afectados:
- Crear un archivo nuevo: **app/interfaces/IURLRepository.php**
- **app/models/URLModel.php**

### Subtareas:
2.1. Crear la interfaz `IURLRepository` con métodos como `saveURL` y `getAllURLs`.  
2.2. Actualizar `URLModel` para implementar la interfaz, manteniendo su funcionalidad actual.

---

## 3. Separar la lógica de validación en un servicio especializado

### Descripción:
Mover la lógica de validación de URLs a una clase dedicada, lo que mejora la cohesión y permite extender las reglas de validación fácilmente.

### Archivos afectados:
- Crear un archivo nuevo: **app/services/URLValidator.php**
- **app/controllers/URLController.php**

### Subtareas:
3.1. Crear la clase `URLValidator` que contenga métodos para validar URLs.  
3.2. Modificar `URLController` para inyectar la clase `URLValidator` y delegar la validación a este servicio.

---

## 4. Reforzar el modelo Vista-Controlador

### Descripción:
Implementar un front-controller o un sistema de enrutamiento para centralizar la gestión de solicitudes y la interacción entre vistas y controladores.

### Archivos afectados:
- Crear un archivo nuevo: **public/index.php**
- **app/views/index.php**

### Subtareas:
4.1. Crear un archivo `public/index.php` como punto de entrada único para las solicitudes.  
4.2. Modificar `index.php` para eliminar la lógica de instanciación directa y delegar en el front-controller.  
4.3. Configurar rutas básicas para mapear acciones específicas a controladores.

---

## 5. Mejorar la trazabilidad y el logging

### Descripción:
Reemplazar el sistema actual de trazas (`debug_helper.php`) por una herramienta de logging más robusta y configurable.

### Archivos afectados:
- **app/helpers/debug_helper.php**
- Crear un archivo nuevo: **app/config/logging.php**

### Subtareas:
5.1. Crear un archivo de configuración (`logging.php`) para gestionar los niveles de registro (error, warning, info, debug).  
5.2. Sustituir `debug_trace` por una librería estándar de logging, como Monolog.  
5.3. Configurar diferentes niveles de registro según el entorno (`producción`, `desarrollo`, etc.).

---

## 6. Asegurar la testabilidad

### Descripción:
Añadir pruebas unitarias para validar el correcto funcionamiento de los métodos principales del modelo y del controlador.

### Archivos afectados:
- Crear un directorio nuevo: **tests/**
- Crear archivos nuevos: **tests/URLModelTest.php**, **tests/URLControllerTest.php**

### Subtareas:
6.1. Configurar un framework de pruebas, como PHPUnit, para el proyecto.  
6.2. Crear pruebas unitarias para los métodos de `URLModel` y `URLController`.  
6.3. Implementar mocks o stubs para simular la base de datos durante las pruebas.

---

## 7. Evaluar la ampliación de funcionalidades

### Descripción:
Añadir operaciones CRUD completas (actualizar y eliminar) y funcionalidades como paginación para listas largas.

### Archivos afectados:
- **app/controllers/URLController.php**
- **app/models/URLModel.php**
- **app/views/index.php**
- **app/views/list.php**

### Subtareas:
7.1. Añadir métodos en `URLController` y `URLModel` para actualizar y eliminar URLs.  
7.2. Modificar `index.php` y `list.php` para incluir formularios o enlaces que permitan estas operaciones.  
7.3. Implementar un sistema de paginación para mejorar la experiencia del usuario al navegar por listas extensas.
