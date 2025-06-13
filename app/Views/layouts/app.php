<!DOCTYPE html>
<html lang="es-CL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $csrfToken ?>">
    
    <title><?= $title ?? 'Rifas Chile' ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= $description ?? 'Sistema de gestión de rifas para Chile' ?>">
    <meta name="keywords" content="<?= $keywords ?? 'rifas, chile, sorteos, premios' ?>">
    
    <!-- Open Graph -->    <meta property="og:title" content="<?= $title ?? 'Rifas Chile' ?>">
    <meta property="og:description" content="<?= $description ?? 'Sistema de gestión de rifas para Chile' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= url(currentUrl()) ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Additional CSS -->
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="min-h-screen">
    
    <!-- Navigation -->
    <?php if ($isLoggedIn): ?>
        <?php $this->include('layouts.navigation'); ?>
    <?php endif; ?>    <!-- Main Content -->
    <main class="<?= $isLoggedIn ? 'ml-64 pt-16' : '' ?> min-h-screen p-6">        <!-- Security Warning -->
        <?php 
        $session = new Session();
        if ($session->getFlash('security_warning')): ?>
            <div class="mb-6 p-4 bg-red-600 bg-opacity-20 border border-red-400 rounded-lg backdrop-blur-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-red-300 font-bold">¡ADVERTENCIA DE SEGURIDAD!</h3>
                        <p class="text-red-100 text-sm mt-1"><?= $session->getFlash('security_warning') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
          <!-- Flash Messages -->
        <?php if ($session->getFlash('success')): ?>
            <div class="toast-success mb-6 p-4 rounded-lg">
                <p class="text-white"><?= $session->getFlash('success') ?></p>
            </div>
        <?php endif; ?>

        <?php if ($session->getFlash('message')): ?>
            <div class="toast-info mb-6 p-4 rounded-lg">
                <p class="text-white"><?= $session->getFlash('message') ?></p>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <?= $content ?>
    </main>

    <!-- Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Modals Container -->
    <div id="modals-container"></div>    <!-- JavaScript -->
    <script src="<?= asset('js/ui.js') ?>"></script>
    <script src="<?= asset('js/logic.js') ?>"></script>
    
    <!-- Additional JavaScript -->
    <?php if (isset($additionalJS)): ?>
        <?php foreach ($additionalJS as $js): ?>
            <script src="<?= $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Analytics Scripts -->
    <?php if (!empty($_ENV['GOOGLE_ANALYTICS_ID'])): ?>
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $_ENV['GOOGLE_ANALYTICS_ID'] ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?= $_ENV['GOOGLE_ANALYTICS_ID'] ?>');
        </script>
    <?php endif; ?>

    <?php if (!empty($_ENV['GOOGLE_TAG_MANAGER_ID'])): ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= $_ENV['GOOGLE_TAG_MANAGER_ID'] ?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif; ?>

    <?php if (!empty($_ENV['FACEBOOK_PIXEL_ID'])): ?>
        <!-- Facebook Pixel -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?= $_ENV['FACEBOOK_PIXEL_ID'] ?>');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=<?= $_ENV['FACEBOOK_PIXEL_ID'] ?>&ev=PageView&noscript=1"
        /></noscript>
    <?php endif; ?>

    <!-- Debug Panel (Only for SuperAdmins with debug enabled) -->
    <?php if ($_ENV['APP_DEBUG'] === 'true' && $this->hasRole('superadmin')): ?>
        <div id="debug-panel" class="fixed bottom-4 left-4 glass-card p-4 text-sm max-w-sm">
            <h4 class="font-bold text-white mb-2">🐛 Debug Panel</h4>
            <div class="text-gray-300 space-y-1">
                <p><strong>User:</strong> <?= $user['nombre'] ?? 'N/A' ?></p>
                <p><strong>Role:</strong> <?= $user['tipo'] ?? 'N/A' ?></p>
                <p><strong>Memory:</strong> <?= round(memory_get_usage() / 1024 / 1024, 2) ?> MB</p>
                <p><strong>Time:</strong> <?= round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 2) ?> ms</p>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>
