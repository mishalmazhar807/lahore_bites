<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$password = "";
$database = "lahore_bites";
$port = 3307;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . mysqli_connect_error()
    ]);
    exit;
}
?>