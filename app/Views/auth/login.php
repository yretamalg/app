<?php
// Set page variables
$title = $title ?? 'Iniciar Sesión - Rifas Chile';
$meta_description = $meta_description ?? 'Inicia sesión en tu cuenta de Rifas Chile';
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-white">
                Bienvenido de vuelta
            </h2>
            <p class="mt-2 text-sm text-gray-300">
                Inicia sesión en tu cuenta de Rifas Chile
            </p>
        </div>

        <!-- Login Form -->
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

            <form id="loginForm" method="POST" action="<?= url('auth/login') ?>" class="space-y-6">
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
                               placeholder="Correo electrónico"
                               value="<?php echo htmlspecialchars($_SESSION['old_input']['email'] ?? ''); ?>">
                    </div>
                </div>

                <div>
                    <label for="password" class="sr-only">Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required 
                               class="appearance-none relative block w-full pl-10 pr-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                               placeholder="Contraseña">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded bg-white bg-opacity-20">
                        <label for="remember" class="ml-2 block text-sm text-gray-300">
                            Recordarme
                        </label>
                    </div>                    <div class="text-sm">
                        <a href="<?= url('forgot-password') ?>" class="font-medium text-blue-300 hover:text-blue-200 transition-colors">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" id="loginBtn"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-blue-600 bg-opacity-80 hover:bg-opacity-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 backdrop-blur-sm">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                        </span>
                        <span id="loginBtnText">Iniciar Sesión</span>
                        <span id="loginBtnLoading" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>                <div class="text-center">
                    <p class="text-sm text-gray-300">
                        ¿No tienes cuenta? 
                        <a href="<?= url('register') ?>" class="font-medium text-blue-300 hover:text-blue-200 transition-colors">
                            Regístrate aquí
                        </a>
                    </p>
                </div>
            </form>
        </div>        <!-- Back to home -->
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
    const form = document.getElementById('loginForm');
    const btn = document.getElementById('loginBtn');
    const btnText = document.getElementById('loginBtnText');
    const btnLoading = document.getElementById('loginBtnLoading');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        btn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');

        const formData = new FormData(form);
          fetch('<?= url("auth/login") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="csrf_token"]').value
            },
            credentials: 'include' // Ensure cookies are sent
        })
        .then(response => response.json())
        .then(data => {            if (data.success) {
                window.location.href = data.redirect || url('dashboard');
            } else {
                // Show error
                if (typeof rifasUI !== 'undefined') {
                    rifasUI.showNotification(data.message, 'error');
                } else {
                    alert(data.message);
                }
                
                // Reset button
                btn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof rifasUI !== 'undefined') {
                rifasUI.showNotification('Error de conexión. Intenta nuevamente.', 'error');
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
