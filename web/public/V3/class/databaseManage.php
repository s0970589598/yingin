<?php
require 'connection.php';
class databaseManage extends SqlTool {

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

    public function fire()
    {

    }

    public function getArticle192()
    {
        $sql = "SELECT `yingin192_id`, `goodorbad`, `mean`, `point`, `thousand_num` FROM `yingin192`";
        $result = $this->conn->execute_dql($sql);
        $row = mysqli_fetch_assoc($result);

        return   $row;
    }

    public function getKangxi()
    {
        $sql = "SELECT `kangxi_id`,`uncodechart`,`word`,`num` FROM `kangxi`";
        $result = $this->conn->execute_dql($sql);
        $row = mysqli_fetch_assoc($result);

        return $row;
    }

    public function getArticle10000()
    {
        $sql = "SELECT `yingin10000_id`, `yingin10000_num`, `goodorbad`, `yingin192_id` FROM `yingin10000`";
        $result = $this->conn->execute_dql($sql);
        $row = mysqli_fetch_assoc($result);

        return $row;
    }

    public function updateArticle192($arr, $yingin192_id)
    {
        $thousand_num = $arr['thousand_num'];
        $goodorbad = $arr['goodorbad'];
        $mean = $arr['mean'];
        $point = $arr['point'];

        $sql="UPDATE `yingin192` SET `thousand_num`='$thousand_num', `goodorbad`='$goodorbad', `mean`='$mean', `point`='$point' where  yingin192_id = '$yingin192_id'";
		$result=$this->conn->execute_dml($sql);

        return   $result;
    }

    public function updateKangxi($arr, $kangxi_id)
    {
        $num = $arr['num'];

        $sql="UPDATE `kangxi` SET `num`='$num'  where  kangxi_id='$kangxi_id'";
		$result=$this->conn->execute_dml($sql);

        return $result;
    }

    public function updateArticle10000($arr, $yingin10000_id)
    {
        $goodorbad = $arr['goodorbad'];
        $yingin192_id = $arr['yingin192_id'];

        $sql = "UPDATE `yingin10000` SET  `goodorbad`='$goodorbad', `yingin192_id`='$yingin192_id' where  yingin10000_id = '$yingin10000_id'";
        $result=$this->conn->execute_dml($sql);

        return   $result;
    }


}