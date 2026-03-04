<!-- CREATE -->
<!-- get form information, validates and sanitises info and store into database table -->
<?php 
require "connect.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

//sanitize 
$firstName = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS));
$lastName = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS));
$phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);


$errors = [];

// Required fields 
if ($firstName === null || $firstName === '') {
    $errors[] = "First Name is required.";
}
if ($lastName === null || $lastName === '') {
    $errors[] = "Last Name is required.";
}

// Phone: required 
if ($phone === null || $phone === '') {
    $errors[] = "Phone number is required.";
} elseif (!filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9\-\+\(\)\s]{7,25}$/']])) {
    $errors[] = "Phone number format is invalid.";
}
// Email: required + format check 
if ($email === null || $email === '') {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email must be a valid email address.";
}
//if there are errors
if (!empty($errors)) { 
    echo "<div class='alert alert-danger'>";
    echo "<h2>Please fix the following:</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "<a href='index.php' class='btn btn-dark mt-3'>Go Back</a>";
    echo "</div>";

    exit;
}

//sql query 
$sql = " INSERT INTO registrations (first_name, last_name, phone, email) VALUES (:first_name,:last_name,:phone,:email)";

//prepare statement
$stmt = $pdo->prepare($sql);

//bind values
$stmt->bindParam(':first_name', $firstName);
$stmt->bindParam(':last_name', $lastName);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':email', $email);

//execute
$stmt->execute();

//go back to home 
header("Location:index.php");
exit;
?>

