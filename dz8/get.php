<?php
require "config.php";
$product = Product::find($_REQUEST['id']);
$cats = $product->cats();

if (!empty($product)) {
    http_response_code(200);
    echo json_encode($cats);
} else {
    echo json_encode(['error' => 'not found']);
}
?>
