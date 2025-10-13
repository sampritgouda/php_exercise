<?php
session_start();
require_once "db_connection.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get fields safely
$name = isset($_POST['Name']) ? trim($_POST['Name']) : null;
$email = isset($_POST['Email_id']) ? trim($_POST['Email_id']) : null;
$address = isset($_POST['Address']) ? trim($_POST['Address']) : null;
$phone = isset($_POST['Phone']) ? trim($_POST['Phone']) : null;

$selected_field_name = null;

if ($name !== null) {
    $selected_field_name = 'Name';
} elseif ($email !== null) {
    $selected_field_name = 'Email_id';
} elseif ($address !== null) {
    $selected_field_name = 'Address';
} elseif ($phone !== null) {
    $selected_field_name = 'Phone Number';
}

// --- VALIDATIONS ---

if ($name !== null && strlen($name) > 25) {
    echo json_encode(['status' => 'error', 'message' => 'Name should not exceed 25 characters.']);
    exit;
}

if ($email !== null && strlen($email) > 30) {
    echo json_encode(['status' => 'error', 'message' => 'Email should not exceed 30 characters.']);
    exit;
}

if ($address !== null && strlen($address) > 45) {
    echo json_encode(['status' => 'error', 'message' => 'Address should not exceed 45 characters.']);
    exit;
}

if ($phone !== null && !preg_match('/^[0-9]{10}$/', $phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter a valid 10-digit phone number.']);
    exit;
}

// Check email duplicate only if email field is sent
if ($email !== null) {
    $checkStmt = $conn->prepare("SELECT 1 FROM tUser WHERE Email_id = ? AND User_id != ?");
    $checkStmt->bind_param("si", $email, $user_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered!']);
        exit;
    }
    $checkStmt->close();
}

// --- BUILD DYNAMIC UPDATE QUERY ---

$fields = [];
$params = [];
$types = '';

if ($name !== null) {
    $fields[] = "Name = ?";
    $params[] = $name;
    $types .= 's';
}
if ($email !== null) {
    $fields[] = "Email_id = ?";
    $params[] = $email;
    $types .= 's';
}
if ($address !== null) {
    $fields[] = "Address = ?";
    $params[] = $address;
    $types .= 's';
}
if ($phone !== null) {
    $fields[] = "Phone = ?";
    $params[] = $phone;
    $types .= 's';
}

if (empty($fields)) {
    echo json_encode(['status' => 'error', 'message' => 'No fields to update.']);
    exit;
}

// Build SQL dynamically
$sql = "UPDATE tUser SET " . implode(", ", $fields) . " WHERE User_id = ?";
$params[] = $user_id;
$types .= 'i';

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => $selected_field_name . ' updated successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
}

$stmt->close();
$conn->close();
?>
