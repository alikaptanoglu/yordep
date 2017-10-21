<?php

require_once 'includes/SitemapGenerator.php';
require_once 'conn.php';

$sitemap = new SitemapGenerator("http://yorumdeposu.com/");

$query = "SELECT title_id FROM titles ORDER BY title_id DESC";
$result = $conn->query($query);
if(!$result){
    die($conn->error);
}


$num = $result->num_rows;


for($i=0;$i<$num;$i++){
    $result->data_seek($i);
    $row = $result->fetch_array(MYSQLI_NUM);
    $sitemap->addUrl("http://yorumdeposu.com/title.php?id=$row[0]" ,  date('c'), 'daily', 0.8);
}



        // create sitemap
        $sitemap->createSitemap();
        // write sitemap as file
        $sitemap->writeSitemap();
        // update robots.txt file
        $sitemap->updateRobots();
        // submit sitemaps to search engines
        $sitemap->submitSitemap();






?>