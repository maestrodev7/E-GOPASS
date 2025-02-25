
## 🚀 Getting Started

Follow these steps to set up and run the Laravel application on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- [PHP](https://www.php.net/) (version 8.4.2 or higher)
- [Composer](https://getcomposer.org/) (for dependency management)
- [Node.js](https://nodejs.org/) (for frontend assets, optional)
- A database system (e.g., MySQL, PostgreSQL, SQLite)

### Installation

1. **Clone the repository**  
   Start by cloning this repository to your local machine:

   ```bash
   git clone https://github.com/maestrodev7/E-GOPASS.git
   cd E-GOPASS
   ```

2. **Install PHP dependencies**  
   Use Composer to install the required PHP packages:

   ```bash
   composer install
   ```

3. **Set up the environment file**  
   Copy the `.env.example` file to `.env` and configure your environment variables. For Twilio, ensure the following settings are configured:

   ```env
   TWILIO_SID=your_twilio_sid
   TWILIO_AUTH_TOKEN=your_twilio_auth_token
   TWILIO_PHONE_NUMBER=your_twilio_phone_number
   ```

   Generate an application key:

   ```bash
   php artisan key:generate
   ```

4. **Configure `php.ini` for Twilio**  
   To ensure Twilio works correctly, you need to configure your `php.ini` file:

   - Open your `php.ini` file (you can find its path by running `php --ini`).
   - Locate the lines containing `curl.cainfo` and `openssl.cafile`.
   - Ensure they are set as follows:

     ```ini
     curl.cainfo = "C:\xampp\php\extras\ssl\cacert.pem"
     openssl.cafile = "C:\xampp\php\extras\ssl\cacert.pem"
     ```

   - Save the file and restart your web server (e.g., Apache or Nginx).

5. **Set up the database**  
   Create a database and update the `.env` file with your database credentials:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

   Run migrations to set up the database schema:

   ```bash
   php artisan migrate
   ```


6. **Run the application**  
   Start the Laravel development server:

   ```bash
   php artisan serve
   ```

   Open your browser and navigate to `http://localhost:8000` to view the application.

---

### Additional Commands

- **Run tests**  
  To run the application tests, use:

  ```bash
  php artisan test
  ```

- **Clear cache**  
  If you encounter issues, clear the application cache:

  ```bash
  php artisan cache:clear
  php artisan config:clear
  php artisan view:clear
  php artisan route:clear
  ```

---

### Configuring Twilio

To use Twilio services (e.g., SMS, voice calls), you need to provide the following credentials in your `.env` file:

- `TWILIO_SID`: Your Twilio Account SID.
- `TWILIO_AUTH_TOKEN`: Your Twilio Auth Token.
- `TWILIO_PHONE_NUMBER`: Your Twilio phone number in E.164 format (e.g., `+1234567890`).

Make sure to keep these credentials secure and never commit them to version control.

---

### Troubleshooting Twilio

If you encounter issues with Twilio, ensure the following:

- The `.env` file is correctly configured with your Twilio credentials.
- The `php.ini` file is properly updated with the `curl.cainfo` and `openssl.cafile` paths.
- Your firewall or network settings allow outbound connections to Twilio's API endpoints.

---

Cette section explique comment configurer Twilio sans révéler les informations sensibles. Les utilisateurs sauront quelles variables d'environnement ils doivent définir et comment configurer leur environnement pour que Twilio fonctionne correctement.