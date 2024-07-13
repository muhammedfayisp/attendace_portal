<?php
session_start();
include 'config.php';

// Function to validate input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize variables and error messages
$superuser_name = $superuser_id = $superuser_password = "";
$name_err = $id_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate superuser name
    if (empty(test_input($_POST["superuser_name"]))) {
        $name_err = "Superuser name is required";
    } else {
        $superuser_name = test_input($_POST["superuser_name"]);
    }

    // Validate superuser ID
    if (empty(test_input($_POST["superuser_id"]))) {
        $id_err = "Superuser ID is required";
    } else {
        $superuser_id = test_input($_POST["superuser_id"]);
    }

    // Validate password
    if (empty(test_input($_POST["superuser_password"]))) {
        $password_err = "Password is required";
    } else {
        $superuser_password = test_input($_POST["superuser_password"]);
    }

    // If no errors, proceed to insert the new superuser
    if (empty($name_err) && empty($id_err) && empty($password_err)) {
        $hashed_password = password_hash($superuser_password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO superusers (superuser_name, superuser_password, superuser_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $superuser_name, $hashed_password, $superuser_id);

        if ($stmt->execute()) {
            echo "Superuser registered successfully.";
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Superuser</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h2 class="mt-5">Register Superuser</h2>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="superuser_name">Superuser Name:</label>
                <input type="text" id="superuser_name" name="superuser_name" class="form-control" value="<?php echo $superuser_name; ?>" required>
                <span class="text-danger"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label for="superuser_id">Superuser ID:</label>
                <input type="text" id="superuser_id" name="superuser_id" class="form-control" value="<?php echo $superuser_id; ?>" required>
                <span class="text-danger"><?php echo $id_err; ?></span>
            </div>
            <div class="form-group">
                <label for="superuser_password">Password:</label>
                <input type="password" id="superuser_password" name="superuser_password" class="form-control" required>
                <span class="text-danger"><?php echo $password_err; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
