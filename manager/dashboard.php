<?php

// Manegerial dashboard

// Functions
require "../api/api.fnc.php";
require "../api/settings.php";
require "loginverification.fnc.php";

// Wrapper
require "../attendees/header.php";

$userData = login_verify($_COOKIE);

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$query = MakeDatabaseQuery("SELECT * FROM `events`;", $socket);

$inc = 0;
foreach($query as $key) {
	$inc++;
}

?>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Evolved Event Management Dashboard</p>
</div>

<p>Welcome back, <?=$userData[first_name]?>. There are currently <?=$inc?> events open for registration.</p>

<p><a href="create_event.php" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> Create Event</a></p>

<?php

foreach($query as $key) {
	echo "<div class=\"panel panel-default\">";
		echo "<div class=\"panel-heading\">";
			echo "<div class=\"pull-right\"><span class=\"glyphicon glyphicon-calendar\"> </span> </div>";
			echo "<p class=\"panel-title\">$key[name]</p>";
		echo "</div>";
		echo "<div class=\"panel-body\">";
			echo "<p><strong>When:</strong> $key[dtbegin] to $key[dtend].</p>";
			echo "<p><strong>Where:</strong> $key[venue].</p>";
			echo "<p><strong>Cost:</strong> $key[cost].</p>";
			echo "<div class=\"pull-right\"> <a href=\"/attendees/?view_event=$key[id]\" title=\"To view as an attendee\" class=\"btn btn-info\" target=\"_NEW\"><span class=\"glyphicon glyphicon-send \"></span> Hyperlink to Event</a> <a href=\"./delete_events.php?id=$key[id]\" class=\"btn btn-danger\"> <span class=\"glyphicon glyphicon-remove\"></span> Delete Event</a> <a href=\"./create_event.php?edit=1&event=$key[id]\" class=\"btn btn-success\"> <span class=\"glyphicon glyphicon-check\"></span> Edit Event</a> <a href=\"./view_registrations.php?event=$key[id]\" class=\"btn btn-primary\"> <span class=\"glyphicon glyphicon-flag\"></span> View Registrations</a> </div>";
		echo "</div>";
	echo "</div>";
}

// Wrapper
require "../attendees/footer.php";

?>