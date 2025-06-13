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
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= $title ?? 'Rifas Chile' ?>">
    <meta property="og:description" content="<?= $description ?? 'Sistema de gestión de rifas para Chile' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $_ENV['APP_URL'] . $_SERVER['REQUEST_URI'] ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= $this->asset('css/app.css') ?>">
    
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
    <?php endif; ?>

    <!-- Main Content -->
    <main class="<?= $isLoggedIn ? 'ml-64 pt-16' : '' ?> min-h-screen p-6">
        <!-- Flash Messages -->
        <?php if ($this->success()): ?>
            <div class="toast-success mb-6 p-4 rounded-lg">
                <p class="text-white"><?= $this->success() ?></p>
            </div>
        <?php endif; ?>

        <?php if ($this->message()): ?>
            <div class="toast-info mb-6 p-4 rounded-lg">
                <p class="text-white"><?= $this->message() ?></p>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <?= $content ?>
    </main>

    <!-- Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Modals Container -->
    <div id="modals-container"></div>

    <!-- JavaScript -->
    <script src="<?= $this->asset('js/ui.js') ?>"></script>
    <script src="<?= $this->asset('js/logic.js') ?>"></script>
    
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
