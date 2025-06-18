#!/bin/bash

# Script de Post-Despliegue para RifApp Plus
# Ejecutar después de subir los archivos al servidor

echo "🚀 Iniciando configuración post-despliegue de RifApp Plus..."
echo ""

# Verificar que estamos en el directorio correcto
if [ ! -f "index.php" ]; then
    echo "❌ Error: No se encontró index.php. Asegúrate de estar en el directorio rifapp/"
    exit 1
fi

echo "📂 Directorio actual: $(pwd)"
echo ""

# 1. Configurar archivo .env
echo "1️⃣ Configurando archivo .env..."
if [ -f ".env.production" ]; then
    cp .env.production .env
    echo "✅ Archivo .env configurado desde .env.production"
else
    echo "⚠️ No se encontró .env.production. Debes configurar .env manualmente."
fi
echo ""

# 2. Configurar permisos
echo "2️⃣ Configurando permisos..."
chmod -R 755 .
chmod -R 777 storage/
chmod 644 .env
chmod 644 .htaccess
echo "✅ Permisos configurados"
echo ""

# 3. Crear directorios necesarios
echo "3️⃣ Creando estructura de directorios..."
mkdir -p storage/logs
mkdir -p storage/sessions  
mkdir -p storage/cache
chmod -R 777 storage/
echo "✅ Directorios creados"
echo ""

# 4. Verificar composer
echo "4️⃣ Verificando Composer..."
if command -v composer &> /dev/null; then
    echo "✅ Composer encontrado, instalando dependencias..."
    composer install --no-dev --optimize-autoloader --no-interaction
    echo "✅ Dependencias instaladas"
else
    echo "⚠️ Composer no encontrado. Debes instalar las dependencias manualmente."
    echo "   Comando: composer install --no-dev --optimize-autoloader"
fi
echo ""

# 5. Verificar configuración
echo "5️⃣ Verificando configuración..."
if [ -f ".env" ]; then
    echo "✅ Archivo .env presente"
else
    echo "❌ Archivo .env no encontrado"
fi

if [ -f ".htaccess" ]; then
    echo "✅ Archivo .htaccess presente"
else
    echo "❌ Archivo .htaccess no encontrado"
fi

if [ -d "storage" ] && [ -w "storage" ]; then
    echo "✅ Directorio storage con permisos correctos"
else
    echo "❌ Problemas con directorio storage"
fi
echo ""

# 6. Información final
echo "🎉 Configuración completada!"
echo ""
echo "📋 Próximos pasos:"
echo "   1. Verificar URL: https://www.vbox.pro/rifapp/"
echo "   2. Ejecutar instalador: https://www.vbox.pro/rifapp/install/"
echo "   3. Completar configuración de base de datos"
echo ""
echo "📁 Rutas importantes:"
echo "   - Aplicación: $(pwd)"
echo "   - Logs: $(pwd)/storage/logs/"
echo "   - Configuración: $(pwd)/.env"
echo ""
echo "✅ ¡RifApp Plus está listo para usar!"
