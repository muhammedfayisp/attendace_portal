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
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $idColumn = $columns[0];
        $sql = "DELETE FROM $table WHERE $idColumn = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM $table");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage <?php echo ucfirst($table); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <h1>Manage <?php echo ucfirst($table); ?></h1>
        <a href="add.php?table=<?php echo $table; ?>" class="btn btn-success mb-3">Add New <?php echo ucfirst($table); ?></a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php foreach ($columns as $column) { echo "<th>$column</th>"; } ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <?php foreach ($columns as $column) { echo "<td>{$row[$column]}</td>"; } ?>
                        <td>
                            <a href="edit.php?table=<?php echo $table; ?>&id=<?php echo $row[$columns[0]]; ?>" class="btn btn-warning">Edit</a>
                            <form action="manage.php?table=<?php echo $table; ?>" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row[$columns[0]]; ?>">
                                <input type="submit" name="delete" value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>
</html>
