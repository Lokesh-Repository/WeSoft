<?php
include "config.php";

date_default_timezone_set("	Asia/Kolkata");

if (isset($_POST['verify'])) {

	if (isset($_GET['code'])) {

		$activation_code = $_GET['code'];
		$otp = $_POST['otp'];

		$sqlSelect = "SELECT * FROM accounts WHERE activation_code = '" . $activation_code . "'";
		$resultSelect = mysqli_query($conn, $sqlSelect);
		if (mysqli_num_rows($resultSelect) > 0) {

			$rowSelect = mysqli_fetch_assoc($resultSelect);

			$rowOtp = $rowSelect['otp'];
			$rowSignupTime = $rowSelect['signup_time'];

			$signupTime = date('d-m-Y h:i:s', strtotime($rowSignupTime));
			$signupTime = date_create($signupTime);
			date_modify($signupTime, "+5 minutes");
			$timeUp = date_format($signupTime, 'd-m-Y h:i:s');

			if ($rowOtp !== $otp) {
				echo "<script>alert('Please provide correct OTP..!')</script>";
			} 
            else {
				if (date('d-m-Y h:i:s') >= $timeUp) {

					echo "<script>alert('Your time is up..try it again..!')</script>";
					header("Refresh:1; url=Account.php");
				}
                 else {
					 $recaptcha = $_POST["g-recaptcha-response"];
                    $secret_key = "6LfSh8YlAAAAAFD8o07xaiVYMCNBBCRMQzFUIXhx";
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=". $secret_key . "&response=" . $recaptcha;
                    $response = file_get_contents($url);
                    $response = json_decode($response);
  
    if ($response->success == true) {
    $sqlUpdate = "UPDATE accounts SET otp = '', status = 'active' WHERE otp = '" . $otp . "' AND activation_code = '" . $activation_code . "'";
    $resultUpdate = mysqli_query($conn, $sqlUpdate);

						if ($resultUpdate) {
    						echo "<script>alert('Your account successfully activated')</script>";
    						header("Refresh:1; url=Account.php");
									} 
 						else {
 						echo "<script>alert('Opss..Your account not activated')</script>";
							}
   						 } 
else {
        echo '<script>alert("WE KNOW YOU ARE A HUMAN But Our UNBELIEVABLE Developers Want You To Prove The Same So That We Dont Collect Spam Data.")</script>';
    }
				}
			}

		} else {
			header("Location: Account.php");
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta Tags -->
	<meta charset="UTF-8">
	<meta name="author" content="WeSoft">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Site Title -->
	<title>OTP Verification System</title>
	<!-- External Style Sheet -->
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

</head>

<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
		crossorigin="anonymous"></script>
	<!-- <div class="wrapper">
		<div class="otp">
			<h2>OTP Verify</h2>
			<hr>
			<form action="" method="POST">
				<div class="form-group">
					<label>OTP</label>
					<input type="text" name="otp" placeholder="Enter OTP to verify email" autocomplete="off">
				</div>
				<div class="form-group">
					<label></label>
					<input type="submit" name="verify" value="Verify">
				</div>
			</form>
		</div>
	</div> -->
	<!-- End of Login Wrapper -->
   <section>
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 fixed-top">
      <div class="container">
        <a class="navbar-brand bg-light navimage" href="index.html" id="navimage">
          <img src="Assets/Software-Care-1.png" width="50" height="50" class="d-inline-block align-centre"
            alt="We Soft logo">
        </a>
        <a href="index.html" class="navbar-brand">WE SOFT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" height="20px"
          width="10px">


          <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="index.html" class="nav-link"> HOME &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </li>
            <li class="nav-item" id="nav-item-deco">
              <a onclick="smoothScroll(document.getElementById('abt-us1'))" class="nav-link"> ABOUT US
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </li>
            <li class="nav-item" id="nav-item-deco">
              <a onclick="smoothScroll(document.getElementById('9874'))" class="nav-link"> OUR SERVICES
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </li>
            <li class="nav-item" id="nav-item-deco">
              <a href="careers.html" class="nav-link"> CAREERS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </li>
            <li class="nav-item" id="nav-item-deco">
              <a onclick="smoothScroll(document.getElementById('1546'))" class="nav-link"> CONTACT US
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </li>
            <li id="nav-item-deco">
              <a <button class="btn btn-primary btn-lg" type="button" href="Account.html" class="nav-link"> Login/Sign
                Up </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <script>
      window.smoothScroll = function (target) {
        var scrollContainer = target;
        do { //find scroll container
          scrollContainer = scrollContainer.parentNode;
          if (!scrollContainer) return;
          scrollContainer.scrollTop += 1;
        } while (scrollContainer.scrollTop == 0);

        var targetY = 0;
        do { //find the top of target relatively to the container
          if (target == scrollContainer) break;
          targetY += target.offsetTop;
        } while (target = target.offsetParent);

        scroll = function (c, a, b, i) {
          i++; if (i > 30) return;
          c.scrollTop = a + (b - a) / 30 * i;
          setTimeout(function () { scroll(c, a, b, i); }, 20);
        }
        // start scrolling
        scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
      }
   </script>
   </section>
	<section class="vh-100">
		<div class="container py-5 h-100">
			<div class="row d-flex align-items-center justify-content-center h-100">
				<div class="col-md-8 col-lg-7 col-xl-6">
					<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
						class="img-fluid" alt="Phone image">
				</div>
				<div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
					<form action="" method="POST">
						<!-- Email input -->
						<h3>Please Enter The OTP</h3>
						<div class="form-outline mb-4">
							<input type="text" name="otp" class="form-control form-control-lg" autocomplete="off" placeholder="Enter The Recieved OTP" required/>
						</div>
                        <!-- Recaptcha button -->
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <div class="g-recaptcha" data-sitekey="6LfSh8YlAAAAAIFv2KV0ly5_b5hytosZeCTJ7GkA"></div> 
						<!-- Submit button -->
						<button type="submit" name="verify" value="Verify" class="btn btn-primary btn-lg btn-block mt-2">Continue</button>
					</form>
				</div>
			</div>
		</div>
	</section>
</body>
</html>