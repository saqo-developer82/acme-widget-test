<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<body>
    <h2>Our Products</h2>

    <div class="alert alert-warning" role="alert">
        Our Delivery charge rules
        <ul>
            <li>Orders under $50 cost $4.95</li>
            <li>Orders under $90, delivery costs $2.95</li>
            <li>Orders of $90 or more have free delivery</li>
        </ul>
    </div>

    <div class="alert alert-info" role="alert">
        Our Special offer<br>
        Buy one red widget, get the second half price !!!
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($products as $product) {
                echo "<tr>
                    <td>{$product->name}</td>
                    <td>{$product->code}</td>
                    <td>{$product->price}</td>
                    <td>
                        <input class='selected-count-input' type='number' min='0'></input>
                        <button type='button' class='btn btn-primary add-to-basket-btn' data-product_id='{$product->id}' disabled>Add To Basket</button>
                    </td>
                </tr>";
            }
        ?>
        </tbody>
    </table>

    <a href="basket.php" class='btn btn-outline-success ms-3'>Go To Basket</a>
</body>
<script src="frontend/js/main.js"></script>
</html>
