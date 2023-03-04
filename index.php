<?php

    require_once 'database.php';

    $name = "";
    $address = "";
    $bloodGroup = "";
    $phoneNumber = "";
    $date = "";
    $errors = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $bloodGroup = mysqli_real_escape_string($conn, $_POST["blood_group"]);
        $phoneNumber = mysqli_real_escape_string($conn, $_POST["phone_number"]);
        $date = mysqli_real_escape_string($conn, $_POST["date"]);

        if (empty($name)) {
            $errors[] = "Name is required";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors[] = "Only letters and spaces are allowed in name field";
        }

        if (empty($address)) {
            $errors[] = "Address is required";
        }

        if (empty($bloodGroup)) {
            $errors[] = "Blood group is required";
        }

        if (empty($phoneNumber)) {
            $errors[] = "Phone number is required";
        } elseif (!preg_match("/^[0-9]{10}$/", $phoneNumber)) {
            $errors[] = "Invalid phone number";
        }

        if (empty($date)) {
            $errors[] = "Date is required";
        } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
            $errors[] = "Date should be in the future";
        }

        if (count($errors) == 0) {
            $sql = "INSERT INTO users (name, address, blood_group, phone_number, date) 
                    VALUES ('$name', '$address', '$bloodGroup', '$phoneNumber', '$date')";
            if ($conn->query($sql) === TRUE) {
                header("Location: registered_users.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Blood Donation Registration Form</title>
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

button[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button[type=submit]:hover {
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
        <h1>Blood Donation Registration Form</h1>
        <div class="container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $name; ?>"><br><br>
                <label>Address:</label>
                <input type="text" name="address" value="<?php echo $address; ?>"><br><br>
                <label>Blood Group:</label>
                <select name="blood_group">
                    <option value="" <?php if (empty($bloodGroup)) { echo "selected"; } ?>>Select Blood Group</option>
                    <option value="A+" <?php if ($bloodGroup == "A+") { echo "selected"; } ?>>A+</option>
                    <option value="A-" <?php if ($bloodGroup == "A-") { echo "selected"; } ?>>A-</option>
                    <option value="B+" <?php if ($bloodGroup == "B+") { echo "selected"; } ?>>B+</option>
                    <option value="B-" <?php if ($bloodGroup == "B-") { echo "selected"; } ?>>B-</option>
                    <option value="AB+" <?php if ($bloodGroup == "AB+") { echo "selected"; } ?>>AB+</option>
                    <option value="AB-" <?php if ($bloodGroup == "AB-") { echo "selected"; } ?>>AB-</option>
                    <option value="O+" <?php if ($bloodGroup == "O+") { echo "selected"; } ?>>O+</option>
                    <option value="O-" <?php if ($bloodGroup == "O-") { echo "selected"; } ?>>O-</option>
                </select><br><br>
                <label>Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo $phoneNumber; ?>"><br><br>
                <label>Date:</label>
                <input type="date" name="date" value="<?php echo $date; ?>"><br><br>
                <button type="submit">Submit</button>
            </form>
        </div>
        <?php if (count($errors) > 0): ?>
            <div style="color: red;">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </body>
</html>