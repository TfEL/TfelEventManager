<?php

require "authentication_header.fnc.php";

require "api.fnc.php";

require "settings.php";

$db = configure_active_database();

$socket = ConnectToDatabase($db);

$query = MakeDatabaseQuery("SELECT * FROM `events`;", $socket);

$return = array();

foreach ($query as $key) {
	$when = "From " . $key[dtbegin] . " to " . $key[dtend] . ".";
	$url = "https://events.tfel.edu.au/attendees/?view_event=" . $key[id] . "&api=1";
	$topush = array("id" => $key['id'], "when" => $when, "where" => $key['venue'], "name" => $key['name'], "cost" => $key['cost'], "catering" => $key['catering'], "detailsURL" => $url, );
	array_push($return, $topush);
}

echo json_encode($return, JSON_PRETTY_PRINT);

?>