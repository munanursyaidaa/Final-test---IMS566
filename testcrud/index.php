<?php
include 'db.php';

// Filter
$where = "WHERE 1=1";
if (isset($_GET['status']) && $_GET['status'] !== '') {
    $status = $_GET['status'];
    $where .= " AND status = '$status'";
}

// Get applications
$sql = "SELECT * FROM applications $where ORDER BY created DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Application Reviews</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h2 class="mb-4 text-primary">📱 Application Reviews</h2>

<!-- Filter Form -->
<form method="GET" class="row align-items-end mb-4">
    <div class="col-md-3">
        <label class="form-label">Filter by Status:</label>
        <select name="status" class="form-select">
            <option value="">All</option>
            <option value="Active" <?= (isset($_GET['status']) && $_GET['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= (isset($_GET['status']) && $_GET['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="export_pdf.php" class="btn btn-outline-primary" target="_blank">📄 Export to PDF</a>
    </div>
</form>

<!-- Review Listing -->
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <!-- Left: Text -->
                    <div class="col-md-9">
                        <h5 class="card-title">
                            <?= htmlspecialchars($row['title']) ?>
                            <span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Posted: <?= date('d M Y, h:i A', strtotime($row['created'])) ?>
                        </h6>

                        <p class="card-text"><?= nl2br(htmlspecialchars($row['review'])) ?></p>

                        <p>
                            Rating: <?= str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']) ?><br>
                            <?php
                                $app_id = $row['id'];
                                $avg_q = $conn->query("SELECT AVG(rating) AS avg_rating FROM comments WHERE application_id = $app_id AND status = 'Active'");
                                $avg_rating = $avg_q->fetch_assoc()['avg_rating'];
                                if ($avg_rating !== null):
                                    echo "<small><em>Average user rating: " . round($avg_rating, 2) . " / 5</em></small>";
                                endif;
                            ?>
                        </p>

                        <div class="mb-2">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">✏️ Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">🗑️ Delete</a>
                        </div>

                        <!-- Comments -->
                        <?php
                            $comments = $conn->query("SELECT * FROM comments WHERE application_id = $app_id AND status = 'Active' ORDER BY created DESC");
                            if ($comments->num_rows > 0):
                                echo "<div class='mt-3'><strong>Comments:</strong>";
                                while ($c = $comments->fetch_assoc()):
                        ?>
                                    <div class="p-2 border rounded mb-2 bg-light">
                                        <small><strong><?= htmlspecialchars($c['name']) ?></strong> (Rating: <?= $c['rating'] ?>)</small><br>
                                        <?= nl2br(htmlspecialchars($c['comment'])) ?><br>
                                        <small class="text-muted"><?= date('d M Y, h:i A', strtotime($c['created'])) ?></small>
                                    </div>
                        <?php
                                endwhile;
                                echo "</div>";
                            endif;
                        ?>

                        <!-- Add Comment -->
                        <hr>
                        <button onclick="toggleForm(<?= $app_id ?>)" class="btn btn-sm btn-outline-success">💬 Add Your Comment</button>
                        <div id="comment-form-<?= $app_id ?>" style="display:none;" class="mt-3">
                            <form method="POST" action="add_comment.php" class="row g-2 mt-2">
                                <input type="hidden" name="application_id" value="<?= $app_id ?>">
                                <div class="col-md-3">
                                    <input type="text" name="name" placeholder="Your name" class="form-control" required>
                                </div>
                                <div class="col-md-5">
                                    <textarea name="comment" placeholder="Your comment..." rows="2" class="form-control" required></textarea>
                                </div>
                                <div class="col-md-2">
                                    <select name="rating" class="form-select" required>
                                        <option value="">--</option>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <input type="hidden" name="status" value="Active">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right: Image -->
                    <div class="col-md-3 text-center">
                        <?php if ($row['image']): ?>
                            <img src="<?= $row['image_dir'] . $row['image'] ?>" alt="Image" class="img-thumbnail mb-3" style="max-width: 100%; max-height: 150px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="alert alert-info">No reviews found.</div>
<?php endif; ?>

<!-- Back to Menu -->
<div class="mt-4">
    <a href="menu.php" class="btn btn-maroon">🔙 Back to Menu</a>
</div>

<script>
function toggleForm(id) {
    var form = document.getElementById('comment-form-' + id);
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}
</script>

</body>
</html>
