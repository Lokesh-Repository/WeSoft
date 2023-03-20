<?php


define (DB_USER, "");  //removed the username for safety purposes,just add one if you have!
define (DB_PASSWORD, ""); //removed the password for safety purposes,just add one if you have!
define (DB_DATABASE, "epiz_33178929_phpnewsletters");   //create the database with same name (you know why)
define (DB_HOST, "sql310.epizy.com");


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
?>