# Practical 7 — Test Cases

| No. | Test | Input/action | Expected result |
|---:|---|---|---|
| 1 | Valid submission | Enter valid values in all fields | Success response and CSV record |
| 2 | Empty name | Leave name blank | Name validation message |
| 3 | Short name | Enter one character | Name validation message |
| 4 | Invalid email | Enter `abc@` | Email validation message |
| 5 | Invalid phone | Enter `phone123` | Phone validation message |
| 6 | Missing purpose | Leave purpose unselected | Purpose validation message |
| 7 | Short message | Enter `Hi` | Message length error |
| 8 | Invalid request method | Open `process.php` directly | HTTP 405 response |
| 9 | Invalid CSRF token | Alter or remove hidden token | HTTP 403 response |
| 10 | Stored records | Submit valid data, then open records page | Saved record appears in table |
| 11 | HTML escaping | Use `<script>alert(1)</script>` as message | Content is displayed as text |
| 12 | Storage issue | Make data folder unwritable for a temporary test | Clear storage error, depending on server permissions |

Run tests through `http://localhost/...` with Apache and PHP enabled.
