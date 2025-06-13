# Páginas de Error - RifApp Plus

Este directorio contiene páginas de error especializadas para problemas de base de datos y conexión.

## Páginas de Error

### `connection_error.php`
**Cuándo se muestra:** Cuando la aplicación no puede conectarse a MySQL.

**Problemas que resuelve:**
- MySQL no está ejecutándose
- Credenciales incorrectas en `.env`
- Base de datos no existe
- Puerto o host incorrectos

**Características:**
- Muestra la configuración actual de `.env`
- Proporciona comandos de diagnóstico
- Enlaces a phpMyAdmin y reinstalador
- Interfaz Glassmorphism consistente

### `database_error.php`
**Cuándo se muestra:** Cuando hay conexión a MySQL pero faltan las tablas necesarias.

**Problemas que resuelve:**
- Instalación incompleta
- Tablas eliminadas accidentalmente
- Base de datos vacía
- Esquema corrupto

**Características:**
- Lista las tablas requeridas y su estado
- Opción de reinstalación automática
- Enlace directo a phpMyAdmin
- Instrucciones de importación manual

## Flujo de Manejo de Errores

```
public/index.php
├── No hay .env → Redirige a /install/
├── Hay .env pero no conecta DB → connection_error.php
├── Conecta DB pero no hay tablas → database_error.php
└── Todo OK → Aplicación normal
```

## Personalización

Estas páginas pueden ser personalizadas modificando:
- Colores del degradado de fondo
- Mensajes de error específicos
- Enlaces de acción
- Comandos de diagnóstico

## Integración

Estas páginas se integran con:
- Sistema de instalación (`/install/`)
- Configuración de entorno (`.env`)
- phpMyAdmin para gestión de DB
- Sistema de logging de errores
