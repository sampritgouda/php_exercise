<?php
session_start();
include "db_connection.php";

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : $_SESSION['user_id'];
$is_self = ($user_id === $_SESSION['user_id']); 
$sql = "SELECT Name FROM tUser WHERE User_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){
    echo json_encode([
        'status' => 'success',
        'name' => $row['Name'],
        'is_self' => $is_self
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found',
        'is_self' => $is_self
    ]);
}
?>
