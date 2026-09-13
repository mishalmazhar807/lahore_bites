<?php
include "../config/db.php";

$restaurant_id = $_GET["id"] ?? "";

if ($restaurant_id === "") {
    echo json_encode([
        "status" => "error",
        "message" => "Restaurant ID is required"
    ]);
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM restaurants WHERE restaurant_id = ?");
mysqli_stmt_bind_param($stmt, "i", $restaurant_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Restaurant not found"
    ]);
    exit;
}

$restaurant = mysqli_fetch_assoc($result);

$stmt2 = mysqli_prepare($conn, "SELECT * FROM menu_items WHERE restaurant_id = ? AND availability_status = 'available'");
mysqli_stmt_bind_param($stmt2, "i", $restaurant_id);
mysqli_stmt_execute($stmt2);
$menuResult = mysqli_stmt_get_result($stmt2);

$menu = [];

while ($row = mysqli_fetch_assoc($menuResult)) {
    $menu[] = $row;
}

echo json_encode([
    "status" => "success",
    "restaurant" => $restaurant,
    "menu" => $menu
]);
?>