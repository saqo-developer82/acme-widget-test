<?php

require_once 'DB.php';

class Shop
{
    const BASKET_RADY = 1;
    const BASKET_NOT_RADY = 0;

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    /**
     * Get all products from the database.
     *
     * @return array of product objects
     */
    public function getProducts()
    {
        $sql = "SELECT * FROM products";
        $this->db->query($sql);

        return $this->db->resultSet();
    }

    /**
     * addToBasket function adds a product to the user's shopping basket.
     *
     * @param int $productId
     * @param int $count description
     */
    public function addToBasket($productId, $count)
    {
        $notRadyBasket = $this->getNotRadyBasket();

        $busketId = empty($notRadyBasket) ? $this->createBasket() : $notRadyBasket->id;

        $this->createOrUpdateBasketProduct($busketId, $productId, $count);
    }

    /**
     * Create or update a basket product in the database.
     *
     * @param int $basketId The ID of the basket.
     * @param int $productId The ID of the product.
     * @param int $count The quantity of the product.
     */
    public function createOrUpdateBasketProduct($basketId, $productId, $count)
    {
        $existing = $this->getBasketProduct($basketId, $productId);

        if (!empty($existing)) {
            $sql = "UPDATE basket_products SET count = :count WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $existing->id);
        } else {
            $sql = "INSERT INTO basket_products (basket_id, product_id, count) VALUES (:basket_id, :product_id, :count)";
            $this->db->query($sql);
            $this->db->bind(':basket_id', $basketId);
            $this->db->bind(':product_id', $productId);
        }

        $this->db->bind(':count', $count);
        $this->db->execute();
    }

    /**
     * Create a new basket in the database.
     *
     * @return int The ID of the newly created basket.
     */
    public function createBasket()
    {
        $sql = "INSERT INTO baskets (status) VALUES ("  . self::BASKET_NOT_RADY . ")";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->insertId();
    }

    /**
     * Get the basket that is not ready from the database.
     *
     * @return object
     */
    public function getNotRadyBasket()
    {
        $sql = "SELECT * FROM baskets WHERE status = " . self::BASKET_NOT_RADY;
        $this->db->query($sql);

        return $this->db->single();
    }

    /**
     * Retrieve a specific product from the basket.
     *
     * @param int $basketId The ID of the basket
     * @param int $productId The ID of the product
     * @return array The product information from the database
     */
    public function getBasketProduct($basketId, $productId)
    {
        $sql = "SELECT * FROM basket_products WHERE basket_id = :basket_id AND product_id = :product_id";
        $this->db->query($sql);
        $this->db->bind(':basket_id', $basketId);
        $this->db->bind(':product_id', $productId);

        return $this->db->single();
    }

    /**
     * Get basket data from the database.
     *
     * @return array Fetched basket data
     */
    public function getBasketData()
    {
        $sql = "SELECT b.id, p.name, p.code, p.price , bp.count 
FROM basket_products as bp
JOIN baskets as b ON bp.basket_id = b.id
JOIN products as p ON bp.product_id = p.id
WHERE b.status = " . self::BASKET_NOT_RADY;
        $this->db->query($sql);

        return $this->db->resultSet();
    }

    /**
     * Confirm the order in the database.
     */
    public function confirmOrder()
    {
        $sql = "UPDATE baskets SET status = " . self::BASKET_RADY . " WHERE status = " . self::BASKET_NOT_RADY;
        $this->db->query($sql);
        $this->db->execute();
    }
}
