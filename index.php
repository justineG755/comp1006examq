<?php
require "connect.php";

//create query for all member info 
$sql = "SELECT id, first_name, last_name, phone, email
        FROM registrations
        ORDER BY id DESC";

//prepare
$stmt = $pdo->prepare($sql);

//execute 
$stmt->execute();

//retrieve all rows returned by a SQL query at once
$managers = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Registration</title>
</head>

<body>

    <h1>Event Registration</h1>

    <form action="process.php" method="POST">

        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name"><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name"><br><br>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email"><br><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone"><br><br>

        <button type="submit">Register</button>

    </form>

    <p>
        <a href="admin.php">Go to Admin Page</a>
    </p>

</body>
</html>
