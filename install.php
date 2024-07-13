<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = 'localhost';
    $username = $_POST['username'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $dbname = 'if0_36775444_eattendance';

    // Establish connection
    $conn = new mysqli($host, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === FALSE) {
        die("Error creating database: " . $conn->error);
    }

    // Select database
    $conn->select_db($dbname);

    // Import SQL file
    $sqlFile = 'if0_36775444_eattendance.sql';
    if (file_exists($sqlFile)) {
        $sqlContent = file_get_contents($sqlFile);
        $queries = explode(';', $sqlContent);

        foreach ($queries as $query) {
            if (trim($query)) {
                if ($conn->query($query) === FALSE) {
                    die("Error importing database: " . $conn->error);
                }
            }
        }
    } else {
        die("SQL file not found.");
    }

    // Function to update config files
    function updateConfig($filePath, $host, $username, $password, $dbname) {
        $configContent = "<?php\n";
        $configContent .= "\$protocol='http://';\n";
        $configContent .= "\$host='$host';\n";
        $configContent .= "\$username='$username';\n";
        $configContent .= "\$password='$password';\n";
        $configContent .= "\$dbname='$dbname';\n";
        $configContent .= "\n";
        $configContent .= "\$conn = new mysqli(\$host, \$username, \$password, \$dbname);\n";
        $configContent .= "\n";
        $configContent .= "if (\$conn->connect_error) {\n";
        $configContent .= "    die(\"Connection failed: \" . \$conn->connect_error);\n";
        $configContent .= "}\n";
        $configContent .= "?>";

        file_put_contents($filePath, $configContent);
    }

    // Update all config files
    updateConfig('config.php', $host, $username, $password, $dbname);
    updateConfig('faculty/config.php', $host, $username, $password, $dbname);
    updateConfig('student/config.php', $host, $username, $password, $dbname);
    updateConfig('superuser/config.php', $host, $username, $password, $dbname);

    // Create installed marker file
    file_put_contents('installed.txt', 'installed');

    // Close the connection
    $conn->close();

    // Redirect to index.php
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Install E-Attendance</title>
</head>
<body>
    <h1>Install E-Attendance</h1>
    <form method="post">
        <label for="username">MySQL Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">MySQL Password (leave blank if none):</label>
        <input type="password" id="password" name="password"><br><br>
        <button type="submit">Install</button>
    </form>
</body>
</html>
