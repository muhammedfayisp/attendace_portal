<?php
session_start();
if (!isset($_SESSION['studentId'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Include your database connection file

$studentId = $_SESSION['studentId'];

// Fetch student details including attendedClasses and totalavailableClasses
$sql = "SELECT studentName, class, totalavailableclasses, attendedclasses FROM students WHERE studentId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentId);
$stmt->execute();
$stmt->bind_result($studentName, $class, $totalavailableclasses, $attendedclasses);
$stmt->fetch();
$stmt->close();

// Example allotted courses fetched from session or database
$allottedCourses = explode(',', $_SESSION['allottedCourses']); // Convert comma-separated string to array


function percentage($attendedclasses, $totalavailableclasses){
   $tot=(int) htmlspecialchars($totalavailableclasses); 
   $att=(int) htmlspecialchars($attendedclasses); 
    if($tot !=0){
        return 100 *($att/$tot);
    }else{
        return 0;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .welcome-text {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        .logout-link {
            margin-left: 10px;
            font-size: 1rem;
            text-decoration: none;
            color: #007bff;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
        .student-list {
            margin-top: 20px;
        }
        .student-item {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .student-item p {
            margin: 5px 0;
        }
        .attendance-form {
            margin-top: 20px;
        }
        .submit-btn {
            margin-top: 10px;
        }
       
    </style>
</head>
<body>
    <div class="container">
        <h1 class="welcome-text">Welcome, <?php echo htmlspecialchars($studentName); ?></h1>
        <p>Class: <?php echo htmlspecialchars($class); ?></p>
        <span class="d">Total Attendance:</span><?php echo '<b>'.percentage($attendedclasses, $totalavailableclasses) . '%</b>'; ?></di>
        <span class="d"> (<?php echo htmlspecialchars($attendedclasses) . '/'. htmlspecialchars($totalavailableclasses);?>)</span>
       <span class="d">
       <a class="logout-link" href="logout.php">Logout</a></span>
        <div class="student-list">
            <h2>Allotted Courses:</h2>
            <ul>
                <?php foreach ($allottedCourses as $course) { ?>
                    <li><a href="attendance.php?course=<?php echo urlencode($course); ?>"><?php echo htmlspecialchars($course); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</body>
</html>
