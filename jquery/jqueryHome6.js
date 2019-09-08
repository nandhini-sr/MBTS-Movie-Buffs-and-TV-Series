$(document).ready(function(){
	showLatestMovies();
	displayFromDatabase();
	displayFromWatchLater();
	displayFromActivity();
$('#searchForm').on('submit',(e)=>{
	//console.log($('#searchText').val());
	let searchText = $('#searchText').val();
	getMovies(searchText);
	e.preventDefault();
	});
$('#searchimdb').on('submit',(e)=>{
	//console.log($('#searchText').val());
	let searchimdbID = $('#searchimdbID').val();
	getMoviesIMDB(searchimdbID);
	e.preventDefault();
	});

});


function getMovies(searchText)
{
	$.getJSON( 'http://www.omdbapi.com/?apikey=...'+searchText)
	.then((response)=>{
		console.log(response);
		$('#search_que').show();
		let movies = response.Search;
		let output = '';
		$.each(movies, (index,movie) => {
			    if(movie.Poster!="N/A")
			    {
			    	output += `
					<div class="col-md-2">
					<div class="well text-center" style="height:350px;">
					<button type="button" class="btn" data-toggle="modal" data-target="#basicExampleModal" onmouseover="details('${movie.imdbID}')">
					<img src="${movie.Poster}" style="height:250px;"></button>
					<p style="color:white">${movie.Title}</p>
					</div>
					</div>
					`;
			    }
		});

		$('#movies').html(output);
	})
	.catch((err)=>{
		console.log('error'+err);
	});
	//console.log(searchText);
}

function getMoviesIMDB(searchimdbID)
{
	$.getJSON( 'http://www.omdbapi.com/?apikey=...'+searchimdbID)
	.then((response)=>{
		console.log(response);
		$('#search_que').show();
		let output = '';
			output += `
			<div class="col-md-2">
			<div class="well text-center" style="height:300px;">
			<button type="button" class="btn" data-toggle="modal" data-target="#basicExampleModal" onmouseover="details('${response.imdbID}')">
			<img src="${response.Poster}" style="height:250px;"></button>
			<p style="color:white">${response.Title}</p>
			</div>
			</div>
				`;

		$('#movies').html(output);
	})
	.catch((err)=>{
		console.log('error'+err);
	});
	//console.log(searchText);
}

function showLatestMovies()
{
	var latest = ['tt4154796','tt7131622','tt2283336','tt0448115','tt1979376','tt6565702']; 
	let output;
    for(var index=0; index<6; index++)
    {
    	$.getJSON( 'http://www.omdbapi.com/?apikey=...'+latest[index])
		.then((response)=>{
		output = `
			<div class="col-md-2">
			<div class="well text-center" style="height:300px;" >
			<button type="button" class="btn" data-toggle="modal" data-target="#basicExampleModal" onclick="details('${response.imdbID}')">
			<img src="${response.Poster}" style="height:250px;"></button>
			<p style="color:white">${response.Title}</p>
			</div>
			</div>
			`;
			$('#latest').append(output); 
	})
	.catch((err)=>{
		console.log(err);
	});
    }
    
}

function details(id)
{
	console.log(id);

	$.getJSON( 'http://www.omdbapi.com/?apikey=...'+id)
	.then((response)=>{
		let movie = response;
		let headerModal = `${movie.Title}`;
		let head = `${movie.Title}`+ ' offical trailer';
           console.log(head);
		var request = gapi.client.youtube.search.list({
			part:"snippet",
			type:"video",
			q: head,
			maxResults: 1,
			order: "viewCount",
			publishedAfter: "2015-01-01T00:00:00Z"
		});
		//execute the request
		request.execute(function(response){
			console.log(response);
			var results = response.result;
			$("#results").html("");
			$.each(results.items , function(index, item){
				$.get("item.html" , function(data){
					$("#results").html(convert(data, [{"title":item.snippet.title, "videoid":item.id.videoId}]));
				});
				//$('#results').append(item.id.videoId+" "+item.snippet.title+"<br>");
			});

			resetVideoHeight();
		});
	
	$(window).on("resize",resetVideoHeight);

		//this is from OMDB
		//let movie = response;
		//let head = `${movie.Title}`;
		let output = `
			<div class="row">
			<div class="col-md-1"></div>
				<div class="col-md-2">
					<img src="${movie.Poster}" class="thumbnail" style="height:250px;width:200%;">
				</div>
				<div class="col-md-2"></div>
		        <div class="col-md-6">
					<ul class="list-group">
					<li class="list-group-item"><strong>Genre:&nbsp</strong>${movie.Genre}</li>
					<li class="list-group-item"><strong>Released:&nbsp</strong>${movie.Released}</li>
					<li class="list-group-item"><strong>Rated:&nbsp</strong>${movie.Rated}</li>
					<li class="list-group-item"><strong>IMDB Rating:&nbsp</strong>${movie.imdbRating}</li>
					<li class="list-group-item"><strong>Director:&nbsp</strong>${movie.Director}</li>
					</ul>				
				</div>
			<div class="row">
				<div class="col-md-1">
				</div>
			    <div class="col-md-10">
			        <br>
					<h5>Plot</h5>
					${movie.Plot}
					<hr>
				</div>
			</div>
			<div class="col-md-4">
				</div>
			<div class="col-md-4">
			Fav: <i id="favBtn" onclick="myFunction(this,'${movie.imdbID}','${movie.Title}')" class="fa fa-thumbs-up" style="font-size:40px"></i>
		    &nbsp&nbspWatched: <i id="watBtn" onclick="watchYes(this,'${movie.imdbID}','${movie.Title}')" class="fa fa-check-square" style="font-size:40px"></i>
			</div>`;
          let btnWatch = `<div class="row">
          <div class="col-md-4"></div>
 	 		<div class="col-md-4">
            <button type="button" class="btn btn-success" onclick="addWatch(this,'${movie.imdbID}','${movie.Title}')">Add to Watch Later</button>
    		</div>
    	</div>`;

    	$('#btnWatchLater').html(btnWatch);
		$('#exampleModalLabel').html(headerModal);
		$('#details').html(output);
		let imdbID = `${movie.imdbID}`;
		checkfavColor(imdbID);
		checkWatched(imdbID);
	})
	.catch((err)=>{
		console.log(err);
	});
}

function checkfavColor(id)
{
	console.log('called');
	var imdb = id;
	$.ajax({
			url: "checkFav.php",
			type: "post",
			async: true,
			data:{
				"check":1,
				"imdbID":imdb,
			},
			success: function(data)
			{
				if(data=='yes')
				{
					//console.log(data);
					//console.log($('#favBtn'));
					$("#favBtn").css("color","blue");
				}
				//displayFromActivity();
				//$('#name').val('');
			}
		});
}

function checkWatched(id)
{
	var imdb = id;
	$.ajax({
			url: "checkWat.php",
			type: "post",
			async: true,
			data:{
				"check":1,
				"imdbID":imdb,
			},
			success: function(data)
			{
				if(data=='yes')
				{
					//console.log(data);
					//console.log($('#favBtn'));
					$("#watBtn").css("color","#ff9800");
				}
				//displayFromActivity();
				//$('#name').val('');
			}
		});
}

function convert(e,t)
{
	res=e;
	for(var n=0; n<t.length; n++)
	{
		res = res.replace(/\{\{(.*?)\}\}/g, function(e,r){
			return t[n][r]
		})
	}

	return res
}

function resetVideoHeight()
{
	$("#results").css("width",$("#results").width()* 9/16);
}


function init()
{
	gapi.client.setApiKey('...');
	gapi.client.load('youtube','v3',function(){
		//youtube api is ready
	});
}

function watchYes(x,imdbID,movie_name) {
  //x.classList.toggle("fa-thumbs-up");
  x.style.color="#ff9800";
  //x.fadeOut(10000);
  //console.log('imdbID inside:',imdbID);
  var imdb = imdbID;
  var mov_name = movie_name;
	$.ajax({
			url: "watch.php",
			type: "post",
			async: true,
			data:{
				"watch":1,
				"imdbID":imdb,
				"movie_name":mov_name
			},
			success: function(data)
			{
				displayFromActivity();
				//$('#name').val('');
			}

});
}

function myFunction(x,imdbID,movie_name) {
  //x.classList.toggle("fa-thumbs-up");
  x.style.color="blue";
  //x.fadeOut(10000);
  //console.log('imdbID inside:',imdbID);
  var imdb = imdbID;
  var mov_name = movie_name;
	$.ajax({
			url: "fav.php",
			type: "post",
			async: true,
			data:{
				"fav":1,
				"imdbID":imdb,
				"movie_name":mov_name
			},
			success: function(data)
			{
				displayFromDatabase();
				displayFromActivity();
				//$('#name').val('');

			}

});
}

function displayFromDatabase()
	{
		$.ajax({
			url:"fav.php",
			type:"POST",
			async:false,
			data:
			{
				"display":1
			},
			success: function(data)
			{
				
				//console.log(JSON.parse(data)[0]);
				$('#fav').html("");
				$.each(JSON.parse(data), (index,wLMovie) => {
					//console.log(wLMovie);
					$.getJSON( 'http://www.omdbapi.com/?apikey=...'+wLMovie)
					.then((response)=>{
					let outRes = `
						<div class="col-md-2">
						<div class="well text-center" style="height:300px;" >
						<button type="button" class="btn" data-toggle="modal" data-target="#basicExampleModal" onmouseover="details('${response.imdbID}')">
						<img src="${response.Poster}" style="height:250px;"></button>
						<p style="color:white">${response.Title}</p>
						</div>
						</div>
						`; 
						$('#fav').append(outRes);
						})
						.catch((err)=>{
							console.log(err);
						});
				});
				

			}
		});
	}

	function addWatch(x,imdbID,movie_name) {
  //x.classList.toggle("fa-thumbs-up");
  //x.style.color="blue";
  //x.fadeOut(10000);
 // console.log('imdbID inside:',imdbID);
  var imdb = imdbID;
  var mov_name = movie_name;
	$.ajax({
			url: "watchLater.php",
			type: "post",
			async: true,
			data:{
				"watchLater":1,
				"imdbID":imdb,
				"movie_name":mov_name
			},
			success: function(data)
			{
				displayFromWatchLater();
				displayFromActivity();

			}

});
}

function displayFromWatchLater()
	{
		$.ajax({
			url:"watchLater.php",
			type:"POST",
			async:false,
			data:
			{
				"display":1
			},
			success: function(data)
			{
				
				//console.log(JSON.parse(data)[0]);
				$('#watchLater').html("");
				$.each(JSON.parse(data), (index,wLMovie) => {
					//console.log(wLMovie);
					$.getJSON( 'http://www.omdbapi.com/?....'+wLMovie)
					.then((response)=>{
					let outRes = `
						<div class="col-md-2">
						<div class="well text-center" style="height:300px;" >
						<button type="button" class="btn" data-toggle="modal" data-target="#basicExampleModal" onmouseover="details('${response.imdbID}')">
						<img src="${response.Poster}" style="height:250px;"></button>
						<p style="color:white">${response.Title}</p>
						</div>
						</div>
						`; 
						$('#watchLater').append(outRes);
						})
						.catch((err)=>{
							console.log(err);
						});
				});
				

			}
		});
	}

	function displayFromActivity()
	{
		$.ajax({
			url:"activity.php",
			type:"POST",
			async:false,
			data:
			{
				"activity":1
			},
			success: function(data)
			{
				
				console.log(JSON.parse(data));
				$('#activity').html("");
				$.each(JSON.parse(data), (index,activity) => {
					let out = `<p style="color:white">[${activity.date}] [${activity.time}] => [${activity.mark_as}] - ${activity.movie_name}</p>`;
					$('#activity').append(out);
				});
				

			}
		});
	}
