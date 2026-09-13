<?php
include "../config/db.php";

$query = "SELECT category_id, category_name, image FROM categories ORDER BY category_name ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
    exit;
}

$categories = [];

while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

echo json_encode([
    "status" => "success",
    "categories" => $categories
]);
?>