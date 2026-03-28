<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$role     = $_SESSION['role'] ?? 'bns';
$userName = $_SESSION['name'] ?? '';

// ── Children data ─────────────────────────────────────────────────────────────
$children = [
  ['id'=>'R-001','name'=>'Juan Dela Cruz Jr.','age'=>36,'sex'=>'Male',  'birthday'=>'2023-01-15','weight'=>14.5,'height'=>95, 'purok'=>'Purok 1'],
  ['id'=>'R-002','name'=>'Ana Santos',         'age'=>24,'sex'=>'Female','birthday'=>'2024-02-10','weight'=>10.2,'height'=>85, 'purok'=>'Purok 1'],
  ['id'=>'R-003','name'=>'Pedro Reyes',         'age'=>48,'sex'=>'Male',  'birthday'=>'2022-03-20','weight'=>13.8,'height'=>98, 'purok'=>'Purok 2'],
  ['id'=>'R-004','name'=>'Maria Garcia',        'age'=>28,'sex'=>'Female','birthday'=>'2023-11-05','weight'=>9.5, 'height'=>82, 'purok'=>'Purok 3'],
];

$recentAssessments = [
  ['date'=>'2026-03-18','name'=>'Juan Dela Cruz Jr.','childId'=>'R-001','age'=>'36 mo','weight'=>'14.5','height'=>'95.0','status'=>'Normal',         'statusColor'=>'bg-green-100 text-green-700', 'risk'=>'18/100 - Low',   'riskColor'=>'bg-green-100 text-green-700', 'assessor'=>'Rosa Mendoza (BNS)'],
  ['date'=>'2026-03-17','name'=>'Ana Santos',         'childId'=>'R-002','age'=>'24 mo','weight'=>'10.2','height'=>'85.0','status'=>'Underweight',    'statusColor'=>'bg-yellow-100 text-yellow-700','risk'=>'62/100 - High',  'riskColor'=>'bg-orange-100 text-orange-700','assessor'=>'Rosa Mendoza (BNS)'],
  ['date'=>'2026-03-15','name'=>'Maria Garcia',        'childId'=>'R-004','age'=>'28 mo','weight'=>'9.5', 'height'=>'82.0','status'=>'Severely Wasted','statusColor'=>'bg-red-100 text-red-700',    'risk'=>'92/100 - Severe','riskColor'=>'bg-red-100 text-red-700',    'assessor'=>'Carmen Lopez (BNS)'],
];

$childrenJson    = json_encode($children);
$recentJson      = json_encode($recentAssessments);

// ── Sidebar ───────────────────────────────────────────────────────────────────
$sidebar_active = 'assessment';
$sidebar_items = [
  'dashboard'  => ['label'=>'Dashboard',      'href'=>'dashboard.php',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
  'records'    => ['label'=>'Health Records', 'href'=>'records_bns.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
  'programs'   => ['label'=>'Programs',       'href'=>'programs.php',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>'],
  'assessment' => ['label'=>'Assessment',     'href'=>'assessment.php', 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18z"/>'],
  'reports'    => ['label'=>'Reports',        'href'=>'reports_bns.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zm6-4.5C9 8.004 9.504 7.5 10.125 7.5h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019 19.875V8.625zm6-4.5c0-.621.504-1.125 1.125-1.125h2.25C21.496 3 22 3.504 22 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>'],
  'alerts'     => ['label'=>'Alerts',         'href'=>'alerts.php',     'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>'],
  'bmi'        => ['label'=>'BMI Calculator', 'href'=>'bmi.php',        'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.598 4.5 4.583V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.583c0-.985-.807-1.883-1.907-2.011A48.507 48.507 0 0012 2.25z"/>'],
];

$u = htmlspecialchars($userName);
$r = strtoupper(htmlspecialchars($role));

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

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">Nutritional Assessment</span>';

ob_start();
?>

<div class="p-6 space-y-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

  <!-- Header -->
  <div class="bg-gradient-to-r from-cyan-500 to-teal-600 text-white rounded-2xl p-8 shadow-xl">
    <h1 class="text-3xl font-bold mb-2">Nutritional Assessment &amp; AI Risk Analysis</h1>
    <p class="text-sm text-white/90">Automated classification with predictive risk scoring and program recommendations</p>
  </div>

  <!-- Tabs -->
  <div class="flex gap-1 bg-white shadow-md rounded-xl p-1 w-fit">
    <button onclick="switchTab('new')" id="tab-new"
      class="tab-btn flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold transition-all bg-cyan-50 text-cyan-700 shadow-sm">
      <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18z"/>
      </svg>
      New Assessment
    </button>
    <button onclick="switchTab('recent')" id="tab-recent"
      class="tab-btn flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold transition-all text-gray-600 hover:text-gray-900">
      <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
      </svg>
      Recent Assessments
    </button>
  </div>

  <!-- ══ TAB: NEW ASSESSMENT ═════════════════════════════════════════════════ -->
  <div id="panel-new">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- Form -->
      <div class="lg:col-span-1 bg-white rounded-2xl shadow-lg p-6">
        <div class="mb-6">
          <h3 class="text-lg font-semibold flex items-center gap-2 mb-1">
            <svg class="w-5 h-5 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>
            Child Information
          </h3>
          <p class="text-sm text-gray-500">Select child to auto-fill data, then enter current measurements</p>
        </div>

        <div class="space-y-5">
          <!-- Child select -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Select Child <span class="text-red-500">*</span></label>
            <select id="child-select" onchange="handleChildSelect(this.value)"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
              <option value="">Select child from database</option>
              <?php foreach ($children as $c):
                $ageYears  = intdiv($c['age'], 12);
                $ageMos    = $c['age'] % 12;
                $ageLabel  = $ageYears >= 1
                  ? $ageYears . ' year' . ($ageYears > 1 ? 's' : '')
                  : $c['age'] . ' month' . ($c['age'] != 1 ? 's' : '');
              ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?> (<?= $ageLabel ?>)</option>
              <?php endforeach; ?>
            </select>
            <p class="text-xs text-gray-400 mt-1">Data will auto-populate from resident database</p>
          </div>

          <!-- Age -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Age (months) <span class="text-red-500">*</span></label>
            <input id="f-age" type="number" min="0" max="60" placeholder="Enter age in months"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" />
          </div>

          <!-- Weight -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Weight (kg) <span class="text-red-500">*</span></label>
            <input id="f-weight" type="number" step="0.1" min="0" placeholder="0.0"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" />
          </div>

          <!-- Height -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Height (cm) <span class="text-red-500">*</span></label>
            <input id="f-height" type="number" step="0.1" min="0" placeholder="0.0"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" />
          </div>

          <!-- Sex -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Sex <span class="text-red-500">*</span></label>
            <select id="f-sex" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
              <option value="">Select sex</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>

          <!-- MUAC -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">MUAC – Mid-Upper Arm Circumference (cm) <span class="text-red-500">*</span></label>
            <input id="f-muac" type="number" step="0.1" min="0" placeholder="0.0"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" />
            <p class="text-xs text-gray-400 mt-1">Measure the arm circumference at midpoint between shoulder and elbow</p>
          </div>

          <button id="run-btn" onclick="runAssessment()"
            class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg text-white text-sm font-medium shadow-lg transition-all opacity-50 cursor-not-allowed"
            style="background:linear-gradient(to right,#06b6d4,#0d9488);" disabled>
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18z"/>
            </svg>
            Run Assessment &amp; AI Analysis
          </button>
        </div>
      </div>

      <!-- Results -->
      <div class="lg:col-span-2 space-y-6">

        <!-- Empty state -->
        <div id="result-empty" class="bg-white rounded-2xl shadow-lg p-12 flex items-center justify-center min-h-96">
          <div class="text-center max-w-md">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-cyan-100 to-teal-100 rounded-full flex items-center justify-center">
              <svg class="w-10 h-10 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Ready for AI Analysis</h3>
            <p class="text-gray-500 text-sm">Select a child and enter their current measurements to get automated nutritional classification with AI-powered risk scoring and program recommendations</p>
          </div>
        </div>

        <!-- Result panels (hidden until assessment runs) -->
        <div id="result-panels" class="hidden space-y-6">

          <!-- Classification -->
          <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold flex items-center gap-2 mb-4">
              <svg class="w-5 h-5 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008z"/></svg>
              Nutritional Status Classification
            </h3>
            <div class="text-center mb-6">
              <span id="r-status-badge" class="inline-flex px-6 py-3 rounded-full text-xl font-bold"></span>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div class="p-3 bg-gray-50 rounded-xl"><div class="text-sm text-gray-500 mb-1">Weight-for-Age</div><div id="r-wfa" class="font-semibold"></div></div>
              <div class="p-3 bg-gray-50 rounded-xl"><div class="text-sm text-gray-500 mb-1">Height-for-Age</div><div id="r-hfa" class="font-semibold"></div></div>
              <div class="p-3 bg-gray-50 rounded-xl"><div class="text-sm text-gray-500 mb-1">Weight-for-Height</div><div id="r-wfh" class="font-semibold"></div></div>
              <div class="p-3 bg-gray-50 rounded-xl"><div class="text-sm text-gray-500 mb-1">MUAC Status</div><div id="r-muac" class="font-semibold"></div></div>
            </div>
          </div>

          <!-- AI Risk Score -->
          <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl shadow-lg p-6 border border-purple-200">
            <h3 class="text-lg font-semibold flex items-center gap-2 mb-4">
              <svg class="w-5 h-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
              AI Predictive Risk Score
            </h3>
            <div class="flex items-center gap-6">
              <div class="flex-1">
                <div class="flex items-end gap-2 mb-2">
                  <div id="r-score" class="text-5xl font-bold text-gray-900"></div>
                  <div class="text-2xl text-gray-400 mb-2">/100</div>
                </div>
                <span id="r-risk-badge" class="inline-flex px-4 py-1 rounded-full text-base font-medium"></span>
              </div>
              <div class="flex-1" id="r-risk-msg"></div>
            </div>
          </div>

          <!-- AI Interventions -->
          <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold flex items-center gap-2 mb-4">
              <svg class="w-5 h-5 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09 3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
              AI-Recommended Interventions &amp; Programs
            </h3>
            <div id="r-interventions" class="space-y-3"></div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- ══ TAB: RECENT ASSESSMENTS ════════════════════════════════════════════ -->
  <div id="panel-recent" class="hidden">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <tr>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Date</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Resident</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Age</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Weight</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Height</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Status</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Risk Score</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Assessor</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">History &amp; Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentAssessments as $ra): ?>
            <tr class="border-b border-gray-100 hover:bg-gray-50">
              <td class="p-4 text-sm text-gray-600"><?= $ra['date'] ?></td>
              <td class="p-4 text-sm font-semibold"><?= htmlspecialchars($ra['name']) ?></td>
              <td class="p-4 text-sm text-gray-600"><?= $ra['age'] ?></td>
              <td class="p-4 text-sm text-gray-600"><?= $ra['weight'] ?> kg</td>
              <td class="p-4 text-sm text-gray-600"><?= $ra['height'] ?> cm</td>
              <td class="p-4"><span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium <?= $ra['statusColor'] ?>"><?= $ra['status'] ?></span></td>
              <td class="p-4"><span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium <?= $ra['riskColor'] ?>"><?= $ra['risk'] ?></span></td>
              <td class="p-4 text-sm text-gray-600"><?= htmlspecialchars($ra['assessor']) ?></td>
              <td class="p-4">
                <button onclick="showHistory('<?= $ra['childId'] ?>')"
                  class="flex items-center gap-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all">
                  <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                  View
                </button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- ══ ENROLL MODAL ═══════════════════════════════════════════════════════════ -->
<div id="enroll-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(0,0,0,0.5);">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <div>
        <h2 class="text-xl font-bold flex items-center gap-2">
          <svg class="w-5 h-5 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
          </svg>
          Enroll in Program
        </h2>
        <p class="text-sm text-gray-500 mt-0.5">Enroll the child in <span id="enroll-prog-name" class="font-medium text-cyan-700"></span></p>
      </div>
      <button onclick="closeEnroll()" class="p-2 hover:bg-gray-100 rounded-lg">
        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="p-6 space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Child</label>
        <input id="enroll-child-name" type="text" disabled
          class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Program</label>
        <input id="enroll-program-field" type="text" disabled
          class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Enrollment Notes (Optional)</label>
        <textarea id="enroll-notes" rows="4" placeholder="Add any notes or special instructions..."
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none"></textarea>
      </div>
    </div>
    <div class="flex gap-3 p-6 pt-0">
      <button onclick="closeEnroll()" class="flex-1 py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 text-sm font-medium bg-white hover:bg-gray-50">Cancel</button>
      <button onclick="confirmEnroll()" class="flex-1 py-2.5 rounded-lg text-white text-sm font-medium shadow-lg transition-all" style="background:linear-gradient(to right,#06b6d4,#0d9488);">Confirm Enrollment</button>
    </div>
  </div>
</div>

<!-- ══ HISTORY MODAL ══════════════════════════════════════════════════════════ -->
<div id="history-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(0,0,0,0.5);">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] overflow-y-auto">
    <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-2xl">
      <div>
        <h2 class="text-xl font-bold flex items-center gap-2">
          <svg class="w-5 h-5 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Assessment History
        </h2>
        <p class="text-sm text-gray-500 mt-0.5">View assessment history for <span id="history-child-name" class="font-medium"></span></p>
      </div>
      <button onclick="closeHistory()" class="p-2 hover:bg-gray-100 rounded-lg">
        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="p-6">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <tr>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Date</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Age</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Weight</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Height</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Status</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Risk Score</th>
              <th class="text-left p-4 text-sm font-semibold text-gray-700">Assessor</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentAssessments as $ra): ?>
            <tr class="border-b border-gray-100 hover:bg-gray-50">
              <td class="p-4 text-sm text-gray-600"><?= $ra['date'] ?></td>
              <td class="p-4 text-sm text-gray-600"><?= $ra['age'] ?></td>
              <td class="p-4 text-sm text-gray-600"><?= $ra['weight'] ?> kg</td>
              <td class="p-4 text-sm text-gray-600"><?= $ra['height'] ?> cm</td>
              <td class="p-4"><span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium <?= $ra['statusColor'] ?>"><?= $ra['status'] ?></span></td>
              <td class="p-4"><span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium <?= $ra['riskColor'] ?>"><?= $ra['risk'] ?></span></td>
              <td class="p-4 text-sm text-gray-600"><?= htmlspecialchars($ra['assessor']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="p-6 pt-0">
      <button onclick="closeHistory()" class="w-full py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 text-sm font-medium bg-white hover:bg-gray-50">Close</button>
    </div>
  </div>
</div>

<script>
const CHILDREN = <?= $childrenJson ?>;
let selectedChildId = '';

// ── Tabs ──────────────────────────────────────────────────────────────────────
function switchTab(tab) {
  ['new','recent'].forEach(t => {
    document.getElementById('panel-' + t).classList.toggle('hidden', t !== tab);
    const btn = document.getElementById('tab-' + t);
    btn.classList.toggle('bg-cyan-50', t === tab);
    btn.classList.toggle('text-cyan-700', t === tab);
    btn.classList.toggle('shadow-sm', t === tab);
    btn.classList.toggle('text-gray-600', t !== tab);
  });
}

// ── Auto-populate child ───────────────────────────────────────────────────────
function handleChildSelect(id) {
  selectedChildId = id;
  const child = CHILDREN.find(c => c.id === id);
  if (child) {
    document.getElementById('f-age').value    = child.age;
    document.getElementById('f-weight').value = child.weight;
    document.getElementById('f-height').value = child.height;
    document.getElementById('f-sex').value    = child.sex.toLowerCase();
    document.getElementById('f-muac').value   = '';
    hideResults();
  }
  checkFormReady();
}

// ── Enable run button when all fields filled ──────────────────────────────────
['f-age','f-weight','f-height','f-sex','f-muac'].forEach(id => {
  document.getElementById(id).addEventListener('input', checkFormReady);
  document.getElementById(id).addEventListener('change', checkFormReady);
});

function checkFormReady() {
  const ready = ['f-age','f-weight','f-height','f-sex','f-muac'].every(id => document.getElementById(id).value !== '');
  const btn = document.getElementById('run-btn');
  btn.disabled = !ready;
  btn.classList.toggle('opacity-50', !ready);
  btn.classList.toggle('cursor-not-allowed', !ready);
}

// ── Assessment logic (mirrors React calculateRiskScore & generateInterventions) 
function runAssessment() {
  const weight = parseFloat(document.getElementById('f-weight').value);
  const height = parseFloat(document.getElementById('f-height').value);
  const age    = parseFloat(document.getElementById('f-age').value);
  const muac   = parseFloat(document.getElementById('f-muac').value) || 13.5;
  const bmi    = weight / Math.pow(height / 100, 2);

  let status = 'Normal';
  let wfa = 'Normal', hfa = 'Normal', wfh = 'Normal', muacStatus = 'Normal';

  // Weight-for-Age
  if (age <= 24) {
    if (weight < 9)  { wfa = 'Severely Underweight'; status = 'Severely Wasted'; }
    else if (weight < 11) { wfa = 'Underweight'; status = 'Underweight'; }
  } else if (age <= 48) {
    if (weight < 11) { wfa = 'Severely Underweight'; status = 'Severely Wasted'; }
    else if (weight < 13) { wfa = 'Underweight'; status = 'Underweight'; }
  } else {
    if (weight < 13) { wfa = 'Severely Underweight'; status = 'Severely Wasted'; }
    else if (weight < 15) { wfa = 'Underweight'; status = 'Underweight'; }
  }

  // Height-for-Age
  if (age <= 24) {
    if (height < 75) { hfa = 'Severely Stunted'; status = 'Severely Stunted'; }
    else if (height < 80) { hfa = 'Stunted'; status = 'Stunted'; }
  } else if (age <= 48) {
    if (height < 85) { hfa = 'Severely Stunted'; status = 'Severely Stunted'; }
    else if (height < 90) { hfa = 'Stunted'; status = 'Stunted'; }
  } else {
    if (height < 95) { hfa = 'Severely Stunted'; status = 'Severely Stunted'; }
    else if (height < 100) { hfa = 'Stunted'; status = 'Stunted'; }
  }

  // Weight-for-Height (BMI)
  if (bmi < 14)   { wfh = 'Severely Wasted'; status = 'Severely Wasted'; }
  else if (bmi < 15.5) { wfh = 'Wasted'; status = 'Wasted'; }
  else if (bmi > 18)   { wfh = 'Overweight'; status = 'Overweight'; }

  // MUAC
  if (muac < 11.5)       { muacStatus = 'Severe Acute Malnutrition'; status = 'Severely Wasted'; }
  else if (muac < 12.5)  { muacStatus = 'Moderate Acute Malnutrition'; if (status === 'Normal') status = 'Wasted'; }

  if (wfa==='Normal' && hfa==='Normal' && wfh==='Normal' && muacStatus==='Normal') status = 'Normal';

  // Risk score
  let score = 0, riskLevel = 'Low';
  if (status === 'Severely Wasted' || status === 'Severely Stunted') { score = 85 + Math.random()*15; riskLevel = 'Severe'; }
  else if (['Wasted','Stunted','Underweight'].includes(status))       { score = 55 + Math.random()*30; riskLevel = 'High'; }
  else if (status === 'Overweight')                                   { score = 40 + Math.random()*20; riskLevel = 'Moderate'; }
  else                                                                { score = 5  + Math.random()*20; riskLevel = 'Low'; }
  if (muac < 11.5) score += 15;
  else if (muac < 12.5) score += 5;
  score = Math.min(100, Math.round(score));

  const riskColors = { Severe:'bg-red-100 text-red-700', High:'bg-orange-100 text-orange-700', Moderate:'bg-yellow-100 text-yellow-700', Low:'bg-green-100 text-green-700' };
  const statusColors = {
    Normal:'bg-green-100 text-green-700',
    Underweight:'bg-yellow-100 text-yellow-700', Stunted:'bg-yellow-100 text-yellow-700', Wasted:'bg-yellow-100 text-yellow-700',
    Overweight:'bg-blue-100 text-blue-700',
    'Severely Wasted':'bg-red-100 text-red-700','Severely Stunted':'bg-red-100 text-red-700',
  };

  // Interventions
  const interventions = generateInterventions(status, riskLevel);

  // Render
  document.getElementById('r-status-badge').className = 'inline-flex px-6 py-3 rounded-full text-xl font-bold ' + (statusColors[status] || 'bg-gray-100 text-gray-700');
  document.getElementById('r-status-badge').textContent = status;
  document.getElementById('r-wfa').textContent  = wfa;
  document.getElementById('r-hfa').textContent  = hfa;
  document.getElementById('r-wfh').textContent  = wfh;
  document.getElementById('r-muac').textContent = muacStatus;
  document.getElementById('r-score').textContent = score;
  document.getElementById('r-risk-badge').className = 'inline-flex px-4 py-1 rounded-full text-base font-medium ' + (riskColors[riskLevel] || 'bg-gray-100 text-gray-700');
  document.getElementById('r-risk-badge').textContent = riskLevel + ' Risk';

  // Risk message
  const msgEl = document.getElementById('r-risk-msg');
  if (riskLevel === 'Severe') {
    msgEl.innerHTML = `<div class="flex items-start gap-2 p-3 bg-red-50 border border-red-200 rounded-xl"><svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg><div class="text-sm"><div class="font-semibold text-red-900 mb-1">Critical Intervention Required</div><div class="text-red-700">Immediate enrollment in therapeutic nutrition program recommended</div></div></div>`;
  } else if (riskLevel === 'High') {
    msgEl.innerHTML = `<div class="flex items-start gap-2 p-3 bg-orange-50 border border-orange-200 rounded-xl"><svg class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg><div class="text-sm"><div class="font-semibold text-orange-900 mb-1">High Priority Case</div><div class="text-orange-700">Close monitoring and intervention programs recommended</div></div></div>`;
  } else if (riskLevel === 'Moderate') {
    msgEl.innerHTML = `<div class="text-sm text-gray-600">Regular monitoring and preventive measures recommended</div>`;
  } else {
    msgEl.innerHTML = `<div class="text-sm text-green-700">Continue routine monitoring and maintain current nutrition practices</div>`;
  }

  // Interventions
  const priColors = { Critical:'bg-red-100 text-red-700', High:'bg-orange-100 text-orange-700', Moderate:'bg-yellow-100 text-yellow-700', Low:'bg-blue-100 text-blue-700' };
  document.getElementById('r-interventions').innerHTML = interventions.map(iv => `
    <div class="p-4 border border-gray-200 rounded-xl hover:border-cyan-300 hover:shadow-md transition-all">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <div class="flex items-center gap-2 mb-2 flex-wrap">
            <h4 class="font-semibold text-gray-900">${iv.program}</h4>
            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium ${priColors[iv.priority] || 'bg-gray-100 text-gray-700'}">${iv.priority} Priority</span>
          </div>
          <p class="text-sm text-gray-600">${iv.description}</p>
        </div>
        <button onclick="openEnroll('${iv.program}')"
          class="flex items-center gap-1 px-3 py-2 rounded-lg text-white text-xs font-medium flex-shrink-0 shadow-md transition-all"
          style="background:linear-gradient(to right,#06b6d4,#0d9488);">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
          Enroll
        </button>
      </div>
    </div>`).join('');

  document.getElementById('result-empty').classList.add('hidden');
  document.getElementById('result-panels').classList.remove('hidden');
}

function hideResults() {
  document.getElementById('result-empty').classList.remove('hidden');
  document.getElementById('result-panels').classList.add('hidden');
}

function generateInterventions(status, riskLevel) {
  const list = [];
  if (['Severely Wasted','Wasted'].includes(status)) {
    list.push({ program:'Supplementary Feeding Program', description:'Immediate enrollment in daily feeding program with high-protein meals', priority:'Critical' });
    list.push({ program:'Therapeutic Nutrition', description:'Ready-to-use therapeutic food (RUTF) supplementation', priority:'High' });
  }
  if (['Stunted','Severely Stunted'].includes(status)) {
    list.push({ program:'Growth Monitoring Program', description:'Monthly weight and height tracking with nutrition counseling', priority:'High' });
    list.push({ program:'Micronutrient Supplementation', description:'Vitamin A, Iron, and Zinc supplementation protocol', priority:'High' });
  }
  if (status === 'Underweight') {
    list.push({ program:'Supplementary Feeding Program', description:'Balanced nutrition meals 5 days a week', priority:'Moderate' });
    list.push({ program:'Family Nutrition Education', description:'Counseling sessions for parents on proper child nutrition', priority:'Moderate' });
  }
  if (status === 'Overweight') {
    list.push({ program:'Healthy Lifestyle Program', description:'Physical activity and dietary modification program', priority:'Moderate' });
  }
  if (status === 'Normal') {
    list.push({ program:'Preventive Nutrition Program', description:'Quarterly monitoring and nutrition education', priority:'Low' });
  }
  if (['High','Severe'].includes(riskLevel)) {
    list.push({ program:'Deworming Protocol', description:'Bi-annual deworming medication', priority:'High' });
  }
  return list;
}

// ── Enroll Modal ──────────────────────────────────────────────────────────────
function openEnroll(program) {
  const child = CHILDREN.find(c => c.id === selectedChildId);
  document.getElementById('enroll-prog-name').textContent     = program;
  document.getElementById('enroll-child-name').value          = child ? child.name : '—';
  document.getElementById('enroll-program-field').value       = program;
  document.getElementById('enroll-notes').value               = '';
  const m = document.getElementById('enroll-modal');
  m.classList.remove('hidden'); m.classList.add('flex');
}
function closeEnroll() {
  const m = document.getElementById('enroll-modal');
  m.classList.add('hidden'); m.classList.remove('flex');
}
function confirmEnroll() {
  const prog  = document.getElementById('enroll-program-field').value;
  const notes = document.getElementById('enroll-notes').value;
  alert('Child enrolled in ' + prog + (notes ? '\nNotes: ' + notes : ''));
  closeEnroll();
}

// ── History Modal ─────────────────────────────────────────────────────────────
function showHistory(childId) {
  const child = CHILDREN.find(c => c.id === childId);
  document.getElementById('history-child-name').textContent = child ? child.name : childId;
  const m = document.getElementById('history-modal');
  m.classList.remove('hidden'); m.classList.add('flex');
}
function closeHistory() {
  const m = document.getElementById('history-modal');
  m.classList.add('hidden'); m.classList.remove('flex');
}

// Backdrop close
['enroll-modal','history-modal'].forEach(id => {
  document.getElementById(id).addEventListener('click', function(e) {
    if (e.target === this) { this.classList.add('hidden'); this.classList.remove('flex'); }
  });
});
</script>

<?php
$page_content = ob_get_clean();
?>
<?= $page_content ?>