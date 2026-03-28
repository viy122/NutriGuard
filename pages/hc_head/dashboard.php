<?php
// Guard: Redirect if accessed directly
if (basename((string) ($_SERVER['SCRIPT_NAME'] ?? '')) === 'dashboard.php' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    $redirectParams = $_GET;
    $redirectParams['page'] = 'dashboard';
    header('Location: ../../layout.php?' . http_build_query($redirectParams));
    exit;
}

// Session guard
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Authorization check
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user'])) {
    header('Location: ../../pages/sign_in.php');
    exit;
}

// ── Simulated current Head user ─────────────────────────────────────────
$currentUser = ['name' => 'Dr. Liza Reyes', 'role' => 'head'];

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// ── Data ─────────────────────────────────────────────────────────────────
$nutritionalStatusData = [
    ['name' => 'Normal',      'value' => 200, 'color' => '#22c55e'],
    ['name' => 'Underweight', 'value' => 65,  'color' => '#f59e0b'],
    ['name' => 'Stunted',     'value' => 48,  'color' => '#ef4444'],
    ['name' => 'Wasted',      'value' => 35,  'color' => '#dc2626'],
    ['name' => 'Overweight',  'value' => 15,  'color' => '#3b82f6'],
];

$malnutritionTrend = [
    ['month'=>'Jul','stunted'=>52,'wasted'=>38,'underweight'=>70],
    ['month'=>'Aug','stunted'=>50,'wasted'=>36,'underweight'=>68],
    ['month'=>'Sep','stunted'=>49,'wasted'=>37,'underweight'=>67],
    ['month'=>'Oct','stunted'=>48,'wasted'=>36,'underweight'=>66],
    ['month'=>'Nov','stunted'=>48,'wasted'=>35,'underweight'=>66],
    ['month'=>'Dec','stunted'=>48,'wasted'=>35,'underweight'=>65],
    ['month'=>'Jan','stunted'=>48,'wasted'=>35,'underweight'=>65],
    ['month'=>'Feb','stunted'=>48,'wasted'=>35,'underweight'=>65],
    ['month'=>'Mar','stunted'=>48,'wasted'=>35,'underweight'=>65],
];

$purokRisk = [
    ['name'=>'Purok 1 - Silangan','value'=>18,'color'=>'#ef4444'],
    ['name'=>'Purok 2 - Gitna',   'value'=>12,'color'=>'#f59e0b'],
    ['name'=>'Purok 3 - Kanluran','value'=>8, 'color'=>'#22c55e'],
    ['name'=>'Purok 4 - Hilaga',  'value'=>7, 'color'=>'#22c55e'],
    ['name'=>'Purok 5 - Timog',   'value'=>5, 'color'=>'#22c55e'],
];

$ageGroupData = [
    ['name'=>'0-11 months', 'value'=>104,'color'=>'#ef4444'],
    ['name'=>'12-23 months','value'=>108,'color'=>'#f59e0b'],
    ['name'=>'24-59 months','value'=>134,'color'=>'#22c55e'],
];

// JSON encode for JS
$jsNutritional  = json_encode($nutritionalStatusData);
$jsTrend        = json_encode($malnutritionTrend);
$jsAge          = json_encode($ageGroupData);
?>

<style>
.dashboard-head-page { 
  font-family: 'Segoe UI', system-ui, sans-serif;
  color: #1e293b;
}

/* ── Header Banner ── */
.dashboard-head-page .page-banner {
  background: linear-gradient(135deg, #06b6d4 0%, #0d9488 100%);
  color: #fff; border-radius: 1.25rem; padding: 2rem 2.25rem;
  box-shadow: 0 10px 30px rgba(6,182,212,.3); margin-bottom: 1.5rem;
}
.dashboard-head-page .page-banner h1 { font-size: 1.75rem; font-weight: 700; margin-bottom: .3rem; }
.dashboard-head-page .page-banner p  { font-size: .875rem; opacity: .9; }

/* ── Grid helpers ── */
.dashboard-head-page .grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
.dashboard-head-page .grid-4-2 { display: grid; grid-template-columns: repeat(4,1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
.dashboard-head-page .grid-2  { display: grid; grid-template-columns: repeat(2,1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
.dashboard-head-page .grid-3  { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem; }

/* ── KPI Cards ── */
.dashboard-head-page .kpi-card {
  background: #fff; border-radius: 1rem;
  box-shadow: 0 2px 12px rgba(0,0,0,.07);
  padding: 1.4rem; border-left: 4px solid transparent;
  transition: box-shadow .2s, transform .2s;
}
.dashboard-head-page .kpi-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.12); transform: translateY(-1px); }
.dashboard-head-page .kpi-card.cyan   { border-color: #06b6d4; }
.dashboard-head-page .kpi-card.blue   { border-color: #3b82f6; }
.dashboard-head-page .kpi-card.pink   { border-color: #ec4899; }
.dashboard-head-page .kpi-card.purple { border-color: #a855f7; }
.dashboard-head-page .kpi-icon {
  width: 52px; height: 52px; border-radius: .75rem;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1rem; box-shadow: 0 4px 10px rgba(0,0,0,.15);
}
.dashboard-head-page .kpi-icon svg { width: 24px; height: 24px; stroke: #fff; fill: none; stroke-width: 2; }
.dashboard-head-page .kpi-icon.cyan   { background: linear-gradient(135deg,#06b6d4,#0891b2); }
.dashboard-head-page .kpi-icon.blue   { background: linear-gradient(135deg,#3b82f6,#2563eb); }
.dashboard-head-page .kpi-icon.pink   { background: linear-gradient(135deg,#ec4899,#db2777); }
.dashboard-head-page .kpi-icon.purple { background: linear-gradient(135deg,#a855f7,#9333ea); }
.dashboard-head-page .kpi-label { font-size: .8rem; color: #64748b; margin-bottom: .25rem; }
.dashboard-head-page .kpi-count { font-size: 2.4rem; font-weight: 700; line-height: 1; margin-bottom: .3rem; }
.dashboard-head-page .kpi-sub   { font-size: .72rem; color: #94a3b8; font-weight: 500; }
.dashboard-head-page .kpi-sub.green { color: #16a34a; display: flex; align-items: center; gap: .2rem; }
.dashboard-head-page .kpi-sub.gray  { color: #94a3b8; }

/* ── Secondary stat cards (border-top) ── */
.dashboard-head-page .sec-card {
  background: #fff; border-radius: 1rem;
  box-shadow: 0 2px 12px rgba(0,0,0,.07);
  padding: 1.2rem 1.3rem; border-top: 4px solid transparent;
  display: flex; align-items: center; justify-content: space-between;
  transition: box-shadow .2s;
}
.dashboard-head-page .sec-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.11); }
.dashboard-head-page .sec-card.teal    { border-color: #14b8a6; }
.dashboard-head-page .sec-card.emerald { border-color: #10b981; }
.dashboard-head-page .sec-card.indigo  { border-color: #6366f1; }
.dashboard-head-page .sec-card.orange  { border-color: #f97316; }
.dashboard-head-page .sec-label { font-size: .8rem; color: #64748b; margin-bottom: .25rem; }
.dashboard-head-page .sec-count { font-size: 1.8rem; font-weight: 700; }
.dashboard-head-page .sec-count.teal    { color: #0d9488; }
.dashboard-head-page .sec-count.emerald { color: #059669; }
.dashboard-head-page .sec-count.indigo  { color: #4f46e5; }
.dashboard-head-page .sec-count.orange  { color: #ea580c; }
.dashboard-head-page .sec-mini { font-size: .7rem; color: #16a34a; display: flex; align-items: center; gap: .2rem; margin-top: .3rem; }
.dashboard-head-page .sec-mini.gray { color: #94a3b8; }
.dashboard-head-page .sec-icon {
  width: 44px; height: 44px; border-radius: .6rem;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.dashboard-head-page .sec-icon svg { width: 20px; height: 20px; stroke-width: 2; fill: none; }
.dashboard-head-page .sec-icon.teal    { background: #ccfbf1; } .dashboard-head-page .sec-icon.teal    svg { stroke: #0d9488; }
.dashboard-head-page .sec-icon.emerald { background: #d1fae5; } .dashboard-head-page .sec-icon.emerald svg { stroke: #059669; }
.dashboard-head-page .sec-icon.indigo  { background: #e0e7ff; } .dashboard-head-page .sec-icon.indigo  svg { stroke: #4f46e5; }
.dashboard-head-page .sec-icon.orange  { background: #ffedd5; } .dashboard-head-page .sec-icon.orange  svg { stroke: #ea580c; }

/* ── Chart / Panel Cards ── */
.dashboard-head-page .panel {
  background: #fff; border-radius: 1rem;
  box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 1.5rem;
}
.dashboard-head-page .panel-title {
  font-size: 1rem; font-weight: 700; margin-bottom: .2rem;
  display: flex; align-items: center; gap: .5rem;
}
.dashboard-head-page .title-bar {
  width: 3px; height: 20px; border-radius: 3px;
  background: linear-gradient(to bottom, #06b6d4, #0d9488); flex-shrink: 0;
}
.dashboard-head-page .panel-sub { font-size: .8rem; color: #64748b; margin-bottom: 1.25rem; }
.dashboard-head-page .chart-wrap { position: relative; height: 280px; }
.dashboard-head-page .chart-wrap-sm { position: relative; height: 200px; }

/* ── Purok Risk Bars ── */
.dashboard-head-page .risk-list { display: flex; flex-direction: column; gap: .75rem; }
.dashboard-head-page .risk-header { display: flex; justify-content: space-between; margin-bottom: .35rem; }
.dashboard-head-page .risk-name { font-size: .8rem; font-weight: 600; }
.dashboard-head-page .risk-val  { font-size: .8rem; font-weight: 700; color: #0891b2; }
.dashboard-head-page .risk-track { height: 8px; background: #f1f5f9; border-radius: 9999px; overflow: hidden; }
.dashboard-head-page .risk-fill  { height: 100%; border-radius: 9999px; transition: width .6s ease; }

/* ── Legend dots ── */
.dashboard-head-page .legend-list { display: flex; flex-direction: column; gap: .5rem; margin-top: 1rem; }
.dashboard-head-page .legend-item {
  display: flex; align-items: center; justify-content: space-between;
  font-size: .8rem; padding: .4rem .6rem; border-radius: .45rem; font-weight: 500;
}
.dashboard-head-page .legend-dot { width: 10px; height: 10px; border-radius: 50%; margin-right: .5rem; flex-shrink: 0; }
.dashboard-head-page .legend-left { display: flex; align-items: center; }

/* ── Alert items ── */
.dashboard-head-page .alert-list { display: flex; flex-direction: column; gap: .65rem; }
.dashboard-head-page .alert-item {
  display: flex; gap: .75rem; padding: .7rem .8rem; border-radius: .75rem;
  cursor: pointer; transition: filter .15s;
}
.dashboard-head-page .alert-item:hover { filter: brightness(.96); }
.dashboard-head-page .alert-item.red    { background: #fef2f2; }
.dashboard-head-page .alert-item.orange { background: #fff7ed; }
.dashboard-head-page .alert-item.blue   { background: #eff6ff; }
.dashboard-head-page .alert-item.green  { background: #f0fdf4; }
.dashboard-head-page .alert-icon {
  width: 32px; height: 32px; border-radius: .5rem;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.dashboard-head-page .alert-icon svg { width: 15px; height: 15px; stroke-width: 2; fill: none; }
.dashboard-head-page .alert-item.red    .alert-icon { background: #fee2e2; } .dashboard-head-page .alert-item.red    .alert-icon svg { stroke: #dc2626; }
.dashboard-head-page .alert-item.orange .alert-icon { background: #ffedd5; } .dashboard-head-page .alert-item.orange .alert-icon svg { stroke: #ea580c; }
.dashboard-head-page .alert-item.blue   .alert-icon { background: #dbeafe; } .dashboard-head-page .alert-item.blue   .alert-icon svg { stroke: #2563eb; }
.dashboard-head-page .alert-item.green  .alert-icon { background: #dcfce7; } .dashboard-head-page .alert-item.green  .alert-icon svg { stroke: #16a34a; }
.dashboard-head-page .alert-msg  { font-size: .82rem; font-weight: 600; margin-bottom: .15rem; color: #1e293b; }
.dashboard-head-page .alert-time { font-size: .7rem; color: #94a3b8; }

/* ── Responsive ── */
@media (max-width: 1100px) {
  .dashboard-head-page .grid-4, .dashboard-head-page .grid-4-2 { grid-template-columns: repeat(2,1fr); }
  .dashboard-head-page .grid-3 { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
  .dashboard-head-page .grid-2, .dashboard-head-page .grid-3, .dashboard-head-page .grid-4, .dashboard-head-page .grid-4-2 { grid-template-columns: 1fr; }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<div class="dashboard-head-page">
  <!-- Banner -->
  <div class="page-banner">
    <h1>Community Health Dashboard</h1>
    <p>Real-time analytics for Batangas, Magahis, Tuy &middot; Barangay-wide Overview</p>
  </div>

  <!-- Primary KPIs -->
  <div class="grid-4">
    <div class="kpi-card cyan">
      <div class="kpi-icon cyan">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <div class="kpi-label">Total Population</div>
      <div class="kpi-count">2,847</div>
      <div class="kpi-sub gray">Barangay residents</div>
    </div>
    <div class="kpi-card blue">
      <div class="kpi-icon blue">
        <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </div>
      <div class="kpi-label">Total Children</div>
      <div class="kpi-count">438</div>
      <div class="kpi-sub gray">0–5 years old</div>
    </div>
    <div class="kpi-card pink">
      <div class="kpi-icon pink">
        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg>
      </div>
      <div class="kpi-label">Pregnant Women</div>
      <div class="kpi-count">24</div>
      <div class="kpi-sub green">&#8593; +3 this month</div>
    </div>
    <div class="kpi-card purple">
      <div class="kpi-icon purple">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
      </div>
      <div class="kpi-label">Senior Citizens</div>
      <div class="kpi-count">187</div>
      <div class="kpi-sub gray">60 years and above</div>
    </div>
  </div>

  <!-- Secondary Stats -->
  <div class="grid-4-2">
    <div class="sec-card teal">
      <div>
        <div class="sec-label">Active BHW</div>
        <div class="sec-count teal">15</div>
      </div>
      <div class="sec-icon teal">
        <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </div>
    </div>
    <div class="sec-card emerald">
      <div>
        <div class="sec-label">Active BNS</div>
        <div class="sec-count emerald">4</div>
      </div>
      <div class="sec-icon emerald">
        <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </div>
    </div>
    <div class="sec-card indigo">
      <div>
        <div class="sec-label">Puroks Covered</div>
        <div class="sec-count indigo">5</div>
      </div>
      <div class="sec-icon indigo">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
    </div>
    <div class="sec-card orange">
      <div>
        <div class="sec-label">At Risk</div>
        <div class="sec-count orange">67</div>
        <div class="sec-mini">&#8595; -4 vs last quarter</div>
      </div>
      <div class="sec-icon orange">
        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      </div>
    </div>
  </div>

  <!-- Charts Row 1 -->
  <div class="grid-2">
    <!-- Nutritional Status Bar Chart -->
    <div class="panel">
      <div class="panel-title"><div class="title-bar"></div>Nutritional Status Distribution</div>
      <div class="panel-sub">Children 0–5 years &middot; Current Quarter</div>
      <div class="chart-wrap">
        <canvas id="chartNutrition"></canvas>
      </div>
    </div>

    <!-- Malnutrition Trend Line Chart -->
    <div class="panel">
      <div class="panel-title"><div class="title-bar"></div>Malnutrition Trend</div>
      <div class="panel-sub">9-month trend &middot; Cases over time</div>
      <div class="chart-wrap">
        <canvas id="chartTrend"></canvas>
      </div>
    </div>
  </div>

  <!-- Charts Row 2 -->
  <div class="grid-3">
    <!-- Purok Risk Levels -->
    <div class="panel">
      <div class="panel-title"><div class="title-bar"></div>Purok Risk Levels</div>
      <div class="panel-sub">Population identified as at-risk</div>
      <div class="risk-list">
        <?php foreach ($purokRisk as $p): ?>
        <?php $pct = round(($p['value'] / 18) * 100); ?>
        <div class="risk-item">
          <div class="risk-header">
            <span class="risk-name"><?= h($p['name']) ?></span>
            <span class="risk-val"><?= $p['value'] ?> at-risk</span>
          </div>
          <div class="risk-track">
            <div class="risk-fill" style="width:<?= $pct ?>%;background-color:<?= h($p['color']) ?>;"></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Age Group Donut Chart -->
    <div class="panel">
      <div class="panel-title"><div class="title-bar"></div>Age Group Distribution</div>
      <div class="panel-sub">Nutrition at-risk by age bracket</div>
      <div class="chart-wrap-sm">
        <canvas id="chartAge"></canvas>
      </div>
      <div class="legend-list">
        <?php foreach ($ageGroupData as $ag): ?>
        <?php
          $bgMap = ['#ef4444'=>'#fef2f2','#f59e0b'=>'#fffbeb','#22c55e'=>'#f0fdf4'];
          $bg = $bgMap[$ag['color']] ?? '#f8fafc';
        ?>
        <div class="legend-item" style="background:<?= $bg ?>;">
          <div class="legend-left">
            <div class="legend-dot" style="background:<?= h($ag['color']) ?>;"></div>
            <span><?= h($ag['name']) ?></span>
          </div>
          <strong><?= $ag['value'] ?></strong>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Recent Alerts -->
    <div class="panel">
      <div class="panel-title"><div class="title-bar"></div>Recent Alerts</div>
      <div class="panel-sub">Priority health alerts &amp; reminders</div>
      <div class="alert-list">
        <div class="alert-item red">
          <div class="alert-icon">
            <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          </div>
          <div>
            <div class="alert-msg">3 children in Purok 1 flagged as severely wasted</div>
            <div class="alert-time">2 hours ago</div>
          </div>
        </div>
        <div class="alert-item orange">
          <div class="alert-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          </div>
          <div>
            <div class="alert-msg">Follow-up overdue for 5 residents in Purok 2</div>
            <div class="alert-time">5 hours ago</div>
          </div>
        </div>
        <div class="alert-item blue">
          <div class="alert-icon">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
          <div>
            <div class="alert-msg">Monthly OPT report ready for submission</div>
            <div class="alert-time">1 day ago</div>
          </div>
        </div>
        <div class="alert-item green">
          <div class="alert-icon">
            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <div>
            <div class="alert-msg">Purok 3 achieved 100% weighing coverage</div>
            <div class="alert-time">3 days ago</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
// ── Chart.js defaults ────────────────────────────────────────────────────
Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";
Chart.defaults.font.size   = 12;
Chart.defaults.color       = '#64748b';

// ── Data from PHP ────────────────────────────────────────────────────────
const nutritionalData = <?= $jsNutrition = json_encode(array_map(fn($d) => ['name'=>$d['name'],'value'=>$d['value'],'color'=>$d['color']], $nutritionalStatusData)) ?>;
const trendData       = <?= $jsTrend ?>;
const ageData         = <?= $jsAge ?>;

// ── 1. Nutritional Status Bar Chart ─────────────────────────────────────
new Chart(document.getElementById('chartNutrition'), {
    type: 'bar',
    data: {
        labels: nutritionalData.map(d => d.name),
        datasets: [{
            data:            nutritionalData.map(d => d.value),
            backgroundColor: nutritionalData.map(d => d.color),
            borderRadius:    8,
            borderSkipped:   false,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: '#f0f0f0', drawBorder: false }, ticks: { stepSize: 50 } }
        }
    }
});

// ── 2. Malnutrition Trend Line Chart ────────────────────────────────────
new Chart(document.getElementById('chartTrend'), {
    type: 'line',
    data: {
        labels: trendData.map(d => d.month),
        datasets: [
            {
                label: 'Underweight',
                data: trendData.map(d => d.underweight),
                borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,.08)',
                borderWidth: 3, pointRadius: 5, pointBackgroundColor: '#f59e0b',
                tension: .3, fill: false,
            },
            {
                label: 'Stunted',
                data: trendData.map(d => d.stunted),
                borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,.08)',
                borderWidth: 3, pointRadius: 5, pointBackgroundColor: '#ef4444',
                tension: .3, fill: false,
            },
            {
                label: 'Wasted',
                data: trendData.map(d => d.wasted),
                borderColor: '#dc2626', backgroundColor: 'rgba(220,38,38,.08)',
                borderWidth: 3, pointRadius: 5, pointBackgroundColor: '#dc2626',
                tension: .3, fill: false,
            },
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { usePointStyle: true, pointStyleWidth: 10, padding: 16, font: { size: 11 } }
            }
        },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: '#f0f0f0', drawBorder: false } }
        }
    }
});

// ── 3. Age Group Donut Chart ─────────────────────────────────────────────
new Chart(document.getElementById('chartAge'), {
    type: 'doughnut',
    data: {
        labels: ageData.map(d => d.name),
        datasets: [{
            data:            ageData.map(d => d.value),
            backgroundColor: ageData.map(d => d.color),
            borderWidth: 2, borderColor: '#fff',
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        cutout: '68%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed}`
                }
            }
        }
    }
});
</script>