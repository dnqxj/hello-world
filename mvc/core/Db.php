<?php

/**
 * 数据库访问类
 */
class Db
{
    private static function db_connect(){
        require 'config/database.php';
        //创建连接
        $conn = mysqli_connect($db['db_host'], $db['db_user'], $db['db_password'], $db['db_name']);
        if(!$conn){
            exit('Connection failed: '.mysqli_connect_error());
        }
        return $conn;
    }

    //获取一条记录
    public static function item($table, $where=array())
    {
        $conn = self::db_connect();
        $rows = false;
        $sql = "SELECT * FROM {$table} ";
        if($where){
            $sql .= 'where '.self::getwhere($where);
        }
        $sql .= ' LIMIT 1';
        if($result = mysqli_query($conn, $sql)){
            while($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_close($conn);
        if(!$rows){
            return $rows;
        }
        return $rows[0];
    }

    //查询列表
    public static function lists($table, $where, $order=''){
        $conn = self::db_connect();
        $rows = false;
        $sql = "SELECT * FROM {$table} ";
        if($where){
            $sql .= " where ".self::getwhere($where);
        }
        if($order){
            $sql .= " ORDER BY {$order}";
        }
        if($result = mysqli_query($conn, $sql)){
            while($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_close($conn);
        if(!rows){
            return $rows;
        }
        return $rows;
    }

    //自定义索引
    public static function cates($table,$where,$index,$order){
        $lists = self::lists($table,$where,$order);
        if(!$lists){
            return false;
        }
        $result = array();
        foreach ($lists as $key=>$value) {
            $result[$value[$index]] = $value;
        }
    }

    //总数
    public static function totals($table, $where){
        $conn = self::db_connect();
        //查询记录的条数
        $sql = "SELECT COUNT(*) AS count FROM {$table} ";
        if($where){
           $sql .= " WHERE ".self::getwhere($where);
        }
        $count  = 0;
        if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];
        }
        mysqli_close($conn);
        return $count;
    }

    //添加数据
    public static function insert($table, $data){
        $conn = self::db_connect();
        $fields = $values = [];
        $data['username'] = 'yanglang';
        $data['password'] = 'dasfdsjaf';

        foreach ($data as $key=>$item) {
            $item = str_replace("'", '&apos', $item); //处理单引号;防止sql攻击
            $item = str_replace('"', '&quot', $item); //处理双引号
            $fields[] = "`".$key."`";
            $values[] = "'".$item."'";
        }
        $sql = "INSERT INTO {$table} (".implode(',', $fields).") VALUES (".implode(',', $values).")";
        $insert_id = 0;
        if(mysqli_query($conn, $sql)){
            $insert_id = mysqli_insert_id($conn);
        }
        mysqli_close($conn);
        return $insert_id;
    }

    //分页

    /**
     * @param $table
     * @param $where
     * @param $page
     * @param $num
     * @param string $order
     */
    public static function pagination($table, $where, $page, $num, $order = ''){
        $conn = self::db_connect();
        $count = self::totals($table, $where);
        //计算总页数
        $total_page = ceil($count/$num);
        //处理$page
        $page = max(1, $page);
        //每页的起始数
        $offset = ($page - 1)*$num;
        //拼接查询数据的SQL语句
        $sql = "SELECT * FROM {$table}";
        if($where){
            $sql .= ' WHERE '.self::getwhere($where);
        }

        if($order){
            $sql .= ' ORDER BY {$order} ';
        }

        $sql .= ' LIMIT '.$offset.','.$num;
        $rows = [];
        if($result = mysqli_query($conn,$sql)){
            while($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_close($conn);
        return array('total'=>$count, 'lists'=>$rows);
    }

    //处理where条件
    private static function getwhere($params=array()){
        $_where = '';
        if(!$params){
            return $_where;
        }
        foreach ($params as $key=>$value){
            $value = gettype($value)=='string'?"'".$value."'":$value;
            if($value){
                $_where .= $key.'='.$value.' AND ';
            }else{
                $_where .= $key.' AND ';
            }
        }
        return rtrim($_where, 'AND ');
    }
}

//链式操作
class Sysdb
{
    public function table($table){
        $this->table = $table;
        //查询后重置属性值
        $this->where = array();
        $this->fields = "*";
        return $this;
    }

    public function where($where){
        $this->where = $where;
        return $this;
    }

    public function fields($fields){
        $this->fields = $fields;
    }

    public function item(){
        $item = Db::item($this->table,$this->where);
        return $item;
    }
}