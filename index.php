<?php
// NutriGuard Index Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NutriGuard - Predictive Community Health Monitoring</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            cyan: { 50:'#ecfeff',100:'#cffafe',500:'#06b6d4',600:'#0891b2',700:'#0e7490' },
            teal: { 600:'#0d9488',700:'#0f766e' }
          }
        }
      }
    }
  </script>
  <style>
    .gradient-text {
      background: linear-gradient(to right, #0891b2, #0d9488);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .gradient-bg { background: linear-gradient(to right, #06b6d4, #0d9488); }
    .gradient-btn { background: linear-gradient(to right, #06b6d4, #0d9488); }
    .gradient-btn:hover { background: linear-gradient(to right, #0891b2, #0f766e); }
    .gradient-icon { background: linear-gradient(135deg, #06b6d4, #0d9488); }
  </style>
</head>
<body class="bg-white text-gray-900 font-sans">

<!-- Navigation -->
<nav class="sticky top-0 z-50 bg-white border-b border-gray-200">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center gap-2">
      <div class="w-8 h-8 gradient-icon rounded-full flex items-center justify-center">
        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
        </svg>
      </div>
      <span class="text-xl font-semibold">
        <span class="text-gray-900">NUTRI</span><span class="gradient-text"> GUARD</span>
      </span>
    </div>
    <!-- Links -->
    <div class="hidden md:flex items-center gap-8">
      <a href="#features" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">Features</a>
      <a href="#how-it-works" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">How It Works</a>
      <a href="#impact" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">Impact</a>
      <a href="#about" class="text-gray-600 hover:text-gray-900 transition-colors text-sm">About</a>
      <a href="pages/sign_up.php" class="text-gray-600 hover:text-gray-900 transition-colors text-sm px-4 py-2">Sign In</a>
      <a href="pages/sign_in.php" class="gradient-btn text-white text-sm px-4 py-2 rounded-lg shadow-md transition-all">Get Started</a>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="py-20 px-6 bg-gradient-to-br from-gray-50 to-white">
  <div class="max-w-6xl mx-auto text-center">
    <div class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-50 rounded-full mb-6">
      <svg class="w-4 h-4 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6.75v6.75"/>
      </svg>
      <span class="text-sm text-cyan-700">Predictive Community Health Monitoring</span>
    </div>

    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
      Protecting Communities<br>
      <span class="gradient-text">One Health Record</span> at a Time
    </h1>

    <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
      NUTRI-GUARD empowers Barangay Health Workers with predictive analytics,
      automated risk scoring, and real-time dashboards to detect malnutrition
      early and safeguard community health.
    </p>

    <div class="flex items-center justify-center gap-4 mb-16">
      <a href="pages/sign_in.php" class="gradient-btn text-white px-8 py-4 rounded-lg text-lg font-medium shadow-lg transition-all">Get Started →</a>
      <a href="#features" class="border-2 border-gray-300 hover:border-gray-400 text-gray-700 px-8 py-4 rounded-lg text-lg font-medium transition-all">ⓘ Learn More</a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
      <?php
        $stats = [
          ['20%', 'Malnutrition Reduction'],
          ['50%', 'Faster Reporting'],
          ['30%', 'Fewer Missed Follow-ups'],
        ];
        foreach ($stats as $s): ?>
        <div>
          <div class="text-5xl font-bold gradient-text mb-2"><?= $s[0] ?></div>
          <div class="text-gray-600"><?= $s[1] ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Features -->
<section id="features" class="py-20 px-6 bg-white">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-16">
      <div class="text-sm text-cyan-600 uppercase tracking-widest mb-2">Features</div>
      <h2 class="text-4xl font-bold mb-4">Everything Health Workers Need</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Built specifically for BHWs and BNS to streamline community health monitoring from data entry to decision-making.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php
        $features = [
          [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/>',
            'title' => 'Centralized Health Records',
            'desc'  => 'Digitize and unify resident demographic, nutritional, and health data in one secure platform.',
          ],
          [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zm6-4.5C9 8.004 9.504 7.5 10.125 7.5h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019 19.875V8.625zm6-4.5c0-.621.504-1.125 1.125-1.125h2.25C21.496 3 22 3.504 22 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
            'title' => 'Predictive Risk Scoring',
            'desc'  => 'Automatically classify nutritional status and flag at-risk children using predictive analytics.',
          ],
          [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>',
            'title' => 'Purok-Level Heatmaps',
            'desc'  => 'Visualize health risk distribution across zones to prioritize interventions where they matter most.',
          ],
          [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
            'title' => 'Automated Report Generation',
            'desc'  => 'Generate municipal health reports instantly—no more manual spreadsheets and hand-compiled data.',
          ],
          [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>',
            'title' => 'Follow-Up Alerts',
            'desc'  => 'Automated reminders ensure no at-risk household is overlooked, reducing missed follow-ups by 30%.',
          ],
          [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>',
            'title' => 'Role-Based Access Control',
            'desc'  => 'Secure, role-specific access for Admins, BNS, and BHWs with full activity audit logging.',
          ],
        ];
        foreach ($features as $f): ?>
        <div class="p-8 bg-white border border-gray-200 rounded-2xl hover:shadow-xl transition-shadow">
          <div class="w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <?= $f['icon'] ?>
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3"><?= htmlspecialchars($f['title']) ?></h3>
          <p class="text-gray-600"><?= htmlspecialchars($f['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- How It Works -->
<section id="how-it-works" class="py-20 px-6 bg-gradient-to-br from-gray-50 to-white">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-16">
      <div class="text-sm text-cyan-600 uppercase tracking-widest mb-2">How It Works</div>
      <h2 class="text-4xl font-bold mb-4">From Data to Action in Four Steps</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <?php
        $steps = [
          ['STEP 01', 'Record Health Data',    'BHWs and BNS input resident demographic and nutritional data through an intuitive web interface.',       '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>'],
          ['STEP 02', 'Analyze & Score Risks', 'The system automatically classifies nutritional status and generates predictive risk scores for children.', '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6.75v6.75"/>'],
          ['STEP 03', 'Visualize Insights',    'Interactive dashboards and purok-level heatmaps reveal health trends and high-risk zones at a glance.',   '<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>'],
          ['STEP 04', 'Act on Alerts',         'Automated follow-up reminders and generated reports drive timely interventions and streamlined reporting.',  '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>'],
        ];
        foreach ($steps as $s): ?>
        <div class="text-center">
          <div class="w-20 h-20 gradient-icon rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
            <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <?= $s[3] ?>
            </svg>
          </div>
          <div class="text-sm text-cyan-600 uppercase tracking-widest mb-2"><?= $s[0] ?></div>
          <h3 class="text-xl font-semibold mb-3"><?= htmlspecialchars($s[1]) ?></h3>
          <p class="text-gray-600"><?= htmlspecialchars($s[2]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Impact -->
<section id="impact" class="py-20 px-6 gradient-bg text-white text-center">
  <div class="max-w-7xl mx-auto">
    <div class="text-sm uppercase tracking-widest mb-2 text-white/90">Measurable Impact</div>
    <h2 class="text-4xl font-bold mb-4">Real Results for Real Communities</h2>
    <p class="text-xl text-white/90 max-w-3xl mx-auto mb-12">
      NUTRI-GUARD is designed to achieve tangible health outcomes for Barangay Magahis.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <?php
        $impacts = [
          ['20%', 'Reduction in child malnutrition cases within 12 months'],
          ['50%', 'Faster health report preparation'],
          ['40%', 'Faster identification of high-risk households'],
          ['30%', 'Fewer missed follow-up visits'],
        ];
        foreach ($impacts as $i): ?>
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
          <div class="text-5xl font-bold mb-3"><?= $i[0] ?></div>
          <p class="text-white/90"><?= htmlspecialchars($i[1]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- About -->
<section id="about" class="py-20 px-6 bg-white text-center">
  <div class="max-w-4xl mx-auto">
    <div class="w-16 h-16 gradient-icon rounded-full flex items-center justify-center mx-auto mb-6">
      <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
      </svg>
    </div>
    <h2 class="text-4xl font-bold mb-6">Built for Barangay Magahis</h2>
    <p class="text-lg text-gray-600 mb-4 leading-relaxed">
      NUTRI-GUARD is developed for the Barangay Magahis Health Center in Tuy, Batangas.
      It empowers Barangay Health Workers (BHWs) and Barangay Nutrition Scholars (BNS) to
      transition from paper-based record-keeping to a modern, data-driven health monitoring
      platform—enabling early detection of malnutrition and more effective community healthcare delivery.
    </p>
    <p class="text-sm text-gray-400">
      Created by Laguras, Cables, Hernando &amp; Leynes under Asst. Prof. Benjie R. Samonte.
    </p>
  </div>
</section>

<!-- Footer -->
<footer class="py-8 px-6 border-t border-gray-200 bg-gray-50">
  <div class="max-w-7xl mx-auto flex items-center justify-between flex-wrap gap-2">
    <div class="flex items-center gap-2">
      <div class="w-6 h-6 gradient-icon rounded-full flex items-center justify-center">
        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
        </svg>
      </div>
      <span class="text-sm font-medium">
        <span class="text-gray-900">NUTRI</span><span class="gradient-text"> GUARD</span>
      </span>
    </div>
    <span class="text-sm text-gray-600">
      &copy; <?= date('Y') ?> NUTRI-GUARD. Barangay Magahis Health Center, Tuy, Batangas.
    </span>
  </div>
</footer>

</body>
</html>