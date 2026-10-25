<?php
$filePath = __DIR__ . "/data/submissions.csv";
$rows = [];
$error = "";
if (is_file($filePath) && is_readable($filePath)) {
    $file = fopen($filePath, "rb");
    if ($file !== false) {
        if (flock($file, LOCK_SH)) {
            while (($row = fgetcsv($file)) !== false) {
                $rows[] = $row;
            }
            flock($file, LOCK_UN);
        } else {
            $error = "Could not lock the file for reading.";
        }
        fclose($file);
    } else {
        $error = "Could not open the records file.";
    }
}
if ($rows && ($rows[0][0] ?? "") === "Submitted At") {
    array_shift($rows);
}
function h($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Saved Records</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <main class="container">
      <p class="eyebrow">PRACTICAL 7 · PHP</p>
      <h1>Saved submissions</h1>
      <p class="muted">Records read from the CSV file.</p>
    </main>
  </header>
  <main class="container records">
    <p><a href="index.php">← Back to form</a></p>
    <?php if ($error): ?><div class="notice error"><?= h(
    $error,
) ?></div><?php elseif (
    !$rows
): ?><div class="notice">No submissions saved yet. Submit the form to add the
      first record.</div><?php else: ?><p class="muted"><?= count(
    $rows,
) ?> saved record(s)</p>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Submitted at</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Purpose</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody><?php foreach (
     $rows
     as $row
 ): ?><tr><?php for ($i = 0; $i < 6; $i++): ?><td><?= h(
    $row[$i] ?? "",
) ?></td><?php endfor; ?></tr><?php endforeach; ?></tbody>
      </table>
    </div><?php endif; ?>
  </main>
</body>

</html>