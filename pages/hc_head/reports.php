<?php
// Guard: Redirect if accessed directly
if (basename((string) ($_SERVER['SCRIPT_NAME'] ?? '')) === 'reports.php' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
	$redirectParams = $_GET;
	$redirectParams['page'] = 'reports';
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

function esc(string $value): string
{
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function calc_age(string $birthday): int
{
	if ($birthday === '') {
		return 0;
	}

	$birth = DateTime::createFromFormat('Y-m-d', $birthday);
	if (!$birth) {
		return 0;
	}

	$now = new DateTime();
	return (int) $now->diff($birth)->y;
}

$activeTab = (string) ($_GET['tab'] ?? 'garne');
$year = (string) ($_GET['year'] ?? '2026');
$month = (string) ($_GET['month'] ?? 'February');
$quarter = (string) ($_GET['quarter'] ?? '1st');

$validTabs = ['garne', 'cbmb', 'ageMasterlist', 'pregnant', 'pregnancyOutcome'];
if (!in_array($activeTab, $validTabs, true)) {
	$activeTab = 'garne';
}

$validQuarters = ['1st', '2nd', '3rd', '4th'];
if (!in_array($quarter, $validQuarters, true)) {
	$quarter = '1st';
}

$years = ['2026', '2025', '2024'];
$months = [
	'January', 'February', 'March', 'April', 'May', 'June',
	'July', 'August', 'September', 'October', 'November', 'December',
];

$tabs = [
	['id' => 'garne', 'label' => 'BHW GARNE Reports'],
	['id' => 'cbmb', 'label' => 'CBMB Quarterly'],
	['id' => 'ageMasterlist', 'label' => 'Age Group Masterlist'],
	['id' => 'pregnant', 'label' => 'Pregnant Women Tracker'],
	['id' => 'pregnancyOutcome', 'label' => 'Pregnancy Outcomes'],
];

$bhwReports = [
	['id' => 1, 'bhwName' => 'Ana Torres', 'purok' => 'Purok 1', 'month' => 'February', 'year' => '2026', 'status' => 'Submitted'],
	['id' => 2, 'bhwName' => 'Maria Santos', 'purok' => 'Purok 2', 'month' => 'February', 'year' => '2026', 'status' => 'Submitted'],
];

$puroks = ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5'];

$cbmbQuarterData = [
	'1st' => [
		'totalPop' => '316',
		'noHouses' => '101',
		'noFamilies' => '163',
		'withSanitary' => '73',
		'withUnsanitary' => '2',
		'noToilet' => '26',
		'nawasa' => '75',
		'deepWell' => '0',
		'spring' => '0',
		'housesIodizedSalt' => '95',
		'fullyImmunized' => '42',
		'infantDeaths' => '0',
	],
	'2nd' => [
		'totalPop' => '316',
		'noHouses' => '105',
		'noFamilies' => '163',
		'withSanitary' => '74',
		'withUnsanitary' => '2',
		'noToilet' => '29',
		'nawasa' => '96',
		'deepWell' => '0',
		'spring' => '0',
		'housesIodizedSalt' => '98',
		'fullyImmunized' => '45',
		'infantDeaths' => '1',
	],
	'3rd' => [
		'totalPop' => '317',
		'noHouses' => '105',
		'noFamilies' => '165',
		'withSanitary' => '76',
		'withUnsanitary' => '2',
		'noToilet' => '27',
		'nawasa' => '78',
		'deepWell' => '0',
		'spring' => '0',
		'housesIodizedSalt' => '100',
		'fullyImmunized' => '48',
		'infantDeaths' => '0',
	],
	'4th' => [
		'totalPop' => '332',
		'noHouses' => '109',
		'noFamilies' => '169',
		'withSanitary' => '78',
		'withUnsanitary' => '2',
		'noToilet' => '29',
		'nawasa' => '80',
		'deepWell' => '0',
		'spring' => '0',
		'housesIodizedSalt' => '102',
		'fullyImmunized' => '50',
		'infantDeaths' => '0',
	],
];

$residents = [
	['id' => 1, 'surname' => 'Dela Cruz', 'firstname' => 'Maria', 'middlename' => 'Santos', 'birthday' => '1990-03-15', 'gender' => 'F', 'purok' => 'Purok 1', 'contactNo' => '09123456789', 'isPregnant' => false],
	['id' => 2, 'surname' => 'Garcia', 'firstname' => 'Juan', 'middlename' => 'Reyes', 'birthday' => '1985-07-22', 'gender' => 'M', 'purok' => 'Purok 1', 'contactNo' => '09234567890', 'isPregnant' => false],
	['id' => 3, 'surname' => 'Santos', 'firstname' => 'Ana', 'middlename' => 'Lopez', 'birthday' => '2020-05-10', 'gender' => 'F', 'purok' => 'Purok 2', 'contactNo' => '', 'isPregnant' => false],
	['id' => 4, 'surname' => 'Reyes', 'firstname' => 'Pedro', 'middlename' => 'Cruz', 'birthday' => '2019-11-03', 'gender' => 'M', 'purok' => 'Purok 2', 'contactNo' => '', 'isPregnant' => false],
	['id' => 5, 'surname' => 'Lopez', 'firstname' => 'Carmen', 'middlename' => 'Bautista', 'birthday' => '1968-01-20', 'gender' => 'F', 'purok' => 'Purok 3', 'contactNo' => '09345678901', 'isPregnant' => false],
	['id' => 6, 'surname' => 'Capacia', 'firstname' => 'Maricon', 'middlename' => 'Olivar', 'birthday' => '1993-04-12', 'gender' => 'F', 'purok' => 'Purok 2', 'contactNo' => '09551593652', 'isPregnant' => true, 'lmp' => '2025-08-15', 'edd' => '2026-05-22'],
	['id' => 7, 'surname' => 'Hernandez', 'firstname' => 'Elena', 'middlename' => 'Vega', 'birthday' => '1988-09-01', 'gender' => 'F', 'purok' => 'Purok 1', 'contactNo' => '09678901234', 'isPregnant' => true, 'lmp' => '2025-10-05', 'edd' => '2026-07-12'],
];

$summaryGroups = [
	['label' => 'Less than 1 yr old', 'min' => 0, 'max' => 0],
	['label' => '1-4 years old', 'min' => 1, 'max' => 4],
	['label' => '5-6 years old', 'min' => 5, 'max' => 6],
	['label' => '7-14 years old', 'min' => 7, 'max' => 14],
	['label' => '15-49 years old', 'min' => 15, 'max' => 49],
	['label' => '50-64 years old', 'min' => 50, 'max' => 64],
	['label' => '65 years & above', 'min' => 65, 'max' => 200],
];

$countByRange = function (int $min, int $max, string $gender) use ($residents): int {
	$count = 0;
	foreach ($residents as $resident) {
		$age = calc_age((string) $resident['birthday']);
		if ($resident['gender'] === $gender && $age >= $min && $age <= $max) {
			$count++;
		}
	}
	return $count;
};

$summaryRows = [];
foreach ($summaryGroups as $group) {
	$female = $countByRange((int) $group['min'], (int) $group['max'], 'F');
	$male = $countByRange((int) $group['min'], (int) $group['max'], 'M');
	$summaryRows[] = [
		'label' => $group['label'],
		'f' => $female,
		'm' => $male,
		'total' => $female + $male,
	];
}

$pregnantResidents = array_values(array_filter($residents, static function (array $resident): bool {
	return (bool) ($resident['isPregnant'] ?? false);
}));

$queryBase = 'layout.php?page=reports&year=' . urlencode($year) . '&month=' . urlencode($month) . '&quarter=' . urlencode($quarter);
?>

<style>
.reports-head-page { padding: 20px; color: #0f172a; }
.reports-head-header { display: flex; justify-content: space-between; gap: 12px; align-items: center; margin-bottom: 14px; }
.reports-head-header h1 { margin: 0 0 4px; font-size: 24px; }
.reports-head-header p { margin: 0; color: #64748b; font-size: 14px; }

.reports-head-btn {
	border: 0;
	border-radius: 10px;
	padding: 9px 14px;
	font-weight: 600;
	color: #fff;
	background: linear-gradient(135deg, #06b6d4, #0d9488);
	text-decoration: none;
	display: inline-flex;
	align-items: center;
	gap: 8px;
}

.reports-head-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
.reports-head-tab {
	text-decoration: none;
	color: #475569;
	font-size: 13px;
	font-weight: 600;
	border: 1px solid #e2e8f0;
	border-radius: 12px;
	padding: 9px 13px;
	background: #fff;
}
.reports-head-tab.active { border-color: #67e8f9; background: #ecfeff; color: #0e7490; }

.reports-head-card {
	background: #fff;
	border: 1px solid #e2e8f0;
	border-radius: 16px;
	box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
	overflow: hidden;
}

.reports-head-card-header {
	padding: 18px 20px;
	border-bottom: 1px solid #e2e8f0;
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 10px;
	flex-wrap: wrap;
}
.reports-head-card-header h2 { margin: 0 0 3px; font-size: 18px; }
.reports-head-card-header p { margin: 0; color: #64748b; font-size: 13px; }

.reports-head-filters { display: flex; gap: 8px; flex-wrap: wrap; }
.reports-head-select {
	border: 1px solid #cbd5e1;
	border-radius: 10px;
	padding: 8px 10px;
	font-size: 13px;
	background: #fff;
}

.reports-head-table-wrap { overflow-x: auto; }
.reports-head-table { width: 100%; border-collapse: collapse; min-width: 760px; }
.reports-head-table th {
	text-align: left;
	padding: 12px;
	font-size: 11px;
	text-transform: uppercase;
	letter-spacing: .06em;
	color: #64748b;
	background: #f8fafc;
	border-bottom: 1px solid #e2e8f0;
}
.reports-head-table td {
	padding: 12px;
	border-bottom: 1px solid #f1f5f9;
	font-size: 13px;
	color: #334155;
	vertical-align: top;
}

.reports-head-badge {
	display: inline-block;
	padding: 4px 10px;
	border-radius: 999px;
	font-size: 11px;
	font-weight: 700;
}
.reports-head-badge.submitted { background: #dcfce7; color: #15803d; }
.reports-head-badge.pending { background: #fee2e2; color: #b91c1c; }

.reports-head-btn-sm {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 6px;
	border: 1px solid #cbd5e1;
	border-radius: 8px;
	padding: 6px 10px;
	color: #334155;
	background: #fff;
	font-size: 12px;
	text-decoration: none;
}

.reports-head-grid {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 12px;
	padding: 16px 20px 20px;
}

.reports-head-mini {
	border: 1px solid #e2e8f0;
	border-radius: 12px;
	padding: 12px;
}
.reports-head-mini h3 {
	margin: 0 0 10px;
	font-size: 12px;
	letter-spacing: 0.06em;
	text-transform: uppercase;
	color: #0e7490;
}

.reports-head-mini-row {
	display: flex;
	justify-content: space-between;
	gap: 8px;
	font-size: 13px;
	padding: 7px 0;
	border-bottom: 1px solid #f1f5f9;
}
.reports-head-mini-row:last-child { border-bottom: 0; }

.reports-head-total { font-weight: 700; color: #0e7490; }

@media (max-width: 900px) {
	.reports-head-grid { grid-template-columns: 1fr; }
}
</style>

<div class="reports-head-page">
	<div class="reports-head-header">
		<div>
			<h1>Reports</h1>
			<p>Consolidated reports from all BHW</p>
		</div>
		<a class="reports-head-btn" href="<?= esc($queryBase . '&tab=' . $activeTab) ?>">Export PDF</a>
	</div>

	<div class="reports-head-tabs">
		<?php foreach ($tabs as $tab): ?>
			<a
				class="reports-head-tab <?= $activeTab === $tab['id'] ? 'active' : '' ?>"
				href="<?= esc($queryBase . '&tab=' . urlencode($tab['id'])) ?>"
			>
				<?= esc($tab['label']) ?>
			</a>
		<?php endforeach; ?>
	</div>

	<?php if ($activeTab === 'garne'): ?>
		<section class="reports-head-card">
			<div class="reports-head-card-header">
				<div>
					<h2>BHW Monthly Activities Reports (GARNE)</h2>
					<p>Submitted reports for <?= esc($year) ?></p>
				</div>
				<form method="get" action="layout.php" class="reports-head-filters">
					<input type="hidden" name="page" value="reports">
					<input type="hidden" name="tab" value="garne">
					<input type="hidden" name="quarter" value="<?= esc($quarter) ?>">
					<select name="year" class="reports-head-select" onchange="this.form.submit()">
						<?php foreach ($years as $yearItem): ?>
							<option value="<?= esc($yearItem) ?>" <?= $year === $yearItem ? 'selected' : '' ?>><?= esc($yearItem) ?></option>
						<?php endforeach; ?>
					</select>
					<select name="month" class="reports-head-select" onchange="this.form.submit()">
						<?php foreach ($months as $monthItem): ?>
							<option value="<?= esc($monthItem) ?>" <?= $month === $monthItem ? 'selected' : '' ?>><?= esc($monthItem) ?></option>
						<?php endforeach; ?>
					</select>
				</form>
			</div>

			<div class="reports-head-table-wrap">
				<table class="reports-head-table">
					<thead>
						<tr>
							<th>BHW Name</th>
							<th>Purok</th>
							<th>Month/Year</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($bhwReports as $report): ?>
							<tr>
								<td><strong><?= esc($report['bhwName']) ?></strong></td>
								<td><?= esc($report['purok']) ?></td>
								<td><?= esc($report['month']) ?> <?= esc($report['year']) ?></td>
								<td><span class="reports-head-badge submitted"><?= esc($report['status']) ?></span></td>
								<td><a class="reports-head-btn-sm" href="<?= esc($queryBase . '&tab=garne') ?>">View</a></td>
							</tr>
						<?php endforeach; ?>

						<?php foreach ($puroks as $purok): ?>
							<?php
							$found = false;
							foreach ($bhwReports as $report) {
								if ($report['purok'] === $purok) {
									$found = true;
									break;
								}
							}
							?>
							<?php if (!$found): ?>
								<tr>
									<td style="color:#94a3b8;">-</td>
									<td><?= esc($purok) ?></td>
									<td><?= esc($month) ?> <?= esc($year) ?></td>
									<td><span class="reports-head-badge pending">Not Submitted</span></td>
									<td style="color:#94a3b8;">-</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>
	<?php endif; ?>

	<?php if ($activeTab === 'cbmb'): ?>
		<section class="reports-head-card">
			<div class="reports-head-card-header">
				<div>
					<h2>Community Based Monitoring Board (CBMB)</h2>
					<p>Municipality: Tuy, Batangas · Year <?= esc($year) ?></p>
				</div>
				<form method="get" action="layout.php" class="reports-head-filters">
					<input type="hidden" name="page" value="reports">
					<input type="hidden" name="tab" value="cbmb">
					<input type="hidden" name="month" value="<?= esc($month) ?>">
					<select name="year" class="reports-head-select" onchange="this.form.submit()">
						<?php foreach ($years as $yearItem): ?>
							<option value="<?= esc($yearItem) ?>" <?= $year === $yearItem ? 'selected' : '' ?>><?= esc($yearItem) ?></option>
						<?php endforeach; ?>
					</select>
					<select name="quarter" class="reports-head-select" onchange="this.form.submit()">
						<?php foreach ($validQuarters as $q): ?>
							<option value="<?= esc($q) ?>" <?= $quarter === $q ? 'selected' : '' ?>><?= esc($q) ?> Quarter</option>
						<?php endforeach; ?>
					</select>
				</form>
			</div>

			<div class="reports-head-grid">
				<div class="reports-head-mini">
					<h3>Community Health Profile</h3>
					<div class="reports-head-mini-row"><span>Total Population</span><strong><?= esc($cbmbQuarterData[$quarter]['totalPop']) ?></strong></div>
					<div class="reports-head-mini-row"><span>No. of Houses</span><strong><?= esc($cbmbQuarterData[$quarter]['noHouses']) ?></strong></div>
					<div class="reports-head-mini-row"><span>No. of Families</span><strong><?= esc($cbmbQuarterData[$quarter]['noFamilies']) ?></strong></div>
					<div class="reports-head-mini-row"><span>With Sanitary Toilet</span><strong><?= esc($cbmbQuarterData[$quarter]['withSanitary']) ?></strong></div>
					<div class="reports-head-mini-row"><span>With Unsanitary Toilet</span><strong><?= esc($cbmbQuarterData[$quarter]['withUnsanitary']) ?></strong></div>
					<div class="reports-head-mini-row"><span>No Toilet</span><strong><?= esc($cbmbQuarterData[$quarter]['noToilet']) ?></strong></div>
				</div>
				<div class="reports-head-mini">
					<h3>Water Supply</h3>
					<div class="reports-head-mini-row"><span>NAWASA</span><strong><?= esc($cbmbQuarterData[$quarter]['nawasa']) ?></strong></div>
					<div class="reports-head-mini-row"><span>Deep Well / Jetmatic</span><strong><?= esc($cbmbQuarterData[$quarter]['deepWell']) ?></strong></div>
					<div class="reports-head-mini-row"><span>Spring</span><strong><?= esc($cbmbQuarterData[$quarter]['spring']) ?></strong></div>
					<h3 style="margin-top:12px;">Additional Health Indicators</h3>
					<div class="reports-head-mini-row"><span>Houses Using Iodized Salt</span><strong><?= esc($cbmbQuarterData[$quarter]['housesIodizedSalt']) ?></strong></div>
					<div class="reports-head-mini-row"><span>Fully Immunized Children</span><strong><?= esc($cbmbQuarterData[$quarter]['fullyImmunized']) ?></strong></div>
					<div class="reports-head-mini-row"><span>Infant Deaths (0-12 mos)</span><strong><?= esc($cbmbQuarterData[$quarter]['infantDeaths']) ?></strong></div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ($activeTab === 'ageMasterlist'): ?>
		<section class="reports-head-card">
			<div class="reports-head-card-header">
				<div>
					<h2>Age Group / Masterlist Report</h2>
					<p>Per-age breakdown with summary by range</p>
				</div>
			</div>
			<div class="reports-head-table-wrap">
				<table class="reports-head-table">
					<thead>
						<tr>
							<th>Age</th>
							<th>F</th>
							<th>M</th>
							<th>Age Group</th>
							<th>F</th>
							<th>M</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($age = 0; $age < 30; $age++): ?>
							<?php
							$fCount = 0;
							$mCount = 0;
							foreach ($residents as $resident) {
								$residentAge = calc_age((string) $resident['birthday']);
								if ($residentAge === $age) {
									if ($resident['gender'] === 'F') {
										$fCount++;
									}
									if ($resident['gender'] === 'M') {
										$mCount++;
									}
								}
							}
							$summary = $summaryRows[$age] ?? null;
							?>
							<tr>
								<td><?= $age ?></td>
								<td><?= $fCount ?></td>
								<td><?= $mCount ?></td>
								<td><?= $summary ? esc($summary['label']) : '' ?></td>
								<td><?= $summary ? (int) $summary['f'] : '' ?></td>
								<td><?= $summary ? (int) $summary['m'] : '' ?></td>
								<td class="reports-head-total"><?= $summary ? (int) $summary['total'] : '' ?></td>
							</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			</div>
		</section>
	<?php endif; ?>

	<?php if ($activeTab === 'pregnant'): ?>
		<section class="reports-head-card">
			<div class="reports-head-card-header">
				<div>
					<h2>Pagsubaybay sa mga Buntis</h2>
					<p>Regional Safe Motherhood Program · Tuy, Batangas</p>
				</div>
			</div>
			<div class="reports-head-table-wrap">
				<table class="reports-head-table">
					<thead>
						<tr>
							<th>No.</th>
							<th>Full Name</th>
							<th>Age</th>
							<th>Address</th>
							<th>Contact</th>
							<th>LMP</th>
							<th>EDD</th>
							<th>1-12 wks</th>
							<th>13-20 wks</th>
							<th>21-26 wks</th>
							<th>27-30 wks</th>
							<th>31-34 wks</th>
							<th>35-36 wks</th>
							<th>37-38 wks</th>
							<th>39-40 wks</th>
							<th>Postnatal</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($pregnantResidents as $index => $resident): ?>
							<tr>
								<td><?= $index + 1 ?></td>
								<td><strong><?= esc($resident['surname']) ?>, <?= esc($resident['firstname']) ?> <?= esc($resident['middlename']) ?></strong></td>
								<td><?= calc_age((string) $resident['birthday']) ?></td>
								<td><?= esc($resident['purok']) ?>, Tuy, Batangas</td>
								<td><?= esc((string) ($resident['contactNo'] ?: '-')) ?></td>
								<td><?= esc((string) ($resident['lmp'] ?? '-')) ?></td>
								<td><?= esc((string) ($resident['edd'] ?? '-')) ?></td>
								<?php for ($wk = 0; $wk < 9; $wk++): ?>
									<td style="color:#94a3b8;">-</td>
								<?php endfor; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>
	<?php endif; ?>

	<?php if ($activeTab === 'pregnancyOutcome'): ?>
		<section class="reports-head-card">
			<div class="reports-head-card-header">
				<div>
					<h2>Kinalabasan ng Pagbubuntis (Pregnancy Outcomes)</h2>
					<p>Regional Safe Motherhood Program · Tuy, Batangas</p>
				</div>
			</div>
			<div class="reports-head-table-wrap">
				<table class="reports-head-table">
					<thead>
						<tr>
							<th>No.</th>
							<th>Petsa ng Pagtatala</th>
							<th>Buong Pangalan</th>
							<th>Live Birth Date</th>
							<th>Birth Weight</th>
							<th>Preterm Date</th>
							<th>Preterm Weight</th>
							<th>Stillbirth Date</th>
							<th>Abortion Date</th>
							<th>24 hrs</th>
							<th>3rd day</th>
							<th>7-14 day</th>
							<th>3rd week</th>
							<th>Maternal Death</th>
							<th>Infant Death</th>
							<th>Remarks</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>2-12-26</td>
							<td><strong>Capacia, Maricon Olivar</strong></td>
							<td>5-22-26</td>
							<td>3.2 kg</td>
							<td style="color:#94a3b8;">-</td>
							<td style="color:#94a3b8;">-</td>
							<td style="color:#94a3b8;">-</td>
							<td style="color:#94a3b8;">-</td>
							<td>5-22-26</td>
							<td>5-25-26</td>
							<td>6-2-26</td>
							<td style="color:#94a3b8;">-</td>
							<td style="color:#94a3b8;">-</td>
							<td style="color:#94a3b8;">-</td>
							<td>Healthy baby</td>
						</tr>
						<?php for ($i = 0; $i < 5; $i++): ?>
							<tr>
								<td><?= $i + 2 ?></td>
								<?php for ($c = 0; $c < 15; $c++): ?>
									<td style="color:#94a3b8;">-</td>
								<?php endfor; ?>
							</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			</div>
		</section>
	<?php endif; ?>
</div>
