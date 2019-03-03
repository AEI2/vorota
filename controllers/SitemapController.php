<?php

class SitemapController extends Controller
{
    public function actionIndex()
    {
        $urls = array();

        // Записи блога
        $posts = Post::model()->findAll(array(
            'condition' => 't.public = 1 AND t.date <= NOW()'));

        $host = Yii::app()->request->hostInfo;

        echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url){
            echo '<url>
                <loc>' . $host . $url.'</loc>
                <changefreq>daily</changefreq>
                <priority>0.5</priority>
            </url>';
        }
        echo '</urlset>';
        Yii::app()->end();
    }
}