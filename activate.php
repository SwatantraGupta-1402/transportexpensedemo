<?php
error_reporting(0);
include('includes/config.php');
session_start();
  $session_info = $_SESSION['user_session_info'];
  //$strUserName = $session_info['candidate_user_name'];
  $strUserEmailAddress = $session_info['user_email_address'];
  $intUserId = $session_info['user_id'];
  echo $id = $_GET['last_id'];
  
  echo $sql = "SELECT * FROM user_registration WHERE user_id =".$id; 
  	
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
      if ($row['is_active'] == "Active") {
        $err_msg = '<div class="alert alert-danger" align="center">
                            <strong>Ooops!</strong> Your account has been already activated.
                        </div>.';
        //echo "info";
      } else {
        $sql_update = "UPDATE `user_registration` SET  `is_active` =  'Active' WHERE `user_id` = '".$id."'";
        $result_update = mysqli_query($connection, $sql_update);
        if($result_update){
        	 $success_msg = '<div class="alert alert-success"align="center">
                            <strong>Success!</strong> Your account has been activated successfully.
                        </div>.';
        //$msgType = "success";
    	}
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>BTL | User Activation Page</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body background="avatar/index4.jpg" style="width:500px;height:200px;" >
	<br>
  <div class="container">
  	<div id="flash-msg">
          <p> <?php if(isset($err_msg)) { echo $err_msg; } 
              if(isset($success_msg)) { echo $success_msg; 
            } ?>    
          </p>
        </div>

  <h2 style="color:lightgray" align="center">Welcome! BTL Pramotions Organizations.</h2>
  <div class="alert alert-success" align="center">
    <strong >Thank You for registering with BTL Pramotions Pvt. Ltd. !</strong>
  </div>
</div>
</body>
</html>