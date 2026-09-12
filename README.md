<div align="center">
  <img src="images/icon.png" alt="Rechnungsverwaltung logo" width="140" />
  <h1>Mini PA 2021 — Rechnungsverwaltung</h1>
  <p><b>An invoice and reminder management web app.</b><br/>Manages people, their invoices (<i>Rechnungen</i>) and payment reminders (<i>Mahnungen</i>), with login and full add/edit/delete.</p>
  <p>
    <a href="LICENSE"><img alt="License: MIT" src="https://img.shields.io/badge/License-MIT-blue.svg"></a>
    <img alt="PHP" src="https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white">
    <img alt="MySQL" src="https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white">
    <img alt="Docker" src="https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white">
    <img alt="Apache" src="https://img.shields.io/badge/Apache-D22128?logo=apache&logoColor=white">
  </p>
</div>

---

A small invoice and reminder management web app ("Meine Mini PA") built as a
2021 mini project assignment (Mini-Projektarbeit). It manages people, their
invoices (*Rechnungen*) and payment reminders (*Mahnungen*), with login,
overview pages and full add/edit/delete for each entity.

Written in plain **PHP** on a hand-rolled MVC structure (front controller +
router + models + views) backed by **MySQL/MariaDB**, and shipped with a
**Docker** setup that runs the app, the database and phpMyAdmin together.

## Features

- Manage **people**, **invoices** and **reminders** (create, edit, delete).
- Mark invoices as paid (*begleichen*) and add multi-level reminders.
- Overview pages per person and per invoice.
- Login / logout.
- Server-side validation.

## Tech stack

- PHP (custom MVC: `core/Router.php`, `core/bootstrap.php`, `app/`)
- MySQL / MariaDB (schema in `minipa.sql`)
- Apache with `.htaccess` URL rewriting
- Docker / Docker Compose (PHP-Apache + MariaDB + phpMyAdmin)

## Run with Docker (recommended)

```bash
docker compose up -d --build
```

The database is seeded automatically on first start (schema `minipa.sql` plus
mock data in `docker/initdb/`). Then open:

| What       | URL                                        |
|------------|--------------------------------------------|
| Web app    | http://localhost:8092/rechnungen/login     |
| phpMyAdmin | http://localhost:8095                      |

Demo login: `admin@minipa.test` / `admin123`. See [`DOCKER.md`](DOCKER.md) for
ports, phpMyAdmin credentials and common commands.

## Run without Docker

1. Create a MySQL/MariaDB database named `minipa` and import `minipa.sql`.
2. Adjust the DB credentials in `index.php` if they differ from `root` / empty.
3. Serve the project with PHP + Apache (URL rewriting via `.htaccess`), e.g. under
   XAMPP, and open `/rechnungen/login`.

## Project structure

```
index.php            Front controller + route table
core/                Router, bootstrap, database, helpers
app/Controllers/     Request handling (WelcomeController, validation)
app/Models/          Rechnungen model (DB access)
app/Views/           HTML views (people, invoices, reminders, login)
docker/              Docker init SQL + Apache config
mockup/              Diagrams (class, ERM, use case, folder structure)
doku/                Project documentation
```

## License

Released under the [MIT License](LICENSE) © 2026 Olivier Lüthy. You're free to use, modify and distribute this
software, including commercially, as long as the copyright notice and license are included.

## Author

Built by **Olivier Lüthy** — [GitHub](https://github.com/olivierluethy).
