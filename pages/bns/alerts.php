<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$role      = $_SESSION['role'] ?? 'bhw';
$userName  = $_SESSION['name'] ?? '';
$isHead    = $role === 'head';
$isBHW     = $role === 'bhw';
$isBNS     = $role === 'bns';

// User → Purok assignments
$userAssignments = [
  'Ana Torres'   => 'Purok 1',
  'Maria Santos' => 'Purok 2',
  'Rosa Mendoza' => 'Purok 3',
  'Carmen Lopez' => 'Purok 4',
];
$userPurok = $userAssignments[$userName] ?? '';

// ── Alerts Data ──────────────────────────────────────────────────────────────
$alertsData = [
  ['id'=>'A-001','residentId'=>'R-004','residentName'=>'Maria Garcia',           'type'=>'High Risk - Malnutrition',          'category'=>'Malnutrition',       'priority'=>'Critical','priorityColor'=>'bg-red-100 text-red-700',    'message'=>'Severe wasted condition detected - immediate intervention required',                       'dueDate'=>'2026-03-16','status'=>'Pending',   'purok'=>'Purok 3','assignedTo'=>'Rosa Mendoza','assignedRole'=>'BNS','isCompleted'=>false],
  ['id'=>'A-009','residentId'=>'R-012','residentName'=>'Sofia Isabel Bautista',  'type'=>'Vaccination Due - Pentavalent 2',    'category'=>'Vaccination',        'priority'=>'High',    'priorityColor'=>'bg-purple-100 text-purple-700','message'=>'Pentavalent 2nd dose due (10 weeks schedule) - Baby is now 14 months old',                  'dueDate'=>'2026-03-20','status'=>'Pending',   'purok'=>'Purok 3','assignedTo'=>'Rosa Mendoza','assignedRole'=>'BNS','isCompleted'=>false],
  ['id'=>'A-010','residentId'=>'R-013','residentName'=>'Pedro Jr. Reyes',        'type'=>'Vaccination Due - MMR 1',            'category'=>'Vaccination',        'priority'=>'High',    'priorityColor'=>'bg-purple-100 text-purple-700','message'=>'Measles-Mumps-Rubella 1st dose due at 9 months - Child is now 33 months',                  'dueDate'=>'2026-03-22','status'=>'Pending',   'purok'=>'Purok 1','assignedTo'=>'Ana Torres',  'assignedRole'=>'BHW','isCompleted'=>false],
  ['id'=>'A-015','residentId'=>'R-014','residentName'=>'Ana Marie Santos',       'type'=>'Vaccination Complete - Annual Checkup','category'=>'Vaccination',      'priority'=>'Low',     'priorityColor'=>'bg-blue-100 text-blue-700',   'message'=>'Fully immunized - Annual health checkup recommended',                                       'dueDate'=>'2026-04-15','status'=>'Upcoming',  'purok'=>'Purok 2','assignedTo'=>'Maria Santos','assignedRole'=>'BHW','isCompleted'=>false],
  ['id'=>'A-011','residentId'=>'R-006','residentName'=>'Maricon Olivar Capacia', 'type'=>'Prenatal Visit - 35-36 weeks',       'category'=>'Maternal Health',    'priority'=>'High',    'priorityColor'=>'bg-pink-100 text-pink-700',   'message'=>'Prenatal check-up due for 35-36 weeks pregnancy milestone',                                 'dueDate'=>'2026-03-25','status'=>'Scheduled', 'purok'=>'Purok 2','assignedTo'=>'Rosa Mendoza','assignedRole'=>'BNS','isCompleted'=>false],
  ['id'=>'A-012','residentId'=>'R-007','residentName'=>'Elena Vega Hernandez',   'type'=>'Prenatal Visit - 27-30 weeks',       'category'=>'Maternal Health',    'priority'=>'High',    'priorityColor'=>'bg-pink-100 text-pink-700',   'message'=>'High-risk pregnancy - Prenatal check-up overdue',                                           'dueDate'=>'2026-03-18','status'=>'Pending',   'purok'=>'Purok 1','assignedTo'=>'Ana Torres',  'assignedRole'=>'BHW','isCompleted'=>false],
  ['id'=>'A-002','residentId'=>'R-003','residentName'=>'Pedro Reyes',            'type'=>'Follow-up - Stunted Child',          'category'=>'Nutrition Follow-up','priority'=>'High',    'priorityColor'=>'bg-orange-100 text-orange-700','message'=>'Monthly follow-up assessment due for stunted child in feeding program',                      'dueDate'=>'2026-03-18','status'=>'Pending',   'purok'=>'Purok 2','assignedTo'=>'Maria Santos','assignedRole'=>'BHW','isCompleted'=>false],
  ['id'=>'A-003','residentId'=>'R-002','residentName'=>'Ana Santos',             'type'=>'Monitoring - Feeding Program',       'category'=>'Nutrition Follow-up','priority'=>'Medium',  'priorityColor'=>'bg-yellow-100 text-yellow-700','message'=>'Progress check on supplementary feeding program - Weight monitoring',                        'dueDate'=>'2026-03-20','status'=>'Pending',   'purok'=>'Purok 1','assignedTo'=>'Ana Torres',  'assignedRole'=>'BHW','isCompleted'=>true ],
  ['id'=>'A-005','residentId'=>'R-008','residentName'=>'Isabella Cruz',          'type'=>'Follow-up - Weight Monitoring',      'category'=>'Nutrition Follow-up','priority'=>'High',    'priorityColor'=>'bg-orange-100 text-orange-700','message'=>'Bi-weekly weight monitoring due for underweight child',                                     'dueDate'=>'2026-03-17','status'=>'Pending',   'purok'=>'Purok 1','assignedTo'=>'Ana Torres',  'assignedRole'=>'BHW','isCompleted'=>false],
  ['id'=>'A-004','residentId'=>'R-006','residentName'=>'Sofia Villanueva',       'type'=>'Consultation - Nutrition Counseling','category'=>'Consultation',       'priority'=>'Medium',  'priorityColor'=>'bg-yellow-100 text-yellow-700','message'=>'Nutrition counseling session scheduled for mother',                                          'dueDate'=>'2026-03-22','status'=>'Scheduled', 'purok'=>'Purok 4','assignedTo'=>'Carmen Lopez','assignedRole'=>'BNS','isCompleted'=>false],
  ['id'=>'A-006','residentId'=>'R-001','residentName'=>'Juan Dela Cruz Jr.',     'type'=>'Routine Check - Quarterly',          'category'=>'Routine',            'priority'=>'Low',     'priorityColor'=>'bg-blue-100 text-blue-700',   'message'=>'Quarterly nutritional assessment reminder',                                                  'dueDate'=>'2026-04-01','status'=>'Upcoming',  'purok'=>'Purok 1','assignedTo'=>'Ana Torres',  'assignedRole'=>'BHW','isCompleted'=>false],
  ['id'=>'A-008','residentId'=>'R-005','residentName'=>'Carlos Mendoza',         'type'=>'Routine Check - Health Screening',   'category'=>'Routine',            'priority'=>'Low',     'priorityColor'=>'bg-blue-100 text-blue-700',   'message'=>'Regular health screening due for normal-status child',                                      'dueDate'=>'2026-04-10','status'=>'Upcoming',  'purok'=>'Purok 2','assignedTo'=>'Maria Santos','assignedRole'=>'BHW','isCompleted'=>false],
  ['id'=>'A-013','residentId'=>'R-009','residentName'=>'Miguel Santos',          'type'=>'BMI Recalculation Due',              'category'=>'Health Assessment',  'priority'=>'Medium',  'priorityColor'=>'bg-yellow-100 text-yellow-700','message'=>'3-month BMI reassessment due - Tracking obesity risk',                                       'dueDate'=>'2026-03-28','status'=>'Upcoming',  'purok'=>'Purok 3','assignedTo'=>'Rosa Mendoza','assignedRole'=>'BNS','isCompleted'=>false],
  ['id'=>'A-014','residentId'=>'R-010','residentName'=>'Carmen Bautista',        'type'=>'Vitamin A Supplementation',          'category'=>'Supplementation',    'priority'=>'Medium',  'priorityColor'=>'bg-yellow-100 text-yellow-700','message'=>'6-month Vitamin A dose due for child aged 24 months',                                       'dueDate'=>'2026-03-30','status'=>'Upcoming',  'purok'=>'Purok 2','assignedTo'=>'Maria Santos','assignedRole'=>'BHW','isCompleted'=>false],
];

// ── Handle toggle-complete via POST (AJAX) ───────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_id'])) {
  // In a real app, update DB here.
  // For demo, we track completed IDs in session.
  $id = $_POST['toggle_id'];
  if (!isset($_SESSION['completed_alerts'])) $_SESSION['completed_alerts'] = [];
  if (in_array($id, $_SESSION['completed_alerts'])) {
    $_SESSION['completed_alerts'] = array_values(array_diff($_SESSION['completed_alerts'], [$id]));
  } else {
    $_SESSION['completed_alerts'][] = $id;
  }
  echo json_encode(['ok' => true]);
  exit;
}

// Apply session-stored completions
$completedAlerts = $_SESSION['completed_alerts'] ?? [];
foreach ($alertsData as &$a) {
  if (in_array($a['id'], $completedAlerts)) $a['isCompleted'] = true;
}
unset($a);

// ── Role filter ───────────────────────────────────────────────────────────────
$roleFiltered = array_values(array_filter($alertsData, function($a) use ($isHead, $isBHW, $isBNS, $userPurok) {
  if ($isHead) return true;
  if (($isBHW || $isBNS) && $userPurok) return $a['purok'] === $userPurok;
  return true;
}));

// ── Stats ─────────────────────────────────────────────────────────────────────
$pendingCount   = count(array_filter($roleFiltered, fn($a) => $a['status'] === 'Pending'   && !$a['isCompleted']));
$scheduledCount = count(array_filter($roleFiltered, fn($a) => $a['status'] === 'Scheduled' && !$a['isCompleted']));
$upcomingCount  = count(array_filter($roleFiltered, fn($a) => $a['status'] === 'Upcoming'  && !$a['isCompleted']));
$completedCount = count(array_filter($roleFiltered, fn($a) => $a['isCompleted']));

// Pass data to JS as JSON
$alertsJson = json_encode($roleFiltered);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Alerts & Reminders – NutriGuard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

<?php
// ── Sidebar ────────────────────────────────────────────────────────────────
$sidebar_active = 'alerts';
$sidebar_items = [
  'dashboard' => ['label'=>'Dashboard',      'href'=>'dashboard.php', 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
  'records'   => ['label'=>'Health Records', 'href'=>'records.php',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
  'reports'   => ['label'=>'Reports',        'href'=>'reports.php',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zm6-4.5C9 8.004 9.504 7.5 10.125 7.5h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019 19.875V8.625zm6-4.5c0-.621.504-1.125 1.125-1.125h2.25C21.496 3 22 3.504 22 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>'],
  'map'       => ['label'=>'Heatmap',        'href'=>'map.php',       'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>'],
  'alerts'    => ['label'=>'Alerts',         'href'=>'alerts.php',    'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>'],
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

$user_name_esc = htmlspecialchars($userName);
$user_role_esc = strtoupper(htmlspecialchars($role));
$sidebar_footer = '
<div style="display:flex;align-items:center;gap:0.6rem;">
  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#06b6d4,#0d9488);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
    <svg style="width:18px;height:18px;color:#fff;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
    </svg>
  </div>
  <div class="sidebar-footer-text" style="flex:1;min-width:0;">
    <div style="font-size:0.8rem;font-weight:600;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' . $user_name_esc . '</div>
    <div style="font-size:0.7rem;color:#6b7280;">' . $user_role_esc . '</div>
  </div>
  <a href="logout.php" class="sidebar-label" title="Logout" style="color:#9ca3af;display:flex;align-items:center;">
    <svg style="width:16px;height:16px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
    </svg>
  </a>
</div>';

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">Alerts &amp; Reminders</span>';

// Page content assembled below, injected via $page_content
ob_start();
?>

<div class="p-6 space-y-6">

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-cyan-500 to-teal-600 text-white rounded-2xl p-8 shadow-xl">
    <h1 class="text-3xl font-bold mb-2">Alerts &amp; Reminders</h1>
    <p class="text-sm text-white/90">
      <?= $isHead
        ? 'Track all follow-ups, notifications, and risk-based alerts across all puroks'
        : 'Track your assigned alerts for ' . ($userPurok ?: 'your area')
      ?>
    </p>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <?php
      $stats = [
        ['label'=>'Pending',   'count'=>$pendingCount,   'note'=>'Requires immediate attention','border'=>'border-red-500',  'grad'=>'from-red-500 to-red-600',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>','note_color'=>'text-red-600'],
        ['label'=>'Scheduled', 'count'=>$scheduledCount, 'note'=>'Appointments set',            'border'=>'border-blue-500', 'grad'=>'from-blue-500 to-blue-600',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>','note_color'=>'text-blue-600'],
        ['label'=>'Upcoming',  'count'=>$upcomingCount,  'note'=>'Future reminders',            'border'=>'border-green-500','grad'=>'from-green-500 to-green-600','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>','note_color'=>'text-green-600'],
        ['label'=>'Completed', 'count'=>$completedCount, 'note'=>'Actions done',                'border'=>'border-gray-500', 'grad'=>'from-gray-500 to-gray-600',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>','note_color'=>'text-gray-600'],
      ];
      foreach ($stats as $s): ?>
      <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow border-l-4 <?= $s['border'] ?> p-6">
        <div class="flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-600 mb-1 font-medium"><?= $s['label'] ?></div>
            <div class="text-4xl font-bold mb-1" id="stat-<?= strtolower($s['label']) ?>"><?= $s['count'] ?></div>
            <div class="text-xs <?= $s['note_color'] ?> font-medium"><?= $s['note'] ?></div>
          </div>
          <div class="w-16 h-16 bg-gradient-to-br <?= $s['grad'] ?> rounded-2xl flex items-center justify-center shadow-lg">
            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <?= $s['icon'] ?>
            </svg>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Filters -->
  <div class="flex gap-3 flex-wrap items-center">
    <!-- Search -->
    <div class="relative flex-1 min-w-64">
      <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
      </svg>
      <input
        id="search-input"
        type="text"
        placeholder="Search by resident name, ID, or message..."
        oninput="applyFilters()"
        class="w-full pl-10 pr-4 py-3 bg-white shadow-md border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500"
      />
    </div>
    <!-- Priority -->
    <select id="priority-filter" onchange="applyFilters()" class="w-48 h-12 px-3 bg-white shadow-md border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
      <option value="all">All Priorities</option>
      <option value="Critical">Critical</option>
      <option value="High">High</option>
      <option value="Medium">Medium</option>
      <option value="Low">Low</option>
    </select>
    <!-- Status -->
    <select id="status-filter" onchange="applyFilters()" class="w-48 h-12 px-3 bg-white shadow-md border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
      <option value="all">All Status</option>
      <option value="Pending">Pending</option>
      <option value="Scheduled">Scheduled</option>
      <option value="Upcoming">Upcoming</option>
    </select>
    <!-- Show Completed checkbox -->
    <label class="flex items-center gap-2 bg-white shadow-md rounded-lg px-4 py-3 cursor-pointer h-12">
      <input type="checkbox" id="show-completed" onchange="applyFilters()" class="w-4 h-4 accent-cyan-500 cursor-pointer" />
      <span class="text-sm font-medium">Show Completed</span>
    </label>
  </div>

  <!-- Alerts Table -->
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full" id="alerts-table">
        <thead class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
          <tr>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Status</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Alert ID</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Resident</th>
            <?php if ($isHead): ?>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Assigned To</th>
            <?php endif; ?>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Type</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Priority</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Message</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Due Date</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Alert Status</th>
          </tr>
        </thead>
        <tbody id="alerts-tbody">
          <!-- Rendered by JS -->
        </tbody>
      </table>
    </div>
    <div class="p-4 border-t border-gray-200 bg-gray-50">
      <div class="text-sm text-gray-600 font-medium" id="alerts-footer">
        Showing 0 alerts
      </div>
    </div>
  </div>

</div>

<script>
const IS_HEAD = <?= json_encode($isHead) ?>;
const IS_BHW  = <?= json_encode($isBHW) ?>;
const IS_BNS  = <?= json_encode($isBNS) ?>;
const USER_PUROK = <?= json_encode($userPurok) ?>;

// All alerts passed from PHP
let alerts = <?= $alertsJson ?>;

function priorityColor(p) {
  const map = {
    Critical: 'bg-red-100 text-red-700',
    High:     'bg-orange-100 text-orange-700',
    Medium:   'bg-yellow-100 text-yellow-700',
    Low:      'bg-blue-100 text-blue-700',
  };
  return map[p] || 'bg-gray-100 text-gray-700';
}

function statusColor(s, completed) {
  if (completed) return 'bg-gray-100 text-gray-700';
  const map = { Pending:'bg-red-100 text-red-700', Scheduled:'bg-blue-100 text-blue-700', Upcoming:'bg-green-100 text-green-700' };
  return map[s] || 'bg-gray-100 text-gray-700';
}

function badge(text, cls) {
  return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${cls}">${text}</span>`;
}

function renderTable() {
  const search   = document.getElementById('search-input').value.toLowerCase();
  const priority = document.getElementById('priority-filter').value;
  const status   = document.getElementById('status-filter').value;
  const showDone = document.getElementById('show-completed').checked;

  const filtered = alerts.filter(a => {
    const matchSearch = a.residentName.toLowerCase().includes(search) ||
                        a.residentId.toLowerCase().includes(search) ||
                        a.message.toLowerCase().includes(search);
    const matchPriority = priority === 'all' || a.priority === priority;
    const matchStatus   = status === 'all'   || a.status === status;
    const matchDone     = showDone ? true : !a.isCompleted;
    return matchSearch && matchPriority && matchStatus && matchDone;
  });

  const tbody = document.getElementById('alerts-tbody');
  tbody.innerHTML = filtered.map(a => {
    const rowOpacity = a.isCompleted ? 'opacity-60' : '';

    // Status cell
    let statusCell = '';
    if (IS_BHW || IS_BNS) {
      statusCell = `<input type="checkbox" class="w-4 h-4 accent-cyan-500 cursor-pointer" ${a.isCompleted ? 'checked' : ''}
        onchange="toggleComplete('${a.id}')" title="Mark as completed" />`;
    } else if (IS_HEAD) {
      statusCell = a.isCompleted
        ? `<svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
        : badge(a.priority, priorityColor(a.priority));
    }

    // Assigned To column (head only)
    const assignedCol = IS_HEAD ? `
      <td class="p-4">
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
          </svg>
          <div>
            <div class="text-sm font-medium">${a.assignedTo}</div>
            <div class="text-xs text-gray-500">${a.assignedRole}</div>
          </div>
        </div>
      </td>` : '';

    return `
      <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all ${rowOpacity}" data-id="${a.id}">
        <td class="p-4">${statusCell}</td>
        <td class="p-4 text-sm text-gray-600 font-medium">${a.id}</td>
        <td class="p-4">
          <div class="text-sm font-medium">${a.residentName}</div>
          <div class="text-xs text-gray-500">${a.residentId} · ${a.purok}</div>
        </td>
        ${assignedCol}
        <td class="p-4 text-sm text-gray-600 font-medium">${a.type}</td>
        <td class="p-4">${badge(a.priority, priorityColor(a.priority))}</td>
        <td class="p-4 text-sm text-gray-600 max-w-xs">${a.message}</td>
        <td class="p-4 text-sm text-gray-600 font-medium">${a.dueDate}</td>
        <td class="p-4">${badge(a.isCompleted ? 'Completed' : a.status, statusColor(a.status, a.isCompleted))}</td>
      </tr>`;
  }).join('');

  document.getElementById('alerts-footer').textContent =
    `Showing ${filtered.length} of ${alerts.length} alerts${(!IS_HEAD && USER_PUROK) ? ' for ' + USER_PUROK : ''}`;

  updateStats();
}

function applyFilters() { renderTable(); }

function toggleComplete(id) {
  // Optimistic UI update
  alerts = alerts.map(a => a.id === id ? { ...a, isCompleted: !a.isCompleted } : a);
  renderTable();

  // Persist to server via POST
  fetch('alerts.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'toggle_id=' + encodeURIComponent(id)
  });
}

function updateStats() {
  const pending   = alerts.filter(a => a.status === 'Pending'   && !a.isCompleted).length;
  const scheduled = alerts.filter(a => a.status === 'Scheduled' && !a.isCompleted).length;
  const upcoming  = alerts.filter(a => a.status === 'Upcoming'  && !a.isCompleted).length;
  const completed = alerts.filter(a => a.isCompleted).length;
  document.getElementById('stat-pending').textContent   = pending;
  document.getElementById('stat-scheduled').textContent = scheduled;
  document.getElementById('stat-upcoming').textContent  = upcoming;
  document.getElementById('stat-completed').textContent = completed;
}

// Initial render
renderTable();
</script>

<?php
$page_content = ob_get_clean();
include 'sidebar.php';
?>
</body>
</html>