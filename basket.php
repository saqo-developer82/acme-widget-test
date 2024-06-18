<?php

require_once 'backend/Shop.php';

$shop = new Shop();
$basket_products = $shop->getBasketData();

if (!empty($basket_products)) {
    include_once 'frontend/views/basket_page.php';
} else {
    echo 'No products found';
}
