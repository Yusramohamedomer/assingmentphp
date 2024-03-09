<?php
session_start();
if (!isset($_SESSION["txtusername"])) {
    header("Location: login.php");
    exit;
}
?>

<?php

require_once('header.php');

$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'phpassignment';
$port = 3307;

try {
    $conn = new mysqli($server, $username, $password, $dbname, $port);

 
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submit'])) {
        
            $id = $_POST['idn'];
            $fname = $_POST['fname'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $sql = "INSERT INTO dentistt (id,first_name, dob, gender, email, phone) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $id, $fname, $dob, $gender, $email, $phone);

      
            if ($stmt->execute()) {
                echo "Data saved successfully!";
            } else {
                throw new Exception("Failed to save data: " . $stmt->error);
            }

        
            $stmt->close();
        } elseif (isset($_POST['update'])) {
    
            $id = $_POST['idn'];
            $fname = $_POST['fname'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $sql = "UPDATE dentistt SET first_name=?, dob=?, gender=?, email=?, phone=? WHERE id=?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Error in the prepared statement: " . $conn->error);
            }

            $stmt->bind_param("sssssi", $fname, $dob, $gender, $email, $phone, $id);

         
            if ($stmt->execute()) {
                echo "Data updated successfully!";
            } else {
                throw new Exception("Failed to update data: " . $stmt->error);
            }

            $stmt->close();
        } elseif (isset($_POST['delete'])) {
          
            $id = $_POST['idn'];

            $sql = "DELETE FROM dentistt WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $id);

       
            if ($stmt->execute()) {
                echo "Data deleted successfully!";
            } else {
                throw new Exception("Failed to delete data: " . $stmt->error);
            }

        
            $stmt->close();
        }
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>



<?php

$sql = "SELECT * FROM dentistt";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table border="2">';
    echo "<tr><th>ID</th><th>First Name</th><th>Date of Birth</th><th>Gender</th><th>Email</th><th>Phone Number</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['dob'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}


$conn->close();

require_once('footer.php');
?>