<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user'])) {
  header('Location: pages/sign_in.php');
  exit;
}

$role     = $_SESSION['role'] ?? 'bhw';
$userName = $_SESSION['name'] ?? 'Maria Santos';

// ── Chart Data ────────────────────────────────────────────────────────────────
$ageGroupData = json_encode([
  ['name'=>'0-11 months', 'value'=>28, 'color'=>'#ef4444'],
  ['name'=>'12-23 months','value'=>35, 'color'=>'#f59e0b'],
  ['name'=>'24-59 months','value'=>42, 'color'=>'#22c55e'],
]);

$homeVisitsData = json_encode([
  ['week'=>'Week 1','visits'=>12,'target'=>15],
  ['week'=>'Week 2','visits'=>15,'target'=>15],
  ['week'=>'Week 3','visits'=>14,'target'=>15],
  ['week'=>'Week 4','visits'=>13,'target'=>15],
]);

$formSubmissions = [
  ['name'=>'GARNE', 'submitted'=>3,  'pending'=>0],
  ['name'=>'CBMB',  'submitted'=>1,  'pending'=>0],
  ['name'=>'PhilPEN','submitted'=>28,'pending'=>5],
];

// ── Sidebar ───────────────────────────────────────────────────────────────────
$sidebar_active = 'dashboard';
$sidebar_items = [
  'dashboard' => ['label'=>'Dashboard',      'href'=>'dashboard.php', 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
  'records'   => ['label'=>'Health Records', 'href'=>'records.php',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
  'reports'   => ['label'=>'Reports',        'href'=>'reports.php',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zm6-4.5C9 8.004 9.504 7.5 10.125 7.5h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019 19.875V8.625zm6-4.5c0-.621.504-1.125 1.125-1.125h2.25C21.496 3 22 3.504 22 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>'],
  'alerts'    => ['label'=>'Alerts',         'href'=>'alerts.php',    'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>'],
  'bmi'       => ['label'=>'BMI Calculator', 'href'=>'bmi.php',       'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.598 4.5 4.583V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.583c0-.985-.807-1.883-1.907-2.011A48.507 48.507 0 0012 2.25z"/>'],
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

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">BHW Dashboard</span>';

ob_start();
?>

<div class="p-6 space-y-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-2xl p-8 shadow-xl">
    <h1 class="text-3xl font-bold mb-2">My Health Worker Dashboard</h1>
    <p class="text-sm text-white/90">Purok 2 - Gitna Coverage · BHW: <?= htmlspecialchars($userName) ?></p>
  </div>

  <!-- KPI Cards (Primary) -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php
      $kpis = [
        ['label'=>'My Coverage Area',    'value'=>'Purok 2','sub'=>'145 households',       'border'=>'border-teal-500',  'grad'=>'from-teal-500 to-teal-600',  'subColor'=>'text-gray-600',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>'],
        ['label'=>'Residents Under Care','value'=>'568',    'sub'=>'Total residents',       'border'=>'border-blue-500',  'grad'=>'from-blue-500 to-blue-600',  'subColor'=>'text-gray-600',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5"/>'],
        ['label'=>'Pending Assessments', 'value'=>'5',      'sub'=>'Due this week',          'border'=>'border-orange-500','grad'=>'from-orange-500 to-orange-600','subColor'=>'text-orange-600','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
        ['label'=>'Forms Due',           'value'=>'0',      'sub'=>'✓ All submitted',        'border'=>'border-purple-500','grad'=>'from-purple-500 to-purple-600','subColor'=>'text-green-600', 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>'],
      ];
      foreach ($kpis as $k): ?>
      <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow border-l-4 <?= $k['border'] ?> p-6">
        <div class="flex items-start justify-between mb-4">
          <div class="w-14 h-14 rounded-xl bg-gradient-to-br <?= $k['grad'] ?> flex items-center justify-center shadow-lg">
            <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <?= $k['icon'] ?>
            </svg>
          </div>
        </div>
        <div class="text-sm text-gray-600 mb-1"><?= $k['label'] ?></div>
        <div class="text-4xl font-bold mb-2"><?= $k['value'] ?></div>
        <div class="text-xs <?= $k['subColor'] ?> font-medium"><?= $k['sub'] ?></div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Secondary Stats -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php
      $secondary = [
        ['label'=>'Senior Citizens','value'=>'32','sub'=>'In my coverage area','border'=>'border-indigo-500','color'=>'text-indigo-600','bg'=>'bg-indigo-100','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>','trend'=>null],
        ['label'=>'Home Visits',    'value'=>'54','sub'=>'+8 this month',       'border'=>'border-green-500', 'color'=>'text-green-600', 'bg'=>'bg-green-100', 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>','trend'=>'up'],
        ['label'=>'At-Risk Cases',  'value'=>'12','sub'=>'Requires follow-up',  'border'=>'border-red-500',   'color'=>'text-red-600',   'bg'=>'bg-red-100',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>','trend'=>null],
      ];
      foreach ($secondary as $s): ?>
      <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 <?= $s['border'] ?>">
        <div class="flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-600 mb-1"><?= $s['label'] ?></div>
            <div class="text-3xl font-bold <?= $s['color'] ?>"><?= $s['value'] ?></div>
          </div>
          <div class="w-12 h-12 rounded-xl <?= $s['bg'] ?> flex items-center justify-center">
            <svg class="w-6 h-6 <?= $s['color'] ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <?= $s['icon'] ?>
            </svg>
          </div>
        </div>
        <div class="text-xs mt-2 flex items-center gap-1 font-medium <?= $s['trend'] === 'up' ? 'text-green-600' : 'text-gray-500' ?>">
          <?php if ($s['trend'] === 'up'): ?>
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18"/></svg>
          <?php endif; ?>
          <?= $s['sub'] ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Charts Row -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Age Group Distribution Pie -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-6">
        <h3 class="text-lg font-semibold flex items-center gap-2 mb-1">
          <div class="w-2 h-6 rounded-full" style="background:linear-gradient(to bottom,#14b8a6,#059669);"></div>
          Age Group Distribution
        </h3>
        <p class="text-sm text-gray-500">Children in my coverage area (Purok 2)</p>
      </div>
      <div class="flex items-center gap-4">
        <canvas id="ageGroupPie" width="200" height="200" style="max-width:200px;flex-shrink:0;"></canvas>
        <div class="flex-1 space-y-2">
          <div class="flex items-center justify-between text-sm p-2 bg-red-50 rounded-lg">
            <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-red-500"></div><span class="font-medium">0-11 months</span></div>
            <span class="font-bold">28 children</span>
          </div>
          <div class="flex items-center justify-between text-sm p-2 bg-orange-50 rounded-lg">
            <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-amber-500"></div><span class="font-medium">12-23 months</span></div>
            <span class="font-bold">35 children</span>
          </div>
          <div class="flex items-center justify-between text-sm p-2 bg-green-50 rounded-lg">
            <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-green-500"></div><span class="font-medium">24-59 months</span></div>
            <span class="font-bold">42 children</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Home Visits Line Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-6">
        <h3 class="text-lg font-semibold flex items-center gap-2 mb-1">
          <div class="w-2 h-6 rounded-full" style="background:linear-gradient(to bottom,#14b8a6,#059669);"></div>
          Weekly Home Visits
        </h3>
        <p class="text-sm text-gray-500">Current month progress</p>
      </div>
      <canvas id="homeVisitsChart" height="220"></canvas>
    </div>
  </div>

  <!-- Bottom Row -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Submissions -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-6">
        <h3 class="text-lg font-semibold flex items-center gap-2 mb-1">
          <div class="w-2 h-6 rounded-full" style="background:linear-gradient(to bottom,#14b8a6,#059669);"></div>
          Form Submissions
        </h3>
        <p class="text-sm text-gray-500">This month status</p>
      </div>
      <div class="space-y-4">
        <?php foreach ($formSubmissions as $form): ?>
        <div class="p-4 bg-gray-50 rounded-xl">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-semibold"><?= $form['name'] ?></span>
            <span class="text-xs px-2 py-1 rounded-full font-medium <?= $form['pending'] === 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
              <?= $form['pending'] === 0 ? '✓ Complete' : $form['pending'] . ' pending' ?>
            </span>
          </div>
          <div class="flex items-center gap-2 text-xs text-gray-600">
            <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <?= $form['submitted'] ?> submitted
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Priority Tasks -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-6">
        <h3 class="text-lg font-semibold flex items-center gap-2 mb-1">
          <div class="w-2 h-6 rounded-full" style="background:linear-gradient(to bottom,#14b8a6,#059669);"></div>
          Priority Tasks
        </h3>
        <p class="text-sm text-gray-500">Upcoming this week</p>
      </div>
      <div class="space-y-3">
        <?php
          $tasks = [
            ['bg'=>'bg-orange-50','hover'=>'hover:bg-orange-100','iconBg'=>'bg-orange-100','iconColor'=>'text-orange-600','title'=>'5 PhilPEN assessments due','sub'=>'Due by Friday','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>'],
            ['bg'=>'bg-pink-50',  'hover'=>'hover:bg-pink-100',  'iconBg'=>'bg-pink-100',  'iconColor'=>'text-pink-600',  'title'=>'Prenatal checkup reminders','sub'=>'3 pregnant women','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5"/>'],
            ['bg'=>'bg-blue-50',  'hover'=>'hover:bg-blue-100',  'iconBg'=>'bg-blue-100',  'iconColor'=>'text-blue-600',  'title'=>'GARNE report preparation','sub'=>'Next Monday','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>'],
          ];
          foreach ($tasks as $t): ?>
          <div class="flex gap-3 p-3 <?= $t['bg'] ?> <?= $t['hover'] ?> rounded-xl transition-colors cursor-pointer">
            <div class="w-8 h-8 rounded-lg <?= $t['iconBg'] ?> flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4 <?= $t['iconColor'] ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <?= $t['icon'] ?>
              </svg>
            </div>
            <div class="flex-1">
              <div class="text-sm font-medium mb-0.5"><?= $t['title'] ?></div>
              <div class="text-xs text-gray-500"><?= $t['sub'] ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-6">
        <h3 class="text-lg font-semibold flex items-center gap-2 mb-1">
          <div class="w-2 h-6 rounded-full" style="background:linear-gradient(to bottom,#14b8a6,#059669);"></div>
          Recent Activities
        </h3>
        <p class="text-sm text-gray-500">Your latest actions</p>
      </div>
      <div class="space-y-3">
        <?php
          $activities = [
            ['bg'=>'bg-green-50', 'iconBg'=>'bg-green-100', 'iconColor'=>'text-green-600', 'title'=>'Completed PhilPEN for Juan Cruz','time'=>'2 hours ago','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            ['bg'=>'bg-blue-50',  'iconBg'=>'bg-blue-100',  'iconColor'=>'text-blue-600',  'title'=>'Home visit: Santos family',       'time'=>'5 hours ago','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>'],
            ['bg'=>'bg-purple-50','iconBg'=>'bg-purple-100','iconColor'=>'text-purple-600','title'=>'Submitted CBMB report',           'time'=>'1 day ago',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>'],
          ];
          foreach ($activities as $a): ?>
          <div class="flex gap-3 p-3 <?= $a['bg'] ?> rounded-xl">
            <div class="w-8 h-8 rounded-lg <?= $a['iconBg'] ?> flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4 <?= $a['iconColor'] ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <?= $a['icon'] ?>
              </svg>
            </div>
            <div class="flex-1">
              <div class="text-sm font-medium mb-0.5"><?= $a['title'] ?></div>
              <div class="text-xs text-gray-500"><?= $a['time'] ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ageData   = <?= $ageGroupData ?>;
const visitData = <?= $homeVisitsData ?>;

// ── 1. Age Group Pie ──────────────────────────────────────────────────────────
new Chart(document.getElementById('ageGroupPie'), {
  type: 'pie',
  data: {
    labels: ageData.map(d => d.name),
    datasets: [{
      data: ageData.map(d => d.value),
      backgroundColor: ageData.map(d => d.color),
      borderWidth: 2,
      borderColor: '#fff',
    }]
  },
  options: {
    plugins: {
      legend: { display: false },
      tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} children` } }
    },
  }
});

// ── 2. Home Visits Line Chart ─────────────────────────────────────────────────
new Chart(document.getElementById('homeVisitsChart'), {
  type: 'line',
  data: {
    labels: visitData.map(d => d.week),
    datasets: [
      {
        label: 'Visits Made',
        data: visitData.map(d => d.visits),
        borderColor: '#10b981',
        backgroundColor: 'rgba(16,185,129,0.1)',
        borderWidth: 3,
        pointRadius: 6,
        pointBackgroundColor: '#10b981',
        fill: true,
        tension: 0.3,
      },
      {
        label: 'Target',
        data: visitData.map(d => d.target),
        borderColor: '#94a3b8',
        borderWidth: 2,
        borderDash: [5, 5],
        pointRadius: 4,
        pointBackgroundColor: '#94a3b8',
        fill: false,
        tension: 0,
      }
    ]
  },
  options: {
    plugins: { legend: { position: 'bottom' } },
    scales: {
      y: { beginAtZero: true, max: 20, grid: { color: '#f0f0f0' } },
      x: { grid: { display: false } },
    },
  }
});
</script>

<?php
$page_content = ob_get_clean();
?>
<?= $page_content ?>