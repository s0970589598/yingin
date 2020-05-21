<?php
require 'connection.php';
class chineseName extends SqlTool {

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

    public function fire($name)
    {
        $name_count = mb_strlen(trim($name));

        for ($i = 0; $i < $name_count; $i++) {
            $disintegration_name[$i]['name'] = mb_substr($name, $i, 1,"utf-8");
            $disintegration_name[$i]['strokes'] = self::getStrokes($disintegration_name[$i]['name']);
        }

        $composite_num = self::getCompositeNum($disintegration_name);
        $matching_num = self::getMatchingNum($disintegration_name);
        $total_num = self::getTotalNum($disintegration_name);

        $name_fate = array (
            'disintegration_name' => $disintegration_name,
            'composite_num' => $composite_num,
            'matching_num'  => $matching_num,
            'total_num'     => $total_num
        );

        return json_encode($name_fate);
    }

    public function getCompositeNum($disintegration_name)
    {
        $name_count = count($disintegration_name);

        for ($j = 0; $j <= $name_count; $j++) {
            if($j+1 > ($name_count - 1)) {
                break;
            }
            (int)$composite_num[$j]['num'] = (int)$disintegration_name[$j]['strokes'] + (int)$disintegration_name[$j+1]['strokes'];
            $string = (string)$composite_num[$j];
            $composite_num[$j]['num'] = str_pad($string,4,'0',STR_PAD_LEFT);
            $composite_num[$j]['article'] = self::getArticle($composite_num[$j]['num']);

        }
        return $composite_num;
    }

    public function getMatchingNum($disintegration_name)
    {
        $name_count = count($disintegration_name);

        for ($k = 0; $k <= $name_count; $k++) {
            if ($k+1 > ($name_count - 1)) {
                break;
            }

            if ($disintegration_name[$k]['strokes'] < 10 && $disintegration_name[$k+1]['strokes'] < 10) {
                $string = (string)$disintegration_name[$k]['strokes'] . (string)$disintegration_name[$k+1]['strokes'];
                $matching_num[$k]['num'] = str_pad($string,2,'0',STR_PAD_LEFT);
                $matching_num[$k]['article'] = self::getArticle($matching_num[$k]['num']);
            } else {
                if ($disintegration_name[$k]['strokes'] < 10) {
                    $disintegration_name[$k]['strokes'] = (int)$disintegration_name[$k]['strokes'] + 24;

                }
                if ($disintegration_name[$k+1]['strokes'] < 10) {
                    $disintegration_name[$k+1]['strokes'] = str_pad($string,1,'0',STR_PAD_LEFT);

                }
                $matching_num[$k]['num'] = (string)$disintegration_name[$k]['strokes'] . (string)$disintegration_name[$k+1]['strokes'];
                $matching_num[$k]['article'] = self::getArticle($matching_num[$k]['num']);
            }
        }
        return $matching_num;
    }

    public function getTotalNum($disintegration_name)
    {
        $name_count = count($disintegration_name);

        for ($l = 0; $l <= $name_count; $l++) {
            $total_num['num'] += (int)$disintegration_name[$l]['strokes'];
        }

        $string = (string)$total_num['num'];
        $total_num['num'] = str_pad($string,4,'0',STR_PAD_LEFT);
        $total_num['article'] = self::getArticle($total_num['num']);

        return $total_num;
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


}