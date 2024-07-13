<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_id = $_POST['faculty_id'];
    $password = $_POST['password'];
    $course = $_POST['course'];
    $class = $_POST['class'];

    $sql = "SELECT * FROM faculty WHERE facultyId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['facultyId'] = $faculty_id;
            $_SESSION['faculty_name'] = $row['facultyName'];
            $_SESSION['course'] = $course;
            $_SESSION['class'] = $class;
            
            // Redirect to faculty dashboard or desired page
            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Faculty ID not found";
    }

    $stmt->close();
}

$conn->close();
?>
