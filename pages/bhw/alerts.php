<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['user_id']) && !isset($_SESSION['user'])) {
    header('Location: pages/sign_in.php');
    exit;
}

// If this file is opened directly, reroute to layout so shared CSS/sidebar load correctly.
if (basename((string) ($_SERVER['SCRIPT_NAME'] ?? '')) === 'alerts.php' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    $redirectParams = $_GET;
    $redirectParams['page'] = 'alerts';
    header('Location: ../../layout.php?' . http_build_query($redirectParams));
    exit;
}

$currentUser = [
    'name' => (string) ($_SESSION['name'] ?? 'Rosa Dela Cruz'),
    'role' => strtolower((string) ($_SESSION['role'] ?? 'bhw')),
    'purok' => (string) ($_SESSION['purok'] ?? $_SESSION['purok_name'] ?? 'Purok 1'),
];

$isHead = in_array($currentUser['role'], ['head', 'hc_head', 'health_center_head'], true);
$isBHW = $currentUser['role'] === 'bhw';
$isBNS = $currentUser['role'] === 'bns';
$userPurok = $currentUser['purok'];

$allAlerts = [
    ['id' => 'A-001', 'residentId' => 'R-004', 'residentName' => 'Maria Garcia', 'type' => 'High Risk - Malnutrition', 'category' => 'Malnutrition', 'priority' => 'Critical', 'priorityClass' => 'priority-critical', 'message' => 'Severe wasted condition detected - immediate intervention required', 'dueDate' => '2026-03-16', 'status' => 'Pending', 'statusClass' => 'status-pending', 'purok' => 'Purok 3', 'assignedTo' => 'Rosa Mendoza', 'assignedRole' => 'BNS', 'isCompleted' => false],
    ['id' => 'A-009', 'residentId' => 'R-012', 'residentName' => 'Sofia Isabel Bautista', 'type' => 'Vaccination Due - Pentavalent 2', 'category' => 'Vaccination', 'priority' => 'High', 'priorityClass' => 'priority-high', 'message' => 'Pentavalent 2nd dose due (10 weeks schedule) - Baby is now 14 months old', 'dueDate' => '2026-03-20', 'status' => 'Pending', 'statusClass' => 'status-pending', 'purok' => 'Purok 3', 'assignedTo' => 'Rosa Mendoza', 'assignedRole' => 'BNS', 'isCompleted' => false],
    ['id' => 'A-010', 'residentId' => 'R-013', 'residentName' => 'Pedro Jr. Reyes', 'type' => 'Vaccination Due - MMR 1', 'category' => 'Vaccination', 'priority' => 'High', 'priorityClass' => 'priority-high', 'message' => 'Measles-Mumps-Rubella 1st dose due at 9 months - Child is now 33 months', 'dueDate' => '2026-03-22', 'status' => 'Pending', 'statusClass' => 'status-pending', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => false],
    ['id' => 'A-015', 'residentId' => 'R-014', 'residentName' => 'Ana Marie Santos', 'type' => 'Vaccination Complete - Annual Checkup', 'category' => 'Vaccination', 'priority' => 'Low', 'priorityClass' => 'priority-low', 'message' => 'Fully immunized - Annual health checkup recommended', 'dueDate' => '2026-04-15', 'status' => 'Upcoming', 'statusClass' => 'status-upcoming', 'purok' => 'Purok 2', 'assignedTo' => 'Maria Santos', 'assignedRole' => 'BHW', 'isCompleted' => false],
    ['id' => 'A-011', 'residentId' => 'R-006', 'residentName' => 'Maricon Olivar Capacia', 'type' => 'Prenatal Visit - 35-36 weeks', 'category' => 'Maternal Health', 'priority' => 'High', 'priorityClass' => 'priority-maternal', 'message' => 'Prenatal check-up due for 35-36 weeks pregnancy milestone', 'dueDate' => '2026-03-25', 'status' => 'Scheduled', 'statusClass' => 'status-scheduled', 'purok' => 'Purok 2', 'assignedTo' => 'Rosa Mendoza', 'assignedRole' => 'BNS', 'isCompleted' => false],
    ['id' => 'A-012', 'residentId' => 'R-007', 'residentName' => 'Elena Vega Hernandez', 'type' => 'Prenatal Visit - 27-30 weeks', 'category' => 'Maternal Health', 'priority' => 'High', 'priorityClass' => 'priority-maternal', 'message' => 'High-risk pregnancy - Prenatal check-up overdue', 'dueDate' => '2026-03-18', 'status' => 'Pending', 'statusClass' => 'status-pending', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => false],
    ['id' => 'A-002', 'residentId' => 'R-003', 'residentName' => 'Pedro Reyes', 'type' => 'Follow-up - Stunted Child', 'category' => 'Nutrition Follow-up', 'priority' => 'High', 'priorityClass' => 'priority-high-orange', 'message' => 'Monthly follow-up assessment due for stunted child in feeding program', 'dueDate' => '2026-03-18', 'status' => 'Pending', 'statusClass' => 'status-pending', 'purok' => 'Purok 2', 'assignedTo' => 'Maria Santos', 'assignedRole' => 'BHW', 'isCompleted' => false],
    ['id' => 'A-003', 'residentId' => 'R-002', 'residentName' => 'Ana Santos', 'type' => 'Monitoring - Feeding Program', 'category' => 'Nutrition Follow-up', 'priority' => 'Medium', 'priorityClass' => 'priority-medium', 'message' => 'Progress check on supplementary feeding program - Weight monitoring', 'dueDate' => '2026-03-20', 'status' => 'Pending', 'statusClass' => 'status-pending', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => true],
    ['id' => 'A-005', 'residentId' => 'R-008', 'residentName' => 'Isabella Cruz', 'type' => 'Follow-up - Weight Monitoring', 'category' => 'Nutrition Follow-up', 'priority' => 'High', 'priorityClass' => 'priority-high-orange', 'message' => 'Bi-weekly weight monitoring due for underweight child', 'dueDate' => '2026-03-17', 'status' => 'Pending', 'statusClass' => 'status-pending', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => false],
    ['id' => 'A-004', 'residentId' => 'R-006', 'residentName' => 'Sofia Villanueva', 'type' => 'Consultation - Nutrition Counseling', 'category' => 'Consultation', 'priority' => 'Medium', 'priorityClass' => 'priority-medium', 'message' => 'Nutrition counseling session scheduled for mother', 'dueDate' => '2026-03-22', 'status' => 'Scheduled', 'statusClass' => 'status-scheduled', 'purok' => 'Purok 4', 'assignedTo' => 'Carmen Lopez', 'assignedRole' => 'BNS', 'isCompleted' => false],
    ['id' => 'A-006', 'residentId' => 'R-001', 'residentName' => 'Juan Dela Cruz Jr.', 'type' => 'Routine Check - Quarterly', 'category' => 'Routine', 'priority' => 'Low', 'priorityClass' => 'priority-low', 'message' => 'Quarterly nutritional assessment reminder', 'dueDate' => '2026-04-01', 'status' => 'Upcoming', 'statusClass' => 'status-upcoming', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => false],
    ['id' => 'A-008', 'residentId' => 'R-005', 'residentName' => 'Carlos Mendoza', 'type' => 'Routine Check - Health Screening', 'category' => 'Routine', 'priority' => 'Low', 'priorityClass' => 'priority-low', 'message' => 'Regular health screening due for normal-status child', 'dueDate' => '2026-04-10', 'status' => 'Upcoming', 'statusClass' => 'status-upcoming', 'purok' => 'Purok 2', 'assignedTo' => 'Maria Santos', 'assignedRole' => 'BHW', 'isCompleted' => false],
    ['id' => 'A-013', 'residentId' => 'R-009', 'residentName' => 'Miguel Santos', 'type' => 'BMI Recalculation Due', 'category' => 'Health Assessment', 'priority' => 'Medium', 'priorityClass' => 'priority-medium', 'message' => '3-month BMI reassessment due - Tracking obesity risk', 'dueDate' => '2026-03-28', 'status' => 'Upcoming', 'statusClass' => 'status-upcoming', 'purok' => 'Purok 3', 'assignedTo' => 'Rosa Mendoza', 'assignedRole' => 'BNS', 'isCompleted' => false],
    ['id' => 'A-014', 'residentId' => 'R-010', 'residentName' => 'Carmen Bautista', 'type' => 'Vitamin A Supplementation', 'category' => 'Supplementation', 'priority' => 'Medium', 'priorityClass' => 'priority-medium', 'message' => '6-month Vitamin A dose due for child aged 24 months', 'dueDate' => '2026-03-30', 'status' => 'Upcoming', 'statusClass' => 'status-upcoming', 'purok' => 'Purok 2', 'assignedTo' => 'Maria Santos', 'assignedRole' => 'BHW', 'isCompleted' => false],
];

if (!isset($_SESSION['completedAlerts_bhw'])) {
    $_SESSION['completedAlerts_bhw'] = ['A-003'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_id'])) {
    $tid = (string) $_POST['toggle_id'];
    if (in_array($tid, $_SESSION['completedAlerts_bhw'], true)) {
        $_SESSION['completedAlerts_bhw'] = array_values(array_diff($_SESSION['completedAlerts_bhw'], [$tid]));
    } else {
        $_SESSION['completedAlerts_bhw'][] = $tid;
    }

    $routeQs = http_build_query(array_filter([
        'page' => 'alerts',
        'search' => $_POST['search'] ?? '',
        'priority' => $_POST['priority'] ?? 'all',
        'status' => $_POST['status'] ?? 'all',
        'completed' => $_POST['completed'] ?? '',
    ]));

    header('Location: layout.php' . ($routeQs ? "?$routeQs" : '?page=alerts'));
    exit;
}

foreach ($allAlerts as &$a) {
    $a['isCompleted'] = in_array($a['id'], $_SESSION['completedAlerts_bhw'], true);
}
unset($a);

$search = trim((string) ($_GET['search'] ?? ''));
$priorityFilter = (string) ($_GET['priority'] ?? 'all');
$statusFilter = (string) ($_GET['status'] ?? 'all');
$showCompleted = isset($_GET['completed']) && $_GET['completed'] === '1';

$scopedAlerts = array_values(array_filter($allAlerts, static fn($a) => $isHead || $a['purok'] === $userPurok));

$filtered = array_values(array_filter($scopedAlerts, static function ($a) use ($search, $priorityFilter, $statusFilter, $showCompleted) {
    $matchSearch = $search === ''
        || stripos($a['residentName'], $search) !== false
        || stripos($a['residentId'], $search) !== false
        || stripos($a['message'], $search) !== false;
    $matchPriority = $priorityFilter === 'all' || $a['priority'] === $priorityFilter;
    $matchStatus = $statusFilter === 'all' || $a['status'] === $statusFilter;
    $matchCompleted = $showCompleted ? true : !$a['isCompleted'];
    return $matchSearch && $matchPriority && $matchStatus && $matchCompleted;
}));

$pendingCount = count(array_filter($scopedAlerts, static fn($a) => $a['status'] === 'Pending' && !$a['isCompleted']));
$scheduledCount = count(array_filter($scopedAlerts, static fn($a) => $a['status'] === 'Scheduled' && !$a['isCompleted']));
$upcomingCount = count(array_filter($scopedAlerts, static fn($a) => $a['status'] === 'Upcoming' && !$a['isCompleted']));
$completedCount = count(array_filter($scopedAlerts, static fn($a) => $a['isCompleted']));

function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>

<style>
.alerts-page .alert-card { border-radius: 14px; border: 1px solid #e2e8f0; background: #fff; }
.alerts-page .metric { border-left: 4px solid; }
.alerts-page .metric.pending { border-left-color: #ef4444; }
.alerts-page .metric.scheduled { border-left-color: #3b82f6; }
.alerts-page .metric.upcoming { border-left-color: #22c55e; }
.alerts-page .metric.completed { border-left-color: #64748b; }
.alerts-page .badge { display: inline-flex; align-items: center; padding: 0.22rem 0.65rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; }
.alerts-page .priority-critical { background: #fee2e2; color: #b91c1c; }
.alerts-page .priority-high { background: #ede9fe; color: #6d28d9; }
.alerts-page .priority-high-orange { background: #ffedd5; color: #c2410c; }
.alerts-page .priority-maternal { background: #fce7f3; color: #be185d; }
.alerts-page .priority-medium { background: #fef9c3; color: #a16207; }
.alerts-page .priority-low { background: #dbeafe; color: #1d4ed8; }
.alerts-page .status-pending { background: #fee2e2; color: #b91c1c; }
.alerts-page .status-scheduled { background: #dbeafe; color: #1d4ed8; }
.alerts-page .status-upcoming { background: #dcfce7; color: #15803d; }
.alerts-page .status-completed { background: #f1f5f9; color: #475569; }
.alerts-page .completed-row { opacity: 0.55; }
.alerts-page .res-sub { font-size: 0.72rem; color: #94a3b8; margin-top: 0.15rem; }
</style>

<div class="alerts-page">
    <div class="mb-6 rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-800">Alerts &amp; Reminders</h1>
        <p class="mt-1 text-sm text-slate-600">
            <?= $isHead ? 'Track all follow-ups, notifications, and risk-based alerts across all puroks' : 'Track your assigned alerts for ' . h($userPurok) ?>
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4 mb-6">
        <div class="alert-card metric pending p-4"><p class="text-xs text-slate-500">Pending</p><p class="text-3xl font-bold text-slate-800"><?= $pendingCount ?></p></div>
        <div class="alert-card metric scheduled p-4"><p class="text-xs text-slate-500">Scheduled</p><p class="text-3xl font-bold text-slate-800"><?= $scheduledCount ?></p></div>
        <div class="alert-card metric upcoming p-4"><p class="text-xs text-slate-500">Upcoming</p><p class="text-3xl font-bold text-slate-800"><?= $upcomingCount ?></p></div>
        <div class="alert-card metric completed p-4"><p class="text-xs text-slate-500">Completed</p><p class="text-3xl font-bold text-slate-800"><?= $completedCount ?></p></div>
    </div>

    <form method="GET" action="layout.php" class="mb-6 grid grid-cols-1 gap-3 lg:grid-cols-5">
        <input type="hidden" name="page" value="alerts">
        <input type="text" name="search" value="<?= h($search) ?>" placeholder="Search by resident name, ID, or message..." class="rounded-xl border border-slate-300 px-4 py-2 text-sm">

        <select name="priority" class="rounded-xl border border-slate-300 px-4 py-2 text-sm" onchange="this.form.submit()">
            <option value="all" <?= $priorityFilter === 'all' ? 'selected' : '' ?>>All Priorities</option>
            <option value="Critical" <?= $priorityFilter === 'Critical' ? 'selected' : '' ?>>Critical</option>
            <option value="High" <?= $priorityFilter === 'High' ? 'selected' : '' ?>>High</option>
            <option value="Medium" <?= $priorityFilter === 'Medium' ? 'selected' : '' ?>>Medium</option>
            <option value="Low" <?= $priorityFilter === 'Low' ? 'selected' : '' ?>>Low</option>
        </select>

        <select name="status" class="rounded-xl border border-slate-300 px-4 py-2 text-sm" onchange="this.form.submit()">
            <option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>All Status</option>
            <option value="Pending" <?= $statusFilter === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Scheduled" <?= $statusFilter === 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
            <option value="Upcoming" <?= $statusFilter === 'Upcoming' ? 'selected' : '' ?>>Upcoming</option>
        </select>

        <label class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2 text-sm">
            <input type="checkbox" name="completed" value="1" <?= $showCompleted ? 'checked' : '' ?> onchange="this.form.submit()">
            <span>Show Completed</span>
        </label>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Done</th>
                        <th class="px-4 py-3 text-left">Alert ID</th>
                        <th class="px-4 py-3 text-left">Resident</th>
                        <?php if ($isHead): ?><th class="px-4 py-3 text-left">Assigned To</th><?php endif; ?>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Priority</th>
                        <th class="px-4 py-3 text-left">Message</th>
                        <th class="px-4 py-3 text-left">Due Date</th>
                        <th class="px-4 py-3 text-left">Alert Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($filtered)): ?>
                    <tr><td colspan="<?= $isHead ? 9 : 8 ?>" class="px-4 py-10 text-center text-slate-400">No alerts found.</td></tr>
                    <?php else: ?>
                    <?php foreach ($filtered as $alert): ?>
                    <?php
                        $isDone = $alert['isCompleted'];
                        $alertStatusClass = $isDone ? 'status-completed' : $alert['statusClass'];
                        $alertStatusLabel = $isDone ? 'Completed' : $alert['status'];
                    ?>
                    <tr class="border-t border-slate-100 <?= $isDone ? 'completed-row' : '' ?>">
                        <td class="px-4 py-3">
                            <?php if ($isBHW || $isBNS): ?>
                            <form method="POST" action="layout.php?page=alerts" class="inline">
                                <input type="hidden" name="toggle_id" value="<?= h($alert['id']) ?>">
                                <input type="hidden" name="search" value="<?= h($search) ?>">
                                <input type="hidden" name="priority" value="<?= h($priorityFilter) ?>">
                                <input type="hidden" name="status" value="<?= h($statusFilter) ?>">
                                <input type="hidden" name="completed" value="<?= $showCompleted ? '1' : '' ?>">
                                <button type="submit" class="h-5 w-5 rounded border border-slate-300 text-xs font-bold <?= $isDone ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-transparent' ?>">✓</button>
                            </form>
                            <?php else: ?>
                            <span class="text-slate-400"><?= $isDone ? 'Done' : '-' ?></span>
                            <?php endif; ?>
                        </td>

                        <td class="px-4 py-3 font-semibold text-slate-700"><?= h($alert['id']) ?></td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-800"><?= h($alert['residentName']) ?></div>
                            <div class="res-sub"><?= h($alert['residentId']) ?> • <?= h($alert['purok']) ?></div>
                        </td>

                        <?php if ($isHead): ?>
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-700"><?= h($alert['assignedTo']) ?></div>
                            <div class="text-xs text-slate-500"><?= h($alert['assignedRole']) ?></div>
                        </td>
                        <?php endif; ?>

                        <td class="px-4 py-3 font-medium text-slate-700"><?= h($alert['type']) ?></td>
                        <td class="px-4 py-3"><span class="badge <?= h($alert['priorityClass']) ?>"><?= h($alert['priority']) ?></span></td>
                        <td class="px-4 py-3 text-slate-600" style="max-width: 260px; line-height: 1.4;"><?= h($alert['message']) ?></td>
                        <td class="px-4 py-3 font-medium text-slate-700 whitespace-nowrap"><?= h($alert['dueDate']) ?></td>
                        <td class="px-4 py-3"><span class="badge <?= h($alertStatusClass) ?>"><?= h($alertStatusLabel) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
            Showing <?= count($filtered) ?> of <?= count($scopedAlerts) ?> alerts<?= $isHead ? '' : ' for ' . h($userPurok) ?>
        </div>
    </div>
</div>
