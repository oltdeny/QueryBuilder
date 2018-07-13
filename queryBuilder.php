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
    public static $orderBy;

    function __construct($config){
        self::$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
        self::$mysqli->query("SET NAMES 'utf8'");
    }

    public function dbClose(){
        self::$mysqli->close();
    }

    public function select($columns){
        if(gettype($columns) == "array"){
            self::$select = "SELECT ".implode(",", $columns);
        }
        elseif (gettype($columns) == "string"){
            if($columns == "*"){
                self::$select = "SELECT * ";
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function from($table){
        if(gettype($table) != "string"){
            return false;
        }
        self::$from = " FROM ".$table;
    }
    /**
     * $cases - ассоциативный массив
     */
    public function where($cases){
        if(gettype($cases) != "array"){
            return false;
        }
        self::$where = " WHERE ";
        foreach ($cases as $key => $case) {
            if ($key < count($cases)-1){
                self::$where .= $key.'='.$case.",";
                continue;
            }
            self::$where .= $key.'='.$case;
        }
    }

    public function orderBy($order){
        if(gettype($order) != "string"){
            return false;
        }
        if($order == "DESC"){
            self::$orderBy = "ORDER BY ".$order;
        }
        if($order == "ASC"){
            self::$orderBy = "ORDER BY ".$order;
        }
    }

    public function limit($first = 1, $second){
        self::$limit = " LIMIT ".$first.", ".$second;
    }

    public function execute(){
        $query = self::$select.self::$from.self::$where.self::$orderBy.self::$limit;
        return self::$mysqli->query($query);
    }

    public function insert($table, $columns){
        if(gettype($table) == "string" && gettype($columns) == "array"){
            $insert = "INSERT INTO ".$table;
            $keys = " (".implode(",", array_keys($columns)).") ";
            $insert .= $keys."VALUES ";
            $values = " (".implode(",", $columns).")";
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
            $i = 0;
            foreach ($columns as $key => $column) {
                if ($i < count($columns)-1){
                    $i++;
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

    public function delete($table, $id){
        if(gettype($table) == "string" && gettype($id) == "integer"){
            $delete = "DELETE FROM ".$table;
            $delete .= " WHERE `id` = ".$id;
            return self::$mysqli->query($delete);
        }
        else{
            return false;
        }
    }
}