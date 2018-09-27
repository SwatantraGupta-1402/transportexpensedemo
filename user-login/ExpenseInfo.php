<?php

require_once('../includes/config.php');
  $session_info      = $_SESSION['user_session_info'];
  $UserName          = $session_info['full_name'];
  $userEmailAddress  = $session_info['user_email_address'];
  $intUserId         = $session_info['user_id'];

  date_default_timezone_set('Asia/Kolkata');

  if(isset($_POST["exp_date"]) && $_POST["user_id"]){
    $msg = '';
    $isError = false;
    $isRedirect = false;
    $sql_exp_form = "SELECT * FROM `expense_sheet_form` WHERE user_id = '".$_POST['user_id']."' AND created_date = '".$_POST['exp_date']."'";
    $resquery = mysqli_query($connection,$sql_exp_form);
    
    if(mysqli_num_rows($resquery) > 0){      
      $msg = "Allowed";
      $isError = false;
      $isRedirect = true;
    }else{
      $currDate = date("y-m-d");
      $exp_date = date('y-m-d',strtotime($_POST["exp_date"]));
      $date= date_create($currDate."");
      $date1= date_create($_POST["exp_date"]);
      $diff = date_diff($date, $date1);
      $allow_date = -2;
      $diff_date = (int)$diff->format("%R%a");
      
      if($diff_date <= 0 && $diff_date > $allow_date){
          $msg = "Allowed";
          $isError = false;
          $isRedirect = false;
      }else{
        $msg = "Not allowed";
        $isError = true;
        $isRedirect = false;
      }
    }

    $resArr = array();
    $resArr['msg'] = $msg;
    $resArr['isError'] = $isError;
    $resArr['isRedirect'] = $isRedirect;
    echo json_encode($resArr);
  }

  if(isset($_POST["expFormId"])){
    if (strpos($_POST['expFormId'], 'deleteother') !== false) {
        $delId = explode("-", $_POST['expFormId']);
        $sql = "DELETE FROM others_expenses WHERE other_exp_id = ".$delId[1];
        $result = mysqli_query($connection, $sql);
        echo json_encode($result);
    }else if (strpos($_POST['expFormId'], 'deletetada') !== false) {
        $delId = explode("-", $_POST['expFormId']);
        $sql = "DELETE FROM team_ta_da_advance_expense WHERE team_ta_da_exp_id = ".$delId[1];
        $result = mysqli_query($connection, $sql);
        echo json_encode($result);
    }else{
      $expFormId = $_POST['expFormId'];
      $isOther = $_POST['isOther'] === 'true'? true: false;
      $sql_query_da;
      if($isOther == true){
      	$sql_query_da = "SELECT other_exp_id,expense_desc,others_expense FROM `others_expenses` WHERE expense_form_id =".$expFormId;
      }else{
      	$sql_query_da = "SELECT tda.candidate_name,tda.team_da FROM team_ta_da_advance_expense as tda WHERE tda.expense_form_id=".$expFormId;
      }
      
      $result_user_da = mysqli_query($connection, $sql_query_da);
      
      
      $retObj = array();
      while ($row = mysqli_fetch_array($result_user_da)) {
      	$arr = array();
      	if($isOther){
      		$arr['expense_desc'] = $row['expense_desc'];
	    	$arr['others_expense'] = $row['others_expense'];
      	}else{
      		$arr['candidate_name'] = $row['candidate_name'];
	    	$arr['team_da'] = $row['team_da'];
      	}
	    
	    array_push($retObj, $arr);
	  }
	
  	echo json_encode($retObj);
    }  
    } 
?>