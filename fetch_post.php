<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include "db_connection.php";

//checking is loged in
if(!isset($_SESSION['user_id'])){
    echo "<div>Please log in to view posts.</div>";
    exit();
}

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : $_SESSION['user_id'] ?? null;

// Fetch posts for this user only
$sql = "SELECT tw.post, tw.posting_date, tu.Name
        FROM tWall tw
        JOIN tUser tu ON tw.user_id = tu.User_id
        WHERE tw.user_id = ?
        ORDER BY tw.posting_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        // Calculate time difference
        $posting_time = strtotime($row['posting_date']);
        $diff = time() - $posting_time;
        if($diff < 60) $time_text = "Just now";
        elseif($diff < 3600) $time_text = floor($diff/60)." min ago";
        elseif($diff < 86400) $time_text = floor($diff/3600)." hrs ago";
        else $time_text = date("d M Y H:i", $posting_time);

        // Random counts for likes/comments/shares
        $likes = rand(100,1000);
        $comments = rand(10,100);
        $shares = rand(1,50);

        // Output your exact HTML
        echo '<div class="w-100 mt-3 bg-white px-3 pb-2 post-card">';
        echo '  <div class=" py-2 d-flex justify-content-between align-items-center">';
        echo '    <div class="d-flex gap-2 align-items-center">';
        echo '      <img src="img/mark-zuckerberg.jpg" alt="" width="40px" height="40px" class="rounded-circle">';
        echo '      <div>';
        echo '        <strong>'.htmlspecialchars($row['Name']).'</strong><br>';
        echo '        <span class="post-time">'.$time_text.'</span>';
        echo '      </div>';
        echo '    </div>';
        echo '    <span>';
        echo '      <img src="img/3-dots.svg" alt="">';
        echo '    </span>';
        echo '  </div>';
        echo '  <div class="post-text">';
        echo '    <p class="post-card-text">'.htmlspecialchars($row['post']).'</p>';
        echo '  </div>';
        echo '  <div class="d-flex justify-content-between post-action-count">';
        echo '    <div class="d-flex">';
        echo '      <img src="img/like-blue.svg" alt="" width="20px" height="20px">';
        echo '      <img src="img/red-heart.svg" alt="" height="20px" width="20px">';
        echo '      <span class="ms-2">'.$likes.'K</span>';
        echo '    </div>';
        echo '    <div >';
        echo '      <span>'.$comments.'K Comments</span>';
        echo '      <span>'.$shares.'K Shares</span>';
        echo '    </div>';
        echo '  </div>';
        echo '  <hr class="mb-0">';
        echo '  <div class="row post-action-btn">';
        echo '    <div class="col-3 col-sm-4 px-0 px-lg-2">';
        echo '      <button class="btn w-100 "><img src="img/like.png" width="20px" height="20px"/> <span class="ms-1"> Like</span> </button>';
        echo '    </div>';
        echo '    <div class="col-sm-4 col-5 px-0 px-lg-2">';
        echo '      <button class="btn w-100 "><img src="img/chat.png" width="20px" height="20px"/> <span class="ms-1"> Comments</span></button>';
        echo '    </div>';
        echo '    <div class="col-sm-4 col-3 px-0 px-lg-2">';
        echo '      <button class="btn w-100 "><img src="img/share.png" width="20px" height="20px"/> <span class="ms-1"> Share</span></button>';
        echo '    </div>';
        echo '  </div>';
        echo '  <hr class="mt-0">';
        echo '</div>';
    }
} else {
    echo "<div class='post-section'>No posts yet.</div>";
}
?>
