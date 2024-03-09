<?php 
session_start();
$error = "";

// Database connection
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'phpassignment';
$port = 3307;

try {
    $con = new mysqli($server, $username, $password, $dbname,$port);
    if ($con->connect_error) {
        throw new Exception("Connection failed: " . $con->connect_error);
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Read data entered by the user
    $uname = $_POST["txtusername"];
    $upass = $_POST["txtpassword"];

    // Query to check the user credentials
    $sql = mysqli_query($con, "SELECT * FROM login WHERE username='$uname' OR password='$upass'");
    $row = mysqli_fetch_assoc($sql);

    if (mysqli_num_rows($sql) > 0) {
        if ($upass == $row["password"]) {
            $_SESSION["txtusername"] = $uname;
            header("Location: home.php"); 

            // Redirection
        
        } else {
            $error = "Invalid credentials";
        }
    } else {
        $error = "No way";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color: pink;"><br><br><br><br><br>
<center>
<div style="text-align: center; border: 2px solid; padding: 10px; width: 300px; background-color:white; ">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Username:</label>
        <input type="text" name="txtusername" placeholder="Enter username" /><br><br>
        <label>Password:</label>
        <input type="password" name="txtpassword" placeholder="Enter password" /><br><br>
        <input type="submit" value="Login" name="submit" />
    </form>
    <br />

    <h4 style="color: red;">
        <?php echo (isset($error)) ? $error : ""; ?>
    </h4>
</div>
</center>
</body>
</html>
