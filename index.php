<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="includes/style.css">
<script src='includes/jquery-3.3.1.min.js'></script>
<script src='includes/canvasjs.min.js'> </script>
<script type="text/javascript">
function showResults(obj){
	$.ajax({
			url: 'classes/controllers/interactions.php',
			type: 'GET',
			dataType: 'json',
			data: obj,
		}).done(function(users) {
			$('#results').html("<div id='chartContainer' style='height: 370px; width: 100%;'></div>");		
			
			var chart = new CanvasJS.Chart("chartContainer", {
				theme: "light1",
				animationEnabled: true,		
				title:{text: "Usuários Influentes (Número de interações)"},
				data: [{type: "column"}]
			});
		 
			var datas = [];

			$.each(users, function(users, user){
				datas.push({'label': user.name, 'y': user.quantity});
			})

			chart.options.data[0] = {'dataPoints': datas};
			chart.render();
		}).fail(function() {
			console.log("error");
	})
}

$(document).ready(function() {
	showResults({'setup': 'user'});
})
</script>
</head>
<body>
	<div id='results'></div>
	<div id='filtros'>
		<h2>Filtrar por:</h2>
		<p><a href='#' onclick="showResults({'setup': 'brand'})">Marca</a></p>
		<p style="padding: 0 10px;"><a href='#' onclick="showResults({'setup': 'user'})">Usuários</a></p>
	</div>
</body>
</html>