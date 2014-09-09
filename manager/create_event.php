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

$event = $socket->real_escape_string(filter_var($_GET['event'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

?>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea",
	menubar: false
 });
</script>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Evolved Event Management Dashboard</p>
</div>

<p><a href="./dashboard.php" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></p>

<?php if ($_GET['edit'] == true) {
	
	$query = MakeDatabaseQuery("SELECT * FROM `events` WHERE `id`=\"$event\";", $socket);
	
	foreach($query as $key) {
?>

<form action="create_edit_scaffold.php" method="get">

<input type="hidden" name="existing_event" value="1">
<input type="hidden" name="event_id" value="<?=$_GET['event']?>">


<p>Event begin date &amp; time <br>
<input type="text" name="dtbegin" class="form-control" placeholder="2014-12-25 09:00 am" value="<?=$key[dtbegin]?>" required></p>
<p>Event end date &amp; time
<input type="text" name="dtend" class="form-control" placeholder="2014-12-25 09:00 pm" value="<?=$key[dtend]?>" required></p>
<p>Event Name &mdash; ideally three-five words about the event, short as possible <br>
<input type="text" name="name" class="form-control" placeholder="Event Name (Short)" value="<?=$key[name]?>" required></p>
<p>Venue &mdash; ideally a one-liner for the ADDRESS – this powers the Google Map, make sure it's correct! <br>
<input type="text" name="venue" class="form-control" placeholder="Venue (Short)" value="<?=$key[venue]?>" required></p>
<p>Cost &mdash; ideally a one-liner about cost, if you REALLY need two lines, type &lt;br&gt; in between lines <br>
<input type="text" name="cost" class="form-control" placeholder="Cost (Short)" value="<?=$key[cost]?>" required></p>
<p>Catering &mdash; ideally a one-liner about catering, if you REALLY need two lines, type &lt;br&gt; in between lines <br>
<input type="text" name="catering" class="form-control" placeholder="Catering (Short)" value="<?=$key[catering]?>" required></p>
<p>Event name &mdash; longer, but not too long displayed on the event 'details' page. <br>
<input type="text" name="head" class="form-control" placeholder="Event Name (Long)" value="<?=$key[head]?>" required></p>
<p>Event name byline &mdash; displayed on the event 'details' page, under the event name (long) above <br>
<input type="text" name="sub" class="form-control" Placeholder="Event Name Byline (Long)" value="<?=$key[sub]?>" required></p>
<p>Description &mdash; formatted and spell checked on the fly <br>
<textarea name="description"><?=$key[description]?></textarea></p>
<p><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Update Event</button></p>

<?php
}
} else { 

?>

<form action="create_edit_scaffold.php" method="get">
	<input type="hidden" name="owner" value="<?=$userData[email_address]?>">
	<p>Event begin date &amp; time <br>
	<input type="datetime-local" name="dtbegin" class="form-control" placeholder="2014-12-25 09:00 am" required></p>
	<p>Event end date &amp; time
	<input type="datetime-local" name="dtend" class="form-control" placeholder="2014-12-25 09:00 pm" required></p>
	<p>Event Name &mdash; ideally three-five words about the event, short as possible <br>
	<input type="text" name="name" class="form-control" placeholder="Event Name (Short)" required></p>
	<p>Venue &mdash; ideally a one-liner for the ADDRESS – this powers the Google Map, make sure it's correct! <br>
	<input type="text" name="venue" class="form-control" placeholder="Venue (Short)" required></p>
	<p>Cost &mdash; ideally a one-liner about cost, if you REALLY need two lines, type &lt;br&gt; in between lines <br>
	<input type="text" name="cost" class="form-control" placeholder="Cost (Short)" required></p>
	<p>Catering &mdash; ideally a one-liner about catering, if you REALLY need two lines, type &lt;br&gt; in between lines <br>
	<input type="text" name="catering" class="form-control" placeholder="Catering (Short)" required></p>
	<p>Event name &mdash; longer, but not too long displayed on the event 'details' page. <br>
	<input type="text" name="head" class="form-control" placeholder="Event Name (Long)" required></p>
	<p>Event name byline &mdash; displayed on the event 'details' page, under the event name (long) above <br>
	<input type="text" name="sub" class="form-control" Placeholder="Event Name Byline (Long)" required></p>
	<p>Description &mdash; formatted and spell checked on the fly <br>
	<textarea name="description"> </textarea></p>
	<p class="pull-right">Resize here ^</p>
	<p><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Create Event</button></p>
</form>
<?php
}
// Wrapper
require "../attendees/footer.php";

?>