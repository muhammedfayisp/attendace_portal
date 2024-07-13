<?php
session_start();
if (isset($_SESSION['faculty_id'])) {
    header("Location: index.php"); // Redirect if faculty is already logged in
    exit();
}

include 'config.php'; // Include your database connection file

// Function to fetch courses
function fetchCourses($conn) {
    $sql = "SELECT courseId, courseName FROM courses";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['courseId']}'>{$row['courseName']}</option>";
        }
    } else {
        echo "<option value=''>No courses found</option>";
    }
}

// Function to fetch classes
function fetchClasses($conn) {
    $sql = "SELECT class, className FROM class";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['class']}'>{$row['className']}</option>";
        }
    } else {
        echo "<option value=''>No classes found</option>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h2 class="mt-5">Faculty Login</h2>
        <form action="authenticate.php" method="post">
            <div class="form-group">
                <label for="faculty_id">Faculty ID:</label>
                <input type="text" id="faculty_id" name="faculty_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="course">Course:</label>
                <select id="course" name="course" class="form-control" required>
                    <option value="">Select Course</option>
                    <?php fetchCourses($conn); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="class">Class:</label>
                <select id="class" name="class" class="form-control" required>
                    <option value="">Select Class</option>
                    <?php fetchClasses($conn); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
