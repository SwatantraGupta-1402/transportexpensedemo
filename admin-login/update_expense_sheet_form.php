<?php 
error_reporting(0);
//ini_set("display_errors", "1");

//error_reporting(E_ALL);
 require_once('../includes/config.php');
    session_start();
    
     $session_info          = $_SESSION['user_session_info'];
     $strUserName           = $session_info['user_name'];
     $strUserEmailAddress   = $session_info['user_email_address'];
     $intUserId             = $session_info['user_id'];
     date_default_timezone_set('Asia/Kolkata');
    if(isset($_SESSION['user_name'])){
        if((time()-$_SESSION['last_time']) > 60*15){
            header("Location:logout.php");
        }else{
          $_SESSION['last_time'] = time();
          
    if(isset($_GET['ID'])){ 
     $ExpenseformID = base64_decode($_GET['ID']);
     
     $sql = "SELECT SUM(day_wise_distance) as tot_distance FROM expense_sheet_form";
     $sql_result = mysqli_query($connection, $sql);
     $row = mysqli_fetch_assoc($sql_result);
    
    $sql_query_user = "SELECT esf.*,SUM(esf.diesel_in_liter) as tot,ur.user_id,ur.full_name,ur.vehicle_reg,ur.vehicle_type,(SUM(esf.diesel_in_liter)/vt.vehicle_avg) as diesel_avg FROM `expense_sheet_form` as esf 
       LEFT JOIN user_registration as ur ON esf.user_id = ur.user_id
       LEFt JOIN vehicle_type as vt ON vt.vehicle_type_id = ur.vehicle_type_id 
       WHERE esf.expense_form_id=".$ExpenseformID;
       $result_user = mysqli_query($connection, $sql_query_user);
       $row_user = mysqli_fetch_assoc($result_user);
     
    $sql_query_ta_da = "SELECT team_ta_da_exp_id,candidate_name,team_da FROM team_ta_da_advance_expense WHERE expense_form_id = ".$ExpenseformID;
       $result_query_ta_da = mysqli_query($connection,$sql_query_ta_da);
       $totRow=mysqli_num_rows($result_query_ta_da);
       //echo "no. of rows fetched : ".$totRow; 
     
    $sql_query_others = "SELECT other_exp_id,expense_desc,others_expense FROM others_expenses WHERE expense_form_id = ".$ExpenseformID;
       $result_query_others = mysqli_query($connection,$sql_query_others);
       $rowcount=mysqli_num_rows($result_query_others);
       //echo "no. of rows fetched : ".$rowcount;       

    $sql_query = "SELECT full_name,project_name,user_avatar FROM user_registration WHERE user_id= '".$intUserId."'";
       $result_query = mysqli_query($connection,$sql_query);
       $row_array = mysqli_fetch_assoc($result_query);
  }  
      

      if(isset($_POST['submit'])){
        $intDieselVanRent           = $_POST['diesel_van'];
        $intExpenseId               = $_POST['expense_id']; 
        $intDieselVanPowerBackup    = $_POST['diesel_power_backup'];
        $intTollRoadTax             = $_POST['toll_road_tax'];
        $ExpenseDate                = $_POST['expense_date'];
        $intVanRepair               = $_POST['van_repair'];
        $intVanDriverAdvance        = $_POST['van_driver_advance'];
        $intRoomRent                = $_POST['room_rent'];
        $candidateName              = $_POST['candidate_name']; 
        $teamDa                     = $_POST['team_da'];
        $team_ta_da_exp_id          = $_POST['team_ta_da_exp_id'];
        $intMobileRecharge          = $_POST['mobile_recharge'];
        $intATMCharge               = $_POST['atm_charge'];
        $intStationary              = $_POST['stationary'];
        $Travelling                 = $_POST['travelling_expense'];
        $intRepair                  = $_POST['repair_item'];
        $intPermission              = $_POST['permission'];
        $intPurchase                = $_POST['purchase_cost'];
        //$intOthers                  = $_POST['others'];        
        $intTotalExpenseDay         = $_POST['total_expense_day'];
        $intTotalAmount             = $_POST['total_amount'];
        $intOpeningBalance          = $_POST['opening_balance'];
        $intReceiveAmount           = $_POST['received_amount'];
        $intTotalBalance            = $_POST['total_balance'];
        $strFrom                    = $_POST['from'];
        $strTo                      = $_POST['to'];
        $strStartMeterReading       = $_POST['start_meter_reading'];
        $strClosingMeterReading     = $_POST['closing_meter_reading'];
        $strDayWiseDistance         = $_POST['day_wise_distance'];
        $intTotalDistance           = $_POST['total_distance'];
        $intDieselLiter             = $_POST['diesel_leter'];
        $strVehicleReg              = $_POST['vehicle_reg'];
        $strVehicleType             = $_POST['vehicle_type'];
        $expense_desc               = $_POST['expense_desc'];
        $others_expense             = $_POST['others_expense'];
        $other_exp_id               = $_POST['other_exp_id'];
        $created_by                 = $strUserName;
        $created_date               = date("Y-m-d");
        $updated_by                 = $strUserName;
        $updated_date               = date("Y-m-d h:i:s");


    $sql_query_update = "UPDATE `expense_sheet_form` SET
      diesel_van_expense = '$intDieselVanRent', diesel_power_backup_expense = '$intDieselVanPowerBackup',
      toll_road_tax_expense = '$intTollRoadTax', van_repair_expense = '$intVanRepair', van_driver_expense = '$intVanDriverAdvance',
      room_rent_expense = '$intRoomRent', mobile_recharge_expense = '$intMobileRecharge', atm_charge_expense = '$intATMCharge',
      stationary_expense = '$intStationary', travelling_expense = '$Travelling', electronic_item_repair_expense = '$intRepair',
      permission_expense = '$intPermission', purchase_item_cost = '$intPurchase', total_expense_day_wise = '$intTotalExpenseDay',total_expense ='$intTotalAmount', opening_balance = '$intOpeningBalance', receiveing_amount = '$intReceiveAmount',
      total_balance = '$intTotalBalance', from_source_place = '$strFrom', to_destination_place = '$strTo', 
      start_meter_reading = '$strStartMeterReading', closing_meter_reading = '$strClosingMeterReading', day_wise_distance = '$strDayWiseDistance',
      total_distance = '$intTotalDistance', diesel_in_liter = '$intDieselLiter', vehicle_reg = '$strVehicleReg',
      vehicle_type = '$strVehicleType',updated_by = '$updated_by',updated_date = '$updated_date' WHERE expense_form_id =".$ExpenseformID;
      $result_query = mysqli_query($connection,$sql_query_update);
      
      if($result_query){
        $tomorrowDate = new DateTime($_POST['expense_date']);
        $tomorrowDate->modify('+1 day');
        $tomorrowDate = $tomorrowDate->format('Y-m-d');
        $sql_check_data = "SELECT * FROM expense_sheet_form WHERE created_Date = '".$tomorrowDate."' and user_id = ".$intUserId;
        $result_check_data = mysqli_query($connection,$sql_check_data);
        $rowcount = mysqli_num_rows($result_check_data);
        $tot_amt = 0;
        if($rowcount){
            $row_check_data = mysqli_fetch_assoc($result_check_data);
            if((int)$intTotalBalance < 0){
                $tot_amt = ((int)$intTotalBalance - (int)$row_check_data['total_expense_day_wise']);
            }else{
                $tot_amt = ((int)$intTotalBalance + (int)$row_check_data['total_expense_day_wise']);
            }
            if($tot_amt < 0){
                $tot_amt = $tot_amt + (int)$row_check_data['receiveing_amount'];
            }else{
                $tot_amt = $tot_amt - (int)$row_check_data['receiveing_amount'];
            }
            $sql_query_update = "UPDATE `expense_sheet_form` SET opening_balance = '$intTotalBalance', total_expense = '$tot_amt' WHERE user_id = '$intUserId' and expense_form_id =".$row_check_data['expense_form_id'];
            $result_query = mysqli_query($connection,$sql_query_update);
        }
      }
      
      $success_msg = '<div class="alert alert-success">
      <strong>Success!</strong> Data has been Submitted successfully.
      </div>';

      /* Team TA DA Other Expense Info Add more Field Insert Query Start Here */
      foreach($candidateName as $ind => $value){
        if($candidateName[$ind] != '' && $teamDa[$ind] != ''){
          if($team_ta_da_exp_id[$ind] != ''){
            $sql_query_update_1 = "UPDATE `team_ta_da_advance_expense` SET
              candidate_name = '$candidateName[$ind]', team_da = '$teamDa[$ind]',updated_by = '$updated_by',updated_date = '$updated_date' WHERE team_ta_da_exp_id = ".$team_ta_da_exp_id[$ind];
            $result_query_1 = mysqli_query($connection,$sql_query_update_1);
          }else{
            $expenseId = $_POST['expense_id']; 
            $sql_query_insert1 = "INSERT INTO `team_ta_da_advance_expense` (candidate_name,team_da,expense_form_id,created_by,created_date) VALUES ('$candidateName[$ind]','$teamDa[$ind]', '$expenseId','$created_by','$created_date')";
              $result_query_1 = mysqli_query($connection, $sql_query_insert1);
          }
        }
      }
               
        /* Others Expense Info Add more Field Insert Query Start Here */
      foreach($expense_desc as $index => $value){
        if($expense_desc[$index] != '' && $others_expense[$index] != ''){
          if($other_exp_id[$index] != ''){
            $sql_query_update_2 = "UPDATE `others_expenses` SET
              expense_desc = '$expense_desc[$index]', others_expense = '$others_expense[$index]',updated_by = '$updated_by',updated_date = '$updated_date' WHERE other_exp_id = ".$other_exp_id[$index];
            $result_query_2 = mysqli_query($connection,$sql_query_update_2);
          }else{
            $expenseId = $_POST['expense_id']; 
            $sql_query_insert = "INSERT INTO `others_expenses` (expense_desc,others_expense,expense_form_id,created_by,created_date) VALUES ('$expense_desc[$index]','$others_expense[$index]', '$expenseId','$created_by','$created_date')";
              $result_query = mysqli_query($connection, $sql_query_insert);
          }
        }
      }

      $success_msg = '<div class="alert alert-success">
            <strong>Success!</strong> Data has been submitted successfully.
          </div>';
          echo "<meta http-equiv='refresh' content='0'>";
        mysqli_close($connection);
      }
    }
    }else{
    header('Location:../index.php');
}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>BTL | User Admin Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for bootstrap inputs, input groups, custom checkboxes and radio controls and more" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link rel="icon" type="image/png" sizes="16x16" href="../avatar/favicon-small.png">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
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
        <style>
            .fontfamily{
            font-family: Cambria;
            }
        </style>
        </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="admin_dashboard.php">
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
                            
                            <!-- END TODO DROPDOWN -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                             <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="../<?php echo $row_array['user_avatar']; ?>" height="25" width="25" />
                                    <span class="username username-hide-on-mobile fontfamily" style="text-transform:uppercase;"><?php echo $row_array['full_name']; ?></span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="../logout.php">
                                            <i class="icon-key fontfamily"></i> Log Out </a>
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
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
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
                            <li class="nav-item ">
                                <a href="admin_dashboard.php" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title fontfamily">Dashboard</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase fontfamily">Features</h3>
                            </li>
                            <!--<li class="nav-item start active open">
                                <a href="expense_sheet_form.php" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title fontfamily">Expense Sheet Form</span>
                                </a>
                            </li>-->
                             <li class="nav-item start">
                                <a href="users_expense_list.php" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title fontfamily">Expense Sheet List</span>
                                </a>
                            </li>
                            <!-- <li class="heading">
                                <h3 class="uppercase">Features</h3>
                            </li>
                            <li class="nav-item  ">
                                <a href="user_expense_list.php" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title">Expense List </span>
                                    
                                </a>
                            </li> -->
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
                                    <a href="#" class="fontfamily">Home</a>
                                    <!-- <i class="fa fa-circle"></i> -->
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title fontfamily"> Update BTL Expense Sheet Form for Employee's </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                       <div class="row">
                            <div class="col-md-12 ">
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="icon-settings font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase fontfamily"> Day wise Expense Sheet Form</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']; ?>" id="expense_sheet_form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group col-md-4">
                                                             <label for="expense_date"><strong>Select Expense Date:</strong></label>
                                                             <br> <br>
                                                            <div class="input-group">
                                                                <i class="fa fa-calendar fa-2x" ></i>
                                                                <input type="text" class="form-control" placeholder="Select Expense Date" name="expense_date" id="datepicker_expense" value="<?php echo $row_user['created_date'] ?>" style="border-radius: 5px;margin-top:-29px;margin-left:28px;" readonly="readonly"> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                             <label for="vehicle_reg"><strong>Select Vehicle No:</strong></label>
                                                              <br><br>
                                                                <div class="input-group">
                                                                <i class="fa fa-bus fa-2x" ></i>
                                                                <input type="text" class="form-control " placeholder="Vehicle Reg. No" name="vehicle_reg" id="vehicle_reg" value="<?php echo $row_user['vehicle_reg'] ?>" style="border-radius: 5px;margin-top:-29px;margin-left:28px;text-transform: uppercase;" readonly="readonly"> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 pull-right">
                                                             <label for="expense_date"><strong>Select Vehicle Type:</strong></label>
                                                             <br> <br>
                                                           <div class="">
                                                                <i class="fa fa-bus fa-2x" ></i>
                                                                <input type="text" class="form-control" placeholder="Vehicle Type" name="vehicle_type" id="vehicle_type" value="<?php echo $row_user['vehicle_type'] ?>" style="border-radius: 5px;margin-top:-29px;margin-left:28px;" readonly="readonly"> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                 </div>
                                                 <hr>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                    <input type="hidden" name="expense_id" value="<?php echo $row_user['expense_form_id']; ?>">
                                                        <label for="diesel_van"><strong>Diesel Van:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Diesel Van Detail" name="diesel_van" id="diesel_van" value="<?php echo $row_user['diesel_van_expense']; ?>" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="diesel_power_backup"><strong>Diesel (Power Backup):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Diesel (Power Backup)" name="diesel_power_backup" value="<?php echo $row_user['diesel_power_backup_expense']; ?>" id="diesel_power_backup" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="toll_road_tax"><strong>Toll Tax & Road Tax:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Toll Tax & Road Tax" name="toll_road_tax" id="toll_road_tax" value="<?php echo $row_user['toll_road_tax_expense']; ?>" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="van_repair"><strong>Van Repair:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Van Repair Cost" name="van_repair" id="van_repair" style="border-radius: 5px;" value="<?php echo $row_user['van_repair_expense']; ?>" > 
                                                        </div>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="van_driver_advance"><strong>Van Driver Advance:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Van Driver Advance" name="van_driver_advance" style="border-radius: 5px;" value="<?php echo $row_user['van_driver_expense']; ?>" id="van_driver_advance"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="roorm_rent"><strong>Room Rent</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Room Rent" name="room_rent" id="room_rent" style="border-radius: 5px;" value="<?php echo $row_user['room_rent_expense']; ?>" > 
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="mobile_recharge"><strong>Mobile Recharge</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Mobile Recharge" name="mobile_recharge" id="mobile_recharge" style="border-radius: 5px;" value="<?php echo $row_user['mobile_recharge_expense']; ?>" > 
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                    <div class=" form-group col-md-12"><hr>
                                                        <label class="hint" style="color: blue;margin-left:20px;"><strong>Team DA & Advance Details:</strong></label>
                                                           <div class="input-group field_wrapper_advance">
                                                             <?php $i = 0; 
                                                        $totRow=mysqli_num_rows($result_query_ta_da);
                                                        if($totRow > 0){
                                                          while ($row_ta_da = mysqli_fetch_assoc($result_query_ta_da)) { ?>
                                                          <div class=" form-group row" style="margin-left: 0px;">
                                                                <div class="col-md-6">
                                                                  <input type="hidden" value="<?php echo $row_ta_da['team_ta_da_exp_id']?>" name="team_ta_da_exp_id[]" />
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control uppercase" placeholder="Candidate Name" name="candidate_name[]" value="<?php echo $row_ta_da['candidate_name']; ?>" id="candidate_name" style="border-radius: 5px;text-transform:uppercase;"> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control calc" placeholder="Team DA Amount" name="team_da[]" value="<?php echo $row_ta_da['team_da']; ?>" id="team_da" style="border-radius: 5px;">
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:void(0);" class="remove_button_advance" title="Add Others Field" id="deletetada-<?php echo $row_ta_da['team_ta_da_exp_id']?>"><img src="../avatar/remove.png" class="pull-right" style="border-radius: 5px;margin-top: 10px;margin-right: -15px;" width="15px" height="15px"></a>
                                                            </div> 
                                                            <?php }} ?>
                                                            <div class=" form-group row" style="margin-left: 0px;">
                                                                <div class="col-md-6">
                                                                  <input type="hidden" value="<?php echo $row_ta_da['team_ta_da_exp_id']?>" name="team_ta_da_exp_id[]" />
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control uppercase" placeholder="Candidate Name" name="candidate_name[]" value="<?php echo $row_ta_da['candidate_name']; ?>" id="candidate_name" style="border-radius: 5px;text-transform:uppercase;"> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control calc" placeholder="Team DA Amount" name="team_da[]" value="<?php echo $row_ta_da['team_da']; ?>" id="team_da" style="border-radius: 5px;">
                                                                    </div>
                                                                </div> 
                                                                <a href="javascript:void(0);" class="add_button_advance" title="Add Others Field"><img src="../avatar/add.png" class="pull-right" style="border-radius: 5px;margin-top: 10px;margin-right: -15px;" width="15px" height="15px"></a> 
                                                        </div>
                                                    </div>
                                               
                                                <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="atm_charge"><strong>ATM Charge</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="ATM Charge" name="atm_charge" id="atm_charge" style="border-radius: 5px;" value="<?php echo $row_user['atm_charge_expense']; ?>" > 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="stationary"><strong>Stationary:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Stationary" name="stationary" id="stationary" style="border-radius: 5px;" value="<?php echo $row_user['stationary_expense']; ?>" > 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="travelling_expense"><strong>Travelling (Auto/Rikshaw):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Traveling Expense" name="travelling_expense" id="travelling_expense" style="border-radius: 5px;" value="<?php echo $row_user['travelling_expense']; ?>" > 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="repair_item"><strong>Repair (Electronics Item):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Repair Electronic Item" name="repair_item" id="repair_item" style="border-radius: 5px;" value="<?php echo $row_user['electronic_item_repair_expense']; ?>" > 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="permission"><strong>Permission (Police/Municipal):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Permission Charge" id="permission" name="permission" style="border-radius: 5px;" value="<?php echo $row_user['permission_expense']; ?>" > 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="purchase_cost"><strong>Purchase (Any Item):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Purchase Item Cost" name="purchase_cost" id="purchase_cost" style="border-radius: 5px;" value="<?php echo $row_user['purchase_item_cost']; ?>" > 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="total_expense_day"><strong>Total Expense (Day Wise):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control total" placeholder="Total Amount" name="total_expense_day" required="" value="<?php echo $row_user['total_expense_day_wise']; ?>" id="total_expense_day" style="border-radius: 5px;" readonly="readonly">
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class=" form-group col-md-12"><hr>
                                                        <label class="hint" style="color: blue;margin-left:20px;"><strong>Other Expense Details:</strong></label>
                                                        <div class="input-group field_wrapper_others">
                                                        <?php $i = 0; 
                                                        $rowcount=mysqli_num_rows($result_query_others);
                                                        if($rowcount > 0){
                                                          while ($row_others = mysqli_fetch_assoc($result_query_others)) { ?>
                                                          <input type="hidden" value="<?php echo $row_others['other_exp_id']; ?>" name="other_exp_id[]" />
                                                             <div class=" form-group row" style="margin-left: 0px;">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="expense_desc form-control" placeholder="Other Expense Info" name="expense_desc[]" id="" style="border-radius: 5px;text-transform:uppercase;" value="<?php echo $row_others['expense_desc']; ?>"> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="others_expense form-control calc" placeholder="Others Expense Amount" name="others_expense[]" id="" style="border-radius: 5px;" value="<?php echo $row_others['others_expense']; ?>">
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:void(0);" class="remove_button_others" id="<?php echo 'deleteother-'.$row_others['other_exp_id']; ?>" title="Remove Others Field"><img src="../avatar/remove.png" class="pull-right" style="border-radius: 5px;margin-top:10px;margin-right: -15px;" width="15px" height="15px"></a>
                                                            </div>  
                                                        <?php $i++; } 
                                                        } ?>
                                                             <div class=" form-group row" style="margin-left: 0px;">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="expense_desc form-control" placeholder="Other Expense Info" name="expense_desc[]" id="" style="border-radius: 5px;text-transform:uppercase;" value=""> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="others_expense form-control calc" placeholder="Others Expense Amount" name="others_expense[]" id="" style="border-radius: 5px;" value="">
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:void(0);" class="add_button_others" title="Add Others Field"><img src="../avatar/add.png" class="pull-right" style="border-radius: 5px;margin-top:10px;margin-right: -15px;" width="15px" height="15px"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="total_amount"><strong>Total Amount:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control total_amt" placeholder="Total Amount" name="total_amount" required="" value="<?php echo $row_user['total_expense']; ?>" id="total_amount" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="balance"><strong>Opening Balance:</strong></label>
                                                        <div class="input-group">     
                                                             <input type="text" class="form-control opening" placeholder="Opening Balance" name="opening_balance" id="opening_balance" required="" value="<?php echo $row_user['opening_balance']; ?>" style="border-radius: 5px;" readonly="readonly">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="rcv_amt"><strong>Received Amount:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control abcd" placeholder="Received Amount" name="received_amount" id="received_amount" value="<?php echo $row_user['receiveing_amount']; ?>" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="total_balance"><strong>Total Balance:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Total Balance" name="total_balance" id="total_balance" required="" value="<?php echo $row_user['total_balance']; ?>" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div>
                                                </div>
                                                    <p class="hint" style="color: blue;margin-left:28px;"><strong>Van Log Book Details:</strong></p>
                                                    <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="from"><strong>From:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="From (Source Palce Name)" name="from" id="from" required="" value="<?php echo $row_user['from_source_place']; ?>" style="border-radius: 5px;text-transform:uppercase;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="to"><strong>To:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="To (Desti. Palce Name)" name="to" id="to" value="<?php echo $row_user['to_destination_place']; ?>" required="" style="border-radius: 5px;text-transform:uppercase;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="start_meter_reading"><strong>Start Meter Reading (KM):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control meter_reading" placeholder="Starting Meter Reading" id="start_meter_reading" name="start_meter_reading" value="<?php echo $row_user['start_meter_reading']; ?>" required="" style="border-radius: 5px;"> 
                                                            <span style="color:red" id="startmeterErr"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="closing_meter_reading"><strong>Closing Meter Reading (KM):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control meter_reading" placeholder="Closing Meter Reading" id="closing_meter_reading" name="closing_meter_reading" value="<?php echo $row_user['closing_meter_reading']; ?>" required="" style="border-radius: 5px;"> 
                                                            <span style="color:red" id="closemeterErr"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                          <div class="form-group col-md-3">
                                                        <label for="day_wise_distance"><strong>Day Wise Distance (KM):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control tot_dis" placeholder="Day Wise Distance (KM)" id="day_wise_distance" name="day_wise_distance" required="" style="border-radius: 5px;" readonly="readonly" value="<?php echo $row_user['day_wise_distance']; ?>"> 
                                                        </div>
                                                    </div>
                                                    <!--<div class="form-group col-md-3">-->
                                                    <!--    <label for="total_distance"><strong>Total Distance (KM):</strong></label>-->
                                                    <!--    <div class="input-group">-->
                                                    <!--        <input type="text" class="form-control tot_dis" placeholder="Total Distance" id="total_distance" name="total_distance" value="<?php echo $row['tot_distance']; ?>" required="" style="border-radius: 5px;" readonly="readonly"> -->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <div class="form-group col-md-3">
                                                        <label for="diesel_leter"><strong>Diesel (Ltr):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Diesel in Litre" name="diesel_leter" id="diesel_leter" value="<?php echo $row_user['diesel_in_liter']; ?>" required="" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="diesel_leter"><strong>Total Diesel (Ltr):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Total Diesel in Litre" name="total_diesel_leter" id="total_diesel_leter" value="<?php echo $row_user['tot']; ?>" required="" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div>
                                                    <!--<div class="form-group col-md-3">-->
                                                    <!--    <label for="diesel_leter"><strong>Avg Diesel (Ltr):</strong></label>-->
                                                    <!--    <div class="input-group">-->
                                                    <!--        <input type="text" class="form-control" placeholder=" Avg Diesel in Litre" name="avg_diesel_leter" id="avg_diesel_leter" value="<?php echo number_format($row_user['diesel_avg'],2); ?>" required="" style="border-radius: 5px;" readonly="readonly"> -->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                </div>                                                
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                            <input type="submit" class="btn blue" name="submit" value="Submit" />
                                            <a href="index.php"><input type="button" class="btn default" name="cancel" value="Cancel"></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END SAMPLE FORM PORTLET-->
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                               
                                <!-- END SAMPLE FORM PORTLET-->
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                
                                <!-- END SAMPLE FORM PORTLET-->
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
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner fontfamily" style="margin-left:600px;"> 2018 &copy; BTL Pramotions Advertising Pvt. Ltd.   
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
        <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
        <!-- Others Page Java Script Code Start Here -->
        <script type="text/javascript">
           $(document).ready(function(){
                var openBal = $('#opening_balance').val() == '' ? 0 : parseInt($('#opening_balance').val());
                var totamt = openBal;
                if($('#total_amount').val() == ''){ $('#total_amount').val(openBal); }else{ totamt = parseInt($('#total_amount').val());}
                var Disopen = $('#total_distance').val();
                var totamtdis = Disopen;
                
                /* Script for Adding more row in Others Field Start Here */
                var maxField = 10; //Input fields increment limitation
                var r = 1; //Initial field counter is 1
                var addButton = $('.add_button_others'); //Add button selector
                var wrapper = $('.field_wrapper_others'); //Input field wrapper
                var fieldHTML = '<input type="hidden" name="other_exp_id[]" /><div class=" form-group row" style="margin-left: 0px;"><div class="col-md-6"><div class="form-group"><input type="text" class="form-control" placeholder="Other Expense Info" name="expense_desc[]" style="border-radius: 5px;text-transform:uppercase;"></div></div><div class="col-md-6"><div class="form-group"><input type="text" class="form-control calc" placeholder="Others Expense Amount" name="others_expense[]" style="border-radius: 5px;"></div></div><a href="javascript:void(0);" class="remove_button_others" title="Remove Others Field"><img src="../avatar/remove.png" class="pull-right" style="border-radius: 5px;margin-top:10px;margin-right: -15px;" width="15px" height="15px"></a></div>'; 
                 
                
                $(addButton).click(function(){
                    if(r < maxField){ 
                        r++;
                        $(wrapper).append(fieldHTML);
                    }
                });
                
                 
                
                //Once remove button is clicked
                $(wrapper).on('click', '.remove_button_others', function(e){
                    e.preventDefault();
                    var eleId = $(this).closest('a').attr('id');
                    var tempVal = $(this).parent('div').find('.calc').val() == '' ? 0 : parseInt($(this).parent('div').find('.calc').val());
                    var totVal = $('#total_expense_day') == '' ? 0 : parseInt($('#total_expense_day').val());
                    $('#total_expense_day').val(totVal - tempVal);
                    //$('#id').val('').trigger('change')
                    $('#received_amount').trigger('refresh');
                    $(this).parent('div').remove(); //Remove field html
                    r--;//Decrement field counter
                    if(eleId != undefined){
                      deleteFn(eleId);
                    }
                });
                /* Script for Adding more row in Others Field End Here */ 

                /* Script for Adding more row in Team DA & Advance Field Start Here */

                var maxField = 10; //Input fields increment limitation
                var y = 1; //Initial field counter is 1
                var addButton = $('.add_button_advance'); //Add button selector
                var advance = $('.field_wrapper_advance'); //Input field wrapper
                var fieldHTMLS = '<div class="form-group row" style="margin-left: 0px;"><div class="col-md-6"><div class="form-group"><input type="text" class="form-control" placeholder="Candidate Name" name="candidate_name[]" id="candidate_name" style="border-radius: 5px;"></div></div><div class="col-md-6"><div class="form-group"><input type="text" class="form-control calc" placeholder=" Team DA Amount" name="team_da[]" id="team_da" style="border-radius: 5px;"></div></div><a href="javascript:void(0);" class="remove_button_advance" title="Add Others Field"><img src="../avatar/remove.png" class="pull-right" style="border-radius: 5px;margin-top: 10px;margin-right: -15px;" width="15px" height="15px"></a></div>'; 
                
                $(addButton).click(function(){
                    if(y < maxField){ 
                        y++;
                        $(advance).append(fieldHTMLS);
                    }
                });
                
                //Once remove button is clicked
                $(advance).on('click', '.remove_button_advance', function(e){
                    e.preventDefault();
                    var eleId = $(this).closest('a').attr('id');
                    var tempVal = $(this).parent('div').find('.calc').val() == '' ? 0 : parseInt($(this).parent('div').find('.calc').val());
                    var totVal = $('#total_expense_day').val() == '' ? 0 : parseInt($('#total_expense_day').val());
                    $('#total_expense_day').val(totVal - tempVal);
                    // alert(totVal - tempVal);
                    //$('.total').val(totVal - tempVal);
                    $(this).parent('div').remove(); //Remove field html
                    y--; //Decrement field counter

                    if(eleId != undefined){
                      deleteFn(eleId);
                    }
                });

             /* Script for Adding more row in Team DA & Advance Field End Here */

                var total_balance = 0;
              $('body').keyup( ".calc", function(e) {                    
                  var sum = 0;
                  var recv_amt = $('#received_amount').val();
                  $(".calc").each(function(){
                      sum = $(this).val() == '' ? sum : sum+parseInt($(this).val());
                  });
                  $("#total_expense_day").val(sum);
                  total_balance = totamt - sum;
                  $('#total_balance').val(total_balance);

              });


             $('#received_amount').on('keyup', function() {
                var recvAmt = $(this).val() == '' ? 0 : parseInt($(this).val());
                var totExpDay = parseInt($('#total_expense_day').val());
                totamt = openBal + recvAmt;
                $('#total_amount').val(totamt);
                totExpDay = totamt - totExpDay;
                $('#total_balance').val(totExpDay);
                
             });

             var TotDayWise = $('#total_distance').val() == '' ? 0 : parseInt($('#total_distance').val());
             $('#closing_meter_reading').on('keyup', function() {
                $('#closemeterErr').html('');$('#startmeterErr').html('');
                var stMtrRead = 0;
                if($('#start_meter_reading').val() == ''){
                  $(this).val('');
                  $('#startmeterErr').html('Error : Start meter reading must have a value.');
                }else if($('#start_meter_reading').val() != ''){
                  if(parseInt($('#start_meter_reading').val()) < 1){
                    $(this).val('');
                    $('#startmeterErr').html('Error : Start meter reading value should be greater than zero.');
                  }else{
                    stMtrRead = parseInt($('#start_meter_reading').val());        
                    var clMtrRead = $(this).val() == '' ? 0 : parseInt($(this).val());
                    var DayWiseDis = clMtrRead - stMtrRead;
                    if(stMtrRead > clMtrRead){
                      $('#day_wise_distance').val(Math.round(DayWiseDis));
                      //$('#total_distance').val(Math.round(DayWiseDis) + Math.round(TotDayWise));
                      $('#closemeterErr').html('Error : Close meter reading must be greater than start meter reading.');
                    }else{
                      $('#day_wise_distance').val(Math.round(DayWiseDis)); //+ Math.round(currentTotDis));
                      $('#total_distance').val(Math.round(DayWiseDis) + Math.round(TotDayWise));
                    }
                  }
                }                
             });

            function deleteFn(delId){
              if(delId != undefined){
                $.ajax({
                 url: 'ExpenseInfo.php',
                 method: 'post',
                 dataType: 'json',                       
                 data: {"expFormId":delId },
                 success:function(data){}
               });
              }
            }
             
             $("#flash-msg").delay(3000).fadeOut("slow");
            });
        </script>
    </body>
</html>