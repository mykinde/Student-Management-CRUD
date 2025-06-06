# 🎓 Student Management System (Laravel 12)

A simple Laravel 12-based web application for managing students, courses, and grades with built-in authentication.

---

## 🚀 Features

- ✅ **Authentication**
  - Login, registration, and password reset (via Laravel Breeze)
- 📋 **Student Management**
  - Create, view, update, delete student records
- 📚 **Course Management**
  - Manage course details and descriptions
- 📝 **Grades Management**
  - Assign and track student grades per course
- 🔐 **Secure Access**
  - All operations protected by authentication middleware

---

## 📦 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL or any supported database

---

## ⚙️ Installation Guide

Follow these steps to install and run the project locally:

```bash
# 1. Clone the repository
git clone https://github.com/your-username/student-management.git
cd student-management

# 2. Install dependencies
composer install
npm install && npm run dev

# 3. Copy .env and set database credentials
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Run database migrations
php artisan migrate

# 6. Serve the application
php artisan serve



app/
├── Models/
│   ├── Student.php
│   ├── Course.php
│   └── Grade.php
├── Http/Controllers/
│   ├── StudentController.php
│   ├── CourseController.php
│   └── GradeController.php
resources/views/
├── students/
├── courses/
└── grades/
routes/
└── web.php





## About Repository

A very simple Laravel 12 +  Application.
<p align="center">
<img src="https://i.imgur.com/zX9aMWO.png">

</p>

## mykinde
for full package and demo contact g3send@gmail.com

## Credit
This repository is motivated by [mykinde/laravStart](https://github.com/mykinde/laravel_12_chatgpt_app.git) and his awesome video tutorial in [Youtube](https://www.youtube.com/watch?v=ubSWfJ4Gqy8).
https://gemini.google.com/app/cc1dd82531cd6999

## License
---
This project is open-sourced under the MIT License.

Let me know if you want the GitHub Actions deployment, Docker setup, or Blade component examples included.