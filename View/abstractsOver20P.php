<?php
require_once('../base.php');
require_once('../View/db_connect.php'); // Adjust the path to your database connection file

function getAbstractsWithOver20Presenters() {
    $query = "SELECT * FROM AbstractsWithOver20Presenters";
    $result = $GLOBALS['conn']->query($query);

    if (!$result) {
        die("Query failed: " . $GLOBALS['conn']->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

$abstracts = getAbstractsWithOver20Presenters();
$inject['title'] = 'Abstracts With Over 20 Presenters';

// Prepare HTML content
$inject['body'] = '<div class="container"><h4>Abstracts with More Than 20 Presenters</h4><ul>';
foreach ($abstracts as $abstract) {
    $inject['body'] .= "<li>Abstract ID: {$abstract['abstractID']} - Number of Presenters: {$abstract['NumberOfPresenters']}</li>";
}
$inject['body'] .= '</ul></div>';

printMain($inject);
?>
