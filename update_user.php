<?php
session_start();
require_once "db_connection.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

$name = trim($_POST['Name'] ?? '');
$email = trim($_POST['Email_id'] ?? '');
$address = trim($_POST['Address'] ?? '');
$phone = trim($_POST['Phone'] ?? '');

//validate name length
if (strlen($name) > 25) {
    echo json_encode(['status' => 'error', 'message' => 'Name should not exceed 25 characters.']);
    exit;
}

//validate email length
if (strlen($email) > 25) {
    echo json_encode(['status' => 'error', 'message' => 'Email  should not exceed 25 characters.']);
    exit;
}

//validate address length
if (strlen($address) > 45) {
    echo json_encode(['status' => 'error', 'message' => 'Address should not exceed 45 characters.']);
    exit;
}

//  Validate phone number
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter a valid 10-digit phone number.']);
    exit;
}


//checking the email already exists 
$checkStmt = $conn->prepare("SELECT * FROM tUser WHERE Email_id = ? AND User_id != ?");
$checkStmt->bind_param("si", $email, $user_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // Email already exists
   echo json_encode(['status' => 'error', 'message' => 'Email already registered!']);
   exit;
} 



$stmt = $conn->prepare("UPDATE tUser SET Name=?, Email_id=?, Address=?, Phone=? WHERE User_id=?");
$stmt->bind_param("sssii", $name, $email, $address, $phone, $user_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
}

$stmt->close();
$conn->close();
?>
