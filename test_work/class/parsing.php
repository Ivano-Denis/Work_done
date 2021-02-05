<?php


class parsing
{

    public $url;

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getNewsLink()
    {
        $content = file_get_contents($this->url);

        preg_match_all('#<h2>(.*)<\/h2>#Uis', $content,$allNews);

        $arrLinks = [];

        foreach ($allNews[0] as $key => $news) {

            preg_match_all('#(?<=href=\')([\s\S]+?)(?=\'\sclass)#Uis', $news,$link);

            $arrLinks[$key] = $link[0][0];
        }

        return $arrLinks;
    }


    public function getNewsContent($url)
    {
        $content = file_get_contents($url);
        preg_match_all('#(?<=<h1\sclass="storyheadline">)([\s\S]+?)(?=<\/h1>)#Uis', $content,$header);

        preg_match_all('#(?<=<span\sclass="storycontent">)([\s\S]+?)(?=<script)#i', $content,$textNews);

//        preg_match_all('#(?<=<div\sclass=\'mailmunch-forms-before-post\'\sstyle=\'display:\snone\s!important;\'></div>)([\s\S]+?)(?=<\/span><\/p><div\sclass=\'mailmunch-forms-in-post-middle\')#i', $textNews[0][0],$textNews);
//
//        $result = preg_replace('#function\smyAdDoneFunction(.*)document\.write#Uis' ,'',  $textNews[0][0]);

        preg_match_all('#<div\sclass="photowrap">(.*)<\/div>#Uis', $content,$image);

        preg_match_all('#(?<=<img\ssrc=\')([\s\S]+?)(?=\'\salt)#Uis', $image[0][0],$image);


        preg_match_all('#<span\sclass="time-wrapper">(.*)<\/span>#Uis', $content,$datePublished);
        preg_match_all('#(?<=<span\sclass="time-wrapper">)([\s\S]+?)(?=<\/span>)#Uis', $datePublished[0][0],$datePublished);


        $datePublished = strtotime($datePublished[0][0]);


        return [
            'header' => $header[0][0],
//            'text' => strip_tags($result),
            'text' => strip_tags($textNews[0][0]),
            'img_link' => $image[0][0],
            'date' => $datePublished
        ];
    }


}

