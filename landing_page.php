<?php
$_GET['page'] = 'dashboard';
require __DIR__ . '/layout.php';
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NutriGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900 font-sans">
    <main class="min-h-screen flex items-center justify-center px-6">
        <section class="max-w-3xl text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">NUTRI-GUARD</h1>
            <p class="text-gray-600 text-lg mb-8">Predictive Community Health Monitoring for early malnutrition detection.</p>
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="index.php?page=dashboard" class="px-6 py-3 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">Open Dashboard</a>
                <a href="index.php?page=analytics" class="px-6 py-3 rounded-lg border border-gray-300 hover:border-gray-400">View Analytics</a>
            </div>
        </section>
    </main>
</body>
</html>
