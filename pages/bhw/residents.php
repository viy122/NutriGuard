<?php
// residents.php - Resident Profiles Page

// Sample resident data
$residents = [
    [
        "id" => "R-001",
        "name" => "Juan Dela Cruz Jr.",
        "age" => "3y",
        "sex" => "M",
        "purok" => "Purok 1",
        "status" => "Normal",
        "statusColor" => "status-normal",
        "lastAssessment" => "2026-03-01",
        "birthday" => "2023-01-15",
        "contactNo" => "09123456789",
        "civilStatus" => "Single",
        "birthplace" => "Tuy, Batangas",
        "philhealthNo" => "12-345678901-2",
        "occupation" => "N/A (Minor)",
        "weight" => "14.5",
        "height" => "95",
        "waist" => "N/A",
        "bmi" => "16.1",
        "familyPlanningMethod" => "N/A",
        "isPregnant" => false,
        "pregnancyInfo" => null,
        "formsAnswered" => [],
    ],
    [
        "id" => "R-002",
        "name" => "Ana Santos",
        "age" => "2y",
        "sex" => "F",
        "purok" => "Purok 1",
        "status" => "Underweight",
        "statusColor" => "status-underweight",
        "lastAssessment" => "2026-02-28",
        "birthday" => "2024-02-10",
        "contactNo" => "09234567890",
        "civilStatus" => "Single",
        "birthplace" => "Tuy, Batangas",
        "philhealthNo" => "12-345678902-3",
        "occupation" => "N/A (Minor)",
        "weight" => "10.2",
        "height" => "85",
        "waist" => "N/A",
        "bmi" => "14.1",
        "familyPlanningMethod" => "N/A",
        "isPregnant" => false,
        "pregnancyInfo" => null,
        "formsAnswered" => [],
    ],
    [
        "id" => "R-006",
        "name" => "Maricon Olivar Capacia",
        "age" => "32y",
        "sex" => "F",
        "purok" => "Purok 2",
        "status" => "Pregnant",
        "statusColor" => "status-pregnant",
        "lastAssessment" => "2026-03-10",
        "birthday" => "1993-04-12",
        "contactNo" => "09551593652",
        "civilStatus" => "Married",
        "birthplace" => "Magahis, Tuy, Batangas",
        "philhealthNo" => "12-345678906-7",
        "occupation" => "Housewife",
        "weight" => "62",
        "height" => "158",
        "waist" => "85",
        "bmi" => "24.8",
        "familyPlanningMethod" => "N/A (Currently Pregnant)",
        "isPregnant" => true,
        "pregnancyInfo" => [
            "lmp" => "2025-08-15",
            "edd" => "2026-05-22",
            "gravida" => "2",
            "para" => "1",
            "prenatalVisits" => [
                ["weeks" => "1-12",  "date" => "2025-10-05"],
                ["weeks" => "13-20", "date" => "2025-12-04"],
                ["weeks" => "21-26", "date" => "2026-01-15"],
                ["weeks" => "27-30", "date" => "2026-02-12"],
                ["weeks" => "31-34", "date" => "2026-03-02"],
            ],
        ],
        "formsAnswered" => [
            ["name" => "PhilPEN Assessment", "date" => "2026-02-15", "status" => "Completed"],
            ["name" => "Prenatal Check-up",  "date" => "2026-03-02", "status" => "Completed"],
        ],
    ],
    [
        "id" => "R-007",
        "name" => "Elena Vega Hernandez",
        "age" => "36y",
        "sex" => "F",
        "purok" => "Purok 1",
        "status" => "Pregnant",
        "statusColor" => "status-pregnant",
        "lastAssessment" => "2026-03-08",
        "birthday" => "1988-09-01",
        "contactNo" => "09678901234",
        "civilStatus" => "Married",
        "birthplace" => "Tuy, Batangas",
        "philhealthNo" => "12-345678907-8",
        "occupation" => "Teacher",
        "weight" => "68",
        "height" => "162",
        "waist" => "90",
        "bmi" => "25.9",
        "familyPlanningMethod" => "N/A (Currently Pregnant)",
        "isPregnant" => true,
        "pregnancyInfo" => [
            "lmp" => "2025-10-05",
            "edd" => "2026-07-12",
            "gravida" => "3",
            "para" => "2",
            "prenatalVisits" => [
                ["weeks" => "1-12",  "date" => "2025-11-20"],
                ["weeks" => "13-20", "date" => "2026-01-05"],
            ],
        ],
        "formsAnswered" => [
            ["name" => "PhilPEN Assessment", "date" => "2026-01-28", "status" => "Completed"],
            ["name" => "Prenatal Check-up",  "date" => "2026-01-05", "status" => "Completed"],
        ],
    ],
    [
        "id" => "R-008",
        "name" => "Maria Garcia Lopez",
        "age" => "28y",
        "sex" => "F",
        "purok" => "Purok 3",
        "status" => "Normal",
        "statusColor" => "status-normal",
        "lastAssessment" => "2026-03-05",
        "birthday" => "1998-05-20",
        "contactNo" => "09345678901",
        "civilStatus" => "Married",
        "birthplace" => "Tuy, Batangas",
        "philhealthNo" => "12-345678908-9",
        "occupation" => "Store Owner",
        "weight" => "58",
        "height" => "160",
        "waist" => "75",
        "bmi" => "22.7",
        "familyPlanningMethod" => "Pills",
        "isPregnant" => false,
        "pregnancyInfo" => null,
        "formsAnswered" => [
            ["name" => "PhilPEN Assessment",  "date" => "2026-03-05", "status" => "Completed"],
            ["name" => "Nutrition Assessment", "date" => "2026-02-20", "status" => "Completed"],
        ],
    ],
];

// --- Filtering ---
$searchTerm  = isset($_GET['search']) ? trim($_GET['search']) : '';
$purokFilter = isset($_GET['purok'])  ? trim($_GET['purok'])  : 'all';

$filteredResidents = array_filter($residents, function($r) use ($searchTerm, $purokFilter) {
    $matchesSearch = $searchTerm === ''
        || stripos($r['name'], $searchTerm) !== false
        || stripos($r['id'],   $searchTerm) !== false;
    $matchesPurok  = $purokFilter === 'all' || $r['purok'] === $purokFilter;
    return $matchesSearch && $matchesPurok;
});

// --- Detail modal data via GET param ---
$selectedResident = null;
if (isset($_GET['view'])) {
    $viewId = $_GET['view'];
    foreach ($residents as $r) {
        if ($r['id'] === $viewId) {
            $selectedResident = $r;
            break;
        }
    }
}

// Helper: prenatal pending rows
$allWeekRanges = ["1-12","13-20","21-26","27-30","31-34","35-36","37-38","39-40"];

function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$routeBase = 'layout.php?page=residents';
?>
<style>
  /* ── Scoped Base (avoid affecting shared sidebar/layout) ── */
  .residents-page,
  .residents-page *,
  .residents-page *::before,
  .residents-page *::after {
    box-sizing: border-box;
  }

  .residents-page {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    background: linear-gradient(135deg, #f0fdfa 0%, #f1f5f9 100%);
    min-height: 100vh;
    color: #1e293b;
    padding: 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  /* ── Header Banner ── */
  .header-banner {
    background: linear-gradient(135deg, #06b6d4 0%, #0d9488 100%);
    color: #fff;
    border-radius: 1rem;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    box-shadow: 0 10px 30px rgba(6,182,212,.3);
  }
  .header-banner h1 { font-size: 1.75rem; font-weight: 700; margin-bottom: .25rem; }
  .header-banner p  { font-size: .875rem; opacity: .9; }
  .btn-add {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #fff; color: #0891b2;
    border: none; border-radius: .6rem;
    padding: .55rem 1.1rem; font-size: .875rem; font-weight: 600;
    cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,.15);
    text-decoration: none; transition: background .15s;
  }
  .btn-add:hover { background: #e0f2fe; }
  .btn-add svg { width: 16px; height: 16px; }

  /* ── Filters ── */
  .filters { display: flex; gap: 1rem; }
  .search-wrap { position: relative; flex: 1; }
  .search-wrap svg { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94a3b8; }
  .search-wrap input {
    width: 100%; padding: .7rem .75rem .7rem 2.4rem;
    border: none; border-radius: .75rem;
    background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,.08);
    font-size: .9rem; color: #1e293b; outline: none;
  }
  .search-wrap input:focus { box-shadow: 0 0 0 2px #06b6d4; }
  .filter-select {
    width: 200px; padding: .7rem .9rem;
    border: none; border-radius: .75rem;
    background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,.08);
    font-size: .9rem; color: #1e293b; cursor: pointer; outline: none;
  }
  .filter-select:focus { box-shadow: 0 0 0 2px #06b6d4; }

  /* ── Table Card ── */
  .table-card { background: #fff; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,.07); overflow: hidden; }
  .table-wrap { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; }
  thead { background: linear-gradient(90deg, #f8fafc, #f1f5f9); }
  th { padding: 1rem; text-align: left; font-size: .8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: .05em; }
  td { padding: 1rem; font-size: .875rem; color: #475569; border-bottom: 1px solid #f1f5f9; }
  td.name-cell { font-weight: 600; color: #1e293b; }
  tbody tr:hover { background: linear-gradient(90deg, #f8fafc, #fff); }
  tbody tr:last-child td { border-bottom: none; }

  /* ── Status Badges ── */
  .badge {
    display: inline-block; padding: .25rem .7rem;
    border-radius: 9999px; font-size: .75rem; font-weight: 600;
  }
  .status-normal      { background: #dcfce7; color: #15803d; }
  .status-underweight { background: #fef9c3; color: #a16207; }
  .status-pregnant    { background: #fce7f3; color: #be185d; }
  .status-overweight  { background: #fee2e2; color: #dc2626; }
  .badge-completed    { background: #dcfce7; color: #15803d; }
  .badge-pending      { background: #f1f5f9; color: #64748b; }

  /* ── Action Buttons ── */
  .actions { display: flex; gap: .4rem; }
  .btn-icon {
    width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
    border: none; background: transparent; border-radius: .5rem; cursor: pointer; transition: background .15s;
    text-decoration: none;
  }
  .btn-icon.view:hover  { background: #eff6ff; }
  .btn-icon.view svg    { color: #64748b; }
  .btn-icon.view:hover svg { color: #2563eb; }
  .btn-icon.edit:hover  { background: #f0fdf4; }
  .btn-icon.edit svg    { color: #64748b; }
  .btn-icon.edit:hover svg { color: #16a34a; }
  .btn-icon svg { width: 16px; height: 16px; }

  /* ── Pagination Bar ── */
  .pagination {
    display: flex; justify-content: space-between; align-items: center;
    padding: .9rem 1rem; border-top: 1px solid #f1f5f9; background: #f8fafc;
  }
  .pagination span { font-size: .85rem; color: #64748b; font-weight: 500; }
  .pagination-btns { display: flex; gap: .4rem; }
  .btn-page {
    padding: .35rem .75rem; border: 1px solid #e2e8f0; background: #fff;
    border-radius: .5rem; font-size: .8rem; cursor: pointer; color: #64748b;
    box-shadow: 0 1px 3px rgba(0,0,0,.06);
  }
  .btn-page:disabled { opacity: .45; cursor: not-allowed; }

  /* ── Modal Overlay ── */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15,23,42,.5); backdrop-filter: blur(4px);
    z-index: 1000; align-items: center; justify-content: center;
    padding: 1rem;
  }
  .modal-overlay.active { display: flex; }
  .modal {
    background: #fff; border-radius: 1.25rem;
    max-width: 860px; width: 100%; max-height: 90vh;
    overflow-y: auto; box-shadow: 0 25px 60px rgba(0,0,0,.25);
    padding: 1.75rem; position: relative;
  }
  .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
  .modal-header h2 { font-size: 1.25rem; font-weight: 700; color: #0e7490; }
  .btn-close {
    width: 32px; height: 32px; border: none; background: #f1f5f9;
    border-radius: .5rem; cursor: pointer; font-size: 1.1rem; color: #64748b;
    display: flex; align-items: center; justify-content: center;
  }
  .btn-close:hover { background: #fee2e2; color: #dc2626; }

  /* ── Info Sections ── */
  .info-section { border-radius: .75rem; padding: 1.25rem; margin-bottom: 1rem; }
  .info-section.personal  { background: linear-gradient(135deg, #ecfeff, #f0fdfa); border: 1px solid #a5f3fc; }
  .info-section.health    { background: linear-gradient(135deg, #eff6ff, #eef2ff); border: 1px solid #bfdbfe; }
  .info-section.pregnancy { background: linear-gradient(135deg, #fdf2f8, #fff1f2); border: 1px solid #fbcfe8; }
  .info-section.forms     { background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 1px solid #e2e8f0; }
  .section-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: 1rem; font-weight: 700; margin-bottom: 1rem;
  }
  .section-title svg { width: 18px; height: 18px; }
  .personal  .section-title { color: #155e75; }
  .health    .section-title { color: #1e40af; }
  .pregnancy .section-title { color: #9d174d; }
  .forms     .section-title { color: #374151; }
  .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
  .info-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
  .info-item label {
    display: block; font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; color: #94a3b8; margin-bottom: .2rem;
  }
  .info-item p { font-size: .875rem; font-weight: 500; color: #1e293b; }
  .prenatal-table { width: 100%; border-collapse: collapse; font-size: .8rem; margin-top: .75rem; }
  .prenatal-table thead { background: #fce7f3; }
  .prenatal-table th { padding: .5rem .75rem; text-align: left; font-weight: 700; color: #9d174d; }
  .prenatal-table td { padding: .5rem .75rem; border-bottom: 1px solid #fce7f3; }

  @media (max-width: 640px) {
    .header-banner { flex-direction: column; gap: 1rem; }
    .filters { flex-direction: column; }
    .filter-select { width: 100%; }
    .info-grid, .info-grid-3 { grid-template-columns: 1fr; }
  }
</style>
<div class="residents-page">

  <!-- Header Banner -->
  <div class="header-banner">
    <div>
      <h1>Resident Profiles</h1>
      <p>Manage demographics and health records</p>
    </div>
    <a href="add_resident.php" class="btn-add">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Resident
    </a>
  </div>

  <!-- Filters -->
  <form method="GET" action="layout.php" class="filters" id="filterForm">
    <input type="hidden" name="page" value="residents" />
    <div class="search-wrap">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input
        type="text" name="search"
        placeholder="Search by name or ID..."
        value="<?= h($searchTerm) ?>"
        oninput="document.getElementById('filterForm').submit()"
      />
    </div>
    <select name="purok" class="filter-select" onchange="document.getElementById('filterForm').submit()">
      <option value="all"    <?= $purokFilter === 'all'     ? 'selected' : '' ?>>All Puroks</option>
      <option value="Purok 1" <?= $purokFilter === 'Purok 1' ? 'selected' : '' ?>>Purok 1</option>
      <option value="Purok 2" <?= $purokFilter === 'Purok 2' ? 'selected' : '' ?>>Purok 2</option>
      <option value="Purok 3" <?= $purokFilter === 'Purok 3' ? 'selected' : '' ?>>Purok 3</option>
      <option value="Purok 4" <?= $purokFilter === 'Purok 4' ? 'selected' : '' ?>>Purok 4</option>
      <option value="Purok 5" <?= $purokFilter === 'Purok 5' ? 'selected' : '' ?>>Purok 5</option>
    </select>
  </form>

  <!-- Table -->
  <div class="table-card">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age / Sex</th>
            <th>Purok</th>
            <th>Status</th>
            <th>Last Assessment</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($filteredResidents)): ?>
          <tr>
            <td colspan="7" style="text-align:center;padding:2rem;color:#94a3b8;">No residents found.</td>
          </tr>
          <?php else: ?>
          <?php foreach ($filteredResidents as $r): ?>
          <tr>
            <td><?= h($r['id']) ?></td>
            <td class="name-cell"><?= h($r['name']) ?></td>
            <td><?= h($r['age']) ?> / <?= h($r['sex']) ?></td>
            <td><?= h($r['purok']) ?></td>
            <td><span class="badge <?= h($r['statusColor']) ?>"><?= h($r['status']) ?></span></td>
            <td><?= h($r['lastAssessment']) ?></td>
            <td>
              <div class="actions">
                <!-- View: opens modal via query param -->
                 <a href="<?= h($routeBase) ?>&view=<?= urlencode($r['id']) ?>&search=<?= urlencode($searchTerm) ?>&purok=<?= urlencode($purokFilter) ?>"
                   class="btn-icon view" title="View details">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                <!-- Edit: link to edit page -->
                <a href="edit_resident.php?id=<?= urlencode($r['id']) ?>" class="btn-icon edit" title="Edit resident">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <!-- Pagination -->
    <div class="pagination">
      <span>Showing <?= count($filteredResidents) ?> of <?= count($residents) ?> residents</span>
      <div class="pagination-btns">
        <button class="btn-page" disabled>&#8249; Prev</button>
        <button class="btn-page" disabled>Next &#8250;</button>
      </div>
    </div>
  </div>

</div><!-- /.residents-page -->


<!-- ── Detail Modal ── -->
<?php if ($selectedResident): $r = $selectedResident; ?>
<div class="modal-overlay active" id="detailModal">
  <div class="modal">
    <div class="modal-header">
      <h2>Complete Resident Information</h2>
      <a href="<?= h($routeBase) ?>&search=<?= urlencode($searchTerm) ?>&purok=<?= urlencode($purokFilter) ?>" class="btn-close" title="Close">&times;</a>
    </div>

    <!-- Personal Information -->
    <div class="info-section personal">
      <div class="section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Personal Information
      </div>
      <div class="info-grid">
        <div class="info-item"><label>Full Name</label>       <p><?= h($r['name']) ?></p></div>
        <div class="info-item"><label>Resident ID</label>     <p><?= h($r['id']) ?></p></div>
        <div class="info-item"><label>Birthday</label>        <p><?= h($r['birthday']) ?></p></div>
        <div class="info-item"><label>Age / Sex</label>       <p><?= h($r['age']) ?> / <?= h($r['sex']) ?></p></div>
        <div class="info-item"><label>Civil Status</label>    <p><?= h($r['civilStatus']) ?></p></div>
        <div class="info-item"><label>Birthplace</label>      <p><?= h($r['birthplace']) ?></p></div>
        <div class="info-item"><label>📞 Contact Number</label><p><?= h($r['contactNo']) ?></p></div>
        <div class="info-item"><label>📍 Address / Purok</label><p><?= h($r['purok']) ?>, Tuy, Batangas</p></div>
        <div class="info-item"><label>PhilHealth No.</label>  <p><?= h($r['philhealthNo']) ?></p></div>
        <div class="info-item"><label>💼 Occupation</label>   <p><?= h($r['occupation']) ?></p></div>
      </div>
    </div>

    <!-- Health Metrics -->
    <div class="info-section health">
      <div class="section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Health Metrics
      </div>
      <div class="info-grid-3">
        <div class="info-item"><label>Weight</label>           <p><?= h($r['weight']) ?> kg</p></div>
        <div class="info-item"><label>Height</label>           <p><?= h($r['height']) ?> cm</p></div>
        <div class="info-item"><label>Waist</label>            <p><?= h($r['waist']) ?> cm</p></div>
        <div class="info-item"><label>BMI</label>              <p><?= h($r['bmi']) ?></p></div>
        <div class="info-item"><label>Nutritional Status</label>
          <p><span class="badge <?= h($r['statusColor']) ?>"><?= h($r['status']) ?></span></p></div>
        <div class="info-item"><label>Last Assessment</label>  <p><?= h($r['lastAssessment']) ?></p></div>
      </div>
      <div class="info-item" style="margin-top:1rem">
        <label>❤️ Family Planning Method</label>
        <p><?= h($r['familyPlanningMethod']) ?></p>
      </div>
    </div>

    <!-- Pregnancy Information -->
    <?php if ($r['isPregnant'] && $r['pregnancyInfo']): $p = $r['pregnancyInfo']; ?>
    <div class="info-section pregnancy">
      <div class="section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg>
        Pregnancy Information
      </div>
      <div class="info-grid" style="margin-bottom:1rem">
        <div class="info-item"><label>Last Menstrual Period (LMP)</label><p><?= h($p['lmp']) ?></p></div>
        <div class="info-item"><label>Expected Delivery Date (EDD)</label><p><?= h($p['edd']) ?></p></div>
        <div class="info-item"><label>Gravida</label><p>G<?= h($p['gravida']) ?></p></div>
        <div class="info-item"><label>Para</label>   <p>P<?= h($p['para']) ?></p></div>
      </div>
      <label style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;">
        Prenatal Consultation Schedule
      </label>
      <?php
        // Build a lookup of completed visits
        $completedMap = [];
        foreach ($p['prenatalVisits'] as $v) {
            $completedMap[$v['weeks']] = $v['date'];
        }
      ?>
      <table class="prenatal-table">
        <thead>
          <tr><th>Weeks</th><th>Date of Visit</th><th>Status</th></tr>
        </thead>
        <tbody>
          <?php foreach ($allWeekRanges as $range): ?>
          <tr>
            <td><?= h($range) ?> weeks</td>
            <?php if (isset($completedMap[$range])): ?>
            <td><?= h($completedMap[$range]) ?></td>
            <td><span class="badge badge-completed">Completed</span></td>
            <?php else: ?>
            <td style="color:#94a3b8">—</td>
            <td><span class="badge badge-pending">Pending</span></td>
            <?php endif; ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>

    <!-- Forms Answered -->
    <?php if (!empty($r['formsAnswered'])): ?>
    <div class="info-section forms">
      <div class="section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Forms Answered
      </div>
      <div class="info-grid">
        <?php foreach ($r['formsAnswered'] as $form): ?>
        <div class="info-item">
          <label><?= h($form['name']) ?></label>
          <p><?= h($form['date']) ?> — <?= h($form['status']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div><!-- /.modal -->
</div><!-- /.modal-overlay -->
<?php endif; ?>