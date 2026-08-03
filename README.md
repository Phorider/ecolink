# EcoLink

EcoLink connects citizens who have recyclable waste with nearby waste collectors —
"Uber for recyclable waste," without real-time tracking, payments, maps, or notifications.

Built with **Laravel 12**, **MySQL**, **Blade + Tailwind CSS (v4, via Vite)**, and hand-rolled
Breeze-style session authentication. No JavaScript frameworks, no APIs, no AI.

## Roles

| Role | Capabilities |
|---|---|
| **Citizen** | Register/login, create waste requests (type, weight, address, description, optional photo), view own requests with search/filter, cancel a request while it's still Pending. |
| **Collector** | Register/login, browse available (Pending) requests, accept a request, mark accepted jobs as Collected, view completed job history. |
| **Admin** | Login, dashboard with platform stats, manage users (search/filter, delete), manage all waste requests (search/filter, view, delete inappropriate ones). |

## Tech stack

- Laravel 12 (PHP 8.2+)
- MySQL
- Blade templates + Tailwind CSS 4 (via Vite) — no React/Vue/Alpine
- Session-based auth (Breeze-style controllers, written by hand — no package required)
- Role-based authorization via a custom `role` middleware
- Public disk file storage for request photos

## Folder structure (key paths)

```
app/
  Http/
    Controllers/
      Auth/                 Login & registration controllers
      Citizen/               WasteRequestController (citizen CRUD)
      Collector/             RequestController (browse/accept/collect)
      Admin/                 UserController, WasteRequestController
      DashboardController.php   Routes each role to its own dashboard view
    Middleware/
      EnsureUserHasRole.php  role:citizen|collector|admin route guard
  Models/
    User.php
    WasteRequest.php
database/
  migrations/                users table (+ role, phone) and waste_requests table
  factories/                 UserFactory, WasteRequestFactory
  seeders/                   DatabaseSeeder (demo accounts + sample requests)
resources/
  views/
    components/               nav, layouts/app, layouts/guest, form inputs, badge
    auth/                      login.blade.php, register.blade.php
    citizen/                   dashboard, requests/index|create|show
    collector/                 dashboard, available, jobs, completed
    admin/                     dashboard, users/index, requests/index|show
routes/
  web.php                     all RESTful routes, grouped by role middleware
```

## Database schema

**users**
`id, name, email, email_verified_at, password, role (citizen|collector|admin), phone, remember_token, timestamps`

**waste_requests**
`id, user_id (FK→users), collector_id (nullable FK→users), type (Plastic|Paper|Glass|Metal|E-waste|Organic), weight (decimal), address, description (nullable), image (nullable path), status (Pending|Accepted|Collected|Cancelled), accepted_at, collected_at, timestamps`

## Installation

1. **Clone / unzip the project**, then install PHP dependencies:
   ```bash
   composer install
   ```

2. **Copy the environment file** and generate an app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Create a MySQL database** named `ecolink` (or update `.env` with your own DB name), then set your DB credentials in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecolink
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations and seed sample data:**
   ```bash
   php artisan migrate --seed
   ```

5. **Link storage** so uploaded waste photos are publicly accessible:
   ```bash
   php artisan storage:link
   ```

6. **Install frontend dependencies and build Tailwind assets:**
   ```bash
   npm install
   npm run build
   ```
   (or `npm run dev` while developing, alongside `php artisan serve`)

7. **Serve the app:**
   ```bash
   php artisan serve
   ```
   Visit `http://127.0.0.1:8000`.

## Demo accounts (after seeding)

All seeded accounts use the password: **`password`**

| Role | Email |
|---|---|
| Admin | `admin@ecolink.test` |
| Citizen | `citizen@ecolink.test` |
| Collector | `collector@ecolink.test` |

The seeder also creates several additional random citizens/collectors and ~29 sample
waste requests across every status (Pending, Accepted, Collected, Cancelled) so every
screen has realistic data immediately.

## Notes on requirements coverage

- **Authentication:** hand-written Breeze-style `RegisteredUserController` / `AuthenticatedSessionController`, session guard, `guest`/`auth` middleware.
- **Authorization:** custom `role` middleware alias (`app/Http/Middleware/EnsureUserHasRole.php`), registered in `bootstrap/app.php`, applied per route group. Citizens/collectors also can't view or cancel each other's requests — enforced with `abort_unless` in the controllers.
- **Form validation:** all create/store actions use Laravel's `$request->validate()`.
- **Image upload:** optional `image` field stored on the `public` disk under `storage/app/public/waste_images`, served via `Storage::url()`.
- **Pagination:** `paginate(8)`/`paginate(10)` on all listing views, with `withQueryString()` so filters persist across pages.
- **Search by waste type:** query-string `type` filter on citizen "My Requests", collector "Available Requests", and admin "Requests" pages (plus a `status` filter and admin user search by name/email).
- **RESTful routes:** citizen requests use `Route::resource(...)->only([...])`; collector/admin actions use conventional REST-style verbs and URIs.
- **No APIs / JS frameworks / payments / maps / notifications / AI / chat**, as required — plain Blade + vanilla `<form>` submissions + Tailwind only.

## Default demo request statuses

Pending → available to collectors · Accepted → assigned to a collector, awaiting pickup ·
Collected → completed · Cancelled → withdrawn by the citizen before acceptance.
