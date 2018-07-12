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
$newDb->limit(1, 3);
$success = $newDb->execute();
while($row = $success->fetch_array()){
    print_r($row);
}
