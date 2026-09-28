<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Case Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; padding: 20px; }
        h2 { text-align: center; margin-bottom: 30px; }
        .section { margin-bottom: 15px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>

<h2>📝 Case Report</h2>

<div class="section"><span class="label">Case ID:</span> <?= esc($case['id']) ?></div>
<div class="section"><span class="label">Title:</span> <?= esc($case['title']) ?></div>
<div class="section"><span class="label">Region:</span> <?= esc($case['region']) ?></div>
<div class="section"><span class="label">Status:</span> <?= esc(ucfirst($case['status'])) ?></div>
<div class="section"><span class="label">Officer Assigned:</span> <?= esc($officerName) ?></div>
<div class="section"><span class="label">Description:</span> <?= esc($case['description']) ?></div>
<div class="section"><span class="label">Created At:</span> <?= date('Y-m-d H:i:s', strtotime($case['created_at'])) ?></div>

</body>
</html>
