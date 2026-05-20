# Royal Food Corner — Laravel 11 + Tailwind (Glass UI)

A modern restaurant ordering platform for an Indo-Sri Lankan eatery. Originally built as a PHP + MySQL + Bootstrap site, fully migrated to **Laravel 11 + TailwindCSS 3 + Alpine.js** with a premium glassmorphism UI.

![Stack](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php)
![Tailwind](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=flat-square&logo=tailwindcss)
![Alpine](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat-square&logo=alpinedotjs)

## Features

### Customer-facing
- Glassmorphism hero, menu browser, category filters, gallery (masonry), product detail, cart, checkout, account, orders
- Session-based cart that persists across pages
- Login / register with hashed passwords + session auth
- Contact form

### Admin panel (`/admin`)
- Sidebar dashboard with KPIs (products, messages, items sold, orders, revenue)
- Full CRUD on products (with image uploads to `storage/products`)
- Gallery image upload / delete
- Customer orders list (with items, payment method, addresses)
- Customer messages list with delete

### Tech highlights
- Custom **glass UI** component library in `resources/css/app.css` (`.glass`, `.glass-card`, `.glass-input`, `.glass-table`, `.btn-primary`, `.btn-gold`, `.btn-ghost`)
- Custom Tailwind theme: `royal` red + `gold` accents, `font-display` (Playfair Display), `bg-spice-radial` ambient background
- Multi-guard authentication: `web` (users) + `admin` (admins)

## Local Setup

Requirements: PHP 8.2+, Composer, MySQL 8+, Node 20+.

```bash
git clone <repo-url>
cd royal-food-corner

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate

# Edit .env with your DB credentials, then:
php artisan migrate --seed
php artisan storage:link

php artisan serve
```

Default admin (created by seeder — **change after first login**): `admin / admin123`.

## Deployment

### Option A — Railway (recommended)

1. Push this repo to GitHub.
2. [railway.app](https://railway.app) → New Project → Deploy from GitHub.
3. Add a **MySQL** plugin (auto-injects credentials).
4. Set these env vars on the web service:
   ```
   APP_KEY=base64:<from "php artisan key:generate --show">
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://<your-railway-domain>
   FORCE_HTTPS=true
   DB_CONNECTION=mysql
   DB_HOST=${{MySQL.MYSQL_HOST}}
   DB_PORT=${{MySQL.MYSQL_PORT}}
   DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
   DB_USERNAME=${{MySQL.MYSQL_USER}}
   DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
   SESSION_DRIVER=file
   ```
5. Railway auto-detects `railway.json` + `nixpacks.toml` and deploys.

### Option B — Render

`render.yaml` + `Dockerfile` included. New → Blueprint → point at this repo.

### Why not Vercel?

Vercel is great for stateless Next.js/edge apps. Laravel needs a long-running PHP process and persistent file storage (for admin image uploads), which Vercel doesn't natively support. Use Railway / Render / Fly.io for Laravel.

## Project Structure

```
app/
  Http/Controllers/
    Admin/          # AuthController, DashboardController, ProductController, ...
    Auth/           # LoginController, RegisterController
    HomeController, MenuController, CartController, CheckoutController, ...
  Models/           # User, Admin, Product, GalleryImage, Order, OrderItem, Payment, Contact
  Support/Cart.php  # session-backed cart helper

resources/
  css/app.css       # Glass UI component library
  views/
    layouts/        # app.blade.php (user), admin.blade.php
    partials/       # navbar.blade.php, footer.blade.php
    user/           # home, menu, gallery, cart, checkout, orders, account, product-details
    auth/           # login, register
    admin/          # login, dashboard, product-edit, gallery, orders, messages

database/
  migrations/       # users, admins, products, gallery_images, orders + items + payments, contacts
  seeders/          # AdminSeeder, ProductSeeder (30 dishes), GalleryImageSeeder
```

## License

MIT.
