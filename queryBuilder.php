<?php

class queryBuilder{
    public static $mysqli;
    public static $select;
    public static $from;
    public static $where;
    public static $insert;
    public static $limit;
    public static $update;
    public static $delete;
    public static $orderByDesc;
    public static $orderByAsc;

    function __construct($config){
        self::$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
        self::$mysqli->query("SET NAMES 'utf8'");
    }

    public function dbClose(){
        self::$mysqli->close();
    }

    public function select($columns){
        if(gettype($columns) != "array"){
            return false;
        }
        self::$select = "SELECT ".implode(",", $columns);

    }
    public function from($table){
        if(gettype($table) != "string"){
            return false;
        }
        self::$from = "FROM ".$table;
    }
    /**
     * $cases - ассоциативный массив
     */
    public function where($cases){
        if(gettype($cases) != "array"){
            return false;
        }
        self::$where = "WHERE ";
        foreach ($cases as $key => $case) {
            if ($key < count($cases)-1){
                self::$where .= $key.'='.$case.",";
                continue;
            }
            self::$where .= $key.'='.$case;
        }
    }

    public function execute(){
        $query = self::$select.self::$from.self::$where;
        return self::$mysqli->query($query);
    }

    public function insert($table, $columns){
        if(gettype($table) == "string" && gettype($columns) == "array"){
            $insert = "INSERT INTO ".$table;
            $keys = "(";
            foreach ($columns as $key => $column) {
                if ($key < count($columns)-1){
                    $keys .= $key. ',';
                    continue;
                }
                $keys .= $key.")";
            }
            $insert .= $keys."VALUES";
            $values = "(";
            foreach ($columns as $key => $column) {
                if ($key < count($columns)-1){
                    $values .= $column . ',';
                    continue;
                }
                $values .= $column.")";
            }
            $insert .= $values;
            return self::$mysqli->query($insert);
        }
        else{
            return false;
        }
    }

    public function update($table, $columns, $id){
        if(gettype($table) == "string" && gettype($columns) == "array" && gettype($id) == "integer"){
            $update = "UPDATE ".$table." SET ";
            $values = "";
            foreach ($columns as $key => $column) {
                if ($key < count($columns)-1){
                    $values .= $key . '=' . $column . ",";
                    continue;
                }
                $values .= $key . '=' . $column;
            }
            $update .= $values." WHERE ".$table.".`id` = ".$id;
            return self::$mysqli->query($update);
        }
        else{
            return false;
        }

    }



}