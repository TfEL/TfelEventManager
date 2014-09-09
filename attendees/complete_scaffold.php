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
	} else { 
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Registration Error</strong> something went wrong while attempting to add your registration.</div>
		<p>$error_message.</p>
		 <p>Unfortunately we were not able to add your registration at this time. Please, try again. If you keep receiving this error, try using a different web-browser, or device.</p>";
	}

require "footer.php";

?>