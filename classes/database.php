<?php

class Database {
    private $host = "localhost";
    private $db_name = "guest_accommodation_system";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function registerAdmin($email, $password) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Admin_ID FROM administrator WHERE Admin_Email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email already registered.'];
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO administrator (Admin_Email, Admin_Password) VALUES (?, ?)");
        if ($stmt->execute([$email, $hashed_password])) {
            return ['success' => true, 'message' => 'Admin account created.'];
        } else {
            return ['success' => false, 'message' => 'An error occurred. Please try again.'];
        }
    }

    public function registerCustomer($fname, $lname, $email, $phone, $password) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Cust_ID FROM customer WHERE Cust_Email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email already registered.'];
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO customer (Cust_FN, Cust_LN, Cust_Email, Cust_Phone, Cust_Password) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$fname, $lname, $email, $phone, $hashed_password])) {
            return ['success' => true, 'message' => 'You can now log in.'];
        } else {
            return ['success' => false, 'message' => 'An error occurred. Please try again.'];
        }
    }

    public function addAmenity($name, $desc, $cost) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO amenity (Amenity_Name, Amenity_Desc, Amenity_Cost) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $desc, $cost])) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error adding amenity.'];
        }
    }

    public function addRoom($type, $rate, $cap) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO room (Room_Type, Room_Rate, Room_Cap) VALUES (?, ?, ?)");
        if ($stmt->execute([$type, $rate, $cap])) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error adding room.'];
        }
    }

    public function deleteAmenity($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM amenity WHERE Amenity_ID = ?");
        return $stmt->execute([$id]);
    }

    public function getRoomById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM room WHERE Room_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateRoom($id, $type, $rate, $cap) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE room SET Room_Type=?, Room_Rate=?, Room_Cap=? WHERE Room_ID=?");
        return $stmt->execute([$type, $rate, $cap, $id]);
    }

    public function deleteRoom($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM room WHERE Room_ID = ?");
        return $stmt->execute([$id]);
    }

    public function loginUser($email, $password) {
        // Check customer table
        $stmt = $this->conn->prepare("SELECT Cust_ID, Cust_FN, Cust_Password, is_banned FROM customer WHERE Cust_Email = ?");
        $stmt->execute([$email]);
        if ($row = $stmt->fetch()) {
            $db_password = $row['Cust_Password'];
            if (
                (strlen($db_password) > 20 && password_verify($password, $db_password)) ||
                $password === $db_password
            ) {
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
        }

        // Check administrator table
        $stmt = $this->conn->prepare("SELECT Admin_ID, Admin_Email, Admin_Password FROM administrator WHERE Admin_Email = ?");
        $stmt->execute([$email]);
        if ($row = $stmt->fetch()) {
            if (password_verify($password, $row['Admin_Password'])) {
                return [
                    'success' => true,
                    'user_id' => $row['Admin_ID'],
                    'user_FN' => 'Admin',
                    'user_type' => 'admin',
                    'is_banned' => false,
                    'redirect' => 'admin_homepage.php'
                ];
            } else {
                return ['success' => false, 'message' => 'Incorrect password.'];
            }
        }

        return ['success' => false, 'message' => 'Email not found.'];
    }

    public function getAllAmenities() {
        $conn = $this->getConnection();
        $stmt = $conn->query("SELECT * FROM amenity");
        return $stmt->fetchAll();
    }

    public function getAllRooms() {
        $conn = $this->getConnection();
        $stmt = $conn->query("SELECT Room_ID, Room_Type, Room_Rate, Room_Cap, Room_Status FROM room");
        return $stmt->fetchAll();
    }

    public function getAmenityById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM amenity WHERE Amenity_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateAmenity($id, $name, $desc, $cost) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE amenity SET Amenity_Name=?, Amenity_Desc=?, Amenity_Cost=? WHERE Amenity_ID=?");
        return $stmt->execute([$name, $desc, $cost, $id]);
    }

    public function getAllCustomers() {
        $conn = $this->getConnection();
        $stmt = $conn->query("SELECT * FROM customer");
        return $stmt->fetchAll();
    }

    public function getAllBookings() {
        $conn = $this->getConnection();
        $stmt = $conn->query("SELECT * FROM booking");
        return $stmt->fetchAll();
    }

    public function getAllBookingsWithCustomer() {
        $conn = $this->getConnection();
        $sql = "SELECT b.*, c.Cust_FN, c.Cust_LN, c.Cust_Email
                FROM booking b
                LEFT JOIN customer c ON b.Cust_ID = c.Cust_ID";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll();
    }

    public function addBooking($cust_id, $emp_id, $in, $out, $cost, $status, $roomType, $guests) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO booking (Cust_ID, Emp_ID, Booking_IN, Booking_Out, Booking_Cost, Booking_Status, Room_Type, Guests) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$cust_id, $emp_id, $in, $out, $cost, $status, $roomType, $guests]);
    }

    public function bookRoom($cust_id, $check_in, $check_out, $guests, $cost, $status, $emp_id = null) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO booking (Cust_ID, Emp_ID, Booking_IN, Booking_Out, Booking_Cost, Booking_Status, Guests)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cust_id, $emp_id, $check_in, $check_out, $cost, $status, $guests]);
        return $conn->lastInsertId();
    }

    public function addBookingWithRoom($cust_id, $emp_id, $checkIn, $checkOut, $cost, $status, $guests, $room_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO booking (Cust_ID, Emp_ID, Booking_IN, Booking_Out, Booking_Cost, Booking_Status, Guests)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        if (!$stmt->execute([$cust_id, $emp_id, $checkIn, $checkOut, $cost, $status, $guests])) {
            return false;
        }
        $booking_id = $conn->lastInsertId();

        $stmt2 = $conn->prepare("INSERT INTO bookingroom (Booking_ID, Room_ID) VALUES (?, ?)");
        if (!$stmt2->execute([$booking_id, $room_id])) {
            return false;
        }

        return $booking_id;
    }

    public function getAllEmployees() {
        $stmt = $this->conn->query("SELECT * FROM employee");
        return $stmt->fetchAll();
    }

    public function addBookingRoom($booking_id, $room_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO bookingroom (Booking_ID, Room_ID) VALUES (?, ?)");
        return $stmt->execute([$booking_id, $room_id]);
    }

    public function addBookingAmenity($booking_id, $amenity_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO bookingamenity (Booking_ID, Amenity_ID) VALUES (?, ?)");
        return $stmt->execute([$booking_id, $amenity_id]);
    }

    public function getLatestBookingId($cust_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Booking_ID FROM booking WHERE Cust_ID = ? ORDER BY Booking_ID DESC LIMIT 1");
        $stmt->execute([$cust_id]);
        $row = $stmt->fetch();
        return $row ? $row['Booking_ID'] : null;
    }

    public function addFeedback($cust_id, $booking_id, $rating, $comment) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO feedback (Cust_ID, Booking_ID, Feed_Rating, Feed_Comment) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$cust_id, $booking_id, $rating, $comment]);
    }

    public function getRecentFeedback($limit = 5) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare(
            "SELECT f.Feed_Rating, f.Feed_Comment, f.Feed_DOF, c.Cust_FN 
             FROM feedback f 
             JOIN customer c ON f.Cust_ID = c.Cust_ID 
             ORDER BY f.Feed_DOF DESC LIMIT ?"
        );
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllServices() {
        $conn = $this->getConnection();
        $stmt = $conn->query("SELECT * FROM service");
        return $stmt->fetchAll();
    }

    public function addService($name, $desc, $cost) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO service (Service_Name, Service_Desc, Service_Cost) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $desc, $cost]);
    }

    public function updateService($id, $name, $desc, $cost) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE service SET Service_Name=?, Service_Desc=?, Service_Cost=? WHERE Service_ID=?");
        return $stmt->execute([$name, $desc, $cost, $id]);
    }

    public function deleteService($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM service WHERE Service_ID=?");
        return $stmt->execute([$id]);
    }

    public function getServiceById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM service WHERE Service_ID=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function addBookingService($booking_id, $service_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO bookingservice (Booking_ID, Service_ID) VALUES (?, ?)");
        return $stmt->execute([$booking_id, $service_id]);
    }

    public function getPaymentsByBooking($booking_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Payment_ID, Payment_Amount, Payment_Method, Payment_Date FROM payment WHERE Booking_ID = ? ORDER BY Payment_Date DESC");
        $stmt->execute([$booking_id]);
        return $stmt->fetchAll();
    }

    public function getRoomPrice($room_id, $default_price, $ref_date = null) {
        $conn = $this->getConnection();
        $date = $ref_date ?: date('Y-m-d H:i:s');
        $stmt = $conn->prepare("SELECT Price FROM roomprices WHERE Room_ID = ? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidT DESC LIMIT 1");
        $stmt->execute([$room_id, $date]);
        $row = $stmt->fetch();
        return $row ? $row['Price'] : $default_price;
    }

    public function getAmenityPrice($amenity_id, $default_price, $ref_date = null) {
        $conn = $this->getConnection();
        $date = $ref_date ?: date('Y-m-d H:i:s');
        $stmt = $conn->prepare("SELECT Price FROM amenityprices WHERE Amenity_ID = ? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidT DESC LIMIT 1");
        $stmt->execute([$amenity_id, $date]);
        $row = $stmt->fetch();
        return $row ? $row['Price'] : $default_price;
    }

    public function getServicePrice($service_id, $default_price, $ref_date = null) {
        $conn = $this->getConnection();
        $date = $ref_date ?: date('Y-m-d H:i:s');
        $stmt = $conn->prepare("SELECT Price FROM serviceprices WHERE Service_ID = ? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidT DESC LIMIT 1");
        $stmt->execute([$service_id, $date]);
        $row = $stmt->fetch();
        return $row ? $row['Price'] : $default_price;
    }

    public function customerExists($email = null, $phone = null) {
        $conn = $this->getConnection();
        if ($email && $phone) {
            $stmt = $conn->prepare("SELECT Cust_ID, Cust_Email, Cust_Phone FROM customer WHERE Cust_Email = ? OR Cust_Phone = ?");
            $stmt->execute([$email, $phone]);
        } elseif ($email) {
            $stmt = $conn->prepare("SELECT Cust_ID, Cust_Email FROM customer WHERE Cust_Email = ?");
            $stmt->execute([$email]);
        } elseif ($phone) {
            $stmt = $conn->prepare("SELECT Cust_ID, Cust_Phone FROM customer WHERE Cust_Phone = ?");
            $stmt->execute([$phone]);
        } else {
            return false;
        }
        $row = $stmt->fetch();
        return $row ? $row : false;
    }

    public function recordPayment($booking_id, $amount, $method) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Payment_ID FROM payment WHERE Booking_ID = ?");
        $stmt->execute([$booking_id]);
        $exists = $stmt->fetch();

        if ($exists) {
            $stmt = $conn->prepare("UPDATE payment SET Payment_Amount=?, Payment_Method=? WHERE Booking_ID=?");
            $success = $stmt->execute([$amount, $method, $booking_id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO payment (Booking_ID, Payment_Amount, Payment_Method) VALUES (?, ?, ?)");
            $success = $stmt->execute([$booking_id, $amount, $method]);
        }

        if ($success) {
            $update = $conn->prepare("UPDATE booking SET Booking_Status = 'Paid' WHERE Booking_ID = ?");
            $update->execute([$booking_id]);
            return true;
        } else {
            return false;
        }
    }

    public function getBookingAmount($booking_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Booking_Cost FROM booking WHERE Booking_ID = ?");
        $stmt->execute([$booking_id]);
        $row = $stmt->fetch();
        return $row ? $row['Booking_Cost'] : null;
    }

    public function getServicePromoById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM serviceprices WHERE SP_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateServicePromo($id, $price, $from, $to) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE serviceprices SET Price=?, PromValidF=?, PromValidT=? WHERE SP_ID=?");
        return $stmt->execute([$price, $from, $to, $id]);
    }

    public function getRoomPromoById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM roomprices WHERE Price_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateRoomPromo($id, $price, $from, $to) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE roomprices SET Price=?, PromValidF=?, PromValidT=? WHERE Price_ID=?");
        return $stmt->execute([$price, $from, $to, $id]);
    }

    public function getEmployeeById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM employee WHERE Emp_ID=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateEmployee($id, $fname, $lname, $email, $phone) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE employee SET Emp_FN=?, Emp_LN=?, Emp_Email=?, Emp_Phone=? WHERE Emp_ID=?");
        return $stmt->execute([$fname, $lname, $email, $phone, $id]);
    }

    public function getAmenityPromoById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM amenityprices WHERE AP_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateAmenityPromo($id, $price, $from, $to) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE amenityprices SET Price=?, PromValidF=?, PromValidT=? WHERE AP_ID=?");
        return $stmt->execute([$price, $from, $to, $id]);
    }

    public function deleteServicePromo($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM serviceprices WHERE SP_ID = ?");
        return $stmt->execute([$id]);
    }

    public function deleteRoomPromo($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM roomprices WHERE RP_ID = ?");
        return $stmt->execute([$id]);
    }

    public function deleteAmenityPromo($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM amenityprices WHERE AP_ID = ?");
        return $stmt->execute([$id]);
    }

    public function getCustomerById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM customer WHERE Cust_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function banCustomer($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE customer SET is_banned = 1 WHERE Cust_ID = ?");
        return $stmt->execute([$id]);
    }

    public function assignTaskToEmployee($id, $task) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE employee SET Emp_Role=? WHERE Emp_ID=?");
        return $stmt->execute([$task, $id]);
    }

    public function getAllAmenityPromos() {
        $conn = $this->getConnection();
        $stmt = $conn->query("SELECT ap.*, a.Amenity_Name FROM amenityprices ap JOIN amenity a ON ap.Amenity_ID = a.Amenity_ID ORDER BY ap.PromValidF DESC");
        return $stmt->fetchAll();
    }

    public function getAllRoomPromos() {
        $conn = $this->getConnection();
        $stmt = $conn->query("SELECT rp.*, r.Room_Type FROM roomprices rp JOIN room r ON rp.Room_ID = r.Room_ID ORDER BY rp.PromValidF DESC");
        return $stmt->fetchAll();
    }

    public function getAllServicePromos() {
        $conn = $this->getConnection();
        $stmt = $conn->query("SELECT sp.*, s.Service_Name FROM serviceprices sp JOIN service s ON sp.Service_ID = s.Service_ID ORDER BY sp.PromValidF DESC");
        return $stmt->fetchAll();
    }

    public function addServicePromo($service_id, $price, $from, $to) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO serviceprices (Service_ID, Price, PromValidF, PromValidT) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$service_id, $price, $from, $to]);
    }

    public function addRoomPromo($room_id, $price, $from, $to) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO roomprices (Room_ID, Price, PromValidF, PromValidT) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$room_id, $price, $from, $to]);
    }

    public function addEmployee($fname, $lname, $email, $phone, $admin_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO employee (Emp_FN, Emp_LN, Emp_Email, Emp_Phone, Admin_ID) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$fname, $lname, $email, $phone, $admin_id]);
    }

    public function addAmenityPromo($amenity_id, $price, $from, $to) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO amenityprices (Amenity_ID, Price, PromValidF, PromValidT) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$amenity_id, $price, $from, $to]);
    }

    public function getActiveRoomPromo($room_id, $date) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM roomprices WHERE Room_ID=? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidF DESC LIMIT 1");
        $stmt->execute([$room_id, $date]);
        return $stmt->fetch();
    }

    public function getActiveAmenityPromo($amenity_id, $date) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM amenityprices WHERE Amenity_ID=? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidF DESC LIMIT 1");
        $stmt->execute([$amenity_id, $date]);
        return $stmt->fetch();
    }

    public function getActiveServicePromo($service_id, $date) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM serviceprices WHERE Service_ID=? AND ? BETWEEN PromValidF AND PromValidT ORDER BY PromValidF DESC LIMIT 1");
        $stmt->execute([$service_id, $date]);
        return $stmt->fetch();
    }

    public function getLatestUnpaidBooking($cust_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM booking WHERE Cust_ID=? AND Booking_Status='Pending' ORDER BY Booking_IN DESC LIMIT 1");
        $stmt->execute([$cust_id]);
        return $stmt->fetch();
    }

    public function addPaymentWithReceipt($booking_id, $amount, $method, $filename) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("INSERT INTO payment (Booking_ID, Payment_Amount, Payment_Method, Receipt_Image, Payment_DOF) VALUES (?, ?, ?, ?, NOW())");
        $success = $stmt->execute([$booking_id, $amount, $method, $filename]);

        if ($success) {
            $update = $conn->prepare("UPDATE booking SET Booking_Status = 'For Verification' WHERE Booking_ID = ?");
            $update->execute([$booking_id]);
        }

        return $success;
    }

    public function upsertPaymentWithReceipt($booking_id, $amount, $method, $filename) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Payment_ID FROM payment WHERE Booking_ID = ?");
        $stmt->execute([$booking_id]);
        $exists = $stmt->fetch();

        if ($exists) {
            $stmt = $conn->prepare("UPDATE payment SET Payment_Amount=?, Payment_Method=?, Receipt_Image=?, Payment_DOF=NOW() WHERE Booking_ID=?");
            $success = $stmt->execute([$amount, $method, $filename, $booking_id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO payment (Booking_ID, Payment_Amount, Payment_Method, Receipt_Image, Payment_DOF) VALUES (?, ?, ?, ?, NOW())");
            $success = $stmt->execute([$booking_id, $amount, $method, $filename]);
        }

        if ($success) {
            $update = $conn->prepare("UPDATE booking SET Booking_Status = 'For Verification' WHERE Booking_ID = ?");
            $update->execute([$booking_id]);
        }

        return $success;
    }

    public function handleAdminPayment($booking_id, $amount, $method, $file) {
        $filename = '';
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $uploadFileDir = './uploaded_receipts/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }
            $fileName = basename($file['name']);
            $dest_path = $uploadFileDir . $fileName;
            if (move_uploaded_file($file['tmp_name'], $dest_path)) {
                $filename = $fileName;
            } else {
                return ['success' => false, 'message' => "Failed to move uploaded file."];
            }
        }

        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Payment_ID FROM payment WHERE Booking_ID = ?");
        $stmt->execute([$booking_id]);
        $exists = $stmt->fetch();

        if ($exists) {
            $stmt = $conn->prepare("UPDATE payment SET Payment_Amount=?, Payment_Method=?, Receipt_Image=?, Payment_DOF=NOW() WHERE Booking_ID=?");
            $success = $stmt->execute([$amount, $method, $filename, $booking_id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO payment (Booking_ID, Payment_Amount, Payment_Method, Receipt_Image, Payment_DOF) VALUES (?, ?, ?, ?, NOW())");
            $success = $stmt->execute([$booking_id, $amount, $method, $filename]);
        }

        if ($success) {
            return ['success' => true, 'message' => "Payment recorded successfully!"];
        } else {
            return ['success' => false, 'message' => "Failed to record payment."];
        }
    }

    public function getPaymentByBookingId($booking_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM payment WHERE Booking_ID = ?");
        $stmt->execute([$booking_id]);
        return $stmt->fetch();
    }

    public function markBookingAsPaid($booking_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE booking SET Booking_Status = 'Paid' WHERE Booking_ID = ?");
        $success = $stmt->execute([$booking_id]);

        if ($success) {
            $this->markRoomAsUnavailableByBooking($booking_id);
        }
        return $success;
    }

    public function markRoomAsUnavailableByBooking($booking_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Room_ID FROM bookingroom WHERE Booking_ID = ?");
        $stmt->execute([$booking_id]);
        if ($row = $stmt->fetch()) {
            $room_id = $row['Room_ID'];
            $stmt2 = $conn->prepare("UPDATE room SET Room_Status = 'Unavailable' WHERE Room_ID = ?");
            $stmt2->execute([$room_id]);
            return true;
        }
        return false;
    }

    public function isPaymentWindowOpen($booking_id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT Booking_IN, Booking_Status FROM booking WHERE Booking_ID = ?");
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch();

        if (!$booking) return false;

        $now = time();
        $booking_in = strtotime($booking['Booking_IN']);

        return ($now < $booking_in && $booking['Booking_Status'] === 'Pending');
    }
}
?>