<?php
define (DB_USER, ""); //removed the username for safety purposes,just add one if you have!
define (DB_PASSWORD, ""); //removed the Password for safety purposes,just add one if you have!
define (DB_DATABASE, "epiz_33178929_phpnewsletters");  //use same name for easy setting up
define (DB_HOST, "sql310.epizy.com");
   $db = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>