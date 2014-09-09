<?php

// Teacher Registration for WruD
// © 2014 Department for Education and Child Development

// @Requries - uses the settings from the API for centralisation
require '../api/settings.php';
require '../api/api.fnc.php';

// @Headers
date_default_timezone_set("Australia/Adelaide");

// @Setters
$db = configure_active_database();
$socket = ConnectToDatabase($db) or die("<strong>Error:</strong> couldn't find database! Try again in a few moments.");

// @Getters
$cleanData = array();
$cleanData['emailaddress'] = $socket->real_escape_string(filter_var($_GET['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

// @Inref Functions
function return_failed() {
    header('Location: /attendees/register.php?ssl=true&failed=true');
}

function fix_time($timeString) {
    try {
        $correctTimeStamp = date("Y-m-d H:i:s", $timeString);
    } catch (Exception $e) { 
        return_failed();
    }
    return $correctTimeStamp;
}

// @Create Time

$timeCreated = fix_time(time());

// @Build Query

$safeQuery = "UPDATE `users` SET `enabled` = '1' WHERE `emailaddress` = '$cleanData[emailaddress]';";

echo $safeQuery;

// @Insert New User

try {
    $result = MakeDatabaseQuery($safeQuery, $socket) or return_failed();
    
    if (!result) {
        return_failed();
        die();
    } else {
        header('Location: /attendees/register_complete.php?ex=:nil');
    }
} catch (Exception $e) {
    return_failed();
    die();
} 
