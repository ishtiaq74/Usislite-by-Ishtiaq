# PHP Code Explanation — UsisLite (Student Portal)

This document explains the purpose and important code in each PHP file in the project, points out security considerations, and includes sample viva questions & answers so you can present the project confidently.

---

## Quick setup (how to get this file)
- The file is in the repository root: `PHP_CODE_EXPLANATION.md`.
- You can download it from GitHub or via the raw link:
  `https://raw.githubusercontent.com/ishtiaq74/Usislite-by-Ishtiaq/main/PHP_CODE_EXPLANATION.md`

---

## Overview: app flow
- `index.php` shows the login and signup forms.
- `signin.php` authenticates users and redirects them to the appropriate dashboard (student, faculty, or registrar).
- `signup.php` creates a User (and Student or Faculty records) and redirects to the appropriate dashboard.
- `DBconnect.php` creates the DB connection using `config.php` (copy `config.example.php`).
- `views/` contains pages for dashboards and forms. `actions/` contains small scripts that perform add/delete operations.

---

## File-by-file explanation

### `DBconnect.php`
- Loads `config.php` (you must copy `config.example.php` to `config.php` and set credentials).
- Uses `new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME)` to create a connection stored in `$conn`.
- If the connection fails, the page terminates with an error message.

Tip for viva: explain that centralizing the connection makes it easy to include DB access from multiple pages.

---

### `config.example.php`
- Contains placeholder constants:
  - `DB_SERVER`, `DB_USERNAME`, `DB_PASSWORD`, `DB_NAME`.
- Instruction: copy to `config.php` and do NOT commit `config.php` (it's in `.gitignore`).

---

### `index.php` (Forms)
- Presents two forms using POST:
  - Login form -> `signin.php` (fields: username, password)
  - Signup form -> `signup.php` (username, password, name, email, phoneno, role)
- Frontend-only: no JS validation; uses HTML `required` attributes.

Viva note: this page is the user entry point; explain the form `action` attributes and how submission flows to server scripts.

---

### `signup.php`
- Starts session (`session_start()`), includes `DBconnect.php`.
- Reads POST fields and inserts into `User` table:
  - Currently stores password as plaintext: `INSERT INTO User (..., Password, ...) VALUES ('$p')`.
- Depending on `role` value, inserts into `Student` or `Faculty`:
  - Student: generates `StudentID` like `Sxxx`, inserts into `Student` and redirects to `/views/student_dashboard.php`.
  - Faculty: creates `Initials` from the name and inserts into `Faculty`.
- Sets `$_SESSION['userid']` so user is treated as logged in immediately.

Security note: this file is vulnerable to SQL Injection and stores passwords in plaintext — see Improvements below.

Suggested viva reply: "I would use `password_hash()` before storing passwords and prepared statements to avoid SQL injection."

---

### `signin.php`
- Starts session and includes DB connection.
- Reads POST `username` and `password` and queries `User` table:
  - `SELECT * FROM User WHERE UserID='$u' AND Password='$p'`.
- If a row is found, sets `$_SESSION['userid']` and checks role by querying `Student` and `Faculty` tables, redirecting to the appropriate dashboard.
- Special case: username `reg` is treated as registrar and redirected accordingly.

Security note: plain-text password check, no prepared statements, and no rate limiting.

Suggested viva reply: "On a secure system I'd store hashed passwords and use `password_verify()` during login."

---

### `views/*` (dashboards & pages)
General structure used by pages in `views/`:
- `session_start()` + `require_once(__DIR__.'/../DBconnect.php')` at top.
- They fetch the logged-in user data using `$_SESSION['userid']`.
- They perform SQL queries to list courses, students, assigned courses, etc., and render HTML.

Important files:
- `views/student_dashboard.php` — shows student details and courses taken.
- `views/student_take_course.php` — lists available assigned courses and has a form to take a course (POST to `student_take_course_action.php`). **Note:** The corresponding action script `student_take_course_action.php` is not present in `actions/` (this is a missing piece).
- `views/student_drop_course.php` — lists taken courses and posts to `../actions/student_drop_course_action.php`.
- `views/faculty_dashboard.php` — shows faculty info and assigned courses.
- `views/faculty_add_course.php` — search student and adds them to a course via `../actions/faculty_add_course_action.php`.
- `views/faculty_course_students.php` — shows students for a course and can drop them using `../actions/faculty_drop_course_action.php`.
- `views/register_*` pages — used by registrar (user `reg`) for viewing and dropping students' courses.

Security & robustness remarks:
- Some view pages escape output where needed (`htmlspecialchars`) but many SQL queries directly interpolate variables (risk of SQL injection when inputs come from GET/POST).
- Session checks are inconsistent: some pages check for logged-in user and redirect; some assume `$_SESSION['userid']` exists.

---

### `actions/*` (server-side operations)
- `actions/faculty_add_course_action.php`:
  - Protects pages by checking `$_SESSION['userid']` and validates POST data, escapes inputs with `mysqli_real_escape_string`, prevents duplicate entries, and inserts into `CoursesTaken`.
- `actions/faculty_drop_course_action.php`:
  - Deletes an entry from `CoursesTaken` after basic validation and escaping.
- `actions/register_drop_course.php`:
  - Registrar-only action (`$_SESSION['userid'] === 'reg'`) to delete a student's course registration.
- `actions/student_drop_course_action.php`:
  - Gets the logged-in user, maps to `StudentID`, and deletes the `CoursesTaken` record.

Good practices seen here: use of `mysqli_real_escape_string` in actions to reduce SQL injection for POST parameters.

Note: the `student_take_course_action.php` referenced by the take course form is missing; this is a bug/omission.

---

## Security & improvement checklist (good viva points)
- Passwords: Use `password_hash()` and `password_verify()` instead of storing plaintext.
- Use prepared statements (mysqli prepared or PDO) to prevent SQL injection reliably.
- Add input validation & sanitization for all form inputs.
- Add CSRF tokens to POST forms to prevent cross-site request forgery.
- Ensure all pages check `$_SESSION['userid']` and confirm the user's role before allowing sensitive actions (authorization checks).
- Consistently escape output with `htmlspecialchars()` before rendering user data to prevent XSS.
- Implement logging and proper error handling (avoid exposing DB errors in production).

---

## Known issues to mention in viva
- Missing `student_take_course_action.php` (the form points to it, but it doesn't exist in `actions/`).
- Inconsistent use of input escaping: some files use `mysqli_real_escape_string`, others don't.
- Passwords are stored in plaintext.

---

## Sample viva Q&A (short answers you can memorize)
Q: How does login work in this app?
A: `signin.php` accepts username/password, queries `User` table, sets `$_SESSION['userid']` if valid, then identifies role by checking `Student`, `Faculty`, or the special `reg` user and redirects to the correct dashboard.

Q: Where are database credentials stored?
A: In `config.php` which is created from `config.example.php`. `DBconnect.php` requires `config.php` and creates the mysqli connection.

Q: How would you secure user passwords?
A: Use `password_hash()` on signup and `password_verify()` on login. Also use prepared statements for queries.

Q: How can you prevent a student from enrolling twice in the same course?
A: The `faculty_add_course_action.php` checks for existing `CoursesTaken` rows before inserting; you should also add a unique constraint at DB level.


---

## Commands & quick actions
- Copy config example:

```bash
copy config.example.php config.php
# or on Linux / macOS
cp config.example.php config.php
```

- Start XAMPP (Apache & MySQL) and visit `http://localhost/student_portal`.
- Export database: `mysqldump -u root -p connect > database.sql` (I can add an example DB dump if you want).

---

## Want me to extend this file?
I can add:
- An **annotated SQL schema** (`database.sql`) showing tables and example data.
- A **step-by-step live demo guide** for deployment on a hosting provider.
- A **short cheat sheet** for common viva questions with example answers.

If you want any of these, tell me which one and I'll add it and push it to your repository.

---

Good luck with your viva — tell me if you want this exported as a PDF or any additions to the notes!