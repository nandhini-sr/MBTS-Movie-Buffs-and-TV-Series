$(document).ready(function(){
	showLatestMovies();
$('#searchForm').on('submit',(e)=>{
	//console.log($('#searchText').val());
	let searchText = $('#searchText').val();
	getMovies(searchText);
	e.preventDefault();
	});

});

function getMovies(searchText)
{
	alert('new');
	$.getJSON( 'http://www.omdbapi.com/?apikey=...')
	.then((response)=>{
		console.log(response.Search);
		let movies = response.Search;
		let output = '';
		$.each(movies, (index,movie) => {
			//if(${movies[index]['Poster']})
			//{
				output += `
				<div class="col-md-3">
				<div class="well text-center">
				<img src="${movies[index]['Poster']}">
				<h5 style="color:white">${movies[index]['Title']}</h5>
				<a onclick="movieSelected('${movies[index]['imdbID']}')" class="btn btn-primary" href="#">Movie Details</a>
				</div>
				</div>
				`;
			//}
		});

		$('#movies').html(output);
	})
	.catch((err)=>{
		console.log(err);
	});
	//console.log(searchText);
}

function showLatestMovies()
{
	$.getJSON( 'http://www.omdbapi.com/?apikey=...')
	.then((response)=>{
		console.log(response);
		/*let movies = response.Search;
		let output = '';
		$.each(movies, (index,movie) => {
			//if(${movies[index]['Poster']})
			//{
				output += `
				<div class="col-md-3">
				<div class="well text-center">
				<img src="${movies[index]['Poster']}">
				<h5 style="color:white">${movies[index]['Title']}</h5>
				<a onclick="movieSelected('${movies[index]['imdbID']}')" class="btn btn-primary" href="#">Movie Details</a>
				</div>
				</div>
				`;
			//}
		});

		$('#movies').html(output);*/
	})
	.catch((err)=>{
		console.log(err);
	});
}
