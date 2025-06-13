<?php
// Set page variables
$title = $title ?? 'Recuperar Contraseña - Rifas Chile';
$meta_description = $meta_description ?? 'Recupera tu contraseña de Rifas Chile';
$page_class = $page_class ?? 'auth-page';
?>

<div class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 flex items-center justify-center px-4 sm:px-6 lg:px-8">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-white">
                Recuperar Contraseña
            </h2>
            <p class="mt-2 text-sm text-gray-300">
                Te enviaremos un enlace para restablecer tu contraseña
            </p>
        </div>

        <!-- Forgot Password Form -->
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

            <form id="forgotPasswordForm" method="POST" action="/auth/forgot-password" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken ?? ''); ?>">
                
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" required 
                               class="appearance-none relative block w-full pl-10 pr-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="Ingresa tu correo electrónico"
                               value="<?php echo htmlspecialchars($_SESSION['old_input']['email'] ?? ''); ?>">
                    </div>
                </div>

                <div>
                    <button type="submit" id="forgotPasswordBtn"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-orange-600 bg-opacity-80 hover:bg-opacity-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 backdrop-blur-sm">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-orange-300 group-hover:text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                        <span id="forgotPasswordBtnText">Enviar Enlace de Recuperación</span>
                        <span id="forgotPasswordBtnLoading" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="text-center space-y-2">
                    <p class="text-sm text-gray-300">
                        ¿Recordaste tu contraseña? 
                        <a href="/login" class="font-medium text-blue-300 hover:text-blue-200 transition-colors">
                            Inicia sesión
                        </a>
                    </p>
                    <p class="text-sm text-gray-300">
                        ¿No tienes cuenta? 
                        <a href="/register" class="font-medium text-green-300 hover:text-green-200 transition-colors">
                            Regístrate aquí
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Information Box -->
        <div class="bg-blue-500 bg-opacity-20 backdrop-blur-sm rounded-2xl border border-blue-300 border-opacity-30 p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-200">
                        ¿Cómo funciona?
                    </h3>
                    <div class="mt-2 text-sm text-blue-100">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Ingresa tu correo electrónico registrado</li>
                            <li>Recibirás un enlace seguro en tu email</li>
                            <li>El enlace expira en 1 hora por seguridad</li>
                            <li>Crea una nueva contraseña y listo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to home -->
        <div class="text-center">
            <a href="/" class="text-sm text-gray-400 hover:text-gray-300 transition-colors flex items-center justify-center">
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
    const form = document.getElementById('forgotPasswordForm');
    const btn = document.getElementById('forgotPasswordBtn');
    const btnText = document.getElementById('forgotPasswordBtnText');
    const btnLoading = document.getElementById('forgotPasswordBtnLoading');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        btn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');

        const formData = new FormData(form);
        
        fetch('/auth/forgot-password', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                UI.showNotification(data.message, 'success');
                // Clear form
                form.reset();
            } else {
                // Show error
                UI.showNotification(data.message, 'error');
            }
            
            // Reset button
            btn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            UI.showNotification('Error de conexión. Intenta nuevamente.', 'error');
            
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
