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
			<button hidden class="btn btn-info" style="width: 100px;" id="load">
			Connect
		</button>

		<button class="btn btn-danger" style="width: 100px;" id="unload">
			Disconnect
		</button>
		
	</div>
	<div class="container">
		

		<div class="container table-container col-12 pt-2"  style="padding-right: 0">
			<!-- <h2>Call</h2> -->
			<table class="table table-bordered">
			  <thead>
			    <tr>
			      <th scope="col">OI</th>
			      <th scope="col">Change in OI</th>
			      <th scope="col">Volume</th>			 		
			      <th scope="col">LTP</th>
				  <th scope="col">Strike</th>
				  <th scope="col">OI</th>
			      <th scope="col">Change in OI</th>
			      <th scope="col">Volume</th>	
			      <th scope="col">LTP</th>
			    </tr>
			  </thead>
			  <tbody id="table-body">
			    
			  </tbody>
			</table>
		</div>
	</div>

<!-- Modal Start	 -->

<div class="modal" tabindex="-1"  id="exampleModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal End -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script type="text/javascript">
	//const socket = new WebSocket('wss://push.truedata.in:8082?user=wssand030&password=asif030', 'echo-protocol');      
  	
  	var isSocketIsOn = false;
  	var socketConnection = {};
	var strike_prices = [];
	var tableData = {};
	var spot = 0;
	var table = ``;
    var entity = "NIFTY 50";
	var highestCEV = 0;
	var highestPEV = 0;
	var reverse = false;

	$(document).ready(function(){
	$("#load").click();
	$('td[data-type="strike"]').click(function(){
			$("#exampleModal .modal-body").text($(this).html());
			

		});
	});
    $('#load').click(function(){
         	var socket = new WebSocket('wss://push.truedata.in:8084?user=wssand030&password=asif030');
    		isSocketIsOn = true;
    		socketConnection = socket;
    		socket.addEventListener('open', function (event) {
			//socket.send(JSON.stringify({"method":"addsymbol","symbols":[]}));
			socket.send(JSON.stringify({"method":"addsymbol","symbols":["NIFTY 50", "NIFTY22120818000CE", "NIFTY22120818000PE"]}));
			});
			
			socket.addEventListener('message', function (event) {
				
				let data = JSON.parse(event.data);
				
				if(data.message == 'symbols added') {

					if((spot == 0) && typeof data.symbollist[0][0] != 'undefined' && (data.symbollist[0][0] == "NIFTY 50")) {
						//check spot
						spot = Math.round(data.symbollist[0][3]/50)*50;	
					}
					let strikes = [spot, 
						spot+50,spot+100,spot+150,spot+200,spot+250,spot+300,spot+350,spot+400,spot+450,
						spot-50,spot-100,spot-150,spot-200,spot-250,spot-300,spot-350,spot-400,spot-450,
					];
					if(reverse) {
						strikes = strikes.sort().reverse();	
					} else {
						strikes = strikes.sort();

					}

					strike_prices = strikes;
					socket.send(JSON.stringify({"method":"addsymbol","symbols":[
						"NIFTY221208"+strikes[0]+"CE",
						"NIFTY221208"+strikes[1]+"CE",
						"NIFTY221208"+strikes[2]+"CE",
						"NIFTY221208"+strikes[3]+"CE",
						"NIFTY221208"+strikes[4]+"CE",
						"NIFTY221208"+strikes[5]+"CE",
						"NIFTY221208"+strikes[6]+"CE",
						"NIFTY221208"+strikes[7]+"CE",
						"NIFTY221208"+strikes[8]+"CE",
						"NIFTY221208"+strikes[9]+"CE",
						"NIFTY221208"+strikes[10]+"CE",
						"NIFTY221208"+strikes[11]+"CE",
						"NIFTY221208"+strikes[12]+"CE",
						"NIFTY221208"+strikes[13]+"CE",
						"NIFTY221208"+strikes[14]+"CE",
						"NIFTY221208"+strikes[15]+"CE",
						"NIFTY221208"+strikes[16]+"CE",
						"NIFTY221208"+strikes[17]+"CE",
						"NIFTY221208"+strikes[18]+"CE",
						"NIFTY221208"+strikes[0]+"PE",
						"NIFTY221208"+strikes[1]+"PE",
						"NIFTY221208"+strikes[2]+"PE",
						"NIFTY221208"+strikes[3]+"PE",
						"NIFTY221208"+strikes[4]+"PE",
						"NIFTY221208"+strikes[5]+"PE",
						"NIFTY221208"+strikes[6]+"PE",
						"NIFTY221208"+strikes[7]+"PE",
						"NIFTY221208"+strikes[8]+"PE",
						"NIFTY221208"+strikes[9]+"PE",
						"NIFTY221208"+strikes[10]+"PE",
						"NIFTY221208"+strikes[11]+"PE",
						"NIFTY221208"+strikes[12]+"PE",
						"NIFTY221208"+strikes[13]+"PE",
						"NIFTY221208"+strikes[14]+"PE",
						"NIFTY221208"+strikes[15]+"PE",
						"NIFTY221208"+strikes[16]+"PE",
						"NIFTY221208"+strikes[17]+"PE",
						"NIFTY221208"+strikes[18]+"PE",

					]}));
					
					
				}
				

				if(typeof JSON.parse(event.data).symbollist != 'undefined' && JSON.parse(event.data).symbollist.length > 5){
					// $('#data-box').append('<div id="table-rows">'+(event.data)+'</div>');
					table = event.data;
				}
				make_table();
			});  
    });

    $('#unload').click(function(){
    	if (isSocketIsOn) {socketConnection.close();}
    })

	function make_table() {
		let html = '';
		let htmlStrike = '';
		let tabPE = [];
		let tabCE = [];
		let tableData = JSON.parse(table);
		//console.log(tableData);
		if(tableData.symbollist && tableData.symbollist.length > 5){
			table = tableData.symbollist;
			$.each(table, function (index, element) {
				if(element[0].slice(-2) == 'CE') {
					if(element[6]/50 > highestCEV) {
						highestCEV = element[6]/50;
					}
						tabCE.push(element);
					} else {
						if(element[6]/50 > highestPEV) {
						highestPEV = element[6]/50;
					}
						tabPE.push(element);
				}
			});	
		}
		
		$.each(strike_prices, function(index, item) {
			htmlStrike += `<tr class='${item}' style='border-bottom: ${item == spot ? '2px #f97d06 solid': ''}'>
			<td class='${item}-CE' scope="col" style="background: ${item <= spot ? '#FAC898 !important': ''}">${tabCE[index][11]/50}</td>
			<td class='${item}-CE' scope="col" style="background: ${item <= spot ? '#FAC898 !important': ''}">${(tabCE[index][12] - tabCE[index][11])/50}</td>
			<td class='${item}-CE' scope="col" style="background: ${highestCEV == tabCE[index][6]/50 ? '#f97d06' : (item <= spot ? '#FAC898 !important': '')}">${tabCE[index][6]/50}</td>
			<td class='${item}-CE' scope="col" style="background: ${item <= spot ? '#FAC898 !important': ''}">${tabCE[index][3]}</td>
			<td style='background: #f5f5f5' data-type="strike" data-bs-toggle="modal" class='${item}-STR' data-bs-target="#exampleModal" scope="col">${item}</td>
			<td class='${item}-PE' scope="col" style="background: ${item > spot ? '#FAC898 !important': ''}">${tabPE[index][11]/50}</td>
			<td class='${item}-PE' scope="col" style="background: ${item > spot ? '#FAC898 !important': ''}">${(tabPE[index][12] - tabPE[index][11])/50}</td>
			<td class='${item}-PE' scope="col" style="background: ${highestPEV == tabPE[index][6]/50 ? '#f97d06' : (item > spot ? '#FAC898 !important': '')}">${tabPE[index][6]/50}</td>
			<td class='${item}-PE' scope="col" style="background: ${item > spot ? '#FAC898 !important': ''}">${tabPE[index][3]}</td>
			</tr>`
		})
		
		if($('#table-body').children().length > 0){
			$('#table-body').children().remove();
		} 
		$('#table-body').append(htmlStrike);

	}

</script>
</body>
</html>