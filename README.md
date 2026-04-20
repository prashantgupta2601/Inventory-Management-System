📦 Inventory Management System – Full Stack PHP Web Application
The Inventory Management System is a lightweight, PHP-based web application designed to help manage and display inventory data through a clean dashboard interface. This beginner-friendly system reads from a static data.json file, supports login/logout features, and provides a simple and effective way to manage products or stock in a small organization.

🚀 Features
🔐 Login/Logout Authentication – Basic session-based login system

📊 Dashboard View – Display inventory records from a JSON data file

📁 JSON-based Storage – Easily configurable and lightweight data storage

🔄 Modular Structure – Clean PHP file organization for each page/view

🧰 Ready for Localhost Deployment – Easily run with XAMPP or any PHP server

🛠️ Tech Stack :
Layer	Technology
Frontend	HTML, CSS (optionally Bootstrap)
Backend	PHP
Data Storage	JSON file (data.json)
Web Server	Apache (XAMPP/LAMP)
Version Ctrl	Git 


inventory-management-system/
│
├── index.php           # Home/Login Page
├── login.php           # Login form and logic
├── logout.php          # Logout and session destroy
├── dashboard.php       # Inventory dashboard after login
├── about.php           # Static informational page
├── data.json           # Inventory data in JSON format
└── .git/               # Git tracking folder


[
  {
    "product_id": "P001",
    "product_name": "Laptop",
    "quantity": 10,
    "price": 750
  },
  {
    "product_id": "P002",
    "product_name": "Mouse",
    "quantity": 50,
    "price": 25
  }
]


🧩 Setup Instructions
✅ Prerequisites
Make sure you have:

PHP (v7.x or later)

Apache server (via XAMPP, LAMP, etc.)
Any modern web browser

🖥️ Installation Steps
1. Download or Clone the Repository:
git clone https://github.com/your-username/inventory-management-system.git

2. Move Project to Web Server Directory
For XAMPP: Move the project folder to:
C:\xampp\htdocs\

3. Start Apache : Open the XAMPP Control Panel and start Apache.
4. Visit in Browser : http://localhost/inventory-management-system/index.php


🔐 Login Details
You can hardcode credentials in login.php for testing:

$username = "admin";
$password = "1234";

After successful login, you will be redirected to dashboard.php.

📈 Dashboard Overview
The dashboard loads data from the data.json file and presents it in a structured table, showing:
Product ID :
Product Name
Quantity Available
Price
(This file can be edited manually or extended for future development)

🔐 Security Note :
This system is intended for learning/demo use. For production:
Use hashed passwords (password_hash() in PHP)
Sanitize all user inputs
Validate and secure sessions


📄 License :
This project is licensed under the MIT License.
Feel free to use, modify, and distribute it as you wish.



