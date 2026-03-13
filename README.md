# 🔐 Full-Stack Login & Register System

A full-stack authentication system built with **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript** — featuring role-based access control with separate dashboards for **Users** and **Admins**.

> 📺 Project inspired by the tutorial: [Full-Stack Login & Register Form | Codehal](https://youtu.be/LiomRvK7AM8?si=K3j_WSRcxnMBAm-i)

---

![Status](https://img.shields.io/badge/Status-Working-brightgreen)
![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange?logo=mysql)
![License](https://img.shields.io/badge/License-MIT-lightgrey)

---

## ✨ Features

- 🔑 **User Registration** — create an account with name, email, password, and role
- 🔒 **Secure Login** — passwords hashed with `password_hash()` / `password_verify()`
- 👤 **Role-Based Access** — separate dashboard pages for `user` and `admin`
- 🚪 **Session Management** — protected routes redirect unauthenticated users
- 🔄 **Logout** — destroys session and redirects to login
- 💅 **Animated UI** — smooth toggle between Login and Register forms via JavaScript
- ❗ **Error Handling** — inline form error messages with session flash messages

---

## 🗂️ Project Structure
```
login_register/
├── index.php           # Main page — renders Login & Register forms
├── login_register.php  # Handles form submissions (login & register logic)
├── admin_page.php      # Admin dashboard (protected route)
├── user_page.php       # User dashboard (protected route)
├── logout.php          # Destroys session and redirects
├── config.php          # Database connection (MySQLi)
├── style.css           # Styling for all pages
└── script.js           # Form toggle animation
```

---

## 🛠️ Tech Stack

| Layer     | Technology        |
|-----------|-------------------|
| Frontend  | HTML5, CSS3, JavaScript |
| Backend   | PHP (procedural)  |
| Database  | MySQL             |
| Server    | Apache (XAMPP / WAMP / Laragon) |

---

## ⚙️ Setup & Installation

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (or WAMP / Laragon)
- PHP 8.x
- MySQL

### Steps

1. **Clone the repository**
```bash
   git clone https://github.com/your-username/login_register.git
```

2. **Move to your server's root folder**
```
   /xampp/htdocs/login_register/
```

3. **Create the database**

   Open **phpMyAdmin** and run the following SQL:
```sql
   CREATE DATABASE `users db`;

   USE `users db`;

   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(100) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       role ENUM('user', 'admin') NOT NULL
   );
```

4. **Configure the database connection**

   Edit `config.php` if your credentials differ:
```php
   $host     = "localhost";
   $username = "root";
   $password = "";        // your MySQL password
   $dbname   = "users db";
```

5. **Start Apache and MySQL** in your XAMPP control panel.

6. **Access the app** in your browser:
```
   http://localhost/login_register/
```

---

## 🚀 How It Works

1. The user visits `index.php` and sees the **Login** form by default.
2. Clicking *"Register"* toggles the form (via JavaScript) without a page reload.
3. On **Register**, the backend checks if the email already exists and inserts the new user with a hashed password.
4. On **Login**, the backend queries the user, verifies the password, and starts a session.
5. Based on the `role` column, the user is redirected to either:
   - `/user_page.php` — regular user dashboard
   - `/admin_page.php` — admin dashboard
6. Both protected pages check for a valid session; unauthenticated access redirects back to `index.php`.
7. Clicking **Logout** destroys the session and redirects to the login page.

---

## ⚠️ Security Notes

This project is intended for **learning purposes**. Before deploying to production, consider:

- Using **PDO with prepared statements** to prevent SQL injection
- Adding **CSRF token protection** to forms
- Enforcing **HTTPS** in production
- Implementing **rate limiting** on login attempts
- Storing secrets in environment variables (not in `config.php`)

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

---

## 🙏 Credits

Tutorial by **Codehal** — [Watch on YouTube](https://youtu.be/LiomRvK7AM8?si=K3j_WSRcxnMBAm-i)
