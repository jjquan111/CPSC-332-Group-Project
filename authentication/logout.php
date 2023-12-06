<?php

require_once('../base.php');

session_destroy();
session_start();

$inject = [
    'body'=>"Logout Complete",
    'title'=>"Logout",
];
printMain($inject);
?>
