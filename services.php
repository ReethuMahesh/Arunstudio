<?php
session_start();
include "db.php";

$result = $conn->query("SELECT * FROM products");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header("Location: cart.php");
    exit();
}
?>
<?php include 'header.php'; ?>
    
<div class="container" style="margin-top:100px;">
    <h1 class="text-center mb-4">Our Services</h1>
    <a href="cart.php" class="btn btn-primary">View Cart (<?= array_sum($_SESSION['cart']) ?>)</a>
    <div class="row mt-3">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card p-3 mb-3">
                    <h5><?= htmlspecialchars($row['name']) ?></h5>
                    <p>₹<?= number_format($row['price']) ?></p>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button name="add" class="btn btn-success">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
