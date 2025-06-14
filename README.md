# Guest Accommodation System

This project is a web-based Guest Accommodation System for managing room bookings, amenities, services, employees, and customer feedback for a hotel or resort. It is built with PHP, MySQL (MariaDB), and Bootstrap.

---

## Features

- **User Registration & Login** (Customer/Admin)
- **Room Booking** with amenities and services selection
- **Employee Management** (Admin)
- **Service & Amenity Management** (Admin)
- **Booking Management** (Admin)
- **Customer Feedback & Ratings**
- **Payment Tracking**
- **Responsive UI** with Bootstrap

---

## Database Structure

The system uses a MySQL database named `guest_accommodation_system` with the following main tables:

- **administrator**: Admin login credentials
- **customer**: Customer information
- **employee**: Employee records (linked to admin)
- **room**: Room types, rates, and capacity
- **service**: List of available services
- **amenity**: List of available amenities
- **booking**: Main booking records (linked to customer, employee)
- **bookingroom**: Links bookings to rooms
- **bookingamenity**: Links bookings to amenities
- **bookingservice**: Links bookings to services
- **feedback**: Customer feedback and ratings
- **payment**: Payment records

**See `IM/guest_accommodation_system (2).sql` for full schema and sample data.**

---

## Setup Instructions

1. **Clone or Download the Project**

2. **Import the Database**
   - Open phpMyAdmin or your MySQL client.
   - Import `IM/guest_accommodation_system (2).sql` to create all tables and sample data.

3. **Configure Database Connection**
   - Edit `classes/database.php` and set your MySQL credentials in the connection method.

4. **Run the Project**
   - Place the project folder in your XAMPP/WAMP `htdocs` directory.
   - Start Apache and MySQL.
   - Access via `http://localhost/Finals_WST&DBS/`

---

## Usage

- **Admin Login:** Use credentials from the `administrator` table (see SQL file).
- **Customer Registration:** Customers can register and book rooms.
- **Booking:** Customers select rooms, amenities, and services, then submit bookings.
- **Admin Panel:** Admins can manage rooms, amenities, services, employees, bookings, and view feedback.

---

## Table Relationships

- **booking** links to **customer** and optionally **employee**
- **bookingroom**, **bookingamenity**, **bookingservice** link bookings to rooms, amenities, and services
- **feedback** links to both **customer** and **booking**
- **payment** links to **booking**

---

## Sample Admin Credentials

Check the `administrator` table in the SQL file for default admin emails and passwords.

---

## Screenshots

*(Add screenshots of the homepage, booking form, admin dashboard, etc.)*

---

## License

This project is for educational purposes.
Created by Group Olap

---
