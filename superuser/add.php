<?php
session_start();
if (!isset($_SESSION['superuser_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$table = $_GET['table'];

function getTableColumns($table) {
    switch ($table) {
        case 'faculty':
            return ['facultyId', 'facultyName', 'password', 'courses'];
        case 'students':
            return ['studentId', 'class', 'allottedCourses', 'studentName', 'password'];
        case 'attendancesheet':
            return ['studentId', 'courseCode', 'facultyId', 'date', 'class'];
        case 'class':
            return ['class', 'staffAdvisorId', 'className'];
        default:
            return [];
    }
}

$columns = getTableColumns($table);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $values = [];
    foreach ($columns as $column) {
        if ($column == 'password') {
            $values[] = password_hash($_POST[$column], PASSWORD_BCRYPT);
        } else {
            $values[] = $_POST[$column];
        }
    }
    $placeholders = implode(',', array_fill(0, count($values), '?'));
    $types = str_repeat('s', count($values));
    $sql = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    $stmt->close();
    header("Location: manage.php?table=$table");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New <?php echo ucfirst($table); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>Add New <?php echo ucfirst($table); ?></h1>
        <form action="add.php?table=<?php echo $table; ?>" method="post">
            <?php foreach ($columns as $column) { ?>
                <div class="form-group">
                    <label for="<?php echo $column; ?>"><?php echo ucfirst($column); ?></label>
                    <input type="<?php echo $column == 'password' ? 'password' : 'text'; ?>" class="form-control" id="<?php echo $column; ?>" name="<?php echo $column; ?>" required>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
