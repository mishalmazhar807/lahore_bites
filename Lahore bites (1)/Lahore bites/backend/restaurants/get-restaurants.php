<?php
include "../config/db.php";

$query = "SELECT 
            r.restaurant_id,
            r.restaurant_name,
            r.description,
            r.phone,
            r.email,
            r.address,
            r.opening_time,
            r.closing_time,
            r.status,
            r.delivery_fee,
            r.minimum_order,
            r.rating,
            r.image,
            GROUP_CONCAT(DISTINCT c.category_name SEPARATOR ', ') AS categories,
            GROUP_CONCAT(DISTINCT m.item_name SEPARATOR ', ') AS menu_items
          FROM restaurants r
          LEFT JOIN menu_items m ON r.restaurant_id = m.restaurant_id
          LEFT JOIN categories c ON m.category_id = c.category_id
          WHERE r.status = 'active'
          GROUP BY 
            r.restaurant_id,
            r.restaurant_name,
            r.description,
            r.phone,
            r.email,
            r.address,
            r.opening_time,
            r.closing_time,
            r.status,
            r.delivery_fee,
            r.minimum_order,
            r.rating,
            r.image
          ORDER BY r.rating DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
    exit;
}

$restaurants = [];

while ($row = mysqli_fetch_assoc($result)) {
    $restaurants[] = $row;
}

echo json_encode([
    "status" => "success",
    "restaurants" => $restaurants
]);
?>