<?php
// Redirect direct access so shared layout/sidebar/css are used.
if (basename((string) ($_SERVER['SCRIPT_NAME'] ?? '')) === 'alerts.php' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
	$redirectParams = $_GET;
	$redirectParams['page'] = 'alerts';
	header('Location: ../../layout.php?' . http_build_query($redirectParams));
	exit;
}

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

if (!isset($_SESSION['user_id']) && !isset($_SESSION['user'])) {
	header('Location: ../../pages/sign_in.php');
	exit;
}

if (!function_exists('esc')) {
	function esc(string $value): string
	{
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
}

$currentUser = [
	'name' => (string) ($_SESSION['name'] ?? 'Head User'),
	'role' => strtolower((string) ($_SESSION['role'] ?? 'hc_head')),
];

$isHead = in_array($currentUser['role'], ['head', 'hc_head', 'health_center_head'], true);
$isBHW = $currentUser['role'] === 'bhw';
$isBNS = $currentUser['role'] === 'bns';

$userAssignments = [
	'Ana Torres' => 'Purok 1',
	'Maria Santos' => 'Purok 2',
	'Rosa Mendoza' => 'Purok 3',
	'Carmen Lopez' => 'Purok 4',
];
$userPurok = $userAssignments[$currentUser['name']] ?? '';

$alertsData = [
	['id' => 'A-001', 'residentId' => 'R-004', 'residentName' => 'Maria Garcia', 'type' => 'High Risk - Malnutrition', 'category' => 'Malnutrition', 'priority' => 'Critical', 'priorityClass' => 'priority-critical', 'message' => 'Severe wasted condition detected - immediate intervention required', 'dueDate' => '2026-03-16', 'status' => 'Pending', 'purok' => 'Purok 3', 'assignedTo' => 'Rosa Mendoza', 'assignedRole' => 'BNS', 'isCompleted' => false],
	['id' => 'A-009', 'residentId' => 'R-012', 'residentName' => 'Sofia Isabel Bautista', 'type' => 'Vaccination Due - Pentavalent 2', 'category' => 'Vaccination', 'priority' => 'High', 'priorityClass' => 'priority-high-purple', 'message' => 'Pentavalent 2nd dose due (10 weeks schedule) - Baby is now 14 months old', 'dueDate' => '2026-03-20', 'status' => 'Pending', 'purok' => 'Purok 3', 'assignedTo' => 'Rosa Mendoza', 'assignedRole' => 'BNS', 'isCompleted' => false],
	['id' => 'A-010', 'residentId' => 'R-013', 'residentName' => 'Pedro Jr. Reyes', 'type' => 'Vaccination Due - MMR 1', 'category' => 'Vaccination', 'priority' => 'High', 'priorityClass' => 'priority-high-purple', 'message' => 'Measles-Mumps-Rubella 1st dose due at 9 months - Child is now 33 months', 'dueDate' => '2026-03-22', 'status' => 'Pending', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => false],
	['id' => 'A-015', 'residentId' => 'R-014', 'residentName' => 'Ana Marie Santos', 'type' => 'Vaccination Complete - Annual Checkup', 'category' => 'Vaccination', 'priority' => 'Low', 'priorityClass' => 'priority-low', 'message' => 'Fully immunized - Annual health checkup recommended', 'dueDate' => '2026-04-15', 'status' => 'Upcoming', 'purok' => 'Purok 2', 'assignedTo' => 'Maria Santos', 'assignedRole' => 'BHW', 'isCompleted' => false],
	['id' => 'A-011', 'residentId' => 'R-006', 'residentName' => 'Maricon Olivar Capacia', 'type' => 'Prenatal Visit - 35-36 weeks', 'category' => 'Maternal Health', 'priority' => 'High', 'priorityClass' => 'priority-high-pink', 'message' => 'Prenatal check-up due for 35-36 weeks pregnancy milestone', 'dueDate' => '2026-03-25', 'status' => 'Scheduled', 'purok' => 'Purok 2', 'assignedTo' => 'Rosa Mendoza', 'assignedRole' => 'BNS', 'isCompleted' => false],
	['id' => 'A-012', 'residentId' => 'R-007', 'residentName' => 'Elena Vega Hernandez', 'type' => 'Prenatal Visit - 27-30 weeks', 'category' => 'Maternal Health', 'priority' => 'High', 'priorityClass' => 'priority-high-pink', 'message' => 'High-risk pregnancy - Prenatal check-up overdue', 'dueDate' => '2026-03-18', 'status' => 'Pending', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => false],
	['id' => 'A-002', 'residentId' => 'R-003', 'residentName' => 'Pedro Reyes', 'type' => 'Follow-up - Stunted Child', 'category' => 'Nutrition Follow-up', 'priority' => 'High', 'priorityClass' => 'priority-high-orange', 'message' => 'Monthly follow-up assessment due for stunted child in feeding program', 'dueDate' => '2026-03-18', 'status' => 'Pending', 'purok' => 'Purok 2', 'assignedTo' => 'Maria Santos', 'assignedRole' => 'BHW', 'isCompleted' => false],
	['id' => 'A-003', 'residentId' => 'R-002', 'residentName' => 'Ana Santos', 'type' => 'Monitoring - Feeding Program', 'category' => 'Nutrition Follow-up', 'priority' => 'Medium', 'priorityClass' => 'priority-medium', 'message' => 'Progress check on supplementary feeding program - Weight monitoring', 'dueDate' => '2026-03-20', 'status' => 'Pending', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => true],
	['id' => 'A-005', 'residentId' => 'R-008', 'residentName' => 'Isabella Cruz', 'type' => 'Follow-up - Weight Monitoring', 'category' => 'Nutrition Follow-up', 'priority' => 'High', 'priorityClass' => 'priority-high-orange', 'message' => 'Bi-weekly weight monitoring due for underweight child', 'dueDate' => '2026-03-17', 'status' => 'Pending', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => false],
	['id' => 'A-004', 'residentId' => 'R-006', 'residentName' => 'Sofia Villanueva', 'type' => 'Consultation - Nutrition Counseling', 'category' => 'Consultation', 'priority' => 'Medium', 'priorityClass' => 'priority-medium', 'message' => 'Nutrition counseling session scheduled for mother', 'dueDate' => '2026-03-22', 'status' => 'Scheduled', 'purok' => 'Purok 4', 'assignedTo' => 'Carmen Lopez', 'assignedRole' => 'BNS', 'isCompleted' => false],
	['id' => 'A-006', 'residentId' => 'R-001', 'residentName' => 'Juan Dela Cruz Jr.', 'type' => 'Routine Check - Quarterly', 'category' => 'Routine', 'priority' => 'Low', 'priorityClass' => 'priority-low', 'message' => 'Quarterly nutritional assessment reminder', 'dueDate' => '2026-04-01', 'status' => 'Upcoming', 'purok' => 'Purok 1', 'assignedTo' => 'Ana Torres', 'assignedRole' => 'BHW', 'isCompleted' => false],
	['id' => 'A-008', 'residentId' => 'R-005', 'residentName' => 'Carlos Mendoza', 'type' => 'Routine Check - Health Screening', 'category' => 'Routine', 'priority' => 'Low', 'priorityClass' => 'priority-low', 'message' => 'Regular health screening due for normal-status child', 'dueDate' => '2026-04-10', 'status' => 'Upcoming', 'purok' => 'Purok 2', 'assignedTo' => 'Maria Santos', 'assignedRole' => 'BHW', 'isCompleted' => false],
	['id' => 'A-013', 'residentId' => 'R-009', 'residentName' => 'Miguel Santos', 'type' => 'BMI Recalculation Due', 'category' => 'Health Assessment', 'priority' => 'Medium', 'priorityClass' => 'priority-medium', 'message' => '3-month BMI reassessment due - Tracking obesity risk', 'dueDate' => '2026-03-28', 'status' => 'Upcoming', 'purok' => 'Purok 3', 'assignedTo' => 'Rosa Mendoza', 'assignedRole' => 'BNS', 'isCompleted' => false],
	['id' => 'A-014', 'residentId' => 'R-010', 'residentName' => 'Carmen Bautista', 'type' => 'Vitamin A Supplementation', 'category' => 'Supplementation', 'priority' => 'Medium', 'priorityClass' => 'priority-medium', 'message' => '6-month Vitamin A dose due for child aged 24 months', 'dueDate' => '2026-03-30', 'status' => 'Upcoming', 'purok' => 'Purok 2', 'assignedTo' => 'Maria Santos', 'assignedRole' => 'BHW', 'isCompleted' => false],
];

$searchTerm = trim((string) ($_GET['search'] ?? ''));
$priorityFilter = (string) ($_GET['priority'] ?? 'all');
$statusFilter = (string) ($_GET['status'] ?? 'all');
$showCompleted = (string) ($_GET['completed'] ?? '') === '1';

$roleFilteredAlerts = array_values(array_filter($alertsData, static function (array $alert) use ($isHead, $isBHW, $isBNS, $userPurok): bool {
	if ($isHead) {
		return true;
	}
	if (($isBHW || $isBNS) && $userPurok !== '') {
		return $alert['purok'] === $userPurok;
	}
	return true;
}));

$filteredAlerts = array_values(array_filter($roleFilteredAlerts, static function (array $alert) use ($searchTerm, $priorityFilter, $statusFilter, $showCompleted): bool {
	$search = strtolower($searchTerm);
	$matchesSearch = $search === ''
		|| strpos(strtolower((string) $alert['residentName']), $search) !== false
		|| strpos(strtolower((string) $alert['residentId']), $search) !== false
		|| strpos(strtolower((string) $alert['message']), $search) !== false;

	$matchesPriority = $priorityFilter === 'all' || $alert['priority'] === $priorityFilter;
	$matchesStatus = $statusFilter === 'all' || $alert['status'] === $statusFilter;
	$matchesCompleted = $showCompleted ? true : !(bool) $alert['isCompleted'];

	return $matchesSearch && $matchesPriority && $matchesStatus && $matchesCompleted;
}));

$pendingCount = count(array_filter($roleFilteredAlerts, static fn(array $a): bool => $a['status'] === 'Pending' && !(bool) $a['isCompleted']));
$scheduledCount = count(array_filter($roleFilteredAlerts, static fn(array $a): bool => $a['status'] === 'Scheduled' && !(bool) $a['isCompleted']));
$upcomingCount = count(array_filter($roleFilteredAlerts, static fn(array $a): bool => $a['status'] === 'Upcoming' && !(bool) $a['isCompleted']));
$completedCount = count(array_filter($roleFilteredAlerts, static fn(array $a): bool => (bool) $a['isCompleted']));

$queryBase = 'layout.php?page=alerts';
?>

<style>
.alerts-head-page { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: calc(100vh - 2rem); padding: 24px; }
.alerts-head-page .hero { background: linear-gradient(135deg, #06b6d4, #0d9488); color: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 16px 35px rgba(13, 148, 136, 0.25); }
.alerts-head-page .hero h1 { margin: 0 0 6px; font-size: 30px; }
.alerts-head-page .hero p { margin: 0; font-size: 13px; opacity: 0.9; }

.alerts-head-page .cards { margin-top: 18px; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
.alerts-head-page .card { background: #fff; border-radius: 16px; box-shadow: 0 6px 24px rgba(15, 23, 42, 0.08); padding: 18px; border-left: 4px solid; }
.alerts-head-page .card.pending { border-left-color: #ef4444; }
.alerts-head-page .card.scheduled { border-left-color: #3b82f6; }
.alerts-head-page .card.upcoming { border-left-color: #22c55e; }
.alerts-head-page .card.completed { border-left-color: #6b7280; }
.alerts-head-page .card-label { color: #64748b; font-size: 13px; font-weight: 600; margin-bottom: 4px; }
.alerts-head-page .card-value { font-size: 38px; font-weight: 700; line-height: 1; color: #0f172a; }
.alerts-head-page .card-sub { font-size: 11px; margin-top: 5px; font-weight: 600; }

.alerts-head-page .filters { margin-top: 16px; display: grid; grid-template-columns: 1.4fr 0.7fr 0.7fr auto; gap: 12px; align-items: center; }
.alerts-head-page .field,
.alerts-head-page .select,
.alerts-head-page .check-wrap { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; height: 46px; padding: 0 12px; box-shadow: 0 3px 10px rgba(15, 23, 42, 0.06); }
.alerts-head-page .field,
.alerts-head-page .select { width: 100%; }
.alerts-head-page .check-wrap { display: inline-flex; align-items: center; gap: 8px; }
.alerts-head-page .apply-btn { height: 46px; border: 0; border-radius: 12px; padding: 0 14px; color: #fff; font-weight: 600; background: linear-gradient(135deg, #06b6d4, #0d9488); cursor: pointer; }

.alerts-head-page .table-wrap { margin-top: 16px; background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 6px 24px rgba(15, 23, 42, 0.08); overflow: hidden; }
.alerts-head-page .table-scroll { overflow-x: auto; }
.alerts-head-page table { width: 100%; min-width: 1080px; border-collapse: collapse; }
.alerts-head-page th { text-align: left; padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; background: linear-gradient(90deg, #f8fafc, #f1f5f9); border-bottom: 1px solid #e2e8f0; }
.alerts-head-page td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: top; font-size: 13px; color: #334155; }
.alerts-head-page .completed-row { opacity: 0.6; }

.alerts-head-page .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
.alerts-head-page .priority-critical { background: #fee2e2; color: #b91c1c; }
.alerts-head-page .priority-high-orange { background: #ffedd5; color: #c2410c; }
.alerts-head-page .priority-high-purple { background: #f3e8ff; color: #7e22ce; }
.alerts-head-page .priority-high-pink { background: #fce7f3; color: #be185d; }
.alerts-head-page .priority-medium { background: #fef9c3; color: #a16207; }
.alerts-head-page .priority-low { background: #dbeafe; color: #1d4ed8; }

.alerts-head-page .status-pending { background: #fee2e2; color: #b91c1c; }
.alerts-head-page .status-scheduled { background: #dbeafe; color: #1d4ed8; }
.alerts-head-page .status-upcoming { background: #dcfce7; color: #15803d; }
.alerts-head-page .status-completed { background: #f1f5f9; color: #475569; }

.alerts-head-page .res-main { font-weight: 600; color: #0f172a; }
.alerts-head-page .res-sub { font-size: 11px; color: #94a3b8; margin-top: 2px; }
.alerts-head-page .footer { padding: 12px 14px; font-size: 13px; color: #64748b; background: #f8fafc; }

@media (max-width: 1200px) {
	.alerts-head-page .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
	.alerts-head-page .filters { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
	.alerts-head-page .cards { grid-template-columns: 1fr; }
	.alerts-head-page .filters { grid-template-columns: 1fr; }
}
</style>

<div class="alerts-head-page">
	<div class="hero">
		<h1>Alerts &amp; Reminders</h1>
		<p>
			<?= $isHead
				? 'Track all follow-ups, notifications, and risk-based alerts across all puroks'
				: 'Track your assigned alerts for ' . esc($userPurok !== '' ? $userPurok : 'your area') ?>
		</p>
	</div>

	<div class="cards">
		<div class="card pending">
			<div class="card-label">Pending</div>
			<div class="card-value"><?= $pendingCount ?></div>
			<div class="card-sub" style="color:#dc2626;">Requires immediate attention</div>
		</div>
		<div class="card scheduled">
			<div class="card-label">Scheduled</div>
			<div class="card-value"><?= $scheduledCount ?></div>
			<div class="card-sub" style="color:#2563eb;">Appointments set</div>
		</div>
		<div class="card upcoming">
			<div class="card-label">Upcoming</div>
			<div class="card-value"><?= $upcomingCount ?></div>
			<div class="card-sub" style="color:#16a34a;">Future reminders</div>
		</div>
		<div class="card completed">
			<div class="card-label">Completed</div>
			<div class="card-value"><?= $completedCount ?></div>
			<div class="card-sub" style="color:#4b5563;">Actions done</div>
		</div>
	</div>

	<form method="get" action="layout.php" class="filters">
		<input type="hidden" name="page" value="alerts">
		<input class="field" type="text" name="search" value="<?= esc($searchTerm) ?>" placeholder="Search by resident name, ID, or message...">

		<select class="select" name="priority">
			<option value="all" <?= $priorityFilter === 'all' ? 'selected' : '' ?>>All Priorities</option>
			<option value="Critical" <?= $priorityFilter === 'Critical' ? 'selected' : '' ?>>Critical</option>
			<option value="High" <?= $priorityFilter === 'High' ? 'selected' : '' ?>>High</option>
			<option value="Medium" <?= $priorityFilter === 'Medium' ? 'selected' : '' ?>>Medium</option>
			<option value="Low" <?= $priorityFilter === 'Low' ? 'selected' : '' ?>>Low</option>
		</select>

		<select class="select" name="status">
			<option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>All Status</option>
			<option value="Pending" <?= $statusFilter === 'Pending' ? 'selected' : '' ?>>Pending</option>
			<option value="Scheduled" <?= $statusFilter === 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
			<option value="Upcoming" <?= $statusFilter === 'Upcoming' ? 'selected' : '' ?>>Upcoming</option>
		</select>

		<label class="check-wrap">
			<input type="checkbox" name="completed" value="1" <?= $showCompleted ? 'checked' : '' ?>>
			<span style="font-size:13px;font-weight:600;color:#334155;">Show Completed</span>
		</label>

		<button class="apply-btn" type="submit">Apply Filters</button>
	</form>

	<div class="table-wrap">
		<div class="table-scroll">
			<table>
				<thead>
					<tr>
						<th>Status</th>
						<th>Alert ID</th>
						<th>Resident</th>
						<?php if ($isHead): ?>
							<th>Assigned To</th>
						<?php endif; ?>
						<th>Type</th>
						<th>Priority</th>
						<th>Message</th>
						<th>Due Date</th>
						<th>Alert Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($filteredAlerts)): ?>
						<tr>
							<td colspan="<?= $isHead ? 9 : 8 ?>" style="text-align:center;color:#94a3b8;padding:30px;">No alerts found.</td>
						</tr>
					<?php else: ?>
						<?php foreach ($filteredAlerts as $alert): ?>
							<?php
							$isCompleted = (bool) $alert['isCompleted'];
							$statusClass = $isCompleted
								? 'status-completed'
								: ($alert['status'] === 'Pending'
									? 'status-pending'
									: ($alert['status'] === 'Scheduled' ? 'status-scheduled' : 'status-upcoming'));
							$statusLabel = $isCompleted ? 'Completed' : $alert['status'];
							?>
							<tr class="<?= $isCompleted ? 'completed-row' : '' ?>">
								<td>
									<?php if ($isHead): ?>
										<?php if ($isCompleted): ?>
											<span class="badge status-completed">Completed</span>
										<?php else: ?>
											<span class="badge <?= esc($alert['priorityClass']) ?>"><?= esc($alert['priority']) ?></span>
										<?php endif; ?>
									<?php else: ?>
										<?= $isCompleted ? 'Done' : '-' ?>
									<?php endif; ?>
								</td>
								<td style="font-weight:600;color:#475569;"><?= esc($alert['id']) ?></td>
								<td>
									<div class="res-main"><?= esc($alert['residentName']) ?></div>
									<div class="res-sub"><?= esc($alert['residentId']) ?> • <?= esc($alert['purok']) ?></div>
								</td>
								<?php if ($isHead): ?>
									<td>
										<div style="font-weight:600;"><?= esc($alert['assignedTo']) ?></div>
										<div class="res-sub"><?= esc($alert['assignedRole']) ?></div>
									</td>
								<?php endif; ?>
								<td style="font-weight:600;"><?= esc($alert['type']) ?></td>
								<td><span class="badge <?= esc($alert['priorityClass']) ?>"><?= esc($alert['priority']) ?></span></td>
								<td style="max-width:290px;line-height:1.45;"><?= esc($alert['message']) ?></td>
								<td style="font-weight:600;white-space:nowrap;"><?= esc($alert['dueDate']) ?></td>
								<td><span class="badge <?= esc($statusClass) ?>"><?= esc($statusLabel) ?></span></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>

		<div class="footer">
			Showing <?= count($filteredAlerts) ?> of <?= count($roleFilteredAlerts) ?> alerts<?= $isHead ? '' : ' for ' . esc($userPurok) ?>
		</div>
	</div>
</div>
