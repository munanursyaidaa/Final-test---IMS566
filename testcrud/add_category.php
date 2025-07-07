<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $status = $_POST['status'];
    $conn->query("INSERT INTO categories (title, status, created, modified) VALUES ('$title', '$status', NOW(), NOW())");
    header("Location: categories.php");
}
?>
<form method="POST">
    Title: <input type="text" name="title"><br><br>
    Status: 
    <select name="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select><br><br>
    <button type="submit">Add</button>
</form>
