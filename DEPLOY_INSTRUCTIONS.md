# Instrucciones de Despliegue - RifApp Plus

## Información del Servidor
- **Servidor**: vbox.pro
- **Usuario**: mediamat  
- **Directorio**: /home2/mediamat/rifapp
- **URL Final**: https://www.vbox.pro/rifapp/

## Proceso de Despliegue

### 1. Verificación Pre-despliegue
- ✅ .htaccess configurado para subdirectorios
- ✅ Router actualizado para detección automática de base URL
- ✅ index.php principal actualizado para subdirectorios
- ✅ .env.production preparado con configuración de producción

### 2. Archivos a Transferir
- app/ (controladores, modelos, vistas)
- config/ (configuraciones)
- core/ (clases principales)
- public/ (recursos públicos)
- resources/ (assets)
- routes/ (definición de rutas)
- storage/ (logs, sesiones)
- scripts/ (scripts auxiliares)
- index.php (punto de entrada)
- .htaccess (reescritura de URLs)
- composer.json (dependencias)

### 3. Configuración Post-despliegue
- Copiar .env.production como .env
- Configurar permisos (755 para archivos, 777 para storage/)
- Instalar dependencias de Composer
- Ejecutar instalador web si es necesario

### 4. Validación
- Verificar acceso a https://www.vbox.pro/rifapp/
- Probar instalador en https://www.vbox.pro/rifapp/install/
- Validar funcionamiento de rutas y recursos estáticos

## Comandos SSH Importantes
```bash
# Crear estructura de directorios
mkdir -p /home2/mediamat/rifapp/{storage/logs,storage/sessions,storage/cache}

# Configurar permisos
chmod -R 755 /home2/mediamat/rifapp
chmod -R 777 /home2/mediamat/rifapp/storage/

# Instalar dependencias
cd /home2/mediamat/rifapp && composer install --no-dev --optimize-autoloader
```
