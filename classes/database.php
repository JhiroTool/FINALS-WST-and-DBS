<?php

class Database {
    private $host = "localhost";
    private $db_name = "guest_accommodation_system";
    private $username = "root";
    private $password = ""; // Change if your MySQL has a password
    public $conn;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->db_name
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Optional: Get the connection
    public function getConnection() {
        return $this->conn;
    }

    public function registerAdmin($email, $password) {
        $conn = $this->getConnection();
        // Check if email exists
        $stmt = $conn->prepare("SELECT Admin_ID FROM administrator WHERE Admin_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return ['success' => false, 'message' => 'Email already registered.'];
        }
        $stmt->close();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO administrator (Admin_Email, Admin_Password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password);
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'message' => 'Admin account created.'];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'An error occurred. Please try again.'];
        }
    }

    public function registerCustomer($fname, $lname, $email, $phone, $password) {
        $conn = $this->getConnection();

        // Check if email already exists
        $stmt = $conn->prepare("SELECT Cust_ID FROM customer WHERE Cust_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return ['success' => false, 'message' => 'Email already registered.'];
        }
        $stmt->close();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO customer (Cust_FN, Cust_LN, Cust_Email, Cust_Phone, Cust_Password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fname, $lname, $email, $phone, $hashed_password);
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'message' => 'You can now log in.'];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'An error occurred. Please try again.'];
        }
    }

    public function addAmenity($name, $desc, $cost) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO amenity (Amenity_Name, Amenity_Desc, Amenity_Cost) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $desc, $cost);
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Error adding amenity.'];
        }
    }

    public function addRoom($type, $rate, $cap) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO room (Room_Type, Room_Rate, Room_Cap) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $type, $rate, $cap);
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Error adding room.'];
        }
    }

    public function deleteAmenity($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM amenity WHERE Amenity_ID = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getRoomById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM room WHERE Room_ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $room = $result->fetch_assoc();
        $stmt->close();
        return $room;
    }

    public function updateRoom($id, $type, $rate, $cap) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE room SET Room_Type=?, Room_Rate=?, Room_Cap=? WHERE Room_ID=?");
        $stmt->bind_param("sdii", $type, $rate, $cap, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function deleteRoom($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM room WHERE Room_ID = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function loginUser($email, $password) {
        $stmt = $this->conn->prepare("SELECT Cust_ID, Cust_FN, Cust_Password, is_banned FROM customer WHERE Cust_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['Cust_Password'])) {
                return [
                    'success' => true,
                    'user_id' => $row['Cust_ID'],
                    'user_FN' => $row['Cust_FN'],
                    'user_type' => 'user',
                    'is_banned' => $row['is_banned'],
                    'redirect' => 'homepage.php'
                ];
            } else {
                return ['success' => false, 'message' => 'Incorrect password.'];
            }
        } else {
            return ['success' => false, 'message' => 'Email not found.'];
        }
    }

    public function getAllAmenities() {
        $conn = $this->getConnection();
        $result = $conn->query("SELECT * FROM amenity");
        $amenities = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $amenities[] = $row;
            }
            $result->free();
        }
        return $amenities;
    }

    public function getAllRooms() {
        $conn = $this->getConnection();
        $result = $conn->query("SELECT * FROM room");
        $rooms = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rooms[] = $row;
            }
            $result->free();
        }
        return $rooms;
    }

    public function getAmenityById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM amenity WHERE Amenity_ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $amenity = $result->fetch_assoc();
        $stmt->close();
        return $amenity;
    }

    public function updateAmenity($id, $name, $desc, $cost) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE amenity SET Amenity_Name=?, Amenity_Desc=?, Amenity_Cost=? WHERE Amenity_ID=?");
        $stmt->bind_param("ssdi", $name, $desc, $cost, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getAllCustomers() {
        $conn = $this->getConnection();
        $result = $conn->query("SELECT * FROM customer");
        $customers = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            $result->free();
        }
        return $customers;
    }

    public function getAllBookings() {
        $conn = $this->getConnection();
        $result = $conn->query("SELECT * FROM booking");
        $bookings = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
            $result->free();
        }
        return $bookings;
    }

    public function getAllBookingsWithCustomer() {
        $conn = $this->getConnection();
        $sql = "SELECT b.*, c.Cust_FN, c.Cust_LN, c.Cust_Email
                FROM booking b
                LEFT JOIN customer c ON b.Cust_ID = c.Cust_ID";
        $result = $conn->query($sql);
        $bookings = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
            $result->free();
        }
        return $bookings;
    }

    public function addBooking($cust_id, $emp_id, $in, $out, $cost, $status, $roomType, $guests) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO booking (Cust_ID, Emp_ID, Booking_IN, Booking_Out, Booking_Cost, Booking_Status, Room_Type, Guests) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissdssi", $cust_id, $emp_id, $in, $out, $cost, $status, $roomType, $guests);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function bookRoom($cust_id, $check_in, $check_out, $guests, $cost, $status, $emp_id = null) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO booking (Cust_ID, Emp_ID, Booking_IN, Booking_Out, Booking_Cost, Booking_Status, Guests)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissdsi", $cust_id, $emp_id, $check_in, $check_out, $cost, $status, $guests);
        $result = $stmt->execute();
        $booking_id = $stmt->insert_id;
        $stmt->close();
        return $result ? $booking_id : false;
    }

    public function getAllEmployees() {
        $stmt = $this->conn->prepare("SELECT * FROM employee");
        $stmt->execute();
        $result = $stmt->get_result();
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        return $employees;
    }

    public function addBookingRoom($booking_id, $room_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO bookingroom (Booking_ID, Room_ID) VALUES (?, ?)");
        $stmt->bind_param("ii", $booking_id, $room_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function addBookingAmenity($booking_id, $amenity_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO bookingamenity (Booking_ID, Amenity_ID) VALUES (?, ?)");
        $stmt->bind_param("ii", $booking_id, $amenity_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function addFeedback($cust_id, $booking_id, $rating, $comment) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO feedback (Cust_ID, Booking_ID, Feed_Rating, Feed_Comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iids", $cust_id, $booking_id, $rating, $comment);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getRecentFeedback($limit = 10) {
        $conn = $this->getConnection();
        $sql = "SELECT f.Feed_Rating, f.Feed_Comment, f.Feed_DOF, c.Cust_FN 
                FROM feedback f 
                JOIN customer c ON f.Cust_ID = c.Cust_ID 
                ORDER BY f.Feed_DOF DESC 
                LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $feedbacks = [];
        while ($row = $result->fetch_assoc()) {
            $feedbacks[] = $row;
        }
        $stmt->close();
        return $feedbacks;
    }

    public function getAllServices() {
        $conn = $this->getConnection();
        $result = $conn->query("SELECT * FROM service");
        $services = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $services[] = $row;
            }
        }
        return $services;
    }

    // CREATE
    public function addService($name, $desc, $cost) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO service (Service_Name, Service_Desc, Service_Cost) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $desc, $cost);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // UPDATE
    public function updateService($id, $name, $desc, $cost) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE service SET Service_Name=?, Service_Desc=?, Service_Cost=? WHERE Service_ID=?");
        $stmt->bind_param("ssdi", $name, $desc, $cost, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // DELETE
    public function deleteService($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM service WHERE Service_ID=?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // GET BY ID (for editing)
    public function getServiceById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM service WHERE Service_ID=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $service = $result->fetch_assoc();
        $stmt->close();
        return $service;
    }

    public function addBookingService($booking_id, $service_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO bookingservice (Booking_ID, Service_ID) VALUES (?, ?)");
        $stmt->bind_param("ii", $booking_id, $service_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getPaymentsByBooking($booking_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Payment_ID, Payment_Amount, Payment_Method, Payment_Date FROM payment WHERE Booking_ID = ? ORDER BY Payment_Date DESC");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $payments = [];
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
        $stmt->close();
        return $payments;
    }

    // Get current or booking-date-based room price (promo or regular)
    public function getRoomPrice($room_id, $default_price, $ref_date = null) {
        $conn = $this->getConnection();
        $date = $ref_date ?: date('Y-m-d H:i:s');
        $stmt = $conn->prepare("SELECT Price FROM roomprices WHERE Room_ID = ? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidT DESC LIMIT 1");
        $stmt->bind_param("is", $room_id, $date);
        $stmt->execute();
        $stmt->bind_result($promo_price);
        if ($stmt->fetch()) {
            $stmt->close();
            return $promo_price;
        }
        $stmt->close();
        return $default_price;
    }

    // Get current or booking-date-based amenity price (promo or regular)
    public function getAmenityPrice($amenity_id, $default_price, $ref_date = null) {
        $conn = $this->getConnection();
        $date = $ref_date ?: date('Y-m-d H:i:s');
        $stmt = $conn->prepare("SELECT Price FROM amenityprices WHERE Amenity_ID = ? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidT DESC LIMIT 1");
        $stmt->bind_param("is", $amenity_id, $date);
        $stmt->execute();
        $stmt->bind_result($promo_price);
        if ($stmt->fetch()) {
            $stmt->close();
            return $promo_price;
        }
        $stmt->close();
        return $default_price;
    }

    // Get current or booking-date-based service price (promo or regular)
    public function getServicePrice($service_id, $default_price, $ref_date = null) {
        $conn = $this->getConnection();
        $date = $ref_date ?: date('Y-m-d H:i:s');
        $stmt = $conn->prepare("SELECT Price FROM serviceprices WHERE Service_ID = ? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidT DESC LIMIT 1");
        $stmt->bind_param("is", $service_id, $date);
        $stmt->execute();
        $stmt->bind_result($promo_price);
        if ($stmt->fetch()) {
            $stmt->close();
            return $promo_price;
        }
        $stmt->close();
        return $default_price;
    }
}
?>