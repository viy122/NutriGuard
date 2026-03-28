<?php
require_once __DIR__ . '/backend/auth.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: pages/sign_in.php');
    exit;
}

$page = $_GET['page'] ?? 'dashboard';
$role = normalizeRoleCode((string) ($_SESSION['role'] ?? ''));
$validRoles = ['bns', 'bhw', 'hc_head'];

if (!in_array($role, $validRoles, true)) {
    $role = 'bns';
}

$rolePages = [];
$rolePageFiles = glob(__DIR__ . '/pages/' . $role . '/*.php') ?: [];
foreach ($rolePageFiles as $file) {
    $rolePages[] = pathinfo($file, PATHINFO_FILENAME);
}

if (!in_array($page, $rolePages, true)) {
    $page = 'dashboard';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRI-GUARD</title>

    <link rel="stylesheet" href="src/output.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />


    <!-- ✅ Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9faf7;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex-grow: 1;
            background-color: #fff;
            padding: 1.5rem;
            overflow-x: auto;
        }

        .nav-link.active {
            background-color: #10b981 !important;
            color: #fff !important;
            border-radius: 8px;
        }

        #page-loader {
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,0.85);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 9999;
        }
        .spinner {
            width: 3rem;
            height: 3rem;
            border: 4px solid rgba(16,185,129,0.18);
            border-top-color: #10b981;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        #page-loader p {
            margin-top: 10px;
            color: #10b981;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="layout-wrapper">
    <?php
    $sidebarInclude = __DIR__ . '/components/sidebar.php';

    if (file_exists($sidebarInclude)) {
        include $sidebarInclude;
    }
    ?>

    <div class="main-content">
        <?php
        $headerInclude = file_exists(__DIR__ . '/components/header.php')
            ? __DIR__ . '/components/header.php'
            : __DIR__ . '/includes/header.php';

        if (file_exists($headerInclude)) {
            include $headerInclude;
        }
        ?>

        <!-- ✅ Page Loader -->
        <div id="page-loader">
            <div class="spinner" aria-hidden="true"></div>
            <p>Loading, please wait...</p>
        </div>

        <!-- ✅ Page Content -->
        <main>
            <?php
            // Use absolute paths to avoid include warnings from working-directory issues.
            $candidatePaths = [
                __DIR__ . "/pages/{$role}/{$page}.php",
                __DIR__ . "/pages/task_steps/{$page}.php",
                __DIR__ . "/{$page}.php",
                __DIR__ . "/pages/{$role}/dashboard.php",
                __DIR__ . "/pages/dashboard.php",
            ];

            $included = false;
            foreach ($candidatePaths as $path) {
                if (!is_file($path)) {
                    continue;
                }

                if (basename($path) === 'layout.php') {
                    continue;
                }

                include $path;
                $included = true;
                break;
            }

            if (!$included) {
                echo '<div style="padding:16px;border:1px solid #e5e7eb;border-radius:10px;background:#fff">';
                echo '<h2 style="margin:0 0 8px 0;font-size:20px;color:#111827">No page found</h2>';
                echo '<p style="margin:0;color:#4b5563">Create `pages/dashboard.php` or add a page file under `pages/` or `pages/bns/`.</p>';
                echo '</div>';
            }
            ?>
        </main>
    </div>
</div>

<!-- ✅ Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

</body>
</html>
