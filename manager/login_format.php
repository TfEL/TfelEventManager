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
$cleanData['emailaddress'] = $socket->real_escape_string(filter_var($_POST['emailaddress'], FILTER_VALIDATE_EMAIL));
$cleanData['password'] = $socket->real_escape_string(filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

// @Inref Functions
function return_failed() {
    header('Location: /login.php?ssl=true&failed=true');
}

function fix_time($timeString) {
    try {
        // COOKIE TIME FIXER!!!!!
        $correctTimeStamp = date("l, d-M-Y H:i:s T", $timeString);
    } catch (Exception $e) { 
        return_failed();
    }
    return $correctTimeStamp;
}

// @Build Query

$safeQuery = "SELECT * FROM `administrators` WHERE `emailaddress`='$cleanData[emailaddress]' AND `password`='$cleanData[password]';";

// @Insert New User

try {
    $result = MakeDatabaseQuery($safeQuery, $socket) or return_failed();
    
    $isRows = $result->num_rows;
    
    if ($isRows == 0) { 
        // Nothing came back in the query.
        return_failed();
    } else {
        // There was a result...
        $returnKeys = MakeDatabaseFetch($result, $socket);
        if ($returnKeys[emailaddress] == $cleanData[emailaddress]) {
            if ($returnKeys[password] == $cleanData[password]) {
                // Vaid user.
                
                $time = fix_time(time()+9000);
                
                echo '<script type="text/javascript">
                        document.cookie="emailAddress=' .$returnKeys[emailaddress] . '; expires=' . $time . ';";
                        document.cookie="firstName=' . $returnKeys[firstname] . '; expires=' . $time . ';";
                        document.cookie="loginStamped=until; expires=' . $time . ';";
                        window.location="./dashboard.php";
                    </script>';
            } else {
                return_failed();
            }
        } else {
            return_failed();
        }
    }
    
    if (!result) {
        return_failed();
        die();
    }
} catch (Exception $e) {
    return_failed();
    die();
} 
