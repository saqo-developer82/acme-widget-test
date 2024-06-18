<?php
$input = file_get_contents('php://input');

$data = json_decode($input, true);

// Check if the request is valid
if (empty($data) || !is_array($data) || !isset($data['action'])) {
    http_response_code(400);
    die('Wrong request');
}

require_once 'Shop.php';
$shop = new Shop();

// Perform the action
switch ($data['action']) {
    case 'add_to_basket':
        $shop->addToBasket($data['product_id'], $data['count']);
        break;
    case 'confirm_order':
        $shop->confirmOrder();
        break;
    default:
        http_response_code(404);
        die('Action not found');
}


