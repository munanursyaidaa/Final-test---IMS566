<?php
include 'db.php';
$cat = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-maroon text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">📂 Manage Categories</h4>
                <a href="add_category.php" class="btn btn-sm btn-light text-maroon fw-semibold">+ Add Category</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($c = $cat->fetch_assoc()): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= htmlspecialchars($c['title']) ?></td>
                                <td>
                                    <span class="badge <?= $c['status'] === 'Active' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $c['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit_category.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-light">Edit</a> ||
                                    <a href="delete_category.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-light" onclick="return confirm('Delete this category?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($cat->num_rows == 0): ?>
                            <tr><td colspan="4">No categories found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="menu.php" class="btn btn-maroon">🔙 Back to Menu</a>
</div>

</body>
</html>

