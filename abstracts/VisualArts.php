<?php
require_once('../base.php');

// Define the subject areas relevant to Visual Arts abstracts
$subjectAreas = [
    'vestibulum',
    'blandit',
    // Add any other subjects relevant to Visual Arts
];

$inject = [
    'title' => 'Visual Arts - Subject Areas',
    'body' => '<div class="container"><h2>Visual Arts Subjects</h2><ul>'
];

foreach ($subjectAreas as $subject) {
    $inject['body'] .= '<li><a href="displayAbstracts.php?type=Visual Arts&subject=' . urlencode($subject) . '">' . $subject . '</a></li>';
}

$inject['body'] .= '</ul></div>';

printMain($inject);
?>
