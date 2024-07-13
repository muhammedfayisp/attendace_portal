<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $studentId = $_POST['studentId'];
    $password = $_POST['password'];

    // Validate input
    if (empty($studentId) || empty($password)) {
        die("Please fill in both fields.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT studentName, class, allottedCourses, password FROM students WHERE studentId = ?");
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($studentName, $class, $allottedCourses, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows == 1 && password_verify($password, $hashed_password)) {
        // Set session variables
        $_SESSION['studentId'] = $studentId;
        $_SESSION['studentName'] = $studentName;
        $_SESSION['class'] = $class;
        $_SESSION['allottedCourses'] = $allottedCourses;
        
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid ID or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
