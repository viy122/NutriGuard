<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$role     = $_SESSION['role'] ?? 'bhw';
$userName = $_SESSION['name'] ?? '';

// ── Sidebar setup ────────────────────────────────────────────────────────────
$sidebar_active = 'bmi';
$sidebar_items = [
  'dashboard' => ['label'=>'Dashboard',      'href'=>'dashboard.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
  'records'   => ['label'=>'Health Records', 'href'=>'records.php',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
  'reports'   => ['label'=>'Reports',        'href'=>'reports.php',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zm6-4.5C9 8.004 9.504 7.5 10.125 7.5h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019 19.875V8.625zm6-4.5c0-.621.504-1.125 1.125-1.125h2.25C21.496 3 22 3.504 22 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>'],
  'map'       => ['label'=>'Heatmap',        'href'=>'map.php',      'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>'],
  'alerts'    => ['label'=>'Alerts',         'href'=>'alerts.php',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>'],
  'bmi'       => ['label'=>'BMI Calculator', 'href'=>'bmi.php',      'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.598 4.5 4.583V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.583c0-.985-.807-1.883-1.907-2.011A48.507 48.507 0 0012 2.25z"/>'],
];

$sidebar_header = '
<div style="display:flex;align-items:center;gap:0.5rem;padding:0.25rem;">
  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#06b6d4,#0d9488);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
    <svg style="width:18px;height:18px;color:#fff;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
    </svg>
  </div>
  <span class="sidebar-label" style="font-size:1rem;font-weight:600;">
    <span style="color:#111827;">NUTRI</span>
    <span style="background:linear-gradient(to right,#0891b2,#0d9488);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"> GUARD</span>
  </span>
</div>';

$u = htmlspecialchars($userName);
$r = strtoupper(htmlspecialchars($role));
$sidebar_footer = '
<div style="display:flex;align-items:center;gap:0.6rem;">
  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#06b6d4,#0d9488);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
    <svg style="width:18px;height:18px;color:#fff;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
    </svg>
  </div>
  <div class="sidebar-footer-text" style="flex:1;min-width:0;">
    <div style="font-size:0.8rem;font-weight:600;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'.$u.'</div>
    <div style="font-size:0.7rem;color:#6b7280;">'.$r.'</div>
  </div>
  <a href="logout.php" class="sidebar-label" title="Logout" style="color:#9ca3af;display:flex;align-items:center;">
    <svg style="width:16px;height:16px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
    </svg>
  </a>
</div>';

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">BMI Calculator</span>';

ob_start();
?>

<div class="p-6 max-w-4xl mx-auto">

  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
      <div class="p-3 bg-gradient-to-br from-cyan-500 to-teal-600 rounded-xl shadow-lg">
        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.598 4.5 4.583V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.583c0-.985-.807-1.883-1.907-2.011A48.507 48.507 0 0012 2.25z"/>
        </svg>
      </div>
      <div>
        <h1 class="text-3xl font-bold">BMI Calculator</h1>
        <p class="text-gray-600 text-sm">Calculate Body Mass Index and assess health status</p>
      </div>
    </div>
  </div>

  <!-- Main Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Calculator Form -->
    <div class="p-6 rounded-2xl shadow-lg bg-gradient-to-br from-white to-cyan-50">
      <h2 class="text-xl font-semibold mb-4">Enter Your Details</h2>
      <form id="bmi-form" class="space-y-5" onsubmit="calculateBMI(event)">

        <div>
          <label for="weight" class="block text-sm font-medium text-gray-700 mb-1.5">Weight (kg)</label>
          <input
            id="weight" type="number" step="0.1" min="1" required
            placeholder="e.g., 65.5"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition bg-white"
          />
        </div>

        <div>
          <label for="height" class="block text-sm font-medium text-gray-700 mb-1.5">Height (cm)</label>
          <input
            id="height" type="number" step="0.1" min="1" required
            placeholder="e.g., 170"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition bg-white"
          />
        </div>

        <div class="flex gap-3 pt-2">
          <button
            type="submit"
            class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-lg text-white text-sm font-medium shadow-lg transition-all"
            style="background:linear-gradient(to right,#06b6d4,#0d9488);"
            onmouseover="this.style.background='linear-gradient(to right,#0891b2,#0f766e)'"
            onmouseout="this.style.background='linear-gradient(to right,#06b6d4,#0d9488)'"
          >
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.598 4.5 4.583V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.583c0-.985-.807-1.883-1.907-2.011A48.507 48.507 0 0012 2.25z"/>
            </svg>
            Calculate BMI
          </button>
          <button
            type="button"
            onclick="resetCalculator()"
            class="px-6 py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 text-sm font-medium hover:border-gray-400 transition-all bg-white"
          >
            Reset
          </button>
        </div>
      </form>
    </div>

    <!-- Results -->
    <div class="p-6 rounded-2xl shadow-lg bg-white">
      <h2 class="text-xl font-semibold mb-4">Your Results</h2>

      <!-- Empty State -->
      <div id="result-empty" class="flex flex-col items-center justify-center h-64 text-gray-400">
        <svg class="w-16 h-16 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6.75v6.75"/>
        </svg>
        <p class="text-center text-sm">Enter your weight and height to calculate your BMI</p>
      </div>

      <!-- Result State -->
      <div id="result-output" class="hidden space-y-6">

        <!-- BMI Circle -->
        <div class="text-center">
          <div id="bmi-circle" class="inline-flex items-center justify-center w-32 h-32 rounded-full shadow-xl mb-4 transition-all duration-500">
            <div class="text-white text-center">
              <div id="bmi-value" class="text-4xl font-bold">--</div>
              <div class="text-sm opacity-90">BMI</div>
            </div>
          </div>
          <h3 id="bmi-category" class="text-2xl font-semibold"></h3>
        </div>

        <!-- Category Bars -->
        <div class="space-y-2">
          <?php
            $bars = [
              ['label'=>'Underweight', 'range'=>'&lt; 18.5',  'grad'=>'from-blue-500 to-blue-600',    'id'=>'bar-under'],
              ['label'=>'Normal',      'range'=>'18.5 - 24.9','grad'=>'from-green-500 to-green-600',   'id'=>'bar-normal'],
              ['label'=>'Overweight',  'range'=>'25 - 29.9',  'grad'=>'from-yellow-500 to-orange-500', 'id'=>'bar-over'],
              ['label'=>'Obese',       'range'=>'≥ 30',        'grad'=>'from-red-500 to-red-600',       'id'=>'bar-obese'],
            ];
            foreach ($bars as $bar): ?>
            <div class="mt-3">
              <div class="flex items-center justify-between text-sm mb-1">
                <span class="font-medium text-gray-700"><?= $bar['label'] ?></span>
                <span class="text-gray-500"><?= $bar['range'] ?></span>
              </div>
              <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div id="<?= $bar['id'] ?>" class="h-full bg-gradient-to-r <?= $bar['grad'] ?> rounded-full transition-all duration-500 w-0"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Advice Box -->
        <div class="p-4 bg-gradient-to-br from-cyan-50 to-teal-50 rounded-xl border border-cyan-200">
          <p id="bmi-advice" class="text-sm text-gray-700"></p>
        </div>

      </div>
    </div>
  </div>

  <!-- Info Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <div class="p-5 rounded-2xl shadow-lg bg-gradient-to-br from-blue-50 to-blue-100">
      <div class="flex items-start gap-3">
        <div class="p-2 bg-blue-500 rounded-lg flex-shrink-0">
          <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"/>
          </svg>
        </div>
        <div>
          <h3 class="text-sm font-semibold mb-1">Underweight</h3>
          <p class="text-xs text-gray-600">BMI below 18.5 may indicate malnutrition or health issues</p>
        </div>
      </div>
    </div>

    <div class="p-5 rounded-2xl shadow-lg bg-gradient-to-br from-green-50 to-green-100">
      <div class="flex items-start gap-3">
        <div class="p-2 bg-green-500 rounded-lg flex-shrink-0">
          <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3"/>
          </svg>
        </div>
        <div>
          <h3 class="text-sm font-semibold mb-1">Healthy Weight</h3>
          <p class="text-xs text-gray-600">BMI 18.5–24.9 indicates optimal health and wellness</p>
        </div>
      </div>
    </div>

    <div class="p-5 rounded-2xl shadow-lg bg-gradient-to-br from-orange-50 to-red-100">
      <div class="flex items-start gap-3">
        <div class="p-2 bg-orange-500 rounded-lg flex-shrink-0">
          <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
          </svg>
        </div>
        <div>
          <h3 class="text-sm font-semibold mb-1">Overweight/Obese</h3>
          <p class="text-xs text-gray-600">BMI 25+ may increase risk of health complications</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Disclaimer -->
  <div class="p-4 mt-6 bg-gray-50 border border-gray-200 rounded-2xl">
    <p class="text-xs text-gray-600">
      <strong>Note:</strong> BMI is a screening tool and not a diagnostic test. It does not account for muscle mass, bone density, or body composition. Consult with a healthcare professional for a comprehensive health assessment.
    </p>
  </div>

</div>

<script>
function calculateBMI(e) {
  e.preventDefault();

  const weight = parseFloat(document.getElementById('weight').value);
  const height = parseFloat(document.getElementById('height').value);
  if (!weight || !height || weight <= 0 || height <= 0) return;

  const hm  = height / 100;
  const bmi = parseFloat((weight / (hm * hm)).toFixed(1));

  let category, advice, grad, circleStyle;

  if (bmi < 18.5) {
    category = 'Underweight';
    advice   = 'You may need to gain weight. Consult with a healthcare provider for a personalized nutrition plan.';
    grad     = 'linear-gradient(135deg,#3b82f6,#2563eb)';
  } else if (bmi < 25) {
    category = 'Normal Weight';
    advice   = "Great! You're in a healthy weight range. Maintain a balanced diet and regular exercise.";
    grad     = 'linear-gradient(135deg,#22c55e,#16a34a)';
  } else if (bmi < 30) {
    category = 'Overweight';
    advice   = 'Consider adopting healthier eating habits and increasing physical activity.';
    grad     = 'linear-gradient(135deg,#eab308,#f97316)';
  } else {
    category = 'Obese';
    advice   = "It's important to consult with a healthcare provider to develop a weight management plan.";
    grad     = 'linear-gradient(135deg,#ef4444,#dc2626)';
  }

  // Update circle
  document.getElementById('bmi-circle').style.background = grad;
  document.getElementById('bmi-value').textContent    = bmi;
  document.getElementById('bmi-category').textContent  = category;
  document.getElementById('bmi-advice').textContent    = advice;

  // Update bars — set active bar to full width, others to 0
  const bars = {
    'bar-under':  bmi < 18.5,
    'bar-normal': bmi >= 18.5 && bmi < 25,
    'bar-over':   bmi >= 25   && bmi < 30,
    'bar-obese':  bmi >= 30,
  };
  Object.entries(bars).forEach(([id, active]) => {
    document.getElementById(id).style.width = active ? '100%' : '0%';
  });

  // Show result panel
  document.getElementById('result-empty').classList.add('hidden');
  document.getElementById('result-output').classList.remove('hidden');
}

function resetCalculator() {
  document.getElementById('weight').value = '';
  document.getElementById('height').value = '';
  document.getElementById('result-empty').classList.remove('hidden');
  document.getElementById('result-output').classList.add('hidden');
  ['bar-under','bar-normal','bar-over','bar-obese'].forEach(id => {
    document.getElementById(id).style.width = '0%';
  });
}
</script>

<?php
$page_content = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BMI Calculator – NutriGuard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="margin:0;font-family:sans-serif;">
  <?php include 'sidebar.php'; ?>
</body>
</html>