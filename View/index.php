<?php
require_once('../base.php');

$inject = [
    'title' => 'Required Views',
    'body' => '<div class="container">
                <ul>
                    <li><a href="10moreEvent.php">Who create more than 10 events</a></li>
                    <li><a href="100moreAbstracts.php">events with more than 100 abstracts</a></li>
                    <li><a href="abstractsOver20P.php">abstracts with over 20 presenters</a></li>
                    <li><a href="abstracts_CW.php"> abstracts which are closed or withdrawn</a></li>
                </ul>
               </div>'

];

printMain($inject);

?>