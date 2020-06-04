<?php

    class SqlTool {
        //属性
        private $conn;
        private $host="mysql";
        private $user="root";
        private $password="root";
        private $db="yingin";

        function SqlTool(){
            $this->conn=MySQLi_connect($this->host,$this->user,$this->password);
            if(!$this->conn){
                die("连接数据库失败".MySQLi_error());
            }
            MySQLi_select_db($this->conn,$this->db);
            MySQLi_query($this->conn,"set names utf8");//设置字符集
        }
        //方法..

        // 完成select dql
        public  function execute_dql($sql){

            $res=MySQLi_query($this->conn,$sql) or die(MySQLi_error());
            return $res;

        }


        //完成 update,delete ,insert dml
        public  function execute_dml($sql){

            $b=MySQLi_query($this->conn,$sql);
            //echo "添加的id=".MySQLi_insert_id($this->conn);
            if(!$b){
                return 0;//失败
            }else{
                if(MySQLi_affected_rows($this->conn)>0){
                    return 1;//表示成功
                }else{
                    return 2;//表示没有行数影响.
                }
            }
        }
    }

?>