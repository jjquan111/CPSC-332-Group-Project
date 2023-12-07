<?php
require_once('../base.php');

$inject = [
    'title' => 'Abstracts List',
    'body' => '<div class="container">
                <ul>
                    <li><a href="OralTalk.php">Oral Talk</a></li>
                    <li><a href="Poster.php">Poster</a></li>
                    <li><a href="PerformingArts.php">Performing Arts</a></li>
                    <li><a href="VisualArts.php">Visual Arts</a></li>
                </ul>
               </div>'

];

printMain($inject);

?>
