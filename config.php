<?php
$servername = "localhost";
$username = "u687581842_td";
$password = "serenoss";
$dbname="u687581842_td";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
$conn->query("SET NAMES UTF8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 ?>
