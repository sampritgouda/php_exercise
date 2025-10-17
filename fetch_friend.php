<?php
session_start();
require_once "db_connection.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : $_SESSION['user_id'] ?? null;

//fetch friends from db
$sql = "
    SELECT DISTINCT u.user_id, u.name
    FROM t_friends f
    JOIN t_user u 
        ON u.user_id = CASE 
            WHEN f.user_id = ? THEN f.friend_id
            WHEN f.friend_id = ? THEN f.user_id
        END
    WHERE ? IN (f.user_id, f.friend_id)
";
//binding parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$friends = [];
while ($row = $result->fetch_assoc()) {
    $friends[] = $row;
}

if (!empty($friends)) {
    echo json_encode([
        'status' => 'success',
        'friends' => $friends,
        'total_friends' => count($friends)
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No friends found'
    ]);
}
//closing connections
$stmt->close();
$conn->close();
?>
