<?php
$currentPage = $page ?? 'dashboard';
$rawRole = strtolower(trim((string) ($_SESSION['role'] ?? '')));
$displayName = trim((string) ($_SESSION['name'] ?? 'User'));
$displayRoleName = trim((string) ($_SESSION['role_name'] ?? ''));

$roleAlias = [
	'head' => 'hc_head',
	'hc_head' => 'hc_head',
	'health_center_head' => 'hc_head',
	'bhw' => 'bhw',
	'bns' => 'bns',
];

$currentRole = $roleAlias[$rawRole] ?? 'bns';

$menuByRole = [
	'bns' => [
		['page' => 'dashboard', 'label' => 'Dashboard'],
		['page' => 'residents', 'label' => 'Residents'],
		['page' => 'nutrition_ai', 'label' => 'Nutrition Assessment & AI'],
		['page' => 'nutrition_programs', 'label' => 'Nutrition Programs'],
		['page' => 'bmi_calc', 'label' => 'BMI Calculator'],
		['page' => 'reports', 'label' => 'Reports'],
		['page' => 'alerts', 'label' => 'Alerts'],
	],
	'bhw' => [
		['page' => 'dashboard', 'label' => 'Dashboard'],
		['page' => 'residents', 'label' => 'Residents'],
		['page' => 'bmi_cal', 'label' => 'BMI Calculator'],
		['page' => 'reports', 'label' => 'Reports'],
		['page' => 'alerts', 'label' => 'Alerts'],
	],
	'hc_head' => [
		['page' => 'dashboard', 'label' => 'Dashboard'],
		['page' => 'residents', 'label' => 'Residents'],
		['page' => 'reports', 'label' => 'Reports'],
		['page' => 'alerts', 'label' => 'Alerts'],
		['page' => 'activity_log', 'label' => 'Activity Log'],
		['page' => 'user_management', 'label' => 'User Management'],
	],
];

if (!array_key_exists($currentRole, $menuByRole)) {
	$currentRole = 'bns';
}

$menuItems = $menuByRole[$currentRole];

$iconByPage = [
	'dashboard' => '<path d="M4.75 4.75h5.25v5.25H4.75zM14 4.75h5.25v5.25H14zM4.75 14h5.25v5.25H4.75zM14 14h5.25v5.25H14z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'residents' => '<path d="M16.5 19.25v-1.5a3.25 3.25 0 00-3.25-3.25h-2.5a3.25 3.25 0 00-3.25 3.25v1.5M12 11.25a3 3 0 100-6 3 3 0 000 6zm6.25 8v-1a2.75 2.75 0 00-2.25-2.7m-8-7.4A2.75 2.75 0 016 10.85" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'bmi_calc' => '<path d="M8 4.75h8M8 8.25h8M8.75 12h.01M12 12h.01M15.25 12h.01M8.75 15.25h.01M12 15.25h.01M15.25 15.25h.01M9.5 20h5a2.75 2.75 0 002.75-2.75V6.75A2.75 2.75 0 0014.5 4h-5a2.75 2.75 0 00-2.75 2.75v10.5A2.75 2.75 0 009.5 20z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'bmi_cal' => '<path d="M8 4.75h8M8 8.25h8M8.75 12h.01M12 12h.01M15.25 12h.01M8.75 15.25h.01M12 15.25h.01M15.25 15.25h.01M9.5 20h5a2.75 2.75 0 002.75-2.75V6.75A2.75 2.75 0 0014.5 4h-5a2.75 2.75 0 00-2.75 2.75v10.5A2.75 2.75 0 009.5 20z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'reports' => '<path d="M8.5 4.75h5l3.75 3.75v10A1.75 1.75 0 0115.5 20h-7A1.75 1.75 0 016.75 18.5v-12A1.75 1.75 0 018.5 4.75zM13.5 4.75V8.5h3.75M9.5 12h5M9.5 15h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'alerts' => '<path d="M12 5.5a4 4 0 00-4 4v2.08c0 .56-.16 1.11-.46 1.58L6.25 15.25h11.5l-1.29-2.09c-.3-.47-.46-1.02-.46-1.58V9.5a4 4 0 00-4-4zM10.25 18a1.75 1.75 0 003.5 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'nutrition_ai' => '<path d="M9.5 19.25h5M10 4.75h4a2.25 2.25 0 012.25 2.25v5.1a4.5 4.5 0 11-8.5 0V7A2.25 2.25 0 0110 4.75zM9.75 9.5h4.5M9.75 12h2.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'nutrition_programs' => '<path d="M7.5 6.5h9a2 2 0 012 2v7a2 2 0 01-2 2h-9a2 2 0 01-2-2v-7a2 2 0 012-2zM9 4.75v3.5M15 4.75v3.5M8.75 11.25h6.5M8.75 14h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'activity_log' => '<path d="M6.75 6.75h10.5M6.75 12h10.5M6.75 17.25h6.5M5.5 4.75h13a1.75 1.75 0 011.75 1.75v11a1.75 1.75 0 01-1.75 1.75h-13a1.75 1.75 0 01-1.75-1.75v-11A1.75 1.75 0 015.5 4.75z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
	'user_management' => '<path d="M8.75 10.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM15.25 11.75a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5zM5.5 18.75v-1a3.25 3.25 0 013.25-3.25h2a3.25 3.25 0 013.25 3.25v1M14.25 18.75v-.5a2.75 2.75 0 012.75-2.75h.25a2.75 2.75 0 012.75 2.75v.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
];

if ($displayRoleName === '') {
	$roleLabels = [
		'hc_head' => 'Health Center Head',
		'bhw' => 'Barangay Health Worker',
		'bns' => 'Barangay Nutrition Scholar',
	];
	$displayRoleName = $roleLabels[$currentRole] ?? strtoupper(str_replace('_', ' ', $currentRole));
}
?>

<style>
	.app-sidebar {
		width: 248px;
		min-width: 248px;
		background: #ffffff;
		color: #0f172a;
		min-height: 100vh;
		display: flex;
		flex-direction: column;
		border-right: 1px solid #e2e8f0;
		box-sizing: border-box;
		transition: width 0.25s ease, min-width 0.25s ease;
		overflow: hidden;
	}

	.app-brand {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 18px 14px 16px;
		border-bottom: 1px solid #e2e8f0;
	}

	.brand-icon {
		width: 30px;
		height: 30px;
		border-radius: 999px;
		background: linear-gradient(135deg, #0ea5a8 0%, #0f9fb5 100%);
		display: inline-flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}

	.brand-title {
		font-size: 15px;
		font-weight: 600;
		letter-spacing: 0.2px;
		color: #0f172a;
	}

	.sidebar-brand-copy {
		min-width: 0;
	}

	.sidebar-profile {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 14px;
		background: linear-gradient(180deg, #e8f8fb 0%, #eefbfd 100%);
		border-bottom: 1px solid #d7eef2;
	}

	.profile-avatar {
		width: 40px;
		height: 40px;
		border-radius: 999px;
		background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
		color: #ffffff;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
		box-shadow: 0 8px 18px rgba(37, 99, 235, 0.2);
	}

	.profile-copy {
		min-width: 0;
	}

	.user-name {
		font-size: 14px;
		font-weight: 600;
		color: #0f172a;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.user-role {
		margin-top: 2px;
		font-size: 12px;
		color: #64748b;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.sidebar-collapse {
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		width: 100%;
		border: 0;
		background: #ffffff;
		color: #475569;
		padding: 16px 14px;
		font-size: 13px;
		font-weight: 600;
		border-bottom: 1px solid #e2e8f0;
		cursor: pointer;
	}

	.sidebar-collapse:hover {
		background: #f8fafc;
	}

	.sidebar-main {
		display: flex;
		flex-direction: column;
		flex: 1;
		padding: 14px 12px 18px;
	}

	.sidebar-menu {
		display: flex;
		flex-direction: column;
		gap: 6px;
	}

	.sidebar-link {
		display: flex;
		align-items: center;
		gap: 12px;
		text-decoration: none;
		color: #334155;
		font-size: 14px;
		font-weight: 500;
		padding: 11px 12px;
		border-radius: 12px;
		transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
		white-space: nowrap;
	}

	.sidebar-link:hover {
		background: #f8fafc;
		transform: translateX(2px);
	}

	.sidebar-link.active {
		background: #f1f5f9;
		color: #0f172a;
		font-weight: 600;
	}

	.sidebar-link-icon {
		width: 18px;
		height: 18px;
		flex-shrink: 0;
	}

	.sidebar-link-label,
	.brand-title,
	.user-name,
	.user-role,
	.collapse-label,
	.sidebar-footer-label {
		transition: opacity 0.18s ease, visibility 0.18s ease;
	}

	.sidebar-footer {
		margin-top: auto;
		padding-top: 18px;
	}

	.logout-link {
		display: flex;
		align-items: center;
		gap: 12px;
		text-decoration: none;
		color: #64748b;
		font-size: 14px;
		font-weight: 500;
		padding: 11px 12px;
		border-radius: 12px;
	}

	.logout-link:hover {
		background: #f8fafc;
		color: #0f172a;
	}

	.app-sidebar.is-collapsed {
		width: 88px;
		min-width: 88px;
	}

	.app-sidebar.is-collapsed .brand-title,
	.app-sidebar.is-collapsed .user-name,
	.app-sidebar.is-collapsed .user-role,
	.app-sidebar.is-collapsed .collapse-label,
	.app-sidebar.is-collapsed .sidebar-link-label,
	.app-sidebar.is-collapsed .sidebar-footer-label {
		opacity: 0;
		visibility: hidden;
		width: 0;
		overflow: hidden;
	}

	.app-sidebar.is-collapsed .app-brand,
	.app-sidebar.is-collapsed .sidebar-profile {
		justify-content: center;
	}

	.app-sidebar.is-collapsed .sidebar-link,
	.app-sidebar.is-collapsed .logout-link {
		justify-content: center;
		padding-left: 0;
		padding-right: 0;
	}

	.app-sidebar.is-collapsed .sidebar-collapse {
		gap: 0;
	}

	.app-sidebar.is-collapsed .brand-icon,
	.app-sidebar.is-collapsed .profile-avatar {
		margin-right: 0;
	}

	@media (max-width: 960px) {
		.app-sidebar {
			width: 220px;
			min-width: 220px;
		}
	}

	@media (max-width: 720px) {
		.app-sidebar,
		.app-sidebar.is-collapsed {
			width: 88px;
			min-width: 88px;
		}

		.app-sidebar .brand-title,
		.app-sidebar .user-name,
		.app-sidebar .user-role,
		.app-sidebar .collapse-label,
		.app-sidebar .sidebar-link-label,
		.app-sidebar .sidebar-footer-label {
			opacity: 0;
			visibility: hidden;
			width: 0;
			overflow: hidden;
		}

		.app-sidebar .app-brand,
		.app-sidebar .sidebar-profile,
		.app-sidebar .sidebar-link,
		.app-sidebar .logout-link {
			justify-content: center;
		}
	}
</style>

<aside class="app-sidebar" id="app-sidebar">
	<div class="app-brand">
		<span class="brand-icon" aria-hidden="true">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M9 12.75L11.25 15L15 9.75m-3-7.036A11.959 11.959 0 013.598 6A11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</span>
		<div class="sidebar-brand-copy">
			<div class="brand-title">NUTRIGUARD</div>
		</div>
	</div>

	<div class="sidebar-profile">
		<span class="profile-avatar" aria-hidden="true">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 12a3.75 3.75 0 100-7.5A3.75 3.75 0 0012 12zm-6 7.5a6 6 0 1112 0" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</span>
		<div class="profile-copy">
			<div class="user-name"><?= htmlspecialchars($displayName) ?></div>
			<div class="user-role"><?= htmlspecialchars($displayRoleName) ?></div>
		</div>
	</div>

	<button class="sidebar-collapse" id="sidebar-collapse" type="button" aria-expanded="true" aria-controls="app-sidebar">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
			<path d="M14.25 6.75L9 12l5.25 5.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
		<span class="collapse-label">Collapse</span>
	</button>

	<div class="sidebar-main">
		<nav class="sidebar-menu">
			<?php foreach ($menuItems as $item): ?>
				<?php
				$isActive = $currentPage === $item['page'];
				$iconMarkup = $iconByPage[$item['page']] ?? $iconByPage['reports'];
				?>
				<a
					class="sidebar-link<?= $isActive ? ' active' : '' ?>"
					href="layout.php?page=<?= urlencode($item['page']) ?>"
					title="<?= htmlspecialchars($item['label']) ?>"
				>
					<svg class="sidebar-link-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
						<?= $iconMarkup ?>
					</svg>
					<span class="sidebar-link-label"><?= htmlspecialchars($item['label']) ?></span>
				</a>
			<?php endforeach; ?>
		</nav>

		<div class="sidebar-footer">
			<a class="logout-link" href="backend/logout.php" title="Sign out">
				<svg class="sidebar-link-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
					<path d="M14 7.75V6.5A1.75 1.75 0 0012.25 4.75h-5.5A1.75 1.75 0 005 6.5v11A1.75 1.75 0 006.75 19.25h5.5A1.75 1.75 0 0014 17.5v-1.25M10.5 12h8m0 0l-2.5-2.5m2.5 2.5l-2.5 2.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span class="sidebar-footer-label">Sign out</span>
			</a>
		</div>
	</div>
</aside>

<script>
	(function () {
		const sidebar = document.getElementById('app-sidebar');
		const toggle = document.getElementById('sidebar-collapse');

		if (!sidebar || !toggle) {
			return;
		}

		const storageKey = 'nutriguard-sidebar-collapsed';

		const applyState = (collapsed) => {
			sidebar.classList.toggle('is-collapsed', collapsed);
			toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
			toggle.title = collapsed ? 'Expand sidebar' : 'Collapse sidebar';
		};

		applyState(window.localStorage.getItem(storageKey) === 'true');

		toggle.addEventListener('click', function () {
			const collapsed = !sidebar.classList.contains('is-collapsed');
			applyState(collapsed);
			window.localStorage.setItem(storageKey, collapsed ? 'true' : 'false');
		});
	})();
</script>
