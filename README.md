# 🌟 Charity Management System

A **Laravel 12** based web application designed to manage charity services, handle donations, generate medical reports, process assistive tools requests, and manage service requests efficiently.

---

## 🚀 Features

- 🔐 **Authentication System** (Patient, Employee, Service Employee, Admin)  
- 💰 **Online Donations** with secure processing  
- 📝 **Medical Reports** creation and management for patients  
- 🛠️ **Assistive Tools Requests** (patients can request medical devices/tools)  
- 📄 **Service Requests** to facilitate additional support for patients  
- 📅 **Appointment Scheduling** for patient visits  

---

## 👥 User Roles

- 🧑‍⚕️ **Patient** – Can submit service requests, view reports, request assistive tools.  
- 👩‍💼 **Employee** – Manages patient information and medical reports.  
- 🛠️ **Service Employee** – Handles assistive tools and service requests.  
- 👨‍💻 **Admin** – Full control over the system, manages employees and services.  

---

## 🛠️ Tech Stack

- **Laravel 12** (PHP Framework)
- **PHP 8**
- **MySQL** (Database)
- **HTML, CSS, JavaScript** (Frontend)
- **Bootstrap / Blade Templates**

---
## ⚙️ Installation

1. Clone the repository using: `git clone https://github.com/Bushra021/charity-management-system-laravel.git`  
2. Navigate to the project folder: `cd charity-management-system-laravel`  
3. Install dependencies: `composer install`  
4. Create a copy of the environment file: `cp .env.example .env`  
5. Configure your database information inside the `.env` file  
6. Generate application key: `php artisan key:generate`  
7. Run database migrations: `php artisan migrate`  
8. Start the development server: `php artisan serve`
