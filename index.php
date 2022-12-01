<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<title>Trade Table</title>
</head>
<body>
	<div class="container pt-5 flex" style="text-align: center;">
			<button class="btn btn-info" style="width: 100px;" id="load">
			Connect
		</button>
		<button class="btn btn-danger" style="width: 100px;" id="unload">
			Disconnect
		</button>
		
	</div>
	<div class="row">
		
		<div class="container table-container col-8 pt-5">
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">OI</th>
			      <th scope="col">Change in OI</th>
			      <th scope="col">Volume</th>
			      <th scope="col">IV</th>
			      <th scope="col">Delta</th>
			      <th scope="col">LTP</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <th scope="row">1</th>
			      <td>Mark</td>
			      <td>Otto</td>
			      <td>@mdo</td>
			      <td>Otto</td>
			      <td>@mdo</td>
			    </tr>
			    <tr>
			      <th scope="row">2</th>
			      <td>Jacob</td>
			      <td>Thornton</td>
			      <td>@fat</td>
			      <td>Otto</td>
			      <td>@mdo</td>
			    </tr>
			    <tr>
			      <th scope="row">3</th>
			      <td colspan="2">Larry the Bird</td>
			      <td>@twitter</td>
			      <td>Otto</td>
			      <td>@mdo</td>
			    </tr>
			  </tbody>
			</table>
		</div>
	</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script type="text/javascript">
	//const socket = new WebSocket('wss://push.truedata.in:8082?user=wssand030&password=asif030', 'echo-protocol');      
  	
  	var isSocketIsOn = false;
  	var socketConnection = {};

    		
    $('#load').click(function(){
         	var socket = new WebSocket('wss://push.truedata.in:8084?user=wssand030&password=asif030');
    		isSocketIsOn = true;
    		socketConnection = socket;
    		socket.addEventListener('open', function (event) {
 
			socket.send(JSON.stringify({"method":"addsymbol","symbols":["NIFTY-I","NIFTY 50"]}));
			    			    //socket.send(JSON.stringify({"method":"getmarketstatus","symbols":["NIFTY-I","NIFTY 50"]}));
			 
			});

		    socket.addEventListener('message', function (event) {
        	console.log(event.data);
        	$('body').append(event.data+'<br>');
    		});
		   
    
    });

    $('#unload').click(function(){
    	if (isSocketIsOn) {socketConnection.close();}
    })


</script>
</body>
</html>