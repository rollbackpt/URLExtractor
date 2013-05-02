<?php

require_once '../URLExtractor/urlextractor.class.php';

$urlEmbed = new UrlExtractor('http://aharpa.pt/paginas/eventos/');
$urlEmbed->extractAll();

echo 'title -> <pre>';
var_dump($urlEmbed->title);
echo '</pre><br/><br/>description -> <pre>';
var_dump($urlEmbed->description);
echo '</pre><br/><br/>keywords -> <pre>';
var_dump($urlEmbed->keywords);
echo '</pre><br/><br/>images -> <pre>';
var_dump($urlEmbed->images);
echo '</pre><br/>';
