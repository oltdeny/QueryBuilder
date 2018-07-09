<?php

class queryBuilder{
    public static $select;
    public static $from;
    public static $table;
    public static $insert;
    public static $limit;
    public static $update;
    public static $delete;


    function __construct($config){
        $mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
        $mysqli->query("SET NAMES 'utf8'");
    }

    public static function dbClose($mysqli){
        $mysqli->close();
    }

    public static function select($columns){
        self::$select = "SELECT ";
        foreach ($columns as $key => $column) {
            if ($key < count($columns)-1){
                self::$select .= $column . ',';
                continue;
            }
            self::$select .= $column;
        }
    }

    public static function from($table){
        self::$from = "FROM ".$table;
    }

    public static function insert($table, $columns){
        self::$insert = "INSERT INTO ".$table;
        $keys = "(";
        foreach ($columns as $key => $column) {
            if ($key < count($columns)-1){
                $keys .= $key. ',';
                continue;
            }
            $keys .= $key.")";
        }
        self::$insert .= "VALUES";
        $values = "(";
        foreach ($columns as $key => $column) {
            if ($key < count($columns)-1){
                $values .= $column . ',';
                continue;
            }
            $values .= $column.")";
        }
    }



}