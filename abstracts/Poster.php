<?php
require_once('../base.php');

// Define the subject areas relevant to Poster abstracts
$subjectAreas = [
    'sapien ut',
    'morbi',
    'sed vestibulum',
    // Add other relevant subjects here
];

$inject = [
    'title' => 'Poster - Subject Areas',
    'body' => '<div class="container"><h2>Poster Subjects</h2><ul>'
];

foreach ($subjectAreas as $subject) {
    $inject['body'] .= '<li><a href="displayAbstracts.php?type=Poster&subject=' . urlencode($subject) . '">' . $subject . '</a></li>';
}

$inject['body'] .= '</ul></div>';

printMain($inject);
?>
