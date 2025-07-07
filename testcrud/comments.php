<?php
include 'db.php';
$res = $conn->query("SELECT comments.*, applications.title AS app_title 
                    FROM comments 
                    JOIN applications ON comments.application_id = applications.id 
                    ORDER BY comments.created DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="container py-4">

    <h2 class="mb-4 text-primary">💬 Manage Comments</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-secondary">
                <tr>
                    <th>ID</th>
                    <th>App</th>
                    <th>Name</th>
                    <th>Comment</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['app_title']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['comment'])) ?></td>
                        <td><?= $row['rating'] ?></td>
                        <td class="d-flex gap-2">
                            <a href="edit_comment.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">✏️ Edit</a>
                            <a href="delete_comment.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this comment?')" class="btn btn-sm btn-outline-secondary">🗑️ Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Back to Menu Button -->
    <div class="mt-4">
        <a href="menu.php" class="btn btn-maroon">🔙 Back to Menu</a>
    </div>

</body>
</html>
