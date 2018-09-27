<?php 
    require_once('../includes/config.php');
    error_reporting(0);
    session_start();
     $session_info          = $_SESSION['user_session_info'];
     $strUserName           = $session_info['user_name'];
     $strUserEmailAddress   = $session_info['user_email_address'];
     $intUserId             = $session_info['user_id'];
     $ExpenseID = $_GET['expense_form_id'];
     date_default_timezone_set('Asia/Kolkata');
     $today_date = date("Y-m-d");
     
     if(isset($_SESSION['user_name'])){
        if((time()-$_SESSION['last_time']) > 60*15){
            header("Location:../logout.php");
        }else{
          $_SESSION['last_time'] = time();

     /* Select Query for Vehicle Type data on Expense Sheet Form Start Here */ 

        $sql_vehicle = "SELECT * FROM vehicle_type";
        $result_vehicle = mysqli_query($connection, $sql_vehicle);      


      /* Select Query for Vehicle Type data on Expense Sheet Form End Here */ 

      $sql_query_user_info = "SELECT ur.full_name,ur.user_avatar,ur.vehicle_reg,ur.vehicle_type,vt.vehicle_avg FROM user_registration as ur LEFT JOIN vehicle_type as vt ON vt.vehicle_type_id = ur.vehicle_type_id WHERE ur.user_id=".$intUserId;
      $result_user_info = mysqli_query($connection,$sql_query_user_info);
      $row_array_user_info = mysqli_fetch_assoc($result_user_info);
      
      $sql_query_user = "SELECT expense_form_id,total_balance,total_distance,created_date,opening_balance,total_expense FROM `expense_sheet_form` WHERE user_id='".$intUserId."' ORDER BY created_date DESC LIMIT 1";
      $result_query = mysqli_query($connection,$sql_query_user);
      $row_array = mysqli_fetch_assoc($result_query);
      
      $sql_query_aggregate = "SELECT SUM(day_wise_distance) as tot_dist,SUM(diesel_in_liter) as tot, (SUM(day_wise_distance)/(SUM(diesel_in_liter))) as diesel_avgs FROM `expense_sheet_form` WHERE user_id='".$intUserId."'";
      $result_query_agg = mysqli_query($connection,$sql_query_aggregate);
      $row_array_agg = mysqli_fetch_assoc($result_query_agg);

      date_default_timezone_set('Asia/Kolkata');
     if(isset($_POST['submit'])){
        $intDieselVanRent           = $_POST['diesel_van'];
        $intExpenseId               = $_POST['expense_id']; 
        $intDieselVanPowerBackup    = $_POST['diesel_power_backup'];
        $intTollRoadTax             = $_POST['toll_road_tax'];
        $ExpenseDate                = $_POST['expense_date'];
        $intVanRepair               = $_POST['van_repair'];
        $intVanDriverAdvance        = $_POST['van_driver_advance'];
        $intRoomRent                = $_POST['room_rent'];
        $strCandidateName           = $_POST['candidate_name']; 
        $intTeamDa                  = $_POST['team_da'];
        $intMobileRecharge          = $_POST['mobile_recharge'];
        $intATMCharge               = $_POST['atm_charge'];
        $intStationary              = $_POST['stationary'];
        $Travelling                 = $_POST['travelling_expense'];
        $intRepair                  = $_POST['repair_item'];
        $intPermission              = $_POST['permission'];
        $intPurchase                = $_POST['purchase_cost'];
        $intOthers                  = $_POST['others'];        
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
        $intTotalDieselLeter        = $_POST['total_diesel_leter'];
        $strVehicleReg              = $_POST['vehicle_reg'];
        $strVehicleType             = $_POST['vehicle_type'];
        $strGeoLocation             = $_POST['geo_location'];
        $created_by                 = $strUserName;
        $created_date               = $today_date;
        //$currentDate                = DATE("Y-m-d");

        $sql_query = "SELECT * FROM expense_sheet_form WHERE created_date = '".$today_date."'";
        $sql_result = mysqli_query($connection, $sql_query);
        $num_rows = mysqli_fetch_assoc($sql_result);
        if($num_rows > 0){
    
            $err_msg = '<div class="alert alert-danger">
                            <h3>Oopss!</h3> <strong>Today, One record already Exist. </strong>
                        </div>';

        }else{


    
   $sql_query_insert = "INSERT INTO `expense_sheet_form` 
        (user_id,diesel_van_expense,diesel_power_backup_expense,toll_road_tax_expense,van_repair_expense,
        van_driver_expense,room_rent_expense,mobile_recharge_expense,atm_charge_expense,
        stationary_expense,travelling_expense,electronic_item_repair_expense,permission_expense,purchase_item_cost,total_expense_day_wise,total_expense,opening_balance,receiveing_amount,
        total_balance,from_source_place,to_destination_place,start_meter_reading,closing_meter_reading,day_wise_distance,total_distance,diesel_in_liter,total_diesel_leter,vehicle_reg,vehicle_type,geo_location,created_by,created_date) 
        VALUES('$intUserId',
        '$intDieselVanRent',
        '$intDieselVanPowerBackup',
        '$intTollRoadTax',
        '$intVanRepair',
        '$intVanDriverAdvance',
        '$intRoomRent',
        '$intMobileRecharge',
        '$intATMCharge',
        '$intStationary',
        '$Travelling',
        '$intRepair',
        '$intPermission',
        '$intPurchase',
        '$intTotalExpenseDay',
        '$intTotalAmount',
        '$intOpeningBalance',
        '$intReceiveAmount',
        '$intTotalBalance',
        '$strFrom',
        '$strTo',
        '$strStartMeterReading',
        '$strClosingMeterReading',
        '$strDayWiseDistance',
        '$intTotalDistance',
        '$intDieselLiter',
        '$intTotalDieselLeter',
        '$strVehicleReg',
        '$strVehicleType',
        '$strGeoLocation',
        '$created_by',
        '$ExpenseDate')";
   
        $result_query = mysqli_query($connection, $sql_query_insert);
        $last_id = mysqli_insert_id($connection);

        /* Team TA DA Other Expense Info Add more Field Insert Query Start Here */
                      if($_POST['candidate_name'] !=''){
                          foreach ( $_POST['candidate_name'] as $key=>$value ) {
                          $values_4   = $last_id;
                          $values_8 = $value;
                          $values_7   = $_POST['team_da'][$key];
                          $values_5   = $created_by;
                          $values_6   = $ExpenseDate;
                   
                       $sql_query_insert_2 = "INSERT INTO `team_ta_da_advance_expense` 
                                      (expense_form_id,
                                      candidate_name,
                                      team_da,
                                      created_by,
                                      created_date) 
                                      VALUES 
                                      ( '$values_4',
                                        '$values_8',
                                        '$values_7',
                                        '$values_5',
                                        '$values_6')";
                                $result_query_2 = mysqli_query($connection,$sql_query_insert_2);
                                 $success_msg = '<div class="alert alert-success">
                            <strong>Success!</strong> Others Expenses Data has been Submitted successfully.
                        </div>'; 
                          } 
                        }
    /* Team TA DA Other Expense Info Add more Field Insert Query End Here */

               
        /* Others Expense Info Add more Field Insert Query Start Here */
                      if($_POST['others'] !=''){
                          foreach ( $_POST['others'] as $key=>$value ) {
                          $values_1   = $last_id;
                          $values_rel = $value;
                          $values_9   = $_POST['expense_description'][$key];
                          $values_2   = $created_by;
                          $values_3   = $ExpenseDate;
                   
                       $sql_query_insert_1 = "INSERT INTO `others_expenses` 
                                      (expense_form_id,
                                      expense_desc,
                                      others_expense,
                                      created_by,
                                      created_date) 
                                      VALUES 
                                      ( '$values_1',
                                        '$values_9',
                                        '$values_rel',
                                        '$values_2',
                                        '$values_3')";
                                $result_query_1 = mysqli_query($connection,$sql_query_insert_1);
                                 $success_msg = '<div class="alert alert-success">
                            <strong>Success!</strong> Others Expenses Data has been Submitted successfully.
                        </div>'; 
                          } 
                        }
    /* Others Expense Info Add more Field Insert Query End Here */
                if($result_query){
                    $success_msg = '<div class="alert alert-success">
                                    <strong>Success!</strong> Data has been submitted successfully.
                                </div>';
                    
                        header("Location: expense_sheet_form.php");
                        }else{
                            $err_msg = '<div class="alert alert-danger">
                                    <strong>Oopss!</strong> Something went wrong.
                            </div>';
                        }
                    }
                    mysqli_close($connection);
                }
            }
        }else{
        header('Location:../');
    }


 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>BTL | User Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for bootstrap inputs, input groups, custom checkboxes and radio controls and more" name="description" />
        <meta content="" name="author" />
        <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
         <link rel="shortcut icon" href="favicon.ico" /> 
         <style>
            .fontfamily{
            font-family: Cambria;
            }
        </style> 
        <link rel="shortcut icon" href="favicon.ico" /> 
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="index">
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
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="../<?php echo $row_array_user_info['user_avatar']; ?>" height="25" width="25" />
                                    <span class="username username-hide-on-mobile fontfamily" style="text-transform: uppercase;"><?php echo $row_array_user_info['full_name']; ?></span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="../logout">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                           
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
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <li class="sidebar-search-wrapper">
                            </li>
                            <li class="">
                                <a href="index" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase">Features</h3>
                            </li>
                            <li class="nav-item start active open">
                                <a href="expense_sheet_form" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title">Expense Sheet Form</span>
                                </a>
                            </li>
                             <li class="nav-item start">
                                <a href="expense_sheet_list" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title">Expense Sheet List</span>
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
                                    <a href="#">Home</a>
                                    <!-- <i class="fa fa-circle"></i> -->
                                </li>
                            </ul>
                        </div>
                        <br>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <!-- <h1 class="page-title"> BTL Expense Sheet Form for Employee's </h1> -->
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                         <div id="flash-msg">
                              <p> <?php if(isset($err_msg)) { echo $err_msg; } 
                                  if(isset($success_msg)) { echo $success_msg; 
                                } ?>    
                              </p>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="icon-settings font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase"> Day wise Expense Sheet Form</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" style="text-transform:uppercase;">
                                        <form role="form" method="post" action="expense_sheet_form.php" id="expense_sheet_form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                         <div id="output"></div>
                                                          <input type="hidden" name="geo_location" id="geo_location" value="">
                                                        <div class="form-group col-md-4">
                                                             <label for="expense_date"><strong>Select Expense Date:</strong></label>
                                                             <br> <br>
                                                            <div class="input-group">
                                                                <i class="fa fa-calendar fa-2x" ></i>
                                                                <input type="text" class="form-control" placeholder="Select Expense Date" name="expense_date" id="datepicker_expense" value="" style="border-radius: 5px;margin-top:-29px;margin-left:28px;text-transform:uppercase;" required=""> 
                                                            </div>
                                                            <span id="dateErr" style="color:red"></span>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                             <label for="vehicle_reg"><strong>Select Vehicle No:</strong></label>
                                                              <br><br>
                                                                <div class="input-group">
                                                                <i class="fa fa-bus fa-2x" ></i>
                                                                <input type="text" class="form-control uppercase" placeholder="Vehicle Reg. No" name="vehicle_reg" id="vehicle_reg" value="<?php echo $row_array_user_info['vehicle_reg'] ?>" style="border-radius: 5px;margin-top:-29px;margin-left:28px;" readonly="readonly"> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 pull-right">
                                                             <label for="vehicle_type"><strong>Select Vehicle Type:</strong></label>
                                                             <br> <br>
                                                            <div class="">
                                                                <i class="fa fa-bus fa-2x" ></i>
                                                                <input type="text" class="form-control" placeholder="Vehicle Type" name="vehicle_type" id="vehicle_type" value="<?php echo $row_array_user_info['vehicle_type'] ?>" style="border-radius: 5px;margin-top:-29px;margin-left:28px;" readonly="readonly"> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                 </div>
                                                 <hr>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                    <input type="hidden" name="expense_form_id" value="<?php echo $row_array['expense_form_id']; ?>">
                                                        <label for="diesel_van"><strong>Diesel Van:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Diesel Van Detail" name="diesel_van" id="diesel_van" value="" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="diesel_power_backup"><strong>Diesel (Power Backup):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Diesel (Power Backup)" name="diesel_power_backup" value="" id="diesel_power_backup" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="toll_road_tax"><strong>Toll Tax & Road Tax:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Toll Tax & Road Tax" name="toll_road_tax" id="toll_road_tax" value="" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="van_repair"><strong>Van Repair:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Van Repair Cost" name="van_repair" id="van_repair" style="border-radius: 5px;" value="" > 
                                                        </div>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="van_driver_advance"><strong>Van Driver Advance:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Van Driver Advance" name="van_driver_advance" style="border-radius: 5px;" value="" id="van_driver_advance"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="roorm_rent"><strong>Room Rent</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Room Rent" name="room_rent" id="room_rent" style="border-radius: 5px;" value="" > 
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="mobile_recharge"><strong>Mobile Recharge</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Mobile Recharge" name="mobile_recharge" id="mobile_recharge" style="border-radius: 5px;" value="" > 
                                                        </div>
                                                    </div>
                                                </div>
                                                   
                                                    <div class="row col-md-12">
                                                      <div class=" form-group col-md-6"><hr>
                                                        <label class="hint" style="color: blue;margin-left:20px;"><strong>Team DA & Advance Details:</strong></label>
                                                           <div class="input-group field_wrapper_advance">
                                                             <div class="row" style="margin-left: 0px;">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Candidate Name" name="candidate_name[]" id="candidate_name" style="border-radius: 5px;text-transform:uppercase;"> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control calc" placeholder="Team DA Amount" name="team_da[]" id="team_da" style="border-radius: 5px;">
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:void(0);" class="add_button_advance" title="Add Others Field"><img src="../avatar/add.png" class="pull-right" style="border-radius: 5px;margin-top: 10px;margin-right: -15px;" width="15px" height="15px"></a> 
                                                            </div>    
                                                        </div>
                                                    </div>
                                                        <div class="form-group col-md-6"><hr>
                                                              <label class="hint" style="color: blue;margin-left:20px;"><strong>Other Expense Details:</strong></label>
                                                                 <div class="input-group field_wrapper_others">
                                                                   <div class=" form-group row" style="margin-left: 0px;">
                                                                      <div class="col-md-6">
                                                                          <div class="form-group">
                                                                              <input type="text" class="form-control" placeholder="Other Expense Info" name="expense_description[]" id="expense_description" style="border-radius: 5px;text-transform:uppercase;"> 
                                                                          </div>
                                                                      </div>
                                                                      <div class="col-md-6">
                                                                          <div class="form-group">
                                                                              <input type="text" class="form-control calc" placeholder="Others Expense Amount" name="others[]" id="others" style="border-radius: 5px;">
                                                                          </div>
                                                                      </div>
                                                                      <a href="javascript:void(0);" class="add_button_others" title="Add Others Field"><img src="../avatar/add.png" class="pull-right" style="border-radius: 5px;margin-top:10px;margin-right: -15px;" width="15px" height="15px"></a>
                                                                  </div>    
                                                              </div>
                                                          </div>
                                                      </div>

                                                <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="atm_charge"><strong>ATM Charge</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="ATM Charge" name="atm_charge" id="atm_charge" style="border-radius: 5px;" value="" > 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="stationary"><strong>Stationary:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Stationary" name="stationary" id="stationary" style="border-radius: 5px;" value="" > 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="travelling_expense"><strong>Travelling (Auto/Rikshaw):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Traveling Expense" name="travelling_expense" id="travelling_expense" style="border-radius: 5px;" value="" > 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="repair_item"><strong>Repair (Electronics Item):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control calc" placeholder="Repair Electronic Item" name="repair_item" id="repair_item" style="border-radius: 5px;" value="" > 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="form-group col-md-3">
                                                            <label for="permission"><strong>Permission (Police/Municipal):</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control calc" placeholder="Permission Charge" id="permission" name="permission" style="border-radius: 5px;" value="" > 
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="purchase_cost"><strong>Purchase (Any Item):</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control calc" placeholder="Purchase Item Cost" name="purchase_cost" id="purchase_cost" style="border-radius: 5px;" value="" > 
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="total_expense_day"><strong>Total Expense (Day Wise):</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control total" placeholder="Total Amount" name="total_expense_day" required="" value="<?php echo $intTotalDayWiseAmount ?>" id="total_expense_day" style="border-radius: 5px;" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="total_amount"><strong>Total Amount:</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control total_amt" placeholder="Total Amount" name="total_amount" required="" value="<?php echo $intTotalexpense; ?>" id="total_amount" style="border-radius: 5px;" readonly="readonly"> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                    <!-- <div class="form-group col-md-3">
                                                        <label for="total_amount"><strong>Total Amount:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control total_amt" placeholder="Total Amount" name="total_amount" required="" value="<?php echo $intTotalexpense; ?>" id="total_amount" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group col-md-3">
                                                        <label for="balance"><strong>Opening Balance:</strong></label>
                                                        <div class="input-group">     
                                                             <input type="text" class="form-control opening" placeholder="Opening Balance" name="opening_balance" id="opening_balance" required="" value="<?php echo $row_array['total_balance']; ?>" style="border-radius: 5px;" readonly="readonly">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="rcv_amt"><strong>Received Amount:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control abcd" placeholder="Received Amount" name="received_amount" id="received_amount" value="" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="total_balance"><strong>Total Balance:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Total Balance" name="total_balance" id="total_balance" required="" value="" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                   
                                                    <div class="col-md-12">
                                                      <p class="hint" style="color: blue;margin-left:28px;"><strong>Van Log Book Details:</strong></p>
                                                        <div class="form-group col-md-3">
                                                            <label for="from"><strong>From:</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="From (Source Palce Name)" name="from" id="from" required="" value="" style="border-radius: 5px;text-transform:uppercase;"> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="to"><strong>To:</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="To (Desti. Palce Name)" name="to" id="to" value="" required="" style="border-radius: 5px;text-transform:uppercase;"> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="start_meter_reading"><strong>Start Meter Reading (KM):</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control meter_reading" placeholder="Starting Meter Reading" id="start_meter_reading" name="start_meter_reading" value="" required="" style="border-radius: 5px;"> 
                                                              <span style="color:red" id="startmeterErr"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="closing_meter_reading"><strong>Closing Meter Reading (KM):</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control meter_reading" placeholder="Closing Meter Reading" id="closing_meter_reading" name="closing_meter_reading" value="" required="" style="border-radius: 5px;"> 
                                                                <span style="color:red" id="closemeterErr"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                                <div class="col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="day_wise_distance"><strong>Day Wise Distance (KM):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control tot_dis" placeholder="Day Wise Distance (KM)" id="day_wise_distance" name="day_wise_distance" value="" required="" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="total_distance"><strong>Total Distance (KM):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Total Distance" id="total_distance" name="total_distance" value="<?php echo $row_array_agg['tot_dist']; ?>" required="" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="diesel_leter"><strong>Diesel (Ltr):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Diesel in Litre" name="diesel_leter" id="diesel_leter" value="" required="" style="border-radius: 5px;"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="diesel_leter"><strong>Total Diesel (Ltr):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Total Diesel in Litre" name="total_diesel_leter" id="total_diesel_leter" value="<?php echo $row_array_agg['tot']; ?>" required="" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-12">
                                                  <div class="form-group col-md-3">
                                                        <label for="diesel_leter"><strong>Avg Diesel (Ltr):</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder=" Avg Diesel in Litre" name="avg_diesel_leter" id="avg_diesel_leter" value="<?php echo number_format($row_array_agg['diesel_avgs'],2); ?>" required="" style="border-radius: 5px;" readonly="readonly"> 
                                                        </div>
                                                    </div>
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
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner" style="margin-left:600px;"> 2018 &copy; BTL Pramotions Advertising Pvt. Ltd.   
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
        <!-- BEGIN CORE PLUGINS -->
        
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!--<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script> -->
        <script type="text/javascript">  

            $(document).ready(function(){
              $(function() {
                var userId = <?php echo json_encode($intUserId); ?>;
                $( "#datepicker_expense" ).datepicker({
                    dateFormat:"yy-mm-dd",
                    onSelect: function(dateText, inst) {
                      $('#dateErr').text('');
                      $.ajax({
                       url: 'ExpenseInfo.php',
                       method: 'post',
                       dataType: 'json',                       
                       data: {"user_id":userId, "exp_date":$(this).val() },
                       success:function(data){
                        if(data['isRedirect']){
                          var getUrl = window.location;
                          var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                          window.location.href = baseUrl+'/user-login/expense_sheet_list.php';
                        }else if(data['isError']){
                          $('#datepicker_expense').val('');
                          $('#dateErr').text(data['msg']);
                        }
                      }
                     });
                  }
                });
              });

                var openBal = $('#opening_balance').val() == '' ? 0 : parseInt($('#opening_balance').val());
                var totamt = openBal;
                $('#total_amount').val(openBal);

                var Disopen = $('#total_distance').val();
                var totamtdis = Disopen;
                //alert(totamtdis);
                

               /* Script for Adding more row in Others Field Start Here */

                var maxField = 10; //Input fields increment limitation
                var x = 1; //Initial field counter is 1
                var addButton = $('.add_button_others'); //Add button selector
                var wrapper = $('.field_wrapper_others'); //Input field wrapper
                var fieldHTML = '<div class=" form-group row" style="margin-left: 0px;"><div class="col-md-6"><div class="form-group"><input type="text" class="form-control" placeholder="Other Expense Info" name="expense_description[]" id="expense_description" style="border-radius: 5px;text-transform:uppercase;"></div></div><div class="col-md-6"><div class="form-group"><input type="text" class="form-control calc" placeholder="Others Expense Amount" name="others[]" id="others" style="border-radius: 5px;"></div></div><a href="javascript:void(0);" class="remove_button_others" title="Remove Others Field"><img src="../avatar/remove.png" class="pull-right" style="border-radius: 5px;margin-top:10px;margin-right: -15px;" width="15px" height="15px"></a></div>'; 
                 
                
                $(addButton).click(function(){
                    if(x < maxField){ 
                        x++;
                        $(wrapper).append(fieldHTML);
                    }
                });
                
                //Once remove button is clicked
                $(wrapper).on('click', '.remove_button_others', function(e){
                    e.preventDefault();
                    var tempVal = $(this).parent('div').find('.calc').val() == '' ? 0 : parseInt($(this).parent('div').find('.calc').val());
                    var totVal = $('.total').val() == '' ? 0 : parseInt($('.total').val())
                    $('.total').val(totVal - tempVal);
                    $(this).parent('div').remove(); //Remove field html
                    x--; //Decrement field counter
                });
                /* Script for Adding more row in Others Field End Here */ 

                /* Script for Adding more row in Team DA & Advance Field Start Here */

                var maxField = 10; //Input fields increment limitation
                var x = 1; //Initial field counter is 1
                var addButton = $('.add_button_advance'); //Add button selector
                var advance = $('.field_wrapper_advance'); //Input field wrapper
                var fieldHTMLS = '<div class="form-group row" style="margin-left: 0px;"><div class="col-md-6"><div class="form-group"><input type="text" class="form-control" placeholder="Candidate Name" name="candidate_name[]" id="candidate_name" style="border-radius: 5px;"></div></div><div class="col-md-6"><div class="form-group"><input type="text" class="form-control calc" placeholder=" Team DA Amount" name="team_da[]" id="team_da" style="border-radius: 5px;"></div></div><a href="javascript:void(0);" class="remove_button_advance" title="Add Others Field"><img src="../avatar/remove.png" class="pull-right" style="border-radius: 5px;margin-top: 10px;margin-right: -15px;" width="15px" height="15px"></a></div>'; 
                
                $(addButton).click(function(){
                    if(x < maxField){ 
                        x++;
                        $(advance).append(fieldHTMLS);
                    }
                });
                
                //Once remove button is clicked
                $(advance).on('click', '.remove_button_advance', function(e){
                    e.preventDefault();
                    var tempVal = $(this).parent('div').find('.calc').val() == '' ? 0 : parseInt($(this).parent('div').find('.calc').val());
                    var totVal = $('.total').val() == '' ? 0 : parseInt($('.total').val())
                    $('.total').val(totVal - tempVal);
                    $(this).parent('div').remove(); //Remove field html
                    x--; //Decrement field counter
                });

             /* Script for Adding more row in Team DA & Advance Field End Here */

              var total_balance = 0;
              $('body').keyup( ".calc", function(e) {                    
                  var sum = 0;
                  $(".calc").each(function(){
                      sum = $(this).val() == '' ? sum : sum+parseInt($(this).val());
                  });
                  $("#total_expense_day").val(sum); 
                  total_balance = totamt - sum;
                  $('#total_balance').val(total_balance);

              });

             $('#received_amount').on('keyup', function() {
                var recvAmt = $(this).val() == '' ? 0 : parseInt($(this).val());
                totamt = openBal + recvAmt;
                $('#total_amount').val(totamt);
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

             var TotDayWiseDiesel = $('#total_diesel_leter').val() == '' ? 0 : parseInt($('#total_diesel_leter').val());
             $('#diesel_leter').on('keyup', function() {
                var DiselInLtr = $(this).val() == '' ? 0 : parseInt($(this).val());
                $('#total_diesel_leter').val(Math.round(DiselInLtr) + Math.round(TotDayWiseDiesel));
                //alert($('#total_diesel_leter').val(Math.round(DiselInLtr) + Math.round(TotDayWiseDiesel)));
              });

             $("#flash-msg").delay(3000).fadeOut("slow");
             
            });
        </script>
        <script type="text/javascript">  

            $(document).ready(function(){
             var x = document.getElementById('output');
                  if(navigator.geolocation){
                    navigator.geolocation.getCurrentPosition(showPosition,  showError);
                  }else{
                    x.innerHTML = "Browser doesn't Support.";
                  }
                  
                  function showError(error) {
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            var blocklocation = "User denied the request for Geolocation."
                            var blockLoc = $('#geo_location').val(blocklocation);
                            break;
                        case error.POSITION_UNAVAILABLE:
                           var blocklocation = "Location information is unavailable."
                           var blockLoc = $('#geo_location').val(blocklocation);
                            break;
                        case error.TIMEOUT:
                            var blocklocation = "The request to get user location timed out."
                            var blockLoc = $('#geo_location').val(blocklocation);
                            break;
                        case error.UNKNOWN_ERROR:
                            var blocklocation = "An unknown error occurred."
                            var blockLoc = $('#geo_location').val(blocklocation);
                            break;
                    }
                }
                
                function showPosition(position){
                  var lat = position.coords.latitude; 
                  var long =position.coords.longitude;
                  //alert(lat+','+long);

                  var geocodeFromLatLong = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+position.coords.latitude+','+position.coords.longitude+'&sensor=true_or_false&key=AIzaSyBP1BnaAFDKaddAUPcL8q3Z0POOXQ0ZqfQ';
                    $.get({
                      url : geocodeFromLatLong,
                      success : function(data){
                        console.log(data);
                      var geoloca = data.results[1].formatted_address;
                      var geolocation_address = $('#geo_location').val(data.results[1].formatted_address);
                      //alert(geolocation_address);
                      }
                    });
                }
            });
        </script>
    </body>
</html>
