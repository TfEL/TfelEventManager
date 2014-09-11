<?php

// Form Submission Engine

require "api.fnc.php";
require "settings.php";
require "authentication_header.fnc.php";

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$event = $socket->real_escape_string(filter_var($_GET['register_event'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

$query = MakeDatabaseQuery("SELECT * FROM `events` WHERE `id`=$event;", $socket);

$name = $socket->real_escape_string(filter_var($_GET['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$school = $socket->real_escape_string(filter_var($_GET['school'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$email = $socket->real_escape_string(filter_var($_GET['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$phone = $socket->real_escape_string(filter_var($_GET['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
$dietary = $socket->real_escape_string(filter_var($_GET['dietary'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

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

if (!$error_message) {
	$error_message = "Success";
}

$return = array("Success" => $success, "Message" => $error_message);

echo json_encode($return, JSON_PRETTY_PRINT);

?>