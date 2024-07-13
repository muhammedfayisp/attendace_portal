<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $superuser_id = $_POST['superuser_id'];
    $superuser_password = $_POST['superuser_password'];

    // Validate input
    if (empty($superuser_id) || empty($superuser_password)) {
        die("Please fill in both fields.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT superuser_name, superuser_password FROM superusers WHERE superuser_id = ?");
    $stmt->bind_param("s", $superuser_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($superuser_name, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows == 1 && password_verify($superuser_password, $hashed_password)) {
        // Set session variables
        $_SESSION['superuser_id'] = $superuser_id;
        $_SESSION['superuser_name'] = $superuser_name;
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid superuser ID or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
