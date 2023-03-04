<?php

require_once 'database.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: registered_users.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registered Users</title>
    <link href="Images\blood-drop 16+16.png" rel="icon" >
    <link href="Images\blood-drop 32+32.png" rel="icon">
    <link href="Images\blood-drop 180+180.png" rel="apple-touch-icon">
    <style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

td a {
  color: red;
}

h3 a {
  color: red; /* change "blue" to the desired color */
}

tr:nth-child(odd){background-color: #f2f2f2}

    </style>
</head>
<body>
    <h1>Registered Users</h1>
    <div style="overflow-x:auto;">
        <table border="3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Blood Group</th>
                    <th>Phone Number</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>
                        <td><?php echo $row["blood_group"]; ?></td>
                        <td><?php echo $row["phone_number"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>
                            <a href="registered_users.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <br>
    <h3><a href="index.php">Register Another User</a></h3>
</body>
</html>
