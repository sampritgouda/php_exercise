<?php
session_start();
header('Content-Type: application/json');

//DB connection file
require_once "db_connection.php";  

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    echo json_encode([
        'status' => 'error',
        'message' => 'You must be logged in to post.'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['post_content']) && !empty(trim($_POST['post_content']))) {
    $post_content = $conn->real_escape_string($_POST['post_content']);
    // Insert post into database
    $sql = "INSERT INTO tWall (user_id, post) VALUES ('$user_id', '$post_content')";
    // Execute query and check for success
    if($conn->query($sql) === TRUE) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Post added successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error inserting post: ' . $conn->error
        ]);
    }
} else {
    // Post content is empty
    echo json_encode([
        'status' => 'error',
        'message' => 'Post content cannot be empty.'
    ]);
}
// Close the database connection
$conn->close();
?>
