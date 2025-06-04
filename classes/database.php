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
        $conn = $this->getConnection();

        // Check administrator
        $stmt = $conn->prepare("SELECT Admin_ID, Admin_Email, Admin_Password FROM administrator WHERE Admin_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $adminResult = $stmt->get_result();
        if ($admin = $adminResult->fetch_assoc()) {
            if (password_verify($password, $admin['Admin_Password'])) {
                $stmt->close();
                return [
                    'success' => true,
                    'user_id' => $admin['Admin_ID'],
                    'user_type' => 'admin',
                    'user_FN' => 'Administrator',
                    'redirect' => 'admin_homepage.php'
                ];
            } else {
                $stmt->close();
                return ['success' => false, 'message' => 'Invalid password.'];
            }
        }
        $stmt->close();

        // Check customer
        $stmt = $conn->prepare("SELECT Cust_ID, Cust_FN, Cust_Email, Cust_Password FROM customer WHERE Cust_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $custResult = $stmt->get_result();
        if ($cust = $custResult->fetch_assoc()) {
            if (password_verify($password, $cust['Cust_Password'])) {
                $stmt->close();
                return [
                    'success' => true,
                    'user_id' => $cust['Cust_ID'],
                    'user_type' => 'customer',
                    'user_FN' => $cust['Cust_FN'],
                    'redirect' => 'homepage.php'
                ];
            } else {
                $stmt->close();
                return ['success' => false, 'message' => 'Invalid password.'];
            }
        }
        $stmt->close();

        return ['success' => false, 'message' => 'No user found with that email.'];
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
}
?>