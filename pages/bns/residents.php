<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$role     = $_SESSION['role'] ?? 'bns';
$userName = $_SESSION['name'] ?? 'Rosa Mendoza';

// BNS purok assignment
$userAssignments = [
  'Ana Torres'   => 'Purok 1',
  'Maria Santos' => 'Purok 2',
  'Rosa Mendoza' => 'Purok 3',
  'Carmen Lopez' => 'Purok 1',
];
$userPurok = $userAssignments[$userName] ?? '';

// ── Residents Data ────────────────────────────────────────────────────────────
$residents = [
  [
    'id'                  => 'R-001',
    'name'                => 'Juan Dela Cruz Jr.',
    'age'                 => '3y',
    'sex'                 => 'M',
    'purok'               => 'Purok 1',
    'status'              => 'Normal',
    'statusColor'         => 'bg-green-100 text-green-700',
    'lastAssessment'      => '2026-03-01',
    'birthday'            => '2023-01-15',
    'contactNo'           => '09123456789',
    'civilStatus'         => 'Single',
    'birthplace'          => 'Tuy, Batangas',
    'philhealthNo'        => '12-345678901-2',
    'occupation'          => 'N/A (Minor)',
    'weight'              => '14.5',
    'height'              => '95',
    'waist'               => 'N/A',
    'bmi'                 => '16.1',
    'familyPlanningMethod'=> 'N/A',
    'isPregnant'          => false,
    'pregnancyInfo'       => null,
    'formsAnswered'       => [],
  ],
  [
    'id'                  => 'R-002',
    'name'                => 'Ana Santos',
    'age'                 => '2y',
    'sex'                 => 'F',
    'purok'               => 'Purok 1',
    'status'              => 'Underweight',
    'statusColor'         => 'bg-yellow-100 text-yellow-700',
    'lastAssessment'      => '2026-02-28',
    'birthday'            => '2024-02-10',
    'contactNo'           => '09234567890',
    'civilStatus'         => 'Single',
    'birthplace'          => 'Tuy, Batangas',
    'philhealthNo'        => '12-345678902-3',
    'occupation'          => 'N/A (Minor)',
    'weight'              => '10.2',
    'height'              => '85',
    'waist'               => 'N/A',
    'bmi'                 => '14.1',
    'familyPlanningMethod'=> 'N/A',
    'isPregnant'          => false,
    'pregnancyInfo'       => null,
    'formsAnswered'       => [],
  ],
  [
    'id'                  => 'R-006',
    'name'                => 'Maricon Olivar Capacia',
    'age'                 => '32y',
    'sex'                 => 'F',
    'purok'               => 'Purok 2',
    'status'              => 'Pregnant',
    'statusColor'         => 'bg-pink-100 text-pink-700',
    'lastAssessment'      => '2026-03-10',
    'birthday'            => '1993-04-12',
    'contactNo'           => '09551593652',
    'civilStatus'         => 'Married',
    'birthplace'          => 'Magahis, Tuy, Batangas',
    'philhealthNo'        => '12-345678906-7',
    'occupation'          => 'Housewife',
    'weight'              => '62',
    'height'              => '158',
    'waist'               => '85',
    'bmi'                 => '24.8',
    'familyPlanningMethod'=> 'N/A (Currently Pregnant)',
    'isPregnant'          => true,
    'pregnancyInfo'       => [
      'lmp'     => '2025-08-15',
      'edd'     => '2026-05-22',
      'gravida' => '2',
      'para'    => '1',
      'prenatalVisits' => [
        ['weeks'=>'1-12',  'date'=>'2025-10-05'],
        ['weeks'=>'13-20', 'date'=>'2025-12-04'],
        ['weeks'=>'21-26', 'date'=>'2026-01-15'],
        ['weeks'=>'27-30', 'date'=>'2026-02-12'],
        ['weeks'=>'31-34', 'date'=>'2026-03-02'],
      ],
    ],
    'formsAnswered' => [
      ['name'=>'PhilPEN Assessment','date'=>'2026-02-15','status'=>'Completed'],
      ['name'=>'Prenatal Check-up', 'date'=>'2026-03-02','status'=>'Completed'],
    ],
  ],
  [
    'id'                  => 'R-007',
    'name'                => 'Elena Vega Hernandez',
    'age'                 => '36y',
    'sex'                 => 'F',
    'purok'               => 'Purok 1',
    'status'              => 'Pregnant',
    'statusColor'         => 'bg-pink-100 text-pink-700',
    'lastAssessment'      => '2026-03-08',
    'birthday'            => '1988-09-01',
    'contactNo'           => '09678901234',
    'civilStatus'         => 'Married',
    'birthplace'          => 'Tuy, Batangas',
    'philhealthNo'        => '12-345678907-8',
    'occupation'          => 'Teacher',
    'weight'              => '68',
    'height'              => '162',
    'waist'               => '90',
    'bmi'                 => '25.9',
    'familyPlanningMethod'=> 'N/A (Currently Pregnant)',
    'isPregnant'          => true,
    'pregnancyInfo'       => [
      'lmp'     => '2025-10-05',
      'edd'     => '2026-07-12',
      'gravida' => '3',
      'para'    => '2',
      'prenatalVisits' => [
        ['weeks'=>'1-12',  'date'=>'2025-11-20'],
        ['weeks'=>'13-20', 'date'=>'2026-01-05'],
      ],
    ],
    'formsAnswered' => [
      ['name'=>'PhilPEN Assessment','date'=>'2026-01-28','status'=>'Completed'],
      ['name'=>'Prenatal Check-up', 'date'=>'2026-01-05','status'=>'Completed'],
    ],
  ],
  [
    'id'                  => 'R-008',
    'name'                => 'Maria Garcia Lopez',
    'age'                 => '28y',
    'sex'                 => 'F',
    'purok'               => 'Purok 3',
    'status'              => 'Normal',
    'statusColor'         => 'bg-green-100 text-green-700',
    'lastAssessment'      => '2026-03-05',
    'birthday'            => '1998-05-20',
    'contactNo'           => '09345678901',
    'civilStatus'         => 'Married',
    'birthplace'          => 'Tuy, Batangas',
    'philhealthNo'        => '12-345678908-9',
    'occupation'          => 'Store Owner',
    'weight'              => '58',
    'height'              => '160',
    'waist'               => '75',
    'bmi'                 => '22.7',
    'familyPlanningMethod'=> 'Pills',
    'isPregnant'          => false,
    'pregnancyInfo'       => null,
    'formsAnswered' => [
      ['name'=>'PhilPEN Assessment',  'date'=>'2026-03-05','status'=>'Completed'],
      ['name'=>'Nutrition Assessment','date'=>'2026-02-20','status'=>'Completed'],
    ],
  ],
];

// BNS sees only their assigned purok
$scopedResidents = array_values(array_filter($residents, fn($r) => !$userPurok || $r['purok'] === $userPurok));

// Encode for JS modal
$residentsJson = json_encode($scopedResidents);

// ── Sidebar ──────────────────────────────────────────────────────────────────
$sidebar_active = 'records';
$sidebar_items = [
  'dashboard' => ['label'=>'Dashboard',      'href'=>'dashboard.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
  'records'   => ['label'=>'Health Records', 'href'=>'records.php',  'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
  'reports'   => ['label'=>'Reports',        'href'=>'reports_bns.php','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zm6-4.5C9 8.004 9.504 7.5 10.125 7.5h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019 19.875V8.625zm6-4.5c0-.621.504-1.125 1.125-1.125h2.25C21.496 3 22 3.504 22 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>'],
  'map'       => ['label'=>'Heatmap',        'href'=>'map.php',      'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>'],
  'alerts'    => ['label'=>'Alerts',         'href'=>'alerts.php',   'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>'],
  'bmi'       => ['label'=>'BMI Calculator', 'href'=>'bmi.php',      'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.598 4.5 4.583V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.583c0-.985-.807-1.883-1.907-2.011A48.507 48.507 0 0012 2.25z"/>'],
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

$topbar_content = '<span style="font-size:1rem;font-weight:600;color:#111827;">Resident Profiles</span>';

ob_start();
?>

<div class="p-6 space-y-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-cyan-500 to-teal-600 text-white rounded-2xl p-8 shadow-xl">
    <div class="flex items-start justify-between flex-wrap gap-3">
      <div>
        <h1 class="text-3xl font-bold mb-2">Resident Profiles</h1>
        <p class="text-sm text-white/90">
          Manage demographics and health records
          <?= $userPurok ? ' · ' . htmlspecialchars($userPurok) : '' ?>
        </p>
      </div>
      <button
        onclick="openAddModal()"
        class="flex items-center gap-2 bg-white text-cyan-600 hover:bg-gray-100 px-4 py-2.5 rounded-lg text-sm font-semibold shadow-lg transition-all"
      >
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Add Resident
      </button>
    </div>
  </div>

  <!-- Filters -->
  <div class="flex gap-3 flex-wrap">
    <div class="relative flex-1 min-w-64">
      <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
      </svg>
      <input
        id="search-input"
        type="text"
        placeholder="Search by name or ID..."
        oninput="filterTable()"
        class="w-full pl-10 pr-4 py-3 bg-white shadow-md border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500"
      />
    </div>
    <select
      id="purok-filter"
      onchange="filterTable()"
      class="w-48 h-12 px-3 bg-white shadow-md border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500"
    >
      <option value="all">All Puroks</option>
      <?php foreach (['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5'] as $p): ?>
        <option value="<?= $p ?>" <?= $p === $userPurok ? 'selected' : '' ?>><?= $p ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full" id="residents-table">
        <thead class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
          <tr>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">ID</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Name</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Age / Sex</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Purok</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Status</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Last Assessment</th>
            <th class="text-left p-4 text-sm font-semibold text-gray-700">Actions</th>
          </tr>
        </thead>
        <tbody id="residents-tbody">
          <?php foreach ($scopedResidents as $res): ?>
          <tr
            class="resident-row border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-white transition-all"
            data-id="<?= htmlspecialchars($res['id']) ?>"
            data-name="<?= strtolower(htmlspecialchars($res['name'])) ?>"
            data-purok="<?= htmlspecialchars($res['purok']) ?>"
          >
            <td class="p-4 text-sm text-gray-600 font-medium"><?= htmlspecialchars($res['id']) ?></td>
            <td class="p-4 text-sm font-semibold"><?= htmlspecialchars($res['name']) ?></td>
            <td class="p-4 text-sm text-gray-600"><?= htmlspecialchars($res['age']) ?> / <?= htmlspecialchars($res['sex']) ?></td>
            <td class="p-4 text-sm text-gray-600"><?= htmlspecialchars($res['purok']) ?></td>
            <td class="p-4">
              <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium <?= htmlspecialchars($res['statusColor']) ?>">
                <?= htmlspecialchars($res['status']) ?>
              </span>
            </td>
            <td class="p-4 text-sm text-gray-600"><?= htmlspecialchars($res['lastAssessment']) ?></td>
            <td class="p-4">
              <div class="flex gap-1">
                <button
                  onclick="viewResident('<?= htmlspecialchars($res['id']) ?>')"
                  class="p-2 hover:bg-blue-50 rounded-lg transition-colors group"
                  title="View"
                >
                  <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                </button>
                <button
                  onclick="editResident('<?= htmlspecialchars($res['id']) ?>')"
                  class="p-2 hover:bg-green-50 rounded-lg transition-colors group"
                  title="Edit"
                >
                  <svg class="w-4 h-4 text-gray-500 group-hover:text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Footer -->
    <div class="flex items-center justify-between p-4 border-t border-gray-200 bg-gray-50">
      <div class="text-sm text-gray-600 font-medium" id="table-footer">
        Showing <?= count($scopedResidents) ?> of <?= count($scopedResidents) ?> residents
        <?= $userPurok ? ' · ' . htmlspecialchars($userPurok) : '' ?>
      </div>
      <div class="flex gap-2">
        <button disabled class="p-2 border border-gray-200 rounded-lg opacity-40 bg-white">
          <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
        </button>
        <button disabled class="p-2 border border-gray-200 rounded-lg opacity-40 bg-white">
          <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </button>
      </div>
    </div>
  </div>

</div>

<!-- ══ VIEW DETAIL MODAL ══════════════════════════════════════════════════════ -->
<div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(0,0,0,0.5);">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">

    <!-- Modal Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-2xl z-10">
      <h2 class="text-xl font-bold text-cyan-700">Complete Resident Information</h2>
      <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Modal Body -->
    <div id="modal-body" class="p-6 space-y-6"></div>
  </div>
</div>

<!-- ══ ADD RESIDENT MODAL ═════════════════════════════════════════════════════ -->
<div id="add-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(0,0,0,0.5);">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
    <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-2xl z-10">
      <h2 class="text-xl font-bold text-cyan-700">Add New Resident</h2>
      <button onclick="closeAddModal()" class="p-2 hover:bg-gray-100 rounded-lg">
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <form class="p-6 space-y-4" onsubmit="submitAddResident(event)">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php
          $addFields = [
            ['name'=>'full_name',    'label'=>'Full Name',       'type'=>'text',   'required'=>true],
            ['name'=>'birthday',     'label'=>'Birthday',        'type'=>'date',   'required'=>true],
            ['name'=>'sex',          'label'=>'Sex',             'type'=>'select', 'options'=>['M'=>'Male','F'=>'Female'],'required'=>true],
            ['name'=>'civil_status', 'label'=>'Civil Status',    'type'=>'select', 'options'=>['Single'=>'Single','Married'=>'Married','Widowed'=>'Widowed','Separated'=>'Separated'],'required'=>true],
            ['name'=>'birthplace',   'label'=>'Birthplace',      'type'=>'text',   'required'=>false],
            ['name'=>'contact_no',   'label'=>'Contact Number',  'type'=>'text',   'required'=>false],
            ['name'=>'philhealth_no','label'=>'PhilHealth No.',  'type'=>'text',   'required'=>false],
            ['name'=>'occupation',   'label'=>'Occupation',      'type'=>'text',   'required'=>false],
            ['name'=>'weight',       'label'=>'Weight (kg)',      'type'=>'number', 'required'=>false],
            ['name'=>'height',       'label'=>'Height (cm)',      'type'=>'number', 'required'=>false],
          ];
          foreach ($addFields as $f): ?>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5"><?= $f['label'] ?><?= $f['required'] ? ' *' : '' ?></label>
            <?php if ($f['type'] === 'select'): ?>
              <select name="<?= $f['name'] ?>" <?= $f['required'] ? 'required' : '' ?>
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                <option value="">Select...</option>
                <?php foreach ($f['options'] as $v => $l): ?>
                  <option value="<?= $v ?>"><?= $l ?></option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <input type="<?= $f['type'] ?>" name="<?= $f['name'] ?>" <?= $f['required'] ? 'required' : '' ?>
                <?= $f['type']==='number' ? 'step="0.1" min="0"' : '' ?>
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" />
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1.5">Purok</label>
          <select name="purok" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
            <?php foreach (['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5'] as $p): ?>
              <option value="<?= $p ?>" <?= $p === $userPurok ? 'selected' : '' ?>><?= $p ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="flex items-center gap-2 mt-2 cursor-pointer">
            <input type="checkbox" name="is_pregnant" id="is-pregnant-check" onchange="togglePregnancyFields()" class="w-4 h-4 accent-cyan-500" />
            <span class="text-sm font-medium text-gray-700">Currently Pregnant</span>
          </label>
        </div>
      </div>

      <!-- Pregnancy fields (hidden by default) -->
      <div id="pregnancy-fields" class="hidden space-y-4 p-4 bg-pink-50 rounded-xl border border-pink-200">
        <h4 class="text-sm font-bold text-pink-700">Pregnancy Information</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">LMP (Last Menstrual Period)</label>
            <input type="date" name="lmp" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">EDD (Expected Delivery Date)</label>
            <input type="date" name="edd" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Gravida</label>
            <input type="number" name="gravida" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Para</label>
            <input type="number" name="para" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500" />
          </div>
        </div>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-lg text-white text-sm font-medium shadow-lg transition-all" style="background:linear-gradient(to right,#06b6d4,#0d9488);">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
          Add Resident
        </button>
        <button type="button" onclick="closeAddModal()" class="px-6 py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 text-sm font-medium bg-white">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
const ALL_RESIDENTS = <?= $residentsJson ?>;

// ── Search & filter ──────────────────────────────────────────────────────────
function filterTable() {
  const search = document.getElementById('search-input').value.toLowerCase();
  const purok  = document.getElementById('purok-filter').value;
  const rows   = document.querySelectorAll('.resident-row');
  let visible  = 0;
  rows.forEach(row => {
    const matchName  = row.dataset.name.includes(search) || row.dataset.id.toLowerCase().includes(search);
    const matchPurok = purok === 'all' || row.dataset.purok === purok;
    row.style.display = (matchName && matchPurok) ? '' : 'none';
    if (matchName && matchPurok) visible++;
  });
  const total = rows.length;
  const purokLabel = <?= json_encode($userPurok) ?>;
  document.getElementById('table-footer').textContent =
    `Showing ${visible} of ${total} residents${purokLabel ? ' · ' + purokLabel : ''}`;
}

// ── View Modal ───────────────────────────────────────────────────────────────
function viewResident(id) {
  const res = ALL_RESIDENTS.find(r => r.id === id);
  if (!res) return;

  const prenatalAllVisits = ['1-12','13-20','21-26','27-30','31-34','35-36','37-38','39-40'];
  const visitMap = {};
  if (res.pregnancyInfo?.prenatalVisits) {
    res.pregnancyInfo.prenatalVisits.forEach(v => { visitMap[v.weeks] = v.date; });
  }

  let pregnancySection = '';
  if (res.isPregnant && res.pregnancyInfo) {
    const visitRows = prenatalAllVisits.map(w => {
      const date = visitMap[w];
      const badge = date
        ? `<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Completed</span>`
        : `<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Pending</span>`;
      return `<tr class="border-b border-pink-100">
        <td class="p-2">${w} weeks</td>
        <td class="p-2 font-medium">${date || '—'}</td>
        <td class="p-2">${badge}</td>
      </tr>`;
    }).join('');

    pregnancySection = `
      <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-4 rounded-xl border border-pink-200">
        <h3 class="text-lg font-bold text-pink-800 mb-4 flex items-center gap-2">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
          Pregnancy Information
        </h3>
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div><p class="text-xs font-semibold text-gray-500 uppercase mb-0.5">LMP</p><p class="text-sm font-medium">${res.pregnancyInfo.lmp}</p></div>
          <div><p class="text-xs font-semibold text-gray-500 uppercase mb-0.5">EDD</p><p class="text-sm font-medium">${res.pregnancyInfo.edd}</p></div>
          <div><p class="text-xs font-semibold text-gray-500 uppercase mb-0.5">Gravida</p><p class="text-sm font-medium">G${res.pregnancyInfo.gravida}</p></div>
          <div><p class="text-xs font-semibold text-gray-500 uppercase mb-0.5">Para</p><p class="text-sm font-medium">P${res.pregnancyInfo.para}</p></div>
        </div>
        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Prenatal Consultation Schedule</p>
        <div class="overflow-x-auto">
          <table class="w-full text-xs">
            <thead class="bg-pink-100"><tr>
              <th class="p-2 text-left font-semibold">Weeks</th>
              <th class="p-2 text-left font-semibold">Date of Visit</th>
              <th class="p-2 text-left font-semibold">Status</th>
            </tr></thead>
            <tbody>${visitRows}</tbody>
          </table>
        </div>
      </div>`;
  }

  let formsSection = '';
  if (res.formsAnswered?.length) {
    const formItems = res.formsAnswered.map(f =>
      `<div><p class="text-xs font-semibold text-gray-500 uppercase mb-0.5">${f.name}</p>
       <p class="text-sm font-medium">${f.date} — ${f.status}</p></div>`
    ).join('');
    formsSection = `
      <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-xl border border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Forms Answered</h3>
        <div class="grid grid-cols-2 gap-4">${formItems}</div>
      </div>`;
  }

  document.getElementById('modal-body').innerHTML = `
    <!-- Personal Info -->
    <div class="bg-gradient-to-r from-cyan-50 to-teal-50 p-4 rounded-xl border border-cyan-200">
      <h3 class="text-lg font-bold text-cyan-800 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
        Personal Information
      </h3>
      <div class="grid grid-cols-2 gap-4">
        ${infoField('Full Name', res.name)}
        ${infoField('Resident ID', res.id)}
        ${infoField('Birthday', res.birthday)}
        ${infoField('Age / Sex', res.age + ' / ' + res.sex)}
        ${infoField('Civil Status', res.civilStatus)}
        ${infoField('Birthplace', res.birthplace)}
        ${infoField('Contact Number', res.contactNo)}
        ${infoField('Address / Purok', res.purok + ', Tuy, Batangas')}
        ${infoField('PhilHealth No.', res.philhealthNo)}
        ${infoField('Occupation', res.occupation)}
      </div>
    </div>

    <!-- Health Metrics -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
      <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3"/></svg>
        Health Metrics
      </h3>
      <div class="grid grid-cols-3 gap-4">
        ${infoField('Weight', res.weight + ' kg')}
        ${infoField('Height', res.height + ' cm')}
        ${infoField('Waist', res.waist + ' cm')}
        ${infoField('BMI', res.bmi)}
        <div><p class="text-xs font-semibold text-gray-500 uppercase mb-1">Nutritional Status</p>
          <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium ${res.statusColor}">${res.status}</span>
        </div>
        ${infoField('Last Assessment', res.lastAssessment)}
      </div>
      <div class="mt-3">${infoField('Family Planning Method', res.familyPlanningMethod)}</div>
    </div>

    ${pregnancySection}
    ${formsSection}
  `;

  const modal = document.getElementById('detail-modal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function infoField(label, value) {
  return `<div><p class="text-xs font-semibold text-gray-500 uppercase mb-0.5">${label}</p><p class="text-sm font-medium">${value || '—'}</p></div>`;
}

function closeModal() {
  const modal = document.getElementById('detail-modal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

// ── Edit (placeholder) ───────────────────────────────────────────────────────
function editResident(id) {
  alert('Edit resident ' + id + ' — connect to your edit form or route.');
}

// ── Add Modal ────────────────────────────────────────────────────────────────
function openAddModal() {
  const m = document.getElementById('add-modal');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeAddModal() {
  const m = document.getElementById('add-modal');
  m.classList.add('hidden');
  m.classList.remove('flex');
}

function togglePregnancyFields() {
  const checked = document.getElementById('is-pregnant-check').checked;
  document.getElementById('pregnancy-fields').classList.toggle('hidden', !checked);
}

function submitAddResident(e) {
  e.preventDefault();
  alert('Resident added! (Connect to your PHP backend to persist data.)');
  closeAddModal();
}

// Close modals on backdrop click
['detail-modal','add-modal'].forEach(id => {
  document.getElementById(id).addEventListener('click', function(e) {
    if (e.target === this) {
      this.classList.add('hidden');
      this.classList.remove('flex');
    }
  });
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
  <title>Resident Profiles – NutriGuard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="margin:0;font-family:sans-serif;">
  <?php include 'sidebar.php'; ?>
</body>
</html>