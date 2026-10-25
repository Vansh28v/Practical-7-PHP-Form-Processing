<?php
session_start();
function respond(
    string $title,
    array $messages,
    bool $success = false,
    int $status = 200,
): never {
    http_response_code($status);
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>' .
        htmlspecialchars($title, ENT_QUOTES, "UTF-8") .
        '</title><link rel="stylesheet" href="css/style.css"></head><body><main class="container result"><section class="panel"><h1>' .
        htmlspecialchars($title, ENT_QUOTES, "UTF-8") .
        "</h1><ul>";
    foreach ($messages as $message) {
        echo "<li>" . htmlspecialchars($message, ENT_QUOTES, "UTF-8") . "</li>";
    }
    echo '</ul><p><a href="index.php">← Back to form</a></p>';
    if ($success) {
        echo '<p><a href="records.php">View saved records →</a></p>';
    }
    echo "</section></main></body></html>";
    exit();
}
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Allow: POST");
    respond(
        "Invalid request",
        ["Submit the form using the provided page."],
        false,
        405,
    );
}
$sent = $_POST["csrf_token"] ?? "";
$known = $_SESSION["csrf_token"] ?? "";
if (
    !is_string($sent) ||
    !is_string($known) ||
    $known === "" ||
    !hash_equals($known, $sent)
) {
    respond(
        "Request could not be verified",
        ["Refresh the form and try again."],
        false,
        403,
    );
}
$name = trim((string) ($_POST["name"] ?? ""));
$email = trim((string) ($_POST["email"] ?? ""));
$phone = trim((string) ($_POST["phone"] ?? ""));
$purpose = trim((string) ($_POST["purpose"] ?? ""));
$message = trim((string) ($_POST["message"] ?? ""));
$errors = [];
if (mb_strlen($name) < 2 || mb_strlen($name) > 80) {
    $errors[] = "Name must contain 2–80 characters.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 120) {
    $errors[] = "Enter a valid email address.";
}
if (!preg_match('/^[0-9+\-\s()]{7,15}$/', $phone)) {
    $errors[] = "Enter a valid phone number (7–15 characters).";
}
if (
    !in_array($purpose, ["Registration", "General enquiry", "Feedback"], true)
) {
    $errors[] = "Choose a valid purpose.";
}
if (mb_strlen($message) < 10 || mb_strlen($message) > 1000) {
    $errors[] = "Message must contain 10–1000 characters.";
}
if ($errors) {
    respond("Please correct these details", $errors, false, 422);
}
$name = preg_replace('/[\r\n\t]+/', " ", $name);
$phone = preg_replace("/\s+/", " ", $phone);
$purpose = preg_replace('/[\r\n\t]+/', " ", $purpose);
$dir = __DIR__ . "/data";
$path = $dir . "/submissions.csv";
if (!is_dir($dir) && !mkdir($dir, 0750, true) && !is_dir($dir)) {
    respond(
        "Storage error",
        ["Could not create the data directory."],
        false,
        500,
    );
}
$file = fopen($path, "ab");
if ($file === false) {
    respond(
        "Storage error",
        ["Could not open CSV file. Check folder permissions."],
        false,
        500,
    );
}
if (!flock($file, LOCK_EX)) {
    fclose($file);
    respond("Storage error", ["Could not lock the file safely."], false, 500);
}
$stat = fstat($file);
$ok = true;
if (($stat["size"] ?? 0) === 0) {
    $ok =
        fputcsv($file, [
            "Submitted At",
            "Name",
            "Email",
            "Phone",
            "Purpose",
            "Message",
        ]) !== false;
}
if ($ok) {
    $ok =
        fputcsv($file, [
            date("c"),
            $name,
            $email,
            $phone,
            $purpose,
            $message,
        ]) !== false;
}
fflush($file);
flock($file, LOCK_UN);
fclose($file);
if (!$ok) {
    respond(
        "Storage error",
        ["The submission could not be saved."],
        false,
        500,
    );
}
$_SESSION["csrf_token"] = bin2hex(random_bytes(32));
respond(
    "Submission successful",
    ["Your details were validated and saved to the CSV file."],
    true,
);

