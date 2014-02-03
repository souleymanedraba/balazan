window.addEventListener( "load", function(){

		var nodes = document.querySelectorAll( ".bistri-video-conference" );

		for( var i = 0; i < nodes.length; i++ ){

			var room = nodes[ i ].getAttribute( "data-room" );

			nodes[ i ].addEventListener( "click", function(){
				window.open( bvc_page + "?api_key=" + bvc_apiKey +"&app_key=" + bvc_appKey + "&room=" + room );
			} );
		}
} )