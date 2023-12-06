<?php
require_once('base.php');

function runSQLFile($relativepath, $servername, $username, $password, $port, $database=NULL) {

  $basepath = dirname( dirname(__FILE__) ); //gives parent of parent of current file
  $scriptfullpath = '"' . $basepath . "/SQL Scripts" . $relativepath . '"';

  $conn = new mysqli($servername, $username, $password, $database, $port);

  $query = $conn->query("SHOW VARIABLES LIKE 'basedir'");
  $row = $query->fetch_assoc();
  $sqldir = '"' . $row['Value'] . '/bin/mysql"'; //gets the location of cmd 'mysql' so we can execute .sql files with it without it being on path
  if ($database) {
    //--password='{$password}'
    $args = " --user='{$username}' -h {$servername} -D {$database} < " . $scriptfullpath;
  }
  else {
    //--password='{$password}' 
    $args = " --user='{$username}' -h {$servername} < " . $scriptfullpath;
  }
  $output = shell_exec($sqldir . $args . " 2>&1");
  // return $sqldir . $args . " 2>&1";
  return $output;
}

try {
  $res1 = runSQLFile('/project_tables(4).sql', $GLOBALS['servername'], $GLOBALS['username'],$GLOBALS['password'], $GLOBALS['port']);
  $res2 = runSQLFile('/insertalldata.sql', $GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['port'], $GLOBALS['database']);
  $res3 = runSQLFile('/createViews.sql', $GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['port'], $GLOBALS['database']);

  $inject = [
    "body" => "<div class='container'>
                <a href='/cs332/'>Return Home</a>
                <ul>
                  <li>Create DB and Tables output: " . issetor($res1) . "</li>
                  <li>Create DB and Tables output: " . issetor($res2) . "</li>
                  <li>Create DB and Tables output: " . issetor($res3) . "</li>
                </ul>
              </div>",
    "title" => "Initialize the db success"
  ];
}
catch (Exception $e) {
  $inject = [
    "title" => "Initlize the db failed",
    "body" => "Failed to initialize the db, error: {$e->getMessage()}"
  ];
}

printMain($inject);
?>
