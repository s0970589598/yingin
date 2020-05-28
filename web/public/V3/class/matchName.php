<?php

require 'connection.php';

class matchName extends SqlTool
{
    protected $database_link;
    protected $conn;
    protected $name;
    protected $name_count;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->conn = new SqlTool;
    }

    public function fire($first_num, $name_count)
    {
        $first = self::getCompositeNum($first_num, $name_count);
        $sec = self::getCompositeNum2($first);
        $total = self::getTotalNum($sec);

        return json_encode($total);
    }

    public function getCompositeNum($first_num)
    {
        $key = 0;
        for ($j = 1; $j <= 32; $j++) {
            $num = (int)$first_num + $j;
            $string = (string)$num;
            $num = str_pad($string,4,'0',STR_PAD_LEFT);
            $article = self::getArticle($num);

            if (self::getGoodOrBad($article['goodorbad'])) {
                $matching_num = self::getMatchingNum($first_num, $j);
                if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                    $composite_num[$key]['first_num'] = $first_num;
                    $composite_num[$key]['sec_num'] = $j;
                    $composite_num[$key]['chain_sum']['num'] = $num;
                    $composite_num[$key]['chain_sum']['article'] = $article;
                    $composite_num[$key]['matching'] = $matching_num;
                    $key += 1;
                }
            }
        }
        return $composite_num;
    }

    public function getMatchingNum($first_num, $sec_num)
    {
        if ($first_num < 10 && $sec_num < 10) {
            $string = (string)$first_num . (string)$sec_num;
            $matching_num = str_pad($string,4,'0',STR_PAD_LEFT);
            $article = self::getArticle($matching_num);
        } else {
            if ($first_num < 10) {
                $first_num = (int)$first_num + 24;
            }
            if ($sec_num < 10) {
                $sec_num = str_pad((string)$sec_num, 2, '0',STR_PAD_LEFT);
            }
            $matching_num = (string)$first_num . (string)$sec_num;
            $article = self::getArticle($matching_num);
        }

        $matching['num'] = $matching_num;
        $matching['article'] = $article;

        return $matching;
    }

    public function getCompositeNum2($first)
    {
        $key = 0;
        for ($i = 0; $i < count($first); $i++) {
            $sec_num = $first[$i]['sec_num'];
            for ($j = 1; $j <= 32; $j++) {
                $num = (int)$sec_num + $j;
                $string = (string)$num;
                $num = str_pad($string, 4, '0', STR_PAD_LEFT);
                $article = self::getArticle($num);

                if (self::getGoodOrBad($article['goodorbad'])) {
                    $matching_num = self::getMatchingNum($sec_num, $j);
                    if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                        $composite_num2[$key]['first_num'] = $first[$i]['first_num'];
                        $composite_num2[$key]['sec_num'] = $sec_num;
                        $composite_num2[$key]['thir_num'] = $j;
                        $composite_num2[$key]['chain_sum'][0]= $first[$i]['chain_sum'];
                        $composite_num2[$key]['matching'][0] = $first[$i]['matching'];
                        $composite_num2[$key]['chain_sum'][1]['num'] = $num;
                        $composite_num2[$key]['chain_sum'][1]['article'] = $article;
                        $composite_num2[$key]['matching'][1] = $matching_num;
                        $key += 1;
                    }
                }
            }
        }
        return $composite_num2;
    }

    public function getTotalNum($sec)
    {
        $total = count($sec);
        $key = 0;
        for ($l = 0; $l <= $total; $l++) {
            $total_num['num'] = (int)$sec[$l]['first_num'] + $sec[$l]['sec_num'] + $sec[$l]['thir_num'];
            $string = (string)$total_num['num'];
            $total_num['num'] = str_pad($string, 4, '0', STR_PAD_LEFT);
            $total_num['article'] = self::getArticle($total_num['num']);

            if (self::getTotalGoodOrBad($total_num['article']['goodorbad'])) {
                $composite_num2[$key]['first_num'] = $sec[$l]['first_num'];
                $composite_num2[$key]['sec_num'] = $sec[$l]['sec_num'];
                $composite_num2[$key]['thir_num'] = $sec[$l]['thir_num'];
                $composite_num2[$key]['chain_sum']= $sec[$l]['chain_sum'];
                $composite_num2[$key]['matching'] = $sec[$l]['matching'];
                $composite_num2[$key]['total'] = $total_num;
                $composite_num2[$key]['score'] = self::getNameScroe($composite_num2[$key]['chain_sum'][0]['article']['goodorbad']) + self::getNameScroe($composite_num2[$key]['matching'][0]['article']['goodorbad']) + self::getNameScroe($composite_num2[$key]['chain_sum'][1]['article']['goodorbad']) + self::getNameScroe($composite_num2[$key]['matching'][1]['article']['goodorbad']) + self::getNameScroe($composite_num2[$key]['total']['article']['goodorbad']);
                $key += 1;
            }
        }
        return $composite_num2;
    }

    public function getGoodOrBad($goodorbad)
    {
        if ($goodorbad == '上上' || $goodorbad == '上中' || $goodorbad == '中中' || $goodorbad == '中平') {
    		return true;
        } else {
            return false;
        }
    }

    public function getTotalGoodOrBad($goodorbad)
    {
        if ($goodorbad == '上上' || $goodorbad == '上中') {
    		return true;
        } else {
            return false;
        }
    }

    public function getStrokes($string)
    {
        $sql = "SELECT * FROM `kangxi`  WHERE word ='$string' ";
        $result = $this->conn->execute_dql($sql);
        $row = mysqli_fetch_assoc($result);
        return   $row['num'];
    }

    public function getArticle($num)
    {
        $sql = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id  WHERE yingin10000_num ='$num'";
        $result = $this->conn->execute_dql($sql);
        $row = mysqli_fetch_assoc($result);

        $article = array(
            'yingin10000_num' => $row['yingin10000_num'],
            'goodorbad' => $row['goodorbad'],
            'mean' => $row['mean'],
            'thousand_num' => $row['thousand_num'],
        );

        return   $article;
    }

    public function getNameScroe($goodorbad) {
        switch ($goodorbad) {
            case '上上':
                $score = 20;
                break;
            case '上中':
                $score = 15;
                break;
            case '中中':
                $score = 10;
                break;
            case '中平':
                $score = 10;
                break;
            case '中下':
                $score = 5;
                break;
            case '下中':
                $score = 5;
                break;
            default:
                $score = 0;
                break;
        }
        return $score;
    }
}

