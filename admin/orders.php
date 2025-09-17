<?php
include "../db.php";
$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>All Orders</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Total</th><th>Date</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['customer_name'] ?></td>
            <td><?= $row['customer_email'] ?></td>
            <td><?= $row['customer_phone'] ?></td>
            <td>₹<?= $row['total'] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php include 'footer.php'; ?>
</body>
</html>
