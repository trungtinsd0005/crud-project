<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_demo";

$conn = new mysqli($servername, $username, $password, $database);
if($conn->connect_error) {
    die("Connect that bai: " . $conn->connect_error);
}
?>

