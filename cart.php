<?php
include "db.php";
session_start();
$cart = $_SESSION['cart'] ?? [];

if (!$cart) {
    echo "<h3>Your cart is empty</h3><a href='index.php'>Shop Now</a>";
    exit;
}

$ids = implode(",", array_keys($cart));
$result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Your Cart</h2>
    <table class="table">
        <tr><th>Product</th><th>Qty</th><th>Price</th></tr>
        <?php while($row = $result->fetch_assoc()): 
            $qty = $cart[$row['id']];
            $subtotal = $row['price'] * $qty;
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $qty ?></td>
            <td>₹<?= $subtotal ?></td>
        </tr>
        <?php endwhile; ?>
        <tr><td colspan="2"><strong>Total</strong></td><td><strong>₹<?= $total ?></strong></td></tr>
    </table>
    <a href="checkout.php" class="btn btn-success">Checkout</a>
</body>
</html>
