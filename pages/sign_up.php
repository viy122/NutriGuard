<?php
session_start();

$error = '';
$name  = '';
$email = '';
$selectedRole = 'bhw';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name            = trim($_POST['name'] ?? '');
  $email           = trim($_POST['email'] ?? '');
  $password        = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirm_password'] ?? '';
  $selectedRole    = $_POST['role'] ?? 'bhw';

  // Validation
  if (!$name || !$email || !$password || !$confirmPassword) {
    $error = 'All fields are required';
  } elseif ($password !== $confirmPassword) {
    $error = 'Passwords do not match';
  } elseif (strlen($password) < 6) {
    $error = 'Password must be at least 6 characters';
  } else {
    // Load existing users
    $usersFile = __DIR__ . '/users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    // Check if email already exists
    $emailExists = array_filter($users, fn($u) => $u['email'] === $email);

    if ($emailExists) {
      $error = 'Email already exists. Please use a different email.';
    } else {
      // Save new user
      $users[] = [
        'name'     => $name,
        'email'    => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role'     => $selectedRole,
      ];
      file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

      // Log in immediately
      $_SESSION['user'] = $email;
      $_SESSION['name'] = $name;
      $_SESSION['role'] = $selectedRole;
      header('Location: ../layout.php?page=dashboard');
      exit;
    }
  }
}

$roles = [
  [
    'value'       => 'head',
    'label'       => 'Health Center Head',
    'description' => 'Manage and oversee all operations',
    'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>',
  ],
  [
    'value'       => 'bhw',
    'label'       => 'BHW (Barangay Health Worker)',
    'description' => 'Conduct assessments and field work',
    'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
  ],
  [
    'value'       => 'bns',
    'label'       => 'BNS (Barangay Nutrition Scholar)',
    'description' => 'Nutritional monitoring and planning',
    'icon'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>',
  ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up – NutriGuard</title>
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

  <div class="w-full max-w-2xl">

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
      <p class="text-gray-600 text-sm">Create your account to get started</p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
      <h2 class="text-2xl font-semibold mb-1">Create Account</h2>
      <p class="text-gray-600 text-sm mb-6">Join the NUTRI-GUARD community health system</p>

      <!-- Error -->
      <?php if ($error): ?>
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="" class="space-y-5">

        <!-- Full Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
          <input
            id="name" name="name" type="text" required
            placeholder="Enter your full name"
            value="<?= htmlspecialchars($name) ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
          />
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
          <input
            id="email" name="email" type="email" required
            placeholder="Enter your email"
            value="<?= htmlspecialchars($email) ?>"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
          />
        </div>

        <!-- Password + Confirm -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
            <input
              id="password" name="password" type="password" required
              placeholder="At least 6 characters"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            />
          </div>
          <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
            <input
              id="confirm_password" name="confirm_password" type="password" required
              placeholder="Re-enter password"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            />
          </div>
        </div>

        <!-- Role Selection -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-3">Select Your Role</label>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <?php foreach ($roles as $role): ?>
              <label
                class="cursor-pointer p-4 rounded-xl border-2 transition-all text-left role-card <?= $selectedRole === $role['value'] ? 'border-cyan-500 bg-cyan-50 shadow-md selected' : 'border-gray-200 hover:border-cyan-300' ?>"
                data-role="<?= $role['value'] ?>"
              >
                <input type="radio" name="role" value="<?= $role['value'] ?>" class="hidden" <?= $selectedRole === $role['value'] ? 'checked' : '' ?> />
                <svg class="w-8 h-8 mb-2 role-icon <?= $selectedRole === $role['value'] ? 'text-cyan-600' : 'text-gray-400' ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <?= $role['icon'] ?>
                </svg>
                <div class="text-sm font-medium mb-1"><?= htmlspecialchars($role['label']) ?></div>
                <div class="text-xs text-gray-500"><?= htmlspecialchars($role['description']) ?></div>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <button
          type="submit"
          class="gradient-btn w-full text-white py-2.5 rounded-lg font-medium shadow-lg transition-all text-sm"
        >
          Create Account
        </button>
      </form>

      <p class="text-center text-gray-600 text-sm mt-6">
        Already have an account?
        <a href="sign_in.php" class="text-cyan-600 hover:text-cyan-700 font-medium">Sign In</a>
      </p>
    </div>

    <p class="text-center text-gray-500 text-sm mt-6">
      Barangay Magahis, Tuy, Batangas · Municipal Health Office
    </p>
  </div>

  <script>
    // Role card interactive selection
    document.querySelectorAll('.role-card').forEach(card => {
      card.addEventListener('click', () => {
        // Reset all
        document.querySelectorAll('.role-card').forEach(c => {
          c.classList.remove('border-cyan-500', 'bg-cyan-50', 'shadow-md', 'selected');
          c.classList.add('border-gray-200');
          c.querySelector('.role-icon').classList.remove('text-cyan-600');
          c.querySelector('.role-icon').classList.add('text-gray-400');
          c.querySelector('input[type=radio]').checked = false;
        });
        // Select clicked
        card.classList.add('border-cyan-500', 'bg-cyan-50', 'shadow-md', 'selected');
        card.classList.remove('border-gray-200');
        card.querySelector('.role-icon').classList.add('text-cyan-600');
        card.querySelector('.role-icon').classList.remove('text-gray-400');
        card.querySelector('input[type=radio]').checked = true;
      });
    });
  </script>

</body>
</html>