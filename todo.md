
## 1. Aplicar el principio de Inversión de Dependencias (DIP) con repositorio de URLs

- [ ] **Tarea 1.1: Crear la implementación de `IURLRepository`**  
  - [ ] Crear un archivo nuevo, por ejemplo:  
    `app/repositories/URLRepository.php`  
    que implemente la interfaz `IURLRepository`.  
  - [ ] Dentro de esta clase, inyectar la conexión a la base de datos (`PDO`) en el constructor, para que las operaciones de lectura/escritura en la tabla `urls` sean responsabilidad del repositorio.

- [ ] **Tarea 1.2: Mover la lógica de obtención de la “última URL” al repositorio**  
  - [ ] Pasar el método que obtiene la última URL (actualmente en `GetDataService`) a un método como `getLastURL()` en `URLRepository`.  
  - [ ] Dejar `GetDataService` libre de la lógica directa de la base de datos.

---

## 2. Modificar `GetDataService` para inyectar `IURLRepository`

- [ ] **Tarea 2.1: Eliminar la creación directa de `Database` en `GetDataService`**  
  - [ ] En el archivo `public/get_data.php`, quitar la línea:  
    ```php
    $database = new Database();
    $this->conn = $database->getConnection();
    ```  
  - [ ] En su lugar, inyectar en el constructor de `GetDataService` una instancia de `IURLRepository` (por ejemplo, `URLRepository`) cuando se inicialice en `get_data.php`.

- [ ] **Tarea 2.2: Ajustar la llamada a `getLastURL()`**  
  - [ ] Reemplazar la lógica de `$this->getLastUrl()` dentro de `GetDataService` para que ahora use `$this->urlRepository->getLastURL()` (o el nombre que hayas definido).  
  - [ ] El resto del proceso (validación y respuesta JSON) sigue igual, pero leyendo ya desde el repositorio.

---

## 3. Separar la lógica de respuesta HTTP (SRP)

- [ ] **Tarea 3.1: Crear un nuevo controlador o script para manejar la respuesta**  
  - [ ] Crear un archivo nuevo, por ejemplo:  
    `public/controllers/GetDataController.php`  
    (o el nombre que prefieras) que se encargue de:  
    1. Llamar a los métodos de `GetDataService` o similar.  
    2. Configurar los encabezados `header('Content-Type: application/json; ...)`.  
    3. Generar la respuesta HTTP final (JSON).

- [ ] **Tarea 3.2: Ajustar `get_data.php` para usar el nuevo controlador**  
  - [ ] En `get_data.php`, instancia únicamente el controlador (p. ej. `GetDataController`) y llama el método principal que genere la respuesta.  
  - [ ] Eliminar o reducir la lógica de respuesta dentro de `GetDataService`, para que esta clase se enfoque exclusivamente en “obtener y procesar” la información.

---

## 4. Sustituir la función global `debug_trace()` por la interfaz `DebugInterface`

- [ ] **Tarea 4.1: Decidir si se elimina o refactoriza `debug_helper.php`**  
  - [ ] Si se opta por eliminar:  
    - [ ] **Eliminar** el archivo `app/helpers/debug_helper.php` (o dejarlo vacío si deseas conservar el nombre).  
    - [ ] Asegurarse de remover su inclusión en todos los lugares donde se llama a `require_once __DIR__ . '/../app/helpers/debug_helper.php'`.  
  - [ ] Si se opta por refactorizar:  
    - [ ] Transformarlo en una clase que implemente `DebugInterface` (en lugar de una función global).

- [ ] **Tarea 4.2: Inyectar `DebugInterface` donde se necesite**  
  - [ ] Utilizar `DebugLogger` (o la clase concreta que implementa `DebugInterface`) en `Database`, `URLRepository` y en cualquier otro lugar que requiera logs de debug.  
  - [ ] Pasarlo vía constructor o método set, evitando funciones globales.  

- [ ] **Tarea 4.3: Decidir el modo de producción vs. desarrollo**  
  - [ ] En modo producción, se guarda el log en un archivo (ya contemplado en `DebugLogger`).  
  - [ ] En modo desarrollo, se imprime en pantalla (también contemplado).

---

## 5. Extraer la lógica de creación de tablas y base de datos de `Database` (OCP)

- [ ] **Tarea 5.1: Evaluar si se requiere un sistema de migraciones**  
  - [ ] Si es necesario escalar, crear un archivo nuevo, por ejemplo:  
    `app/database/migrations/CreateURLsTable.php`  
    que contenga la lógica de `CREATE TABLE IF NOT EXISTS ...`.  
  - [ ] Dejar `Database` únicamente con la responsabilidad de establecer y mantener la conexión (`getConnection()`).

- [ ] **Tarea 5.2: Actualizar `Database`**  
  - [ ] Eliminar o comentar la parte de `createTable()` dentro de `Database`.  
  - [ ] Ajustar el método `getConnection()` para que ya no llame a la creación de tablas.  
  - [ ] Mover la lógica de `createDatabase()` a un proceso de setup o migración, si también deseas extraer esa responsabilidad.

---

## 6. Revisar nombres y realizar refactor final (SRP/OCP)

- [ ] **Tarea 6.1: Ajustar nombres de clases y archivos para mayor coherencia**  
  - [ ] Por ejemplo, cambiar `GetDataService` a `URLService` o `DataService`, si describe mejor la funcionalidad.  
  - [ ] Asegurarse de que los archivos correspondan a los nombres de las clases para mantener consistencia (psr-4, convención de nombres, etc.).

- [ ] **Tarea 6.2: Verificar si se necesita una interfaz para la conexión de base de datos**  
  - [ ] Si en el futuro se planea soportar múltiples motores (MySQL, PostgreSQL, etc.), crear `DatabaseConnectionInterface` y mover la lógica de `Database` ahí.  
  - [ ] Implementar distintas clases concretas si se requiere.

- [ ] **Tarea 6.3: Pruebas finales**  
  - [ ] Probar que la aplicación funcione con cada refactor.  
  - [ ] Realizar tests unitarios (si existen) o manuales para asegurarse de que todo sigue operando correctamente.
