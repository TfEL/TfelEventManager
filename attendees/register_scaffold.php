<?php

// List engine, HTML template below

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$event = $socket->real_escape_string(filter_var($_GET['register_event'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

$query = MakeDatabaseQuery("SELECT * FROM `events` WHERE `id`=$event;", $socket);

?>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Register for an event by the TfEL Team</p>
</div>

<div> <p><a href="/" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></p> </div>
<?php

foreach($query as $key) {
	echo "<div class=\"panel panel-default\">";
		echo "<div class=\"panel-heading\">";
			echo "<div class=\"pull-right\"><span class=\"glyphicon glyphicon-calendar\"> </span> </div>";
			echo "<p class=\"panel-title\">Registration for $key[name]</p>";
		echo "</div>";
		echo "<div class=\"panel-body\">";
			echo "<p><strong>When:</strong> $key[dtbegin] to $key[dtend].</p>";
			echo "<p><strong>Where:</strong> $key[venue].</p>";
			echo "<p><strong>Cost:</strong> $key[cost].</p>";
?>

<form action="complete_scaffold.php" method="get">
	<input type="hidden" name="register_event" value="<?=$event?>">
	
	<p>Full Name <span style="color:red">*</span><br><input type="text" class="form-control" name="name" placeholder="Full Name" required></p>
	<p>School / Site <span style="color:red">*</span><br><input type="text" class="form-control" name="school" placeholder="School" required></p>
	<p>Email Address <span style="color:red">*</span><br><input type="email" class="form-control" name="email" placeholder="Email Address" required></p>
	<p>Phone Number (inc area code) <span style="color:red">*</span><br><input type="phone" class="form-control" name="phone" placeholder="Phone Number" required></p>
	<p>Dietary Requirements <br><input type="text" class="form-control" name="dietary" placeholder="None" required></p>
	
	<p><button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"> Register</button></p>
		
	<p><span style="color:red">*</span> indicates a required field</p>
</form>

<?php 
		echo "</div>";
	echo "</div>";
}
?>