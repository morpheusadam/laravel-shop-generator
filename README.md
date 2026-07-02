<div align="center">
# 🏬 Shop Smith
### A powerful, feature-rich **Laravel eCommerce CMS** for building and managing an online store — multi-language, multi-currency, modular architecture, PWA-ready, with a beautiful and powerful admin panel.

<p>
  <img src="https://img.shields.io/github/license/morpheusadam/ShopSmith?style=for-the-badge&color=4c1" alt="License" />
  <img src="https://img.shields.io/github/stars/morpheusadam/ShopSmith?style=for-the-badge&color=ffca28" alt="Stars" />
  <img src="https://img.shields.io/github/forks/morpheusadam/ShopSmith?style=for-the-badge&color=42a5f5" alt="Forks" />
  <img src="https://img.shields.io/github/last-commit/morpheusadam/ShopSmith?style=for-the-badge&color=8e44ad" alt="Last commit" />
  <img src="https://img.shields.io/github/repo-size/morpheusadam/ShopSmith?style=for-the-badge&color=e67e22" alt="Repo size" />
</p>

<p>
  <img src="https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Vue.js-2-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white" alt="Vue" />
  <img src="https://img.shields.io/badge/Bootstrap-UI-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap" />
  <img src="https://img.shields.io/badge/Vite-Build-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite" />
  <img src="https://img.shields.io/badge/PWA-Ready-5A0FC8?style=for-the-badge&logo=pwa&logoColor=white" alt="PWA" />
</p>

</div>

---

## 📖 Overview

**Laravel Shop Generator** is a complete, feature-rich **eCommerce CMS** built on **Laravel 10**. It provides everything you need to create, launch, and manage a modern online store — a polished customer storefront, a powerful admin panel, and a **modular architecture** (powered by `nwidart/laravel-modules`) that keeps the codebase clean and extensible.

Out of the box it supports **multiple languages and currencies**, rich product attributes and options, order management, coupons and flash sales, wishlist and compare, guest checkout, invoice generation, and advanced search and filtering. A guided web installer, system requirement checks, license handling, and an update system make deployment straightforward, while built-in **PWA** support, scheduled currency-rate updates, and advanced reports round out a store-ready toolkit.

It's ideal for **store owners, agencies, and developers** who want a customizable Laravel-based shop platform with a modular, scaffold-friendly foundation.

> 🔎 **Keywords:** laravel ecommerce cms, online store, laravel shop, multi-language store, multi-currency, modular laravel, nwidart modules, pwa ecommerce, admin panel, flash sales, coupons, guest checkout.

---

## ✨ Features

- 🌐 **Multiple language support**
- 💱 **Multiple currency support** with scheduled rate updates
- 🧩 **Product attributes & options**
- 📦 **Order management**
- 🏷️ **Brands, tags & reviews**
- ⚡ **Flash sales & coupons**
- ❤️ **Wishlist & compare**
- 🛒 **Guest checkout**
- 🧾 **Invoice generation**
- 🔍 **Advanced search & filtering**
- 📈 **SEO optimized**
- 🖥️ **Beautiful & powerful admin panel**
- 📄 **Custom static pages**
- 📊 **Advanced system reports**
- 🛠️ **Maintenance mode**
- 🧱 **Module & entity scaffolding** (Artisan generators)
- 📲 **PWA support** (installable web app)
- 🧰 **Guided web installer** with requirement checks
- ➕ **And more...**

---

## 🛠️ Tech Stack

<p align="center">
  <img src="https://skillicons.dev/icons?i=laravel,php,mysql,vue,bootstrap,vite,sass,redis" alt="Tech stack" />
</p>

| Layer | Technologies |
| --- | --- |
| Backend | Laravel 10, PHP 8.1+, nwidart/laravel-modules, Doctrine DBAL |
| Frontend | Blade, Vue 2, Bootstrap, Alpine.js, jQuery, Sass, Vite |
| Caching | Predis adapter, alternative-laravel-cache |
| PWA & i18n | silviolleite/laravelpwa, Symfony Intl |
| Tooling | Wikimedia Composer Merge Plugin, dotenv-editor, PostCSS RTLCSS |

---

## 🚀 Getting Started

### Requirements

- **PHP 8.1+** with Composer (`ext-gd` enabled)
- **MySQL 5.6+** or **MariaDB 10.0+**
- **Node.js & npm**
- Required PHP extensions: Intl, OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON

### Installation

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

# 4. Set your database credentials in .env, then migrate & seed
php artisan migrate --seed

# 5. Build frontend assets
npm run build      # or: npm run dev
```

Then serve the app and complete setup via the guided web installer:

```bash
php artisan serve
```

> 💡 You can also create the database through your hosting control panel / phpMyAdmin and run the **web installer** to finish configuration.

---

## ⚙️ Module Scaffolding

Laravel Shop Generator uses a modular structure. New modules and entities can be scaffolded with the built-in Artisan commands:

```bash
php artisan scaffold:module    # scaffold a new module
php artisan scaffold:entity    # scaffold a new entity
```

---

## 🗂️ Project Structure

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

---

## 🤝 Contributing

Contributions are welcome! Open an [issue](https://github.com/morpheusadam/ShopSmith/issues) or submit a pull request with new features, fixes, or improvements.

## 📜 License

See the repository's license terms (add a `LICENSE` file if distributing). Built on the open-source **Laravel** framework (MIT).

---

<div align="center">

### 👤 Author — Morpheus Adam

Web developer & cheerful hacker · PHP · Laravel · Go

<p>
  <a href="https://github.com/morpheusadam"><img src="https://img.shields.io/badge/GitHub-morpheusadam-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub" /></a>
  <a href="https://sam.zeonic.me"><img src="https://img.shields.io/badge/Website-sam.zeonic.me-4c1?style=for-the-badge&logo=googlechrome&logoColor=white" alt="Website" /></a>
  <a href="mailto:morpheusadam95@gmail.com"><img src="https://img.shields.io/badge/Email-Contact-D14836?style=for-the-badge&logo=gmail&logoColor=white" alt="Email" /></a>
</p>

⭐ **If Laravel Shop Generator helped you launch your store, please give it a star!** ⭐

</div>
