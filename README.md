![Installation Complete](public/Documentation/4.png)
# Laravel Shop Generator - Laravel Ecommerce CMS

Laravel Shop Generator is a powerful and feature-rich Ecommerce CMS built with Laravel. It provides a comprehensive solution for creating and managing an online store with ease.

## Features

- **Multiple Language Support**
- **Multiple Currency Support**
- **Product Attributes and Options**
- **Order Management**
- **Brands, Tags, and Reviews**
- **Flash Sales and Coupons**
- **Wishlist and Compare**
- **Guest Checkout**
- **Invoice Generation**
- **Advanced Search and Filtering**
- **SEO Optimized**
- **Beautiful & Powerful Admin Panel**
- **Scheduled Currency Rate Updating**
- **Custom Static Pages**
- **Advanced System Reports**
- **Maintenance Mode**
- **And More...**

## Requirements

- **PHP:** 7.4+ (Recommended: 8.1 or higher)
- **MySQL:** 5.6+ or MariaDB 10.0+
- **PHP Extensions:**
  - Intl
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON

## Installation

### Step 1: Extract and Upload

1. Unzip the downloaded archive package.
2. Rename the `Laravel Shop Generator` directory to your desired directory name.
3. Upload the directory to your web server through FTP or Control Panel.

### Step 2: Creating Database

1. Create a database for Laravel Shop Generator through your server control panel.
2. If your server has phpMyAdmin, you can also create a database using phpMyAdmin.

### Step 3: Install Dependencies

1. Navigate to the project directory:
    ```bash
    cd /path/to/your/laravel-shop-generator
    ```
2. Install Composer dependencies:
    ```bash
    composer install
    ```
3. Install NPM dependencies:
    ```bash
    npm install
    ```

### Step 4: Environment Configuration

1. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```
2. Open the `.env` file and configure your environment variables, including database connection details.

### Step 5: Generate Application Key

1. Generate the application key:
    ```bash
    php artisan key:generate
    ```

### Step 6: Run Migrations and Seed Database

1. Run the database migrations and seed the database:
    ```bash
    php artisan migrate --seed
    ```

### Step 7: Build Frontend Assets

1. Build the frontend assets:
    ```bash
    npm run dev
    ```

### Step 8: Run Installation Wizard

1. Go to your website address.
2. Follow the installation wizard.

**Note:** You should configure your web server's document/web root to be the `public` directory.

### Pre-Installation

The pre-installation page checks if your server meets the requirements and has the correct directory permissions to set up Laravel Shop Generator. Ensure that directories within the `storage` and the `bootstrap/cache` directories are writable by your web server.

### Configuration

Fill in the database connection details, administration details, and store details, then click the `Install` button to install Laravel Shop Generator.

### Complete

After successfully installing Laravel Shop Generator, you will see a success message. You now have the option to browse your online store or log into the administration panel.

## Admin Login

- **URL:** [https://your-domain.com/admin](https://your-domain.com/admin)
- **Email:** `admin@email.com`
- **Password:** `123456`

## User Login

- **URL:** [https://your-domain.com/login](https://your-domain.com/login)
- **Email:** `admin@email.com`
- **Password:** `123456`

## Changelog

### Version 4.3.1 (5 Jul 2024)
- Fix file manager issue

### Version 4.3.0 (3 Jul 2024)
- Add new sidebar cart design
- Add new newsletter popup design
- Add locale switcher in auth pages
- Add ability to change storefront font with 17 fonts preset
- Fix product gallery lightbox duplicate images
- Fix missing translations
- Fix responsive issues
- Improve accessibility
- Improve storefront theme design

... (Include other versions as needed)

## License

This project is licensed under the terms of the [Envato Regular License](https://codecanyon.net/licenses/standard).

## Support

For support, please contact [EnvaySoft](https://codecanyon.net/user/envaysoft).

---

© All Rights Reserved EnvaySoft

## Screenshots
## 📞 Contact Me
<div align="center">
    <a href="https://www.linkedin.com/in/hesam-ahmadpour" style="color: red; font-size: 20px; text-decoration: none;">LinkedIn</a> |
    <a href="https://t.me/morpheusadam" style="color: red; font-size: 20px; text-decoration: none;">Telegram</a>
</div>


![Installation Step 1](public/Documentation/1.png)
![Installation Step 2](public/Documentation/2.png)
![Installation Step 3](public/Documentation/3.png)
![Installation Complete](public/Documentation/4.png)
