<?php
session_start();
if (!isset($_SESSION['superuser_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$table = $_GET['table'];
$id = $_GET['id'];

function getTableColumns($table) {
    switch ($table) {
        case 'faculty':
            return ['facultyId', 'facultyName', 'courses'];
        case 'students':
            return ['studentId', 'class', 'allottedCourses', 'studentName'];
        case 'attendancesheet':
            return ['studentId', 'courseCode', 'facultyId', 'date', 'class'];
        case 'class':
            return ['class', 'staffAdvisorId', 'className'];
        default:
            return [];
    }
}

$columns = getTableColumns($table);
$idColumn = $columns[0];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $values = [];
    $types = '';
    foreach ($columns as $column) {
        if ($column != $idColumn) { 
            $values[] = $_POST[$column];

            $types .= 's';
        }
    }
    $values[] = $id; 
    $types .= 's'; 

    $setClause = implode(' = ?, ', array_slice($columns, 1)) . ' = ?'; 

    $sql = "UPDATE $table SET $setClause WHERE $idColumn = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    $stmt->close();
    header("Location: manage.php?table=$table");
    exit();
}

$result = $conn->query("SELECT * FROM $table WHERE $idColumn = '$id'");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?php echo ucfirst($table); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>Edit <?php echo ucfirst($table); ?></h1>
        <form action="edit.php?table=<?php echo $table; ?>&id=<?php echo $id; ?>" method="post">
            <?php foreach ($columns as $column) { ?>
                <div class="form-group">
                    <label for="<?php echo $column; ?>"><?php echo ucfirst($column); ?></label>
                    <input type="<?php echo $column == 'password' ? 'password' : 'text'; ?>" class="form-control" id="<?php echo $column; ?>" name="<?php echo $column; ?>" value="<?php echo $row[$column]; ?>" <?php echo $column == $idColumn ? 'readonly' : ''; ?> required>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
