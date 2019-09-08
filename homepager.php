<?php
    session_start();
    print_r($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
	<title>MovieInfo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.homepage1.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	  <br>
      <?php
        if ( isset($_SESSION["user_name"]) ) 
         {
           //echo($_SESSION["user_name"]." | ");
           echo('<p style="color:white; display:inline; font-size:150%;float:right; margin-top: -10px; margin-right: 30px">'.$_SESSION["user_name"].' |</p> ');
         }
       ?>
       <form action="logout.inc.php" method="POST" style="float:right; margin-top: -10px; margin-right: 30px">
       <button type="submit" class="btn btn-warning" name="LogOut" style="display:inline">Log out</button>
       </form>
       <br>
       <hr>
	
	<div class="container">
		<div class="jumbotron">
			<h3 class="text-center">MBTS - Movie Buffs and TV series</h3>
			<form id="searchForm">
				<input type="text" class="form-control" id="searchText" placeholder="Search by Title">
			</form>
			<form id="searchimdb">	
				<input type="text" class="form-control" id="searchimdbID" placeholder=" OR Search by imdbID">
			</form>
			
		</div>
	</div>
    
	<div class="container">
		<h3 style="color:white; display:none" id="search_que">Search Queries:<hr></h3>
		<div id="movies" class="row"></div>
	</div>
	<br>
	<div class="container">
		<h3 style="color:white">Latest Movies(2019)<hr></h3>
		<div id="latest" class="row">
		</div>
	</div>
	<br><br>
	<div class="container">
		<h3 style="color:white">Favorites<hr></h3>
		<div id="fav" class="row">
		</div>
	</div>
	<br>
	<div class="container">
		<h3 style="color:white">Watch Later List<hr></h3>
		<div id="watchLater" class="row">
		</div>
	</div>
	<br>
	<div class="container">
		<h3 style="color:white">Activity Log<hr></h3>
		<div id="activity">
		</div>
	</div>



<!-- Modal -->
<div class="modal fade" id="basicExampleModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:200%; margin-left:-200px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
      </div>
      <div class="modal-body" id="details">
      </div>
      <div class="row">
      	<div class="col-md-12">
      <div class="modal-body" id="results">
      	</div>
      </div>
 	 </div>
 	 <div class="modal-body" id="btnWatchLater">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>  
    <script type="text/javascript" src="jquery/jqueryHome4.js"></script>
	<script src="jquery/app.js"></script>
	<script src="https://apis.google.com/js/client.js?onload=init"></script>
</body>
</html>