# 🔌 API Documentation - Tecno Believe

## 📋 Índice
- [Introducción](#introducción)
- [Autenticación](#autenticación)
- [Endpoints de Eventos](#endpoints-de-eventos)
- [Endpoints de Reservas](#endpoints-de-reservas)
- [Endpoints de Usuarios](#endpoints-de-usuarios)
- [Endpoints de Patrocinadores](#endpoints-de-patrocinadores)
- [Endpoints de Promociones](#endpoints-de-promociones)
- [Códigos de Respuesta](#códigos-de-respuesta)
- [Ejemplos de Uso](#ejemplos-de-uso)

## 🎯 Introducción

La API de Tecno Believe proporciona acceso programático a todas las funcionalidades del sistema. Está construida siguiendo principios RESTful y utiliza JSON para el intercambio de datos.

### **Base URL**
```
https://api.tecnobelieve.com/v1
```

### **Características**
- ✅ **RESTful**: Arquitectura REST estándar
- ✅ **JSON**: Formato de datos JSON
- ✅ **Autenticación**: Laravel Sanctum
- ✅ **Rate Limiting**: Límites de velocidad
- ✅ **Versionado**: API versionada
- ✅ **CORS**: Soporte para CORS

## 🔐 Autenticación

### **Métodos de Autenticación**

#### **1. Sanctum Token**
```http
Authorization: Bearer {token}
```

#### **2. Session Cookie**
```http
Cookie: laravel_session={session_id}
X-CSRF-TOKEN: {csrf_token}
```

### **Obtener Token de Acceso**
```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "usuario@email.com",
    "password": "contraseña"
}
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "Usuario",
            "email": "usuario@email.com",
            "role": "client"
        },
        "token": "1|abc123def456..."
    }
}
```

## 🎯 Endpoints de Eventos

### **Listar Eventos**
```http
GET /api/events
```

**Parámetros de Query:**
| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `status` | string | Filtrar por estado (activo, programado, inactivo) |
| `date_from` | date | Fecha desde (YYYY-MM-DD) |
| `date_to` | date | Fecha hasta (YYYY-MM-DD) |
| `limit` | integer | Número de resultados (default: 10) |
| `page` | integer | Página (default: 1) |

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "events": [
            {
                "id": 1,
                "nombre": "Concierto de Rock",
                "descripcion": "Gran concierto...",
                "capacidad": 500,
                "precio_entrada": 150.00,
                "fecha": "2024-12-25",
                "hora": "20:00:00",
                "ubicacion": "Auditorio Municipal",
                "estado": "activo",
                "imagen": "https://res.cloudinary.com/...",
                "created_at": "2024-12-01T10:00:00Z",
                "updated_at": "2024-12-01T10:00:00Z"
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 5,
            "total_items": 50,
            "per_page": 10
        }
    }
}
```

### **Obtener Evento Específico**
```http
GET /api/events/{id}
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "event": {
            "id": 1,
            "nombre": "Concierto de Rock",
            "descripcion": "Gran concierto...",
            "capacidad": 500,
            "precio_entrada": 150.00,
            "fecha": "2024-12-25",
            "hora": "20:00:00",
            "ubicacion": "Auditorio Municipal",
            "estado": "activo",
            "imagen": "https://res.cloudinary.com/...",
            "bookings_count": 45,
            "available_spots": 455,
            "promotions": [
                {
                    "id": 1,
                    "descripcion": "Descuento navideño",
                    "descuento": 20,
                    "fecha_inicio": "2024-12-01",
                    "fecha_fin": "2024-12-31"
                }
            ]
        }
    }
}
```

### **Crear Evento** (Admin)
```http
POST /api/events
Authorization: Bearer {admin_token}
Content-Type: multipart/form-data

{
    "nombre": "Nuevo Evento",
    "descripcion": "Descripción del evento",
    "capacidad": 300,
    "precio_entrada": 100.00,
    "fecha": "2024-12-30",
    "hora": "19:00",
    "ubicacion": "Centro de Convenciones",
    "estado": "programado",
    "imagen": [archivo_imagen]
}
```

### **Actualizar Evento** (Admin)
```http
PUT /api/events/{id}
Authorization: Bearer {admin_token}
```

### **Eliminar Evento** (Admin)
```http
DELETE /api/events/{id}
Authorization: Bearer {admin_token}
```

## 🎫 Endpoints de Reservas

### **Crear Reserva**
```http
POST /api/bookings
Authorization: Bearer {token}
Content-Type: application/json

{
    "evento_id": 1,
    "usuario_id": 1,
    "costo_entrada": 150.00
}
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "booking": {
            "id": 123,
            "evento_id": 1,
            "usuario_id": 1,
            "costo_entrada": 150.00,
            "codigo_reserva": "TB-2024-001234",
            "estado": "confirmada",
            "created_at": "2024-12-15T14:30:00Z"
        }
    }
}
```

### **Listar Mis Reservas**
```http
GET /api/user/bookings
Authorization: Bearer {token}
```

### **Obtener Reserva Específica**
```http
GET /api/bookings/{id}
Authorization: Bearer {token}
```

### **Cancelar Reserva**
```http
DELETE /api/bookings/{id}
Authorization: Bearer {token}
```

## 👥 Endpoints de Usuarios

### **Registro**
```http
POST /api/auth/register
Content-Type: application/json

{
    "name": "Nombre Usuario",
    "email": "usuario@email.com",
    "password": "contraseña123",
    "password_confirmation": "contraseña123",
    "phone": "+591 12345678"
}
```

### **Perfil del Usuario**
```http
GET /api/user/profile
Authorization: Bearer {token}
```

### **Actualizar Perfil**
```http
PUT /api/user/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Nuevo Nombre",
    "phone": "+591 87654321",
    "style": "dark"
}
```

### **Cerrar Sesión**
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

## 🏢 Endpoints de Patrocinadores

### **Listar Patrocinadores** (Admin)
```http
GET /api/sponsors
Authorization: Bearer {admin_token}
```

### **Crear Patrocinador** (Admin)
```http
POST /api/sponsors
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "nombre": "Empresa Patrocinadora",
    "descripcion": "Descripción de la empresa",
    "email": "contacto@empresa.com",
    "telefono": "+591 12345678"
}
```

### **Actualizar Patrocinador** (Admin)
```http
PUT /api/sponsors/{id}
Authorization: Bearer {admin_token}
```

### **Eliminar Patrocinador** (Admin)
```http
DELETE /api/sponsors/{id}
Authorization: Bearer {admin_token}
```

## 🎁 Endpoints de Promociones

### **Listar Promociones**
```http
GET /api/promotions
```

### **Promociones Activas**
```http
GET /api/promotions/active
```

### **Crear Promoción** (Admin)
```http
POST /api/promotions
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "evento_id": 1,
    "descripcion": "Descuento especial",
    "descuento": 25,
    "fecha_inicio": "2024-12-01",
    "fecha_fin": "2024-12-31"
}
```

## 📊 Endpoints de Estadísticas (Admin)

### **Dashboard Stats**
```http
GET /api/admin/stats
Authorization: Bearer {admin_token}
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "events": {
            "total": 50,
            "active": 25,
            "programmed": 15,
            "inactive": 10
        },
        "bookings": {
            "total": 1250,
            "this_month": 150,
            "revenue": 187500.00
        },
        "users": {
            "total": 500,
            "new_this_month": 45
        },
        "sponsors": {
            "total": 12,
            "active": 8
        }
    }
}
```

## 🔢 Códigos de Respuesta

### **Códigos de Éxito**
| Código | Descripción |
|--------|-------------|
| `200` | OK - Solicitud exitosa |
| `201` | Created - Recurso creado |
| `204` | No Content - Eliminación exitosa |

### **Códigos de Error del Cliente**
| Código | Descripción |
|--------|-------------|
| `400` | Bad Request - Datos inválidos |
| `401` | Unauthorized - No autenticado |
| `403` | Forbidden - Sin permisos |
| `404` | Not Found - Recurso no encontrado |
| `422` | Unprocessable Entity - Errores de validación |
| `429` | Too Many Requests - Rate limit excedido |

### **Códigos de Error del Servidor**
| Código | Descripción |
|--------|-------------|
| `500` | Internal Server Error - Error interno |
| `503` | Service Unavailable - Servicio no disponible |

## 📝 Formato de Errores

### **Error de Validación**
```json
{
    "success": false,
    "message": "Los datos proporcionados no son válidos.",
    "errors": {
        "email": [
            "El campo email es obligatorio."
        ],
        "password": [
            "La contraseña debe tener al menos 8 caracteres."
        ]
    }
}
```

### **Error de Autenticación**
```json
{
    "success": false,
    "message": "No autenticado.",
    "error_code": "UNAUTHENTICATED"
}
```

### **Error de Autorización**
```json
{
    "success": false,
    "message": "No tienes permisos para realizar esta acción.",
    "error_code": "FORBIDDEN"
}
```

## 🚀 Ejemplos de Uso

### **JavaScript/Fetch**
```javascript
// Obtener eventos
async function getEvents() {
    try {
        const response = await fetch('https://api.tecnobelieve.com/v1/events', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            console.log('Eventos:', data.data.events);
        } else {
            console.error('Error:', data.message);
        }
    } catch (error) {
        console.error('Error de red:', error);
    }
}

// Crear reserva
async function createBooking(eventId, token) {
    try {
        const response = await fetch('https://api.tecnobelieve.com/v1/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                evento_id: eventId,
                usuario_id: 1,
                costo_entrada: 150.00
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            console.log('Reserva creada:', data.data.booking);
        } else {
            console.error('Error:', data.message);
        }
    } catch (error) {
        console.error('Error de red:', error);
    }
}
```

### **PHP/cURL**
```php
<?php
// Obtener eventos
function getEvents() {
    $curl = curl_init();
    
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.tecnobelieve.com/v1/events',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ]
    ]);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        return $data['data']['events'];
    }
    
    return null;
}

// Autenticación
function authenticate($email, $password) {
    $curl = curl_init();
    
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.tecnobelieve.com/v1/auth/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'email' => $email,
            'password' => $password
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ]
    ]);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        return $data['data']['token'];
    }
    
    return null;
}
?>
```

### **Python/Requests**
```python
import requests
import json

class TecnoBelieveAPI:
    def __init__(self, base_url="https://api.tecnobelieve.com/v1"):
        self.base_url = base_url
        self.token = None
    
    def authenticate(self, email, password):
        """Autenticar usuario y obtener token"""
        url = f"{self.base_url}/auth/login"
        data = {
            "email": email,
            "password": password
        }
        
        response = requests.post(url, json=data)
        
        if response.status_code == 200:
            result = response.json()
            self.token = result['data']['token']
            return True
        
        return False
    
    def get_events(self, status=None, limit=10):
        """Obtener lista de eventos"""
        url = f"{self.base_url}/events"
        params = {"limit": limit}
        
        if status:
            params["status"] = status
        
        response = requests.get(url, params=params)
        
        if response.status_code == 200:
            return response.json()['data']['events']
        
        return None
    
    def create_booking(self, event_id, cost):
        """Crear una reserva"""
        if not self.token:
            raise Exception("No autenticado")
        
        url = f"{self.base_url}/bookings"
        headers = {
            "Authorization": f"Bearer {self.token}",
            "Content-Type": "application/json"
        }
        data = {
            "evento_id": event_id,
            "costo_entrada": cost
        }
        
        response = requests.post(url, json=data, headers=headers)
        
        if response.status_code == 201:
            return response.json()['data']['booking']
        
        return None

# Uso
api = TecnoBelieveAPI()

# Autenticar
if api.authenticate("usuario@email.com", "contraseña"):
    # Obtener eventos activos
    events = api.get_events(status="activo")
    print(f"Eventos encontrados: {len(events)}")
    
    # Crear reserva para el primer evento
    if events:
        booking = api.create_booking(events[0]['id'], events[0]['precio_entrada'])
        if booking:
            print(f"Reserva creada: {booking['codigo_reserva']}")
```

## 🔄 Rate Limiting

### **Límites por Endpoint**
| Endpoint | Límite | Ventana |
|----------|--------|---------|
| `/auth/login` | 5 intentos | 1 minuto |
| `/auth/register` | 3 intentos | 5 minutos |
| `/events` | 100 requests | 1 minuto |
| `/bookings` | 10 requests | 1 minuto |
| Otros endpoints | 60 requests | 1 minuto |

### **Headers de Rate Limit**
```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1640995200
```

## 🔧 Configuración de CORS

### **Headers Permitidos**
- `Content-Type`
- `Authorization`
- `X-Requested-With`
- `X-CSRF-TOKEN`

### **Métodos Permitidos**
- `GET`
- `POST`
- `PUT`
- `DELETE`
- `OPTIONS`

### **Orígenes Permitidos**
- `https://tecnobelieve.com`
- `https://app.tecnobelieve.com`
- `http://localhost:3000` (desarrollo)

---

Esta documentación proporciona una guía completa para integrar con la API de Tecno Believe. Para más información o soporte técnico, contacta al equipo de desarrollo. 