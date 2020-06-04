<?php
//namespace crawler;
 ini_set("max_execution_time", "300");
require '../class/class_crawler_pixnet.php' ;
//header('Content-Type: application/json; charset=utf-8');

$pixnet_blog_api_url = 'https://emma.pixnet.cc/blog/articles?user=agegurugure&format=json&per_page=300';


$re_json=new crawlerPixnet();


$blog_article = json_decode($re_json->Curl_content($pixnet_blog_api_url), true);
echo '<html><body>';

foreach($blog_article['articles'] as $key => $val){

    $pixnet_article_api_url = 'https://emma.pixnet.cc/blog/articles/' . $val['id'] . '?user=agegurugure&format=json';
    $site_category = $val['site_category'];
    $category = $val['category'];
    $link = $val['link'];
    $title = $val['title'];
    $hits = $val['hits']['total'];
    $article = json_decode($re_json->Curl_content($pixnet_article_api_url),true);
    echo '<h1>' . $key . $title . '</h1>';
    echo '<h2>' . $site_category . '/' . $category . '</h2>';
    echo '<h3>' . $link . '</h3>';
    echo '<h4>' . $hits . '</h4>';
    echo $body = $article['article']['body'];
    echo '<hr/>';
    echo '<br/>';
}

echo '</body></html>';
?>