<?php
$servername = "localhost";
$username = "root"; // Default XAMPP user
$password = "Chips@1234";     // Default XAMPP password
$dbname = "tech_news_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>