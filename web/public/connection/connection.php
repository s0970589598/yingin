<?php
//echo __FILE__;
# FileName="Connection_php_mysql.htm"

# Type="MYSQL"

# HTTP="true"

//mysql
//$hostname= "localhost"; //主機名稱，一般都設定「localhost」當地主機
//$database= "sports"; //資料庫名稱
//$username= "root"; //資料庫登入帳號
//$password= "1234"; //資料庫登入密碼碼
//
//
//$database_link = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
////開啟MySQL伺服器連結，mysql_connect()函式依序是放入剛剛設定的變數$hostname, $username, $password，後面的trigger_error()函式是可當資料庫連結發生問題可以回傳錯誤訊息
//
//mysql_query("set names utf8"); //使用mysql_query()函式送出一個字串到資料庫，將資料庫設定為utf8編碼，防止中文亂碼產生
//
//mysql_select_db($database, $database_link);






ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
$hostname= "mysql"; //主機名稱，一般都設定「localhost」當地主機
$database= "yingin"; //資料庫名稱
$username= "root"; //資料庫登入帳號
$password= "root"; //資料庫登入密碼碼

//$hostname= "localhost"; //主機名稱，一般都設定「localhost」當地主機
//$database= "sports"; //資料庫名稱
//$username= "daniel"; //資料庫登入帳號
//$password= "danieldaniel"; //資料庫登入密碼碼

$database_link = mysqli_connect($hostname, $username, $password) or die('Error with MySQL connection');
//$database_link = mysql_connect($hostname, $username, $password,true) or trigger_error(mysql_error(),E_USER_ERROR);
//開啟MySQL伺服器連結，mysql_connect()函式依序是放入剛剛設定的變數$hostname, $username, $password，後面的trigger_error()函式是可當資料庫連結發生問題可以回傳錯誤訊息
mysqli_query($database_link,"set names utf8"); //使用mysql_query()函式送出一個字串到資料庫，將資料庫設定為utf8編碼，防止中文亂碼產生
//mysqli_select_db( $database_link,$database);


mysqli_select_db($database_link, $database) or die ("no database");



?>