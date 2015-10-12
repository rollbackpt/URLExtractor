<?php

require_once '../src/UrlExtractor.php';

if (isset($_POST['url']) && !empty($_POST['url'])) {
    $urlExtractor = new \rollbackpt\UrlExtractor($_POST['url']);
	echo $urlExtractor->extractAll();

/*
	echo 'title -> <pre>';
	var_dump($urlEmbed->title);
	echo '</pre><br/><br/>description -> <pre>';
	var_dump($urlEmbed->description);
	echo '</pre><br/><br/>keywords -> <pre>';
	var_dump($urlEmbed->keywords);
	echo '</pre><br/><br/>images -> <pre>';
	var_dump($urlEmbed->images);
	echo '</pre><br/>';
*/
}
