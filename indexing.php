<!DOCTYPE html>
<html>
<head>
	<title>Ajax insert and retrieve</title>
	<style type="text/css">
		body
		{
			background:#fafcfc;
		}
		#wrapper
		{
			width:50%;
			height:auto;
			margin:10px auto;
			background:white;
			border: 1px solid #cbcbcb;
		}
		#comment_input_form
		{
			width:50%;
			margin:100px auto;
			background:#fafcfc;
			padding:20px;
		}
		#comment_input_form li
		{
			list-style-type: none;
			margin:5px;
		}
		input[type=text], textarea
		{
			width: 80%;
		}
		#comment_box
		{
			margin-top:10px;
			padding:5px;
			border:1px solid #cbcbcb;
		}
	</style>
</head>
<body>
<div id="wrapper">
	<div id="display"></div>
	<div id="comment_input_form">
		<li>Name:</li>
		<li><input type="text" id="name"></li>
		<li>Comment: </li>
		<li><textarea id="comment"></textarea></li>
		<li><input type="submit"  id="save" value="POST"></li>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		displayFromDatabase();
		$('#save').click(function(){
			var name = $('#name').val();
			var comment = $('#comment').val();
			$.ajax({
				url: "server.php",
				type: "post",
				async: true,
				data:{
					"done":1,
					"username":name,
					"comment":comment
				},
				success: function(data)
				{
					displayFromDatabase();
					$('#name').val('');
					$('#comment').val('');

				}
			});
		});
	});

	function displayFromDatabase()
	{
		$.ajax({
			url:"server.php",
			type:"POST",
			async:false,
			data:
			{
				"display":1
			},
			success: function(data)
			{
				$("#display").html(data);
			}
		});
	}




</script>
</body>
</html>