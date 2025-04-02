<div align="center">

<h3 align="center">Job Dating Project</h3>

  <p align="center">
    A simple MVC project for user authentication and role-based access control.
    <br />
     <a href="https://github.com/issam-mhj/jobdating">github.com/issam-mhj/jobdating</a>
  </p>
</div>
## Table of Contents

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#key-features">Key Features</a></li>
      </ul>
    </li>
    <li><a href="#architecture">Architecture</a></li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>

## About The Project

This project is a basic implementation of the Model-View-Controller (MVC) architectural pattern in PHP. It provides user authentication (login and signup), role-based access control (admin and user roles), and utilizes a database for user management. It also includes basic logging and form validation.

### Key Features

- **User Authentication:** Implements login and signup functionality with password hashing and CSRF protection.
- **Role-Based Access Control:** Supports different roles (admin and user) with access to different dashboards.
- **Database Integration:** Uses Eloquent ORM for database interaction.
- **Templating Engine:** Utilizes Twig for rendering views.
- **Logging:** Implements a simple logging mechanism for error tracking and debugging.
- **Form Validation:** Includes validation for email, password, and username.
- **CSRF Protection:** Protects against Cross-Site Request Forgery attacks.

The project follows the MVC architectural pattern:

- **Models:** Represent data and business logic (e.g., `User.php`). Uses Eloquent ORM.
- **Views:** Handle the presentation layer (e.g., `.twig` files in the `app/views` directory).  Twig templating engine is used.
- **Controllers:** Manage user requests and interact with models and views (e.g., `AuthController.php`, `AdminController.php`, `UserController.php`).

Key technologies used:

- **PHP:** The primary programming language.
- **Eloquent ORM:** For database interaction.
- **Twig:** Templating engine for rendering views.
- **Composer:** Dependency management.
- **vlucas/phpdotenv:** For managing environment variables.
- **Symfony/Var-Dumper:** For debugging.

## Getting Started

### Prerequisites

- PHP >= 7.4
- Composer
- A database (e.g., MySQL)
- Web server (e.g., Apache, Nginx)

### Installation

1.  **Clone the repository:**

    ```sh
    git clone https://github.com/issam-mhj/jobdating.git
    cd jobdating
    ```

2.  **Install Composer dependencies:**

    ```sh
    composer install
    ```

3.  **Configure environment variables:**

    -   Create a `.env` file in the project root directory.
    -   Add the following environment variables, replacing the values with your actual database credentials:

        ```
        DB_DRIVER=mysql
        DB_HOST=localhost
        DB_NAME=your_database_name
        DB_USER=your_database_user
        DB_PASSWORD=your_database_password
        ```

4.  **Initialize the database:**

    -   Create the database specified in the `.env` file.
    -   Run the database migrations to create the necessary tables.  Since the project uses Eloquent, you would typically define migrations and run them using a tool like `php artisan migrate` (if this was a Laravel project).  However, this project does not include migrations.  You will need to manually create the `users` table with the following columns:

        ```sql
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );
        ```

5.  **Configure the web server:**

    -   Configure your web server to point to the `public` directory as the document root.
    -   Ensure that the `.htaccess` file is correctly configured to handle routing.

6.  **Access the application:**

    -   Open your web browser and navigate to the project URL.
