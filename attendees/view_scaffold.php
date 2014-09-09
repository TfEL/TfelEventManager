<?php

// List engine, HTML template below

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$event = $socket->real_escape_string(filter_var($_GET['view_event'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

$query = MakeDatabaseQuery("SELECT * FROM `events` WHERE `id`=$event;", $socket);
if ($_GET['api'] = 1) { } 
else {
?>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Upcoming event by the TfEL Team</p>
</div>

<div> <p><a href="/" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></p> </div>

<?php
}
foreach($query as $key) {
	echo "<div class=\"panel panel-default\">";
		echo "<div class=\"panel-heading\">";
			echo "<div class=\"pull-right\"><span class=\"glyphicon glyphicon-calendar\"> </span> </div>";
			echo "<p class=\"panel-title\">$key[name]</p>";
		echo "</div>";
		echo "<div class=\"panel-body\">";
		if ($_GET['api'] = 1) { } else {
		echo '<iframe width="100%" height="280" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q='. $key[venue] . '&output=embed"></iframe>'; }
			echo "<p><strong>When:</strong> $key[dtbegin] to $key[dtend].</p>";
			echo "<p><strong>Where:</strong> $key[venue].</p>";
			echo "<p><strong>Cost:</strong> $key[cost].</p>";
			echo "<p><strong>Catering:</strong> $key[catering]";
			echo "<hr>";
			echo "<h3>$key[head]</h3>";
			echo "<p class=\"lead\">$key[sub]</p>";
			echo "$key[description]";
			echo "<hr>";
			if ($_GET['api'] = 1) { } else {
			echo "<div class=\"pull-right\"> <a href=\"./?register_event=$key[id]\" class=\"btn btn-primary\"> <span class=\"glyphicon glyphicon-flag\"></span> Register Now</a> </div>"; }
		echo "</div>";
	echo "</div>";
}

?>