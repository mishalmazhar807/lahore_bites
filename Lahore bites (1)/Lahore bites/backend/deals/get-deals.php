<?php
include "../config/db.php";

$query = "SELECT 
            d.deal_id,
            d.restaurant_id,
            d.deal_title,
            d.deal_description,
            d.discount_percent,
            d.minimum_order,
            d.deal_type,
            d.status,
            r.restaurant_name
          FROM deals d
          JOIN restaurants r ON d.restaurant_id = r.restaurant_id
          WHERE d.status = 'active'
          ORDER BY d.discount_percent DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
    exit;
}

$deals = [];

while ($row = mysqli_fetch_assoc($result)) {
    $deals[] = $row;
}

echo json_encode([
    "status" => "success",
    "deals" => $deals
]);
?>