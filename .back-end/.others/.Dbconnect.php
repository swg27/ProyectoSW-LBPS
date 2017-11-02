<?php

error_reporting(~E_DEPRECATED & ~E_NOTICE);

define('DBHOST', '');
define('DBUSER', '');
define('DBPASS', '');
define('DBNAME', '');
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
or die("Database Connection failed : " . mysqli_error());

//echo "Database successfully connected ";

?>