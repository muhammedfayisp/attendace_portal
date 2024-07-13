<?php
session_start();
if (!isset($_SESSION['superuser_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ente Attendance Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['superuser_name']; ?></h1>
        <p>This is the superuser dashboard. Here you can manage all records.</p>
        <a href="manage.php?table=faculty" class="btn btn-primary">Manage Faculty</a>
        <a href="manage.php?table=students" class="btn btn-primary">Manage Students</a>
        <a href="manage.php?table=attendancesheet" class="btn btn-primary">Manage Attendance Sheet</a>
        <a href="manage.php?table=class" class="btn btn-primary">Manage Classes</a>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
