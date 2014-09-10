<?php

// List engine, HTML template below

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$query = MakeDatabaseQuery("SELECT * FROM `events`;", $socket);

?>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Upcoming events by the TfEL Team</p>
</div>

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
			echo "<div class=\"pull-right\"> <a href=\"./?view_event=$key[id]\" class=\"btn btn-success\"> <span class=\"glyphicon glyphicon-map-marker\"></span> Learn More</a> <a href=\"./?register_event=$key[id]\" class=\"btn btn-primary\"> <span class=\"glyphicon glyphicon-flag\"></span> Register Now</a> </div>";
		echo "</div>";
	echo "</div>";
}

?>
