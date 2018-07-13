<?php
include_once "config.php";
include_once "queryBuilder.php";

$newDb = new queryBuilder($config);
$id = 40;
$success = $newDb->delete("Users", $id);
