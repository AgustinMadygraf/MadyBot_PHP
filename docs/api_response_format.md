# Formato de Respuestas de la API

Este documento describe el formato estándar de las respuestas JSON utilizadas en la API para garantizar consistencia y facilitar la integración con sistemas externos.

## Estructura General

Todas las respuestas de la API seguirán la siguiente estructura:

### Respuesta de Éxito
```json
{
  "status": "success",
  "message": "Mensaje opcional describiendo el éxito.",
  "data": {
    "key": "value"
  }
}
```

- `status`: Indica el estado de la respuesta, siempre será `success`.
- `message`: Mensaje opcional que describe el resultado exitoso.
- `data`: Contiene los datos devueltos por la API. Puede ser `null` si no hay datos relevantes.

### Respuesta de Error
```json
{
  "status": "error",
  "message": "Descripción del error ocurrido.",
  "errors": [
    "Detalle del error 1",
    "Detalle del error 2"
  ]
}
```

- `status`: Indica el estado de la respuesta, siempre será `error`.
- `message`: Mensaje que describe el error ocurrido.
- `errors`: Lista opcional de detalles adicionales sobre el error.

## Ejemplos

### Ejemplo de Respuesta de Éxito
```json
{
  "status": "success",
  "message": "Operación completada exitosamente.",
  "data": {
    "id": 123,
    "name": "Ejemplo"
  }
}
```

### Ejemplo de Respuesta de Error
```json
{
  "status": "error",
  "message": "El payload no es válido.",
  "errors": [
    "El campo 'email' es obligatorio.",
    "El campo 'password' debe tener al menos 8 caracteres."
  ]
}
```

## Notas
- Todas las respuestas incluirán el header `Content-Type: application/json; charset=utf-8`.
- Los códigos de estado HTTP serán utilizados de acuerdo con el contexto de la respuesta (por ejemplo, `200` para éxito, `400` para errores de cliente, `500` para errores del servidor).