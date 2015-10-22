<?php

require_once '../src/rollbackpt/UrlExtractor/UrlExtractor.php';

$urlExtractor = new \rollbackpt\UrlExtractor\UrlExtractor();
$metaTags = $urlExtractor->extractAll("https://github.com/rollbackpt", false);
echo "<h2>Meta tags from -> https://github.com/rollbackpt</h2>";
echo "<pre>";
var_dump($metaTags);
echo "</pre>";
