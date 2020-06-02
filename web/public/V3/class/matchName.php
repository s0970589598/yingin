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
        $first_num = trim($first_num);
        $name_count = trim($name_count);

        switch ($name_count) {
            case 2 :
                $nameing = self::getCompositeNum($first_num, $name_count);
            break;
            case 3 :
                $first = self::getCompositeNum($first_num, $name_count);
                $nameing = self::getCompositeNum2($first);
            break;
            case 4 :
                $first = self::getCompositeNum($first_num, $name_count);
                $sec = self::getCompositeNum2($first);
                $nameing = self::getCompositeNum3($sec);
            break;
            case 5 :
                $first = self::getCompositeNum($first_num, $name_count);
                $sec = self::getCompositeNum2($first);
                $third = self::getCompositeNum3($sec);
                $nameing = self::getCompositeNum4($third);
            break;
        }

        $total = self::getTotalNum($nameing, $name_count);

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
                    $composite_num[$key][0] = $first_num;
                    $composite_num[$key][1] = $j;
                    $composite_num[$key]['chain_sum'][0]['num'] = $num;
                    $composite_num[$key]['chain_sum'][0]['article'] = $article;
                    $composite_num[$key]['matching'][0] = $matching_num;
                    $key += 1;
                }
            }
        }
        return $composite_num;
    }

    public function getCompositeNum2($sec)
    {
        $key = 0;
        for ($i = 0; $i < count($sec); $i++) {
            $sec_num = $sec[$i][1];
            for ($j = 1; $j <= 32; $j++) {
                $num = (int)$sec_num + $j;
                $string = (string)$num;
                $num = str_pad($string, 4, '0', STR_PAD_LEFT);
                $article = self::getArticle($num);

                if (self::getGoodOrBad($article['goodorbad'])) {
                    $matching_num = self::getMatchingNum($sec_num, $j);
                    if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                        $composite_num2[$key][0] = $sec[$i][0];
                        $composite_num2[$key][1] = $sec[$i][1];
                        $composite_num2[$key][2] = $j;
                        $composite_num2[$key]['chain_sum'][0]= $sec[$i]['chain_sum'][0];
                        $composite_num2[$key]['matching'][0] = $sec[$i]['matching'][0];
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

    public function getCompositeNum3($third)
    {
        $key = 0;
        for ($i = 0; $i < count($third); $i++) {
            $sec_num = $third[$i][2];
            for ($j = 1; $j <= 32; $j++) {
                $num = (int)$sec_num + $j;
                $string = (string)$num;
                $num = str_pad($string, 4, '0', STR_PAD_LEFT);
                $article = self::getArticle($num);

                if (self::getGoodOrBad($article['goodorbad'])) {
                    $matching_num = self::getMatchingNum($sec_num, $j);
                    if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                        $composite_num2[$key][0] = $third[$i][0];
                        $composite_num2[$key][1] = $third[$i][1];
                        $composite_num2[$key][2] = $third[$i][2];
                        $composite_num2[$key][3] = $j;
                        $composite_num2[$key]['chain_sum']= $third[$i]['chain_sum'];
                        $composite_num2[$key]['matching']= $third[$i]['matching'];
                        $composite_num2[$key]['chain_sum'][2]['num'] = $num;
                        $composite_num2[$key]['chain_sum'][2]['article'] = $article;
                        $composite_num2[$key]['matching'][2] = $matching_num;
                        $key += 1;
                    }
                }
            }
        }
        return $composite_num2;
    }

    public function getCompositeNum4($four)
    {
        $key = 0;
        for ($i = 0; $i < count($four); $i++) {
            $sec_num = $four[$i][3];
            for ($j = 1; $j <= 32; $j++) {
                $num = (int)$sec_num + $j;
                $string = (string)$num;
                $num = str_pad($string, 4, '0', STR_PAD_LEFT);
                $article = self::getArticle($num);

                if (self::getGoodOrBad($article['goodorbad'])) {
                    $matching_num = self::getMatchingNum($sec_num, $j);
                    if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                        $composite_num2[$key][0] = $four[$i][0];
                        $composite_num2[$key][1] = $four[$i][1];
                        $composite_num2[$key][2] = $four[$i][2];
                        $composite_num2[$key][3] = $four[$i][3];
                        $composite_num2[$key][4] = $j;
                        $composite_num2[$key]['chain_sum'] = $four[$i]['chain_sum'];
                        $composite_num2[$key]['matching'] = $four[$i]['matching'];
                        $composite_num2[$key]['chain_sum'][3]['num'] = $num;
                        $composite_num2[$key]['chain_sum'][3]['article'] = $article;
                        $composite_num2[$key]['matching'][3] = $matching_num;
                        $key += 1;
                    }
                }
            }
        }
        return $composite_num2;
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

    public function getTotalNum($sec, $name_count)
    {

        $total = count($sec);
        $key = 0;

        for ($l = 0; $l < $total; $l++) {
            for ($m = 0; $m < $name_count; $m++) {
                $total_num[$l]['num'] += (int)$sec[$l][$m];
            }

            $string = (string)$total_num[$l]['num'];
            $total_n[$l]['num'] = str_pad($string, 4, '0', STR_PAD_LEFT);
            $total_n[$l]['article'] = self::getArticle($total_n[$l]['num']);

            if (self::getTotalGoodOrBad($total_n[$l]['article']['goodorbad'])) {
                for ($o = 0; $o < $name_count; $o++) {
                    $composite_num2[$key]['num'][$o] = $sec[$l][$o];
                }
                $composite_num2[$key]['chain_sum']= $sec[$l]['chain_sum'];
                $composite_num2[$key]['matching'] = $sec[$l]['matching'];
                $composite_num2[$key]['total'] = $total_n[$l];
                for ($p = 0; $p < count($composite_num2[$key]['chain_sum']); $p++) {
                    $composite_num2[$key]['score'] += (self::getNameScroe($composite_num2[$key]['chain_sum'][$p]['article']['goodorbad'], $name_count) + self::getNameScroe($composite_num2[$key]['matching'][$p]['article']['goodorbad'], $name_count));
                }
                $composite_num2[$key]['score'] += self::getNameScroe($composite_num2[$key]['total']['article']['goodorbad'], $name_count);

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

    public function getNameScroe($goodorbad, $name_count) {
        switch ($goodorbad) {
            case '上上':
                $score = round(100 / ($name_count + ($name_count - 1)));
                break;
            case '上中':
                $score = round(100 / ($name_count + ($name_count - 1))) - 5;
                break;
            case '中中':
                $score = round(100 / ($name_count + ($name_count - 1))) - 10;
                break;
            case '中平':
                $score = round(100 / ($name_count + ($name_count - 1))) - 10;
                break;
            case '中下':
                $score = round(100 / ($name_count + ($name_count - 1))) - 15;
                break;
            case '下中':
                $score = round(100 / ($name_count + ($name_count - 1))) - 15;
                break;
            default:
                $score = 0;
                break;
        }
        return $score;
    }
}

