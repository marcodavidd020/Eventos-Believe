# 🎉 Tecno Believe - Sistema de Gestión de Eventos

![Laravel](https://img.shields.io/badge/Laravel-11.45.1-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4.1-blue?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql)

## 📋 Descripción

**Tecno Believe** es un sistema completo de gestión de eventos desarrollado en Laravel 11 que permite la administración integral de eventos, reservas, patrocinadores, promociones y servicios. El sistema incluye funcionalidades avanzadas como generación de códigos QR para pagos, integración con Cloudinary para gestión de imágenes, y un diseño moderno y responsivo.

## ✨ Características Principales

### 🎯 **Gestión de Eventos**
- ✅ CRUD completo de eventos
- ✅ Subida de imágenes con Cloudinary
- ✅ Estados: Activo, Programado, Inactivo
- ✅ Gestión de capacidad y precios
- ✅ Vista pública de eventos

### 🎫 **Sistema de Reservas**
- ✅ Reservas de entradas por usuarios
- ✅ Generación de códigos QR para pagos
- ✅ Integración con servicios de pago
- ✅ Validación de disponibilidad

### 🏢 **Gestión de Patrocinadores**
- ✅ Registro de patrocinadores
- ✅ Gestión de patrocinios
- ✅ Información de contacto
- ✅ Estadísticas de patrocinios

### 🎁 **Sistema de Promociones**
- ✅ Descuentos por porcentaje
- ✅ Fechas de vigencia
- ✅ Asociación con eventos
- ✅ Visualización automática

### 👥 **Gestión de Usuarios**
- ✅ Autenticación con Laravel Jetstream
- ✅ Roles de administrador y cliente
- ✅ Perfiles personalizables
- ✅ Temas claro/oscuro

### 🎨 **Interfaz Moderna**
- ✅ Diseño responsivo con Tailwind CSS
- ✅ Modo oscuro/claro
- ✅ Animaciones y transiciones
- ✅ Componentes reutilizables

## 🛠️ Tecnologías Utilizadas

### **Backend**
- **Laravel 11.45.1** - Framework PHP
- **PHP 8.4.1** - Lenguaje de programación
- **MySQL 8.0** - Base de datos
- **Laravel Jetstream** - Autenticación y equipos
- **Laravel Fortify** - Autenticación backend

### **Frontend**
- **Tailwind CSS 3.0** - Framework CSS
- **Alpine.js** - Framework JavaScript reactivo
- **Livewire** - Componentes dinámicos
- **Font Awesome** - Iconografía

### **Servicios Externos**
- **Cloudinary** - Gestión de imágenes
- **QR Code Generator** - Generación de códigos QR
- **Servicios de Pago** - Integración con pasarelas

### **Herramientas de Desarrollo**
- **Composer** - Gestor de dependencias PHP
- **NPM** - Gestor de dependencias JavaScript
- **Vite** - Bundler de assets
- **Git** - Control de versiones

## 📁 Estructura del Proyecto

```
tecno-believe/
├── 📁 app/
│   ├── 📁 Http/Controllers/     # Controladores
│   ├── 📁 Models/              # Modelos Eloquent
│   ├── 📁 Middleware/          # Middleware personalizado
│   └── 📁 View/Components/     # Componentes Blade
├── 📁 database/
│   ├── 📁 migrations/          # Migraciones de BD
│   └── 📁 seeders/            # Seeders de datos
├── 📁 resources/
│   ├── 📁 views/              # Vistas Blade
│   ├── 📁 css/               # Estilos CSS
│   └── 📁 js/                # JavaScript
├── 📁 public/                 # Assets públicos
├── 📁 storage/               # Almacenamiento
├── 📁 docs/                  # Documentación
└── 📁 config/               # Configuraciones
```

## 🚀 Instalación y Configuración

### **Prerrequisitos**
- PHP >= 8.2
- Composer
- Node.js >= 16
- MySQL >= 8.0
- Git

### **1. Clonar el Repositorio**
```bash
git clone https://github.com/tu-usuario/tecno-believe.git
cd tecno-believe
```

### **2. Instalar Dependencias**
```bash
# Dependencias PHP
composer install

# Dependencias JavaScript
npm install
```

### **3. Configuración del Entorno**
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### **4. Configurar Base de Datos**
Edita el archivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tecno_believe
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### **5. Configurar Cloudinary**
```env
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
CLOUDINARY_UPLOAD_PRESET=tu_preset
```

### **6. Ejecutar Migraciones**
```bash
# Crear base de datos
php artisan migrate

# Ejecutar seeders (opcional)
php artisan db:seed
```

### **7. Crear Enlace de Storage**
```bash
php artisan storage:link
```

### **8. Compilar Assets**
```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### **9. Iniciar Servidor**
```bash
php artisan serve
```

## 📊 Diagramas del Sistema

### **Diagrama de Arquitectura**
```mermaid
graph TB
    A[Cliente Web] --> B[Laravel Application]
    B --> C[MySQL Database]
    B --> D[Cloudinary API]
    B --> E[QR Service]
    
    subgraph "Laravel App"
        F[Controllers]
        G[Models]
        H[Views]
        I[Middleware]
    end
    
    B --> F
    F --> G
    G --> C
    F --> H
    A --> I
```

### **Diagrama de Base de Datos**
```mermaid
erDiagram
    USERS ||--o{ BOOKINGS : makes
    EVENTS ||--o{ BOOKINGS : has
    EVENTS ||--o{ PROMOTIONS : has
    SPONSORS ||--o{ SPONSORSHIPS : creates
    EVENTS ||--o{ EVENT_DETAILS : contains
    SERVICES ||--o{ EVENT_DETAILS : provides
    
    USERS {
        id bigint PK
        name varchar
        email varchar
        password varchar
        role varchar
        style varchar
        created_at timestamp
        updated_at timestamp
    }
    
    EVENTS {
        id bigint PK
        nombre varchar
        descripcion text
        capacidad int
        precio_entrada decimal
        fecha date
        hora time
        ubicacion varchar
        estado varchar
        imagen varchar
        public_id varchar
        created_at timestamp
        updated_at timestamp
    }
    
    BOOKINGS {
        id bigint PK
        usuario_id bigint FK
        evento_id bigint FK
        costo_entrada decimal
        created_at timestamp
        updated_at timestamp
    }
    
    PROMOTIONS {
        id bigint PK
        evento_id bigint FK
        descripcion varchar
        descuento int
        fecha_inicio date
        fecha_fin date
        created_at timestamp
        updated_at timestamp
    }
    
    SPONSORS {
        id bigint PK
        nombre varchar
        descripcion text
        email varchar
        telefono varchar
        created_at timestamp
        updated_at timestamp
    }
```

## 🔧 Configuración Avanzada

### **Variables de Entorno Importantes**
```env
# Aplicación
APP_NAME="Tecno Believe"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de Datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tecno_believe

# Cloudinary
CLOUDINARY_URL=cloudinary://key:secret@cloud
CLOUDINARY_UPLOAD_PRESET=preset_name

# Cache
CACHE_STORE=database
SESSION_DRIVER=database

# Queue
QUEUE_CONNECTION=database
```

### **Configuración de Roles**
El sistema maneja dos roles principales:
- **admin**: Acceso completo al panel administrativo
- **client**: Acceso a funcionalidades de cliente

## 📖 Guías de Uso

### **Para Administradores**
1. **Gestión de Eventos**: [docs/admin/events.md](docs/admin/events.md)
2. **Gestión de Patrocinadores**: [docs/admin/sponsors.md](docs/admin/sponsors.md)
3. **Sistema de Promociones**: [docs/admin/promotions.md](docs/admin/promotions.md)
4. **Gestión de Usuarios**: [docs/admin/users.md](docs/admin/users.md)

### **Para Desarrolladores**
1. **Arquitectura del Sistema**: [docs/dev/architecture.md](docs/dev/architecture.md)
2. **API Documentation**: [docs/dev/api.md](docs/dev/api.md)
3. **Componentes Personalizados**: [docs/dev/components.md](docs/dev/components.md)
4. **Testing**: [docs/dev/testing.md](docs/dev/testing.md)

### **Para Usuarios Finales**
1. **Registro y Login**: [docs/user/auth.md](docs/user/auth.md)
2. **Reserva de Eventos**: [docs/user/bookings.md](docs/user/bookings.md)
3. **Pagos con QR**: [docs/user/payments.md](docs/user/payments.md)

## 🧪 Testing

### **Ejecutar Tests**
```bash
# Todos los tests
php artisan test

# Tests específicos
php artisan test --filter EventTest

# Con coverage
php artisan test --coverage
```

### **Tests Disponibles**
- ✅ Tests de Autenticación
- ✅ Tests de CRUD de Eventos
- ✅ Tests de Sistema de Reservas
- ✅ Tests de Promociones
- ✅ Tests de API

## 🚀 Deployment

### **Producción**
```bash
# Optimizar aplicación
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compilar assets
npm run build
```

### **Docker (Opcional)**
```bash
# Construir imagen
docker build -t tecno-believe .

# Ejecutar contenedor
docker run -p 8000:8000 tecno-believe
```

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

### **Estándares de Código**
- Seguir PSR-12 para PHP
- Usar ESLint para JavaScript
- Documentar todas las funciones públicas
- Escribir tests para nuevas funcionalidades

## 📝 Changelog

### **v2.0.0** (2024-12-15)
- ✨ Rediseño completo de la interfaz
- ✨ Sistema de promociones
- ✨ Integración con Cloudinary
- ✨ Generación de códigos QR
- ✨ Modo oscuro/claro
- 🐛 Corrección de errores de timestamps
- 🐛 Mejoras en el sistema de reservas

### **v1.0.0** (2024-07-02)
- 🎉 Lanzamiento inicial
- ✨ CRUD de eventos
- ✨ Sistema de autenticación
- ✨ Panel administrativo básico

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

## 👥 Equipo

- **Desarrollador Principal**: Marco Toledo
- **UI/UX Designer**: Marco Toledo
- **QA Tester**: Marco Toledo

## 📞 Soporte

- **Email**: marcodaviddtc@gmail.com
- **Documentación**: [docs.tecnobelieve.com](https://docs.tecnobelieve.com)
- **Issues**: [GitHub Issues](https://github.com/tu-usuario/tecno-believe/issues)

## 🙏 Agradecimientos

- Laravel Framework
- Tailwind CSS Team
- Cloudinary
- Font Awesome
- Comunidad Open Source

---

**¡Gracias por usar Tecno Believe! 🎉**

Para más información detallada, consulta la documentación específica en la carpeta `docs/`.
