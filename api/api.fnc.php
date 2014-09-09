<?php

// Database functions. I'll try to keep them ALL here, for portability or interop, or something.

function ConnectToDatabase ( $db ) { 
    
    $DatabaseHost = $db["DatabaseHost"];
    
    $DatabaseName = $db["DatabaseName"];

    $DatabaseUser = $db["DatabaseUsername"];

    $DatabasePassword = $db["DatabasePassword"];

    $socket = new mysqli($DatabaseHost, $DatabaseUser, $DatabasePassword, $DatabaseName);
    
    if (!$socket) { 
        echo "<strong>Warning:</strong> I wasn't able to establish a connection to the SQL server, this is very bad. I'm going to try again... <br />";
        $socket = new mysqli($DatabaseHost, $DatabaseUser, $DatabasePassword, $DatabaseName);
        if (!$socket) { echo "<strong>Error:</strong> I was totally unable to establish any connections with the SQL server, I'm going to have to stop here. :( <br />"; die(); }
    }
    
    return $socket;
}

function MakeDatabaseQuery ( $queryIn, $dataSocket ) {
    if ( !empty($queryIn) ) {
        $result = $dataSocket->query($queryIn);
    }
    else {
        $result = "No result, query failed";  
    }
    return $result;
}

function MakeDatabaseFetch ( $QueryOut ) {
    $return = $QueryOut->fetch_assoc();
    return $return;
}

?>