<?php
include_once "config.php";
include_once "queryBuilder.php";

$newDb = new queryBuilder($config);
$columns = ["*"];
$where = [
    "nickname" => ['=', "'sddsfdsf'"],
    "password" => ['=', 123]
];

$cases = ["and"];

$success = $newDb->select($columns)->from("Users")->where($where, $cases);
$success = $newDb->execute();

while ($row = $success->fetch_array()) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
}
