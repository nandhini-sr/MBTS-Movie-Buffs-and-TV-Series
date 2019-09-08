<?php
session_start();
include_once "pdoAllUsers.php";
$username = $_SESSION['user_name'];


    if(isset($_POST['activity']))
    {
        $sqlf = "SELECT user_id from users where user_name = '$username';";
        $stmtf = $pdo->query($sqlf);
        $user_id = $stmtf->fetchColumn();

        $sqls = "SELECT * from activity_log where user_id = '$user_id' ";
        $stmt = $pdo->query($sqls);
        $ids = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $ids[] = array(
                'imdbID'=>$row['imdbID'],
                'mark_as'=>$row['mark_as'], 
                'movie_name'=>$row['movie_name'],
                'date'=>$row['date_mark'],
                'time'=>$row['time_mark'] 

            ); 
        }
        echo json_encode($ids);
    }
?>