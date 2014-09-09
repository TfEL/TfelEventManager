<?php
$ssl = $_GET['ssl'];
$stage = $_GET['ex'];

if ($ssl == false) {
	//header("Location: https://www.tfel.edu.au/?ssl=true");
}


require 'header.php';
?>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Register to speed up registrations</p>
</div>

	<h1>Registering, next steps...</h1>
    <?php if ($stage == ":nil") { ?> <p><strong>You're ready to go!</strong> Your account has been successfully activated, and you can now log in.</p> <p class="text-center"><a href="./login.php" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-log-in"></span> Log In</a></p> <?php } else { ?> <p><strong>Great!</strong> You've completed step one of the registration process.</p> <p>Now head to your email inbox and click the verification link we just sent you.</p> <p>If you don't get the message, make sure to check your spam folder.</p> <p>If it has been more than 30 minutes and you still haven't heard anything, try registering again, or, <a href="mailto:DECD.Tfel@sa.gov.au">contact us</a>.</p> <p>You can safely close this page, your progress so far is saved.</p> <?php } ?>    

<?php

require 'footer.php';

?>