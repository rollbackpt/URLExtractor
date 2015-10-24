<?php

require_once '../src/UrlExtractor/UrlExtractor.php';

if (isset($_POST['url']) && !empty($_POST['url'])) {
    $urlExtractor = new \rollbackpt\UrlExtractor\UrlExtractor();
    echo $urlExtractor->extractAll(htmlspecialchars($_POST['url']));
}
