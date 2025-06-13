<!DOCTYPE html>
<html lang="es-CL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - Rifas Chile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    
    <div class="glass max-w-2xl w-full p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Rifas Chile</h1>
            <p class="text-gray-300">Asistente de Instalación</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between text-sm text-gray-300 mb-2">
                <span>Paso 1 de 5</span>
                <span id="progress-text">Verificación del Sistema</span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-2">
                <div id="progress-bar" class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full transition-all duration-300" style="width: 20%"></div>
            </div>
        </div>

        <!-- Installation Steps -->
        <div id="installation-container">
            
            <!-- Step 1: System Check -->
            <div id="step-1" class="installation-step">
                <h2 class="text-2xl font-semibold text-white mb-6">🔧 Verificación del Sistema</h2>
                
                <div class="space-y-4 mb-6">
                    <p class="text-gray-300">
                        Verificaremos que tu servidor cumple con todos los requisitos necesarios para ejecutar Rifas Chile.
                    </p>
                    
                    <div class="glass p-4">
                        <h3 class="text-white font-medium mb-3">Requisitos del Sistema:</h3>
                        <ul class="text-gray-300 space-y-2">
                            <li>✓ PHP 7.4 o superior</li>
                            <li>✓ Extensión PDO MySQL</li>
                            <li>✓ Extensión OpenSSL</li>
                            <li>✓ Extensión Fileinfo</li>
                            <li>✓ Permisos de escritura en directorios</li>
                        </ul>
                    </div>
                </div>

                <button onclick="startSystemCheck()" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-6 rounded-lg font-medium hover:from-blue-600 hover:to-purple-700 transition-all">
                    Verificar Sistema
                </button>
            </div>

            <!-- Step 2: Database Configuration -->
            <div id="step-2" class="installation-step hidden">
                <h2 class="text-2xl font-semibold text-white mb-6">🗄️ Configuración de Base de Datos</h2>
                
                <form id="database-form" class="space-y-4">
                    <div>
                        <label class="block text-white font-medium mb-2">Servidor de Base de Datos</label>
                        <input type="text" name="db_host" value="localhost" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Nombre de la Base de Datos</label>
                        <input type="text" name="db_name" value="rifas_chile" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Usuario de Base de Datos</label>
                        <input type="text" name="db_user" value="root" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Contraseña de Base de Datos</label>
                        <input type="password" name="db_password" 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-6 rounded-lg font-medium hover:from-blue-600 hover:to-purple-700 transition-all">
                        Probar Conexión
                    </button>
                </form>
            </div>

            <!-- Step 3: Email Configuration -->
            <div id="step-3" class="installation-step hidden">
                <h2 class="text-2xl font-semibold text-white mb-6">📧 Configuración de Correo</h2>
                
                <form id="email-form" class="space-y-4">
                    <div>
                        <label class="block text-white font-medium mb-2">Servidor SMTP</label>
                        <input type="text" name="mail_host" value="smtp.gmail.com" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Puerto SMTP</label>
                        <input type="number" name="mail_port" value="587" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Usuario SMTP (Email)</label>
                        <input type="email" name="mail_username" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Contraseña SMTP</label>
                        <input type="password" name="mail_password" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Encriptación</label>
                        <select name="mail_encryption" required 
                                class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Nombre del Remitente</label>
                        <input type="text" name="mail_from_name" value="Rifas Chile" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-6 rounded-lg font-medium hover:from-blue-600 hover:to-purple-700 transition-all">
                        Probar Configuración
                    </button>
                </form>
            </div>

            <!-- Step 4: Super Admin Configuration -->
            <div id="step-4" class="installation-step hidden">
                <h2 class="text-2xl font-semibold text-white mb-6">👤 Super Administrador</h2>
                
                <form id="admin-form" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-white font-medium mb-2">Nombre</label>
                            <input type="text" name="admin_nombre" required 
                                   class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-white font-medium mb-2">Apellidos</label>
                            <input type="text" name="admin_apellidos" required 
                                   class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Email</label>
                        <input type="email" name="admin_email" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">RUT</label>
                        <input type="text" name="admin_rut" data-rut required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                               placeholder="12.345.678-9">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Teléfono</label>
                        <input type="tel" name="admin_telefono" required 
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                               placeholder="+56 9 1234 5678">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Contraseña</label>
                        <input type="password" name="admin_password" required minlength="6"
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Confirmar Contraseña</label>
                        <input type="password" name="admin_password_confirmation" required minlength="6"
                               class="w-full bg-white bg-opacity-10 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-6 rounded-lg font-medium hover:from-blue-600 hover:to-purple-700 transition-all">
                        Crear Super Administrador
                    </button>
                </form>
            </div>

            <!-- Step 5: Completion -->
            <div id="step-5" class="installation-step hidden text-center">
                <h2 class="text-2xl font-semibold text-white mb-6">🎉 Instalación Completada</h2>
                
                <div class="glass p-6 mb-6">
                    <div class="text-6xl mb-4">✅</div>
                    <h3 class="text-xl font-medium text-white mb-2">¡Rifas Chile está listo!</h3>
                    <p class="text-gray-300">La instalación se ha completado exitosamente.</p>
                </div>

                <div class="space-y-4">
                    <p class="text-gray-300">
                        Tu sistema de rifas está configurado y listo para usar. Puedes acceder al panel de super administrador para comenzar a configurar tu primera rifa.
                    </p>
                    
                    <div class="glass p-4 text-left">
                        <h4 class="text-white font-medium mb-2">Próximos pasos:</h4>
                        <ul class="text-gray-300 space-y-1 text-sm">
                            <li>• Configurar páginas de políticas y términos</li>
                            <li>• Crear administradores y vendedores</li>
                            <li>• Configurar SEO y analytics</li>
                            <li>• Crear tu primera rifa</li>
                        </ul>
                    </div>
                </div>

                <a href="/superadmin/login" class="inline-block bg-gradient-to-r from-green-500 to-blue-600 text-white py-3 px-8 rounded-lg font-medium hover:from-green-600 hover:to-blue-700 transition-all mt-6">
                    Acceder al Panel de Administración
                </a>
            </div>
        </div>

        <!-- Messages -->
        <div id="messages" class="mt-6 hidden">
            <div id="error-message" class="bg-red-500 bg-opacity-20 border border-red-500 text-red-200 p-4 rounded-lg hidden">
                <span id="error-text"></span>
            </div>
            <div id="success-message" class="bg-green-500 bg-opacity-20 border border-green-500 text-green-200 p-4 rounded-lg hidden">
                <span id="success-text"></span>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 5;

        function updateProgress(step) {
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            
            const percentage = (step / totalSteps) * 100;
            progressBar.style.width = percentage + '%';
            
            const stepTexts = [
                '', 'Verificación del Sistema', 'Configuración de Base de Datos', 
                'Configuración de Correo', 'Super Administrador', 'Completado'
            ];
            progressText.textContent = stepTexts[step];
        }

        function showStep(step) {
            // Hide all steps
            document.querySelectorAll('.installation-step').forEach(el => {
                el.classList.add('hidden');
            });
            
            // Show current step
            document.getElementById(`step-${step}`).classList.remove('hidden');
            
            updateProgress(step);
            currentStep = step;
        }

        function showMessage(message, type = 'error') {
            const messagesContainer = document.getElementById('messages');
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            
            messagesContainer.classList.remove('hidden');
            
            if (type === 'error') {
                document.getElementById('error-text').textContent = message;
                errorMessage.classList.remove('hidden');
                successMessage.classList.add('hidden');
            } else {
                document.getElementById('success-text').textContent = message;
                successMessage.classList.remove('hidden');
                errorMessage.classList.add('hidden');
            }
        }

        function hideMessages() {
            document.getElementById('messages').classList.add('hidden');
            document.getElementById('error-message').classList.add('hidden');
            document.getElementById('success-message').classList.add('hidden');
        }

        async function processStep(step, formData = null) {
            const data = formData || new FormData();
            data.append('step', step);

            try {
                const response = await fetch('/install', {
                    method: 'POST',
                    body: data
                });

                const result = await response.json();

                if (result.success) {
                    if (result.message) {
                        showMessage(result.message, 'success');
                    }
                    
                    if (result.next_step) {
                        setTimeout(() => {
                            hideMessages();
                            showStep(result.next_step);
                        }, 1500);
                    } else if (result.redirect) {
                        window.location.href = result.redirect;
                    }
                } else {
                    showMessage(result.message || 'Error en la instalación');
                }
            } catch (error) {
                showMessage('Error de conexión: ' + error.message);
            }
        }

        function startSystemCheck() {
            processStep(1);
        }

        // Form handlers
        document.getElementById('database-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            processStep(2, formData);
        });

        document.getElementById('email-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            processStep(3, formData);
        });

        document.getElementById('admin-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = this.admin_password.value;
            const confirmation = this.admin_password_confirmation.value;
            
            if (password !== confirmation) {
                showMessage('Las contraseñas no coinciden');
                return;
            }
            
            const formData = new FormData(this);
            processStep(4, formData);
        });

        // RUT formatting
        document.addEventListener('input', function(e) {
            if (e.target.hasAttribute('data-rut')) {
                e.target.value = formatRUT(e.target.value);
            }
        });

        function formatRUT(value) {
            let rut = value.replace(/[^0-9kK]/g, '');
            if (rut.length <= 1) return rut;
            
            let dv = rut.slice(-1);
            let number = rut.slice(0, -1);
            
            if (number.length > 3) {
                number = number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            
            return number + '-' + dv;
        }
    </script>

</body>
</html>
