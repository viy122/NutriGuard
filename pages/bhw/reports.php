<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['user_id']) && !isset($_SESSION['user'])) {
    header('Location: pages/sign_in.php');
    exit;
}

$activeTab = $_GET['tab'] ?? 'garne';
$selectedYear = $_GET['year'] ?? '2026';
$selectedMonth = $_GET['month'] ?? 'February';

$years = ['2024', '2025', '2026'];
$months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December',
];

$garneSections = [
    [
        'title' => 'Maternal Care Program',
        'fields' => [
            '1.1 Buntis na ibinigay sa komadrona',
            '1.2 Buntis na na-follow-up ng komadrona',
            '1.3 Buntis na may plano sa panganganak',
            '2.1 Bilang ng bagong panganak',
            '2.2 Newborn screening count',
            '2.3 Nanganak sa bahay',
            '2.4 Nanganak sa clinic',
            '2.5 Nanganak sa hospital',
            '2.6 Nanganak na nag-postnatal check-up',
        ],
    ],
    [
        'title' => 'Child Care Program',
        'fields' => [
            '3.1 Nabakunahan (BCG)',
            '3.2 Nabakunahan (DPT/Pentavalent)',
            '3.3 Nabakunahan (OPV)',
            '3.4 Nabakunahan (Hepa B)',
            '3.5 Nabakunahan (Measles/MMR)',
            '4.1 Natimbang (0-59 buwan)',
            '4.2 Normal na timbang',
            '4.3 Underweight',
            '4.4 Severely underweight',
            '4.5 Nakatanggap ng Vitamin A',
        ],
    ],
    [
        'title' => 'Family Planning Program',
        'fields' => [
            '5.1 Bagong acceptor ng pills',
            '5.2 Bagong acceptor ng condom',
            '5.3 Bagong acceptor ng IUD',
            '5.4 Bagong acceptor ng injectable',
            '5.5 Bagong acceptor ng natural method',
        ],
    ],
    [
        'title' => 'Community Health And Sanitation',
        'fields' => [
            '6.1 Pamilyang may toilet',
            '6.2 Pamilyang may malinis na inuming tubig',
            '6.3 Bahay na may maayos na pagtatapon ng basura',
            '7.1 Health education sessions',
            '7.2 Kalahok sa health education sessions',
            '7.3 Home visits',
        ],
    ],
];

function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function field_name(string $label): string
{
    return preg_replace('/[^a-z0-9]+/i', '_', strtolower($label));
}

$baseUrl = 'layout.php?page=reports';
$queryBase = $baseUrl . '&year=' . urlencode($selectedYear) . '&month=' . urlencode($selectedMonth);
$userName = trim((string) ($_SESSION['name'] ?? 'BHW User'));
?>

<style>
.reports-page { padding: 24px; }
.reports-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.reports-head { margin-bottom: 14px; padding: 20px; }
.reports-head h1 { margin: 0 0 4px; font-size: 24px; color: #0f172a; }
.reports-head p { margin: 0; color: #64748b; font-size: 14px; }

.reports-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
.reports-tab {
    text-decoration: none;
    padding: 9px 14px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    background: #fff;
}
.reports-tab:hover { background: #f8fafc; }
.reports-tab.active { background: #ecfeff; color: #0e7490; border-color: #67e8f9; }

.reports-form-head {
    padding: 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
}
.reports-form-head h2 { margin: 0 0 4px; font-size: 18px; color: #0f172a; }
.reports-form-head p { margin: 0; color: #64748b; font-size: 12px; }
.reports-filters { display: flex; gap: 8px; }
.reports-select {
    padding: 7px 10px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    background: #fff;
    color: #334155;
}

.reports-section {
    margin-bottom: 16px;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 14px;
}
.reports-section h3 {
    margin: 0 0 10px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #0e7490;
}

.reports-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
}
.reports-row:last-child { border-bottom: 0; }
.reports-row label { font-size: 14px; color: #334155; }
.reports-row input {
    width: 90px;
    padding: 6px 8px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    text-align: center;
}

.reports-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    padding: 16px 20px;
    border-top: 1px solid #e2e8f0;
}
.reports-btn {
    border: 0;
    border-radius: 10px;
    padding: 8px 14px;
    font-weight: 600;
    cursor: pointer;
}
.reports-btn.primary { color: #fff; background: linear-gradient(135deg, #06b6d4, #0d9488); }
.reports-btn.muted { color: #334155; background: #f1f5f9; }
</style>

<div class="reports-page">
    <div class="reports-card reports-head">
        <h1>BHW Reports</h1>
        <p>Submit your monthly and quarterly reports · <?= esc($userName) ?></p>
    </div>

    <div class="reports-tabs">
        <a class="reports-tab <?= $activeTab === 'garne' ? 'active' : '' ?>" href="<?= esc($queryBase . '&tab=garne') ?>">Submit GARNE Report</a>
        <a class="reports-tab <?= $activeTab === 'cbmb' ? 'active' : '' ?>" href="<?= esc($queryBase . '&tab=cbmb') ?>">Submit CBMB</a>
        <a class="reports-tab <?= $activeTab === 'philpen' ? 'active' : '' ?>" href="<?= esc($queryBase . '&tab=philpen') ?>">PhilPEN Assessment</a>
        <a class="reports-tab <?= $activeTab === 'masterlist' ? 'active' : '' ?>" href="<?= esc($queryBase . '&tab=masterlist') ?>">Age Group Masterlist</a>
    </div>

    <?php if ($activeTab === 'garne'): ?>
        <form method="post" action="<?= esc($queryBase . '&tab=garne&submitted=1') ?>" class="reports-card">
            <div class="reports-form-head">
                <div>
                    <h2>BHW Activities Monthly Report</h2>
                    <p>PROGRAM/PROYEKTO AT MGA GAWAIN NG REG/ACCREDITED BHW</p>
                </div>
                <div class="reports-filters">
                    <select name="year" onchange="this.form.submit()" class="reports-select">
                        <?php foreach ($years as $year): ?>
                            <option value="<?= esc($year) ?>" <?= $selectedYear === $year ? 'selected' : '' ?>><?= esc($year) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="month" onchange="this.form.submit()" class="reports-select">
                        <?php foreach ($months as $month): ?>
                            <option value="<?= esc($month) ?>" <?= $selectedMonth === $month ? 'selected' : '' ?>><?= esc($month) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="padding: 16px 20px;">
                <?php foreach ($garneSections as $section): ?>
                    <div class="reports-section">
                        <h3><?= esc($section['title']) ?></h3>
                        <?php foreach ($section['fields'] as $field): ?>
                            <?php $fieldName = field_name($field); ?>
                            <div class="reports-row">
                                <label for="<?= esc($fieldName) ?>"><?= esc($field) ?></label>
                                <input id="<?= esc($fieldName) ?>" name="<?= esc($fieldName) ?>" type="number" min="0" value="<?= isset($_POST[$fieldName]) ? (int) $_POST[$fieldName] : 0 ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="reports-actions">
                <a class="reports-btn muted" href="<?= esc($queryBase . '&tab=garne') ?>" style="text-decoration: none;">Clear</a>
                <button class="reports-btn primary" type="submit">Submit Report</button>
            </div>
        </form>
    <?php else: ?>
        <div class="reports-card" style="padding: 36px; text-align: center; color: #64748b;">
            <h3 style="margin: 0 0 8px; color: #334155; font-size: 18px;"><?= esc(strtoupper($activeTab)) ?> Tab</h3>
            <p style="margin: 0;">This section is ready for your next form implementation.</p>
        </div>
    <?php endif; ?>
</div>
