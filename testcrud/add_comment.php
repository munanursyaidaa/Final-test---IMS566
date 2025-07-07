<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $app_id = $_POST['application_id'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $status = $_POST['status'];
    $created = date('Y-m-d H:i:s');

    if (!empty($app_id) && !empty($name) && !empty($comment) && !empty($rating)) {
        $stmt = $conn->prepare("INSERT INTO comments 
            (application_id, name, comment, rating, status, created, modified)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $app_id, $name, $comment, $rating, $status, $created, $created);
        $stmt->execute();
    }
}

header("Location: index.php");
exit();
