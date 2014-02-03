
	function getParameter( name ){
		var url = window.location.href;
		var rule = new RegExp( "[\\?&]" + name + "=([^&#]*)" );
		var res = url.match( rule )
		return res ? res[ 1 ] : undefined;
	}

	function ViewModel(){
		this.connected = ko.observable( false );
		this.joinedRoom = ko.observable( false );
	}

	ViewModel.prototype = {

		startWebcamSD: function(){
			this._startStream( "webcamSD" );
		},

		startWebcamHD: function(){
			this._startStream( "webcamHD" );
		},

		shareScreen: function(){
			this._startStream( "screen" );
		},

		quitConference: function(){
			BistriConference.quitRoom();
		},

		selectContent: function( model, evt ){
			evt.srcElement.select();
		},

		isCompatible: function(){
			return BistriConference.isCompatible();
		},

		_startStream: function( device ){
			document.querySelector( ".stripes" ).style.display = "block";
			BistriConference.startStream( device );
		}
	};

	var onBistriConferenceReady = function(){

		var viewModel = new ViewModel();

		ko.applyBindings( viewModel );

		BistriConference.init( {
			appId: getParameter( "api_key" ),
			appKey: getParameter( "app_key" ),
			debug: true
		} );

		BistriConference.signaling.addHandler( "onConnected", function( data ){
			viewModel.connected( true );
		} );

		BistriConference.signaling.addHandler( "onJoinedRoom", function( data ){
			viewModel.joinedRoom( true );
			for( var i = 0; i < data.members.length; i++ ){
				BistriConference.call( data.members[ i ].id );
			}
		} );

		BistriConference.signaling.addHandler( "onQuittedRoom", function( data ){
			viewModel.joinedRoom( false );
			BistriConference.stopStream();
			var nodes = document.querySelectorAll( "div[id^=video-] video" );
			for(var i=0;  i < nodes.length; i++ ){
				nodes[ i ].parentNode.removeChild( nodes[ i ] );
			}
			count = 0;
		} );

		BistriConference.signaling.addHandler( "onSessionError", function( data ){
			if( data && data.error && console && console.log ){
				console.log( data.error );
			}
		} );

		BistriConference.streams.addHandler( "onStreamAdded", function( stream, pid ){
			if( !pid ){
				var roomId = getParameter( "room" );
				document.querySelector( ".stripes" ).style.display = "none";
				BistriConference.attachStream( stream, document.querySelector( ".local-stream" ), { autoplay: true, fullscreen: true } );
				BistriConference.joinRoom( roomId );
			}
			else{
				var nodes = document.querySelectorAll( ".remote-streams .span6" );

				for(var i=0;  i < nodes.length; i++ ){
					if( !nodes[ i ].firstChild ){
						BistriConference.attachStream( stream, nodes[ i ], { autoplay: true, fullscreen: true } );
						break;
					}
				}
			}
		} );

		BistriConference.streams.addHandler( "onStreamClosed", function( stream, pid ){
			BistriConference.detachStream( stream, true );
		} );

		if( BistriConference.isCompatible() ){
			BistriConference.connect();
		}

	};