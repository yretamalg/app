<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración General - RifApp Plus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-lg w-full">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Configuración General</h1>
                <p class="text-gray-300">Configura los ajustes básicos de la aplicación</p>
            </div>

            <!-- Progress -->
            <div class="mb-6">
                <div class="flex justify-between text-xs text-gray-400 mb-2">
                    <span class="text-blue-300">Bienvenida</span>
                    <span class="text-blue-300">Requisitos</span>
                    <span class="text-blue-300">Base de Datos</span>
                    <span class="text-blue-300">Administrador</span>
                    <span class="text-blue-300">Configuración</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full" style="width: 100%"></div>
                </div>
            </div>

            <!-- Messages -->
            <?php if ($error): ?>
                <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-300 rounded-xl text-red-100">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-4 p-4 bg-green-500 bg-opacity-20 border border-green-300 rounded-xl text-green-100">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <!-- Config Form -->
            <form method="POST" action="?step=config">
                <h2 class="text-lg font-semibold text-white mb-4">Configuración de la Aplicación</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Nombre de la Aplicación
                        </label>
                        <input type="text" name="app_name" value="<?php echo $_POST['app_name'] ?? 'RifApp Plus'; ?>" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="RifApp Plus">
                        <p class="text-xs text-gray-400 mt-1">Este nombre aparecerá en toda la aplicación</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                            </svg>
                            URL de la Aplicación
                        </label>
                        <input type="url" name="app_url" value="<?php echo $_POST['app_url'] ?? 'http://localhost/app'; ?>" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="http://localhost/app">
                        <p class="text-xs text-gray-400 mt-1">URL completa donde estará alojada la aplicación</p>
                    </div>
                </div>

                <h3 class="text-md font-semibold text-white mt-6 mb-4">Configuración de Email (Opcional)</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Servidor SMTP
                        </label>
                        <input type="text" name="mail_host" value="<?php echo $_POST['mail_host'] ?? 'smtp.gmail.com'; ?>"
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="smtp.gmail.com">
                        <p class="text-xs text-gray-400 mt-1">Para Gmail: smtp.gmail.com, para Outlook: smtp-mail.outlook.com</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Puerto SMTP</label>
                            <input type="number" name="mail_port" value="<?php echo $_POST['mail_port'] ?? '587'; ?>"
                                   class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                   placeholder="587">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Nombre del Remitente</label>
                            <input type="text" name="mail_from_name" value="<?php echo $_POST['mail_from_name'] ?? 'RifApp Plus'; ?>"
                                   class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                   placeholder="RifApp Plus">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email de Usuario SMTP</label>
                        <input type="email" name="mail_username" value="<?php echo $_POST['mail_username'] ?? ''; ?>"
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="tu-email@gmail.com">
                        <p class="text-xs text-gray-400 mt-1">Email desde el cual se enviarán las notificaciones</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Contraseña SMTP</label>
                        <input type="password" name="mail_password" value="<?php echo $_POST['mail_password'] ?? ''; ?>"
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Contraseña o App Password">
                        <p class="text-xs text-gray-400 mt-1">Para Gmail, usa una "Contraseña de Aplicación"</p>
                    </div>
                </div>

                <!-- Skip Email Notice -->
                <div class="glassmorphism rounded-xl p-4 mt-6 border-l-4 border-blue-400">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-blue-300 font-medium text-sm">Configuración de Email</h3>
                            <p class="text-gray-300 text-xs mt-1">
                                Puedes configurar el email más tarde desde el panel de administración. 
                                La aplicación funcionará sin configuración de email.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex space-x-4 mt-6">
                    <a href="?step=admin" class="flex-1 px-4 py-2 bg-gray-600 bg-opacity-50 hover:bg-opacity-70 text-white font-medium rounded-lg transition-all duration-200 text-center">
                        Atrás
                    </a>
                    
                    <button type="submit" class="flex-1 px-4 py-2 bg-green-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                        Finalizar Configuración
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                RifApp Plus v1.0 - Configuración General
            </div>
        </div>
    </div>
</body>
</html>
