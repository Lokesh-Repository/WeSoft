<?php
    require("config.php");
    if (isset($_POST['updatepassword'])) {
        $pass = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        $update = "UPDATE `accounts` SET `password`='$pass', `resettoken`=NULL, `tokenexpiry`=NULL WHERE `email`='$_POST[email]'";
        if (mysqli_query($conn, $update)) {
            echo "
            <script>
            alert('Password changed Successfully');
            window.location.href='Login.html'
            </script>
            ";
        } else {
            echo "
            <script>
            alert('Server down please try again later !');
            window.location.href='Login.html'
            </script>
            ";
        }
    } else {
        echo "
            <script>
            alert('We had some Technical Issues! Try Later Please :)');
            window.location.href='Login.html'
            </script>
            ";
    }
?>
