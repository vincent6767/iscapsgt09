<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Hello there!</title>
	</head>
	<body>
		<pre id="output"></pre>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script type="text/javascript">
			var output = document.getElementById('output');

			try {
				var source = new EventSource('{{ action('HomeController@test') }}', {withCredentials: false});
				source.onopen = function() {
					output.appendChild(document.createElement('hr'));

					return ;
				};

				source.onmessage =  function(evt) {
					var samp = document.createElement('samp');
					samp.innerHTML = evt.data + "\n";

					output.appendChild(samp);

					return ; 
				};

				source.onerror = function(event) {
					var txt;
				    switch( event.target.readyState ){
				        // if reconnecting
				        case EventSource.CONNECTING:
				            txt = 'Reconnecting...';
				            //source.close();
				            break;
				        // if error was fatal
				        case EventSource.CLOSED:
				            txt = 'Connection failed. Will not retry.';
				            break;
    				}
    				console.log(txt);
				}

				source.addEventListener('ping', function(e) {
					var data = JSON.parse(e.data);
					console.log(data.time);
				});
			} catch(e) {
				console.log(e);
			}

			//polling technique here!
		/*	(function poll() {
				setTimeout(function() {
					$.get('', function(data) {
						console.log(data);
						poll();
					});
				}, 1000);
			})();*/
		</script>
	</body>
</html>