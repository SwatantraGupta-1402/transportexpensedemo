<?php
    error_reporting(0);
    session_start();
     include('includes/config.php');

  /* Login Page Script Start Here*/
    date_default_timezone_set('Asia/Kolkata');
     if(isset($_POST['login'])){
         if (empty($_POST['user_name']) || empty($_POST['password'])) {
            $err_msg = '<div class="alert alert-danger" role="alert">
                                <strong class="fontfamily">Opss!</strong> User Name and Password should not match..
                            </div>';
            }else{
                $_SESSION['user_name'] = $_POST['user_name'];
                $_SESSION['user_password'] = ($_POST['password']);
                $_SESSION['last_time'] = time();
              
                       $user_name = $_POST['user_name'];
                       $password = $_POST['password'];
                 
                    // Select Query For Fetching Data from Database
                    $sql_query_1 = "SELECT * FROM user_registration  WHERE user_name = '".$_SESSION['user_name']."' AND user_password = '".$_SESSION['user_password']."' AND status = 'Activate' ";
                   
                    $result_1 = mysqli_query($connection,$sql_query_1);
                   
                    $row_1 = mysqli_fetch_assoc($result_1);
                        if($user_name == $row_1['user_name'] && $password == $row_1['user_password']) {
                           
                          $_SESSION['user_session_info'] = array();
                          $_SESSION['user_session_info']["user_name"]           = $row_1["user_name"];
                          $_SESSION['user_session_info']["full_name"]           = $row_1["full_name"];
                          $_SESSION['user_session_info']["user_email_address"]  = $row_1["user_email_address"];
                          $_SESSION['user_session_info']["user_type"]           = $row_1["user_type"];
                          $_SESSION['user_session_info']["user_id"]             = $row_1["user_id"];
                          $_SESSION['user_session_info']["status"]              = $row_1["status"];
                          $_SESSION['user_session_info']["user_password"]       = $row_1["user_password"];
                          //print_r($_SESSION['user_session_info']); die;
                            if($row_1['user_type'] == 'Admin'){
                              $success_msg = '<div class="alert alert-success">
                                    <strong class="fontfamily">Success!</strong> User has been Logged in successfully.
                                </div>';
                                header('Location: admin-login/admin_dashboard');
                               }else if($row_1['user_type'] == 'user'){
                                 $success_msg = '<div class="alert alert-success">
                                    <strong class="fontfamily">Success!</strong> User has been Logged in successfully.
                                </div>';
                                header('Location: user-login/'); 
                             }else{
                            $err_msg = '<div class="alert alert-danger" role="alert">
                                <strong class="fontfamily">Opss!</strong> User Name and Password should not match..
                            </div>';
                        }
        
                    }
                mysqli_close($connection);
                }
            }
    /* Login Page Script End Here*/

     $sql_vehicle = "SELECT * FROM vehicle_type";
     $result_vehicle = mysqli_query($connection, $sql_vehicle);
     
     include('phpmailer/class.phpmailer.php');

     $sql_query = "SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC";
     $result_1 = mysqli_query($connection, $sql_query);

      $strFullNameError = "";
      $strUserNameError = "";
      $strEmailError = "";
      $IntMobileNumberError = "";
      $strUserPasswordError = "";
      $strConfirmUserPasswordError = "";
      $strAddressError = "";
      $strCountryError = "";
      $strStateError = "";
      $strCityError = "";
      $intZipcodeError = "";
      $strPartyNameError = "";
      $strProjectNameError = "";
      $strVehicleRegNoError = "";
      $strVehicleTypeError = "";

      //$strProfileImageError = "";

      if(isset($_POST['submit'])){

        if (empty($_POST["full_name"])) {
          $strFullNameError = "Full Name is required";
          } else {
            $strFullName = validateInput($_POST["full_name"]);
            // check name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$strFullName)) {
              $strFullNameError = "Only letters and white space allowed";
            }
          }
          if (empty($_POST["user_name"])) {
          $strUserNameError = "User Name is required";
          } else {
            $strUserName = validateInput($_POST["user_name"]);
            // check name only contains letters and whitespace
            if (!preg_match("/^[A-Za-z ]{5,31}$/",$strUserName)) {
              $strUserNameError = "Only letters and white space allowed";
            }
          }
        if (empty($_POST["user_email_address"])) {
            $strEmailError = "Email is required";
          } else {
            $strUserEmailAddress = validateInput($_POST["user_email_address"]);
            // check if e-mail address syntax is valid or not
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$strUserEmailAddress)) {
              $strEmailError = "Invalid email format";
            }
          }
        if (empty($_POST["user_mobile_no"])) {
            $IntMobileNumberError = "Mobile Number is required";
          
          } else {
            $intMobileNumber = validateInput($_POST["user_mobile_no"]);
            // check if Mobile No syntax is valid or not
            if (!preg_match("/^[789][0-9]{9}$/",$intMobileNumber)) {
              $IntMobileNumberError = "Invalid Mobile Number format";
            }
          }
        
        if (empty($_POST["password"])) {
            $strUserPasswordError = "User Password is required";
          } else {
            $strUserPassword = validateInput($_POST["password"]);
            // check Password only contains letters and whitespace
            if (!preg_match("/[!@#$%*a-zA-Z0-9]{8,}/",$strUserPassword)) {
              $strUserPasswordError = "Only Alpha Numeric Letters allowed";
            }
          }
        if (empty($_POST["confirm_password"])) {
            $strConfirmUserPasswordError = "Confirm User Password is required";
          
          } else {
            $strUserConfirmPassword = validateInput($_POST["confirm_password"]);
            // check if Mobile No syntax is valid or not
            if (!preg_match("/[!@#$%*a-zA-Z0-9]{8,}/",$strUserConfirmPassword)) {
              $strConfirmUserPasswordError = "Only Alpha Numeric Letters allowed";
            }
          }
       
        if(empty($_POST["address"])) {
          $strAddressError = "Current Location is required";
          }
        
        if(empty($_POST["country"])) {
          $strCountryError = "Country Selection is required";
          }

        if(empty($_POST["state"])) {
          $strStateError = "State selection is required";
          }
        if(empty($_POST["city"])) {
          $strCityError = "City selection is required";
          }
           if(empty($_POST["party_name"])) {
          $strPartyNameError = "Party Name is required";
          }
           if(empty($_POST["project_name"])) {
          $strProjectNameError = "Project Name is required";
          }
          if(empty($_POST["vehicle_reg"])) {
          $strVehicleRegNoError = "Vehicle Registration No. is required";
          }
          if(empty($_POST["vehicle_type"])) {
          $strVehicleTypeError = "Vehicle Type is required";
          }
        if (empty($_POST["zipcode"])) {
            $intZipcodeError = "Zipcode is required"; 
          } else {
            $intZipcode = validateInput($_POST["zipcode"]);
            // check if Mobile No syntax is valid or not
            if (!preg_match("/^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/",$intZipcode)) {
              $intZipcodeError = "Invalid Zipcode format";
            }
          }
        // if(empty($_POST["profile"])) {
        //   $strProfileImageError = "Profile Image is required";
        //   }
        
        if(''!=$strFullNameError || ''!=$strEmailError || ''!=$IntMobileNumberError || ''!=$strUserPasswordError || ''!=$strConfirmUserPasswordError || ''!=$strAddressError || ''!=$strCountryError || ''!=$strStateError || ''!=$strCityError || ''!=$intZipcodeError || ''!=$strVehicleRegNoError || ''!=$strVehicleTypeError || ''!=$strPartyNameError || ''!=$strProjectNameError || ''!=$strUserNameError) {

            $err_msg = '<div class="alert alert-danger">
                            <strong class="fontfamily">Oopss!</strong> Please fill the below fields.
                        </div>';
            
        } else {
          
         if(isset($_POST['submit'])){
            
            $intAdminUserId           = 1; 
            $strFullName              = $_POST['full_name'];
            $strUserName              = $_POST['user_name'];
            $user_type                = "user";
            $strUserEmailAddress      = $_POST['user_email_address'];
            $strUserPassword          = $_POST['password'];
            $strUserConfirmPassword   = $_POST['confirm_password'];
            $intMobileNumber          = $_POST['user_mobile_no'];
            $strPartyName             = $_POST['party_name'];
            $strProjectName           = $_POST['project_name'];
            $strVehicleReg            = $_POST['vehicle_reg'];
            $strVehicleType           = $_POST['vehicle_type'];
            $strAddress               = $_POST['address'];
            $strCountry               = $_POST['country'];
            $strState                 = $_POST['state'];
            $strCity                  = $_POST['city'];
            $intZipcode               = $_POST['zipcode'];
            $created_by               = $_POST['full_name'];
            $created_date             = date("Y-m-d");
            $subject                  = "Sending HTML eMail using PHPMailer.";
              //$message    = "Hello $full_name, <br /><br /> This is HTML eMail Sent using PHPMailer. isn't it cool to send HTML email rather than plain text, it helps to improve your email marketing.";
            // Validation checking User Name and Email Address already exist
            if($strUserEmailAddress !='') {
              
              $add_query = "SELECT * FROM user_registration WHERE user_name = '$strUserName' OR user_email_address = '$strUserEmailAddress' OR vehicle_reg = '$strVehicleReg' AND status='Activate'";
                $result_2 = mysqli_query($connection, $add_query);
                //$results = mysqli_num_rows($connection, $add_result);
                //echo "Swatantra".$resul = mysqli_insert_id($connection);
                //print_r($array_row);
                if (mysqli_num_rows($result_2) != 0) {
                  $rows = mysqli_fetch_assoc($result_2);
                  if ($strUserName==$rows['user_name'])
                        {
                        $err_msg = '<div class="alert alert-danger" role="alert">
                            <strong class="fontfamily">Opss!</strong> User Name already exists.
                        </div>';
                        }
                        elseif($strUserEmailAddress==$rows['user_email_address'])
                        {
                            $err_msg = '<div class="alert alert-danger" role="alert">
                                <strong class="fontfamily">Opss!</strong> User Email Address already Exists.
                            </div>';
                        } 
                        elseif($strVehicleReg==$rows['vehicle_reg'])
                        {
                            $err_msg = '<div class="alert alert-danger" role="alert">
                                <strong class="fontfamily">Opss!</strong> This Vehicle already Registered.
                            </div>';
                        } 
                }
                elseif($strUserPassword != $strUserConfirmPassword){
                    $confirmpassmsg = '<p style="color:red;">Password does not match.</p>';

                // Validation checking User Name and Email Address already exist End Here
                }else {
                  // Query for Inserting data User Details

              // File Uploading Script Start Here
             
               if(isset($_POST['submit'])) {
                $name = $_FILES['profile']['name'];
                $size = $_FILES['profile']['size'];
                $type = $_FILES['profile']['type'];
                $tmp_name = $_FILES['profile']['tmp_name'];
                }
              
              $location = "upload_image/";
              $maxsize = 5120;
              if(isset($name) && !empty($name)){
                if($type != 'image/png' || $type != 'image/jpg' || $type != 'image/jpeg' && $size <= $maxsize){
                  if(move_uploaded_file($tmp_name, $location.$name)){
                    
                    $uploadsuccmsg =  '<p style="color:green;">file Uploaded Successfully..</p>';
                  }else{
                    $uploderrormsg = '<p style="color:red;">Failed to Upload</p>';
                  }
                }else{
                  $uploderrormsg = '<p style="color:red;">File should be png,jpg and jpeg & only 2 MB in size</p>';
                  //exit;
                }
              }
              // File Uploading Script End Here

            
        $query = "INSERT INTO `user_registration` 
              (user_type,
              vehicle_type_id,
              full_name,
              user_name,
              user_email_address,
              user_mobile_no,
              user_password,
              user_confirm_password,
              party_name,
              project_name,
              vehicle_reg,
              vehicle_type,
              user_address,
              country,
              state,
              city,
              zipcode,
              user_avatar,
              created_by,
              created_date) 
              VALUES 
              ('$user_type',
              (SELECT vehicle_type_id FROM vehicle_type WHERE vehicle_type='".$strVehicleType."'),
              '$strFullName',
              '$strUserName',
              '$strUserEmailAddress',
              '$intMobileNumber',
              '$strUserPassword',
              '$strUserConfirmPassword',
              '$strPartyName',
              '$strProjectName',
              '$strVehicleReg',
              '$strVehicleType',
              '$strAddress',
              '$strCountry',
              '$strState',
              '$strCity',
              '$intZipcode',
              '$location$name',
              '$created_by', 
              '$created_date')"; 
              $result = mysqli_query($connection, $query);
                  // Query for Inserting data User Details End Here
                 // Email Sending Script Start Here

              if($result){
                  
                //$lastID = mysqli_insert_id($connection);
                $password = $strUserPassword;
                   //echo $abc = base64_encode($lastID); die;
                  $site_url = "localhost/btlexpensedemo/";
                    $message = '<html><head><title>Email Verification Link</title></head><body>';
                    $message .= '<h3 style="color:gray;">Hello ' .$strFullName. ',</h3>';
                    $message .= '<label> You Have successfully Registered in BTL Pramotions Pvt. Ltd.  
                     Your User Name is ' . '<label style="color:black;">'. $strUserName. '</label>'. ' and Password is ' .' <label style="color:red;"> '. $password . ' </label> '.'</label>';
                    // $message .= '<p><a href="'.$site_url.'activate.php?id=' . $lastID . '"><button class="btn btn-success">CLICK TO ACTIVATE YOUR ACCOUNT</button></a>';
                    $message .= '<h3>Thanks & Regards,</h3>';
                    $message .= '<h2>BTL Pramotions Pvt. Ltd.</h2>';
                    $message .= '<h3>Narendra Katariya</h3>';
                    $message .= "</body></html>";
                   
                    // php mailer code starts
                    $mail = new PHPMailer(true);
                    $mail->IsSMTP();// telling the class to use SMTP

                    $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
                    $mail->SMTPAuth = true;                  // enable SMTP authentication
                    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
                    $mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
                    $mail->Port = 465;                   // set the SMTP port for the GMAIL server

                    $mail->Username = 'swatantra.gupta70@gmail.com'; 
                    $mail->Password = 'swatantra1402@';

                    $mail->SetFrom('swatantra.gupta70@gmail.com', 'Swatantra Gupta');
                    $mail->AddAddress($strUserEmailAddress);

                    $mail->Subject = trim("Email Verifcation - BTL Expense");
                    $mail->MsgHTML($message);
                  try { 
                   $mail->Send();
                   $msg = "An email has been sent for verfication.";
                       $msgType = "success";
                  }
                 //}
                 catch(phpmailerException $ex)
                 {
                  $msg = "<div class='alert alert-warning'>".$ex->errorMessage()."</div>";
                 }
              } 
              // Email Sending Script End Here
              if($result){
                    $success_msg = '<div class="alert alert-success">
                            <strong class="fontfamily">Success!</strong> User has been registered successfully.
                        </div>';
                    header('location:index.php');
                    //exit();
                  }else{
                    $err_msg = '<div class="alert alert-danger">
                            <strong class="fontfamily">Oopss!</strong> Something went wrong.
                        </div>';
                  }
              }
          }

      }//Closing Connection with Server     
        mysqli_close($connection);
    } 
  }// endIf
  function validateInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
 ?>
<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>BTL Expense | Login & Registration</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for " name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link rel="icon" type="image/png" sizes="16x16" href="avatar/favicon-small.png">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
        
        <style type="text/css">
          @import url(http://fonts.googleapis.com/css?family=Roboto);

/****** LOGIN MODAL ******/
.loginmodal-container {
  padding: 30px;
  max-width: 350px;
  width: 100% !important;
  background-color: #F7F7F7;
  margin: 0 auto;
  border-radius: 2px;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  font-family: roboto;
}

.loginmodal-container h1 {
  text-align: center;
  font-size: 1.8em;
  font-family: roboto;
}

/*.loginmodal-container input[type=submit] {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  position: relative;
}*/

/*.loginmodal-container input[type=text], input[type=password] {
  height: 44px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 10px;
  -webkit-appearance: none;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  /* border-radius: 2px; */
  padding: 0 8px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}*/

.loginmodal-container input[type=text]:hover, input[type=password]:hover {
  border: 1px solid #b9b9b9;
  border-top: 1px solid #a0a0a0;
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.loginmodal {
  text-align: center;
  font-size: 14px;
  font-family: 'Arial', sans-serif;
  font-weight: 700;
  height: 36px;
  padding: 0 8px;
/* border-radius: 3px; */
/* -webkit-user-select: none;
  user-select: none; */
}

.loginmodal-submit {
  /* border: 1px solid #3079ed; */
  border: 0px;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1); 
  background-color: #4d90fe;
  padding: 17px 0px;
  font-family: roboto;
  font-size: 14px;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
}

.loginmodal-submit:hover {
  /* border: 1px solid #2f5bb7; */
  border: 0px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #357ae8;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
}

.loginmodal-container a {
  text-decoration: none;
  color: #666;
  font-weight: 400;
  text-align: center;
  display: inline-block;
  opacity: 0.6;
  transition: opacity ease 0.5s;
} 

.login-help{
  font-size: 12px;
}
</style>
<style type="text/css">
 .fontfamily{
   font-family: Cambria;
  }
 .form_tag_color{
  color:white;
 }      
</style>
</head>
    <!-- END HEAD -->

    <body class="login" style="background-image: url(avatar/vehicle_1.jpg);">
        <!-- BEGIN LOGO -->
        <br>
        <div class="logo" style="">
            <a href="">
                <img src="avatar/btl_logo.png" width="250" height="70" style="border-radius: 5px;">
            </a>
        </div>
         <div id="flash-msg">
          <p> <?php if(isset($err_msg)) { echo $err_msg; } 
              if(isset($success_msg)) { echo $success_msg; 
            } ?>    
          </p>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <!-- <div class="content col-md-5" style="margin-left: 20px;"> -->
            <!-- BEGIN LOGIN FORM -->
            <!--  <form class="" action="index.php" method="post">
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <!-- <label class="control-label"><strong class="fontfamily">Username (Email Address)</strong></label>
                    <input class="form-control form-control-solid" type="email" placeholder="Enter Email Address" name="email" style="border-radius: 5px;" required="" />
                </div>

                <div class="form-group">
                    <label class="control-label"><strong class="fontfamily">Password</strong></label>
                    <input class="form-control form-control-solid" type="password" autocomplete="off" placeholder="Password" name="password" style="border-radius: 5px;" required="" />
                </div>

                <div class="form-actions">
                    <input type="submit" class="btn green uppercase" name="login" value="Login">
                </div>
                <div class="login-options">
                    <h4>Follow Us</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                        </li>
                    </ul>
                </div>
            </form> -->
       <!--  </div> -->
        
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <!-- <form class="forget-form" action="index.html" method="post">
                <h3 class="font-green">Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
            </form> -->
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
            <div class="content" style="background: rgba(167, 163, 163, 0.6);">
              <div class="col-md-12" >
             <form action="" method="post" onSubmit="window.location.reload()" enctype="multipart/form-data" >
              <p class="hint" style="color: black; margin-left:710px;"><strong class="fontfamily ">Please Click on Sign In Here !</strong></p>
                <h3 class=" pull-left fontfamily" style="margin-right:0px;color:lightgray;">Sign Up</h3>
                <a href="#" data-toggle="modal" data-target="#login-modal">
                  <h3 class=" pull-right fontfamily" style="margin-left:0px;color:lightgray">Sign In
                  </h3>
                </a>
              <!--   <p class="hint pull-right" style="margin-top:60px;color: black; margin-right:-80px;"><strong class="fontfamily">Please Click on Sign In Here !</strong></p> -->
                <br><br><br><br>
                <!-- <p class="hint"></p> -->
                <div class="col-md-12">
                    <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Full Name</strong></label>
                        <input class="form-control" type="text" placeholder="Full Name" name="full_name" value="<?php echo $_POST['full_name']; ?>" style="border-radius: 5px;text-transform: uppercase;" /> 
                          <span class="error pull-left" style="color:#ae2424;">* <?php echo $strFullNameError;?>
                          </span> 
                    </div><div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">User Name</strong></label>
                        <input class="form-control" type="text" placeholder="User Name" name="user_name" value="<?php echo $_POST['user_name']; ?>" style="border-radius: 5px;text-transform: uppercase;" /> 
                          <span class="error pull-left" style="color:#ae2424;">* <?php echo $strUserNameError;?> 
                          </span> 
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Email Address</strong></label>
                        <input class="form-control" type="text" placeholder="Email Address" name="user_email_address" value="<?php echo $_POST['user_email_address']; ?>" style="border-radius: 5px;" />
                        <span class="error pull-left" style="color:#ae2424;">* <?php echo $strEmailError;?></span> 
                    </div>
                
                    <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Mobile No</strong></label>
                        <input class="form-control" type="text" placeholder="Mobile No" name="user_mobile_no" value="<?php echo $_POST['user_mobile_no']; ?>" style="border-radius: 5px;" />
                        <span class="error pull-left" style="color:#ae2424;">* <?php echo $IntMobileNumberError;?></span>  
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="form-group col-md-3">
                      <label class="control-label "><strong class="fontfamily ">Password</strong></label>
                      <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="" placeholder="Password" name="password" value="" style="border-radius: 5px;" />
                      <span class="error pull-left" style="color:#ae2424;">* <?php echo $strUserPasswordError;?></span>
                   </div>
                   
                    <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Re-type Your Password</strong></label>
                        <input class="form-control" type="password" autocomplete="off" placeholder="Re-type Your Password" name="confirm_password"  value="" style="border-radius: 5px;" />
                        <span class="error pull-left" style="color:#ae2424;">* <?php echo $strConfirmUserPasswordError;?> <?php if(isset($confirmpassmsg)){ echo $confirmpassmsg; } ?></span> 
                    </div>
                   
                    <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Party Name</strong></label>
                        <input class="form-control" type="text" placeholder="Party Name" name="party_name" value="<?php echo $_POST['party_name']; ?>" style="border-radius: 5px;text-transform: uppercase;" />
                        <span class="error pull-left" style="color:#ae2424;">* <?php echo $strPartyNameError;?></span>  
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Project Name</strong></label>
                        <input class="form-control" type="text" placeholder="Project Name" name="project_name" value="<?php echo $_POST['project_name']; ?>" style="border-radius: 5px;text-transform: uppercase;" />
                        <span class="error pull-left" style="color:#ae2424;">* <?php echo $strProjectNameError;?></span>  
                    </div>
                </div>
                <br>
                 <div class="col-md-12">
                     <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Vehicle Reg. No.</strong></label>
                        <input class="form-control" type="text" placeholder="Vehicle Reg No." name="vehicle_reg" value="<?php echo $_POST['vehicle_reg']; ?>" style="border-radius: 5px;text-transform: uppercase;" />
                        <span class="error pull-left" style="color:#ae2424;">* <?php echo $strVehicleRegNoError;?></span>  
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Vehicle Type</strong></label>
                         <select name="vehicle_type" id="vehicle_type" class="form-control" value="<?php echo $_POST['vehicle_type']; ?>" style="border-radius: 5px;text-transform: uppercase;">
                            <option value="">---Vehicle Type---</option>
                        <?php
                              
                              while($row_vehicle = mysqli_fetch_assoc($result_vehicle)){
                                  echo '<option value="'.$row_vehicle['vehicle_type'].'" id="'.$row_vehicle['vehicle_type_id'].'">'.$row_vehicle['vehicle_type'].'</option>';
                                   
                                      }
                                  ?>
                          </select>

                        <span class="error pull-left" style="color:#ae2424;">* <?php echo $strVehicleTypeError;?></span>  
                    </div>
                   <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Address</strong></label>
                        <input class="form-control" type="text" placeholder="Address" name="address" value="<?php echo $_POST['address']; ?>" style="border-radius: 5px;text-transform: uppercase;" />
                        <span class="error pull-left" style="color:#ae2424;;">* <?php echo $strAddressError;?></span> 
                  </div>
                    <div class="form-group col-md-3">
                        <label class="control-label "><strong class="fontfamily ">Country</strong></label>
                        <select name="country" id="country" class="form-control" value="<?php echo $_POST['country']; ?>" style="border-radius: 5px;">
                            <option value="">---Country---</option>
                             <?php
                                  if($result_1 > 0){
                                      while($row = mysqli_fetch_assoc($result_1)){

                                          echo '<option value="'.$row['country_id'].'">'.$row['country_name'].'</option>';
                                      }
                                  }else{
                                      echo '<option value="">---Country not Available---</option>';
                                  }
                                  ?>
                        </select>
                        <span class="error pull-left" style="color:#ae2424;">* <?php echo $strCountryError;?></span>
                    </div>
            </div>
                <br>
              <div class="col-md-12">
                  <div class="form-group col-md-3">
                    <label class="control-label "><strong class="fontfamily ">State</strong></label>
                    <select name="state" id="state" class="form-control" value="<?php echo $_POST['state']; ?>" style="border-radius: 5px;">
                        <option value="">---Select State---</option>
                        
                    </select>
                    <span class="error pull-left" style="color:#ae2424;">* <?php echo $strStateError;?></span>
                </div>
                
                 <div class="form-group col-md-3">
                    <label class="control-label "><strong class="fontfamily ">City</strong></label>
                    <select name="city" id="city" class="form-control" value="<?php echo $_POST['city']; ?>" style="border-radius: 5px;">
                        <option value="">---Select City---</option>
                        
                    </select>
                    <span class="error pull-left" style="color:#ae2424;">* <?php echo $strCityError; ?></span>
                </div>
                  <div class="form-group col-md-3" style="padding-left: 15px;">
                    <label class="control-label "><strong class="fontfamily ">Zip Code</strong></label>
                      <input class="form-control placeholder-no-fix" type="text" placeholder="Zipcode" name="zipcode" value="<?php echo $_POST['zipcode']; ?>" style="border-radius: 5px;" />
                      <span class="error pull-left" style="color:#ae2424;">* <?php echo $intZipcodeError;?></span> 
                  </div>
                  <br>
                  <div class="form-group col-md-3">
                      <label class="control-label "><strong class="fontfamily ">Profile Image</strong></label>
                      <input type="file" class="" name="profile" id="profile" style="border-radius: 5px;" />
                      <span class="error pull-left">
                        <?php if(isset($uploadsuccmsg)) { echo $uploadsuccmsg; } 
                              if(isset($uploderrormsg)) { echo $uploderrormsg; }
                              //if(isset($success_msg)) { echo $success_msg; }
                            ?>    
                      </span>
                  </div>
                </div>
               <br>
                <div class="form-group" style="margin-left:25px;">
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
              </div>
            </form>
          </div>
        <div>
            <!-- END REGISTRATION FORM -->
  
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:430px;margin-top: 10px;margin-bottom: -63px;">
              <i class="fa fa-times-circle"></i>
          </button>
        <div class="loginmodal-container">
        <div id="flash-msg">
          <p> <?php if(isset($err_msg)) { echo $err_msg; } 
              if(isset($success_msg)) { echo $success_msg; 
            } ?>    
          </p>
        </div>
          <h1 class="fontfamily">Login to Your Account</h1><br>
          <form class="" action="index.php" method="post">
                <h3 class="form-title font-green fontfamily">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span class="fontfamily"> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label"><strong class="fontfamily">Username</strong></label>
                    <input class="form-control form-control-solid" type="text" placeholder="Enter User Name" name="user_name" style="border-radius: 5px;" />
                </div>

                <div class="form-group">
                    <label class="control-label"><strong class="fontfamily">Password</strong></label>
                    <input class="form-control form-control-solid" type="password" autocomplete="off" placeholder="Password" name="password" style="border-radius: 5px;" />
                </div>

                <div class="form-actions">
                    <input type="submit" class="btn green uppercase" name="login" value="Login">
                </div>
                <div class="login-options">
                    <h4 class="fontfamily">Follow Us</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
      </div>
</div>
       
        <!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<script src="assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
 <!-- <div class="copyright"> 2014 © Metronic. Admin Dashboard Template. </div> -->
        <!-- BEGIN CORE PLUGINS -->
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/login.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
         <!-- Country, State and City dependent Script Start Here --> 
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script type="text/javascript">
      $(document).ready(function(){
          $('#country').on('change',function(){
              var countryID = $(this).val();
              if(countryID){
                  $.ajax({
                      type:'POST',
                      url:'ajaxData.php',
                      data:'country_id='+countryID,
                      success:function(html){
                          $('#state').html(html);
                          $('#city').html('<option value="">Select state first</option>'); 
                      }
                  }); 
              }else{
                  $('#state').html('<option value="">Select country first</option>');
                  $('#city').html('<option value="">Select state first</option>'); 
              }
          });
          
          $('#state').on('change',function(){
              var stateID = $(this).val();
              if(stateID){
                  $.ajax({
                      type:'POST',
                      url:'ajaxData.php',
                      data:'state_id='+stateID,
                      success:function(html){
                          $('#city').html(html);
                      }
                  }); 
              }else{
                  $('#city').html('<option value="">Select state first</option>'); 
              }
          });
      });
      </script>
      <!-- Country, State and City dependent Script End Here -->

       <script type="text/javascript">
          $(document).ready(function(){
              $("#flash-msg").delay(3000).fadeOut("slow");
          });
     </script>
    </body>

</html>