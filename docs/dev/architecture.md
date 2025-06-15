# 🏗️ Arquitectura del Sistema - Tecno Believe

## 📋 Índice
- [Visión General](#visión-general)
- [Arquitectura de Capas](#arquitectura-de-capas)
- [Patrones de Diseño](#patrones-de-diseño)
- [Diagramas de Secuencia](#diagramas-de-secuencia)
- [Diagramas de Actividad](#diagramas-de-actividad)
- [Diagramas de Clases](#diagramas-de-clases)
- [Flujo de Datos](#flujo-de-datos)

## 🎯 Visión General

Tecno Believe está construido siguiendo una **arquitectura MVC (Model-View-Controller)** con Laravel 11, implementando principios de **Clean Architecture** y **SOLID**. El sistema está diseñado para ser escalable, mantenible y testeable.

### **Principios Arquitectónicos**
- ✅ **Separación de Responsabilidades**
- ✅ **Inversión de Dependencias**
- ✅ **Principio Abierto/Cerrado**
- ✅ **Single Responsibility Principle**
- ✅ **DRY (Don't Repeat Yourself)**

## 🏛️ Arquitectura de Capas

```mermaid
graph TB
    subgraph "Presentation Layer"
        A[Blade Views]
        B[Livewire Components]
        C[Alpine.js]
        D[Tailwind CSS]
    end
    
    subgraph "Application Layer"
        E[Controllers]
        F[Middleware]
        G[Form Requests]
        H[Resources]
    end
    
    subgraph "Domain Layer"
        I[Models/Entities]
        J[Business Logic]
        K[Domain Services]
        L[Events]
    end
    
    subgraph "Infrastructure Layer"
        M[Database]
        N[Cloudinary API]
        O[QR Service]
        P[Cache]
        Q[Queue]
    end
    
    A --> E
    B --> E
    E --> I
    F --> E
    G --> E
    I --> M
    K --> N
    K --> O
    E --> P
    E --> Q
```

### **1. Capa de Presentación**
- **Blade Views**: Templates para renderizado HTML
- **Livewire Components**: Componentes reactivos
- **Alpine.js**: Interactividad del frontend
- **Tailwind CSS**: Estilos y diseño responsivo

### **2. Capa de Aplicación**
- **Controllers**: Lógica de control de flujo
- **Middleware**: Filtros de peticiones HTTP
- **Form Requests**: Validación de datos
- **Resources**: Transformación de datos para API

### **3. Capa de Dominio**
- **Models**: Entidades del negocio
- **Business Logic**: Reglas de negocio
- **Domain Services**: Servicios específicos del dominio
- **Events**: Eventos del sistema

### **4. Capa de Infraestructura**
- **Database**: Persistencia de datos
- **External APIs**: Servicios externos (Cloudinary, QR)
- **Cache**: Sistema de caché
- **Queue**: Cola de trabajos

## 🎨 Patrones de Diseño

### **1. Repository Pattern**
```php
interface EventRepositoryInterface
{
    public function findById(int $id): ?Event;
    public function findActive(): Collection;
    public function create(array $data): Event;
    public function update(Event $event, array $data): Event;
    public function delete(Event $event): bool;
}
```

### **2. Service Pattern**
```php
class EventService
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private ImageService $imageService
    ) {}
    
    public function createEvent(array $data): Event
    {
        if (isset($data['image'])) {
            $data['imagen'] = $this->imageService->upload($data['image']);
        }
        
        return $this->eventRepository->create($data);
    }
}
```

### **3. Observer Pattern**
```php
class EventObserver
{
    public function created(Event $event): void
    {
        // Notificar a usuarios suscritos
        NotifySubscribersJob::dispatch($event);
    }
    
    public function updated(Event $event): void
    {
        // Limpiar caché relacionado
        Cache::tags(['events'])->flush();
    }
}
```

## 🔄 Diagramas de Secuencia

### **Proceso de Reserva de Evento**
```mermaid
sequenceDiagram
    participant U as Usuario
    participant C as Controller
    participant S as Service
    participant M as Model
    participant Q as QR Service
    participant DB as Database
    
    U->>C: POST /events/{id}/book
    C->>S: validateBooking(user, event)
    S->>M: checkAvailability()
    M->>DB: SELECT bookings COUNT
    DB-->>M: count
    M-->>S: availability
    
    alt Disponible
        S->>Q: generateQR(paymentData)
        Q-->>S: qrCode
        S->>M: createBooking()
        M->>DB: INSERT booking
        DB-->>M: booking
        M-->>S: booking
        S-->>C: success + qrCode
        C-->>U: QR Code View
    else No Disponible
        S-->>C: error
        C-->>U: Error Message
    end
```

### **Proceso de Autenticación**
```mermaid
sequenceDiagram
    participant U as Usuario
    participant M as Middleware
    participant A as Auth Service
    participant DB as Database
    participant S as Session
    
    U->>M: Request with credentials
    M->>A: attempt(credentials)
    A->>DB: SELECT user WHERE email
    DB-->>A: user data
    A->>A: verify password
    
    alt Credenciales válidas
        A->>S: create session
        S-->>A: session_id
        A-->>M: authenticated user
        M-->>U: redirect to dashboard
    else Credenciales inválidas
        A-->>M: authentication failed
        M-->>U: error message
    end
```

## 📊 Diagramas de Actividad

### **Flujo de Creación de Evento**
```mermaid
flowchart TD
    A[Inicio] --> B[Llenar Formulario]
    B --> C{Validar Datos}
    C -->|Inválido| D[Mostrar Errores]
    D --> B
    C -->|Válido| E{¿Tiene Imagen?}
    E -->|Sí| F[Subir a Cloudinary]
    E -->|No| G[Usar Imagen por Defecto]
    F --> H[Guardar en BD]
    G --> H
    H --> I[Limpiar Caché]
    I --> J[Notificar Éxito]
    J --> K[Fin]
```

### **Flujo de Pago con QR**
```mermaid
flowchart TD
    A[Usuario Selecciona Evento] --> B[Verificar Autenticación]
    B -->|No Auth| C[Redirect Login]
    B -->|Auth| D[Verificar Disponibilidad]
    D -->|No Disponible| E[Mostrar Error]
    D -->|Disponible| F[Mostrar Formulario Pago]
    F --> G[Seleccionar Método Pago]
    G -->|QR| H[Generar QR Code]
    G -->|Tigo Money| I[Redirect Tigo]
    H --> J[Mostrar QR]
    J --> K[Usuario Escanea QR]
    K --> L[Procesar Pago]
    L -->|Éxito| M[Crear Reserva]
    L -->|Error| N[Mostrar Error Pago]
    M --> O[Enviar Confirmación]
    O --> P[Fin]
```

## 🏗️ Diagramas de Clases

### **Módulo de Eventos**
```mermaid
classDiagram
    class Event {
        +int id
        +string nombre
        +string descripcion
        +int capacidad
        +decimal precio_entrada
        +date fecha
        +time hora
        +string ubicacion
        +string estado
        +string imagen
        +string public_id
        +timestamps
        +hasActivePromotion() bool
        +getDiscountedPrice() decimal
        +bookings() HasMany
        +promotions() HasMany
    }
    
    class Booking {
        +int id
        +int usuario_id
        +int evento_id
        +decimal costo_entrada
        +timestamps
        +user() BelongsTo
        +event() BelongsTo
    }
    
    class Promotion {
        +int id
        +int evento_id
        +string descripcion
        +int descuento
        +date fecha_inicio
        +date fecha_fin
        +timestamps
        +isActive() bool
        +event() BelongsTo
    }
    
    class User {
        +int id
        +string name
        +string email
        +string password
        +string role
        +string style
        +timestamps
        +bookings() HasMany
        +isAdmin() bool
    }
    
    %% Relaciones permitidas
    Event o-- Booking : "has"
    Event o-- Promotion : "has"
    User o-- Booking : "makes"
```

### **Módulo de Patrocinadores**
```mermaid
classDiagram
    class Sponsor {
        +int id
        +string nombre
        +string descripcion
        +string email
        +string telefono
        +timestamps
        +sponsorships() HasMany
    }

    class Sponsorship {
        +int id
        +int patrocinador_id
        +int evento_id
        +decimal monto
        +string tipo
        +timestamps
        +sponsor() BelongsTo
        +event() BelongsTo
    }

    %% Relaciones corregidas
    Sponsor o-- Sponsorship : creates
    Event o-- Sponsorship : receives
```

## 🌊 Flujo de Datos

### **Arquitectura de Datos**
```mermaid
graph LR
    subgraph "Input Sources"
        A[Web Forms]
        B[API Requests]
        C[File Uploads]
    end
    
    subgraph "Processing Layer"
        D[Controllers]
        E[Services]
        F[Validators]
    end
    
    subgraph "Storage Layer"
        G[MySQL Database]
        H[Cloudinary CDN]
        I[Redis Cache]
    end
    
    subgraph "Output Layer"
        J[Blade Views]
        K[JSON API]
        L[PDF Reports]
    end
    
    A --> D
    B --> D
    C --> D
    D --> E
    E --> F
    F --> G
    F --> H
    E --> I
    G --> J
    G --> K
    G --> L
    H --> J
    I --> J
```

### **Flujo de Caché**
```mermaid
graph TD
    A[Request] --> B{Cache Hit?}
    B -->|Yes| C[Return Cached Data]
    B -->|No| D[Query Database]
    D --> E[Store in Cache]
    E --> F[Return Data]
    
    G[Data Update] --> H[Invalidate Cache]
    H --> I[Clear Related Tags]
```

## 🔧 Configuración de Arquitectura

### **Service Providers**
```php
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            EventRepositoryInterface::class,
            EventRepository::class
        );
        
        $this->app->bind(
            ImageServiceInterface::class,
            CloudinaryImageService::class
        );
    }
}
```

### **Middleware Stack**
```php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\HandleInertiaRequests::class,
    ],
    
    'admin' => [
        'auth:sanctum',
        'verified',
        \App\Http\Middleware\CheckRole::class.':admin',
    ],
];
```

## 📈 Escalabilidad

### **Estrategias de Escalabilidad**
1. **Horizontal Scaling**: Load balancers + múltiples instancias
2. **Database Sharding**: Particionamiento por región/evento
3. **CDN Integration**: Cloudinary para assets estáticos
4. **Queue Workers**: Procesamiento asíncrono
5. **Redis Clustering**: Cache distribuido

### **Optimizaciones de Performance**
- **Eager Loading**: Prevenir N+1 queries
- **Database Indexing**: Índices optimizados
- **Query Optimization**: Consultas eficientes
- **Asset Optimization**: Minificación y compresión
- **HTTP Caching**: Headers de caché apropiados

## 🧪 Testing Architecture

### **Pirámide de Testing**
```mermaid
graph TD
    A[Unit Tests - 70%] --> B[Integration Tests - 20%]
    B --> C[E2E Tests - 10%]
    
    subgraph "Unit Tests"
        D[Model Tests]
        E[Service Tests]
        F[Helper Tests]
    end
    
    subgraph "Integration Tests"
        G[Controller Tests]
        H[Database Tests]
        I[API Tests]
    end
    
    subgraph "E2E Tests"
        J[Browser Tests]
        K[User Journey Tests]
    end
```

## 🔒 Seguridad

### **Capas de Seguridad**
1. **Authentication**: Laravel Sanctum
2. **Authorization**: Policies y Gates
3. **Input Validation**: Form Requests
4. **CSRF Protection**: Token verification
5. **SQL Injection**: Eloquent ORM
6. **XSS Protection**: Blade escaping

---

Esta arquitectura proporciona una base sólida para el crecimiento y mantenimiento del sistema Tecno Believe, siguiendo las mejores prácticas de desarrollo de software. 
