<?php

class queryBuilder
{
    public static $mysqli;
    public static $select;
    public static $from;
    public static $where;
    public static $insert;
    public static $into;
    public static $values;
    public static $limit;
    public static $between;
    public static $in;
    public static $update;
    public static $delete;
    public static $orderBy;

    function __construct($config)
    {
        self::$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
        self::$mysqli->query("SET NAMES 'utf8'");
    }

    public function dbClose()
    {
        self::$mysqli->close();
    }

    public function select($columns)
    {
        if (is_array($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    return "Wrong type of data. Required string.";
                }
            }
            self::$select = "SELECT " . implode(",", $columns);
        } elseif (is_string($columns)) {
            if ($columns == "*") {
                self::$select = "SELECT * ";
            } else {
                return "Not allowed data for string.";
            }
        } else {
            return "Wrong type of data.";
        }
        return $this;
    }

    public function from($table)
    {
        if (!is_string($table)) {
            return "Wrong type of data. Required string.";
        }
        self::$from = " FROM " . $table;
        return $this;
    }

    public function where($conditions, $cases)
    {
        if (!(is_array($conditions) && (is_array($cases) || is_string($cases)))) {
            return "Wrong type of data. Required array.";
        }
        self::$where = " WHERE ";
        $i = 0;
        foreach ($conditions as $key => $condition){
            self::$where .= $key.$condition[0].$condition[1]." ".$cases[$i]." ";
            $i++;
        }
        return $this;
    }

    public function between($val1, $val2)
    {
        if (!(is_int($val1) && is_int($val2))) {
            return "Wrong type of data. Required integer.";
        }
        self::$where .= " BETWEEN $val1 AND $val2";
        return $this;
    }

    public function in($values)
    {
        if (is_array($values)) {
            foreach ($values as $value) {
                if (!is_string($value)) {
                    return "Wrong type of data. Required string.";
                }
            }
            self::$where = "IN (" . implode(",", $values) . ")";
        } elseif (is_string($values)) {
            self::$where = "IN ('$values')";
        }
        return $this;
    }

    public function orderBy($order)
    {
        if (!is_string($order)) {
            return "Wrong type of data. Required string.";
        }
        if ($order == "DESC") {
            self::$orderBy = "ORDER BY " . $order;
        }
        if ($order == "ASC") {
            self::$orderBy = "ORDER BY " . $order;
        }
        return $this;
    }

    public function limit($first = 1, $second)
    {
        if (!(is_int($first) && is_int($second))) {
            return "Wrong type of data. Required integer.";
        }
        self::$limit = " LIMIT " . $first . ", " . $second;
        return $this;
    }

    public function insert($table, $columns)
    {
        if (is_string($table) && is_array($columns)) {
            self::$insert = "INSERT INTO " . $table;
            $keys = " (" . implode(",", array_keys($columns)) . ") ";
            self::$insert .= $keys . "VALUES ";
            $values = " (" . implode(",", $columns) . ")";
            self::$insert .= $values;
            return self::$insert;
        } else {
            return "Wrong type of data. Required parameters: string, array";
        }
    }

    public function update($table, $columns, $id)
    {
        if (is_string($table) && is_array($columns) && is_int($id)) {
            self::$update = "UPDATE " . $table . " SET ";
            $values = "";
            $i = 0;
            foreach ($columns as $key => $column) {
                if ($i < count($columns) - 1) {
                    $i++;
                    $values .= $key . '=' . $column . ",";
                    continue;
                }
                $values .= $key . '=' . $column;
            }
            self::$update .= $values . " WHERE " . $table . ".`id` = " . $id;
            return self::$update;
        } else {
            return "Wrong type of data. Required parameters: string, array, integer";
        }
    }

    public function delete($table, $id)
    {
        if (gettype($table) == "string" && gettype($id) == "integer") {
            $delete = "DELETE FROM " . $table;
            $delete .= " WHERE `id` = " . $id;
            return self::$mysqli->query($delete);
        } else {
            return "Wrong type of data. Required parameters: string, integer";
        }
    }

    public function createSQL()
    {
        $query = "";
        if (isset(self::$select)) {
            $query = self::$select . self::$from . self::$where . self::$orderBy . self::$limit;
        } elseif (isset(self::$insert)) {
            $query = self::$insert;
        } elseif (isset(self::$update)) {
            $query = self::$update;
        } elseif (isset(self::$delete)) {
            $query = self::$delete;
        }
        return $query;
    }

    public function execute()
    {
        $query = $this->createSQL();
        return self::$mysqli->query($query);
    }
}