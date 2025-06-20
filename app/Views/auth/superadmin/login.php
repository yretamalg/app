<?php 
// Set page variables
$title = $title ?? 'SuperAdmin Login - Rifas Chile';
$meta_description = $meta_description ?? 'Panel de Control SuperAdmin';
?>

<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <!-- Background decoration -->
    <div class="absolute inset-0 bg-black opacity-50"></div>
    
    <!-- Floating bubbles for glassmorphism effect -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-red-400 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-white bg-opacity-20 backdrop-blur-sm border border-white border-opacity-30">
                <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-white">
                Acceso SuperAdmin
            </h2>
            <p class="mt-2 text-sm text-gray-300">
                Panel de control avanzado - Acceso restringido
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

            <form id="superAdminLoginForm" method="POST" action="<?= url('superadmin/login') ?>" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken ?? ''); ?>">
                
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none relative block w-full px-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                           placeholder="Email">
                </div>
                
                <div>
                    <label for="password" class="sr-only">Contraseña</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="appearance-none relative block w-full px-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 placeholder-gray-300 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent focus:bg-opacity-30 transition-all duration-200" 
                           placeholder="Contraseña">
                </div>

                <div>
                    <button type="submit" id="loginBtn" 
                            class="group relative w-full flex justify-center py-3 px-4 bg-gradient-to-r from-red-500 to-red-700 text-white hover:from-red-600 hover:to-red-800 transition-all duration-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-red-400 group-hover:text-red-300 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>
                        <span id="loginBtnText">Acceder</span>
                        <span id="loginBtnLoading" class="hidden">
                            <svg class="animate-spin ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verificando...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center mt-4">
            <p class="text-xs text-red-300">
                Acceso restringido solo para administradores autorizados
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('superAdminLoginForm');
    const btn = document.getElementById('loginBtn');
    const btnText = document.getElementById('loginBtnText');
    const btnLoading = document.getElementById('loginBtnLoading');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        btn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');

        // Submit form
        form.submit();
    });
});
</script>
