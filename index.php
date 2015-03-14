<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$app = new \Slim\Slim();

$cache = new \Doctrine\Common\Cache\FilesystemCache('cache');


$auth_config = array(
	'client_id'         => getenv('INSTAGRAM_CLIENT_ID'),
	'client_secret'     => getenv('INSTAGRAM_CLIENT_SECRET'),
	'redirect_uri'      => getenv('INSTAGRAM_REDIRECT_URI'),
	'scope'             => array( 'basic' )
);

$instagram = new \Instagram\Instagram;
$instagram->setClientID( $auth_config['client_id'] );



$app->get('/tag/:tag(/:page)', function ($tag, $page = null) use ($app, $instagram, $cache) {
	$term = 'unique_' . $tag . $page;
	$params = isset($page) ? array( 'max_id' => $page ) : null;
	$now = time();
	// $app->etag($term);
	// $app->expires('+5 seconds');

    $storage = $cache->fetch($term);
    if($storage['expiration'] < $now) {

	    $data = function() use($instagram, $tag, $params) {
	    	$tag = $instagram->getTag($tag)->getMedia( $params );
			$images = [];
			foreach($tag as $image) {
				$images[] = [
					'id' => $image->id,
					'link' => $image->link,
					'image' => $image->images->standard_resolution->url,
					'author' => [
						'username' => $image->user->username,
						'full_name' => $image->user->full_name
					]
				];
			}
	    return [$images, $tag];
	    };

	    $data = $data();

	    $storage = [
	    	'images' => $data[0],
	    	'previous' => 'http://' . $_SERVER['HTTP_HOST'] . '/tag/' . $tag . '/' . $data[1]->getNext(),
	    	'permalink' => 'http://' . $_SERVER['HTTP_HOST'] . '/tag/' . $tag . '/' . $data[1]->getMinTagId(),
	    	'expiration' => strtotime('+5 seconds')
	    ];
	    $cache->save($term, $storage);
	}
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody(json_encode($storage));

});





$app->run();