<?php
   
   $DATABASE_HOST = 'sql310.epizy.com';
$DATABASE_USER = ''; //removed the username for safety purposes,just add one if you have!
$DATABASE_PASS = '';  //removed the password for safety purposes,just add one if you have!
$DATABASE_NAME = 'epiz_33178929_phpnewsletters';

 
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
       
        exit('Failed to connect With Our Server Dude! We Will Fix It ASAP, (ME:CALLING BACKEND TEAM)' . mysqli_connect_error());
    }



   
    if (!isset($_POST['username'], $_POST['password'], $_POST['email'],  $_POST['fname'],  $_POST['email'])) {
        // Could not get the data that should have been sent.
        exit('Please complete the registration form!');
    }
    // Make sure the submitted registration values are not empty.
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
        // One or more values are empty.
        exit('Please complete the registration form');
    }

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	
	if ($stmt->num_rows > 0) {
	
		echo 'Another User Exists! So,Radomize Your UserName Please!';
	} else {

        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, fname, lname ) VALUES (?, ?, ?, ?, ?)'))
         {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sssss', $_POST['username'], $password, $_POST['email'], $_POST['fname'], $_POST['lname']);      //the 'sssss' tells the sql prepare statement that the data which to be posted is of string ,string,string,string,string
            $stmt->execute();
            echo 'You Are Now A Member Dude! Welcome Aboard!';
            header('Location: Account.html');
        } else {
            
            echo 'We had some Technical Issues! Try Later Please :) ';
        }
}
$stmt->close();
} else {

echo 'We had some Technical Issues! Try Later Please :) ';
}
$con->close();
?>

