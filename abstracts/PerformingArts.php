<?php
require_once('../base.php');

// Define the subject areas specifically for Performing Arts
$subjectAreas = [
    'Performing Art',
    'Music',
    'Theatre',
    'Film Studies',
    'Dance',
    // Add other relevant subjects for Performing Arts
];

$inject = [
    'title' => 'Performing Arts - Subject Areas',
    'body' => '<div class="container"><h2>Performing Arts Subjects</h2><ul>'
];

foreach ($subjectAreas as $subject) {
    $inject['body'] .= '<li><a href="displayAbstracts.php?type=Performing Arts&subject=' . urlencode($subject) . '">' . $subject . '</a></li>';
}

$inject['body'] .= '</ul></div>';

printMain($inject);
?>
