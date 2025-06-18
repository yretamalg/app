# 🚀 INSTRUCCIONES DE DESPLIEGUE - RifApp Plus

## 📋 RESUMEN DEL PROCESO
Has preparado exitosamente RifApp Plus para despliegue en el servidor cPanel de vbox.pro.

## 📦 ARCHIVO LISTO PARA SUBIR
- **Archivo**: `rifapp-deploy.zip` (101 KB)
- **Ubicación**: `C:\xampp\htdocs\app\rifapp-deploy.zip`

## 🎯 DESTINO DEL DESPLIEGUE
- **Servidor**: vbox.pro
- **Usuario**: mediamat
- **Directorio**: `/home2/mediamat/rifapp`
- **URL Final**: https://www.vbox.pro/rifapp/

## 📝 PASOS DE DESPLIEGUE

### 1. Subir Archivos al Servidor
Opciones para subir el archivo:

#### Opción A: File Manager de cPanel
1. Inicia sesión en el cPanel de vbox.pro
2. Ve a "File Manager"
3. Navega a `/home2/mediamat/`
4. Sube el archivo `rifapp-deploy.zip`
5. Extrae el archivo ZIP
6. Renombra la carpeta extraída a `rifapp`

#### Opción B: SSH/SCP
```bash
# Subir archivo
scp rifapp-deploy.zip mediamat@vbox.pro:/home2/mediamat/

# Conectar por SSH
ssh mediamat@vbox.pro

# Extraer archivos
cd /home2/mediamat/
unzip rifapp-deploy.zip -d rifapp/
```

### 2. Configurar Permisos
```bash
cd /home2/mediamat/rifapp
chmod -R 755 .
chmod -R 777 storage/
chmod 644 .env
```

### 3. Configurar Base de Datos
```bash
# Copiar configuración de producción
cp .env.production .env

# Editar .env con los datos correctos de DB:
# DB_HOST=localhost
# DB_NAME=mediamat_rifa
# DB_USER=mediamat_rifo  
# DB_PASSWORD=Nv^yQB7W0$jmK94b8VDW
```

### 4. Instalar Dependencias
```bash
cd /home2/mediamat/rifapp
composer install --no-dev --optimize-autoloader
```

### 5. Crear Estructura de Directorios
```bash
mkdir -p storage/logs storage/sessions storage/cache
chmod -R 777 storage/
```

## 🔧 CONFIGURACIÓN COMPLETADA

### ✅ Archivos Preparados:
- **`.htaccess`** - Configurado para funcionar en subdirectorio `/rifapp/`
- **`Router.php`** - Actualizado para detección automática de subdirectorio
- **`index.php`** - Mejorado para manejar rutas en subdirectorio
- **`.env.production`** - Configuración lista para producción

### ✅ Optimizaciones Aplicadas:
- URLs relativas automáticas
- Detección automática de subdirectorio
- Headers de seguridad
- Compresión GZIP
- Cache de archivos estáticos
- Protección de archivos sensibles

## 🌐 ACCESO POST-DESPLIEGUE

1. **Instalador**: https://www.vbox.pro/rifapp/install/
2. **Aplicación**: https://www.vbox.pro/rifapp/
3. **Panel Público**: https://www.vbox.pro/rifapp/public/

## ⚠️ VERIFICACIONES IMPORTANTES

### Después del despliegue, verifica:
1. ✅ La URL principal responde correctamente
2. ✅ El instalador es accesible
3. ✅ Los archivos CSS/JS se cargan desde `/rifapp/public/`
4. ✅ Las rutas internas funcionan correctamente
5. ✅ Los permisos de `storage/` están en 777

### Si hay problemas de rutas:
- Verifica que `.htaccess` esté en la raíz de `/rifapp/`
- Confirma que mod_rewrite está habilitado en el servidor
- Revisa que la variable `APP_URL` en `.env` sea: `https://www.vbox.pro/rifapp`

## 📞 SOPORTE
Si encuentras algún problema, verifica:
1. Los logs del servidor en `storage/logs/`
2. Los errores de Apache/PHP en el cPanel
3. Que todos los archivos se hayan subido correctamente

---
**¡Tu aplicación está lista para despliegue! 🎉**
