<?php
require("config.inc.php");
require("common.inc.php");
$conn = new mysqli($host, $user, $password, $db_name);
if ($conn->connect_error == null) {
    echo "Successfully connected to " . $db_name;
}
