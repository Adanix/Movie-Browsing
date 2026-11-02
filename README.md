# 🎬 MATINEE — Multi-City Cinema Browsing & Animated Catalog Platform

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.5](https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-v4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-v3.x-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)](https://alpinejs.dev)
[![Tests Passing](https://img.shields.io/badge/Tests-20%20Passed%20(85%20Assertions)-10B981?style=for-the-badge&logo=githubactions&logoColor=white)](#automated-testing)

> **Live Theatrical Preview**: [https://movie.ramadadawah.my.id](https://movie.ramadadawah.my.id)  
> **Evaluator Inquiries**: [`mailto:nixresponding@gmail.com`](mailto:nixresponding@gmail.com)

**Matinee** is a Dark Art-Deco theatrical discovery platform featuring multi-city cinema browsing, non-rigid fluid animation layouts (Bento Showcase, 3D Grid with cursor tilt & specular glare, Theatrical Timeline), calendar sync, interactive trailers, and a dedicated backoffice curation console with automated double-booking conflict detection.

---

## ✨ Key Platform Features

### 1. Theatrical Experience & Fluid Animation ("Ga Kaku")
- **Dark Art-Deco Palette**: Obsidian (`#0B0B0E`), Deep Velvet (`#141118`), Marquee Gold (`#F5C518`), Amber Spotlight (`#FBBF24`), Champagne White (`#FDFBF7`), Emerald Open (`#10B981`), Sky Upcoming (`#38BDF8`), and Rose Alert (`#E11D48`).
- **3 Dynamic Layout Switcher Modes**:
  - **Editorial Bento Showcase**: Asymmetric editorial layout with prominent hero posters, format badges, and expandable showtime slot drawers.
  - **3D Grid**: Interactive cards featuring **cursor-driven 3D poster tilt & specular glare** via Alpine.js math (adaptive X/Y rotation with smooth spring physics).
  - **Theatrical Timeline**: Time-linear flow of screenings across the circuit for today and upcoming dates.
- **Theatrical Trailer Modal**: Interactive modal with MP4/HLS stream support, format tags, audio specifications, auto-pause on close, and keyboard `ESC` dismissal.
- **Showtime Reveal & RFC-5545 iCalendar Export**: One-click download of `.ics` calendar invites for Apple Calendar, Google Calendar, and Microsoft Outlook.

### 2. Multi-City Context & Cinema Palaces
- **5 Supported Cities**: Jakarta, Bandung, Surabaya, Bali, and Missoula.
- **Circuit Cinemas**: 11 flagship venues (e.g., Grand Surya Palace, Dago Grand Theatre, Tunjungan Grand Pavilion, Ubud Sacred Screenings, The Roxy Missoula) across 28 auditoriums with IMAX with Laser, Dolby Cinema Atmos, ScreenX 270°, and 70mm Film Print.
- **Accessibility Badges**: Closed Captions (`CC`), Audio Description (`AD`), Sensory Friendly (`SF`), and Parent & Baby (`PB`).

### 3. Modular Phase 2 Slot-In Architecture
In strict adherence to the Milestone 1 Demo brief, seat map reservation and payment checkout are decoupled behind a clean service boundary:
- **`TicketingSlotInterface`**: Interface preparing normalized `ShowtimeSlotContext` payloads.
- **`PhaseOnePreviewSlotAdapter`**: Adapter delivering verified showtime contexts ready to slot in Phase 2 live seat locking (Redis TTL) and payment gateways (Midtrans / Stripe).
- **Public API & HTML Previews**: Accessible via `GET /showtimes/{showtime}/preview` (supporting both JSON API and HTML slide-over previews).

### 4. Backoffice Management & Showtime Conflict Engine
- **Conflict Validation Engine (`ShowtimeConflictValidator`)**: Prevents auditorium double-booking by calculating film runtime plus a 20-minute turnaround buffer window.
- **Master Catalog CRUD**: Dedicated Platform Admin console for title curation, vertical/horizontal artwork, runtime, age ratings (SU, 13+, 17+, 21+), audio & subtitles.
- **Deterministic Studio Sync Simulator (`DeterministicStudioSyncSimulator`)**: Simulates external Hollywood and distributor feed ingestion with structured log tracking (`external_sync_logs`).

---

## 👥 Demo Personas (1-Click Passwordless Login)

Matinee includes a dedicated demo persona switcher accessible via `/demo/login` or directly from the top banner:

| Persona | Name | Role | Primary Features & Scopes |
| :--- | :--- | :--- | :--- |
| **Cinephile Member** | Elena Vance | `visitor_member` | Personal Watchlist, release alerts, preferred city filter, iCal export. |
| **Regional Manager** | Marcus Sterling | `cinema_manager` | Jakarta & Bandung cinema management, auditorium specs, showtime scheduling. |
| **Platform Curator** | Aria Chen | `platform_admin` | Full Master Film Catalog CRUD, featured/trending curation, studio sync simulator. |

---

## 🚀 Canonical Routes & Endpoints

| Method | URI | Route Name | Purpose |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | `public.home` | Premiere Hero, layout switcher, circuit cinemas showcase, contact footer. |
| `GET` | `/docs` | `public.docs` | Architecture documentation, Phase 2 slot-in specifications, contact info. |
| `GET` | `/demo/login` | `demo.login` | Passwordless persona selection cards. |
| `POST` | `/demo/quick-login` | `demo.quick-login` | 1-click persona session regeneration. |
| `POST` | `/logout` | `logout` | Session invalidation and redirect to demo login. |
| `GET` | `/movies` | `movies.index` | Searchable & filterable theatrical catalog with layout switching. |
| `GET` | `/movies/{slug}` | `movies.show` | Movie detail, runtime, trailer trigger, 14-day schedule. |
| `GET` | `/movies/{slug}/calendar.ics` | `movies.calendar` | RFC-5545 iCalendar showtime download. |
| `GET` | `/cinemas` | `cinemas.index` | Multi-city cinema palace directory. |
| `GET` | `/cinemas/{slug}` | `cinemas.show` | Cinema venue profile, auditoriums, sound specs, transit notes. |
| `GET` | `/showtimes/{id}/preview` | `showtimes.preview` | Phase 2 slot-in context preview (JSON & HTML). |
| `GET` | `/watchlist` | `watchlist.index` | Member watchlist & release reminders. |
| `GET` | `/manage` | `manage.dashboard` | Backoffice management overview. |
| `GET` | `/manage/movies` | `manage.movies.index` | Master film catalog management (Admin). |
| `GET` | `/manage/showtimes` | `manage.showtimes.index` | Showtime scheduling with double-booking validation. |

---

## 🧪 Automated Testing

The project includes an end-to-end automated test suite covering mandatory P0 routes, catalog discovery, conflict validation, and role authorization gates:

```bash
docker exec movie-app-1 php artisan test
```

### Test Suite Results:
```text
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\BackofficeAuthorizationAndConflictTest
  ✓ guest is redirected when accessing backoffice
  ✓ visitor member is forbidden from backoffice
  ✓ cinema manager can access dashboard and showtimes
  ✓ cinema manager is forbidden from master film catalog
  ✓ platform admin can access film catalog and sync simulator
  ✓ showtime conflict engine prevents double booking

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response

   PASS  Tests\Feature\MovieCatalogAndDiscoveryTest
  ✓ movies index lists titles and supports filtering
  ✓ movie detail page renders with schedule
  ✓ movie calendar ics export
  ✓ cinemas index and detail routes
  ✓ showtime slot preview json and html

   PASS  Tests\Feature\P0MandatoryDeliverablesTest
  ✓ public home route renders successfully with contact email
  ✓ public docs route renders successfully with contact email
  ✓ demo login route renders successfully
  ✓ quick login visitor member persona
  ✓ quick login cinema manager persona
  ✓ quick login platform admin persona
  ✓ logout clears authentication

  Tests:    20 passed (85 assertions)
  Duration: 24.50s
```

---

## 🛠 Local Setup & Development

### 1. Environment & Database
```bash
cp .env.example .env
# Configure DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan key:generate
php artisan migrate --seed
```

### 2. Frontend Asset Compilation
```bash
npm install
npm run build
```

### 3. Resetting Demo State
To restore the database to standard demo seeding at any time:
```bash
php artisan demo:reset
```

---

## 📄 License & Attribution

Designed and developed for the **Matinee Cinema Platform (Milestone 1 Demo)**. Built with Laravel 13, Tailwind CSS v4, and Alpine.js.
