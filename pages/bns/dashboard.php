<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$role     = $_SESSION['role'] ?? 'bns';
$userName = $_SESSION['name'] ?? 'Rosa Mendoza';

// ── Sidebar ──────────────────────────────────────────────────────────────────
$sidebar_active = 'dashboard';
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

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">BNS Dashboard</span>';

// ── Chart Data (mirrors React component) ────────────────────────────────────
$bnsChildNutritionData = json_encode([
  ['label'=>'Normal',      'value'=>145, 'color'=>'#22c55e'],
  ['label'=>'Underweight', 'value'=>42,  'color'=>'#f59e0b'],
  ['label'=>'Stunted',     'value'=>35,  'color'=>'#ef4444'],
  ['label'=>'Wasted',      'value'=>28,  'color'=>'#dc2626'],
  ['label'=>'Overweight',  'value'=>12,  'color'=>'#3b82f6'],
]);

$bnsPregnantTrendData = json_encode([
  ['month'=>'Oct','normal'=>15,'atrisk'=>3],
  ['month'=>'Nov','normal'=>16,'atrisk'=>2],
  ['month'=>'Dec','normal'=>18,'atrisk'=>2],
  ['month'=>'Jan','normal'=>17,'atrisk'=>3],
  ['month'=>'Feb','normal'=>19,'atrisk'=>2],
  ['month'=>'Mar','normal'=>20,'atrisk'=>1],
]);

$bnsMalnutritionData = json_encode([
  ['purok'=>'Purok 1','stunted'=>12,'wasted'=>8,'underweight'=>15,'total'=>35,'risk'=>'high'],
  ['purok'=>'Purok 2','stunted'=>9, 'wasted'=>6,'underweight'=>11,'total'=>26,'risk'=>'medium'],
  ['purok'=>'Purok 3','stunted'=>7, 'wasted'=>5,'underweight'=>9, 'total'=>21,'risk'=>'medium'],
  ['purok'=>'Purok 4','stunted'=>4, 'wasted'=>5,'underweight'=>8, 'total'=>17,'risk'=>'low'],
  ['purok'=>'Purok 5','stunted'=>3, 'wasted'=>4,'underweight'=>6, 'total'=>13,'risk'=>'low'],
]);

$bnsAIPredictionData = json_encode([
  ['factor'=>'Age 0–6 months',    'weight'=>85,'color'=>'#ef4444'],
  ['factor'=>'Low Birth Weight',  'weight'=>78,'color'=>'#f59e0b'],
  ['factor'=>'Purok 1 Location',  'weight'=>72,'color'=>'#fbbf24'],
  ['factor'=>"Multiple Siblings", 'weight'=>65,'color'=>'#22c55e'],
  ['factor'=>"Mother's Age <20",  'weight'=>58,'color'=>'#3b82f6'],
]);

$bnsAgeGroupData = json_encode([
  ['age'=>'0–6 mo',  'total'=>45,'atrisk'=>18],
  ['age'=>'7–11 mo', 'total'=>52,'atrisk'=>15],
  ['age'=>'12–23 mo','total'=>63,'atrisk'=>22],
  ['age'=>'24–35 mo','total'=>58,'atrisk'=>16],
  ['age'=>'36–59 mo','total'=>72,'atrisk'=>19],
]);

ob_start();
?>

<div class="p-6 space-y-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-violet-500 to-purple-600 text-white rounded-2xl p-8 shadow-xl">
    <h1 class="text-3xl font-bold mb-1">BNS Nutrition Dashboard</h1>
    <p class="text-sm text-white/90">
      Barangay-wide Child Nutrition & Maternal Health · BNS: <?= htmlspecialchars($userName) ?>
    </p>
  </div>

  <!-- KPI Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php
      $kpis = [
        ['label'=>'Total Children Monitored','value'=>'262','sub'=>'0–59 months',          'border'=>'border-violet-500','grad'=>'from-violet-500 to-violet-600','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>'],
        ['label'=>'Malnourished Children',   'value'=>'105','sub'=>'Stunted/Wasted/Underweight','border'=>'border-red-500',   'grad'=>'from-red-500 to-red-600',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>'],
        ['label'=>'Pregnant Women Monitored','value'=>'21', 'sub'=>'Active prenatal cases',  'border'=>'border-pink-500',  'grad'=>'from-pink-500 to-pink-600',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>'],
        ['label'=>'High-Risk Households',    'value'=>'35', 'sub'=>'Purok 1 priority',       'border'=>'border-orange-500','grad'=>'from-orange-500 to-orange-600','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>'],
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
        <div class="text-4xl font-bold mb-1"><?= $k['value'] ?></div>
        <div class="text-xs text-gray-500 font-medium"><?= $k['sub'] ?></div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Charts Row 1 -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Child Nutritional Status Pie -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-4">
        <h3 class="text-lg font-semibold flex items-center gap-2">
          <div class="w-2 h-6 bg-gradient-to-b from-violet-500 to-purple-600 rounded-full"></div>
          Child Nutritional Status
        </h3>
        <p class="text-sm text-gray-500">Children 0–59 months · Current Quarter</p>
      </div>
      <div class="flex items-center gap-4">
        <canvas id="nutritionPie" width="220" height="220" style="max-width:220px;flex-shrink:0;"></canvas>
        <div class="flex-1 space-y-2" id="nutritionLegend"></div>
      </div>
    </div>

    <!-- Pregnant Women Trend Line -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-4">
        <h3 class="text-lg font-semibold flex items-center gap-2">
          <div class="w-2 h-6 bg-gradient-to-b from-violet-500 to-purple-600 rounded-full"></div>
          Pregnant Women Monitoring Trend
        </h3>
        <p class="text-sm text-gray-500">Normal vs. at-risk cases over 6 months</p>
      </div>
      <canvas id="pregnantTrend" height="220"></canvas>
    </div>
  </div>

  <!-- Charts Row 2 -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Malnutrition Heatmap Table -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-4">
        <h3 class="text-lg font-semibold flex items-center gap-2">
          <div class="w-2 h-6 bg-gradient-to-b from-violet-500 to-purple-600 rounded-full"></div>
          Purok Malnutrition Heatmap
        </h3>
        <p class="text-sm text-gray-500">Breakdown by type per purok</p>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-gradient-to-r from-gray-50 to-gray-100 text-gray-600">
              <th class="text-left p-3 rounded-l-lg font-semibold">Purok</th>
              <th class="text-center p-3 font-semibold">Stunted</th>
              <th class="text-center p-3 font-semibold">Wasted</th>
              <th class="text-center p-3 font-semibold">Underweight</th>
              <th class="text-center p-3 font-semibold">Total</th>
              <th class="text-center p-3 rounded-r-lg font-semibold">Risk</th>
            </tr>
          </thead>
          <tbody id="heatmapTable"></tbody>
        </table>
      </div>
    </div>

    <!-- Age Group Bar Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
      <div class="mb-4">
        <h3 class="text-lg font-semibold flex items-center gap-2">
          <div class="w-2 h-6 bg-gradient-to-b from-violet-500 to-purple-600 rounded-full"></div>
          At-Risk Children by Age Group
        </h3>
        <p class="text-sm text-gray-500">Total vs. at-risk breakdown</p>
      </div>
      <canvas id="ageGroupBar" height="240"></canvas>
    </div>
  </div>

  <!-- AI Prediction Factors -->
  <div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="mb-6">
      <h3 class="text-lg font-semibold flex items-center gap-2">
        <div class="w-2 h-6 bg-gradient-to-b from-violet-500 to-purple-600 rounded-full"></div>
        AI Malnutrition Risk Factors
      </h3>
      <p class="text-sm text-gray-500">Predictive weight of each risk factor</p>
    </div>
    <div class="space-y-4" id="aiFactors"></div>
  </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Data from PHP ──────────────────────────────────────────────────────────
const nutritionData   = <?= $bnsChildNutritionData ?>;
const pregnantData    = <?= $bnsPregnantTrendData ?>;
const malnutritionData= <?= $bnsMalnutritionData ?>;
const aiData          = <?= $bnsAIPredictionData ?>;
const ageData         = <?= $bnsAgeGroupData ?>;

// ── 1. Child Nutritional Status Pie ───────────────────────────────────────
new Chart(document.getElementById('nutritionPie'), {
  type: 'pie',
  data: {
    labels: nutritionData.map(d => d.label),
    datasets: [{
      data: nutritionData.map(d => d.value),
      backgroundColor: nutritionData.map(d => d.color),
      borderWidth: 2,
      borderColor: '#fff',
    }]
  },
  options: {
    plugins: { legend: { display: false }, tooltip: { callbacks: {
      label: ctx => ` ${ctx.label}: ${ctx.parsed} children`
    }}},
    cutout: 0,
  }
});

// Legend
const legend = document.getElementById('nutritionLegend');
nutritionData.forEach(d => {
  legend.innerHTML += `
    <div class="flex items-center justify-between text-sm p-2 rounded-lg" style="background:${d.color}18">
      <div class="flex items-center gap-2">
        <div class="w-3 h-3 rounded-full flex-shrink-0" style="background:${d.color}"></div>
        <span class="font-medium text-gray-700">${d.label}</span>
      </div>
      <span class="font-bold" style="color:${d.color}">${d.value}</span>
    </div>`;
});

// ── 2. Pregnant Women Trend Line ──────────────────────────────────────────
new Chart(document.getElementById('pregnantTrend'), {
  type: 'line',
  data: {
    labels: pregnantData.map(d => d.month),
    datasets: [
      {
        label: 'Normal',
        data: pregnantData.map(d => d.normal),
        borderColor: '#22c55e',
        backgroundColor: 'rgba(34,197,94,0.1)',
        borderWidth: 3,
        pointRadius: 6,
        pointBackgroundColor: '#22c55e',
        fill: true,
        tension: 0.4,
      },
      {
        label: 'At-Risk',
        data: pregnantData.map(d => d.atrisk),
        borderColor: '#ef4444',
        backgroundColor: 'rgba(239,68,68,0.1)',
        borderWidth: 3,
        pointRadius: 6,
        pointBackgroundColor: '#ef4444',
        fill: true,
        tension: 0.4,
      },
    ]
  },
  options: {
    plugins: { legend: { position: 'bottom' } },
    scales: {
      y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
      x: { grid: { display: false } },
    },
  }
});

// ── 3. Heatmap Table ──────────────────────────────────────────────────────
const riskConfig = {
  high:   { cls: 'bg-red-100 text-red-700',   label: '🔴 High' },
  medium: { cls: 'bg-yellow-100 text-yellow-700', label: '🟡 Medium' },
  low:    { cls: 'bg-green-100 text-green-700',  label: '🟢 Low' },
};
const tbody = document.getElementById('heatmapTable');
malnutritionData.forEach((row, i) => {
  const rc = riskConfig[row.risk];
  const bg = i % 2 === 0 ? '' : 'bg-gray-50';
  tbody.innerHTML += `
    <tr class="${bg} hover:bg-purple-50 transition-colors">
      <td class="p-3 font-semibold text-gray-800">${row.purok}</td>
      <td class="p-3 text-center"><span class="inline-block w-8 h-8 leading-8 rounded-full bg-red-100 text-red-700 font-bold text-xs">${row.stunted}</span></td>
      <td class="p-3 text-center"><span class="inline-block w-8 h-8 leading-8 rounded-full bg-orange-100 text-orange-700 font-bold text-xs">${row.wasted}</span></td>
      <td class="p-3 text-center"><span class="inline-block w-8 h-8 leading-8 rounded-full bg-yellow-100 text-yellow-700 font-bold text-xs">${row.underweight}</span></td>
      <td class="p-3 text-center font-bold text-gray-800">${row.total}</td>
      <td class="p-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-medium ${rc.cls}">${rc.label}</span></td>
    </tr>`;
});

// ── 4. Age Group Grouped Bar ──────────────────────────────────────────────
new Chart(document.getElementById('ageGroupBar'), {
  type: 'bar',
  data: {
    labels: ageData.map(d => d.age),
    datasets: [
      {
        label: 'Total',
        data: ageData.map(d => d.total),
        backgroundColor: 'rgba(139,92,246,0.2)',
        borderColor: '#8b5cf6',
        borderWidth: 2,
        borderRadius: 6,
      },
      {
        label: 'At-Risk',
        data: ageData.map(d => d.atrisk),
        backgroundColor: 'rgba(239,68,68,0.7)',
        borderColor: '#ef4444',
        borderWidth: 2,
        borderRadius: 6,
      },
    ]
  },
  options: {
    plugins: { legend: { position: 'bottom' } },
    scales: {
      y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
      x: { grid: { display: false } },
    },
  }
});

// ── 5. AI Risk Factor Bars ────────────────────────────────────────────────
const aiContainer = document.getElementById('aiFactors');
aiData.forEach(f => {
  aiContainer.innerHTML += `
    <div>
      <div class="flex items-center justify-between mb-1.5">
        <span class="text-sm font-medium text-gray-700">${f.factor}</span>
        <span class="text-sm font-bold" style="color:${f.color}">${f.weight}%</span>
      </div>
      <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full rounded-full transition-all duration-700"
          style="width:${f.weight}%;background:${f.color};"></div>
      </div>
    </div>`;
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
  <title>BNS Dashboard – NutriGuard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="margin:0;font-family:sans-serif;">
  <?php include 'sidebar.php'; ?>
</body>
</html>