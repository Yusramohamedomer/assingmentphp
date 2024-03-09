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
            $address = $_POST['address'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $dob = $_POST['doR'];

            $sql = "INSERT INTO employee (id, full_name, address, email, phone, ddate_reg) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $id, $fname, $address, $email, $phone, $dob);

            // Execute the statement
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

            $sql = "UPDATE employee SET first_name=?, last_name=?, dob=?, gender=?, email=?, phone=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $fname, $lname, $dob, $gender, $email, $phone, $id);

            if ($stmt->execute()) {
                echo "Data updated successfully!";
            } else {
                throw new Exception("Failed to update data: " . $stmt->error);
            }

    
            $stmt->close();
        } elseif (isset($_POST['delete'])) {
        
            $id = $_POST['idn'];

            $sql = "DELETE FROM employee WHERE id=?";
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

$conn->close();
?>

<center>
<?php if (isset($_SESSION["txtusername"])) : ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="text-align: center; border: 2px solid; padding: 10px; width: 300px; background-color:pink; ">
        <label for="idn">E_ID:</label>
        <input type="text" id="idn" name="idn" required><br><br>

        <label for="fname">full_name :</label>
        <input type="text" id="fname" name="fname" required><br><br>

        
        <label for="address">address:</label>
        <input type="address" id="address" name="address" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required><br><br>

        
        <label for="dob">Date of reg:</label>
        <input type="date" id="dob" name="doR" required><br><br>

        <input type="submit" name="submit" value="Submit" id="id">
        <input type="submit" name="update" value="Update" id="id">
        <input type="submit" name="delete" value="Delete" id="id">
    </form>
<?php endif; ?>
<br>

<style>
    body {
        background-color: black;
    }
    #id{
        background-color:black;
        color:pink;
    }
</style>
<?php

$sql = "SELECT * FROM employee order by id asc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table border="2" style="background-color: pink;">';
    echo "<tr><th>ID</th><th>full Name</th><th>address</th><th>Email</th><th>Phone Number</th>><th>date_of_reg</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['full_name'] . "</td>";
        echo "<td>" . $row['address'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['ddate_reg'] . "</td>";
       
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}


$conn->close();
?>
<?php
require_once('footer.php');
?>
</center>