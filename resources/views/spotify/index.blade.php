{!! \HTML::script('js/brain-socket.min.js') !!}
<script>
	window.app = {};

	app.BrainSocket = new BrainSocket(
	        new WebSocket('ws://project.local:8080'),
	        new BrainSocketPubSub()
	);

	app.BrainSocket.Event.listen('test',function(msg)
	{
	    console.log(msg);
	});

	setTimeout(function() {
		app.BrainSocket.message('generic','test');
	}, 5000);
</script>