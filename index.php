<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'backend/Shop.php';

$shop = new Shop();
$products = $shop->getProducts();

if (!empty($products)) {
    include_once 'frontend/views/products_page.php';
} else {
    echo 'No products found';
}
