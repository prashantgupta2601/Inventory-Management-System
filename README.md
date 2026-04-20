# 📦 Inventory Management System

A full-stack PHP web application for managing inventory with AI-powered demand forecasting, interactive analytics, and CSV/PDF export capabilities — built with MySQL, Bootstrap 5, and Chart.js.

[![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-orange?logo=mysql)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?logo=bootstrap)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](./LICENSE)

---

## 🚀 Features

| Feature | Details |
|---|---|
| 🔐 **Secure Authentication** | Session-based login with `password_hash()` and CSRF protection |
| 📊 **Interactive Dashboard** | Inventory overview charts (Chart.js), real-time stats |
| 🤖 **AI Demand Forecasting** | Holt's Linear Trend Model (Double Exponential Smoothing) |
| 📈 **Trend Analysis** | Growth/decline trend percentages with confidence scoring |
| 📉 **Sales Trend Charts** | Per-product monthly sales visualization |
| 📤 **Export Reports** | One-click CSV and PDF reports with AI insights |
| ⚠️ **Low Stock Alerts** | Visual alerts for items below minimum threshold |
| 🌙 **Dark Mode** | Persistent theme toggle with localStorage |
| 🛡️ **Security Hardened** | CSRF tokens on all endpoints, SQL injection protection via Prepared Statements |

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Frontend** | HTML5, Bootstrap 5.3, Chart.js, Bootstrap Icons |
| **Backend** | PHP 8.x |
| **Database** | MySQL 8.x (via `mysqli`) |
| **PDF Generation** | FPDF Library |
| **Web Server** | Apache (XAMPP) |

---

## 📁 Project Structure

```
inventory-system/
├── config.php                          # DB + session + security helpers
├── inventory.php                       # Root-level inventory page
│
└── Inventory-Management-System/
    ├── dashboard.php                   # Main dashboard (charts, table, AI)
    ├── login.php / logout.php          # Auth pages
    ├── add_product.php                 # Add new item form
    ├── edit_product.php                # Edit existing item form
    ├── migrate.php                     # JSON → MySQL migration script
    │
    ├── api/
    │   ├── fetch.php                   # Fetches inventory with AI insights
    │   ├── add.php                     # Adds a product
    │   ├── update.php                  # Updates a product
    │   ├── delete.php                  # Deletes a product
    │   ├── export_csv.php              # CSV export endpoint
    │   ├── export_pdf.php              # PDF export endpoint
    │   └── ForecastingUtil.php         # Holt-Linear forecasting engine
    │
    ├── lib/
    │   └── fpdf.php                    # FPDF library for PDF generation
    │
    └── css/
        └── style.css                   # Custom styling + dark mode
```

---

## ⚙️ Setup Instructions

### Prerequisites
- PHP 8.x
- MySQL 8.x
- Apache (XAMPP recommended)

### 1. Clone the Repository
```bash
git clone https://github.com/prashantgupta2601/Inventory-Management-System.git
```

### 2. Move to Web Server Directory (XAMPP)
```
C:\xampp\htdocs\inventory-system\
```

### 3. Configure the Database
1. Open **XAMPP Control Panel** and start **Apache** and **MySQL**.
2. Create a database named `inventory_db` in phpMyAdmin.
3. Copy `.env.example` to `.env` and fill in your database credentials.
4. Open `config.php` and verify database settings match.

### 4. Run the Migration Script
Navigate to:
```
http://localhost/inventory-system/Inventory-Management-System/migrate.php
```
This will create the `inventory` and `users` tables and populate them.

### 5. Access the Application
```
http://localhost/inventory-system/Inventory-Management-System/login.php
```

> **Default Login**: Created automatically via `migrate.php`. Check the script for credentials.

---

## 🤖 AI Forecasting Model

The system uses **Holt's Linear Trend Model** (Double Exponential Smoothing), which:
- Learns the **level** (baseline demand) from historical data
- Detects **trend** (growth or decline) using two smoothing factors
- Outputs a **next-month forecast** with a **trend percentage** and **confidence score**

This is significantly more accurate than a simple mean for products with consistent growth or seasonal patterns.

---

## 🔐 Security Architecture

- **CSRF Protection**: Session-based tokens injected into all forms and AJAX headers
- **SQL Injection**: 100% of queries use `mysqli` Prepared Statements
- **Password Security**: Passwords stored using `password_hash(PASSWORD_DEFAULT)`
- **HTTP Headers**: `X-Frame-Options`, `X-XSS-Protection`, `X-Content-Type-Options`

---

## 📄 License

This project is licensed under the **MIT License**. Feel free to use, modify, and distribute.
