<?php
session_start();
if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Contact & Registration Form</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <main class="container">
      <p class="eyebrow">PRACTICAL 7 · PHP</p>
      <h1>Contact & Registration Form</h1>
      <p class="muted">A simple form with server-side validation and file
        storage.</p>
    </main>
  </header>
  <main class="container layout">
    <section class="panel">
      <h2>Submit your details</h2>
      <p class="muted">Fields marked * are required.</p>
      <form action="process.php" method="POST">
        <input type="hidden" name="csrf_token"
          value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
        <label for="name">Full name *</label><input id="name" name="name"
          required maxlength="80" placeholder="Your full name">
        <label for="email">Email address *</label><input id="email" name="email"
          type="email" required maxlength="120" placeholder="you@example.com">
        <label for="phone">Mobile number *</label><input id="phone" name="phone"
          type="tel" required maxlength="15" placeholder="Mobile number">
        <label for="purpose">Purpose *</label><select id="purpose"
          name="purpose" required>
          <option value="">Choose one</option>
          <option>Registration</option>
          <option>General enquiry</option>
          <option>Feedback</option>
        </select>
        <label for="message">Message *</label><textarea id="message"
          name="message" rows="4" required minlength="10" maxlength="1000"
          placeholder="Write your message (10–1000 characters)"></textarea><button
          type="submit">Submit form</button>
      </form>
    </section>
    <aside>
      <section class="panel">
        <h2>What this demonstrates</h2>
        <ul>
          <li>POST form submission</li>
          <li>Server-side validation</li>
          <li>Input sanitization and safe output</li>
          <li>CSV file storage</li>
          <li>CSRF token validation</li>
          <li>Success and error messages</li>
        </ul>
      </section>
      <section class="panel">
        <h2>Stored submissions</h2>
        <p class="muted">Valid records are saved in
          <code>data/submissions.csv</code>.</p><a href="records.php">View saved
          records →</a>
      </section>
    </aside>
  </main>
  <footer class="container muted">PHP Form Processing · CSV storage</footer>
</body>

</html>