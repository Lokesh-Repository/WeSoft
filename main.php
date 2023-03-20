<?php
// Update the details below with your MySQL details
$DATABASE_HOST = 'sql310.epizy.com';
$DATABASE_USER = ''; //removed the username for safety purposes,just add one if you have!
$DATABASE_PASS = ''; //removed the username for safety purposes,just add one if you have!
$DATABASE_NAME = 'epiz_33178929_phpnewsletters';
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    // Output all connection errors. We want to know what went wrong...
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to database!');
}
?> 