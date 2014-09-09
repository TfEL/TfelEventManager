<?php

// Form Submission Engine

require '../api/api.fnc.php';
require '../api/settings.php';

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$existing_event = $socket->real_escape_string(filter_var($_GET['existing_event'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$event_id = $socket->real_escape_string(filter_var($_GET['event_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

$owner = $socket->real_escape_string(filter_var($_GET['owner'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$dtbegin = $socket->real_escape_string(filter_var($_GET['dtbegin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$dtend = $socket->real_escape_string(filter_var($_GET['dtend'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$name = $socket->real_escape_string(filter_var($_GET['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$venue = $socket->real_escape_string(filter_var($_GET['venue'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$cost = $socket->real_escape_string(filter_var($_GET['cost'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$catering = $socket->real_escape_string(filter_var($_GET['catering'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$head = $socket->real_escape_string(filter_var($_GET['head'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$sub = $socket->real_escape_string(filter_var($_GET['sub'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$description = $socket->real_escape_string(filter_var($_GET['description']));

// Wrapper...
require "../attendees/header.php";

if ( empty($dtbegin) || empty($dtend) || empty($name) || empty($venue) || empty($cost) || empty($catering) || empty($head) || empty($sub) || empty($description) ) {
	$success = false;
	$error_message = "You didn't fill in all the required fields, please go back and try again";
} else {
	if ($existing_event == true) {
		$query = "UPDATE `eventmanager`.`events` SET `dtbegin`='$dtbegin', `dtend`='$dtend', `name`='$name', `venue`='$venue', `cost`='$cost', `catering`='$catering', `head`='$head', `sub`='$sub', `description`='$description' WHERE `events`.`id`=$event_id;"; 		
		$return = MakeDatabaseQuery($query, $socket);
	} else {
		$query = "INSERT INTO `eventmanager`.`events` (`id`, `created`, `owner`, `dtbegin`, `dtend`, `name`, `venue`, `cost`, `catering`, `head`, `sub`, `description`) VALUES (NULL, CURRENT_TIMESTAMP, '$owner', '2014-09-09 00:00:00', '2014-09-09 00:00:00', '$name', '$venue', '$cost', '$catering', '$head', '$sub', '$description');";
		$return = MakeDatabaseQuery($query, $socket);
	}
	
	//$return = MakeDatabaseQuery("INSERT INTO `eventmanager`.`registrations` (`id`, `created`, `for`, `name`, `school`, `email`, `phone`, `dietary`) VALUES (NULL, CURRENT_TIMESTAMP, '$event', '$name', '$school', '$email', '$phone', '$dietary');", $socket);
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
	<p class="lead">Evolved Event Management Dashboard</p>
</div>

<div> <p><a href="./create_event.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></p> </div>

<?php

	if ($success == true) { 
		echo "<div class=\"alert alert-success\" role=\"alert\">Event Added Successfully. </div>";
	} else { 
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Event Creation Error</strong> something went wrong.</div> <p>$error_message.</p>";
	}

require "../attendees/footer.php";

?>