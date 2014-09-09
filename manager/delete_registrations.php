<?php

// Manegerial dashboard

// Functions
require "../api/api.fnc.php";
require "../api/settings.php";
require "loginverification.fnc.php";

$userData = login_verify($_COOKIE);

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$delete = $socket->real_escape_string(filter_var($_GET['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

$query = MakeDatabaseQuery("DELETE FROM `eventmanager`.`registrations` WHERE `registrations`.`id` = $delete", $socket);

if (!$query) { 
	die("Failed");
} else { 
	header("Location: /manager/dashboard.php");
}
?>