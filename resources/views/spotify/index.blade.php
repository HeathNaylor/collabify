@extends('app')
@section('content')
<div class="container" ng-app="collabifyApp" ng-controller="spotifyController" ng-model="loading" ng-hide="loading">
	<h1>Playlists</h1>
	<div class="row" ng-model="playlists">
		<div class="col-md-4">
			<table class="table table-striped" ng-hide="!playlists.items.length">
				<tr>
					<th>Playlist name</th>
					<th>Songs</th>
				</tr>
				<tr ng-repeat='playlist in playlists.items'>
				{{-- <tr> --}}
					<td><% playlist.name %></td>
					<td><% playlist.tracks.total %></td>
				</tr>
			</table>
			<div ng-hide="playlists.items.length">
				No Playlists
			</div>
		</div>
	</div>
</div>
@stop