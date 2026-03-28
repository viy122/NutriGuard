<?php
// Redirect direct access so shared layout/sidebar/css are used.
if (basename((string) ($_SERVER['SCRIPT_NAME'] ?? '')) === 'user_management.php' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
	$redirectParams = $_GET;
	$redirectParams['page'] = 'user_management';
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
	echo '<p style="margin:0;color:#64748b;">User Management is available for head user only.</p>';
	echo '</div>';
	return;
}

$usersData = [
	['id' => 'U-001', 'username' => 'admin.pedro', 'fullName' => 'Pedro Santos', 'email' => 'pedro.santos@barangay.gov.ph', 'role' => 'Administrator', 'roleClass' => 'role-admin', 'purok' => 'All', 'status' => 'Active', 'statusClass' => 'status-active', 'lastLogin' => '2026-03-15 13:15:42', 'createdDate' => '2025-01-10'],
	['id' => 'U-002', 'username' => 'bns.maria', 'fullName' => 'Maria Cruz', 'email' => 'maria.cruz@barangay.gov.ph', 'role' => 'BNS', 'roleClass' => 'role-bns', 'purok' => 'Purok 1-3', 'status' => 'Active', 'statusClass' => 'status-active', 'lastLogin' => '2026-03-15 14:32:15', 'createdDate' => '2025-02-15'],
	['id' => 'U-003', 'username' => 'bhw.linda', 'fullName' => 'Linda Reyes', 'email' => 'linda.reyes@barangay.gov.ph', 'role' => 'BHW', 'roleClass' => 'role-bhw', 'purok' => 'Purok 4-5', 'status' => 'Active', 'statusClass' => 'status-active', 'lastLogin' => '2026-03-15 11:05:23', 'createdDate' => '2025-03-20'],
	['id' => 'U-004', 'username' => 'bns.rosa', 'fullName' => 'Rosa Martinez', 'email' => 'rosa.martinez@barangay.gov.ph', 'role' => 'BNS', 'roleClass' => 'role-bns', 'purok' => 'Purok 4-5', 'status' => 'Active', 'statusClass' => 'status-active', 'lastLogin' => '2026-03-14 16:48:11', 'createdDate' => '2025-03-14'],
	['id' => 'U-005', 'username' => 'bhw.carlos', 'fullName' => 'Carlos Diaz', 'email' => 'carlos.diaz@barangay.gov.ph', 'role' => 'BHW', 'roleClass' => 'role-bhw', 'purok' => 'Purok 1-2', 'status' => 'Inactive', 'statusClass' => 'status-inactive', 'lastLogin' => '2026-02-28 09:22:11', 'createdDate' => '2025-04-05'],
	['id' => 'U-006', 'username' => 'bns.elena', 'fullName' => 'Elena Gonzales', 'email' => 'elena.gonzales@barangay.gov.ph', 'role' => 'BNS', 'roleClass' => 'role-bns', 'purok' => 'Purok 3', 'status' => 'Active', 'statusClass' => 'status-active', 'lastLogin' => '2026-03-13 15:30:45', 'createdDate' => '2025-05-18'],
];

$searchTerm = trim((string) ($_GET['search'] ?? ''));
$roleFilter = (string) ($_GET['role'] ?? 'all');
$statusFilter = (string) ($_GET['status'] ?? 'all');

$filteredUsers = array_values(array_filter($usersData, static function (array $user) use ($searchTerm, $roleFilter, $statusFilter): bool {
	$search = strtolower($searchTerm);
	$matchesSearch = $search === ''
		|| strpos(strtolower((string) $user['fullName']), $search) !== false
		|| strpos(strtolower((string) $user['username']), $search) !== false
		|| strpos(strtolower((string) $user['email']), $search) !== false;

	$matchesRole = $roleFilter === 'all' || $user['role'] === $roleFilter;
	$matchesStatus = $statusFilter === 'all' || $user['status'] === $statusFilter;

	return $matchesSearch && $matchesRole && $matchesStatus;
}));

$activeUsers = count(array_filter($usersData, static fn(array $u): bool => $u['status'] === 'Active'));
$inactiveUsers = count(array_filter($usersData, static fn(array $u): bool => $u['status'] === 'Inactive'));
$adminUsers = count(array_filter($usersData, static fn(array $u): bool => $u['role'] === 'Administrator'));
?>

<style>
.user-mgmt-head-page { background: linear-gradient(135deg, #f8fafc, #f1f5f9); min-height: calc(100vh - 2rem); padding: 24px; }
.user-mgmt-head-page .hero { background: linear-gradient(135deg, #06b6d4, #0d9488); color: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 16px 35px rgba(13, 148, 136, 0.25); }
.user-mgmt-head-page .hero-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
.user-mgmt-head-page .hero h1 { margin: 0 0 6px; font-size: 30px; }
.user-mgmt-head-page .hero p { margin: 0; font-size: 13px; opacity: 0.9; }
.user-mgmt-head-page .add-btn { border: 0; border-radius: 10px; padding: 9px 14px; font-size: 13px; font-weight: 700; background: #fff; color: #0891b2; box-shadow: 0 8px 18px rgba(2, 132, 199, 0.2); cursor: pointer; }

.user-mgmt-head-page .stats { margin-top: 18px; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
.user-mgmt-head-page .stat { background: #fff; border-radius: 16px; box-shadow: 0 6px 24px rgba(15, 23, 42, 0.08); padding: 18px; border-left: 4px solid; }
.user-mgmt-head-page .stat.total { border-left-color: #3b82f6; }
.user-mgmt-head-page .stat.active { border-left-color: #22c55e; }
.user-mgmt-head-page .stat.inactive { border-left-color: #6b7280; }
.user-mgmt-head-page .stat.admin { border-left-color: #a855f7; }
.user-mgmt-head-page .stat-label { color: #64748b; font-size: 13px; font-weight: 600; margin-bottom: 4px; }
.user-mgmt-head-page .stat-value { font-size: 38px; font-weight: 700; line-height: 1; color: #0f172a; }
.user-mgmt-head-page .stat-sub { font-size: 11px; margin-top: 5px; font-weight: 600; }

.user-mgmt-head-page .filters { margin-top: 16px; display: grid; grid-template-columns: 1.4fr 0.8fr 0.8fr auto; gap: 12px; align-items: center; }
.user-mgmt-head-page .field,
.user-mgmt-head-page .select { width: 100%; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; height: 46px; padding: 0 12px; box-shadow: 0 3px 10px rgba(15, 23, 42, 0.06); }
.user-mgmt-head-page .apply-btn { height: 46px; border: 0; border-radius: 12px; padding: 0 14px; color: #fff; font-weight: 600; background: linear-gradient(135deg, #06b6d4, #0d9488); cursor: pointer; }

.user-mgmt-head-page .table-wrap { margin-top: 16px; background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 6px 24px rgba(15, 23, 42, 0.08); overflow: hidden; }
.user-mgmt-head-page .table-scroll { overflow-x: auto; }
.user-mgmt-head-page table { width: 100%; min-width: 1180px; border-collapse: collapse; }
.user-mgmt-head-page th { text-align: left; padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; background: linear-gradient(90deg, #f8fafc, #f1f5f9); border-bottom: 1px solid #e2e8f0; }
.user-mgmt-head-page td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: top; font-size: 13px; color: #334155; }
.user-mgmt-head-page .mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; }
.user-mgmt-head-page .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
.user-mgmt-head-page .role-admin { background: #f3e8ff; color: #7e22ce; }
.user-mgmt-head-page .role-bns { background: #dbeafe; color: #1d4ed8; }
.user-mgmt-head-page .role-bhw { background: #ccfbf1; color: #0f766e; }
.user-mgmt-head-page .status-active { background: #dcfce7; color: #15803d; }
.user-mgmt-head-page .status-inactive { background: #f1f5f9; color: #475569; }

.user-mgmt-head-page .actions { display: flex; gap: 6px; }
.user-mgmt-head-page .icon-btn { border: 0; background: transparent; color: #64748b; border-radius: 8px; padding: 7px; cursor: pointer; }
.user-mgmt-head-page .icon-btn:hover { background: #f8fafc; color: #0f172a; }
.user-mgmt-head-page .footer { padding: 12px 14px; font-size: 13px; color: #64748b; background: #f8fafc; }

.user-mgmt-head-page dialog { border: 0; border-radius: 14px; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.25); width: min(520px, 94vw); padding: 0; }
.user-mgmt-head-page dialog::backdrop { background: rgba(15, 23, 42, 0.55); }
.user-mgmt-head-page .modal-head { padding: 16px 18px; border-bottom: 1px solid #e2e8f0; }
.user-mgmt-head-page .modal-head h3 { margin: 0 0 4px; font-size: 18px; color: #0f172a; }
.user-mgmt-head-page .modal-head p { margin: 0; color: #64748b; font-size: 13px; }
.user-mgmt-head-page .modal-body { padding: 16px 18px; display: grid; gap: 12px; }
.user-mgmt-head-page .modal-field label { display: block; margin-bottom: 5px; font-size: 13px; font-weight: 600; color: #334155; }
.user-mgmt-head-page .modal-field input,
.user-mgmt-head-page .modal-field select { width: 100%; border: 1px solid #cbd5e1; border-radius: 10px; height: 40px; padding: 0 10px; }
.user-mgmt-head-page .password-row { display: grid; grid-template-columns: 1fr auto auto; gap: 8px; }
.user-mgmt-head-page .password-row input { background: #f1f5f9; }
.user-mgmt-head-page .mini-btn { border: 1px solid #cbd5e1; background: #fff; color: #334155; border-radius: 10px; padding: 0 11px; height: 40px; cursor: pointer; }
.user-mgmt-head-page .modal-foot { display: flex; justify-content: flex-end; gap: 8px; padding: 12px 18px 16px; }
.user-mgmt-head-page .btn-cancel { border: 1px solid #cbd5e1; background: #fff; color: #334155; border-radius: 10px; padding: 8px 12px; cursor: pointer; }
.user-mgmt-head-page .btn-primary { border: 0; background: #0891b2; color: #fff; border-radius: 10px; padding: 8px 12px; cursor: pointer; }

@media (max-width: 1200px) {
	.user-mgmt-head-page .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
	.user-mgmt-head-page .filters { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
	.user-mgmt-head-page .hero-top { flex-direction: column; }
	.user-mgmt-head-page .stats { grid-template-columns: 1fr; }
	.user-mgmt-head-page .filters { grid-template-columns: 1fr; }
}
</style>

<div class="user-mgmt-head-page">
	<div class="hero">
		<div class="hero-top">
			<div>
				<h1>User Management</h1>
				<p>Manage BNS and BHW accounts (Admin Only)</p>
			</div>
			<button class="add-btn" type="button" id="openAddUser">Add User</button>
		</div>
	</div>

	<div class="stats">
		<div class="stat total">
			<div class="stat-label">Total Users</div>
			<div class="stat-value"><?= count($usersData) ?></div>
			<div class="stat-sub" style="color:#64748b;">All accounts</div>
		</div>
		<div class="stat active">
			<div class="stat-label">Active</div>
			<div class="stat-value" style="color:#16a34a;"><?= $activeUsers ?></div>
			<div class="stat-sub" style="color:#16a34a;">Currently active</div>
		</div>
		<div class="stat inactive">
			<div class="stat-label">Inactive</div>
			<div class="stat-value" style="color:#6b7280;"><?= $inactiveUsers ?></div>
			<div class="stat-sub" style="color:#64748b;">Deactivated</div>
		</div>
		<div class="stat admin">
			<div class="stat-label">Administrators</div>
			<div class="stat-value"><?= $adminUsers ?></div>
			<div class="stat-sub" style="color:#64748b;">Admin roles</div>
		</div>
	</div>

	<form method="get" action="layout.php" class="filters">
		<input type="hidden" name="page" value="user_management">
		<input class="field" type="text" name="search" value="<?= esc($searchTerm) ?>" placeholder="Search by name, username, or email...">

		<select class="select" name="role">
			<option value="all" <?= $roleFilter === 'all' ? 'selected' : '' ?>>All Roles</option>
			<option value="Administrator" <?= $roleFilter === 'Administrator' ? 'selected' : '' ?>>Administrator</option>
			<option value="BNS" <?= $roleFilter === 'BNS' ? 'selected' : '' ?>>BNS</option>
			<option value="BHW" <?= $roleFilter === 'BHW' ? 'selected' : '' ?>>BHW</option>
		</select>

		<select class="select" name="status">
			<option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>All Status</option>
			<option value="Active" <?= $statusFilter === 'Active' ? 'selected' : '' ?>>Active</option>
			<option value="Inactive" <?= $statusFilter === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
		</select>

		<button class="apply-btn" type="submit">Apply Filters</button>
	</form>

	<div class="table-wrap">
		<div class="table-scroll">
			<table>
				<thead>
					<tr>
						<th>User ID</th>
						<th>Name</th>
						<th>Username</th>
						<th>Email</th>
						<th>Role</th>
						<th>Purok</th>
						<th>Status</th>
						<th>Last Login</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($filteredUsers)): ?>
						<tr>
							<td colspan="9" style="text-align:center;color:#94a3b8;padding:30px;">No users found.</td>
						</tr>
					<?php else: ?>
						<?php foreach ($filteredUsers as $user): ?>
							<tr>
								<td style="font-weight:600;color:#475569;"><?= esc($user['id']) ?></td>
								<td style="font-weight:600;color:#0f172a;"><?= esc($user['fullName']) ?></td>
								<td class="mono"><?= esc($user['username']) ?></td>
								<td><?= esc($user['email']) ?></td>
								<td><span class="badge <?= esc($user['roleClass']) ?>"><?= esc($user['role']) ?></span></td>
								<td><?= esc($user['purok']) ?></td>
								<td><span class="badge <?= esc($user['statusClass']) ?>"><?= esc($user['status']) ?></span></td>
								<td style="font-weight:600;color:#475569;"><?= esc($user['lastLogin']) ?></td>
								<td>
									<div class="actions">
										<button class="icon-btn" type="button" title="Edit user">Edit</button>
										<?php if ($user['status'] === 'Active'): ?>
											<button class="icon-btn" type="button" title="Deactivate user">Deactivate</button>
										<?php else: ?>
											<button class="icon-btn" type="button" title="Activate user">Activate</button>
										<?php endif; ?>
										<button class="icon-btn" type="button" title="Delete user">Delete</button>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<div class="footer">Showing <?= count($filteredUsers) ?> of <?= count($usersData) ?> users</div>
	</div>

	<dialog id="addUserDialog">
		<div class="modal-head">
			<h3>Add New User</h3>
			<p>Create a new BNS or BHW account</p>
		</div>
		<form method="dialog" class="modal-body" id="addUserForm">
			<div class="modal-field">
				<label for="fullName">Full Name</label>
				<input id="fullName" type="text" placeholder="Enter full name">
			</div>
			<div class="modal-field">
				<label for="email">Email</label>
				<input id="email" type="email" placeholder="Enter email address">
			</div>
			<div class="modal-field">
				<label for="username">Username</label>
				<input id="username" type="text" placeholder="Enter username">
			</div>
			<div class="modal-field">
				<label for="userRole">Role</label>
				<select id="userRole">
					<option value="">Select role</option>
					<option value="BNS">BNS - Barangay Nutrition Scholar</option>
					<option value="BHW">BHW - Barangay Health Worker</option>
				</select>
			</div>
			<div class="modal-field">
				<label for="assignedPurok">Assigned Purok</label>
				<select id="assignedPurok">
					<option value="">Select purok assignment</option>
					<option value="Purok 1">Purok 1</option>
					<option value="Purok 2">Purok 2</option>
					<option value="Purok 3">Purok 3</option>
					<option value="Purok 4">Purok 4</option>
					<option value="Purok 5">Purok 5</option>
					<option value="All">All Puroks (Head only)</option>
				</select>
			</div>

			<div class="modal-field">
				<label for="generatedPassword">Auto-Generated Password</label>
				<div class="password-row">
					<input id="generatedPassword" type="text" readonly>
					<button class="mini-btn" id="copyPasswordBtn" type="button">Copy</button>
					<button class="mini-btn" id="regenPasswordBtn" type="button">Regenerate</button>
				</div>
				<p style="margin:6px 0 0;font-size:11px;color:#64748b;">This password will be used for first login. User can change it later in account settings.</p>
			</div>

			<div class="modal-foot">
				<button type="button" class="btn-cancel" id="cancelAddUser">Cancel</button>
				<button type="submit" class="btn-primary">Create User</button>
			</div>
		</form>
	</dialog>
</div>

<script>
(function () {
	const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
	const dialog = document.getElementById('addUserDialog');
	const openBtn = document.getElementById('openAddUser');
	const cancelBtn = document.getElementById('cancelAddUser');
	const pwdInput = document.getElementById('generatedPassword');
	const copyBtn = document.getElementById('copyPasswordBtn');
	const regenBtn = document.getElementById('regenPasswordBtn');
	const form = document.getElementById('addUserForm');

	function generatePassword() {
		let out = '';
		for (let i = 0; i < 10; i += 1) {
			out += chars.charAt(Math.floor(Math.random() * chars.length));
		}
		return out;
	}

	function resetPasswordUI() {
		pwdInput.value = generatePassword();
		copyBtn.textContent = 'Copy';
	}

	openBtn.addEventListener('click', function () {
		resetPasswordUI();
		dialog.showModal();
	});

	cancelBtn.addEventListener('click', function () {
		dialog.close();
	});

	regenBtn.addEventListener('click', function () {
		resetPasswordUI();
	});

	copyBtn.addEventListener('click', async function () {
		try {
			await navigator.clipboard.writeText(pwdInput.value);
			copyBtn.textContent = 'Copied';
			setTimeout(function () { copyBtn.textContent = 'Copy'; }, 1800);
		} catch (e) {
			copyBtn.textContent = 'Failed';
			setTimeout(function () { copyBtn.textContent = 'Copy'; }, 1800);
		}
	});

	form.addEventListener('submit', function (event) {
		event.preventDefault();
		dialog.close();
		alert('User creation form captured. Connect this to backend save logic next.');
	});
})();
</script>
