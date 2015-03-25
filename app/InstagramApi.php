<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Instagram\Instagram as InstagramProvider;

class InstagramApi extends InstagramProvider {

	public function __construct()
	{
       	parent::__construct();
       	
		$auth_config = array(
			'client_id'         => getenv('INSTAGRAM_CLIENT_ID'),
			'client_secret'     => getenv('INSTAGRAM_CLIENT_SECRET'),
			'redirect_uri'      => getenv('INSTAGRAM_REDIRECT_URI'),
			'scope'             => array( 'basic' )
		);

		$this->setClientID( $auth_config['client_id'] );

	}

	public function getImagesByTag($tag)
	{
		$tag = $this->getTag($tag)->getMedia();
		$images = [];
		foreach($tag as $image) {
			$images[] = [
				'id' => $image->id,
				'link' => $image->link,
				'image' => $image->images->standard_resolution->url,
				'author' => [
					'username' => $image->user->username,
					'avatar' => $image->user->profile_picture,
					'full_name' => $image->user->full_name
				]
			];
		}

		return $images;
	}
}
// 	public function grabImagesTagJson($instatag) 
// 	{

// 		$images = [];
// 		$tag = $this->instagram->getTag($instatag)->getMedia();

// 		foreach($tag as $image) {
			
// 			$newImage['id'] = $image->id;
// 			$newImage['userid'] = $image->user->id;
// 			$newImage['author'] = $image->user->username;
// 			$newImage['link'] = $image->link;
// 			$newImage['image'] = $image->images->thumbnail->url;


// 			$images[] = $newImage;
// 		//	return $newImage;
// 		//	echo "<h3>".$newImage['author']."</h3><p><a href='".$newImage['link']."'><img src='".$newImage['image']."'></a></p>";
// 		}

// 		return json_encode($images);
	
// 	}
// 	public function grabImagesUserJson($userid) 
// 	{

// 		$images = [];
// 		$user = $this->instagram->getUser($userid)->getMedia();
// 		foreach($user as $image) {
			
// 			$newImage['id'] = $image->id;
// 			$newImage['userid'] = $image->user->id;
// 			$newImage['author'] = $image->user->username;
// 			$newImage['link'] = $image->link;
// 			$newImage['image'] = $image->images->thumbnail->url;


// 			$images[] = $newImage;
// 		//	return $newImage;
// 		//	echo "<h3>".$newImage['author']."</h3><p><a href='".$newImage['link']."'><img src='".$newImage['image']."'></a></p>";
// 		}

// 		return json_encode($images);
	
// 	}

// }