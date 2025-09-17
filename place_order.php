<?php
include "db.php";
session_start();

$cart = $_SESSION['cart'] ?? [];
if (!$cart) die("Cart empty!");

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$ids = implode(",", array_keys($cart));
$result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");

$total = 0;
$items = [];
while ($row = $result->fetch_assoc()) {
    $qty = $cart[$row['id']];
    $subtotal = $row['price'] * $qty;
    $total += $subtotal;
    $items[] = ['id' => $row['id'], 'qty' => $qty];
}

$conn->query("INSERT INTO orders (customer_name, customer_email, customer_phone, total) 
              VALUES ('$name','$email','$phone','$total')");
$order_id = $conn->insert_id;

foreach ($items as $item) {
    $conn->query("INSERT INTO order_items (order_id, product_id, quantity) 
                  VALUES ($order_id, {$item['id']}, {$item['qty']})");
}

unset($_SESSION['cart']);
echo "<h3>Order placed successfully!</h3><a href='index.php'>Back to Shop</a>";
?>
