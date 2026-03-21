<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
  exit;
}

$error = '';

// Demo accounts (fallback if users.json doesn't exist)
$demoAccounts = [
  'head@nutriguard.ph' => ['password' => 'head123', 'role' => 'head', 'name' => 'Health Center Head'],
  'bhw@nutriguard.ph'  => ['password' => 'bhw123',  'role' => 'bhw',  'name' => 'BHW User'],
  'bns@nutriguard.ph'  => ['password' => 'bns123',  'role' => 'bns',  'name' => 'BNS User'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  $loggedIn = false;

  // Check users.json first (registered via signup.php)
  $usersFile = __DIR__ . '/users.json';
  if (file_exists($usersFile)) {
    $users = json_decode(file_get_contents($usersFile), true) ?? [];
    foreach ($users as $user) {
      if ($user['email'] === $email && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['email'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $loggedIn = true;
        break;
      }
    }
  }

  // Fallback: check demo accounts
  if (!$loggedIn && isset($demoAccounts[$email]) && $demoAccounts[$email]['password'] === $password) {
    $_SESSION['user'] = $email;
    $_SESSION['name'] = $demoAccounts[$email]['name'];
    $_SESSION['role'] = $demoAccounts[$email]['role'];
    $loggedIn = true;
  }

  if ($loggedIn) {
    header('Location: ../layout.php?page=dashboard');
    exit;
  } else {
    $error = 'Invalid email or password';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In – NutriGuard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .gradient-text {
      background: linear-gradient(to right, #0891b2, #0d9488);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .gradient-icon { background: linear-gradient(135deg, #06b6d4, #0d9488); }
    .gradient-btn  { background: linear-gradient(to right, #06b6d4, #0d9488); }
    .gradient-btn:hover { background: linear-gradient(to right, #0891b2, #0f766e); }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-cyan-50 via-teal-50 to-blue-50 flex items-center justify-center p-4">

  <div class="w-full max-w-md">

    <!-- Logo / Header -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-20 h-20 gradient-icon rounded-full mb-6 shadow-xl">
        <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
        </svg>
      </div>
      <h1 class="text-4xl font-bold mb-2">
        <span class="text-gray-900">NUTRI</span><span class="gradient-text">GUARD</span>
      </h1>
      <p class="text-gray-600 text-sm">
        Predictive Malnutrition &amp; Community Health Risk Detection
      </p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
      <h2 class="text-2xl font-semibold mb-1">Sign In</h2>
      <p class="text-gray-600 text-sm mb-6">Enter your credentials to continue</p>

      <!-- Error -->
      <?php if ($error): ?>
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form method="POST" action="" class="space-y-5">

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
          <input
            id="email" name="email" type="email" required
            placeholder="Enter your email"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
          />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
          <input
            id="password" name="password" type="password" required
            placeholder="Enter your password"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
          />
        </div>

        <button
          type="submit"
          class="gradient-btn w-full text-white py-2.5 rounded-lg font-medium shadow-lg transition-all text-sm"
        >
          Sign In
        </button>
      </form>

      <!-- Demo Accounts -->
      <div class="mt-6 p-4 bg-gradient-to-br from-cyan-50 to-teal-50 rounded-lg border border-cyan-200">
        <p class="text-xs text-gray-700 mb-2 font-medium">Demo Accounts:</p>
        <div class="space-y-1 text-xs text-gray-600">
          <div>Head: head@nutriguard.ph / head123</div>
          <div>BHW: bhw@nutriguard.ph / bhw123</div>
          <div>BNS: bns@nutriguard.ph / bns123</div>
        </div>
      </div>

      <!-- Sign Up Link -->
      <p class="text-center text-gray-600 text-sm mt-6">
        Don't have an account?
        <a href="sign_up.php" class="text-cyan-600 hover:text-cyan-700 font-medium">Sign Up</a>
      </p>
    </div>

    <!-- Footer note -->
    <p class="text-center text-gray-500 text-sm mt-6">
      Barangay Magahis, Tuy, Batangas · Municipal Health Office
    </p>

  </div>
</body>
</html>