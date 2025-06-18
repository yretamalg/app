# Script de despliegue para RifApp Plus en cPanel (PowerShell)
# Servidor: vbox.pro
# Usuario: mediamat
# Directorio: /home2/mediamat/rifapp

Write-Host "=== Iniciando despliegue de RifApp Plus ===" -ForegroundColor Green

# Variables de configuración
$REMOTE_USER = "mediamat"
$REMOTE_HOST = "vbox.pro"
$REMOTE_PATH = "/home2/mediamat/rifapp"

Write-Host "Servidor: $REMOTE_HOST" -ForegroundColor Yellow
Write-Host "Usuario: $REMOTE_USER" -ForegroundColor Yellow
Write-Host "Directorio remoto: $REMOTE_PATH" -ForegroundColor Yellow
Write-Host ""

# Función para ejecutar comando SSH
function Invoke-SSHCommand {
    param($Command)
    Write-Host "Ejecutando: $Command" -ForegroundColor Cyan
    $result = ssh "$REMOTE_USER@$REMOTE_HOST" $Command 2>&1
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Error ejecutando comando: $Command" -ForegroundColor Red
        Write-Host $result -ForegroundColor Red
    } else {
        Write-Host $result -ForegroundColor Gray
    }
}

# Función para copiar archivos
function Copy-ToServer {
    param($LocalPath, $RemotePath)
    Write-Host "Copiando $LocalPath a $RemotePath..." -ForegroundColor Cyan
    scp -r "$LocalPath" "$REMOTE_USER@$REMOTE_HOST`:$RemotePath" 2>&1
}

try {    # 1. Crear directorio remoto
    Write-Host "1. Creando directorio remoto..." -ForegroundColor Blue
    Invoke-SSHCommand "mkdir -p $REMOTE_PATH"    # 2. Copiar archivos principales
    Write-Host "2. Copiando archivos principales..." -ForegroundColor Blue
    
    # Usar scp para transferir archivos (más compatible)
    $itemsToCopy = @(
        "app",
        "config", 
        "core",
        "public",
        "resources",
        "routes",
        "storage",
        "scripts",
        "index.php",
        ".htaccess",
        "composer.json"
    )
    
    if (Test-Path "composer.lock") {
        $itemsToCopy += "composer.lock"
    }
    
    foreach ($item in $itemsToCopy) {
        if (Test-Path $item) {
            Write-Host "Copiando $item..." -ForegroundColor Gray
            if (Test-Path $item -PathType Container) {
                # Es un directorio
                scp -r "$item" "$REMOTE_USER@$REMOTE_HOST`:$REMOTE_PATH/" 2>$null
            } else {
                # Es un archivo
                scp "$item" "$REMOTE_USER@$REMOTE_HOST`:$REMOTE_PATH/" 2>$null
            }
        }
    }

    # 3. Copiar archivo .env de producción
    Write-Host "3. Configurando archivo .env..." -ForegroundColor Blue
    Copy-ToServer ".env.production" "$REMOTE_PATH/.env"    # 4. Configurar permisos
    Write-Host "4. Configurando permisos..." -ForegroundColor Blue
    Invoke-SSHCommand "cd $REMOTE_PATH && chmod -R 755 ."
    Invoke-SSHCommand "cd $REMOTE_PATH && chmod -R 777 storage/"
    Invoke-SSHCommand "cd $REMOTE_PATH && chmod 644 .env"
    Invoke-SSHCommand "cd $REMOTE_PATH && chmod 644 .htaccess"

    # 5. Crear directorios necesarios
    Write-Host "5. Creando directorios necesarios..." -ForegroundColor Blue
    Invoke-SSHCommand "cd $REMOTE_PATH && mkdir -p storage/logs storage/sessions storage/cache"

    # 6. Instalar dependencias (si existe composer)
    Write-Host "6. Verificando composer..." -ForegroundColor Blue
    Invoke-SSHCommand "cd $REMOTE_PATH && if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; fi"

    Write-Host ""
    Write-Host "=== Despliegue completado exitosamente ===" -ForegroundColor Green
    Write-Host "Siguiente paso: Acceder a https://vbox.pro/rifapp/install para configurar la base de datos" -ForegroundColor Yellow
    Write-Host ""

} catch {
    Write-Host "Error durante el despliegue: $_" -ForegroundColor Red
}
