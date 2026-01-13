# UsisLite — Student Portal

A simple PHP/MySQL student portal for course registration and management (students, faculty, and registrar). This repo contains the core project files designed to run on XAMPP (Apache + MySQL).

---

## 🔧 Features

- Student signup, login, and course registration
- Faculty dashboard to add/drop courses and view enrolled students
- Registrar dashboard to view students and faculties
- Simple MySQL-based data storage and PHP server-side rendering

## 🧩 Tech stack

- PHP 7+ (or compatible)
- MySQL / MariaDB
- XAMPP (for local development)

## ⚙️ Requirements

- XAMPP installed and running (Apache + MySQL)
- Place the project in your XAMPP `htdocs` directory, for example:

  `C:\xampp\htdocs\student_portal`

## ⚠️ Configuration

1. Copy `config.example.php` to `config.php`:

   ```php
   cp config.example.php config.php
   ```

   Or manually create `config.php` and set your database credentials.

2. Do NOT commit `config.php` — it contains secrets. `.gitignore` already ignores it.

## 📦 Database

- Create a database called `connect` (or change the name in `config.php`).
- Import your database schema via phpMyAdmin or the MySQL CLI. Example using CLI:

  ```bash
  mysql -u root -p connect < path/to/your-dump.sql
  ```

> Note: This repository does not include an exported SQL dump. Export your local DB, or I can help add an initial `database.sql` file.

## 🚀 Run locally

1. Start Apache and MySQL (XAMPP Control Panel).
2. Place the project under `htdocs` as described above.
3. Visit `http://localhost/student_portal` in your browser.

## 🖼 Screenshots

Add screenshots to the `/screenshots` folder and reference them in this README to show app pages (login, dashboard, etc.). Example:

```markdown
![Student Dashboard](screenshots/student-dashboard.png)
```

## 🤝 Contributing

- Fork the repo, create a feature branch, and open a pull request.
- Report issues or request features via the repository Issues page.

## 📄 License

This project has no license file yet. I recommend adding an **MIT License** if you want others to reuse the code freely.

## 📫 Contact

If you need help or want me to add a LICENSE/screenshots, reach me at **Ishtiaqrahat74@gmail.com**.

---

Enjoy — and let me know if you want me to add a `LICENSE` (MIT), export an example DB dump, or include screenshots and a short deployment guide.