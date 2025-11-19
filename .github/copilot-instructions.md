**Purpose**
- **Quick context:** This is a small Laravel application (Laravel 12, PHP ^8.2) that manages athletes/student-athletes and a minimal frontend using Vite + Tailwind. Key entrypoints: `routes/web.php`, controllers under `app/Http/Controllers`, models in `app/Models`, and Blade views in `resources/views`.

**Getting started (commands)**
- **Install dependencies:** `composer install` and `npm install` (or run the helper script `composer run setup`).
- **Local dev:** `php artisan serve` and `npm run dev` (the repo also has a combined dev orchestration under `composer run dev`).
- **Migrate for development:** `php artisan migrate` (tests use an in-memory sqlite DB; see `phpunit.xml`).
- **Run tests:** `composer test` or `php artisan test` (the `phpunit.xml` sets `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`).

**Architecture - Big picture**
- **Framework:** Laravel (app structure follows standard conventions). The app is mostly MVC with Blade views for UI.
- **Routing & controllers:** `routes/web.php` contains route definitions; some pages are simple closures returning views, while CRUD routes are wired to controllers (example: `AthleteController`).
- **Models & persistence:** Models live in `app/Models`. The database schema for `athletes` is defined in `database/migrations/2025_11_17_135933_create_athletes_table.php` (columns: `student_id, first_name, last_name, course, year_level, sport`).
- **Frontend assets:** `package.json` uses Vite and Tailwind; build scripts are `npm run dev` and `npm run build`.

**Project-specific conventions & patterns**
- **Views naming:** Views are grouped in `resources/views/` (e.g. `resources/views/athlete_lists/athlete_lists.blade.php` and `resources/views/features/student_athlete.blade.php`). Controllers generally return view names matching these paths.
- **Models vs specialized models:** There is both an `Athlete` model and a `StudentAthlete` model. `StudentAthlete` maps to the `student_athletes` table and includes many more attributes (see `app/Models/StudentAthlete.php`). When adding or reading fields, prefer the model whose schema matches the view/data needs.

**Integration points & workflows**
- **Composer scripts:** `composer.json` includes useful scripts: `setup` (installs deps, copies `.env`, runs migrations, builds assets), `dev` (orchestrates `php artisan serve`, queue workers, logs, vite). Use these as a shortcut but verify commands when working locally.
- **Queue & background jobs:** The `dev` script runs `php artisan queue:listen` — be aware of queues if you add jobs. Default `QUEUE_CONNECTION` in `phpunit.xml` is `sync` for tests.
- **Testing environment:** `phpunit.xml` sets many env vars for predictable test runs (e.g., `DB_CONNECTION=sqlite`, `CACHE_STORE=array`, `QUEUE_CONNECTION=sync`). Tests should not require a running DB service.

**Important repository-specific notes / gotchas**
- **Field name mismatches:** `app/Http/Controllers/AthleteController.php` calls `Athlete::create([ 'full_name' => ..., 'athlete_id' => ... ])` but the `athletes` table and `app/Models/Athlete.php` expect `student_id`, `first_name`, `last_name`, etc. This is a likely bug or sign that the view/controller were intended to use `StudentAthlete` instead. Before changing DB/schema or model fields, confirm which model the UI should use.
- **View expects many fields not present on `athletes`:** `resources/views/athlete_lists/athlete_lists.blade.php` references fields such as `middle_initial`, `sport_event`, `status`, `classification`, `birthdate`, `age`, `picture_path`, etc. Those exist on `StudentAthlete` but not `Athlete` — double-check model/view mapping.
- **Migrations & naming:** `StudentAthlete` explicitly sets `protected $table = 'student_athletes'`. For new models, follow the same convention unless you intend to use Laravel's pluralization.

**How to make safe edits (examples)**
- **If adding a column used by views:** 1) add migration in `database/migrations`, 2) update the appropriate model's `$fillable`, 3) update controller creation/validation, 4) update views. Example: to persist `middle_initial` add a migration altering `athletes` or use `student_athletes` if that is the intended table.
- **Fixing the create mismatch quickly:** Change `AthleteController::store` to set `student_id`, `first_name`, `last_name` (or change it to create a `StudentAthlete` if the UI targets that model). Tests and migrations assume `athletes` table columns (see migration file).

**Files to inspect for context**
- `routes/web.php` — route wiring (closures vs controllers).
- `app/Http/Controllers/AthleteController.php` — CRUD behavior for athletes.
- `app/Models/Athlete.php` and `app/Models/StudentAthlete.php` — model definitions and `$fillable` arrays.
- `database/migrations/2025_11_17_135933_create_athletes_table.php` — source of truth for `athletes` schema.
- `resources/views/athlete_lists/athlete_lists.blade.php` — demonstrates expected fields and UI layout.
- `composer.json` / `package.json` / `phpunit.xml` — useful commands and test/runtime envs.

If anything here is unclear or you want me to: fix the `AthleteController` mismatch, update migrations to match the UI, or scaffold missing fields and tests — tell me which direction, and I will implement the change and run the test suite.
