<?php
include_once "config.php";
include_once "queryBuilder.php";

$newDb = new queryBuilder($config);
$columns = ["*"];
$cases = [
    "id"=>30
];
$newDb->select($columns);
$newDb->from("Users");
$newDb->where($cases);
$success = mysqli_fetch_array($newDb->execute());
print_r($success);
