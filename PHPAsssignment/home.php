<?php
session_start();
if (!isset($_SESSION["txtusername"])) {
    header("Location: login.php");
    exit;
}
?>
<?php
require_once('header.php');


?>
<html>

    <body style="background-image:url('downloadd.jpeg'); background-repeat: no-repeat;background-size: cover; height: 500px;background-position: center;">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <form style=" border: 2px;">

</form>
</body>
    </html>
<?php
require_once('footer.php');
?>