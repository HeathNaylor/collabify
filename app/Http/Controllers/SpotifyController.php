<?php namespace Collabify\Http\Controllers;

use SpotifyWebAPI;

class SpotifyController extends Controller {

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
	}

	public function authorize()
	{
		$session = new SpotifyWebAPI\Session(getenv('SPOTIFY_CLIENT_ID'), getenv('SPOTIFY_CLIENT_SECRET'), getenv('SPOTIFY_REDIRECT_URI'));

		$scopes = array(
		    'playlist-read-private',
		    'user-read-private'
		);

		$authorizeUrl = $session->getAuthorizeUrl(array(
		    'scope' => $scopes
		));

		header('Location: ' . $authorizeUrl);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function callback()
	{
		$session = new SpotifyWebAPI\Session(getenv('SPOTIFY_CLIENT_ID'), getenv('SPOTIFY_CLIENT_SECRET'), getenv('SPOTIFY_REDIRECT_URI'));
		$api = new SpotifyWebAPI\SpotifyWebAPI();

		// Request a access token using the code from Spotify
		$session->requestAccessToken($_GET['code']);
		$accessToken = $session->getAccessToken();

		// Set the access token on the API wrapper
		$api->setAccessToken($accessToken);

		$search = $api->search('feel good', 'track');

		dd($search);

		return view('spotify.callback');
	}

}
