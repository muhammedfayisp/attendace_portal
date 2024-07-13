<?php
session_start();
if (!isset($_SESSION['studentId'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Include your database connection file

// Retrieve course code from URL parameter
if (isset($_GET['course'])) {
    $courseCode = $_GET['course'];
} else {
    die("Course parameter missing.");
}

// Fetch all attended dates from attendancesheet for the logged-in student and specified course
$studentId = $_SESSION['studentId'];
$sql = "SELECT DISTINCT DATE_FORMAT(date, '%Y-%m-%d') AS attendedDate FROM attendancesheet WHERE studentId = ? AND courseCode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $studentId, $courseCode);
$stmt->execute();
$result = $stmt->get_result();

$attendedDates = [];
while ($row = $result->fetch_assoc()) {
    $attendedDates[] = $row['attendedDate']; // Store formatted date (YYYY-MM-DD)
}
$stmt->close();

// Function to generate calendar grid for a specific month and year
function generateCalendar($month, $year, $attendedDates) {
    $output = '';
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $firstDay = mktime(0, 0, 0, $month, 1, $year);
    $firstDayOfWeek = date('N', $firstDay);
    $dayOfWeek = 1;

    $output .= '<tr>';
    for ($i = 1; $i < $firstDayOfWeek; $i++) {
        $output .= '<td></td>';
        $dayOfWeek++;
    }

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $class = '';

        if (isDateAttended($currentDate, $attendedDates)) {
            $class = ' class="attended"';
        }

        $output .= '<td' . $class . '>' . $day . '</td>';
        if ($dayOfWeek == 7) {
            $output .= '</tr><tr>';
            $dayOfWeek = 1;
        } else {
            $dayOfWeek++;
        }
    }

    $output .= '</tr>';
    return $output;
}

// Function to check if a date is attended
function isDateAttended($date, $attendedDates) {
    return in_array($date, $attendedDates);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance for <?php echo htmlspecialchars($courseCode); ?></title>
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
        .calendar {
            margin-top: 20px;
        }
        .calendar table {
            border-collapse: collapse;
            width: 100%;
        }
        .calendar th, .calendar td {
            text-align: center;
            padding: 5px;
        }
        .calendar th {
            background-color: #f0f0f0;
        }
        .calendar td.attended {
            background-color: lightgreen;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Attendance for <?php echo htmlspecialchars($courseCode); ?></h1>
        <div class="calendar">
            <table border="1">
                <tbody>
                    <tr>
                        <th colspan="7"><?php echo date('F Y'); ?></th>
                    </tr>
                    <tr>
                        <th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th>
                    </tr>
                    <?php echo generateCalendar(date('n'), date('Y'), $attendedDates); ?>
                </tbody>
            </table>
        </div>
        <br>
        <a href="index.php">Back to Dashboard</a>
    </div>
</body>
</html>
