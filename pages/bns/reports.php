<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$role     = $_SESSION['role'] ?? 'bns';
$userName = $_SESSION['name'] ?? 'Rosa Mendoza';

// ── Handle form submissions ───────────────────────────────────────────────────
$successMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $formType = $_POST['form_type'] ?? '';
  // In real app: save to DB. For demo, just show success.
  $successMsg = match($formType) {
    'opt'         => 'OPT Report submitted successfully!',
    'nutrition'   => 'Nutrition Status Report submitted successfully!',
    'maternal'    => 'Maternal Health Report submitted successfully!',
    'supplementation' => 'Supplementation Report submitted successfully!',
    default       => 'Report submitted successfully!'
  };
}

// ── Sidebar setup ─────────────────────────────────────────────────────────────
$sidebar_active = 'reports';
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

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">BNS Reports</span>';

// ── Data ──────────────────────────────────────────────────────────────────────
$months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
$years  = ['2026','2025','2024'];
$puroks = ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5'];
$quarters = ['1st','2nd','3rd','4th'];

// Active tab from GET (default: opt)
$activeTab = $_GET['tab'] ?? 'opt';

ob_start();
?>

<div class="p-6 space-y-6">

  <!-- Header -->
  <div>
    <h1 class="text-2xl font-bold mb-1">BNS Reports</h1>
    <p class="text-sm text-gray-600">Submit and manage your nutrition monitoring reports · <?= htmlspecialchars($userName) ?></p>
  </div>

  <!-- Success Message -->
  <?php if ($successMsg): ?>
    <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">
      <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <?= htmlspecialchars($successMsg) ?>
    </div>
  <?php endif; ?>

  <!-- Tabs -->
  <?php
    $tabs = [
      'opt'           => 'OPT / Weight Monitoring',
      'nutrition'     => 'Nutritional Status Report',
      'maternal'      => 'Maternal Health Report',
      'supplementation'=> 'Supplementation Report',
      'masterlist'    => 'Child Masterlist',
    ];
  ?>
  <div class="flex gap-2 flex-wrap bg-gray-100 p-1 rounded-xl border border-gray-200 w-fit">
    <?php foreach ($tabs as $id => $label): ?>
      <a
        href="?tab=<?= $id ?>"
        class="px-4 py-2 rounded-lg text-sm font-semibold transition-all <?= $activeTab === $id ? 'bg-white text-violet-700 shadow-sm' : 'text-gray-600 hover:text-gray-900' ?>"
      >
        <?= htmlspecialchars($label) ?>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- ══ OPT / WEIGHT MONITORING ══════════════════════════════════════════ -->
  <?php if ($activeTab === 'opt'): ?>
  <div class="bg-white rounded-2xl shadow-lg">
    <div class="p-6 border-b border-gray-200">
      <h3 class="text-lg font-semibold mb-1">Operation Timbang Plus (OPT+) Report</h3>
      <p class="text-sm text-gray-500">Monthly weight & height monitoring for children 0–59 months</p>
    </div>
    <form method="POST" action="?tab=opt" class="p-6 space-y-6">
      <input type="hidden" name="form_type" value="opt" />

      <!-- Period -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Month</label>
          <select name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php foreach ($months as $m): ?>
              <option <?= $m === 'March' ? 'selected' : '' ?>><?= $m ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Year</label>
          <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php foreach ($years as $y): ?>
              <option><?= $y ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Purok</label>
          <select name="purok" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
            <option value="all">All Puroks</option>
            <?php foreach ($puroks as $p): ?>
              <option><?= $p ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- OPT Fields -->
      <?php
        $optSections = [
          'WEIGHING COVERAGE' => [
            ['key'=>'total_registered',   'label'=>'Total No. of Children Registered (0-59 months)'],
            ['key'=>'total_weighed',      'label'=>'Total No. of Children Weighed'],
            ['key'=>'total_not_weighed',  'label'=>'Total No. of Children Not Weighed'],
            ['key'=>'weighing_coverage',  'label'=>'Weighing Coverage (%)'],
          ],
          'NUTRITIONAL STATUS (Weight for Age)' => [
            ['key'=>'severely_uw',   'label'=>'Severely Underweight (SUW)'],
            ['key'=>'underweight',   'label'=>'Underweight (UW)'],
            ['key'=>'normal_wfa',    'label'=>'Normal'],
            ['key'=>'overweight_wfa','label'=>'Overweight'],
          ],
          'NUTRITIONAL STATUS (Height for Age)' => [
            ['key'=>'severely_stunted','label'=>'Severely Stunted'],
            ['key'=>'stunted',         'label'=>'Stunted'],
            ['key'=>'normal_hfa',      'label'=>'Normal'],
            ['key'=>'tall',            'label'=>'Tall'],
          ],
          'NUTRITIONAL STATUS (Weight for Height)' => [
            ['key'=>'severely_wasted','label'=>'Severely Wasted'],
            ['key'=>'wasted',         'label'=>'Wasted'],
            ['key'=>'normal_wfh',     'label'=>'Normal'],
            ['key'=>'obese',          'label'=>'Obese'],
          ],
        ];
        foreach ($optSections as $section => $fields): ?>
        <div>
          <div class="bg-gradient-to-r from-violet-500 to-purple-600 text-white px-4 py-2 rounded-lg mb-3 text-sm font-bold">
            <?= htmlspecialchars($section) ?>
          </div>
          <div class="space-y-0">
            <?php foreach ($fields as $field): ?>
              <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
                <label class="text-sm text-gray-700 flex-1"><?= htmlspecialchars($field['label']) ?></label>
                <input
                  type="number" min="0" name="<?= $field['key'] ?>"
                  placeholder="0"
                  class="w-24 px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-violet-500"
                />
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="flex gap-3 pt-2">
        <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-lg text-white text-sm font-medium shadow-lg transition-all" style="background:linear-gradient(to right,#7c3aed,#6d28d9);" onmouseover="this.style.background='linear-gradient(to right,#6d28d9,#5b21b6)'" onmouseout="this.style.background='linear-gradient(to right,#7c3aed,#6d28d9)'">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Submit OPT Report
        </button>
        <button type="reset" class="px-6 py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 text-sm font-medium hover:border-gray-400 bg-white transition-all">Reset</button>
      </div>
    </form>
  </div>

  <!-- ══ NUTRITIONAL STATUS REPORT ════════════════════════════════════════ -->
  <?php elseif ($activeTab === 'nutrition'): ?>
  <div class="bg-white rounded-2xl shadow-lg">
    <div class="p-6 border-b border-gray-200">
      <h3 class="text-lg font-semibold mb-1">Nutritional Status Monitoring Report</h3>
      <p class="text-sm text-gray-500">Quarterly summary for the Municipal Nutrition Office</p>
    </div>
    <form method="POST" action="?tab=nutrition" class="p-6 space-y-6">
      <input type="hidden" name="form_type" value="nutrition" />

      <!-- Period -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Quarter</label>
          <div class="flex gap-2 bg-gray-100 p-1 rounded-lg border border-gray-200">
            <?php foreach ($quarters as $q): ?>
              <label class="flex-1">
                <input type="radio" name="quarter" value="<?= $q ?>" class="sr-only" <?= $q === '1st' ? 'checked' : '' ?> />
                <span class="block text-center py-1.5 rounded-md text-sm font-semibold cursor-pointer transition-all quarter-btn" data-value="<?= $q ?>"><?= $q ?> Qtr</span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Year</label>
          <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php foreach ($years as $y): ?><option><?= $y ?></option><?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Nutrition fields per purok -->
      <?php foreach ($puroks as $purok): ?>
        <div>
          <div class="bg-gradient-to-r from-violet-500 to-purple-600 text-white px-4 py-2 rounded-lg mb-3 text-sm font-bold">
            <?= htmlspecialchars($purok) ?>
          </div>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <?php
              $nutFields = ['Normal','Underweight','Stunted','Wasted','Severely Underweight','Severely Stunted','Severely Wasted','Overweight'];
              foreach ($nutFields as $nf):
                $key = strtolower(str_replace([' ','-'], '_', $purok)) . '_' . strtolower(str_replace(' ','_',$nf));
            ?>
              <div>
                <label class="block text-xs font-medium text-gray-600 mb-1"><?= htmlspecialchars($nf) ?></label>
                <input type="number" min="0" name="<?= $key ?>" placeholder="0"
                  class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-violet-500" />
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="flex gap-3 pt-2">
        <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-lg text-white text-sm font-medium shadow-lg" style="background:linear-gradient(to right,#7c3aed,#6d28d9);">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Submit Report
        </button>
        <button type="reset" class="px-6 py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 text-sm font-medium bg-white">Reset</button>
      </div>
    </form>
  </div>

  <!-- ══ MATERNAL HEALTH REPORT ════════════════════════════════════════════ -->
  <?php elseif ($activeTab === 'maternal'): ?>
  <div class="bg-white rounded-2xl shadow-lg">
    <div class="p-6 border-b border-gray-200">
      <h3 class="text-lg font-semibold mb-1">Maternal Health &amp; Prenatal Monitoring Report</h3>
      <p class="text-sm text-gray-500">Monthly tracking of pregnant and lactating women</p>
    </div>
    <form method="POST" action="?tab=maternal" class="p-6 space-y-6">
      <input type="hidden" name="form_type" value="maternal" />

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Month</label>
          <select name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php foreach ($months as $m): ?><option <?= $m==='March'?'selected':'' ?>><?= $m ?></option><?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Year</label>
          <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php foreach ($years as $y): ?><option><?= $y ?></option><?php endforeach; ?>
          </select>
        </div>
      </div>

      <?php
        $maternalSections = [
          'PREGNANT WOMEN' => [
            ['key'=>'preg_total',      'label'=>'Total Number of Pregnant Women'],
            ['key'=>'preg_new',        'label'=>'Newly Registered Pregnant Women'],
            ['key'=>'preg_atrisk',     'label'=>'Pregnant Women Identified as High-Risk'],
            ['key'=>'preg_prenatal1',  'label'=>'With 1st Trimester Prenatal Visit (1–12 wks)'],
            ['key'=>'preg_prenatal2',  'label'=>'With 2nd Trimester Prenatal Visit (13–26 wks)'],
            ['key'=>'preg_prenatal3',  'label'=>'With 3rd Trimester Prenatal Visit (27–40 wks)'],
            ['key'=>'preg_tt2',        'label'=>'Given TT2+ Vaccine'],
            ['key'=>'preg_ferrous',    'label'=>'Given Ferrous Sulfate Supplement'],
            ['key'=>'preg_folicacid',  'label'=>'Given Folic Acid Supplement'],
          ],
          'LACTATING WOMEN' => [
            ['key'=>'lact_total',       'label'=>'Total Lactating Women Monitored'],
            ['key'=>'lact_breastfeed',  'label'=>'Exclusively Breastfeeding (0–6 months)'],
            ['key'=>'lact_counseled',   'label'=>'Given Breastfeeding Counseling'],
          ],
          'BIRTH OUTCOMES' => [
            ['key'=>'birth_live',       'label'=>'Live Births This Month'],
            ['key'=>'birth_preterm',    'label'=>'Preterm Births'],
            ['key'=>'birth_stillbirth', 'label'=>'Stillbirths'],
            ['key'=>'birth_lowweight',  'label'=>'Low Birth Weight Newborns (<2.5 kg)'],
            ['key'=>'maternal_deaths',  'label'=>'Maternal Deaths'],
          ],
        ];
        foreach ($maternalSections as $section => $fields): ?>
        <div>
          <div class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-4 py-2 rounded-lg mb-3 text-sm font-bold">
            <?= htmlspecialchars($section) ?>
          </div>
          <?php foreach ($fields as $f): ?>
            <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
              <label class="text-sm text-gray-700 flex-1"><?= htmlspecialchars($f['label']) ?></label>
              <input type="number" min="0" name="<?= $f['key'] ?>" placeholder="0"
                class="w-24 px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-pink-500" />
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>

      <div class="flex gap-3 pt-2">
        <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-lg text-white text-sm font-medium shadow-lg" style="background:linear-gradient(to right,#ec4899,#e11d48);">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Submit Maternal Report
        </button>
        <button type="reset" class="px-6 py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 text-sm font-medium bg-white">Reset</button>
      </div>
    </form>
  </div>

  <!-- ══ SUPPLEMENTATION REPORT ════════════════════════════════════════════ -->
  <?php elseif ($activeTab === 'supplementation'): ?>
  <div class="bg-white rounded-2xl shadow-lg">
    <div class="p-6 border-b border-gray-200">
      <h3 class="text-lg font-semibold mb-1">Micronutrient Supplementation Report</h3>
      <p class="text-sm text-gray-500">Monthly reporting on Vitamin A, Iron, and other supplements given</p>
    </div>
    <form method="POST" action="?tab=supplementation" class="p-6 space-y-6">
      <input type="hidden" name="form_type" value="supplementation" />

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Month</label>
          <select name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php foreach ($months as $m): ?><option <?= $m==='March'?'selected':'' ?>><?= $m ?></option><?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Year</label>
          <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php foreach ($years as $y): ?><option><?= $y ?></option><?php endforeach; ?>
          </select>
        </div>
      </div>

      <?php
        $suppSections = [
          'VITAMIN A SUPPLEMENTATION' => [
            ['key'=>'vita_6to11',    'label'=>'Children 6–11 months given Vitamin A (100,000 IU)'],
            ['key'=>'vita_12to59',   'label'=>'Children 12–59 months given Vitamin A (200,000 IU)'],
            ['key'=>'vita_pp',       'label'=>'Postpartum Women given Vitamin A (200,000 IU within 4 wks)'],
            ['key'=>'vita_coverage', 'label'=>'Vitamin A Coverage Rate (%)'],
          ],
          'IRON SUPPLEMENTATION' => [
            ['key'=>'iron_preg',      'label'=>'Pregnant Women given Ferrous Sulfate'],
            ['key'=>'iron_lact',      'label'=>'Lactating Women given Ferrous Sulfate'],
            ['key'=>'iron_child',     'label'=>'Children 6–23 months given Iron Drops'],
            ['key'=>'iron_atrisk',    'label'=>'At-Risk Children given Iron Supplement'],
          ],
          'OTHER MICRONUTRIENTS' => [
            ['key'=>'zinc_children',  'label'=>'Children given Zinc Supplementation'],
            ['key'=>'iodized_hh',     'label'=>'Households Using Iodized Salt'],
            ['key'=>'deworming_1to4', 'label'=>'Children 1–4 yrs given Deworming (Albendazole)'],
            ['key'=>'deworming_5to12','label'=>'Children 5–12 yrs given Deworming'],
          ],
        ];
        foreach ($suppSections as $section => $fields): ?>
        <div>
          <div class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-2 rounded-lg mb-3 text-sm font-bold">
            <?= htmlspecialchars($section) ?>
          </div>
          <?php foreach ($fields as $f): ?>
            <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
              <label class="text-sm text-gray-700 flex-1"><?= htmlspecialchars($f['label']) ?></label>
              <input type="number" min="0" name="<?= $f['key'] ?>" placeholder="0"
                class="w-24 px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-amber-500" />
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>

      <div class="flex gap-3 pt-2">
        <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-lg text-white text-sm font-medium shadow-lg" style="background:linear-gradient(to right,#f59e0b,#ea580c);">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Submit Supplementation Report
        </button>
        <button type="reset" class="px-6 py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 text-sm font-medium bg-white">Reset</button>
      </div>
    </form>
  </div>

  <!-- ══ CHILD MASTERLIST ══════════════════════════════════════════════════ -->
  <?php elseif ($activeTab === 'masterlist'): ?>
  <?php
    // Mock children data
    $children = [
      ['id'=>1,'surname'=>'Dela Cruz','firstname'=>'Maria','birthday'=>'2022-03-15','gender'=>'F','purok'=>'Purok 1','status'=>'Normal',      'weight'=>13.2,'height'=>92.5],
      ['id'=>2,'surname'=>'Garcia',  'firstname'=>'Jose', 'birthday'=>'2023-07-22','gender'=>'M','purok'=>'Purok 1','status'=>'Underweight',  'weight'=>10.1,'height'=>84.0],
      ['id'=>3,'surname'=>'Santos',  'firstname'=>'Ana',  'birthday'=>'2020-05-10','gender'=>'F','purok'=>'Purok 2','status'=>'Stunted',       'weight'=>14.5,'height'=>88.0],
      ['id'=>4,'surname'=>'Reyes',   'firstname'=>'Pedro','birthday'=>'2019-11-03','gender'=>'M','purok'=>'Purok 2','status'=>'Normal',        'weight'=>18.2,'height'=>105.0],
      ['id'=>5,'surname'=>'Cruz',    'firstname'=>'Rosa', 'birthday'=>'2024-01-20','gender'=>'F','purok'=>'Purok 3','status'=>'Severely Wasted','weight'=>6.8,'height'=>72.5],
      ['id'=>6,'surname'=>'Bautista','firstname'=>'Luis', 'birthday'=>'2021-04-12','gender'=>'M','purok'=>'Purok 3','status'=>'Normal',        'weight'=>15.0,'height'=>97.0],
      ['id'=>7,'surname'=>'Torres',  'firstname'=>'Eva',  'birthday'=>'2023-09-01','gender'=>'F','purok'=>'Purok 4','status'=>'Wasted',        'weight'=>9.2, 'height'=>80.5],
    ];

    function calcAgeMonths($birthday) {
      $now  = new DateTime();
      $bday = new DateTime($birthday);
      return $now->diff($bday)->y * 12 + $now->diff($bday)->m;
    }

    $statusColors = [
      'Normal'          => 'bg-green-100 text-green-700',
      'Underweight'     => 'bg-yellow-100 text-yellow-700',
      'Stunted'         => 'bg-orange-100 text-orange-700',
      'Wasted'          => 'bg-red-100 text-red-700',
      'Severely Wasted' => 'bg-red-200 text-red-800',
      'Overweight'      => 'bg-blue-100 text-blue-700',
    ];
  ?>
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between flex-wrap gap-3">
      <div>
        <h3 class="text-lg font-semibold mb-1">Child Masterlist (0–59 months)</h3>
        <p class="text-sm text-gray-500">Comprehensive list of all monitored children</p>
      </div>
      <div class="flex gap-2">
        <select id="purok-filter" onchange="filterMasterlist()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
          <option value="all">All Puroks</option>
          <?php foreach ($puroks as $p): ?><option><?= $p ?></option><?php endforeach; ?>
        </select>
        <select id="status-filter-ml" onchange="filterMasterlist()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
          <option value="all">All Status</option>
          <?php foreach (array_keys($statusColors) as $s): ?><option><?= $s ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full" id="masterlist-table">
        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
          <tr>
            <th class="text-left p-4 text-xs font-semibold text-gray-600 uppercase">No.</th>
            <th class="text-left p-4 text-xs font-semibold text-gray-600 uppercase">Child Name</th>
            <th class="text-left p-4 text-xs font-semibold text-gray-600 uppercase">Age (mos)</th>
            <th class="text-left p-4 text-xs font-semibold text-gray-600 uppercase">Sex</th>
            <th class="text-left p-4 text-xs font-semibold text-gray-600 uppercase">Purok</th>
            <th class="text-left p-4 text-xs font-semibold text-gray-600 uppercase">Weight (kg)</th>
            <th class="text-left p-4 text-xs font-semibold text-gray-600 uppercase">Height (cm)</th>
            <th class="text-left p-4 text-xs font-semibold text-gray-600 uppercase">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($children as $i => $child): ?>
            <tr class="border-b border-gray-100 hover:bg-violet-50 transition-colors masterlist-row"
                data-purok="<?= htmlspecialchars($child['purok']) ?>"
                data-status="<?= htmlspecialchars($child['status']) ?>">
              <td class="p-4 text-sm font-mono text-gray-500"><?= $i + 1 ?></td>
              <td class="p-4">
                <div class="text-sm font-semibold"><?= htmlspecialchars($child['surname'].', '.$child['firstname']) ?></div>
              </td>
              <td class="p-4 text-sm text-gray-600"><?= calcAgeMonths($child['birthday']) ?></td>
              <td class="p-4 text-sm text-gray-600"><?= htmlspecialchars($child['gender']) ?></td>
              <td class="p-4 text-sm text-gray-600"><?= htmlspecialchars($child['purok']) ?></td>
              <td class="p-4 text-sm font-medium"><?= $child['weight'] ?></td>
              <td class="p-4 text-sm font-medium"><?= $child['height'] ?></td>
              <td class="p-4">
                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusColors[$child['status']] ?? 'bg-gray-100 text-gray-700' ?>">
                  <?= htmlspecialchars($child['status']) ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="p-4 border-t border-gray-200 bg-gray-50">
      <div class="text-sm text-gray-600 font-medium" id="masterlist-count">
        Showing <?= count($children) ?> children
      </div>
    </div>
  </div>

  <script>
  function filterMasterlist() {
    const purok  = document.getElementById('purok-filter').value;
    const status = document.getElementById('status-filter-ml').value;
    const rows   = document.querySelectorAll('.masterlist-row');
    let visible  = 0;
    rows.forEach(row => {
      const matchP = purok  === 'all' || row.dataset.purok  === purok;
      const matchS = status === 'all' || row.dataset.status === status;
      row.style.display = (matchP && matchS) ? '' : 'none';
      if (matchP && matchS) visible++;
    });
    document.getElementById('masterlist-count').textContent = `Showing ${visible} children`;
  }
  </script>
  <?php endif; ?>

</div>

<script>
// Quarter radio pill styling
document.querySelectorAll('.quarter-btn').forEach(btn => {
  const radio = btn.parentElement.querySelector('input[type=radio]');
  const updateStyle = () => {
    btn.classList.toggle('bg-white', radio.checked);
    btn.classList.toggle('text-violet-700', radio.checked);
    btn.classList.toggle('shadow-sm', radio.checked);
    btn.classList.toggle('text-gray-600', !radio.checked);
  };
  updateStyle();
  radio.addEventListener('change', () => {
    document.querySelectorAll('.quarter-btn').forEach(b => {
      const r = b.parentElement.querySelector('input[type=radio]');
      b.classList.toggle('bg-white',       r.checked);
      b.classList.toggle('text-violet-700',r.checked);
      b.classList.toggle('shadow-sm',      r.checked);
      b.classList.toggle('text-gray-600', !r.checked);
    });
  });
  btn.addEventListener('click', () => { radio.checked = true; radio.dispatchEvent(new Event('change')); });
});
</script>

<?php
$page_content = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BNS Reports – NutriGuard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="margin:0;font-family:sans-serif;">
  <?php include 'sidebar.php'; ?>
</body>
</html>