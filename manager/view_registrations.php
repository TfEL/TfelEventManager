<?php

// Manegerial dashboard

// Functions
require "../api/api.fnc.php";
require "../api/settings.php";
require "loginverification.fnc.php";

// Wrapper
$userData = login_verify($_COOKIE);

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$event = $socket->real_escape_string(filter_var($_GET['event'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

$query = MakeDatabaseQuery("SELECT * FROM `registrations` WHERE `for`=$event;", $socket);

$inc = 0;
foreach($query as $key) {
	$inc++;
}

if ($_GET[csv] == true) { 
header("Content-Type: text/plain");
header("Content-Disposition: attachment;filename=registrations.csv");
	foreach($query as $key) {	
			if (!empty($key[dietary])) {
				echo "$key[name], $key[school], $key[email], $key[phone], $key[dietary],\n";
			} else {
				echo "$key[name], $key[school], $key[email], $key[phone], none,\n";
			}
	}

} else {
	
	require "../attendees/header.php";
	
?>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Evolved Event Management Dashboard</p>
</div>
<p><a href="./dashboard.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Back</a> <a href="view_registrations.php?event=<?=$event?>&csv=true" target="_new" class="btn btn-default"><span class="glyphicon glyphicon-save"></span> Export as CSV (Excel)</a></p>


<?php
echo "<p>There are $inc registrations for this event.</p>";

foreach($query as $key) {
	echo "<div class=\"panel panel-default\">";
		echo "<div class=\"panel-heading\">";
			echo "<div class=\"pull-right\"><span class=\"glyphicon glyphicon-user\"> </span> </div>";
			echo "<p class=\"panel-title\">$key[name]</p>";
		echo "</div>";
		echo "<div class=\"panel-body\">";
		echo "<div class=\"pull-right\"> <a href=\"./delete_registrations.php?id=$key[id]\" class=\"btn btn-danger\"> <span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </div>";
		if (!empty($key[dietary])) {
			echo "<p><strong>School:</strong> $key[school]. <strong>Email:</strong> $key[email]. <strong>Phone:</strong> $key[phone]. <strong>Dietary:</strong> $key[dietary]. </p>";
		} else {
			echo "<p><strong>School:</strong> $key[school]. <strong>Email:</strong> $key[email]. <strong>Phone:</strong> $key[phone]. <strong>Dietary:</strong> None. </p>";
		}
		echo "</div>";
	echo "</div>";
}

// Wrapper
require "../attendees/footer.php";
}
?>