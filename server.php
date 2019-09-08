<?php
session_start();
include_once "pdoAllUsers.php";

    if(isset($_POST['done']))
    {

    	$name = $_POST['username'];
    	$comment = $_POST['comment'];

    	$sql = "INSERT INTO comments (name,comment) VALUES (:title, :description)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':title' => $name,
                    ':description' => $comment
                ));
    }
    
    if(isset($_POST['display']))
    {
    	$sqls = "SELECT * from comments";
        $stmt = $pdo->query($sqls);
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        	?>
        	<div id="comment_box">
        		<p><?php echo $row['name']?></p> 
        		<p><?php echo $row['comment']?></p>
        	</div>
            <?php       
    	}
    }
?>