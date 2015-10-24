<?php

require_once '../src/UrlExtractor/UrlExtractor.php';

$urlExtractor = new \rollbackpt\UrlExtractor\UrlExtractor();
$metaTags = $urlExtractor->extractAll("https://github.com/rollbackpt", false);
echo "<h2>Meta tags from -> https://github.com/rollbackpt</h2>";
echo "<pre>";
var_dump($metaTags);
echo "</pre>";

// Or using composer autoload...
// Install using: composer require rollbackpt/url-extractor

// require __DIR__ . "/../vendor/autoload.php";
//
// use rollbackpt\UrlExtractor\UrlExtractor;
//
// $urlExtractor = new UrlExtractor();
// $metaTags = $urlExtractor->extractAll("https://github.com/rollbackpt", false);
// echo "<h2>Meta tags from -> https://github.com/rollbackpt</h2>";
// echo "<pre>";
// var_dump($metaTags);
// echo "</pre>";
