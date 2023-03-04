<?php

$userID = $_GET['id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve the user data from the database
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Update the user data in the database if the form is submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $bloodGroup = $_POST['bloodGroup'];
    $phoneNumber = $_POST['phoneNumber'];
    $date = $_POST['date'];
  
    $today = date('Y-m-d');
    if ($date < $today) {
      echo "Date should be in the future";
    } else {
      $stmt = $conn->prepare("UPDATE users SET name=?, address=?, blood_group=?, phone_number=?, date=? WHERE id=?");
      $stmt->bind_param("sssssi", $name, $address, $bloodGroup, $phoneNumber, $date, $userID);
      $stmt->execute();
  
      if ($stmt->execute() === TRUE) {
        // Redirect to the main page after updating the user data
        header("Location: registered_users.php");
        exit();
      } else {
        echo "Error updating record: " . $conn->error;
      }
    }
  }




?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit The Form</title>
        <link href="Images\blood-drop 16+16.png" rel="icon" >
        <link href="Images\blood-drop 32+32.png" rel="icon">
        <link href="Images\blood-drop 180+180.png" rel="apple-touch-icon">
        <style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

</style>
    </head>
    <body>
        <h1>Edit the form if required</h1>
        <div class="container">
            <form method="post" action="">
              <label for="name">Name:</label>
              <input type="text" id="name" name="name" value="<?php echo $userData['name']; ?>" required><br><br>

              <label for="address">Address:</label>
              <input type="text" id="address" name="address" value="<?php echo $userData['address']; ?>" required><br><br>

              <label for="bloodGroup">Blood Group:</label>
              <select id="bloodGroup" name="bloodGroup" required>
                <option value="">Select Blood Group</option>
                <option value="A+" <?php if ($userData['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
                <option value="A-" <?php if ($userData['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
                <option value="B+" <?php if ($userData['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
                <option value="B-" <?php if ($userData['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
                <option value="AB+" <?php if ($userData['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                <option value="AB-" <?php if ($userData['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                <option value="O+" <?php if ($userData['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
                <option value="O-" <?php if ($userData['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
              </select><br><br>

              <label for="phoneNumber">Phone Number:</label>
              <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo $userData['phone_number']; ?>" required maxlength="10" pattern="[0-9]{10}" oninvalid="this.setCustomValidity('Please enter a 10-digit number')" oninput="this.setCustomValidity('')"><br><br>


              <label for="date">Date:</label>
              <input type="date" id="date" name="date" min="01-03-2023" value="<?php echo $userData['date']; ?>" required><br><br>

              <input type="submit" name="submit" value="Save">
            </form>
        </div>
    </body>
</html>