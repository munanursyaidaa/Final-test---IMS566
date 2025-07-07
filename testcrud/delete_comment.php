<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM comments WHERE id=$id");
header("Location: comments.php");
?>
