<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\InstagramApi;
use Pusher;

class AdminController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function tag($tag)
	{

		$instagram = new InstagramApi;
		$images = $instagram->getImagesByTag($tag);

		$data = [
			'tag' => $tag,
			'images' => $images
		];

		return view('admin.tag', ['data' => $data]);
	}

	public function tagApi(Request $request,  $tag)
	{
		$images = Image::where('tag', $tag)->get()->reverse();

		$buildImages = [];
		
		foreach($images as $image) {
			$buildImages[] = [
				'id' => $image['id'],
				'link' => $image['link'],
				'image' => $image['image'],
				'author' => [
					'username' => $image['username'],
					'avatar' => $image['avatar'],
					'full_name' => $image['full_name']
				]
			];
		}

		return ['images' => $buildImages];
	}

	public function addImage(Request $request)
	{
		$input = $request->all();

		$search = Image::where('instagram_id', $input['id'])->get();
	
		if(!count($search)) {
			$image = new Image;

			$image['image'] = $input['image'];
			$image['tag'] = $input['tag'];
			$image['instagram_id'] = $input['id'];
			$image['link'] = $input['link'];
			$image['username'] = $input['authorUsername'];
			$image['avatar'] = $input['authorAvatar'];
			$image['full_name'] = $input['authorFullname'];

			$image->save();

			$pusher = new Pusher( env('PUSHER_KEY'), env('PUSHER_SECRET'), env('PUSHER_APP_ID') );
			$pusher->trigger( $input['tag'], 'add_image', $image );

			return ['status' => 'Image inserted into database succesfully.'];
		}

		return ['status' => 'Image already existed.'];

	}

}
