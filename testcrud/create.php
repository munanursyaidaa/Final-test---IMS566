<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $review = $_POST['review'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $status = $_POST['status'] ?? '';

    if (!empty($title) && !empty($review) && !empty($rating) && !empty($status)) {
        $posted_date = date('Y-m-d H:i:s');
        $author = 'Admin'; // tukar ikut siapa login nanti

        $image_dir = 'uploads/';
        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $image = basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_dir . $image);
        }

        $stmt = $conn->prepare("INSERT INTO applications 
            (posted_date, author, title, review, image, image_dir, rating, status, created, modified)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

        $stmt->bind_param("ssssssss", $posted_date, $author, $title, $review, $image, $image_dir, $rating, $status);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $errorMsg = "❌ Failed to submit: " . $stmt->error;
        }
    } else {
        $errorMsg = "❌ Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Review</title>
    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom Style -->
    <style>
        body {
            background-color: #f5f5f5;
        }

        .btn-maroon {
            background-color: #c0392b;
            color: #fff;
            border: none;
            padding: 6px 16px;
            border-radius: 5px;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-maroon:hover {
            background-color: #a93226;
            color: #fff;
        }

        .btn-menu {
            background-color: #800000; /* maroon gelap */
            color: #fff;
        }

        .btn-menu:hover {
            background-color: #a93226;
            color: #fff;
        }

        .star {
            font-size: 28px;
            cursor: pointer;
            color: gray;
        }

        .star.selected {
            color: #ffc107;
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <!-- Back to Menu -->
    <div class="d-flex justify-content-end mb-3">
        <a href="menu.php" class="btn btn-menu">
            <i class="fas fa-arrow-left"></i> Back to Menu
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow border-0">
        <div class="card-header bg-maroon text-maroon">
            <h3 class="mb-0"><i class="fas fa-plus-circle"></i> Submit New App Review</h3>
        </div>
        <div class="card-body">

            <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-warning"><?= $errorMsg ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">App Name</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter app name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Review</label>
                    <textarea name="review" class="form-control" rows="5" placeholder="Write your review here..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating</label><br>
                    <div id="star-container" class="mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star" onclick="setRating(<?= $i ?>)">★</span>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="rating" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Image <small class="text-muted">(optional)</small></label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="">-- Select Status --</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-maroon"><i class="fas fa-paper-plane"></i> Submit Review</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function setRating(value) {
    document.getElementById('rating').value = value;
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
        star.classList.toggle('selected', index < value);
    });
}
</script>

</body>
</html>

