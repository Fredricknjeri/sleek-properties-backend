##RUNNING THE BACKEND
1. Install Prerequisites

PHP: Ensure PHP 7.4 or higher is installed. Download PHP.
Composer: Install Composer from getcomposer.org.
Database: Install MySQL (or use a service like XAMPP, MAMP, or Docker).

2. Clone the Project

If you haven't already, clone your project repository:

git clone <repository-url>
cd <project-folder>

3. Install Project Dependencies

Run this command to install required libraries:

composer install

4. Set Up Environment Variables

Copy the example .env file:

cp .env.example .env

Edit .env to configure your database connection:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

5. Generate Application Key

Run the following command to generate an app key:


php artisan key:generate

6. Run Migrations

Create database tables using migrations:

php artisan migrate

7. Start the Server

Launch the Laravel development server:


php artisan serve

The server will start on http://127.0.0.1:8000.

8. Access the Application

use postman and add http://127.0.0.1:8000 as baseUrl and on the flutter application.
