<?php
include_once "config.php";
include_once "queryBuilder.php";

$newDb = new queryBuilder($config);
$columns = ["*"];
$where = [
    "id" => 30,
    "nickname" => 'admin2'
];
$success = $newDb->select($columns)->from("Users")->where($where, "and");
$success = $newDb->execute();

while ($row = $success->fetch_array()) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
}
