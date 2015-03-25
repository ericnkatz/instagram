<?php namespace App\Http\Controllers;

use App\Image;

class ImagesController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function tag($tag)
	{
		$images = Image::all();
		
		return view( 'tag', ['images' => $images, 'tag' => $tag] );
	}


}
