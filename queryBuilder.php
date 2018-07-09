<?php

class queryBuilder{

    public static function selectBd($s){

        $mysqli = new mysqli("localhost", "mysql", "mysql", $s);
        $mysqli->query("SET NAMES 'utf8'");
    }

    public static function closeBd($mysqli){
        $mysqli->close();
    }

    public static function addRecord($mysqli, $what='*', $where){
        $mysqli->query("SELECT * FROM `Users` WHERE nickname = '$nickname' AND password = MD5('$password')");
    }



}