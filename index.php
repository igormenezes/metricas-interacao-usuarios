<!DOCTYPE HTML>
<html>
<head>
<script src='includes/jquery-3.3.1.min.js'></script>
<script src='includes/canvasjs.min.js'> </script>
<script type="text/javascript">
$(document).ready(function() {
	$.ajax({
		url: 'classes/controllers/interactions.php',
		type: 'GET',
		dataType: 'json',
		data: {'users': true},
	}).done(function(users) {
		$('body').html("<div id='chartContainer' style='height: 370px; width: 100%;'></div>");		
		
		var chart = new CanvasJS.Chart("chartContainer", {
			theme: "light1",
			animationEnabled: true,		
			title:{text: "Usuários Influentes (Número de interações)"},
			data: [{type: "column"}]
		});
	 
		var datas = [];

		console.log(users);

		$.each(users, function(users, user){
			datas.push({'label': user.name, 'y': user.quantity});
		})

		chart.options.data[0] = {'dataPoints': datas};
		chart.render();
	}).fail(function() {
		console.log("error");
	})
})
</script>
</head>
<body>
</body>
</html>