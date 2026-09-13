<?php
include "../config/db.php";

$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");

if ($email === "" || $password === "") {
    echo json_encode([
        "status" => "error",
        "message" => "Email and password are required"
    ]);
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT user_id, full_name, email, phone, password, role FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email not registered. Please register first."
    ]);
    exit;
}

$user = mysqli_fetch_assoc($result);

if (!password_verify($password, $user["password"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Incorrect password"
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "message" => "Login successful",
    "user" => [
        "user_id" => $user["user_id"],
        "full_name" => $user["full_name"],
        "email" => $user["email"],
        "phone" => $user["phone"],
        "role" => $user["role"]
    ]
]);
?>