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

// ── Data ──────────────────────────────────────────────────────────────────────
$programs = [
  [
    'id'            => 'PROG-001',
    'name'          => 'Supplementary Feeding Program',
    'category'      => 'Nutrition Intervention',
    'description'   => 'Daily feeding program providing balanced meals for malnourished children',
    'targetGroup'   => 'Children 0-5 years (Underweight, Wasted)',
    'duration'      => '6 months',
    'schedule'      => 'Monday-Friday, 9:00 AM',
    'location'      => 'Barangay Health Center',
    'capacity'      => 30,
    'enrolled'      => 24,
    'status'        => 'Active',
    'coordinator'   => 'Rosa Mendoza (BNS)',
    'startDate'     => '2026-01-15',
    'interventions' => [
      'High-protein meals (eggs, fish, chicken)',
      'Vitamin supplementation',
      'Weekly weight monitoring',
      'Nutrition counseling for parents',
    ],
  ],
  [
    'id'            => 'PROG-002',
    'name'          => 'Growth Monitoring Program',
    'category'      => 'Preventive Care',
    'description'   => 'Regular monitoring and tracking of child growth and development',
    'targetGroup'   => 'All children 0-5 years',
    'duration'      => 'Ongoing',
    'schedule'      => 'Monthly (First Saturday)',
    'location'      => 'Barangay Health Center',
    'capacity'      => 100,
    'enrolled'      => 78,
    'status'        => 'Active',
    'coordinator'   => 'Rosa Mendoza (BNS)',
    'startDate'     => '2025-01-01',
    'interventions' => [
      'Monthly weight and height measurement',
      'Growth chart plotting',
      'Nutritional status assessment',
      'Early detection of malnutrition',
    ],
  ],
  [
    'id'            => 'PROG-003',
    'name'          => 'Therapeutic Nutrition Program',
    'category'      => 'Critical Intervention',
    'description'   => 'Intensive nutrition therapy for severely malnourished children',
    'targetGroup'   => 'Severely Wasted/Stunted Children',
    'duration'      => '3-6 months (individualized)',
    'schedule'      => 'Daily monitoring',
    'location'      => 'Barangay Health Center + Home Visits',
    'capacity'      => 10,
    'enrolled'      => 7,
    'status'        => 'Active',
    'coordinator'   => 'Carmen Lopez (BNS)',
    'startDate'     => '2026-02-01',
    'interventions' => [
      'Ready-to-use therapeutic food (RUTF)',
      'Daily monitoring and assessment',
      'Medical referrals when needed',
      'Caregiver training',
    ],
  ],
  [
    'id'            => 'PROG-004',
    'name'          => 'Micronutrient Supplementation Program',
    'category'      => 'Supplementation',
    'description'   => 'Regular provision of essential vitamins and minerals',
    'targetGroup'   => 'Children 6 months - 5 years',
    'duration'      => 'Ongoing',
    'schedule'      => 'Bi-annual (Vitamin A), Weekly (Iron)',
    'location'      => 'Barangay Health Center',
    'capacity'      => 150,
    'enrolled'      => 112,
    'status'        => 'Active',
    'coordinator'   => 'Rosa Mendoza (BNS)',
    'startDate'     => '2025-01-01',
    'interventions' => [
      'Vitamin A supplementation (every 6 months)',
      'Iron supplementation for anemia prevention',
      'Deworming (every 6 months)',
      'Zinc supplementation for diarrhea cases',
    ],
  ],
  [
    'id'            => 'PROG-005',
    'name'          => 'Healthy Lifestyle Program',
    'category'      => 'Prevention',
    'description'   => 'Physical activity and nutrition education for overweight children',
    'targetGroup'   => 'Overweight/Obese Children',
    'duration'      => '4 months',
    'schedule'      => 'Twice a week (Tuesday & Thursday)',
    'location'      => 'Barangay Multi-Purpose Hall',
    'capacity'      => 20,
    'enrolled'      => 12,
    'status'        => 'Active',
    'coordinator'   => 'Rosa Mendoza (BNS)',
    'startDate'     => '2026-03-01',
    'interventions' => [
      'Guided physical activities and exercises',
      'Nutrition education and meal planning',
      'Behavior modification counseling',
      'Family involvement activities',
    ],
  ],
  [
    'id'            => 'PROG-006',
    'name'          => 'Maternal Nutrition Program',
    'category'      => 'Maternal Health',
    'description'   => 'Nutrition support and monitoring for pregnant and lactating mothers',
    'targetGroup'   => 'Pregnant & Lactating Women',
    'duration'      => 'Throughout pregnancy + 6 months postpartum',
    'schedule'      => 'Monthly check-ups',
    'location'      => 'Barangay Health Center',
    'capacity'      => 40,
    'enrolled'      => 18,
    'status'        => 'Active',
    'coordinator'   => 'Carmen Lopez (BNS)',
    'startDate'     => '2025-06-01',
    'interventions' => [
      'Iron and folic acid supplementation',
      'Calcium supplementation',
      'Nutrition counseling',
      'Monitoring of maternal weight gain',
    ],
  ],
  [
    'id'            => 'PROG-007',
    'name'          => 'Deworming Program',
    'category'      => 'Preventive Care',
    'description'   => 'Bi-annual deworming for all children to improve nutrient absorption',
    'targetGroup'   => 'Children 1-5 years',
    'duration'      => 'Ongoing',
    'schedule'      => 'Every 6 months (January & July)',
    'location'      => 'Barangay Health Center + Daycare Centers',
    'capacity'      => 200,
    'enrolled'      => 156,
    'status'        => 'Active',
    'coordinator'   => 'Maria Santos (BHW)',
    'startDate'     => '2025-01-01',
    'interventions' => [
      'Albendazole administration',
      'Health education on hygiene',
      'Follow-up monitoring',
      'Coordination with daycare centers',
    ],
  ],
];

$participants = [
  'PROG-001' => [
    ['id'=>'R-002','name'=>'Ana Santos',    'age'=>'24 months','status'=>'Underweight',     'enrollDate'=>'2026-01-20','progress'=>'Gaining 0.3kg/month'],
    ['id'=>'R-003','name'=>'Pedro Reyes',   'age'=>'48 months','status'=>'Stunted',          'enrollDate'=>'2026-01-22','progress'=>'Improved appetite'],
    ['id'=>'R-008','name'=>'Isabella Cruz', 'age'=>'30 months','status'=>'Underweight',      'enrollDate'=>'2026-02-01','progress'=>'Gained 0.5kg this month'],
  ],
  'PROG-003' => [
    ['id'=>'R-004','name'=>'Maria Garcia',  'age'=>'28 months','status'=>'Severely Wasted',  'enrollDate'=>'2026-02-05','progress'=>'Critical - under intensive care'],
  ],
];

// ── Stats ─────────────────────────────────────────────────────────────────────
$activeCount    = count(array_filter($programs, fn($p) => $p['status'] === 'Active'));
$totalEnrolled  = array_sum(array_column($programs, 'enrolled'));
$totalCapacity  = array_sum(array_column($programs, 'capacity'));
$utilizationRate = $totalCapacity > 0 ? round(($totalEnrolled / $totalCapacity) * 100) : 0;

// ── Category helpers ──────────────────────────────────────────────────────────
function categoryColor($cat) {
  return match($cat) {
    'Nutrition Intervention' => 'bg-blue-100 text-blue-700',
    'Critical Intervention'  => 'bg-red-100 text-red-700',
    'Preventive Care'        => 'bg-green-100 text-green-700',
    'Supplementation'        => 'bg-purple-100 text-purple-700',
    'Maternal Health'        => 'bg-pink-100 text-pink-700',
    default                  => 'bg-gray-100 text-gray-700',
  };
}

function categoryIcon($cat) {
  return match($cat) {
    'Nutrition Intervention' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0M3 16.5v-1.875a1.875 1.875 0 011.875-1.875h14.25A1.875 1.875 0 0121 14.625V16.5"/>',
    'Critical Intervention'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>',
    'Preventive Care'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
    'Supplementation'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5"/>',
    'Maternal Health'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/>',
    default                  => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
  };
}

// ── Sidebar ──────────────────────────────────────────────────────────────────
$sidebar_active = 'programs';
$sidebar_items = [
  'dashboard' => ['label'=>'Dashboard',      'href'=>'dashboard.php', 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
  'records'   => ['label'=>'Health Records', 'href'=>'records_bns.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
  'programs'  => ['label'=>'Programs',       'href'=>'programs.php',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>'],
  'reports'   => ['label'=>'Reports',        'href'=>'reports_bns.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zm6-4.5C9 8.004 9.504 7.5 10.125 7.5h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019 19.875V8.625zm6-4.5c0-.621.504-1.125 1.125-1.125h2.25C21.496 3 22 3.504 22 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>'],
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

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">Nutrition Programs</span>';

$programsJson     = json_encode($programs);
$participantsJson = json_encode($participants);

ob_start();
?>

<div class="p-6 space-y-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-cyan-500 to-teal-600 text-white rounded-2xl p-8 shadow-xl">
    <h1 class="text-3xl font-bold mb-2">Nutrition Programs</h1>
    <p class="text-sm text-white/90">Manage feeding programs, interventions, and monitor participant progress</p>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <?php
      $stats = [
        ['label'=>'Active Programs',   'value'=>$activeCount,       'border'=>'border-blue-500',  'grad'=>'from-blue-500 to-blue-600',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0M3 16.5v-1.875a1.875 1.875 0 011.875-1.875h14.25A1.875 1.875 0 0121 14.625V16.5"/>'],
        ['label'=>'Total Participants','value'=>$totalEnrolled,     'border'=>'border-green-500', 'grad'=>'from-green-500 to-green-600', 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>'],
        ['label'=>'Total Capacity',    'value'=>$totalCapacity,     'border'=>'border-purple-500','grad'=>'from-purple-500 to-purple-600','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5"/>'],
        ['label'=>'Utilization Rate',  'value'=>$utilizationRate.'%','border'=>'border-orange-500','grad'=>'from-orange-500 to-orange-600','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>'],
      ];
      foreach ($stats as $s): ?>
      <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 <?= $s['border'] ?>">
        <div class="flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-600 mb-1"><?= $s['label'] ?></div>
            <div class="text-3xl font-bold mb-1"><?= $s['value'] ?></div>
          </div>
          <div class="w-14 h-14 bg-gradient-to-br <?= $s['grad'] ?> rounded-xl flex items-center justify-center shadow-lg">
            <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <?= $s['icon'] ?>
            </svg>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Filters -->
  <div class="flex gap-3 flex-wrap">
    <div class="relative flex-1 min-w-64">
      <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
      </svg>
      <input id="search-input" type="text" placeholder="Search programs..."
        oninput="filterPrograms()"
        class="w-full pl-10 pr-4 py-3 bg-white shadow-md border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" />
    </div>
    <select id="category-filter" onchange="filterPrograms()"
      class="w-56 h-12 px-3 bg-white shadow-md border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
      <option value="all">All Categories</option>
      <option>Nutrition Intervention</option>
      <option>Critical Intervention</option>
      <option>Preventive Care</option>
      <option>Supplementation</option>
      <option>Maternal Health</option>
      <option>Prevention</option>
    </select>
    <select id="status-filter" onchange="filterPrograms()"
      class="w-48 h-12 px-3 bg-white shadow-md border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
      <option value="all">All Status</option>
      <option>Active</option>
      <option>Completed</option>
      <option>Planning</option>
    </select>
  </div>

  <!-- Programs Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="programs-grid">
    <?php foreach ($programs as $prog):
      $util    = $prog['capacity'] > 0 ? round(($prog['enrolled'] / $prog['capacity']) * 100) : 0;
      $barColor = $util >= 90 ? 'bg-red-500' : ($util >= 70 ? 'bg-yellow-500' : 'bg-green-500');
    ?>
    <div
      class="program-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all p-6 border-t-4 border-cyan-500"
      data-name="<?= strtolower(htmlspecialchars($prog['name'])) ?>"
      data-desc="<?= strtolower(htmlspecialchars($prog['description'])) ?>"
      data-category="<?= htmlspecialchars($prog['category']) ?>"
      data-status="<?= htmlspecialchars($prog['status']) ?>"
    >
      <!-- Card Header -->
      <div class="flex items-start gap-3 mb-4">
        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-teal-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
          <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <?= categoryIcon($prog['category']) ?>
          </svg>
        </div>
        <div class="min-w-0">
          <h3 class="font-semibold text-gray-900 leading-tight"><?= htmlspecialchars($prog['name']) ?></h3>
          <p class="text-xs text-gray-400"><?= htmlspecialchars($prog['id']) ?></p>
        </div>
      </div>

      <!-- Category Badge -->
      <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium mb-3 <?= categoryColor($prog['category']) ?>">
        <?= htmlspecialchars($prog['category']) ?>
      </span>

      <!-- Description -->
      <p class="text-sm text-gray-600 mb-4 line-clamp-2" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-clamp:2;">
        <?= htmlspecialchars($prog['description']) ?>
      </p>

      <!-- Enrollment -->
      <div class="space-y-2 mb-4">
        <div class="flex items-center justify-between text-sm">
          <span class="text-gray-600">Participants:</span>
          <span class="font-semibold"><?= $prog['enrolled'] ?> / <?= $prog['capacity'] ?></span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
          <div class="h-2 rounded-full transition-all <?= $barColor ?>" style="width:<?= $util ?>%"></div>
        </div>
      </div>

      <!-- Schedule & Location -->
      <div class="text-xs text-gray-500 space-y-1 mb-4">
        <div>📅 <?= htmlspecialchars($prog['schedule']) ?></div>
        <div>📍 <?= htmlspecialchars($prog['location']) ?></div>
      </div>

      <!-- View Details Button -->
      <button
        onclick="viewProgram('<?= htmlspecialchars($prog['id']) ?>')"
        class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg text-white text-sm font-medium shadow-md transition-all"
        style="background:linear-gradient(to right,#06b6d4,#0d9488);"
        onmouseover="this.style.background='linear-gradient(to right,#0891b2,#0f766e)'"
        onmouseout="this.style.background='linear-gradient(to right,#06b6d4,#0d9488)'"
      >
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        View Details
      </button>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- No results -->
  <div id="no-results" class="hidden text-center py-16 text-gray-400">
    <svg class="w-16 h-16 mx-auto mb-4 opacity-30" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
    </svg>
    <p class="text-lg font-medium">No programs found</p>
    <p class="text-sm">Try adjusting your search or filters</p>
  </div>

</div>

<!-- ══ PROGRAM DETAILS MODAL ════════════════════════════════════════════════ -->
<div id="program-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(0,0,0,0.5);">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
    <div class="flex items-start justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-2xl z-10">
      <div>
        <h2 id="modal-title" class="text-2xl font-bold text-gray-900"></h2>
        <p id="modal-desc" class="text-sm text-gray-500 mt-1"></p>
      </div>
      <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-lg ml-4 flex-shrink-0">
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
    <div id="modal-body" class="p-6 space-y-6"></div>
  </div>
</div>

<script>
const ALL_PROGRAMS    = <?= $programsJson ?>;
const ALL_PARTICIPANTS= <?= $participantsJson ?>;

// ── Filter ───────────────────────────────────────────────────────────────────
function filterPrograms() {
  const search   = document.getElementById('search-input').value.toLowerCase();
  const category = document.getElementById('category-filter').value;
  const status   = document.getElementById('status-filter').value;
  const cards    = document.querySelectorAll('.program-card');
  let visible    = 0;

  cards.forEach(card => {
    const matchSearch   = card.dataset.name.includes(search) || card.dataset.desc.includes(search);
    const matchCategory = category === 'all' || card.dataset.category === category;
    const matchStatus   = status   === 'all' || card.dataset.status   === status;
    const show = matchSearch && matchCategory && matchStatus;
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });

  document.getElementById('no-results').classList.toggle('hidden', visible > 0);
}

// ── Category helpers (mirrors PHP) ────────────────────────────────────────────
function catColor(cat) {
  const map = {
    'Nutrition Intervention': 'bg-blue-100 text-blue-700',
    'Critical Intervention':  'bg-red-100 text-red-700',
    'Preventive Care':        'bg-green-100 text-green-700',
    'Supplementation':        'bg-purple-100 text-purple-700',
    'Maternal Health':        'bg-pink-100 text-pink-700',
  };
  return map[cat] || 'bg-gray-100 text-gray-700';
}

// ── Modal ─────────────────────────────────────────────────────────────────────
function viewProgram(id) {
  const prog = ALL_PROGRAMS.find(p => p.id === id);
  if (!prog) return;

  document.getElementById('modal-title').textContent = prog.name;
  document.getElementById('modal-desc').textContent  = prog.description;

  const util = prog.capacity > 0 ? Math.round((prog.enrolled / prog.capacity) * 100) : 0;
  const barColor = util >= 90 ? '#ef4444' : util >= 70 ? '#eab308' : '#22c55e';

  // Interventions list
  const interventions = prog.interventions.map(i =>
    `<li class="flex items-start gap-2 text-sm"><span class="text-cyan-600 mt-0.5 font-bold">✓</span><span>${i}</span></li>`
  ).join('');

  // Participants table
  const partList = ALL_PARTICIPANTS[id];
  let participantsSection = '';
  if (partList?.length) {
    const rows = partList.map(p => `
      <tr class="border-b border-gray-100 last:border-0">
        <td class="p-3 text-sm font-medium">${p.name}</td>
        <td class="p-3 text-sm text-gray-600">${p.age}</td>
        <td class="p-3"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">${p.status}</span></td>
        <td class="p-3 text-sm text-gray-600">${p.progress}</td>
      </tr>`).join('');

    participantsSection = `
      <div>
        <h4 class="font-semibold mb-3 text-gray-800">Enrolled Participants</h4>
        <div class="border border-gray-200 rounded-xl overflow-hidden">
          <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
              <tr>
                <th class="text-left p-3 text-sm font-semibold text-gray-700">Name</th>
                <th class="text-left p-3 text-sm font-semibold text-gray-700">Age</th>
                <th class="text-left p-3 text-sm font-semibold text-gray-700">Status</th>
                <th class="text-left p-3 text-sm font-semibold text-gray-700">Progress</th>
              </tr>
            </thead>
            <tbody>${rows}</tbody>
          </table>
        </div>
      </div>`;
  }

  document.getElementById('modal-body').innerHTML = `
    <!-- Info grid -->
    <div class="grid grid-cols-2 gap-4">
      <div><p class="text-sm text-gray-500 mb-1">Category</p>
        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium ${catColor(prog.category)}">${prog.category}</span>
      </div>
      <div><p class="text-sm text-gray-500 mb-1">Status</p>
        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">${prog.status}</span>
      </div>
      <div><p class="text-sm text-gray-500 mb-1">Target Group</p><p class="text-sm font-medium">${prog.targetGroup}</p></div>
      <div><p class="text-sm text-gray-500 mb-1">Duration</p><p class="text-sm font-medium">${prog.duration}</p></div>
      <div><p class="text-sm text-gray-500 mb-1">Coordinator</p><p class="text-sm font-medium">${prog.coordinator}</p></div>
      <div><p class="text-sm text-gray-500 mb-1">Start Date</p><p class="text-sm font-medium">${prog.startDate}</p></div>
      <div><p class="text-sm text-gray-500 mb-1">Schedule</p><p class="text-sm font-medium">${prog.schedule}</p></div>
      <div><p class="text-sm text-gray-500 mb-1">Location</p><p class="text-sm font-medium">${prog.location}</p></div>
    </div>

    <!-- Enrollment bar -->
    <div class="p-4 bg-gray-50 rounded-xl">
      <div class="flex items-center justify-between text-sm mb-2">
        <span class="font-medium text-gray-700">Enrollment</span>
        <span class="font-bold">${prog.enrolled} / ${prog.capacity} (${util}%)</span>
      </div>
      <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
        <div class="h-3 rounded-full transition-all" style="width:${util}%;background:${barColor}"></div>
      </div>
    </div>

    <!-- Interventions -->
    <div>
      <h4 class="font-semibold mb-3 text-gray-800">Program Interventions</h4>
      <ul class="space-y-2">${interventions}</ul>
    </div>

    ${participantsSection}
  `;

  const modal = document.getElementById('program-modal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeModal() {
  const modal = document.getElementById('program-modal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

document.getElementById('program-modal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});
</script>

<?php
$page_content = ob_get_clean();
?>
<?= $page_content ?>