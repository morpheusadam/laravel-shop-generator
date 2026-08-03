# Shop Smith

Shop Smith (project name `Laravel Shop Generator`) is a Laravel 10 eCommerce CMS for store owners, agencies, and developers who want a modular, self-hosted online shop with an admin panel.

## Overview

The project provides a customer storefront, an admin panel, and a modular architecture based on `nwidart/laravel-modules` so features live in self-contained modules.

It supports multiple languages and currencies, product attributes and options, order management, coupons and flash sales, wishlist and compare, guest checkout, invoice generation, and search with filtering. A guided web installer checks system requirements and handles licensing, and an update system is included. PWA support, scheduled currency-rate updates, and system reports are built in.

## Features

- Multiple language support
- Multiple currency support with scheduled rate updates
- Product attributes and options
- Order management
- Brands, tags, and reviews
- Flash sales and coupons
- Wishlist and compare
- Guest checkout
- Invoice generation
- Search and filtering
- SEO-oriented URLs and metadata
- Admin panel
- Custom static pages
- System reports
- Maintenance mode
- Module and entity scaffolding via Artisan generators
- PWA support (installable web app)
- Guided web installer with requirement checks

## Requirements

- PHP 8.1 or later with Composer, `ext-gd` enabled
- MySQL 5.6+ or MariaDB 10.0+
- Node.js and npm
- PHP extensions: Intl, OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON

## Installation

```bash
# 1. Get the code
git clone https://github.com/morpheusadam/ShopSmith.git
cd laravel-shop-generator

# 2. Install dependencies
composer install
npm install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Set database credentials in .env, then migrate and seed
php artisan migrate --seed

# 5. Build frontend assets
npm run build      # or: npm run dev
```

Then serve the app and complete setup through the guided web installer:

```bash
php artisan serve
```

The database can also be created through a hosting control panel or phpMyAdmin, with the web installer used to finish configuration.

## Module scaffolding

New modules and entities can be generated with the built-in Artisan commands:

```bash
php artisan scaffold:module    # scaffold a new module
php artisan scaffold:entity    # scaffold a new entity
```

## Tech stack

| Layer | Technologies |
| --- | --- |
| Backend | Laravel 10, PHP 8.1+, nwidart/laravel-modules, Doctrine DBAL |
| Frontend | Blade, Vue 2, Bootstrap, Alpine.js, jQuery, Sass, Vite |
| Caching | Predis adapter, alternative-laravel-cache |
| PWA and i18n | silviolleite/laravelpwa, Symfony Intl |
| Tooling | Wikimedia Composer Merge Plugin, dotenv-editor, PostCSS RTLCSS |

## Project structure

```text
laravel-shop-generator/
├── app/
│   ├── Http/Controllers/   # Install & License controllers
│   ├── Install/            # Web installer (requirements, DB, store, admin)
│   ├── Scaffold/Module/    # Module & entity generators + stubs
│   └── Updater.php         # Update system
├── config/                 # app, database, sentinel, modules, ...
├── Modules/                # Feature modules (nwidart/laravel-modules)
├── resources/              # Blade views & frontend assets
└── routes/                 # Application routes
```

## Contributing

Open an [issue](https://github.com/morpheusadam/ShopSmith/issues) or submit a pull request with new features, fixes, or improvements.

## License

See the repository's license terms; add a `LICENSE` file if distributing. Built on the Laravel framework, which is MIT licensed.

## Author

Morpheus Adam — [GitHub](https://github.com/morpheusadam) · [sam.zeonic.me](https://sam.zeonic.me) · morpheusadam95@gmail.com
