# RifApp Plus

**Sistema de Gestión de Rifas para Chile** 🇨🇱

[![PHP](https://img.shields.io/badge/PHP-8.0%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 🎯 Descripción

RifApp Plus es una aplicación web moderna y escalable para la gestión de rifas en Chile. Desarrollada con arquitectura MVC en PHP, ofrece una plataforma segura y transparente para organizar y participar en rifas con total confianza.

### 🏗️ Arquitectura
- **Backend**: PHP con patrón MVC personalizado
- **Base de Datos**: MySQL con localización chilena
- **Frontend**: JavaScript modular + Tailwind CSS (estilo Glassmorphism)
- **Email**: Integración con PHPMailer
- **Enrutamiento**: URLs amigables basadas en slugs

### 👥 Sistema de Usuarios Multi-nivel
- **Super Administrador**: Control total del sistema
- **Administrador**: Gestión de rifas y vendedores
- **Vendedor**: Venta de números de rifas
- **Comprador**: Vista pública (sin registro requerido)

### 🎲 Tipos de Rifas
1. **Inventario Compartido**: Todos los vendedores ven los mismos números
2. **Inventario Estático**: Cada vendedor tiene su propia copia de números
3. **Inventario Específico**: Asignación manual o automática de rangos

### 🔔 Sistema de Notificaciones
- Notificaciones en tiempo real
- Registro de acciones (logs) para auditoría
- Sistema de "blames" para trazabilidad

### 🇨🇱 Localización Chilena
- Formato de moneda CLP
- Validación de RUT chileno
- Formatos de fecha chilenos
- Validación de números telefónicos chilenos

## 📋 Requisitos del Sistema

- **PHP**: 7.4 o superior
- **MySQL**: 5.7 o superior
- **Extensiones PHP requeridas**:
  - PDO MySQL
  - OpenSSL
  - Mbstring
  - JSON
  - cURL
- **Permisos de escritura**: directorios `/storage/` y raíz del proyecto

## 🚀 Instalación Rápida

### 1. Descarga y Preparación
```bash
# Clonar el repositorio
git clone https://github.com/tu-usuario/rifapp-plus.git
cd rifapp-plus

# Instalar dependencias
composer install
```

### 2. Instalación Asistida
1. Accede a `http://tu-servidor/app/install/`
2. Sigue el asistente de instalación paso a paso:
   - Verificación de requisitos del sistema
   - Configuración de base de datos
   - Creación de usuario administrador
   - Configuración general de la aplicación
   - Instalación final

### 3. ⚠️ IMPORTANTE - Seguridad
**Después de completar la instalación, DEBES eliminar el directorio `/install/` por seguridad:**

```bash
# En Windows
rmdir /s "ruta\del\proyecto\install"

# En Linux/Mac
rm -rf /ruta/del/proyecto/install/
```

### 4. Verificación
- Accede a `http://tu-servidor/app/` (redirige automáticamente)
- O directamente a `http://tu-servidor/app/public/`
- Inicia sesión con las credenciales del administrador creadas durante la instalación
- ¡Listo para usar!

## 🌐 Acceso a la Aplicación

### URLs de Acceso
- **Principal**: `http://tu-servidor/app/` - Redirige automáticamente a public/
- **Directo**: `http://tu-servidor/app/public/` - Acceso directo a la aplicación
- **Instalador**: `http://tu-servidor/app/install/` - Solo durante la instalación inicial

### Nota Importante
Después de eliminar `/install/`, el acceso a `http://tu-servidor/app/` funcionará sin mostrar listado de directorios.

## 📁 Estructura del Proyecto

```
rifapp-plus/
├── index.php              # ✅ Punto de entrada principal (redirige a public/)
├── .htaccess              # ✅ Configuración principal de Apache
├── app/                   # Aplicación principal
│   ├── Controllers/       # Controladores MVC
│   ├── Models/           # Modelos de datos
│   └── Views/            # Vistas y templates
├── config/               # Archivos de configuración
├── core/                 # Clases base del framework
├── install/              # ⚠️ Instalador (ELIMINAR después de instalar)
│   ├── views/            # Vistas del instalador
│   ├── index.php         # Controlador del instalador
│   └── README.md         # Documentación del instalador
├── public/               # Punto de entrada web
│   ├── .htaccess         # ✅ Configuración de ruteo
│   ├── assets/           # CSS, JS, imágenes
│   └── index.php         # Archivo principal de la aplicación
├── routes/               # Definición de rutas
├── scripts/              # Scripts SQL y utilidades
├── storage/              # Archivos de la aplicación
├── vendor/               # Dependencias de Composer
├── .env                  # Variables de entorno (generado en instalación)
├── .env.example          # Plantilla de variables de entorno
└── composer.json         # Dependencias PHP
```

### ⚠️ Importante - Directorio de Instalación

El directorio `/install/` contiene el asistente de instalación web. **DEBE ser eliminado después de completar la instalación** por razones de seguridad.
  - cURL (para composer)
- **Servidor Web**: Apache con mod_rewrite o Nginx
- **Composer**: Para gestión de dependencias

## 🛠️ Instalación

### 1. Clonar o descargar el proyecto

```bash
# Clonar en el directorio de tu servidor web (ej: xampp/htdocs)
git clone https://github.com/tu-usuario/rifas-chile.git
cd rifas-chile
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar permisos

```bash
# En sistemas Unix/Linux
chmod -R 755 storage/
chmod -R 755 public/assets/
chmod 644 .env.example

# Asegurar que el servidor web pueda escribir en storage/
chown -R www-data:www-data storage/
```

### 4. Ejecutar el asistente de instalación

1. Abre tu navegador y ve a: `http://tu-dominio.com/install`
2. Sigue el asistente paso a paso:
   - **Paso 1**: Verificación del sistema
   - **Paso 2**: Configuración de base de datos
   - **Paso 3**: Configuración de correo electrónico
   - **Paso 4**: Creación del super administrador
   - **Paso 5**: Finalización

### 5. Configuración adicional (opcional)

Después de la instalación, puedes configurar:

- **SEO**: Meta tags, sitemap, etc.
- **Analytics**: Google Analytics, Tag Manager, Facebook Pixel
- **Límites**: Cantidad de rifas por admin, vendedores por rifa
- **Páginas**: Políticas de privacidad, términos y condiciones

## 🔧 Configuración Manual (Avanzada)

Si prefieres configurar manualmente sin el asistente:

### 1. Crear archivo .env

```bash
cp .env.example .env
```

Editar `.env` con tu configuración:

```env
# Base de Datos
DB_HOST=localhost
DB_NAME=rifas_chile
DB_USER=tu_usuario
DB_PASSWORD=tu_password

# Email
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tudominio.cl
MAIL_FROM_NAME="Rifas Chile"

# Aplicación
APP_NAME="Sistema de Rifas Chile"
APP_URL=http://localhost/rifas-chile/public
APP_DEBUG=false
APP_TIMEZONE=America/Santiago
```

### 2. Crear base de datos

```sql
CREATE DATABASE rifas_chile CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Ejecutar migraciones

```bash
php scripts/migrate.php
```

### 4. Crear super administrador

```bash
php scripts/create_superadmin.php
```

## 🏃‍♂️ Uso del Sistema

### Panel Super Administrador

Acceso: `/superadmin/login`

**Funcionalidades:**
- Gestión completa de usuarios
- Configuración del sistema
- Configuración de seguridad y límites
- Impersonificación de usuarios (drill-down)
- Visualización de logs y auditoría
- Configuración SEO y Analytics

### Panel Administrador

Acceso: `/login` (registro público disponible)

**Funcionalidades:**
- Creación y gestión de rifas
- Asignación de vendedores
- Configuración de premios
- Estadísticas y reportes
- Gestión de ventas

### Panel Vendedor

Acceso: `/login` (creado por administradores)

**Funcionalidades:**
- Vista de rifas asignadas
- Venta de números
- Gestión de pagos (pagado/por pagar)
- Estadísticas personales

### Vistas Públicas

- Lista de rifas: `/rifas`
- Vista de rifa: `/rifas/nombre-de-la-rifa`
- Vista de vendedor: `/vendedor/nombre-vendedor`

## 🎨 Personalización

### Glassmorphism Theme

El sistema utiliza un diseño moderno con efectos de vidrio. Puedes personalizar:

- **Colores**: Editar variables CSS en `public/assets/css/app.css`
- **Efectos**: Modificar backdrop-filter y transparencias
- **Gradientes**: Personalizar los gradientes de fondo

### JavaScript Modular

- **ui.js**: Interacciones visuales, modales, toasts
- **logic.js**: Cálculos, validaciones, lógica de negocio

### Localización

Archivos de idioma en: `resources/lang/es/`

## 🔒 Seguridad

### Medidas Implementadas

- **Tokens CSRF** en todos los formularios
- **Hashing** de contraseñas con PHP password_hash()
- **Validación de entrada** en todos los campos
- **Sanitización** de datos de salida
- **Sesiones seguras** con regeneración de ID
- **Control de acceso** basado en roles
- **Rate limiting** en intentos de login

### Variables de Entorno

Todas las configuraciones sensibles se almacenan en `.env`:
- Credenciales de base de datos
- Configuración SMTP
- Claves de API
- Tokens de seguridad

## 📊 Base de Datos

### Estructura Principal

```
usuarios (Users)
├── rifas (Raffles)
│   ├── premios (Prizes)
│   ├── numeros_rifa (Raffle Numbers)
│   └── rifa_vendedores (Raffle Vendors)
├── ventas (Sales)
├── action_logs (Activity Logs)
├── paginas (Static Pages)
└── configuraciones (System Config)
```

### Eliminación Suave

El sistema implementa "soft deletes" - los registros se marcan como eliminados pero se mantienen para auditoría.

## 🚀 Producción

### Lista de Verificación

- [ ] Configurar `APP_DEBUG=false`
- [ ] Configurar SSL (HTTPS)
- [ ] Configurar backup de base de datos
- [ ] Configurar logs del servidor
- [ ] Configurar caché (Redis/Memcached)
- [ ] Optimizar imágenes
- [ ] Configurar CDN
- [ ] Monitoreo de rendimiento

### Mantenimiento

```bash
# Limpiar logs antiguos
php scripts/clean_logs.php

# Backup de base de datos
php scripts/backup_database.php

# Optimizar base de datos
php scripts/optimize_database.php
```

## 🐛 Solución de Problemas

### Problemas Comunes

**Error de permisos en storage/**
```bash
chmod -R 755 storage/
chown -R www-data:www-data storage/
```

**Error de conexión a base de datos**
- Verificar credenciales en `.env`
- Verificar que MySQL esté ejecutándose
- Verificar permisos del usuario de BD

**Emails no se envían**
- Verificar configuración SMTP en `.env`
- Verificar que el puerto SMTP esté abierto
- Para Gmail, usar contraseña de aplicación

**URLs no funcionan**
- Verificar que mod_rewrite esté habilitado
- Verificar configuración de `.htaccess`
- Verificar `APP_URL` en `.env`

### Logs del Sistema

Los logs se almacenan en:
- `storage/logs/actions.log` - Actividad del usuario
- `storage/logs/errors.log` - Errores del sistema
- `storage/logs/emails.log` - Log de emails enviados

## 📝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE.md](LICENSE.md) para detalles.

## 📞 Soporte

Para soporte técnico:
- **Email**: soporte@rifaschile.cl
- **Documentación**: [docs.rifaschile.cl](https://docs.rifaschile.cl)
- **Issues**: [GitHub Issues](https://github.com/tu-usuario/rifas-chile/issues)

---

**Rifas Chile** - Sistema de gestión de rifas hecho en Chile, para Chile 🇨🇱
