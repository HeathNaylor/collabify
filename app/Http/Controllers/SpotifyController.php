<?php namespace Collabify\Http\Controllers;

use SpotifyWebAPI;

class SpotifyController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $session = \Session::get('spotify.session');

        // Set the access token on the API wrapper
        $api->setAccessToken($session->getAccessToken());

        $search = $api->search('Homeworld', 'track');

        dd($search);
        return view('spotify.index');
    }

    /**
     * Authorize method to initiate Spotify API access
     *
     * @return redirect
     */
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

        return redirect($authorizeUrl);
    }

    /**
     * Callback method for the Spotify API response
     *
     * @return Response
     */
    public function callback()
    {
        $session = new SpotifyWebAPI\Session(getenv('SPOTIFY_CLIENT_ID'), getenv('SPOTIFY_CLIENT_SECRET'), getenv('SPOTIFY_REDIRECT_URI'));

        // Request a access token using the code from Spotify
        $session->requestAccessToken(\Input::get('code'));
        \Session::put('spotify.session', $session);

        return redirect('/');
    }

}
