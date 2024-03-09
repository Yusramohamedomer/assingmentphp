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

$conn = new mysqli($server, $username, $password, $dbname, $port);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['submit'])) {
         
            $id = $_POST['idn'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $sql = "INSERT INTO newstudent (id, first_name, last_name, dob, gender, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $id, $fname, $lname, $dob, $gender, $email, $phone);

         
            if ($stmt->execute()) {
                echo "Data saved successfully!";
            } else {
                throw new Exception("Error: " . $stmt->error);
            }


            $stmt->close();
        } elseif (isset($_POST['update'])) {
   
            $id = $_POST['idn'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $sql = "UPDATE newstudent SET first_name=?, last_name=?, dob=?, gender=?, email=?, phone=? WHERE id=?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Error in the prepared statement: " . $conn->error);
            }

            $stmt->bind_param("ssssssi", $fname, $lname, $dob, $gender, $email, $phone, $id);

            if ($stmt->execute()) {
                echo "Data updated successfully!";
            } else {
                throw new Exception("Error: " . $stmt->error);
            }

            $stmt->close();
        } elseif (isset($_POST['delete'])) {
           
            $id = $_POST['idn'];

            $sql = "DELETE FROM newstudent WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $id);

          
            if ($stmt->execute()) {
                echo "Data deleted successfully!";
            } else {
                throw new Exception("Error: " . $stmt->error);
            }

            $stmt->close();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<center>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="text-align: center; border: 2px solid; padding: 10px; width: 300px; background-color:pink; ">
        <label for="idn">pat_ID:</label>
        <input type="text" id="idn" name="idn" required><br><br>

        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required><br><br>

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required><br><br>

        <label for="dob">Date of reg:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br><br>

        <label for="email">Email:</label>
        <inputtype="email" id="email" name="email" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <input type="submit" name="submit" value="Submit">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="delete" value="Delete">
    </form>
</center>

<?php

$conn->close();

require_once('footer.php');
?>