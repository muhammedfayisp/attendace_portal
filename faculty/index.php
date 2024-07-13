<?php
session_start();
if (!isset($_SESSION['facultyId'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Include your database connection file

// Fetch students based on class and allottedCourses
$class = $_SESSION['class'];
$course = $_SESSION['course'];

$sql = "SELECT * FROM students WHERE class = ? AND FIND_IN_SET(?, allottedCourses)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $class, $course);
$stmt->execute();
$result = $stmt->get_result();

// Array to hold student records
$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
$stmt->close();

// Function to get faculty ID from session
function getFacultyId() {
    return $_SESSION['facultyId'];
}

// Function to get course code from session
function getCourseCode() {
    return $_SESSION['course'];
}

// Function to get class from session
function getClass() {
    return $_SESSION['class'];
}

// Function to insert attendance record into attendancesheet table
function insertAttendance($studentId, $courseCode, $facultyId, $class, $date) {
    global $conn;
    // Insert into attendancesheet table
    $sql = "INSERT INTO attendancesheet (studentId, courseCode, facultyId, class, date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $studentId, $courseCode, $facultyId, $class, $date);
    $stmt->execute();
    $stmt->close();

       // Increment totalavailableclasses and attendedclasses for the student
       $sql_update = "UPDATE students SET totalavailableclasses = totalavailableclasses + 1, attendedclasses = attendedclasses + 1 WHERE studentId = ?";
       $stmt_update = $conn->prepare($sql_update);
       $stmt_update->bind_param("s", $studentId);
       $stmt_update->execute();
       $stmt_update->close();
}
function insertFacultyAttendance($studentId, $courseCode, $facultyId, $class, $date) {
    global $conn;
       // Insert into facultyAttendance table
       $sql_faculty = "INSERT INTO facultyAttendance (facultyId, courseCode, class, date) VALUES (?, ?, ?, ?)";
       $stmt_faculty = $conn->prepare($sql_faculty);
       $stmt_faculty->bind_param("ssss", $facultyId, $courseCode, $class, $date);
       $stmt_faculty->execute();
       $stmt_faculty->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
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
        <div class="welcome-text">
            Welcome, <b><?php echo htmlspecialchars($_SESSION['faculty_name']); ?></b>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
        <hr>
        <div class="details">
            Course: <b><?php echo htmlspecialchars($_SESSION['course']); ?></b><br>
            Class: <b><?php echo htmlspecialchars($_SESSION['class']); ?></b>
        </div>
        <div class="student-list">
            <h2>Students List</h2>
            <form action="index.php" method="post" class="attendance-form">
                <?php foreach ($students as $student) { ?>
                    <div class="student-item">
                        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student['studentId']); ?></p>
                        <p><strong>Class:</strong> <?php echo htmlspecialchars($student['class']); ?></p>
                        <p><strong>Allotted Courses:</strong> <?php echo htmlspecialchars($student['allottedCourses']); ?></p>
                        <p><strong>Student Name:</strong> <?php echo htmlspecialchars($student['studentName']); ?></p>
                        <input type="checkbox" id="attendance_<?php echo $student['studentId']; ?>" name="attendance[]" value="<?php echo $student['studentId']; ?>" checked>
                    </div>
                <?php } ?>
                <button type="submit" class="submit-btn btn btn-primary">Submit Attendance</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['attendance'])) {
    $facultyId = getFacultyId();
    $courseCode = getCourseCode();
    $class = getClass();
    $date = date('Y-m-d'); // Get current date
    
    // Loop through selected student IDs and insert attendance records
    foreach ($_POST['attendance'] as $studentId) {
        insertAttendance($studentId, $courseCode, $facultyId, $class, $date);
    }
    insertFacultyAttendance($studentId, $courseCode, $facultyId, $class, $date);
    echo "<script>alert('Attendance submitted successfully.')</script>";
}
?>
