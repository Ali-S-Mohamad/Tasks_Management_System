# Task Management API (Laravel 12)

A RESTful API for managing tasks, built with **Laravel 12**, featuring:

* **API Authentication** with Laravel Sanctum
* **Eloquent Relationships**: Users, Tasks, Statuses
* **Authorization** using Gates & Policies
* **Service Layer** for business logic
* **Seeders** for default data (Admin user, statuses, users with tasks)

---

## Table of Contents

1. [Installation](#installation)
2. [Configuration](#configuration)
3. [Database Setup & Seeding](#database-setup--seeding)
4. [Authorization & Policies](#authorization--policies)
5. [Service Layer](#service-layer)
6. [Postman Collection](#postman-collection)
---


### 🚀 Requirements

* PHP ≥ 8.2
* Composer
* MySQL (or other supported DB)
* Laravel 12
---

## Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/Ali-S-Mohamad/Tasks_Management_System.git
   cd Tasks_Management_System
   ```
2. **Install dependencies**:

   ```bash
   composer install
   ```
3. **Copy the example environment file**:

   ```bash
   cp .env.example .env
   ```
4. **Generate application key**:

   ```bash
   php artisan key:generate
   ```

---

## Configuration

1. **Set your database credentials** in the `.env` file:

   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
2. **Sanctum configuration** is already published. Ensure `APP_URL` matches your local or production URL.

---

## Database Setup & Seeding

Run migrations and seeders to prepare the database with default data:

```bash
php artisan migrate --seed
```

The seeders will:

* Create an **admin** user (`admin@example.com`, password: `password`)
* Create default **statuses** (`Pending`, `In Progress`, `Completed`, `Canceled`, `Trashed`)
* Create 3 **regular users**, each with 3 tasks assigned randomly

---


## Authorization & Policies

* **TaskPolicy** controls `viewAny`, `view`, `create`, `update`, `delete` actions on tasks.
* **StatusPolicy** restricts status management to admins only.
* The `before()` method in policies grants **admin** full access before other checks.

---

## Service Layer

All business logic for tasks and statuses is extracted into service classes:

* `App\Services\TaskService`
* `App\Services\StatusService`

Controllers remain thin, focusing on request validation, authorization, and response formatting.

---

## Postman Collection

You can import the API endpoints into Postman using this collection:  
[Open Postman Collection](https://documenter.getpostman.com/view/24693079/2sB2qUnk1q)
