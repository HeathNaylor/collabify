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
        $this->api = new SpotifyWebAPI\SpotifyWebAPI();
    }

    public function index()
    {
        $session = \Session::get('spotify.session');

        // Set the access token on the API wrapper
        $this->api->setAccessToken($session->getAccessToken());

        $search = $this->api->search('Homeworld', 'track');

        $playlist = $this->api->getUserPlaylist('bythepixelradio', '08uuHzyR5eMuBuI6O4e8EV');

        return view('spotify.index');
    }

    public function getPlaylists()
    {
        $session = \Session::get('spotify.session');
        $this->api->setAccessToken($session->getAccessToken());
        $playlists = $this->api->getUserPlaylists('bythepixelradio');
        $playlists = $this->api->getUserPlaylists('testamentband');

        return response()->json(json_encode($playlists));
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
