<?php
include 'db.php';
$id = $_GET['id'];
$get = $conn->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $status = $_POST['status'];
    $conn->query("UPDATE categories SET title='$title', status='$status', modified=NOW() WHERE id=$id");
    header("Location: categories.php");
}
?>
<form method="POST">
    Title: <input type="text" name="title" value="<?= $get['title'] ?>"><br><br>
    Status: 
    <select name="status">
        <option value="Active" <?= $get['status']=='Active' ? 'selected' : '' ?>>Active</option>
        <option value="Inactive" <?= $get['status']=='Inactive' ? 'selected' : '' ?>>Inactive</option>
    </select><br><br>
    <button type="submit">Update</button>
</form>
