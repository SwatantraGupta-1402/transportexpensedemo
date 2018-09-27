<?php
error_reporting(0);
    require_once('../includes/config.php');
     session_start();
      $session_info = $_SESSION['user_session_info'];
      $strFullName = $session_info['full_name'];
      $strUserName = $session_info['user_name'];
      $strUserEmailAddress = $session_info['user_email_address'];
      $intUserId = $session_info['user_id'];
      $user_ID = $_GET['UserId']; 
      date_default_timezone_set('Asia/Kolkata');
      // if(isset($strFullName)){
      //   if((time()-$_SESSION['last_time']) > 60*15){
      //       header("Location:logout.php");
      //   }else{
      //     $_SESSION['last_time'] = time();
    
     $sql_query = "SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC";
     $result_1 = mysqli_query($connection, $sql_query);
     
     $sql_query = "SELECT ur.*,c.country_name,s.state_name,ct.city_name FROM `user_registration` as ur LEFT JOIN countries as c ON c.country_id = ur.country LEFT JOIN states as s ON s.state_id = ur.state LEFT JOIN cities as ct ON ct.city_id = ur.city WHERE ur.user_id = '$user_ID'";
      $result_dashboard = mysqli_query($connection, $sql_query);
      // $row_dashboard = mysqli_fetch_assoc($result_dashboard);
      $row_array = mysqli_fetch_array($result_dashboard);

       $sql_query_1 = "SELECT full_name,project_name,user_avatar FROM user_registration WHERE user_id= '".$intUserId."'";
      $result_query = mysqli_query($connection,$sql_query_1);
      $row_arr = mysqli_fetch_assoc($result_query);
          

    /* Update Query Script Statr Here */ 
    
      $strFullNameError = "";
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
        
        if(''!=$strFullNameError || ''!=$strEmailError || ''!=$IntMobileNumberError || ''!=$strUserPasswordError || ''!=$strConfirmUserPasswordError || ''!=$strAddressError || ''!=$strCountryError || ''!=$strStateError || ''!=$strCityError || ''!=$intZipcodeError) {
            $err_msg = '<div class="alert alert-danger">
                            <strong class="fontfamily">Oopss!</strong> Please fill the below fields.
                        </div>';
            
        } else {
         if(isset($_POST['submit'])){
            //echo "FSHFHG"; 
            $strFullName                = $_POST['full_name'];
            $user_type                  = "user";
            $strUserEmailAddress        = $_POST['user_email_address'];
            $strUserPassword            = $_POST['password'];
            $strUserConfirmPassword     = $_POST['confirm_password'];
            $intMobileNumber            = $_POST['user_mobile_no'];
            $strPartyName               = $_POST['party_name'];
            $strProjectName             = $_POST['project_name'];
            $strAddress                 = $_POST['address'];
            $strCountry                 = $_POST['country'];
            $strState                   = $_POST['state'];
            $strCity                    = $_POST['city'];
            $intZipcode                 = $_POST['zipcode'];
            $created_by                 = $_POST['full_name'];
            $created_date               = date("Y-m-d h:i:s");
            $updated_by                 = $_POST['full_name'];
            $updated_date               = date("Y-m-d h:i:s");
            $subject                    = "Sending HTML eMail using PHPMailer.";
              //$message    = "Hello $full_name, <br /><br /> This is HTML eMail Sent using PHPMailer. isn't it cool to send HTML email rather than plain text, it helps to improve your email marketing.";
            // Validation checking User Name and Email Address already exist
            if($strUserEmailAddress !='') {
                if($strUserPassword != $strUserConfirmPassword){
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
              
              $location = "../upload_image/";
              echo $strUserImage = $location.basename($_FILES['profile']['name']);
              $maxsize = 5120;
              if(isset($name) && !empty($name)){
                if($type != 'image/png' || $type != 'image/jpg' || $type != 'image/jpeg' && $size <= $maxsize){
                  if(move_uploaded_file($tmp_name, $strUserImage)){
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
             
             
            $query = "UPDATE `user_registration` SET 
              user_type             = '$user_type',
              full_name             = '$strFullName', 
              user_email_address    = '$strUserEmailAddress',
              user_mobile_no        = '$intMobileNumber',
              user_password         = '$strUserPassword',
              user_confirm_password = '$strUserConfirmPassword',
              party_name            = '$strPartyName',
              project_name          = '$strProjectName',
              user_address          = '$strAddress',
              country               = '$strCountry',
              state                 = '$strState',
              city                  = '$strCity',
              zipcode               = '$intZipcode',
              user_avatar           = '$strUserImage',
              updated_by            = '$updated_by',
              updated_date          = '$updated_date'
              WHERE user_id         =".$user_ID;
              $result = mysqli_query($connection, $query);
                  // Query for Inserting data User Details End Here

              // Email Sending Script End Here
              if($result){
                    $success_msg = '<div class="alert alert-success">
                            <strong class="fontfamily">Success!</strong> User has been Updated successfully.
                        </div>';
                    header('location:admin_dashboard.php');
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
//}
/* Update Query Script Statr Here */ 
//}
    // }else{
    //     header('Location:../');
    // }
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
        <title>BTL | Admin Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for statistics, charts, recent events and reports" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link rel="icon" type="image/png" sizes="16x16" href="../avatar/favicon-small.png">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
        <style type="text/css">
          .fontfamily{
            font-family: Cambria;
          }
        </style>
      </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="admin_dashboard">
                            <img src="../avatar/btl_logo.png" width="150px" height="45px;" alt="logo" class="logo-default" style="border-radius: 2px;margin-top: 2px;margin-left:-15px;" /> </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                            <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                            <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                            
                            <!-- END NOTIFICATION DROPDOWN -->
                            <!-- BEGIN INBOX DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                           
                            <!-- END INBOX DROPDOWN -->
                            <!-- BEGIN TODO DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <!--  -->
                            <!-- END TODO DROPDOWN -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="../<?php echo $row_arr['user_avatar']; ?>" height="25" width="25" />
                                    <span class="username username-hide-on-mobile fontfamily" style="text-transform:uppercase;"><?php echo $row_arr['full_name']; ?></span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="logout" class="fontfamily">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                           
                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            <li class="sidebar-search-wrapper">
                                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                               
                                <!-- END RESPONSIVE QUICK SEARCH FORM -->
                            </li>
                            <li class="nav-item start active open">
                                <a href="admin_dashboard" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title fontfamily">Dashboard</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase fontfamily">Features</h3>
                            </li>
                            <li class="nav-item  ">
                                <a href="users_expense_list" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title fontfamily">User's Expense List</span>
                                </a>
                            </li>
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
                       
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="dashboard.php"></a>
                                    <span class="fontfamily">Dashboard</span>
                                    <!-- <i class="fa fa-circle"></i> -->
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title fontfamily"> Update User's Details </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-table font-dark"></i>
                                            <span class="caption-subject bold uppercase fontfamily">Update Data</span>
                                        </div>
                                        <div class="tools"> </div>
                                        <div class="content col-md-12" style="margin-right: 5px;">
                                         <form action="" method="post" onSubmit="" enctype="multipart/form-data">
                                            <h3 class="font-green fontfamily">Update Form</h3>
                                            <hr>
                                            <!-- <p class="hint"> Enter your account details below: </p> -->
                                            <div class="col-md-6">
                                                <input class="form-control placeholder-no-fix" type="hidden" placeholder="user ID" name="userid" value="<?php echo $row_array['user_id']; ?>" style="border-radius: 5px;" />
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Full Name</strong></label>
                                                <input class="form-control" type="text" placeholder="Full Name" name="full_name" value="<?php echo $row_array['full_name']; ?>" style="border-radius: 5px;" /> 
                                                  <span class="error pull-left" style="color:red;">* <?php echo $strFullNameError;?> <?php if(isset($user_msg)){ echo $user_msg; } ?></span> 
                                              </div>
                                              <br>
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Email Address</strong></label>
                                                <input class="form-control" type="text" placeholder="Email Address" name="user_email_address" value="<?php echo $row_array['user_email_address']; ?>" style="border-radius: 5px;" />
                                                <span class="error pull-left" style="color:red;">* <?php echo $strEmailError;?> <?php if(isset($check_msg)){ echo $check_msg; } ?></span> 
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Mobile No</strong></label>
                                                <input class="form-control" type="text" placeholder="Mobile No" name="user_mobile_no" value="<?php echo $row_array['user_mobile_no'] ?>" style="border-radius: 5px;" />
                                                <span class="error pull-left" style="color:red;">* <?php echo $IntMobileNumberError;?></span>  
                                            </div>
                                            <br>
                                             <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Password</strong></label>
                                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="" placeholder="Password" name="password" value="" style="border-radius: 5px;" />
                                                <span class="error pull-left" style="color:red;">* <?php echo $strUserPasswordError;?></span>
                                             </div>
                                             <br>
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Re-type Your Password</strong></label>
                                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="confirm_password"  value="" style="border-radius: 5px;" />
                                                <span class="error pull-left" style="color:red;">* <?php echo $strConfirmUserPasswordError;?> <?php if(isset($confirmpassmsg)){ echo $confirmpassmsg; } ?></span> 
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Party Name</strong></label>
                                                <input class="form-control" type="text" placeholder="Party Name" name="party_name" value="<?php echo $row_array['party_name']; ?>" style="border-radius: 5px;" />
                                                <span class="error pull-left" style="color:red;">* <?php echo $strPartyNameError;?></span>  
                                            </div>
                                            </div>
                                         
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Project Name</strong></label>
                                                <input class="form-control" type="text" placeholder="Project Name" name="project_name" value="<?php echo $row_array['project_name']; ?>" style="border-radius: 5px;" />
                                                <span class="error pull-left" style="color:red;">* <?php echo $strProjectNameError;?></span>  
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Address</strong></label>
                                                <input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address" value="<?php echo $row_array['user_address']; ?>" style="border-radius: 5px;" />
                                                <span class="error pull-left" style="color:red;">* <?php echo $strAddressError;?></span> 
                                            </div>
                                            <br>
                                            <!-- <div class="form-group">
                                                <label class="control-label ">City/Town</label>
                                                <input class="form-control placeholder-no-fix" type="text" placeholder="City/Town" name="city" /> 
                                            </div> -->
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Country</strong></label>
                                                <select name="country" id="country" class="form-control" value="<?php echo $row_array['country_name']; ?>" style="border-radius: 5px;">
                                                    <option value="Country">---Select Country---</option>
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
                                                <span class="error pull-left" style="color:red;">* <?php echo $strCountryError;?></span>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">State</strong></label>
                                                <select name="state" id="state" class="form-control" value="<?php echo $row_array['state_name']; ?>" style="border-radius: 5px;">
                                                    <option value="">---Select State---</option>
                                                    
                                                    
                                                </select>
                                                <span class="error pull-left" style="color:red;">* <?php echo $strStateError;?></span>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">City</strong></label>
                                                <select name="city" id="city" class="form-control" value="<?php echo $row_array['city_name']; ?>" style="border-radius: 5px;">
                                                    <option value="">---Select State---</option>
                                                    
                                                        
                                                </select>
                                                <span class="error pull-left" style="color:red;">* <?php echo $strCityError; ?></span>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Zip Code</strong></label>
                                                <input class="form-control placeholder-no-fix" type="text" placeholder="Zipcode" name="zipcode" value="<?php echo $row_array['zipcode']; ?>" style="border-radius: 5px;" />
                                                <span class="error pull-left" style="color:red;">* <?php echo $intZipcodeError;?></span> 
                                            </div>
                                        </div>
                                            <br>
                                            <!-- <div class="form-group">
                                                <label class="control-label "><strong class="fontfamily">Aadhar Details</strong></label>
                                                <input class="form-control placeholder-no-fix" type="text" placeholder="Aadhar Details" name="address" /> 
                                            </div> -->
                                            <div class="form-group pull-left">
                                                <label class="control-label "><strong class="fontfamily">Profile Image</strong></label>
                                                <input type="file" name="profile" id="profile" value="<?php echo $row_array['user_avatar']; ?>" style="border-radius: 5px;" />
                                                <span class="error pull-left">
                                                  <?php if(isset($uploadsuccmsg)) { echo $uploadsuccmsg; } 
                                                        if(isset($uploderrormsg)) { echo $uploderrormsg; }
                                                        //if(isset($success_msg)) { echo $success_msg; }
                                                      ?>    
                                                </span>
                                            </div>
                                           
                                            <br>
                                           <!--  <div class="form-group margin-top-20 margin-bottom-20">
                                                <label class="mt-checkbox mt-checkbox-outline">
                                                    <input type="checkbox" name="tnc" /> I agree to the
                                                    <a href="javascript:;">Terms of Service </a> &
                                                    <a href="javascript:;">Privacy Policy </a>
                                                    <span></span>
                                                </label>
                                                <div id="register_tnc_error"> </div>
                                            </div> -->
                                           
                                                <!-- <button type="button" id="register-back-btn" class="btn green btn-outline">Back</button> -->
                                                <input type="submit" class="btn btn-success uppercase pull-right" name="submit" value="Submit">
                                           
                                        </form>
                                        <div>
                                    </div>
                                   
                                </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
               
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->

            <!-- User List View Details Modal Start Here -->
           
            <!-- User List View Details Modal End Here -->

            <!-- User List View Details Modal Start Here -->
           
            <!-- User List View Details Modal End Here -->

            <!-- BEGIN FOOTER -->
            <div class="page-footer" align="center">
                <div class="page-footer-inner fontfamily"> 2018 &copy; BTL Expense
                    <a target="_blank" href="https://btlexpense.in">BTL Expense</a> 
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
       
        <div class="quick-nav-overlay"></div>
        <!-- END QUICK NAV -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
       <!--  -->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <script src="../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
        <script src="../assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
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