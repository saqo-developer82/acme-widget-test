<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<body>
    <h2>Basket Products</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Product Code</th>
                <th>Product Count</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
    
        <tbody>
            <?php
                $total_without_delievery = 0;
                $delievery_cost = 0;

                foreach ($basket_products as $product) {
                    $total_price = $product->count * $product->price;

                    if ($product->code == 'R01') {
                        if ($product->count % 2 == 0) {
                            $total_price = ($product->count / 2) * ($product->price + $product->price / 2);
                        } elseif ($product->count > 1) {
                            $total_price = (int)($product->count / 2) * ($product->price + $product->price / 2) + $product->price;
                        }
                    }

                    echo "<tr>
                        <td>{$product->name}</td>
                        <td>{$product->code}</td>
                        <td>{$product->count}</td>
                        <td>$ " . $product->price . "</td>
                        <td>$ " . floor($total_price * 100) / 100 . "</td>
                    </tr>";
        
                    $total_without_delievery += $total_price;
                }
    
                // Display total price with delivery
                echo "<tr>
                    <td colspan='3'></td>
                    <th>Total Without Delivery</th>
                    <td>$ " . floor($total_without_delievery * 100) / 100 . "</td></tr>";
    
                // Display delivery cost
                if ($total_without_delievery < 50) {
                    $delievery_cost = 4.95;
                } elseif ($total_without_delievery >= 50 && $total_without_delievery < 90) {
                    $delievery_cost = 2.95;
                }

                 echo "<tr>
                       <td colspan='3'></td>
                       <th>Delivery Cost</th>
                       <td>$ " . floor($delievery_cost * 100) / 100 . "</td></tr>";
    
                 // Display total price with delivery
                 echo "<tr>
                      <td colspan='3'></td>
                      <th>Total</th>
                      <td>$ " . floor(($total_without_delievery + $delievery_cost) * 100) / 100 . "</td></tr>";
            ?>
        </tbody>
    </table>

    <a id="go-to-products" href="index.php" class='btn btn-outline-success ms-3'>Go To Products Page</a>
    <button id="confirm-order" class='btn btn-success ms-3'>Confirm Order</button>
</body>

<script src="frontend/js/main.js"></script>
</html>
