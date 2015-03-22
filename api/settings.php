<?php

// Insert:: INSERT INTO `wrud`.`classlist` (`id`, `owner`, `created`, `classcode`) VALUES (NULL, 'aidancornelius@research.tfel.edu.au', '2014-07-15 12:15:00', '8883cc34');

// Insert User:: INSERT INTO `wrud`.`teachers` (`id`, `emailaddress`, `created`, `password`) VALUES (NULL, 'aidancornelius@research.tfel.edu.au', '2014-07-15 00:00:00', 'rabbit10');

// Query:: SELECT * FROM `classlist` WHERE `classcode`="8883cc34";

// Query:: SELECT * FROM `teachers` WHERE `emailaddress`='aidancornelius@research.tfel.edu.au' AND `password`='rabbit10';

// ext-silk02.aueast.tfel.edu.au

function configure_active_database ( ) { 

	$db = array();

	$db["DatabaseHost"] = "ext-silk02.aueast.tfel.edu.au";

	$db["DatabasePort"] = "3306";

	$db["DatabaseName"] = "eventmanager";

	$db["DatabaseUsername"] = "eventmanager";

	$db["DatabasePassword"] = "";

	return $db;
}
