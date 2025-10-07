<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION['user_id'])) {
    echo "Not logged in";
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['Name'] ?? '';
    $email   = $_POST['Email_id'] ?? '';
    $address = $_POST['Address'] ?? '';
    $phone   = $_POST['Phone'] ?? '';

    $stmt = $conn->prepare("UPDATE tUser SET Name=?, Email_id=?, Address=?, Phone=? WHERE User_id=?");
    $stmt->bind_param("sssii", $name, $email, $address, $phone, $user_id);

    if ($stmt->execute()) {
        $message = "<p style='color:green;'>Profile updated successfully!</p>";
    } else {
        $message = "<p style='color:red;'>Error updating profile.</p>";
    }

    $stmt->close();
}

// Fetch current user data
$stmt = $conn->prepare("SELECT Name, Email_id, Address, Phone FROM tUser WHERE User_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!-- HTML -->
<div>
    <button id="profile-toggle" style="padding:5px 10px; cursor:pointer;">Profile</button>

    <!-- Popup (hidden by default) -->
    <div id="profile-popup" style="display:none; position:absolute; top:50px; right:20px; width:250px; padding:15px; border:1px solid #ccc; background:#fff; box-shadow:0 0 10px rgba(0,0,0,0.2); z-index:100;">
        <h5 style="margin-bottom:10px;">Edit Profile</h5>
        
        <?= $message ?>

        <form method="POST">
            <div style="margin-bottom:8px;">
                <label>Name:</label><br>
                <input type="text" name="Name" value="<?= htmlspecialchars($user['Name']) ?>" style="width:100%;">
            </div>
            <div style="margin-bottom:8px;">
                <label>Email:</label><br>
                <input type="email" name="Email_id" value="<?= htmlspecialchars($user['Email_id']) ?>" style="width:100%;">
            </div>
            <div style="margin-bottom:8px;">
                <label>Address:</label><br>
                <input type="text" name="Address" value="<?= htmlspecialchars($user['Address']) ?>" style="width:100%;">
            </div>
            <div style="margin-bottom:8px;">
                <label>Phone:</label><br>
                <input type="text" name="Phone" value="<?= htmlspecialchars($user['Phone']) ?>" style="width:100%;">
            </div>
            <button type="submit" style="width:100%; padding:5px; background:#007bff; color:#fff; border:none;">Save</button>
        </form>
    </div>
</div>