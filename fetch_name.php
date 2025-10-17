<?php
session_start();
//get database connection
include "db_connection.php";
//checking is loged in
if(!isset($_SESSION['user_id'])){
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}
//fetch user id from get or session
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : $_SESSION['user_id'];
//check if the requested user is the logged in user
$is_self = ($user_id === $_SESSION['user_id']); 
//fetch user name from db
$sql = "SELECT Name FROM tUser WHERE User_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
//send response
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
