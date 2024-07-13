<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superuser Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Superuser Login</h2>
        <form action="authenticate.php" method="post">
            <div class="form-group">
                <label for="superuser_id">Superuser ID:</label>
                <input type="text" id="superuser_id" name="superuser_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="superuser_password">Password:</label>
                <input type="password" id="superuser_password" name="superuser_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
