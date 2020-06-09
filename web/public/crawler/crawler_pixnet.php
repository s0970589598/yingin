<?php
//namespace crawler;
 ini_set("max_execution_time", "300");
require '../class/class_crawler_pixnet.php' ;
//header('Content-Type: application/json; charset=utf-8');

$pixnet_blog_api_url = 'https://emma.pixnet.cc/blog/articles?user=agegurugure&format=json&per_page=300';


$re_json=new crawlerPixnet();


$blog_article = json_decode($re_json->Curl_content($pixnet_blog_api_url), true);
//echo '<html><body>';
foreach ($blog_article['articles'] as $key => $val) {
    $pixnet_article_api_url = 'https://emma.pixnet.cc/blog/articles/' . $val['id'] . '?user=agegurugure&format=json';
    $pixnet_blog_article_url = 'https://agegurugure.pixnet.net/blog/post/' . $val['id'];
    $sql2 = "select count(*) as total from article_age_pixnet where link ='$pixnet_blog_article_url' group by article_id";

    $result2=$re_json->execute_dql($sql2);
    $row = mysqli_fetch_assoc($result2);

    if ($row['total'] <> 1) {
        $site_category = $val['site_category'];
        $category = $val['category'];
        $link = $val['link'];
        $title = $val['title'];
        $hits = $val['hits']['total'];
        $content = $re_json->Curl_content($pixnet_article_api_url);
        $article = json_decode($content, true);
        //echo '<h1>' . $key . $title . '</h1>';
        // echo '<h2>' . $site_category . '/' . $category . '</h2>';
        //echo '<h3>' . $link . '</h3>';
        // echo '<h4>' . $hits . '</h4>';
        $body = $article['article']['body'];
        $thumb = $article['article']['thumb'];
        $images = json_encode($article['article']['images']);
        // echo '<hr/>';
        // echo '<br/>';
        if (!empty($body)) {
            echo $sql = "INSERT INTO `article_age_pixnet`(`title`,`site_category`,`category`,`link`,`hits`,`article`,`images`) VALUES ('$title','$site_category','$category','$link','$hits','$body','$images')";
            $re = $re_json->execute_dml($sql);
        }


    }
}
//echo '</body></html>';
?>