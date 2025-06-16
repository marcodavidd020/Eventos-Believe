# Despliegue en Vercel - Proyecto Laravel

## Archivos creados para Vercel

1. **`api/index.php`** - Punto de entrada para Vercel
2. **`vercel.json`** - Configuración principal de Vercel
3. **`.vercelignore`** - Archivos a ignorar en el despliegue

## Pasos para el despliegue

### 1. Instalar Vercel CLI
```bash
npm i -g vercel
```

### 2. Iniciar sesión en Vercel
```bash
vercel login
```

### 3. Configurar variables de entorno sensibles
**IMPORTANTE:** Antes de desplegar, debes configurar las variables de entorno sensibles directamente en Vercel (no en vercel.json por seguridad):

Ve al dashboard de Vercel → Tu proyecto → Settings → Environment Variables y agrega:

**Para PostgreSQL:**
- `DB_HOST` = `[TU_HOST_POSTGRESQL]`
- `DB_PORT` = `[TU_PUERTO]` (normalmente 5432)
- `DB_DATABASE` = `[TU_BASE_DE_DATOS]`
- `DB_USERNAME` = `[TU_USUARIO]`
- `DB_PASSWORD` = `[TU_CONTRASEÑA]`

**Variables adicionales:**
- `APP_KEY` = `[TU_APP_KEY_GENERADA]` (usar `php artisan key:generate --show`)
- `APP_URL` = `https://tu-proyecto.vercel.app`

### 4. Desplegar
```bash
vercel
```

### 5. Para despliegue en producción
```bash
vercel --prod
```

## Configuración de Base de Datos

Para el despliegue en producción, necesitarás una base de datos PostgreSQL en la nube. Opciones recomendadas:

1. **Aiven** (PostgreSQL - 5GB gratuito)
2. **Neon** (PostgreSQL - 3GB gratuito) 
3. **Supabase** (PostgreSQL - con interfaz web)
4. **Railway** (PostgreSQL/MySQL)
5. **PlanetScale** (MySQL compatible)

## Variables de entorno ya configuradas en vercel.json

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` (ya configurada)
- Configuración de cache para `/tmp`
- Drivers optimizados para serverless

## Notas importantes

1. **Archivos estáticos**: Los archivos en `public/` se servirán automáticamente
2. **Storage**: No uses `storage/` para archivos permanentes, ya que es efímero
3. **Database**: Asegúrate de ejecutar migraciones en tu DB externa antes del despliegue
4. **Dominio personalizado**: Configúralo en Settings → Domains en Vercel
5. **Variables de entorno**: Nunca pongas credenciales sensibles en `vercel.json`

## Comandos útiles de Vercel

```bash
# Ver logs en tiempo real
vercel logs

# Listar despliegues
vercel ls

# Eliminar despliegue
vercel rm [deployment-url]

# Configurar dominio
vercel domains add tu-dominio.com
```

## Solución de problemas comunes

1. **Error de APP_KEY**: Ya está configurada en vercel.json
2. **Error de permisos**: Vercel maneja automáticamente los permisos
3. **Error de base de datos**: Verifica las credenciales en Environment Variables
4. **Error 404**: Verifica que las rutas estén correctamente configuradas
5. **Error libssl.so.10**: Se solucionó actualizando a `vercel-php@0.7.2` y Node.js 18

### Error específico: libssl.so.10
Si encuentras el error:
```
php: error while loading shared libraries: libssl.so.10: cannot open shared object file: No such file or directory
```

**Solución aplicada:**
- Actualizado runtime a `vercel-php@0.7.2` (desde 0.6.0)
- Creado archivo `.node-version` especificando Node.js 18
- Añadido `buildCommand` optimizado en vercel.json

**Referencias:**
- [GitHub Issue #560](https://github.com/vercel-community/php/issues/560) - Problema resuelto en v0.7.2
- [GitHub Discussion #11347](https://github.com/vercel/vercel/discussions/11347) - Solución con Node.js 18

### Error: composer: command not found
Si encuentras el error:
```
sh: line 1: composer: command not found
Error: Command "composer install --no-dev --optimize-autoloader" exited with 127
```

**Solución:**
- **No usar `buildCommand` manual** - El runtime `vercel-php@0.7.2` maneja automáticamente Composer
- Según [Caleb Porzio](https://calebporzio.com/easy-free-serverless-laravel-with-vercel), el runtime hace "all the hard work for us like installing the proper dependencies and running `composer install`"
- Removido `buildCommand` del vercel.json para dejar que Vercel maneje la instalación automáticamente

### Conflicto con rutas API
Si tu proyecto Laravel usa rutas `/api/*`, añadidas rutas adicionales en vercel.json para evitar conflictos:
- `/build/*` → archivos de assets compilados
- `/storage/*` → archivos de storage público

### Error 500 - Configuraciones aplicadas
Para solucionar errores 500 en producción:

1. **TrustProxies configurado**: Añadido `$middleware->trustProxies(at: '*')` en `bootstrap/app.php`
2. **Base de datos PostgreSQL**: Configurado para usar PostgreSQL externo
3. **Error handling**: Añadido try-catch en ruta principal para manejar errores de DB
4. **Debug habilitado**: Para ver errores completos (cambiar a false en producción)
5. **URL actualizada**: Configurada URL correcta de Vercel
6. **Ruta de prueba**: Añadida `/test` para verificar funcionamiento básico

**Configuración de PostgreSQL:**
- Proveedor recomendado: Aiven, Neon, o Supabase
- Credenciales configuradas en Environment Variables de Vercel
- No se incluyen credenciales en el código por seguridad

**Para probar:**
- Visita: `https://eventos-believe.vercel.app/test`
- Debería mostrar JSON con información del sistema

## Actualizar el despliegue

Cada `git push` a la rama principal activará automáticamente un nuevo despliegue si conectas tu repositorio de GitHub con Vercel. 