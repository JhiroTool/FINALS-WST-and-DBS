<?php
function handlePaymentUpload($db, $cust_id, $post, $files) {
    $latestBooking = $db->getLatestUnpaidBooking($cust_id);

    if (!$latestBooking) {
        return ['status' => 'info', 'msg' => 'No pending bookings found for payment.'];
    }

    $booking_id = $latestBooking['Booking_ID'];
    $booking_time = strtotime($latestBooking['Booking_IN']);
    $now = time();
    $timeout = 12 * 60 * 60; // 12 hours
    $time_left = ($booking_time + $timeout) - $now;

    if ($time_left <= 0 || $latestBooking['Booking_Status'] !== 'Pending') {
        return ['status' => 'warning', 'msg' => 'Payment upload time has expired for your latest booking.'];
    }

    $amount = floatval($post['payment_amount']);
    $method = $post['payment_method'];
    $receipt_image = $files['receipt_image'];

    // Use your image upload handler here
    $filename = handleFileUpload($receipt_image);
    if (!$filename) {
        return ['status' => 'danger', 'msg' => 'Invalid image file. Only JPG, PNG, GIF up to 5MB allowed.'];
    }

    // Only insert/update payment if $filename is valid
    if ($db->upsertPaymentWithReceipt($booking_id, $amount, $method, $filename)) {
        return ['status' => 'success', 'msg' => 'Payment submitted! Awaiting verification.'];
    } else {
        return ['status' => 'danger', 'msg' => 'Failed to record payment.'];
    }
}

function handleFileUpload($file)
{
    $target_dir = "upload/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $original_file_name = basename($file["name"]);
    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));

    $check = getimagesize($file["tmp_name"]);
    if ($check === false) return false;

    if ($file["size"] > 5 * 1024 * 1024) return false;

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) return false;

    $new_file_name = pathinfo($original_file_name, PATHINFO_FILENAME) . '_' . time() . '.' . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $new_file_name; // return just the filename for DB storage
    }

    return false;
}