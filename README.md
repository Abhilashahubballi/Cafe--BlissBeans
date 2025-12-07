# Bliss Beans Café Table Booking System

## 📌 Overview
Bliss Beans is a simple web-based table booking system for a café. 
Customers can select a date, time slot, and table number to reserve a seat, and the admin can view and manage all bookings.

The project is built using **PHP** and **MySQL** with a frontend in HTML/CSS/JavaScript.

## ✨ Features
- Customer-facing booking form with:
  - Name, phone, email, number of guests
  - Booking date
  - Time slot selection
  - Table number selection
- Prevents double booking of the same table, date, and time slot.
- Admin panel to:
  - View all bookings
  - Delete bookings if needed
- Basic alert messages for success and error handling.

## 🛠 Tech Stack
- **Backend**: PHP (mysqli)
- **Database**: MySQL (e.g., XAMPP / phpMyAdmin)
- **Frontend**: HTML, CSS, JavaScript
- **Other**: Basic PHP sessions / forms

## 📂 Project Structure
```bash
bliss-beans-booking/
├── admin_bookings.php      # Admin panel to manage bookings
├── book_table.php          # Booking logic & database save
├── index.html              # Main landing page / booking UI
├── css/                    # Stylesheets
├── js/                     # JavaScript files
├── images/                 # Static images (UI assets)
└── webfonts/               # Font files
```

## 🗄 Database Setup

1. Create a database named `coffee_shop` in phpMyAdmin (or MySQL CLI):

```sql
CREATE DATABASE coffee_shop;
```

2. Inside the `coffee_shop` database, create the `table_bookings` table (if your code does not auto-create it):

```sql
CREATE TABLE IF NOT EXISTS table_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    guests INT NOT NULL,
    booking_date DATE NOT NULL,
    time_slot VARCHAR(50) NOT NULL,
    table_no VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

> Note: In the code, the table is created automatically with `CREATE TABLE IF NOT EXISTS`, but you can also create it manually using the SQL above.

3. Update the database connection details in both `book_table.php` and `admin_bookings.php` if needed:

```php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "coffee_shop";
```

## ▶ How to Run (Locally with XAMPP)

1. Install **XAMPP** and start **Apache** and **MySQL**.
2. Copy the `bliss-beans-booking` folder into your `htdocs` directory:

```text
C:/xampp/htdocs/bliss-beans-booking
```

3. Create the `coffee_shop` database in phpMyAdmin and the `table_bookings` table (or let `book_table.php` create it automatically).
4. Visit the application in your browser:

```text
http://localhost/bliss-beans-booking/index.html
```

5. To access the admin bookings page:

```text
http://localhost/bliss-beans-booking/admin_bookings.php
```

## 🚀 Future Improvements
- Add authentication for admin login.
- Add pagination and filters for bookings.
- Send email/SMS confirmation to customers.
- Improve UI with better responsive design.

## 🙌 Author
Developed by **Abhilasha Hubballi** as part of a web development project.
