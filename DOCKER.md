# Mini PA – Docker

Runs the whole app (PHP/Apache) plus a MariaDB database and phpMyAdmin.

## Start

```bash
docker compose up -d --build
```

The database is seeded automatically on first start (schema `minipa.sql` +
mock data in `docker/initdb/02-mock-data.sql`).

## URLs

| What        | URL                                                            |
|-------------|----------------------------------------------------------------|
| Web app     | http://localhost:8092/mpa_2021_Olivier/rechnungen/login        |
| phpMyAdmin  | http://localhost:8095                                          |
| MariaDB     | `localhost:3399` (for external DB tools)                        |

> Ports 8092 / 8095 / 3399 were chosen because 80, 8081, 3306 (and others)
> were already in use on this machine. Change them in `docker-compose.yml` if needed.

## Login (app)

| Email                 | Password   |
|-----------------------|------------|
| `admin@minipa.test`   | `admin123` |
| `olivier@kauz.ch`     | `admin123` |

## Login (phpMyAdmin / MariaDB)

- Server: `db` (already preset), User: `root`, Password: `root`
- Database: `minipa`

## Common commands

```bash
docker compose ps              # status
docker compose logs -f web     # app logs
docker compose down            # stop (DB data is kept)
docker compose down -v         # stop AND wipe DB (re-seeds on next up)
```

## Notes

- The app code is **bind-mounted**, so edits on the host show up immediately
  (just refresh the browser) — handy for the upcoming UI/UX work.
- DB connection settings come from environment variables in `docker-compose.yml`
  (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`), with local-dev fallbacks in the code.
- The app is served under the `/mpa_2021_Olivier/` sub-path so its existing
  relative asset/link paths keep working exactly as before.
