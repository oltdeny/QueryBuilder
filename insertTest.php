<?php
include_once "config.php";
include_once "queryBuilder.php";

$newDb = new queryBuilder($config);
$columns = [
    "name"=>"'tester'",
    "surname"=>"'query'",
    "password"=>"123",
    "nickname"=>"'weeee'"
];
$success = $newDb->insert("Users", $columns);
