
## 1. Implementar la Inversión de Dependencias (DIP) con un repositorio de URLs

### 1.1. Crear un repositorio `URLRepository` que implemente `IURLRepository`
- [x] **1.1.1 (Crear archivo)**: `app/repositories/URLRepository.php`  
  - [x] **1.1.1.1 (Dentro de URLRepository.php)**: Definir la clase `URLRepository` que implemente la interfaz `IURLRepository`.
  - [x] **1.1.1.2 (Dentro de URLRepository.php)**: Inyectar un objeto `PDO` en el constructor.
  - [x] **1.1.1.3 (Dentro de URLRepository.php)**: Implementar el método `saveURL(string $url): bool`.
  - [x] **1.1.1.4 (Dentro de URLRepository.php)**: Implementar el método `getAllURLs(): array`.
  - [x] **1.1.1.5 (Dentro de URLRepository.php)**: Crear un método `getLastURL(): ?string` para retornar la última URL almacenada.

### 1.2. Ajustar la interfaz `IURLRepository` para añadir `getLastURL`
- [ ] **1.2.1 (Modificar archivo)**: `app/interfaces/IURLRepository.php`  
  - [ ] **1.2.1.1 (Dentro de IURLRepository.php)**: Agregar la declaración del método `public function getLastURL(): ?string;` si aún no existe.

---

## 2. Modificar `GetDataService` para inyectar el nuevo repositorio

### 2.1. Eliminar la creación directa de `Database` en `GetDataService`
- [ ] **2.1.1 (Modificar archivo)**: `public/get_data.php`  
  - [ ] **2.1.1.1**: Quitar la línea donde se instancia `new Database()` dentro de `GetDataService`.
  - [ ] **2.1.1.2**: Crear una instancia de `URLRepository` (pasándole la conexión `PDO`).
  - [ ] **2.1.1.3**: Inyectar esa instancia en el constructor de `GetDataService`.

### 2.2. Usar el método `getLastURL()` del repositorio en `GetDataService`
- [ ] **2.2.1 (Modificar archivo)**: `public/get_data.php`  
  - [ ] **2.2.1.1**: Reemplazar la llamada a `$service->getLastUrl()` para que ahora use `$service->getLastURL()` proveniente del repositorio.
  - [ ] **2.2.1.2**: Asegurarse de que toda la lógica de obtención de la URL está delegada a `URLRepository`.

---

## 3. Separar la lógica de respuesta HTTP de la lógica de negocio (SRP)

### 3.1. Crear un nuevo controlador para la respuesta
- [ ] **3.1.1 (Crear archivo)**: `public/controllers/GetDataController.php`  
  - [ ] **3.1.1.1**: Definir la clase `GetDataController`.
  - [ ] **3.1.1.2**: Inyectar (vía constructor) la instancia de `GetDataService` o la clase que maneje la lógica de URLs.
  - [ ] **3.1.1.3**: Agregar un método (por ejemplo, `public function handleRequest()`) para configurar los encabezados HTTP y generar la respuesta JSON.

### 3.2. Usar el nuevo controlador en `get_data.php`
- [ ] **3.2.1 (Modificar archivo)**: `public/get_data.php`
  - [ ] **3.2.1.1**: Eliminar los `header(...)` de `GetDataService` y moverlos a `GetDataController`.
  - [ ] **3.2.1.2**: Instanciar `GetDataController` y llamar a su método `handleRequest()`.

---

## 4. Reemplazar la función global `debug_trace()` por `DebugInterface` (DIP)

### 4.1. Eliminar o refactorizar `debug_helper.php`
- [ ] **4.1.1 (Eliminar archivo)**: `app/helpers/debug_helper.php`  
  - [ ] **4.1.1.1**: Verificar dónde se está usando `require_once __DIR__ . '/../app/helpers/debug_helper.php'` y quitar esas referencias.
  - [ ] **4.1.1.2**: Borrar `debug_helper.php` o bien vaciar su contenido para no romper rutas existentes.

#### (O, alternativamente)

- [ ] **4.1.2 (Modificar archivo)**: `app/helpers/debug_helper.php`
  - [ ] **4.1.2.1**: Convertir la función global `debug_trace()` en una clase que implemente `DebugInterface` (si se decide refactorizar en lugar de eliminar).

### 4.2. Inyectar `DebugInterface` en las clases que usaban `debug_trace()`
- [ ] **4.2.1 (Modificar archivo)**: `app/models/database.php`
  - [ ] **4.2.1.1**: Eliminar llamadas a `debug_trace()` y sustituirlas por `$this->debug->debug(...)`.
  - [ ] **4.2.1.2**: Inyectar una instancia de `DebugInterface` en el constructor de la clase `Database`.

- [ ] **4.2.2 (Modificar archivo)**: `public/get_data.php` (o el controlador correspondiente)
  - [ ] **4.2.2.1**: Eliminar llamadas a `debug_trace()`.
  - [ ] **4.2.2.2**: Asegurarse de que se inyecta `DebugLogger` (o la clase concreta) en los componentes que necesitan logs.

---

## 5. Extraer la creación de tablas y base de datos de `Database` (OCP)

### 5.1. Crear archivos de migración para la tabla `urls`
- [ ] **5.1.1 (Crear archivo)**: `app/database/migrations/CreateUrlsTable.php`
  - [ ] **5.1.1.1**: Agregar lógica de `CREATE TABLE IF NOT EXISTS urls ...`.
  - [ ] **5.1.1.2**: Diseñar un método estático o de instancia (p. ej., `run()`).

### 5.2. Mover la creación de la base de datos a un proceso de configuración
- [ ] **5.2.1 (Crear archivo)**: `app/database/migrations/CreateDatabase.php`
  - [ ] **5.2.1.1**: Agregar la lógica de `CREATE DATABASE IF NOT EXISTS ...`.
  - [ ] **5.2.1.2**: Manejar la configuración necesaria (host, usuario, etc.).

### 5.3. Ajustar la clase `Database`
- [ ] **5.3.1 (Modificar archivo)**: `app/models/database.php`
  - [ ] **5.3.1.1**: Eliminar el método `createTable()` y toda referencia a creación de la DB.
  - [ ] **5.3.1.2**: Conservar únicamente la lógica de `getConnection()` y `createDatabase()` **si** es que aún es obligatoria (o moverla también al nuevo archivo de migración).
  - [ ] **5.3.1.3**: Ajustar las excepciones para no depender de la lógica de creación de tablas.

---

## 6. Refactor final: nombres y consistencia (SRP/OCP)

### 6.1. Renombrar `GetDataService` a `URLService` (o nombre más claro)
- [ ] **6.1.1 (Modificar archivo)**: `public/get_data.php` (o donde esté la clase)
  - [ ] **6.1.1.1**: Cambiar el nombre de la clase de `GetDataService` a `URLService`.
  - [ ] **6.1.1.2**: Ajustar todas las instancias donde se use `new GetDataService(...)` por `new URLService(...)`.

### 6.2. Verificar coherencia en rutas y nombres de archivos
- [ ] **6.2.1 (Modificar archivo)**: `composer.json` (si aplica PSR-4)
  - [ ] **6.2.1.1**: Asegurarse de que el autoload PSR-4 (o el mapeo de archivos) incluya correctamente las nuevas rutas.

### 6.3. Revisión final y pruebas
- [ ] **6.3.1 (Modificar archivo)**: `public/get_data.php` (o el controlador si se renombró)
  - [ ] **6.3.1.1**: Probar que las rutas y clases carguen correctamente.
  - [ ] **6.3.1.2**: Confirmar que la API/servicio responde como se espera.
