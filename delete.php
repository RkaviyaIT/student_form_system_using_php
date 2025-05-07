<?php
$host="localhost";
$username="root";
$password="Rkaviya@123";
$database="php_student_db";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $conn->query("DELETE FROM students WHERE id=$id");
}

header("Location: register.php"); 
exit();
?>
