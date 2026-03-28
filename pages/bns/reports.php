<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$role     = $_SESSION['role'] ?? 'bns';
$userName = $_SESSION['name'] ?? 'Ana Reyes';

// ── Data ──────────────────────────────────────────────────────────────────────
$pregnantWomen = [
  ['no'=>1,'surname'=>'Capacia','firstname'=>'Maricon','middlename'=>'Olivar','age'=>33,'address'=>'Purok 2, Tuy, Batangas','contact'=>'09551593652','lmp'=>'2025-08-15','edd'=>'2026-05-22'],
  ['no'=>2,'surname'=>'Hernandez','firstname'=>'Elena','middlename'=>'Vega','age'=>38,'address'=>'Purok 1, Tuy, Batangas','contact'=>'09678901234','lmp'=>'2025-10-05','edd'=>'2026-07-12'],
  ['no'=>3,'surname'=>'Mendoza','firstname'=>'Josefa','middlename'=>'Torres','age'=>26,'address'=>'Purok 3, Tuy, Batangas','contact'=>'09789012345','lmp'=>'2025-09-20','edd'=>'2026-06-27'],
];

$pregnancyOutcomes = [
  [
    'no'=>1,'date'=>'2-12-26','name'=>'Capacia, Maricon Olivar',
    'liveBirthDate'=>'5-22-26','liveBirthWeight'=>'3.2 kg',
    'pretermDate'=>'—','pretermWeight'=>'—',
    'stillbirth'=>'—','abortion'=>'—',
    'postnatal24h'=>'5-22-26','postnatal3d'=>'5-25-26',
    'postnatal7d'=>'6-2-26','postnatal3w'=>'—',
    'maternalDeath'=>'—','infantDeath'=>'—',
    'remarks'=>'Healthy baby',
  ],
];

$children = [
  ['no'=>1,'name'=>'Cruz, Juan Dela Jr.','birthday'=>'2023-01-15','age_mos'=>36,'sex'=>'M','address'=>'Purok 1, Tuy, Batangas','weight'=>14.5,'height'=>95,'status'=>'Normal','bcg'=>'✓','dpt1'=>'✓','dpt2'=>'✓','dpt3'=>'✓','opv1'=>'✓','opv2'=>'✓','opv3'=>'✓','measles'=>'✓','vitA'=>'✓','fully'=>'Yes'],
  ['no'=>2,'name'=>'Santos, Ana','birthday'=>'2024-02-10','age_mos'=>24,'sex'=>'F','address'=>'Purok 1, Tuy, Batangas','weight'=>10.2,'height'=>85,'status'=>'Underweight','bcg'=>'✓','dpt1'=>'✓','dpt2'=>'✓','dpt3'=>'✓','opv1'=>'✓','opv2'=>'✓','opv3'=>'—','measles'=>'—','vitA'=>'✓','fully'=>'No'],
  ['no'=>3,'name'=>'Garcia, Maria','birthday'=>'2023-11-05','age_mos'=>28,'sex'=>'F','address'=>'Purok 3, Tuy, Batangas','weight'=>9.5,'height'=>82,'status'=>'Severely Wasted','bcg'=>'✓','dpt1'=>'✓','dpt2'=>'✓','dpt3'=>'—','opv1'=>'✓','opv2'=>'—','opv3'=>'—','measles'=>'—','vitA'=>'—','fully'=>'No'],
];

$statusColors = [
  'Normal'          => 'bg-green-100 text-green-700',
  'Underweight'     => 'bg-yellow-100 text-yellow-700',
  'Stunted'         => 'bg-orange-100 text-orange-700',
  'Wasted'          => 'bg-red-100 text-red-700',
  'Severely Wasted' => 'bg-red-200 text-red-800',
  'Overweight'      => 'bg-blue-100 text-blue-700',
];

// Active report type from GET
$activeReport = $_GET['report'] ?? 'pregnant';

// ── Sidebar ───────────────────────────────────────────────────────────────────
$sidebar_active = 'reports';
$sidebar_items = [
  'dashboard' => ['label'=>'Dashboard',      'href'=>'dashboard.php',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
  'records'   => ['label'=>'Health Records', 'href'=>'records_bns.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
  'programs'  => ['label'=>'Programs',       'href'=>'programs.php',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>'],
  'reports'   => ['label'=>'Reports',        'href'=>'bns_reports.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zm6-4.5C9 8.004 9.504 7.5 10.125 7.5h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019 19.875V8.625zm6-4.5c0-.621.504-1.125 1.125-1.125h2.25C21.496 3 22 3.504 22 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>'],
  'alerts'    => ['label'=>'Alerts',         'href'=>'alerts.php',     'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>'],
  'bmi'       => ['label'=>'BMI Calculator', 'href'=>'bmi.php',        'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.598 4.5 4.583V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.583c0-.985-.807-1.883-1.907-2.011A48.507 48.507 0 0012 2.25z"/>'],
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

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">BNS Reports</span>';

ob_start();
?>

<div class="p-6 space-y-6 bg-gray-50 min-h-screen">

  <!-- Header Banner -->
  <div class="rounded-2xl p-8 shadow-xl text-white" style="background:linear-gradient(to right,#7c3aed,#db2777);">
    <div class="flex items-start justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-3xl font-bold mb-1">BNS Reports</h1>
        <p class="text-sm text-white/90">Maternal &amp; Child Health Documentation · BNS: <?= htmlspecialchars($userName) ?></p>
      </div>
      <div class="flex gap-3">
        <button onclick="window.print()"
          class="flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all border border-white/30">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/>
          </svg>
          Print
        </button>
        <button onclick="exportReport()"
          class="flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all border border-white/30">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
          </svg>
          Export
        </button>
      </div>
    </div>
  </div>

  <!-- Report Type Selector -->
  <div class="bg-white rounded-2xl shadow-lg p-6">
    <h2 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2">
      <svg class="w-5 h-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
      </svg>
      Select Report Type
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

      <?php
        $reportTypes = [
          [
            'key'   => 'pregnant',
            'label' => 'Pregnant Women Tracker',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
          ],
          [
            'key'   => 'outcomes',
            'label' => 'Pregnancy Outcomes',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
          ],
          [
            'key'   => 'children',
            'label' => 'Children Health & Immunization (0-59 months)',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>',
          ],
        ];
        foreach ($reportTypes as $rt):
          $isActive = $activeReport === $rt['key'];
      ?>
        <a href="?report=<?= $rt['key'] ?>"
          class="flex items-center gap-3 p-5 rounded-xl border-2 transition-all cursor-pointer <?= $isActive ? 'border-purple-500 bg-purple-50 shadow-md' : 'border-gray-200 hover:border-purple-300 bg-white' ?>">
          <svg class="w-6 h-6 flex-shrink-0 <?= $isActive ? 'text-purple-600' : 'text-gray-400' ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <?= $rt['icon'] ?>
          </svg>
          <span class="text-sm font-semibold <?= $isActive ? 'text-purple-700' : 'text-gray-600' ?>"><?= htmlspecialchars($rt['label']) ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ══ PREGNANT WOMEN TRACKER ═════════════════════════════════════════════ -->
  <?php if ($activeReport === 'pregnant'): ?>
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden" id="print-area">
    <div class="p-6 border-b border-gray-200">
      <h3 class="text-xl font-bold text-gray-900 mb-1">Pagsubaybay sa mga Buntis</h3>
      <p class="text-sm text-gray-500">Target Client List for Pregnant Women · Regional Safe Motherhood Program · Tuy, Batangas</p>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b-2 border-gray-200">
          <tr>
            <th class="text-left p-3 text-xs font-bold text-gray-600 uppercase">No.</th>
            <th class="text-left p-3 text-xs font-bold text-gray-600 uppercase">Full Name</th>
            <th class="text-left p-3 text-xs font-bold text-gray-600 uppercase">Age</th>
            <th class="text-left p-3 text-xs font-bold text-gray-600 uppercase">Address</th>
            <th class="text-left p-3 text-xs font-bold text-gray-600 uppercase">Contact</th>
            <th class="text-left p-3 text-xs font-bold text-gray-600 uppercase">LMP</th>
            <th class="text-left p-3 text-xs font-bold text-gray-600 uppercase">EDD</th>
            <?php
              $prenatalWeeks = ['1-12 WKS','13-20 WKS','21-26 WKS','27-30 WKS','31-34 WKS','35-36 WKS','37-38 WKS','39-40 WKS','Postnatal'];
              foreach ($prenatalWeeks as $wk): ?>
              <th class="text-center p-3 text-xs font-bold text-gray-600 uppercase whitespace-nowrap"><?= $wk ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pregnantWomen as $i => $pw): ?>
          <tr class="border-b border-gray-100 hover:bg-purple-50 transition-colors <?= $i % 2 === 0 ? 'bg-white' : 'bg-gray-50/50' ?>">
            <td class="p-3 font-medium text-gray-500"><?= $pw['no'] ?></td>
            <td class="p-3 font-semibold text-gray-900"><?= htmlspecialchars($pw['surname'].', '.$pw['firstname'].' '.$pw['middlename']) ?></td>
            <td class="p-3 text-gray-600"><?= $pw['age'] ?></td>
            <td class="p-3 text-xs text-gray-600"><?= htmlspecialchars($pw['address']) ?></td>
            <td class="p-3 text-xs text-gray-600"><?= htmlspecialchars($pw['contact']) ?></td>
            <td class="p-3 text-xs font-mono text-gray-700"><?= $pw['lmp'] ?></td>
            <td class="p-3 text-xs font-mono text-gray-700"><?= $pw['edd'] ?></td>
            <?php for ($j = 0; $j < 9; $j++): ?>
              <td class="p-3 text-center text-gray-300 text-base">—</td>
            <?php endfor; ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ══ PREGNANCY OUTCOMES ════════════════════════════════════════════════ -->
  <?php elseif ($activeReport === 'outcomes'): ?>
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden" id="print-area">
    <div class="p-6 border-b border-gray-200">
      <h3 class="text-xl font-bold text-gray-900 mb-1">Kinalabasan ng Pagbubuntis</h3>
      <p class="text-sm text-gray-500">Pregnancy Outcomes · Regional Safe Motherhood Program · Tuy, Batangas</p>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-xs">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="text-left p-3 font-bold text-gray-600 uppercase border-r border-gray-200" rowspan="2">No.</th>
            <th class="text-left p-3 font-bold text-gray-600 uppercase border-r border-gray-200" rowspan="2">Petsa ng Pagtatala</th>
            <th class="text-left p-3 font-bold text-gray-600 uppercase border-r border-gray-200" rowspan="2">Buong Pangalan</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase border-r border-gray-200 bg-green-50" colspan="2">Ipinanganak nang Buhay<br><span class="font-normal text-[10px]">(Live Birth, 37-41 wks)</span></th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase border-r border-gray-200 bg-yellow-50" colspan="2">Ipinanganak nang Kulang<br><span class="font-normal text-[10px]">(Preterm, &lt;37 wks)</span></th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase border-r border-gray-200 bg-orange-50">Sinapupunan<br><span class="font-normal text-[10px]">(Stillbirth, ≥20 wks)</span></th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase border-r border-gray-200 bg-red-50">Naagas/Nalaglag<br><span class="font-normal text-[10px]">(Abortion, &lt;20 wks)</span></th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase border-r border-gray-200 bg-blue-50" colspan="4">Maternal &amp; Child Postnatal Check-ups</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase border-r border-gray-200 bg-purple-50" colspan="2">Civil Registration</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-pink-50">Remarks</th>
          </tr>
          <tr class="bg-gray-100 border-b border-gray-200">
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">Petsa</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">Timbang</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">Petsa</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">Timbang</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">Petsa</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">Petsa</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">24 hrs</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">3rd day</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">7-14 day</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">3rd week</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">Maternal Death</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold border-r border-gray-200">Infant Death</th>
            <th class="text-center p-2 text-[10px] text-gray-600 font-semibold"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pregnancyOutcomes as $o): ?>
          <tr class="border-b border-gray-100 hover:bg-gray-50">
            <td class="p-3 border-r border-gray-200"><?= $o['no'] ?></td>
            <td class="p-3 font-mono border-r border-gray-200"><?= $o['date'] ?></td>
            <td class="p-3 font-semibold border-r border-gray-200"><?= htmlspecialchars($o['name']) ?></td>
            <td class="p-3 text-center font-mono border-r border-gray-200"><?= $o['liveBirthDate'] ?></td>
            <td class="p-3 text-center border-r border-gray-200"><?= $o['liveBirthWeight'] ?></td>
            <td class="p-3 text-center text-gray-400 border-r border-gray-200"><?= $o['pretermDate'] ?></td>
            <td class="p-3 text-center text-gray-400 border-r border-gray-200"><?= $o['pretermWeight'] ?></td>
            <td class="p-3 text-center text-gray-400 border-r border-gray-200"><?= $o['stillbirth'] ?></td>
            <td class="p-3 text-center text-gray-400 border-r border-gray-200"><?= $o['abortion'] ?></td>
            <td class="p-3 text-center font-mono border-r border-gray-200"><?= $o['postnatal24h'] ?></td>
            <td class="p-3 text-center font-mono border-r border-gray-200"><?= $o['postnatal3d'] ?></td>
            <td class="p-3 text-center font-mono border-r border-gray-200"><?= $o['postnatal7d'] ?></td>
            <td class="p-3 text-center text-gray-400 border-r border-gray-200"><?= $o['postnatal3w'] ?></td>
            <td class="p-3 text-center text-gray-400 border-r border-gray-200"><?= $o['maternalDeath'] ?></td>
            <td class="p-3 text-center text-gray-400 border-r border-gray-200"><?= $o['infantDeath'] ?></td>
            <td class="p-3 text-xs"><?= htmlspecialchars($o['remarks']) ?></td>
          </tr>
          <?php endforeach; ?>
          <?php for ($i = count($pregnancyOutcomes); $i < 6; $i++): ?>
          <tr class="border-b border-gray-100 hover:bg-gray-50">
            <td class="p-3 border-r border-gray-200 text-gray-400"><?= $i + 1 ?></td>
            <?php for ($j = 0; $j < 15; $j++): ?>
              <td class="p-3 text-center text-gray-300 border-r border-gray-200">—</td>
            <?php endfor; ?>
            <td class="p-3 text-gray-300">—</td>
          </tr>
          <?php endfor; ?>
        </tbody>
      </table>
    </div>
    <!-- Footer -->
    <div class="p-6 bg-gray-50 border-t border-gray-200 text-xs text-gray-600 space-y-2">
      <p><strong>Pangalan ng BHW:</strong> _______________________________</p>
      <p><strong>Pangalan ng Kumadrona:</strong> _______________________________</p>
      <p><strong>Istasyon ng Pangkalusugang Manggagawa:</strong> _______________________________</p>
      <p><strong>Rural Health Unit:</strong> _______________________________</p>
      <div class="grid grid-cols-2 gap-6 mt-4">
        <div>
          <p class="font-semibold">Inihanda ni:</p>
          <div class="mt-6 border-t border-gray-400 pt-1 text-[10px] text-gray-500">
            <p>(Unang Pangalan, Gitnang Initial, Apelyido)</p>
            <p>Rural Health Midwife</p>
          </div>
        </div>
        <div>
          <p class="font-semibold">Pinatotohanan ni:</p>
          <div class="mt-6 border-t border-gray-400 pt-1 text-[10px] text-gray-500">
            <p>(Unang Pangalan, Gitnang Initial, Apelyido)</p>
            <p>Immediate Supervisor</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ══ CHILDREN HEALTH & IMMUNIZATION ══════════════════════════════════ -->
  <?php elseif ($activeReport === 'children'): ?>
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden" id="print-area">
    <div class="p-6 border-b border-gray-200">
      <h3 class="text-xl font-bold text-gray-900 mb-1">Children Health &amp; Immunization Report</h3>
      <p class="text-sm text-gray-500">0–59 months · Tuy, Batangas · <?= date('Y') ?></p>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-xs">
        <thead class="bg-gray-50 border-b-2 border-gray-200">
          <tr>
            <th class="text-left p-3 font-bold text-gray-600 uppercase">No.</th>
            <th class="text-left p-3 font-bold text-gray-600 uppercase">Name</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase">Age (mo)</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase">Sex</th>
            <th class="text-left p-3 font-bold text-gray-600 uppercase">Address</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase">Weight</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase">Height</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase">Status</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-blue-50">BCG</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-blue-50">DPT1</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-blue-50">DPT2</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-blue-50">DPT3</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-green-50">OPV1</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-green-50">OPV2</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-green-50">OPV3</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-yellow-50">Measles</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-orange-50">Vit A</th>
            <th class="text-center p-3 font-bold text-gray-600 uppercase bg-purple-50">Fully Imm.</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($children as $i => $child): ?>
          <tr class="border-b border-gray-100 hover:bg-purple-50 transition-colors <?= $i % 2 === 0 ? 'bg-white' : 'bg-gray-50/50' ?>">
            <td class="p-3 text-gray-400 font-medium"><?= $child['no'] ?></td>
            <td class="p-3 font-semibold text-gray-900 whitespace-nowrap"><?= htmlspecialchars($child['name']) ?></td>
            <td class="p-3 text-center text-gray-600"><?= $child['age_mos'] ?></td>
            <td class="p-3 text-center text-gray-600"><?= $child['sex'] ?></td>
            <td class="p-3 text-gray-600"><?= htmlspecialchars($child['address']) ?></td>
            <td class="p-3 text-center text-gray-600"><?= $child['weight'] ?> kg</td>
            <td class="p-3 text-center text-gray-600"><?= $child['height'] ?> cm</td>
            <td class="p-3 text-center">
              <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium <?= $statusColors[$child['status']] ?? 'bg-gray-100 text-gray-700' ?>">
                <?= htmlspecialchars($child['status']) ?>
              </span>
            </td>
            <?php
              $vaccFields = ['bcg','dpt1','dpt2','dpt3','opv1','opv2','opv3','measles','vitA'];
              foreach ($vaccFields as $v):
                $val = $child[$v];
                $isCheck = $val === '✓';
            ?>
              <td class="p-3 text-center font-bold <?= $isCheck ? 'text-green-600' : 'text-gray-300' ?>"><?= $val ?></td>
            <?php endforeach; ?>
            <td class="p-3 text-center">
              <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium <?= $child['fully'] === 'Yes' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= $child['fully'] ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- Summary -->
    <div class="p-6 bg-gray-50 border-t border-gray-200">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
        <div class="bg-white rounded-xl p-4 border border-gray-200 text-center">
          <div class="text-2xl font-bold text-purple-600"><?= count($children) ?></div>
          <div class="text-xs text-gray-500 mt-1">Total Children</div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200 text-center">
          <div class="text-2xl font-bold text-green-600"><?= count(array_filter($children, fn($c) => $c['status'] === 'Normal')) ?></div>
          <div class="text-xs text-gray-500 mt-1">Normal Status</div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200 text-center">
          <div class="text-2xl font-bold text-red-600"><?= count(array_filter($children, fn($c) => strpos($c['status'], 'Wasted') !== false || strpos($c['status'], 'Stunted') !== false || $c['status'] === 'Underweight')) ?></div>
          <div class="text-xs text-gray-500 mt-1">Malnourished</div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-200 text-center">
          <div class="text-2xl font-bold text-blue-600"><?= count(array_filter($children, fn($c) => $c['fully'] === 'Yes')) ?></div>
          <div class="text-xs text-gray-500 mt-1">Fully Immunized</div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>

<script>
function exportReport() {
  alert('Export feature — i-connect sa PDF generation library (e.g., TCPDF o mPDF) para sa actual export.');
}
</script>

<style>
@media print {
  #sidebar, #sidebar-gap, #sidebar-trigger, header { display: none !important; }
  #sidebar-inset { margin: 0 !important; }
  #print-area { box-shadow: none !important; border: none !important; }
}
</style>

<?php
$page_content = ob_get_clean();
?>
<?= $page_content ?>