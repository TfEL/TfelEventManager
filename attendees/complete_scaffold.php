<?php

// Form Submission Engine

require '../api/api.fnc.php';
require '../api/settings.php';

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$event = $socket->real_escape_string(filter_var($_GET['register_event'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

$query = MakeDatabaseQuery("SELECT * FROM `events` WHERE `id`=$event;", $socket);

$name = $socket->real_escape_string(filter_var($_GET['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$school = $socket->real_escape_string(filter_var($_GET['school'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$email = $socket->real_escape_string(filter_var($_GET['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$phone = $socket->real_escape_string(filter_var($_GET['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$dietary = $socket->real_escape_string(filter_var($_GET['dietary'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

// Wrapper...
require "header.php";

if ( empty($name) || empty($school) || empty($email) || empty($phone) ) {
	$success = false;
	$error_message = "You didn't fill in all the required fields, please go back and try again";
} else {
	$return = MakeDatabaseQuery("INSERT INTO `eventmanager`.`registrations` (`id`, `created`, `for`, `name`, `school`, `email`, `phone`, `dietary`) VALUES (NULL, CURRENT_TIMESTAMP, '$event', '$name', '$school', '$email', '$phone', '$dietary');", $socket);
}

if (!$return) { 
	$success = false;
	$error_message = "Internal software error, it's not you, it's us, please try again";
} else { 
	$success = true;
}

?>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Register for an event by the TfEL Team</p>
</div>

<div> <p><a href="/" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></p> </div>

<?php

	if ($success == true) { 
		echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Registration Received</strong> thank you. </div>";
		
		$query = MakeDatabaseQuery("SELECT * FROM `events` WHERE `id`=$event;", $socket);
		
		foreach($query as $key) {
			$ename = $key[name];
			$edtbegin =  $key[dtbegin];
			$edtend = $key[dtend];
			$evenue =  $key[venue];
			$ecost = $key[cost];
			$ecatering = $key[catering];
		}
		
        require './includes/PHPMailerAutoload.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'mail.internode.on.net';
        $mail->SMTPAuth = false;
        $mail->setFrom('no-reply@events.tfel.edu.au', 'TfEL Events');
        $mail->addAddress($email, $name);
        $mail->Subject = 'Event Registration Confirmation';
        $mail->Body    = '<!DOCTYPE html>
		<html>
		<body>
		    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		    <div class="container">
		        <h2>Event Registration Confirmation</h2>
		        <p>Hello '.$name.',</p>
		        <p>This message confirms your recent registration for '.$ename.'.</p>
				<p>The event starts '.$edtbegin.' and ends '. $edtend .', and will be hosted at '. $evenue .'.</p>
				<h3>For your records</h3>
				<p>Cost: '.$ecost.'.</p>
				<p>Catering:  '.$ecatering.'.</p>
				<p>Your information: name '.$name.', school '.$school.', email '.$email.', phone '.$phone.', dietary requirements '.$dietary.'.</p>
		        <p>Best Wishes,</p>
		        <p>The Teaching for Effective Learning Team</p>
		        <p>Online: <a href="//www.tfel.edu.au" target="_blank">TfEL Resources</a><br>Phone: <a href="tel:0882264351">08 8226 4351</a></p>
		        <p><small>Please do not reply to this email. Use the contact address above.</small></p>
		    </div>
		</body>
		</html>';

		        if(!$mail->send()) {
		            echo '<strong>Mail error:</strong> ' . $mail->ErrorInfo;
		            $success = false;
					$error_message = "Internal software error, it's not you, it's us, please try again";
		        } else {
		            header('Location: /attendees/register_complete.php');
		        }
		
		
	} else { 
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Registration Error</strong> something went wrong while attempting to add your registration.</div>
		<p>$error_message.</p>
		 <p>Unfortunately we were not able to add your registration at this time. Please, try again. If you keep receiving this error, try using a different web-browser, or device.</p>";
	}

require "footer.php";

?>