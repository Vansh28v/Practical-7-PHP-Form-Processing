# Practical 7: PHP Form Processing

A simple PHP form project demonstrating POST handling, server-side validation, safe output, CSV storage, and clear success/error responses.

## Features
- POST-based registration/contact form.
- Server-side validation for name, email, phone, purpose, and message.
- Trimming and normalization of user input.
- CSV storage using `fputcsv()` and `flock()`.
- Success, validation, request, and storage error messages.
- Page to view saved records with HTML escaping.
- CSRF token validation as an advanced extension.
- Responsive, restrained HTML/CSS design.

## Run with XAMPP
1. Extract this project.
2. Copy `practical-7-php-form-processing` into `C:\xampp\htdocs\`.
3. Start **Apache** in XAMPP Control Panel.
4. Open `http://localhost/practical-7-php-form-processing/`.
5. Submit the form and choose **View saved records**.

PHP must run through Apache. Do not open `index.php` directly or use a static Live Server extension.

## Storage
Valid submissions are appended to `data/submissions.csv`. The first record creates a header row. `flock()` reduces write conflicts, and `fputcsv()` correctly formats CSV values. The included `.htaccess` attempts to block direct data-file access on Apache. Ensure the PHP process has limited write access to `data/`.

## Test cases
| Test | Expected result |
|---|---|
| All valid fields | Success message and saved CSV record |
| Empty or one-character name | Name validation error |
| Invalid email such as `abc@` | Email validation error |
| Invalid phone such as `phone123` | Phone validation error |
| No purpose selected | Purpose validation error |
| Message under 10 characters | Message validation error |
| Open `process.php` directly | HTTP 405 response |
| Invalid or missing CSRF token | HTTP 403 response |
| Submit valid form and open records page | Record appears in table |
| HTML-like content in message | Displayed as text, not executed |

## Files
- `index.php` — form and CSRF token.
- `process.php` — POST handling, validation, and CSV writing.
- `records.php` — displays stored CSV records.
- `css/style.css` — page styling.
- `data/submissions.csv` — generated records.
- `data/.htaccess` — Apache access restriction for data folder.

This is a teaching project, not a production personal-data collection service. For real deployment, protect the records page with authentication and apply suitable retention and privacy controls.
