<?php

require 'connection.php';

class matchCoName extends SqlTool
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

        $name_c = mb_strlen(trim($first_num));
        for ($i = 0; $i < $name_c; $i++) {
            $kind_co[$i]['name'] = mb_substr($first_num, $i, 1,"utf-8");
            $kind_co[$i]['strokes'] = self::getStrokes($kind_co[$i]['name']);
            $fir_num += $kind_co[$i]['strokes'];
            $nameing['kind_co'] = $kind_co;
        }

        switch ($name_count) {
            case 2 :
                $big_total_num = self::getBigTotal($fir_num, $name_count);
                $nameing['nameing'] = self::getCompositeNum($big_total_num, $name_count);
            break;
            case 3 :
                $big_total_num = self::getBigTotal($fir_num, $name_count);
                $first = self::getCompositeNum($big_total_num, $name_count);
                $nameing['nameing']  = self::getCompositeNum2($first, $name_count);
            break;
            case 4 :
                $big_total_num = self::getBigTotal($fir_num, $name_count);
                $first = self::getCompositeNum($big_total_num, $name_count);
                $sec = self::getCompositeNum2($first, $name_count);
                $nameing['nameing']  = self::getCompositeNum3($sec, $name_count);
            break;
            case 5 :
                $big_total_num = self::getBigTotal($fir_num, $name_count);
                $first = self::getCompositeNum($big_total_num, $name_count);
                $sec = self::getCompositeNum2($first, $name_count);
                $third = self::getCompositeNum3($sec, $name_count);
                $nameing['nameing']  = self::getCompositeNum4($third, $name_count);
            break;
        }
        return json_encode($nameing);
    }

    public function getBigTotal($first_num, $name_count)
    {
        $key = 0;
        for ($j = 1; $j <= (32 * $name_count); $j++) {

            $num = (int)$first_num + $j;
            if($j > $num) {
                break;
            }
            $string = (string)$num;
            $num = str_pad($string,4,'0',STR_PAD_LEFT);
            $article = self::getArticle($num);

            if (self::getTotalGoodOrBad($article['goodorbad'])) {
                $total_n[$j]['article'] = self::getArticle(str_pad((string)$j, 4, '0', STR_PAD_LEFT));
                if (self::getTotalGoodOrBad($total_n[$j]['article']['goodorbad'])) {
                    $composite_num[$key]['kind_num'] = $first_num;
                    $composite_num[$key]['small_num'] = $j;
                    $composite_num[$key]['big_total_num']['num'] = $num;
                    $composite_num[$key]['big_total_num']['article'] = $article;
                    $composite_num[$key]['total_num']['num'] = str_pad((string)$j, 4, '0', STR_PAD_LEFT);
                    $composite_num[$key]['total_num']['article'] = $total_n[$j]['article'];
                    // $composite_num[$key]['matching'] = $matching_num;
                    $key += 1;
                }
            }
        }
        return $composite_num;
    }

    public function getCompositeNum($total_num, $num_count)
    {
        $key = 0;

        for ($i = 0; $i < count($total_num); $i++) {
            for ($j = 1; $j < round($total_num[$i]['total_num']['num'] / ($num_count - 1)); $j++) {
                $first_num = abs(round($total_num[$i]['total_num']['num']/ ($num_count - 1)) - $j);

                $num = (int)$first_num + $j;
                $string = (string)$num;
                $num = str_pad($string,4,'0',STR_PAD_LEFT);
                $article = self::getArticle($num);

                if (self::getGoodOrBad($article['goodorbad'])) {
                    $matching_num = self::getMatchingNum($first_num, $j);
                    if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                        $composite_num[$key]['num'][0] = $first_num;
                        $composite_num[$key]['num'][1] = $j;
                        $composite_num[$key]['chain_sum'][0]['num'] = $num;
                        $composite_num[$key]['chain_sum'][0]['article'] = $article;
                        $composite_num[$key]['matching'][0] = $matching_num;
                        $composite_num[$key]['total'] = $total_num[$i];
                        $key += 1;
                    }
                }
            }
        }

        return $composite_num;
    }

    public function getCompositeNum2($sec, $num_count)
    {
        $key = 0;
        for ($i = 0; $i < count($sec); $i++) {
            $fir_num = $sec[$i]['num'][0];
            $sec_num = $sec[$i]['num'][1];
            $total = $sec[$i]['total']['small_num'];
            $part_total = round($sec[$i]['total']['small_num'] / ($num_count - 2));

            $thir_num = $part_total - $fir_num - $sec_num;

                $num = $total - $fir_num;
                $string = (string)$num ;
                $num = str_pad($string, 4, '0', STR_PAD_LEFT);
                $article = self::getArticle($num);

                if (self::getGoodOrBad($article['goodorbad'])) {
                    $matching_num = self::getMatchingNum($sec_num, $thir_num);
                    if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                        $composite_num2[$key]['num'][0] = $sec[$i]['num'][0];
                        $composite_num2[$key]['num'][1] = $sec[$i]['num'][1];
                        $composite_num2[$key]['num'][2] = $thir_num;
                        $composite_num2[$key]['chain_sum'][0]= $sec[$i]['chain_sum'][0];
                        $composite_num2[$key]['matching'][0] = $sec[$i]['matching'][0];
                        $composite_num2[$key]['chain_sum'][1]['num'] = $num;
                        $composite_num2[$key]['chain_sum'][1]['article'] = $article;
                        $composite_num2[$key]['matching'][1] = $matching_num;
                        $composite_num2[$key]['total'] = $sec[$i]['total'];
                        $key += 1;
                    }
                }
        }
        return $composite_num2;
    }

    public function getCompositeNum3($third, $num_count)
    {
        $key = 0;
        for ($i = 0; $i < count($third); $i++) {
            $fir_num = $third[$i]['num'][0];
            $sec_num = $third[$i]['num'][1];
            $thir_num = $third[$i]['num'][2];

            $total = $third[$i]['total']['small_num'];
            $part_total = round($third[$i]['total']['small_num'] / ($num_count - 3));

            $for_num = $part_total - $fir_num - $sec_num - $thir_num;

            $num = $total - $fir_num - $sec_num;
            $string = (string)$num;
            $num = str_pad($string, 4, '0', STR_PAD_LEFT);
            $article = self::getArticle($num);

            if (self::getGoodOrBad($article['goodorbad'])) {
                $matching_num = self::getMatchingNum($thir_num, $for_num);
                if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                    $composite_num2[$key]['num'][0] = $third[$i]['num'][0];
                    $composite_num2[$key]['num'][1] = $third[$i]['num'][1];
                    $composite_num2[$key]['num'][2] = $third[$i]['num'][2];
                    $composite_num2[$key]['num'][3] = $for_num;
                    $composite_num2[$key]['chain_sum']= $third[$i]['chain_sum'];
                    $composite_num2[$key]['matching'] = $third[$i]['matching'];
                    $composite_num2[$key]['chain_sum'][2]['num'] = $num;
                    $composite_num2[$key]['chain_sum'][2]['article'] = $article;
                    $composite_num2[$key]['matching'][2] = $matching_num;
                    $composite_num2[$key]['total'] = $third[$i]['total'];
                    $key += 1;
                }
            }

        }
        return $composite_num2;
    }

    public function getCompositeNum4($four)
    {
        $key = 0;
        for ($i = 0; $i < count($four); $i++) {
            $fir_num = $four[$i]['num'][0];
            $sec_num = $four[$i]['num'][1];
            $thir_num = $four[$i['num']][2];
            $four_num = $four[$i]['num'][3];

            $total = $four[$i]['total']['small_num'];
            $five_num = $total - $fir_num - $sec_num - $thir_num - $four_num;

            $num = $total - $fir_num - $sec_num - $thir_num;
            $string = (string)$num;
            $num = str_pad($string, 4, '0', STR_PAD_LEFT);
            $article = self::getArticle($num);

            if (self::getGoodOrBad($article['goodorbad'])) {
                $matching_num = self::getMatchingNum($four_num, $five_num);
                if (self::getGoodOrBad($matching_num['article']['goodorbad'])) {
                    $composite_num2[$key]['num'][0] = $four[$i]['num'][0];
                    $composite_num2[$key]['num'][1] = $four[$i]['num'][1];
                    $composite_num2[$key]['num'][2] = $four[$i]['num'][2];
                    $composite_num2[$key]['num'][3] = $four[$i]['num'][3];
                    $composite_num2[$key]['num'][4] = $five_num;
                    $composite_num2[$key]['chain_sum'] = $four[$i]['chain_sum'];
                    $composite_num2[$key]['matching'] = $four[$i]['matching'];
                    $composite_num2[$key]['chain_sum'][3]['num'] = $num;
                    $composite_num2[$key]['chain_sum'][3]['article'] = $article;
                    $composite_num2[$key]['matching'][3] = $matching_num;
                    $composite_num2[$key]['total'] = $four[$i]['total'];
                    $key += 1;
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

