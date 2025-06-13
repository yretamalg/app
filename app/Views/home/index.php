<?php
// Set page variables
$title = $title ?? 'Rifas Chile - Participa y Gana';
$meta_description = $meta_description ?? 'La plataforma líder de rifas en Chile. Participa en rifas seguras y transparentes con premios increíbles.';
?>

<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    
    <!-- Floating bubbles for glassmorphism effect -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6">
                <span class="block">Rifas Chile</span>
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                    Tu suerte nos conecta
                </span>
            </h1>
            <p class="max-w-3xl mx-auto text-xl text-gray-300 mb-8">
                La plataforma más segura y transparente de Chile para participar en rifas. 
                Premios increíbles, sorteos en vivo y total transparencia.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/rifas" 
                   class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-white bg-blue-600 bg-opacity-80 hover:bg-opacity-100 backdrop-blur-sm transition-all duration-200 transform hover:scale-105">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Ver Rifas Activas
                </a>
                <?php if (!$isLoggedIn): ?>
                <a href="/register" 
                   class="inline-flex items-center px-8 py-4 border border-white border-opacity-30 text-lg font-medium rounded-xl text-white bg-white bg-opacity-10 hover:bg-opacity-20 backdrop-blur-sm transition-all duration-200">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Crear Cuenta Gratis
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                ¿Por qué elegir Rifas Chile?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Somos la plataforma más confiable y transparente para rifas en Chile
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Transparencia -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg p-8 text-center hover:transform hover:scale-105 transition-all duration-200">
                <div class="h-16 w-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">100% Transparente</h3>
                <p class="text-gray-600">
                    Todos nuestros sorteos son públicos y verificables. Puedes ver cada número vendido y el proceso de sorteo en tiempo real.
                </p>
            </div>

            <!-- Seguridad -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg p-8 text-center hover:transform hover:scale-105 transition-all duration-200">
                <div class="h-16 w-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Pagos Seguros</h3>
                <p class="text-gray-600">
                    Utilizamos tecnología de encriptación de última generación para proteger tus datos y transacciones.
                </p>
            </div>

            <!-- Premios -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg p-8 text-center hover:transform hover:scale-105 transition-all duration-200">
                <div class="h-16 w-16 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Premios Increíbles</h3>
                <p class="text-gray-600">
                    Desde artículos tecnológicos hasta vehículos y dinero en efectivo. Siempre tenemos premios que te van a emocionar.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                Números que nos respaldan
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-extrabold text-blue-600 mb-2">150+</div>
                <div class="text-gray-600">Rifas Realizadas</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-extrabold text-green-600 mb-2">5,000+</div>
                <div class="text-gray-600">Usuarios Activos</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-extrabold text-yellow-600 mb-2">98%</div>
                <div class="text-gray-600">Satisfacción</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-extrabold text-purple-600 mb-2">$50M+</div>
                <div class="text-gray-600">En Premios</div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-white mb-4">
                ¿Listo para probar tu suerte?
            </h2>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Únete a miles de chilenos que ya confían en nosotros. Tu próximo premio te está esperando.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if ($isLoggedIn): ?>
                    <a href="/dashboard" 
                       class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-blue-600 bg-white hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Ir a Mi Dashboard
                    </a>
                <?php else: ?>
                    <a href="/register" 
                       class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl text-blue-600 bg-white hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Crear Cuenta Ahora
                    </a>
                <?php endif; ?>
                <a href="/rifas" 
                   class="inline-flex items-center px-8 py-4 border border-white text-lg font-medium rounded-xl text-white hover:bg-white hover:bg-opacity-10 transition-all duration-200">
                    Explorar Rifas
                </a>
            </div>
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
