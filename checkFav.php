<?php
session_start();
include_once "pdoAllUsers.php";
$username = $_SESSION['user_name'];



    if(isset($_POST['check']))
    {
        $sqlf = "SELECT user_id from users where user_name = '$username';";
        $stmtf = $pdo->query($sqlf);
        $user_id = $stmtf->fetchColumn();

    	$imdbID = $_POST['imdbID'];
        //check if this imdbID already exist
            $sql = "SELECT * from favourites where user_id = $user_id AND imdbID = '$imdbID'";
                $result = $pdo->prepare($sql);
                $result->execute();
            if($result->rowCount()>0)
                {
                  echo "yes";
                }
            else
                {
                echo "no";

                }
    	
    }
    

?>