<?php
// Set page variables
$title = $title ?? 'Crear Cuenta - Rifas Chile';
$meta_description = $meta_description ?? 'Crea tu cuenta en Rifas Chile y participa en nuestras rifas';
$page_class = $page_class ?? 'auth-page';
?>

<div class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <!-- Background decoration -->
    <div class="absolute inset-0 bg-black opacity-50"></div>
    
    <!-- Floating bubbles for glassmorphism effect -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-white bg-opacity-20 backdrop-blur-sm border border-white border-opacity-30">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-white">
                Únete a Rifas Chile
            </h2>
            <p class="mt-2 text-sm text-gray-300">
                Crea tu cuenta y participa en nuestras rifas
            </p>
        </div>

        <!-- Register Form -->
        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-3xl shadow-2xl border border-white border-opacity-20 p-8">
            <!-- Flash Messages -->
            <?php if (isset($_SESSION['flash'])): ?>
                <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                    <div class="mb-4 p-4 rounded-xl <?php echo $type === 'error' ? 'bg-red-500 bg-opacity-20 border border-red-300 text-red-100' : 'bg-green-500 bg-opacity-20 border border-green-300 text-green-100'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endforeach; ?>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form id="registerForm" method="POST" action="<?= url('auth/register') ?>" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken ?? ''); ?>">
                
                <!-- Nombre y Apellido -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="sr-only">Nombre</label>                        <input id="nombre" name="nombre" type="text" required autocomplete="given-name"
                               class="appearance-none relative block w-full px-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="Nombre"
                               value="<?php echo htmlspecialchars($_SESSION['old_input']['nombre'] ?? ''); ?>">
                    </div>
                    <div>
                        <label for="apellido" class="sr-only">Apellido</label>                        <input id="apellido" name="apellido" type="text" required autocomplete="family-name"
                               class="appearance-none relative block w-full px-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="Apellido"
                               value="<?php echo htmlspecialchars($_SESSION['old_input']['apellido'] ?? ''); ?>">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>                        <input id="email" name="email" type="email" required autocomplete="email"
                               class="appearance-none relative block w-full pl-10 pr-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="Correo electrónico"
                               value="<?php echo htmlspecialchars($_SESSION['old_input']['email'] ?? ''); ?>">
                    </div>
                </div>

                <!-- RUT y Teléfono -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="rut" class="sr-only">RUT</label>
                        <input id="rut" name="rut" type="text" required 
                               class="appearance-none relative block w-full px-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="RUT (ej: 12345678-9)"
                               value="<?php echo htmlspecialchars($_SESSION['old_input']['rut'] ?? ''); ?>">
                    </div>
                    <div>
                        <label for="telefono" class="sr-only">Teléfono</label>                        <input id="telefono" name="telefono" type="tel" autocomplete="tel"
                               class="appearance-none relative block w-full px-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="Teléfono (opcional)"
                               value="<?php echo htmlspecialchars($_SESSION['old_input']['telefono'] ?? ''); ?>">
                    </div>
                </div>

                <!-- Contraseñas -->
                <div>
                    <label for="password" class="sr-only">Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="appearance-none relative block w-full pl-10 pr-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="Contraseña (mín. 6 caracteres)">
                    </div>
                </div>

                <div>
                    <label for="password_confirm" class="sr-only">Confirmar Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>                        <input id="password_confirm" name="password_confirm" type="password" required autocomplete="new-password"
                               class="appearance-none relative block w-full pl-10 pr-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="Confirmar contraseña">
                    </div>
                </div>

                <!-- Términos y condiciones -->
                <div class="flex items-center">
                    <input id="acepta_terminos" name="acepta_terminos" type="checkbox" required
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded bg-white bg-opacity-20">                    <label for="acepta_terminos" class="ml-2 block text-sm text-gray-300">
                        Acepto los 
                        <a href="<?= url('terminos') ?>" target="_blank" class="font-medium text-blue-300 hover:text-blue-200 transition-colors">
                            términos y condiciones
                        </a>
                        y 
                        <a href="<?= url('privacidad') ?>" target="_blank" class="font-medium text-blue-300 hover:text-blue-200 transition-colors">
                            política de privacidad
                        </a>
                    </label>
                </div>

                <div>
                    <button type="submit" id="registerBtn"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-green-600 bg-opacity-80 hover:bg-opacity-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 backdrop-blur-sm">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-green-300 group-hover:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </span>
                        <span id="registerBtnText">Crear Cuenta</span>
                        <span id="registerBtnLoading" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="text-center">                    <p class="text-sm text-gray-300">
                        ¿Ya tienes cuenta? 
                        <a href="<?= url('login') ?>" class="font-medium text-blue-300 hover:text-blue-200 transition-colors">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Back to home -->
        <div class="text-center">
            <a href="<?= url('') ?>" class="text-sm text-gray-400 hover:text-gray-300 transition-colors flex items-center justify-center">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al inicio
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const btn = document.getElementById('registerBtn');
    const btnText = document.getElementById('registerBtnText');
    const btnLoading = document.getElementById('registerBtnLoading');
    const rutInput = document.getElementById('rut');

    // RUT formatting
    rutInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9kK]/g, '');
        if (value.length > 1) {
            value = value.slice(0, -1) + '-' + value.slice(-1);
        }
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        e.target.value = value;
    });

    // Password confirmation validation
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');
    
    function validatePasswords() {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Las contraseñas no coinciden');
        } else {
            passwordConfirm.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePasswords);
    passwordConfirm.addEventListener('keyup', validatePasswords);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        btn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');        const formData = new FormData(form);
          fetch('<?= url("auth/register") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="csrf_token"]').value
            },
            credentials: 'include' // Use 'include' to ensure cookies are sent with cross-origin requests
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (typeof UI !== 'undefined') {
                    UI.showNotification(data.message, 'success');
                } else {
                    alert(data.message);
                }
                setTimeout(() => {
                    window.location.href = data.redirect || '/login';
                }, 2000);
            } else {
                // Show error
                if (typeof UI !== 'undefined') {
                    UI.showNotification(data.message, 'error');
                } else {
                    alert(data.message);
                }
                
                // Reset button
                btn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        })        .catch(error => {
            console.error('Error:', error);
            console.error('Error details:', {
                message: error.message,
                stack: error.stack
            });
            if (typeof UI !== 'undefined') {
                UI.showNotification('Error de conexión. Intenta nuevamente.', 'error');
            } else {
                alert('Error de conexión. Intenta nuevamente.');
            }
            
            // Reset button
            btn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
        });
    });
});
</script>

<?php
// Clear old input after displaying
unset($_SESSION['old_input']);
?>
