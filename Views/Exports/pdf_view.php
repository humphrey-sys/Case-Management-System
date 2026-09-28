<!DOCTYPE html>
<html>
<head>
    <title>Case Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2>Case Report</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Region</th>
                <th>Status</th>
                <th>Officer ID</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cases as $case): ?>
            <tr>
                <td><?= $case['id'] ?></td>
                <td><?= $case['title'] ?></td>
                <td><?= $case['region'] ?></td>
                <td><?= $case['status'] ?></td>
                <td><?= $case['officer_id'] ?? 'Unassigned' ?></td>
                <td><?= $case['created_at'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</body>
</html>
