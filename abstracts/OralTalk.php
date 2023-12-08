<?php
require_once('../base.php');

$subjectAreas = [
    'molestie sed',
    'gravida',
    'potenti nullam',
    // ... include other relevant subjects for Oral Talk
];

$inject = [
    'title' => 'Oral Talk - Subject Areas',
    'body' => '<div class="container"><h2>Oral Talk Subjects</h2><ul>'
];

foreach ($subjectAreas as $subject) {
    $inject['body'] .= '<li><a href="displayAbstracts.php?type=Oral Talk&subject=' . urlencode($subject) . '">' . $subject . '</a></li>';
}

$inject['body'] .= '</ul></div>';

printMain($inject);
?>
