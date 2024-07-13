
<?php
if (!file_exists('installed.txt')) {
    header('Location: install.php');
    exit();
}
?>

<?php

// Include the config file

include 'config.php';



// Function to add attendance

function addAttendance($studentID, $courseCode, $facultyId, $date, $class) {

    // Access global variables

    global $host, $username, $password, $dbname;



    // Create connection

    $conn = new mysqli($host, $username, $password, $dbname);



    // Check connection

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }



    // // Prepare the SQL statement

    // $stmt = $conn->prepare("INSERT INTO attendancesheet (studentId, courseCode, facultyId, date, class) VALUES (?, ?, ?, ?, ?)");

    // if ($stmt === false) {

    //     die("Error preparing the statement: " . $conn->error);

    // }



    // // Bind parameters

    // $stmt->bind_param("sssss", $studentID, $courseCode, $facultyId, $date, $class);



    // // Execute the statement

    // if ($stmt->execute()) {

    //     echo "Attendance record added successfully.";

    // } else {

    //     echo "Error: " . $stmt->error;

    // }



    // // Close the statement and connection

    // $stmt->close();

    // $conn->close();

}









function addClass($class, $staffAdvisorId, $className) {

    // Access global variables

    global $host, $username, $password, $dbname;



    // Create connection

    $conn = new mysqli($host, $username, $password, $dbname);



    // Check connection

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }



    // // Prepare the SQL statement

    // $stmt = $conn->prepare("INSERT INTO class (class, staffAdvisorId, className) VALUES (?, ?, ?)");

    // if ($stmt === false) {

    //     die("Error preparing the statement: " . $conn->error);

    // }



    // // Bind parameters

    // $stmt->bind_param("sss", $class, $staffAdvisorId, $className);



    // // Execute the statement

    // if ($stmt->execute()) {

    //     echo "Class record added successfully.";

    // } else {

    //     echo "Error: " . $stmt->error;

    // }



    // // Close the statement and connection

    // $stmt->close();

    // $conn->close();

}





// Example usage

// addAttendance('TVE22AE090', 'EC204', 'SG', '2024-06-23', 'EC355');

// addClass('EC355', 'JIM', 'S4 AEI');

?>





<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ente Attendance</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 1s ease-in-out;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            animation: slideIn 1s ease-in-out;
        }
        h1 {
            color: #333333;
            font-size: 2em;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin: 10px 0;
        }
        ul li a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.2em;
            transition: color 0.3s, transform 0.3s;
        }
        ul li a:hover {
            color: #0056b3;
            transform: scale(1.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 1.5em;
            }
            ul li a {
                font-size: 1em;
            }
        } */
    </style>
</head>
<body>
    <div class="container">
        <h1>ENTE ATTENDANCE</h1>
        <ul>
            <li><a href="student/">Student Login</a></li>
            <li><a href="faculty/">Faculty Login</a></li>
            <li><a href="superuser/">Admin Login</a></li>
        </ul>
    </div>
</body>
</html>
-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ente Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class=" bg-blue-300">
    <div class="flex place-content-center">
        <h1 class="text-5xl font-extrabold text-white m-3 ">Ente Attendance</h1>
    </div>
    <div class="flex place-content-center shadow-2xl">
        
        <div class="m-3 border-violet-950 rounded-md border-2 bg-orange-200 w-screen lg:grid lg:grid-cols-2">
            <div class="m-3 flex place-content-center lg:w-3/4">
                <img src="logo.png" alt="Ente Attendance" class=" w-20 h-20 rounded-full lg:rounded-lg lg:w-full lg:h-full " >
            </div>
            <div class="m-3 lg:w-full lg:p-10 lg:h-full">
                
                <a href="student/">
                    <button class="w-full lg:h-20 font-extrabold lg:text-2xl text-white lg:p-5 p-2 m-1 flex place-content-center bg-blue-600 hover:bg-indigo-600 rounded-lg h-10 shadow-inner shadow-blue-600/60 lg:shadow-indigo-600/60">Student Login</button>
                  </a>
                  <a href="faculty/">
                    <button class="w-full lg:h-20 font-extrabold lg:text-2xl text-white lg:p-5 p-2 m-1 flex place-content-center bg-blue-600 hover:bg-indigo-600 rounded-lg h-10 shadow-inner shadow-blue-600/60 lg:shadow-indigo-600/60">Faculty Login</button>
                  </a>
                  <a href="superuser/">
                    <button class="w-full lg:h-20 font-extrabold lg:text-2xl text-white lg:p-5 p-2 m-1 flex place-content-center bg-blue-600 hover:bg-indigo-600 rounded-lg h-10 shadow-inner shadow-blue-600/60 lg:shadow-indigo-600/60">Admin Login</button>
                  </a>       
            </div>
        
        </div>
    </div>
</body>
</html>
