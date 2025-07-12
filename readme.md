# 👕 ReWear – Clothing Swap Platform

ReWear is a sustainable fashion platform built using PHP & MySQL. It allows users to exchange clothes through listing, browsing, requesting swaps, and managing inventory — with a lightweight admin panel for moderation.

---

## 🔧 Technologies Used
- PHP (Backend)
- MySQL (Database)
- Bootstrap 5 (UI Design)
- AOS (Animation on Scroll)

---

## 📂 Folder Structure
rewear/
├── index.php
├── login.php / register.php / logout.php
├── dashboard.php
├── browse.php
├── add_item.php
├── item_detail.php
├── swap_request.php / redeem_item.php
├── admin.php
├── uploads/ # stores item images
└── includes/
├── db.php # DB config
└── auth.php # auth middleware


---

## 🗂️ Database Schema

### `users`
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role VARCHAR(20) DEFAULT 'user',
  points INT DEFAULT 0
);

CREATE TABLE items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  title VARCHAR(100),
  description TEXT,
  category VARCHAR(50),
  type VARCHAR(50),
  size VARCHAR(10),
  item_condition VARCHAR(50),
  tags VARCHAR(200),
  image VARCHAR(255),
  status VARCHAR(20) DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE swap_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_id INT,
  requester_id INT,
  status VARCHAR(20) DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

 Core Features
👤 User System
User Registration & Login

Session-based authentication (auth.php)

Role-based access (admin, user)

Points tracking

🧺 Item Management
Upload new clothing items

Categories, conditions, sizes, tags

View all listed items

Image upload and storage (in uploads/ folder)

🔁 Swapping Logic
Request swap for an item

Accept / Reject swap requests

Track sent & received swaps from the dashboard

🛠️ Admin Panel (admin.php)
Auto-login with admin email

Approve / Reject item listings

View all users and their points

Remove inappropriate content

🧪 Admin Login for Testing
Field	Value
Email	admin@hackathon.com
Password	admin123@

🚀 How to Run (Local)
Install XAMPP and start Apache & MySQL

Place folder inside htdocs (e.g. htdocs/rewear)

Import tables into MySQL (using the SQL above)

Set your DB connection in includes/db.php

php
Copy
Edit
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'rewear';
Run http://localhost/rewear/ in your browser