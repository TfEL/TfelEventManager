<?php

// © 2014 Department for Education and Child Development
// Event & Conference Manager by Aidan Cornelius-Bell

// Switching 'view controller', haha.

// Functions
require "../api/api.fnc.php";
require "../api/settings.php";
require "loginverification.fnc.php";

// Getters
$register = $_GET['register_event'];
$view = $_GET['view_event'];

$userData = login_verify($_COOKIE);

// Wrapper
require "header.php";

if (!empty($view)) {
	require "view_scaffold.php";
}

if (!empty($register)) {
	require "register_scaffold.php";
}

if (empty($register) && empty($view)) {
	require "list_scaffold.php";
}

// Wrapper
require "footer.php";

?>
