<?php

class UrlExtractorTest extends PHPUnit_Framework_TestCase
{
    public function testExtractAll()
    {

        $expectedData = array(
            "title" => "rollbackpt (Joao Ribeiro)",
            "description" =>
            "rollbackpt has 11 repositories written in JavaScript, PHP, and Cuda. Follow their code on GitHub.",
            "keywords" => array("rollbackpt", "github", "urlextractor", "demo"),
            "images" => array(0 => "https://avatars0.githubusercontent.com/u/2725826?v=3&amp;s=400")
        );

        $urlExtractor = new \rollbackpt\UrlExtractor();
        $urlData = $urlExtractor->extractAll(dirname(__FILE__) . "/test_website.html", false);
        $this->assertEquals($urlData, $expectedData);
    }
}
