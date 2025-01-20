# Setup Instructions

Follow these steps to set up the Backend project locally.

## Prerequisites

Ensure you have the following installed:
- **PHP** (version 8.0 or higher)
- **Composer**
- **MySQL**
- **Laravel Installer** (optional)
- **Mailtrap account** (for local email testing)

---

## 1. Clone the Repository

Clone the repository from GitHub:

```
git clone https://github.com/amitkolloldey/nine_kiwis_chrome_extension_backend.git
cd nine_kiwis_chrome_extension_backend
```

---

## 2. Create the `.env` File

Create a copy of the `.env.example` file and rename it to `.env`:

```
cp .env.example .env
```

---

## 3. Install PHP Dependencies

Run the following command to install PHP dependencies using Composer:

```
composer install
```

---

## 4. Generate the Application Key

Generate the application key for your project by running the following command:

```
php artisan key:generate
```

This command will automatically generate and set the `APP_KEY` in your `.env` file.

---

## 5. Set Up Your `.env` File

Update the `.env` file in the project root with the following configuration:

### Set the Backend URL:
```env
APP_URL=http://127.0.0.1:8000
```

### Set Up the Database Connection:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=nine_kiwis_chrome_extension_backend
DB_USERNAME=root
DB_PASSWORD=
```

---

## 6. Migrate the Database

After setting up the database, run the migrations to create the necessary tables:

```bash
php artisan migrate
```

---

## 7. Run the Local Development Server

Start the Laravel development server:

```bash
php artisan serve
```

---

## 8. Access the Backend

Once the server is running, you can access the backend API at:

[http://127.0.0.1:8000](http://127.0.0.1:8000)
