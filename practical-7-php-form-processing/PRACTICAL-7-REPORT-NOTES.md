# Practical 7 — Report Notes

## Theory Logic
1. **HTML form:** Provides fields for name, email, phone, purpose, and message. It submits to `process.php` using POST.
2. **POST handling:** PHP checks `$_SERVER['REQUEST_METHOD']` and rejects non-POST requests.
3. **CSRF protection:** A random session token is placed in a hidden field and verified using `hash_equals()`.
4. **Server-side validation:** PHP checks required values, name/message lengths, email format, phone format, and the selected purpose. Browser validation alone is not trusted because it can be bypassed.
5. **Safe output:** Input is trimmed and normalized. User-provided values are escaped with `htmlspecialchars()` before they are displayed in HTML.
6. **CSV storage:** Valid records are appended using `fputcsv()`. `flock()` is used to reduce overlapping writes, and a header is written when the file is empty.
7. **Responses:** The processor displays success messages after saving and clear messages for invalid data or storage/request errors.
8. **Display records:** `records.php` reads the CSV and safely displays the stored values in a table.

## Analysis / Interpretation
### 1. Is the form submitted using POST?
Yes. The form specifies `method="POST"` and submits to `process.php`. The PHP script checks the request method and rejects other methods.

### 2. Are inputs validated and sanitized server side?
Yes. PHP validates name and message lengths, email format, phone format, and purpose selection. Inputs are trimmed and normalized. `htmlspecialchars()` escapes user-provided values when rendering HTML.

### 3. Is file writing handled safely?
Yes. The program uses `fputcsv()` to write CSV fields and `flock()` while writing to reduce conflicts between simultaneous submissions. It checks file-opening and writing errors. The data folder should have limited permissions and should not be publicly accessible.

### 4. Are success and error responses displayed clearly?
Yes. A successful submission displays confirmation and a link to saved records. Invalid input produces validation messages, while request, CSRF, and storage failures show appropriate error responses.

## Conclusion
In this practical, I implemented a PHP form that processes data using POST, validates and sanitizes input on the server, and stores valid submissions in a CSV file. I used `fputcsv()` and file locking for safer writing, added CSRF token validation, and displayed clear success and error messages. I also created a page to view stored records, improving my understanding of backend form processing and file-based storage.
