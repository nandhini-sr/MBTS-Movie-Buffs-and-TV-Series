<?php
session_start();
include_once "pdoAllUsers.php";
$username = $_SESSION['user_name'];



    if(isset($_POST['fav']))
    {
        $sqlf = "SELECT user_id from users where user_name = '$username';";
        $stmtf = $pdo->query($sqlf);
        $user_id = $stmtf->fetchColumn();

    	$imdbID = $_POST['imdbID'];
        $movie_title = $_POST['movie_name'];
        //check if this imdbID already exist
            $sql = "SELECT * from favourites where user_id = $user_id AND imdbID = '$imdbID'";
                $result = $pdo->prepare($sql);
                $result->execute();
            if($result->rowCount()>0)
                {
                  //do nothing
                }
            else
            {
                $sql = "INSERT INTO favourites (user_id,imdbID) VALUES (:user, :imdb)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':user' => $user_id,
                    ':imdb' => $imdbID
                ));

                $now_date = date('Y-m-d');
                $now_time = date('h:i:sa');

                $sqla = "INSERT INTO activity_log (user_id,mark_as,imdbID,movie_name,date_mark,time_mark) VALUES (:user,'favourite',:imdb,:movie, '$now_date', '$now_time')";
                $stmta = $pdo->prepare($sqla);
                $stmta->execute(array(
                    ':user' => $user_id,
                    ':imdb' => $imdbID,
                    ':movie' => $movie_title
                ));
            }
    	
    }
    
    if(isset($_POST['display']))
    {
        $sqlf = "SELECT user_id from users where user_name = '$username';";
        $stmtf = $pdo->query($sqlf);
        $user_id = $stmtf->fetchColumn();

    	$sqls = "SELECT * from favourites where user_id = '$user_id' ";
        $stmt = $pdo->query($sqls);
        $ids = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $ids[] = $row['imdbID'];   
    	}
        //print_r($ids);
        echo json_encode($ids);
    }
?>