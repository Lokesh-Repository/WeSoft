<?php
require("config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require __DIR__.'/vendor/autoload.php';
function sendMail($email, $reset_token)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = ''; //SMTP username (Add Your Username)
        $mail->Password = ''; //SMTP password (Add Your Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('wesoft.rf.gd@gmail.com', 'Password Change Request from WeSoft');
        $mail->addAddress($email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Reset Your We Soft Account Password';
        $mail->Body = " Hello There,  <br>
                        We Assume You Made A Password Change Request! If Yes Check Below! Else <b><u>DON't DO ANYTHING DUMB BY CLICKING ON THE LINK BELOW</u></b>
                       Click the link below : <br>
                       <a href='http://wesoft.rf.gd/updatepassword.php?email=$email&reset_token=$reset_token'>Click Here To Reset Your Password</a> <br>
                       Else just Copy paste The Below Link<br>
                       <p>http://wesoft.rf.gd/updatepassword.php?email=$email&reset_token=$reset_token</p>"
                       ;
        $mail->AltBody = 'yeah we have sent you an password reset link (you are seeing this text as you are non-html customer)';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
if (isset($_POST['send-link-mail'])) {
    $query = "SELECT * FROM `accounts` WHERE `email`='$_POST[email]'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d");
            $query = "UPDATE `accounts` SET `resettoken`='$reset_token',`tokenexpiry`='$date' WHERE `email`='$_POST[email]'";
            if (mysqli_query($conn, $query) && sendMail($_POST['email'], $reset_token)) {
                echo "
            <script>
            alert('We have sent an Password Reset Link To Your Inbox.SPAM TOO.');
            window.location.href='Login.html'
            </script>
            ";
            } else {
                echo "
            <script>
            alert('Ahhhh, CRAP!! Something Went Wrong, try again later');
            window.location.href='forgotpassword.html'
            </script>
            ";
            }
        } else {
            echo "
            <script>
            alert('We Are Really Not Dumb. So,First Register Yourself Dude!');
            window.location.href='forgotpassword.html'
            </script>
            ";
        }
    } else {
        echo "
        <script>
        alert('Yeah This Error Is On Us!. So,Chill We Will Fix It ASAP And Try Again Later.');
        window.location.href='forgotpassword.html'
        </script>
        ";
    }
}
?>
