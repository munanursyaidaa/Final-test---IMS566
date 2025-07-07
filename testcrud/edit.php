<?php
include 'db.php';
$id = $_GET['id'];
$get = $conn->query("SELECT * FROM applications WHERE id=$id");
$data = $get->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];

    $conn->query("UPDATE applications SET title='$title', review='$review', rating='$rating', status='$status', category_id='$category_id', modified=NOW() WHERE id=$id");
    echo "<div class='alert alert-success mt-3'>✅ Review updated successfully.</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Application Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- make sure you have btn-maroon -->
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary">✏️ Edit Application Review</h3>
        <a href="menu.php" class="btn btn-maroon text-white">
            <i class="fa-solid fa-arrow-left"></i> Back to Menu
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">App Title</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Review</label>
                    <textarea name="review" rows="5" class="form-control" required><?= htmlspecialchars($data['review']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Rating</label>
                    <input type="number" name="rating" min="1" max="5" value="<?= $data['rating'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Active" <?= $data['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= $data['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" class="form-select" required>
                        <?php
                        $cat = $conn->query("SELECT * FROM categories");
                        while ($row = $cat->fetch_assoc()) {
                            $selected = ($row['id'] == $data['category_id']) ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['title']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn bg-maroon btn-maroon text-dark">💾 Update Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Back to Menu -->
<div class="mt-4">
    <a href="menu.php" class="btn btn-maroon">🔙 Back to Menu</a>
</div>


</div>
<!-- Font Awesome for icon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
