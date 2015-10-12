<?php

require_once '../src/UrlExtractor.php';

if (isset($_POST['url']) && !empty($_POST['url'])) {
    $urlExtractor = new \rollbackpt\UrlExtractor();
    echo $urlExtractor->extractAll(htmlspecialchars($_POST['url']));
}
