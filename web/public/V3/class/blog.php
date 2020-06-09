<?php
require 'connection.php';
class blog extends SqlTool {

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

    public function postGetArticle($site_category = '', $category = '')
    {
        $article = self::getArticle($site_category, $category);

        return json_encode($article);
    }

    public function postGetArticleDetail($article_id)
    {
        $article_detail = self::getArticleDetail($article_id);

        return json_encode($article_detail);
    }

    public function postGetArticleCategory()
    {
        $article_category = self::GetArticleCategory();

        return json_encode($article_category);
    }

    public function getArticle($site_category = '', $category = '')
    {
        if (empty($site_category) && empty($category)) {
            $sql = "SELECT article_id,title,site_category,category,link,hits,images FROM `article_age_pixnet` order by `hits` desc";
        } else {
            $sql = "SELECT article_id,title,site_category,category,link,hits,images FROM `article_age_pixnet` where site_category = '$site_category' and category = '$category' order by `hits` desc";
        }

        $result = $this->conn->execute_dql($sql);
        // $row = mysqli_fetch_assoc($result);
        $data = [];
        while ($row = mysqli_fetch_assoc($result))
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getArticleDetail($article_id)
    {
        $sql = "SELECT title,article FROM `article_age_pixnet` WHERE article_id ='$article_id'";
        $result = $this->conn->execute_dql($sql);
        $row = mysqli_fetch_assoc($result);

        return   $row;
    }

    public function GetArticleCategory()
    {
        $sql = "SELECT `category`,`site_category` FROM `article_age_pixnet` group by `category`,`site_category` ORDER BY `article_age_pixnet`.`site_category` DESC";
        $result = $this->conn->execute_dql($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($result))
        {
            $data[] = $row;
        }
        return   $data;
    }

}