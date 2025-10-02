# 💳 Cards Management System

A full-stack CRUD application for managing payment cards with user authentication. Built with Laravel (backend API) and Vue.js (frontend).

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)

## ✨ Features

- 🔐 **User Authentication** - Secure login and registration system
- 📇 **Card Management** - Full CRUD operations (Create, Read, Update, Delete)
- ✅ **Data Validation** - Comprehensive form validation
- 🎨 **Modern UI** - Responsive Vue.js interface
- 🔒 **Authorization** - Users can only manage their own cards

## 🛠️ Tech Stack

### Backend
- **Laravel 11.x** - PHP framework
- **MySQL** - Database
- **Laravel Sanctum** - API authentication
- **PHP 8.2+**

### Frontend
- **Vue.js 3** - JavaScript framework
- **Vue Router** - Routing
- **Pinia** - State management
- **Axios** - HTTP client
- **Vite** - Build tool

## 📦 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- MySQL >= 8.0
- Git

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/martynaszozda/cards-management-system.git
cd cards-management-system
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node.js dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cards_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

## 🗄️ Database Setup

### Option 1: Using Laravel Migrations (Recommended)

```bash
# Run migrations
php artisan migrate

# (Optional) Seed with sample data
php artisan db:seed
```

### Option 2: Using SQL File

Import the provided SQL file

## 🎮 Usage

### 1. Start the Laravel development server

```bash
php artisan serve
```

The API will be available at: `http://localhost:8000`

### 2. Start the Vite development server

In a new terminal:

```bash
npm run dev
```

The frontend will be available at: `http://localhost:5173`

### 3. Default Test User

```
Email: test@example.com
Password: password
```


## 🗃️ Database Schema

### Cards Table

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| user_id | BIGINT | Foreign key to users |
| card_number | VARCHAR(20) | 20-digit card number (unique) |
| pin | VARCHAR(4) | 4-digit PIN |
| activation_date | DATETIME | Card activation date and time |
| expiry_date | DATE | Card expiration date |
| balance | DECIMAL(10,2) | Card balance |
| created_at | TIMESTAMP | Record creation time |
| updated_at | TIMESTAMP | Record update time |

### Validation Rules

- **Card Number**: Required, exactly 20 digits, unique
- **PIN**: Required, exactly 4 digits
- **Activation Date**: Required, valid datetime
- **Expiry Date**: Required, must be after activation date
- **Balance**: Required, numeric, min: 0, max: 999,999.99

## 🧪 Testing

Run PHP tests:

```bash
php artisan test
```


Made with ❤️ for recruitment purpose
