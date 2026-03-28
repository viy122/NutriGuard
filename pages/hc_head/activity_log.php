<?php
// Redirect direct access so shared layout/sidebar/css are used.
if (basename((string) ($_SERVER['SCRIPT_NAME'] ?? '')) === 'activity_log.php' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
	$redirectParams = $_GET;
	$redirectParams['page'] = 'activity_log';
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

$role = strtolower((string) ($_SESSION['role'] ?? ''));
$isHead = in_array($role, ['head', 'hc_head', 'health_center_head'], true);

if (!$isHead) {
	echo '<div style="padding:16px;border:1px solid #e2e8f0;border-radius:12px;background:#fff;">';
	echo '<h2 style="margin:0 0 8px;color:#0f172a;">Unauthorized</h2>';
	echo '<p style="margin:0;color:#64748b;">Activity Log is available for head user only.</p>';
	echo '</div>';
	return;
}

$activityLogs = [
	['id' => 'LOG-001', 'timestamp' => '2026-03-15 14:32:15', 'user' => 'BNS Maria Cruz', 'userRole' => 'Barangay Nutrition Scholar', 'action' => 'Created Assessment', 'details' => 'New nutritional assessment for Juan Dela Cruz Jr. (R-001)', 'ipAddress' => '192.168.1.45', 'status' => 'Success'],
	['id' => 'LOG-002', 'timestamp' => '2026-03-15 13:15:42', 'user' => 'Admin Pedro Santos', 'userRole' => 'System Administrator', 'action' => 'Updated User', 'details' => 'Modified permissions for BHW Linda Reyes', 'ipAddress' => '192.168.1.10', 'status' => 'Success'],
	['id' => 'LOG-003', 'timestamp' => '2026-03-15 11:05:23', 'user' => 'BHW Linda Reyes', 'userRole' => 'Barangay Health Worker', 'action' => 'Edited Resident', 'details' => 'Updated contact information for Ana Santos (R-002)', 'ipAddress' => '192.168.1.52', 'status' => 'Success'],
	['id' => 'LOG-004', 'timestamp' => '2026-03-15 10:22:18', 'user' => 'BNS Maria Cruz', 'userRole' => 'Barangay Nutrition Scholar', 'action' => 'Generated Report', 'details' => 'Created OPT+ Report for Purok 1, Q1 2026', 'ipAddress' => '192.168.1.45', 'status' => 'Success'],
	['id' => 'LOG-005', 'timestamp' => '2026-03-15 09:45:33', 'user' => 'BHW Linda Reyes', 'userRole' => 'Barangay Health Worker', 'action' => 'Login', 'details' => 'User logged into system', 'ipAddress' => '192.168.1.52', 'status' => 'Success'],
	['id' => 'LOG-006', 'timestamp' => '2026-03-15 09:12:55', 'user' => 'BNS Maria Cruz', 'userRole' => 'Barangay Nutrition Scholar', 'action' => 'Deleted Assessment', 'details' => 'Removed duplicate assessment entry for Pedro Reyes (R-003)', 'ipAddress' => '192.168.1.45', 'status' => 'Success'],
	['id' => 'LOG-007', 'timestamp' => '2026-03-14 16:48:11', 'user' => 'Admin Pedro Santos', 'userRole' => 'System Administrator', 'action' => 'Created User', 'details' => 'Added new BHW account: Rosa Martinez', 'ipAddress' => '192.168.1.10', 'status' => 'Success'],
	['id' => 'LOG-008', 'timestamp' => '2026-03-14 15:33:27', 'user' => 'BHW Linda Reyes', 'userRole' => 'Barangay Health Worker', 'action' => 'Failed Login', 'details' => 'Invalid password attempt', 'ipAddress' => '192.168.1.52', 'status' => 'Failed'],
	['id' => 'LOG-009', 'timestamp' => '2026-03-14 14:21:09', 'user' => 'BNS Maria Cruz', 'userRole' => 'Barangay Nutrition Scholar', 'action' => 'Exported Data', 'details' => 'Downloaded resident data CSV for Purok 1-5', 'ipAddress' => '192.168.1.45', 'status' => 'Success'],
	['id' => 'LOG-010', 'timestamp' => '2026-03-14 13:05:44', 'user' => 'BHW Linda Reyes', 'userRole' => 'Barangay Health Worker', 'action' => 'Created Resident', 'details' => 'Added new resident profile: Carlos Mendoza (R-005)', 'ipAddress' => '192.168.1.52', 'status' => 'Success'],
	['id' => 'LOG-011', 'timestamp' => '2026-03-14 11:42:31', 'user' => 'BNS Maria Cruz', 'userRole' => 'Barangay Nutrition Scholar', 'action' => 'Updated Settings', 'details' => 'Modified alert notification preferences', 'ipAddress' => '192.168.1.45', 'status' => 'Success'],
	['id' => 'LOG-012', 'timestamp' => '2026-03-14 10:15:18', 'user' => 'Admin Pedro Santos', 'userRole' => 'System Administrator', 'action' => 'System Backup', 'details' => 'Initiated automated database backup', 'ipAddress' => '192.168.1.10', 'status' => 'Success'],
];

$searchTerm = trim((string) ($_GET['search'] ?? ''));
$userFilter = (string) ($_GET['user'] ?? 'all');
$actionFilter = (string) ($_GET['action'] ?? 'all');
$dateFilter = (string) ($_GET['date'] ?? 'all');
$export = (string) ($_GET['export'] ?? '') === '1';

$uniqueUsers = array_values(array_unique(array_map(static fn(array $log): string => (string) $log['user'], $activityLogs)));
sort($uniqueUsers);

$uniqueActions = array_values(array_unique(array_map(static fn(array $log): string => (string) $log['action'], $activityLogs)));
sort($uniqueActions);

$filteredLogs = array_values(array_filter($activityLogs, static function (array $log) use ($searchTerm, $userFilter, $actionFilter, $dateFilter): bool {
	$search = strtolower($searchTerm);
	$matchesSearch = $search === ''
		|| strpos(strtolower((string) $log['user']), $search) !== false
		|| strpos(strtolower((string) $log['action']), $search) !== false
		|| strpos(strtolower((string) $log['details']), $search) !== false;

	$matchesUser = $userFilter === 'all' || $log['user'] === $userFilter;
	$matchesAction = $actionFilter === 'all' || $log['action'] === $actionFilter;
	$matchesDate = $dateFilter === 'all' || str_starts_with((string) $log['timestamp'], $dateFilter);

	return $matchesSearch && $matchesUser && $matchesAction && $matchesDate;
}));

if ($export) {
	$filename = 'activity_logs_' . date('Ymd_His') . '.csv';
	header('Content-Type: text/csv; charset=UTF-8');
	header('Content-Disposition: attachment; filename="' . $filename . '"');

	$output = fopen('php://output', 'w');
	if ($output !== false) {
		fputcsv($output, ['Log ID', 'Timestamp', 'User', 'User Role', 'Action', 'Details', 'IP Address', 'Status']);
		foreach ($filteredLogs as $log) {
			fputcsv($output, [
				$log['id'],
				$log['timestamp'],
				$log['user'],
				$log['userRole'],
				$log['action'],
				$log['details'],
				$log['ipAddress'],
				$log['status'],
			]);
		}
		fclose($output);
	}
	exit;
}

$todayCount = count(array_filter($activityLogs, static fn(array $log): bool => str_starts_with((string) $log['timestamp'], '2026-03-15')));
$failedCount = count(array_filter($activityLogs, static fn(array $log): bool => $log['status'] === 'Failed'));

$baseExportQuery = [
	'page' => 'activity_log',
	'search' => $searchTerm,
	'user' => $userFilter,
	'action' => $actionFilter,
	'date' => $dateFilter,
	'export' => '1',
];
?>

<style>
.activity-log-head-page { background: linear-gradient(135deg, #f8fafc, #f1f5f9); min-height: calc(100vh - 2rem); padding: 24px; }
.activity-log-head-page .hero { background: linear-gradient(135deg, #06b6d4, #0d9488); color: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 16px 35px rgba(13, 148, 136, 0.25); }
.activity-log-head-page .hero-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
.activity-log-head-page .hero h1 { margin: 0 0 6px; font-size: 30px; }
.activity-log-head-page .hero p { margin: 0; font-size: 13px; opacity: 0.9; }
.activity-log-head-page .export-btn { text-decoration: none; background: #fff; color: #0891b2; border: 0; border-radius: 10px; padding: 9px 14px; font-size: 13px; font-weight: 700; box-shadow: 0 8px 18px rgba(2, 132, 199, 0.2); }

.activity-log-head-page .stats { margin-top: 18px; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
.activity-log-head-page .stat { background: #fff; border-radius: 16px; box-shadow: 0 6px 24px rgba(15, 23, 42, 0.08); padding: 18px; border-left: 4px solid; }
.activity-log-head-page .stat.total { border-left-color: #3b82f6; }
.activity-log-head-page .stat.today { border-left-color: #22c55e; }
.activity-log-head-page .stat.users { border-left-color: #a855f7; }
.activity-log-head-page .stat.failed { border-left-color: #ef4444; }
.activity-log-head-page .stat-label { color: #64748b; font-size: 13px; font-weight: 600; margin-bottom: 4px; }
.activity-log-head-page .stat-value { font-size: 38px; font-weight: 700; line-height: 1; color: #0f172a; }
.activity-log-head-page .stat-sub { font-size: 11px; margin-top: 5px; font-weight: 600; }

.activity-log-head-page .filters { margin-top: 16px; display: grid; grid-template-columns: 1.4fr 0.8fr 0.8fr 0.8fr auto; gap: 12px; align-items: center; }
.activity-log-head-page .field,
.activity-log-head-page .select { width: 100%; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; height: 46px; padding: 0 12px; box-shadow: 0 3px 10px rgba(15, 23, 42, 0.06); }
.activity-log-head-page .apply-btn { height: 46px; border: 0; border-radius: 12px; padding: 0 14px; color: #fff; font-weight: 600; background: linear-gradient(135deg, #06b6d4, #0d9488); cursor: pointer; }

.activity-log-head-page .table-wrap { margin-top: 16px; background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 6px 24px rgba(15, 23, 42, 0.08); overflow: hidden; }
.activity-log-head-page .table-scroll { overflow-x: auto; }
.activity-log-head-page table { width: 100%; min-width: 980px; border-collapse: collapse; }
.activity-log-head-page th { text-align: left; padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; background: linear-gradient(90deg, #f8fafc, #f1f5f9); border-bottom: 1px solid #e2e8f0; }
.activity-log-head-page td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: top; font-size: 13px; color: #334155; }
.activity-log-head-page .role-sub { font-size: 11px; color: #94a3b8; margin-top: 2px; }
.activity-log-head-page .ip { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; }
.activity-log-head-page .status-badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; }
.activity-log-head-page .status-success { background: #dcfce7; color: #15803d; }
.activity-log-head-page .status-failed { background: #fee2e2; color: #b91c1c; }
.activity-log-head-page .footer { padding: 12px 14px; font-size: 13px; color: #64748b; background: #f8fafc; }

@media (max-width: 1200px) {
	.activity-log-head-page .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
	.activity-log-head-page .filters { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
	.activity-log-head-page .stats { grid-template-columns: 1fr; }
	.activity-log-head-page .filters { grid-template-columns: 1fr; }
	.activity-log-head-page .hero-top { flex-direction: column; }
}
</style>

<div class="activity-log-head-page">
	<div class="hero">
		<div class="hero-top">
			<div>
				<h1>Activity Log</h1>
				<p>Track user actions and system events for audit purposes</p>
			</div>
			<a class="export-btn" href="layout.php?<?= esc(http_build_query($baseExportQuery)) ?>">Export Logs</a>
		</div>
	</div>

	<div class="stats">
		<div class="stat total">
			<div class="stat-label">Total Actions</div>
			<div class="stat-value"><?= count($activityLogs) ?></div>
			<div class="stat-sub" style="color:#64748b;">All time</div>
		</div>
		<div class="stat today">
			<div class="stat-label">Today</div>
			<div class="stat-value"><?= $todayCount ?></div>
			<div class="stat-sub" style="color:#16a34a;">Active day</div>
		</div>
		<div class="stat users">
			<div class="stat-label">Active Users</div>
			<div class="stat-value"><?= count($uniqueUsers) ?></div>
			<div class="stat-sub" style="color:#64748b;">Current period</div>
		</div>
		<div class="stat failed">
			<div class="stat-label">Failed Actions</div>
			<div class="stat-value"><?= $failedCount ?></div>
			<div class="stat-sub" style="color:#dc2626;">Requires attention</div>
		</div>
	</div>

	<form method="get" action="layout.php" class="filters">
		<input type="hidden" name="page" value="activity_log">

		<input class="field" type="text" name="search" value="<?= esc($searchTerm) ?>" placeholder="Search by user, action, or details...">

		<select class="select" name="user">
			<option value="all" <?= $userFilter === 'all' ? 'selected' : '' ?>>All Users</option>
			<?php foreach ($uniqueUsers as $user): ?>
				<option value="<?= esc($user) ?>" <?= $userFilter === $user ? 'selected' : '' ?>><?= esc($user) ?></option>
			<?php endforeach; ?>
		</select>

		<select class="select" name="action">
			<option value="all" <?= $actionFilter === 'all' ? 'selected' : '' ?>>All Actions</option>
			<?php foreach ($uniqueActions as $action): ?>
				<option value="<?= esc($action) ?>" <?= $actionFilter === $action ? 'selected' : '' ?>><?= esc($action) ?></option>
			<?php endforeach; ?>
		</select>

		<select class="select" name="date">
			<option value="all" <?= $dateFilter === 'all' ? 'selected' : '' ?>>All Dates</option>
			<option value="2026-03-15" <?= $dateFilter === '2026-03-15' ? 'selected' : '' ?>>Today (Mar 15)</option>
			<option value="2026-03-14" <?= $dateFilter === '2026-03-14' ? 'selected' : '' ?>>Yesterday (Mar 14)</option>
		</select>

		<button class="apply-btn" type="submit">Apply Filters</button>
	</form>

	<div class="table-wrap">
		<div class="table-scroll">
			<table>
				<thead>
					<tr>
						<th>Timestamp</th>
						<th>User</th>
						<th>Action</th>
						<th>Details</th>
						<th>IP Address</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($filteredLogs)): ?>
						<tr>
							<td colspan="6" style="text-align:center;color:#94a3b8;padding:30px;">No activity logs found.</td>
						</tr>
					<?php else: ?>
						<?php foreach ($filteredLogs as $log): ?>
							<tr>
								<td style="font-weight:600;color:#475569;"><?= esc($log['timestamp']) ?></td>
								<td>
									<div style="font-weight:600;color:#0f172a;"><?= esc($log['user']) ?></div>
									<div class="role-sub"><?= esc($log['userRole']) ?></div>
								</td>
								<td style="font-weight:600;"><?= esc($log['action']) ?></td>
								<td style="max-width:360px;line-height:1.45;"><?= esc($log['details']) ?></td>
								<td class="ip"><?= esc($log['ipAddress']) ?></td>
								<td>
									<span class="status-badge <?= $log['status'] === 'Success' ? 'status-success' : 'status-failed' ?>">
										<?= esc($log['status']) ?>
									</span>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<div class="footer">
			Showing <?= count($filteredLogs) ?> of <?= count($activityLogs) ?> log entries
		</div>
	</div>
</div>
