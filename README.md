# Premium Template

A modern, responsive, and customizable website template built with **PHP, MySQL, HTML, CSS, and JavaScript**. The project includes an admin dashboard, dynamic content management, and a database installation system.

## 🌐 Live Demo

[Visit Premium Template](https://premium-template.rf.gd/)

> If the live demo is unavailable, you can run the project locally using the installation instructions below.

## ✨ Features

- **Responsive Design** — Optimized for desktop, tablet, and mobile devices.
- **Admin Dashboard** — Manage website content through an administration interface.
- **PHP & MySQL Integration** — Store and retrieve dynamic website content.
- **Database Installer** — Set up the database using the included installation files.
- **Secure Password Hashing** — Admin passwords are stored using PHP's `password_hash()`.
- **Environment Configuration** — Supports environment variables through a `.env` file and `phpdotenv`.
- **Reusable Components** — Organized files for easier customization and maintenance.
- **Customizable Content** — Adapt the template to different projects and business needs.

## 🛠️ Technologies Used

- PHP
- MySQL / MariaDB
- HTML5
- CSS3
- JavaScript
- Font Awesome (where included)
- Composer
- PHP dotenv

## 📁 Project Structure

text
Premium-Template/
│
├── css/
├── imgs/
├── javascript/
├── vendor/                     # Composer dependencies
│
├── .env                         # Local environment configuration (not uploaded)
├── .env.example                 # Example environment configuration
├── .gitignore
├── composer.json
├── composer.lock
├── database.sql
├── settings.json
│
├── admin_install.php
├── admin.php
├── change_password.php
├── collaboration.php
├── contact.php
├── db.php                       # Local database connection file (not uploaded)
├── delete_collaboration.php
├── delete_gallery.php
├── delete_newsletter.php
├── delete_service.php
├── delete_social.php
├── delete_timeline.php
├── delete.php
├── edit_collaboration.php
├── edit_gallery.php
├── edit_service.php
├── edit_social.php
├── edit_timeline.php
├── edit.php
├── export_newsletter.php
├── forgot_password.php
├── gallery.php
├── hash.php
├── index.php
├── install_success.php
├── install.php
├── installed.lock
├── installer.php
├── login.php
├── logout.php
├── messages.php
├── newsletter_admin.php
├── newsletter.php
├── send_newsletter_process.php
├── send_newsletter.php
├── services.php
├── settings.php
├── smtp_settings.php
├── socials.php
├── stats.php
├── testimonial_delete.php
├── testimonial_edit.php
└── timeline.php


**Note:** Some local configuration and installation files are excluded from the GitHub repository through `.gitignore`, including `.env`, `db.php`, `vendor/`, and `installed.lock`. Dependencies can be installed using `composer install`.


## ⚙️ Requirements

Before installing the project, make sure you have:

- PHP 8.0 or later (depending on the dependencies used)
- MySQL or MariaDB
- Apache or another compatible PHP web server
- Composer

For local development, you can use XAMPP.

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/achrafachrafe/premium-template.git
```

Enter the project directory:

```bash
cd premium-template
```

Replace `achrafachrafe` and `premium-template` with your actual GitHub details.

### 2. Install Dependencies

```bash
composer install
```

This installs the PHP packages listed in `composer.json`.

### 3. Configure the Database

Create a MySQL database or follow the project's installation process.

If you configure the connection manually, copy `.env.example` to `.env` and enter your local database details:

```env
DB_HOST=localhost
DB_NAME=influencer
DB_USER=root
DB_PASS=
```

**Important:** Keep your actual `.env` file private. Never upload database passwords or other secrets to GitHub.

### 4. Run the Installer

Start Apache and MySQL through XAMPP, then open the project in your browser:

```text
http://localhost/template/install.php
```

Follow the installation steps to configure the database and create the initial administrator account.

The exact installation flow depends on the included installer files and their configuration.

### 5. Open the Website

After installation, open the project locally:

```text
http://localhost/template/
```

Use the administration login page to access the dashboard.

## 🔐 Security Notes

- Never commit `.env` or real database credentials.
- Use strong administrator passwords.
- Use HTTPS when deploying publicly.
- Restrict access to installation scripts after setup.
- Do not expose database credentials or sensitive configuration files.
- Review and test the installer before using the project in production.

## 🎨 Customization

You can customize the template by editing:

- CSS files to change colors, spacing, and layout.
- JavaScript files to adjust interactions.
- Image assets in `imgs/`.
- PHP pages to modify website content and functionality.
- Database records to update dynamic content.

## 🧪 Development

To install dependencies after cloning the repository:

```bash
composer install
```

To check installed Composer packages:

```bash
composer show
```

## 📄 License

This project is distributed under a proprietary commercial license.

Purchasers may use and customize the template for their own personal or commercial projects.

Redistribution, resale, or sharing of the original template or its modified source code is not permitted.

See the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Achraf Yaazza**

A reusable website template designed for customization and further development.

---

If you find this project useful, consider giving the repository a ⭐ on GitHub.
