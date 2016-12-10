<?php
require "config.php";
$id = $_REQUEST['id'];
$product = Product::find($id);
$cats = $product->cats->toJson();
$product->categories = $cats;

if (!empty($product)) {
    http_response_code(200);
    echo json_encode($product);
} else {
    echo json_encode(['error' => 'not found']);
}
?>
