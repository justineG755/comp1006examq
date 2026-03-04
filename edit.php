<!-- UPDATE -->
<!-- allows user to update an already exsisting managers information -->
<?php

// adds connection to database
require "connect.php";

// make sure url is received
if (!isset($_GET['id'])) {
  die("No member ID provided.");
}

// store members id 
$id = $_GET['id'];
$error = "";

// if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // sanitize and collect input
  $firstName = trim($_POST['first_name'] ?? '');
  $lastName  = trim($_POST['last_name'] ?? '');
  $phone     = trim($_POST['phone'] ?? '');
  $email     = trim($_POST['email'] ?? '');

  //server-side validation
  $errors = [];

  //required feilds
  if ($firstName === '') $errors[] = "First name is required.";
  if ($lastName === '')  $errors[] = "Last name is required.";
  if ($phone === '')     $errors[] = "Phone number is required.";

  //make sure email format is valid
  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "A valid email is required.";
  }

  //make sure phone number format is valid
  if ($phone !== '' && !preg_match("/^[0-9\-\+\(\)\s]{7,25}$/", $phone)) {
    $errors[] = "Phone number format is invalid.";
  }
 
  //if errors show to user
  if (!empty($errors)) {
    $error = implode(" ", $errors);
  } else {

//UPDATE QUERY
    $sql = "UPDATE registrations
            SET first_name = :first_name,
                last_name  = :last_name,
                phone      = :phone,
                email      = :email
            WHERE id = :id";

    //prepare statemtn 
    $stmt = $pdo->prepare($sql);

    //bind values
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id,);

    //execute
    $stmt->execute();

    //go back to home page
    header("Location: index.php");
    exit;
  }
}

//gets exsisting mangers info
$sql = "SELECT * FROM registrations WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id,);
$stmt->execute();

$managers = $stmt->fetch();

//if no member then stop
if (!$managers) {
  die("Member not found.");
}

?>

<!-- displays update form pre-filled with existing member info -->
<main >
    <div>
      <h2>Update Manager Info<?= htmlspecialchars($managers['id']); ?></h2>

      <!-- error message if any -->
      <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <form method="post">

        <label class="form-label">First Name</label>
        <input
          type="text"
          name="first_name"
          class="form-control mb-3"
          value="<?= htmlspecialchars($managers['first_name']); ?>"
          required>

        <label class="form-label">Last Name</label>
        <input
          type="text"
          name="last_name"
          class="form-control mb-3"
          value="<?= htmlspecialchars($managers['last_name']); ?>"
          required>

        <label class="form-label">Phone</label>
        <input
          type="text"
          name="phone"
          class="form-control mb-3"
          value="<?= htmlspecialchars($managers['phone']); ?>"
          required>

        <label class="form-label">Email</label>
        <input
          type="email"
          name="email"
          class="form-control mb-3"
          value="<?= htmlspecialchars($managers['email']); ?>"
          required>

        <button>Save Changes</button>
        <a href="index.php">Cancel</a>

      </form>
    </div>
</main>


