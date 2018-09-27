<?php

require_once('../includes/config.php');
  $session_info      = $_SESSION['user_session_info'];
  $UserName          = $session_info['user_name'];
  $userEmailAddress  = $session_info['user_email_address'];
  $userStatus        = $session_info['status']; 
  $intUserId         = $session_info['user_id'];

  if($_POST['id']){
      $id = $_POST['id'];
      $sql = "UPDATE `user_registration` SET status = '".$_POST['status']."' WHERE user_id =".$id;
      $result_3 = mysqli_query($connection, $sql);
      if($result_3){
        $success_msg = '<div class="alert alert-success">
                            <strong>Success!</strong> User has been Authorized successfully.
                        </div>';
      }else{
         $err_msg = '<div class="alert alert-danger" role="alert">
                        <strong>Opss!</strong> User has not authorized..
                    </div>';
      }
    }     
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Authorization</title>
</head>
<body>
     <div id="flash-msg">
          <p> <?php if(isset($err_msg)) { echo $err_msg; } 
              if(isset($success_msg)) { echo $success_msg; 
            } ?>    
          </p>
      </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script type="text/javascript">
          $(document).ready(function(){
              $("#flash-msg").delay(3000).fadeOut("slow");
          });
 </script>     
</body>
</html>