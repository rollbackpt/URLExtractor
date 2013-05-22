<?php

require 'Slim/Slim.php';
require_once '../../../URLExtractor/urlextractor.class.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->post('/url', function () {
	
	try {
		$request = \Slim\Slim::getInstance()->request();
	    $url = json_decode($request->getBody());
	    $urlEmbed = new UrlExtractor($url->url);
		echo $urlEmbed->extractAll();
	} catch (Exception $e) {
		echo json_encode(array('error' => 'Empty URL'));;
	}
	
});

$app->run();
