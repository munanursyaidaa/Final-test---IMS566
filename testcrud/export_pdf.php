<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'db.php';

$mpdf = new \Mpdf\Mpdf();
$html = '<h2>Application Reviews</h2><hr>';

$result = $conn->query("SELECT * FROM applications ORDER BY created DESC");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<div style="margin-bottom: 20px;">';
        $html .= '<strong>' . htmlspecialchars($row['title']) . '</strong> (' . htmlspecialchars($row['status']) . ')<br>';
        $html .= '<small>Posted: ' . date('d M Y, h:i A', strtotime($row['created'])) . '</small><br><br>';
        $html .= nl2br(htmlspecialchars($row['review'])) . '<br><br>';
        $html .= 'Rating: ' . str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']) . '<br>';

        if (!empty($row['image'])) {
            $imagePath = $row['image_dir'] . $row['image'];
            if (file_exists($imagePath)) {
                $base64 = base64_encode(file_get_contents($imagePath));
                $type = pathinfo($imagePath, PATHINFO_EXTENSION);
                $html .= '<br><img src="data:image/' . $type . ';base64,' . $base64 . '" width="100"><br>';
            }
        }

        $html .= '</div><hr>';
    }
} else {
    $html .= '<p>No reviews found.</p>';
}

$mpdf->WriteHTML($html);
$mpdf->Output('reviews.pdf', 'I'); // 'I' to view in browser

