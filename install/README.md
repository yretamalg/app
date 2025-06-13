# Directorio de Instalación - RifApp Plus

## ⚠️ IMPORTANTE - SEGURIDAD

**Este directorio debe ser ELIMINADO después de completar la instalación.**

## ¿Por qué eliminar este directorio?

1. **Seguridad**: Los atacantes pueden usar el instalador para reinstalar la aplicación
2. **Acceso no autorizado**: Puede permitir acceso a configuraciones sensibles
3. **Mejores prácticas**: Es estándar en aplicaciones web eliminar instaladores después del uso

## Cómo eliminar este directorio

### En Windows (PowerShell o CMD):
```powershell
rmdir /s "c:\xampp\htdocs\app\install"
```

### En Linux/Mac:
```bash
rm -rf /path/to/app/install/
```

## Estructura del Instalador

```
install/
├── index.php              # Controlador principal del instalador
├── .htaccess              # Configuración de seguridad
├── README.md              # Este archivo
└── views/                 # Vistas del proceso de instalación
    ├── welcome.php        # Página de bienvenida
    ├── requirements.php   # Verificación de requisitos
    ├── database.php       # Configuración de base de datos
    ├── admin.php          # Creación de usuario administrador
    ├── config.php         # Configuración general
    ├── install.php        # Proceso de instalación
    ├── complete.php       # Instalación completada
    └── already_installed.php # Error si ya está instalado
```

## Proceso de Instalación

1. **Bienvenida**: Introducción al sistema
2. **Requisitos**: Verificación de sistema (PHP, extensiones, permisos)
3. **Base de Datos**: Configuración y prueba de conexión MySQL
4. **Administrador**: Creación del usuario administrador inicial
5. **Configuración**: Ajustes de aplicación y email
6. **Instalación**: Creación de .env, importación de esquema, usuario admin
7. **Completado**: Instrucciones finales y advertencia de eliminar /install/

## Características del Instalador

- ✅ Verificación de requisitos del sistema
- ✅ Prueba de conexión a base de datos
- ✅ Creación automática de base de datos
- ✅ Importación del esquema SQL
- ✅ Generación segura de claves
- ✅ Configuración de timezone chileno
- ✅ Validaciones de formularios
- ✅ Interfaz responsive con Glassmorphism
- ✅ Manejo de errores detallado
- ✅ Advertencias de seguridad

## Después de la Instalación

1. **Elimina este directorio inmediatamente**
2. Accede a la aplicación desde `/public/`
3. Inicia sesión con las credenciales del administrador
4. Configura ajustes adicionales desde el panel de administración

## Soporte

Si tienes problemas con la instalación, revisa:
- Los logs de PHP
- Los logs de MySQL/MariaDB
- Los permisos de directorios
- La configuración de tu servidor web

---

**RifApp Plus v1.0** - Sistema de Gestión de Rifas para Chile
