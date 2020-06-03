<?php
require 'connection.php';
class tenOfthousands extends SqlTool {

    protected $database_link;
    protected $conn;
    protected $name;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->conn = new SqlTool;
    }

    public function fire($num)
    {
        $num = trim($num);
        $len = strlen($num);
        $evenOrOdd = ($len % 2 == 0 ? 'even_num' : 'odd_num');
        $odd = (int) ($len / 2) + 1;
        $even = ($len == 1 ? $odd : floor(($len / 2)));
        $iss_odd = ($len == 1 ? 10 : substr($num, 0, $odd));

        $before_num = ($evenOrOdd == 'odd_num' ? $iss_odd : substr($num, 0, $even));
        $is_before_num_zero = substr($before_num, 0, 1);
        $is_before_num_zero == 0 ? $before_num = '1' . $before_num : $before_num = $before_num;

        $after_num = (int) substr($num, - ($even)) == 0 ? pow(10, $even) : substr($num, - $even);
        //$is_after_num_zero = substr($after_num,0,1);
        //$is_after_num_zero == 0 ? $after_num = '1' . $after_num : $after_num = $after_num;

        $sum_num = $before_num + $after_num;

        $up_gua = ($after_num % 8 == 0 ? 8 : $after_num % 8);
        $down_gua =  ($before_num % 8 == 0 ? 8 : $before_num % 8);
        $variety_gua =  ($sum_num % 6 == 0 ? 6 : $sum_num % 6);
        $gua = $up_gua . $down_gua . $variety_gua;

        $numfate = array(
            'gua' => self::getArticle192($gua),
            'tear_down' => array(
                'num' => $num,
                'len' => $len,
                'evenOrOdd' => $evenOrOdd,
                'odd' => $odd,
                'even' => $even,
                'before_num' => $before_num,
                'is_before_num_zero' => $is_before_num_zero,
                'after_num' => $after_num,
                'sum_num' => $sum_num,
                'up_gua' => $up_gua,
                'down_gua' => $down_gua,
                'variety_gua' => $variety_gua,
                'gua' => $gua
            ),
        );

        return $numfate;
    }

    public function getArticle192($num)
    {
        $sql = "SELECT * FROM `yingin192`  WHERE thousand_num ='$num'";
        $result = $this->conn->execute_dql($sql);
        $row = mysqli_fetch_assoc($result);

        $article = array(
            'yingin192_id' => $row['yingin192_id'],
            'goodorbad' => $row['goodorbad'],
            'mean' => $row['mean'],
            'point' => $row['point'],
            'thousand_num' => $row['thousand_num'],
        );

        return   $article;
    }

}