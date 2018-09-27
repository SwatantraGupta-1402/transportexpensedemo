<?php
error_reporting(0);
    require_once('../includes/config.php');
     session_start();
    
      $session_info = $_SESSION['user_session_info'];
      $strUserName = $session_info['user_name'];
      $strUserEmailAddress = $session_info['user_email_address'];
      $intUserId = $session_info['user_id'];
     if(isset($_SESSION['user_name'])){
        if((time()-$_SESSION['last_time']) > 60*15){
            header("Location:logout.php");
        }else{
          $_SESSION['last_time'] = time();
          
              $sql_query = "SELECT full_name,project_name,user_avatar FROM user_registration WHERE user_id= '".$intUserId."'";
              $result_query = mysqli_query($connection,$sql_query);
              $row_array = mysqli_fetch_assoc($result_query);
              
             $sql_get_user = "SELECT DISTINCT user_id, full_name FROM user_registration ORDER BY full_name";
             $result_getUser = mysqli_query($connection, $sql_get_user);
             
             $sql_query_team = "SELECT esf.expense_form_id,esf.created_date,tda.candidate_name,tda.team_da FROM `expense_sheet_form` as esf 
                                INNER JOIN team_ta_da_advance_expense as tda 
                                ON tda.expense_form_id = esf.expense_form_id";
             $sql_result_team = mysqli_query($connection, $sql_query_team);
             $totrows = mysqli_num_rows($sql_result_team);
     
    
              $sql_query_user = "SELECT esf.*,ur.full_name,esf.created_date,(esf.total_distance / esf.total_diesel_leter) as diesel_avrgs FROM `expense_sheet_form` as esf INNER JOIN user_registration as ur ON esf.user_id = ur.user_id ORDER BY esf.created_date DESC";
             //$result_user = mysqli_query($connection, $sql_query_user);
     
    
     
             if(isset($_POST['from_date'])){
                 $from_date =  $_POST['from_date'];
                 $to_date =  $_POST['to_date'];
                 $emp_name = $_POST['emp_name'];
                 if($from_date != '' && $to_date == ''){
                     $to_date = date('Y-m-d');
                 }
                 if($emp_name != '' && $from_date == ''){
                    $sql_query_user = "SELECT esf.*,ur.full_name,esf.created_date FROM `expense_sheet_form` as esf INNER JOIN user_registration as ur ON esf.user_id = ur.user_id where esf.user_id = '".$emp_name."' order by esf.created_date"; 
                 }else if($emp_name != '' && $from_date != ''){
                     $sql_query_user = "SELECT esf.*,ur.full_name,esf.created_date FROM `expense_sheet_form` as esf INNER JOIN user_registration as ur ON esf.user_id = ur.user_id where esf.created_date >= '".$from_date."' and esf.created_date <= '".$to_date."' and esf.user_id = '".$emp_name."' order by esf.created_date"; 
                 }else if($from_date != '' && $to_date != ''){
                    $sql_query_user = "SELECT esf.*,ur.full_name,esf.created_date FROM `expense_sheet_form` as esf INNER JOIN user_registration as ur ON esf.user_id = ur.user_id where esf.created_date >= '".$from_date."' and esf.created_date <= '".$to_date."' order by ur.full_name, esf.created_date";
                 }else{
                    $sql_query_user = "SELECT esf.*,ur.full_name,esf.created_date FROM `expense_sheet_form` as esf INNER JOIN user_registration as ur ON esf.user_id = ur.user_id"; 
                 }
             }
     //echo $sql_query_user;
     $result_user = mysqli_query($connection, $sql_query_user);
        }
    }else{
        header('Location:../');
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
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
                                    <img alt="" class="img-circle" src="../<?php echo $row_array['user_avatar']; ?>" height="25" width="25" />
                                    <span class="username username-hide-on-mobile fontfamily" style="text-transform:uppercase;"><?php echo $row_array['full_name']; ?></span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="logout">
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
                            <li class="nav-item">
                                <a href="admin_dashboard" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title fontfamily">Dashboard</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase fontfamily">Features</h3>
                            <li class="nav-item start active open ">
                                <a href="users_expense_list" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title fontfamily">User's Expense Sheet List</span>
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
                                    <a href="dashboard.php" class="fontfamily">Dashboard</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                   <a href="users_expense_list.php" class="fontfamily">User's Expense List</a>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title fontfamily"> User's Expense List </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                         <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <form action="users_expense_list.php" method="POST" name="user_expense_form">
                                <div class="col-md-12">
                                    <div class=" form-group col-md-3">
                                        <label><strong class="fontfamily">Select From Date:</strong></label>
                                        <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="from_date" id="from_date" value="" placeholder="Start Date"/>
                                       <!--  <span class="help-block"> Select From date </span> -->
                                    </div>
                                    <div class=" form-group col-md-3">
                                        <label><strong class="fontfamily">Select To Date:</strong></label>
                                        <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="to_date" id="to_date" value="" placeholder="End Date"/>
                                       <!--  <span class="help-block"> Select From date </span> -->
                                    </div>
                                    <div class=" form-group col-md-3">
                                        <label><strong class="fontfamily">Select Employee:</strong></label>
                                        <select class="form-control" name="emp_name" id="emp_name">
                                            <option value="">---Select Name---</option>
                                             <?php while ($row_getUser = mysqli_fetch_assoc($result_getUser)) { ?>
                                            <option value="<?php echo $row_getUser['user_id']; ?>"><?php echo $row_getUser['full_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                   <div class=" form-group col-md-3">
                                       <input type="submit" name="filterBtn" class="btn btn-primary" value="Filter" style="margin-top: 24px; margin-right: 30px;">
                                    </div>
                                    <!-- <div class=" form-group col-md-3">-->
                                    <!--    <label><strong class="fontfamily">Select Project Name:</strong></label>-->
                                    <!--    <select class="form-control" name="project_name" id="project">-->
                                    <!--        <option value="">---Select Project Name---</option>-->
                                    <!--        <?php while ($row = mysqli_fetch_assoc($result_query)) { ?>-->
                                    <!--        <option value="<?php echo $row['project_name']; ?>"><?php echo $row['project_name']; ?>-->
                                    <!--        </option>-->
                                    <!--        <?php } ?>-->
                                            <!-- <option value="">Project Name 1</option>
                                    <!--        <option value="">Project Name 2</option>-->
                                    <!--        <option value="">Project Name 3</option>-->
                                    <!--        <option value="">Project Name 4</option> -->
                                    <!--    </select>-->
                                    <!--</div>-->
                                </div> 
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-table font-dark"></i>
                                            <span class="caption-subject bold uppercase fontfamily">User Expense Data List</span>
                                            <input type="button" name="exportExcel" class="btn btn-primary exprtExcel" value="Export" style="margin-left: 633px;"/>
                                        </div>
                                        <div class="tools"> </div>
                                    </div>
                                    <div class="portlet-body">
                                      <table id="example" class="table table-striped table-bordered table-hover display" style="width:100%;text-transform:uppercase;">
                                            <thead>
                                                <tr class="fontfamily">
                                                   <!--  <th>
                                                        <input type="checkbox" class="check_all" name="checkall" value="" id="check_all">
                                                    </th> -->
                                                    <th>Action</th>
                                                    <th>Date</th>
                                                    <th>Full Name</th>
                                                    <th>User Form Submission Address</th>
                                                    <th>Van Diesel</th>
                                                    <th>Diesel (Power Backup)</th>
                                                    <th>Toll & Tax</th>
                                                    <th>Van Repair</th>
                                                    <th>Van Driver Advance</th>
                                                    <th>Room rent</th>
                                                    <th>Team DA</th>
                                                    <th>Mobile Recharge</th>
                                                    <th>ATM Charge</th>
                                                    <th>Stationary</th>
                                                    <th>Travelling</th>
                                                    <th>Repair</th>
                                                    <th>Premission</th>
                                                    <th>Purchase</th>
                                                    <th>Others</th>
                                                    <th>Total Expense</th>
                                                    <th>Opening Balance</th>
                                                    <th>Receiveing Amount</th>
                                                    <th>Total Amount</th>
                                                    <th>Balance</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Start Reading</th>
                                                    <th>Closing Reading</th>
                                                    <th>Day Wise Distance</th>
                                                    <th>Total Distance</th>
                                                    <th>Diesel (Litre)</th>
                                                    <th>Total Diesel (Liter)</th>
                                                    <th>Average (KM)</th> 
                                                </tr>
                                            </thead>
                                            <tbody class="fontfamily" style="text-transform: uppercase;">
                                               <?php while($row_user = mysqli_fetch_assoc($result_user)){ ?> 
                                                <tr>
                                                    <!-- <td>
                                                    <input type="checkbox" name="check" class="check_single" value="" id="check_id">
                                                    </td> -->
                                                    <td><a href="update_expense_sheet_form?ID=<?php echo base64_encode($row_user['expense_form_id']); ?>" class="btn btn-info">Edit</a></td>
                                                    <td><?php echo date('Y-m-d',strtotime($row_user['created_date'])); ?></td>
                                                    <td><?php echo $row_user['full_name']; ?></td>
                                                    <td><?php echo $row_user['geo_location']; ?></td>
                                                    <td><?php echo number_format($row_user['diesel_van_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['diesel_power_backup_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['toll_road_tax_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['van_repair_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['van_driver_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['room_rent_expense'],2); ?></td>
                                                    <td>
                                                    <table id="" class="table table-striped table-bordered table-hover display taTeamData" style="width:100%">
                                                        <thead>
                                                          <tr class="fontfamily">
                                                           <th style="display: none;">Full Name</th>
                                                            <th><strong>Candidate Name</th>
                                                            <th>Team Da</br></th>
                                                          </tr>
                                                        </thead>
                                                        <tbody class="fontfamily">
                                                          <?php
                                                        $sql_expForm = "SELECT * FROM expense_sheet_form WHERE user_id= '".$row_user['user_id']."'";
                                                        $res_expForm_query =  mysqli_query($connection,$sql_expForm);
                                                        $expFormId ='';
                                                        while($row = mysqli_fetch_assoc($res_expForm_query)){ 
                                                        $expFormId=$row['expense_form_id'];
                                                        $sql_ta_da = "SELECT * FROM team_ta_da_advance_expense WHERE expense_form_id= '".$expFormId."' AND created_date = '".$row_user['created_date']."'";
                                                        $res_tada_query =  mysqli_query($connection,$sql_ta_da);
                                                        while($row_tada = mysqli_fetch_assoc($res_tada_query)){ ?>
                                                          <tr>
                                                            <td style="display: none;"><?php echo $row_user['full_name']; ?></td>
                                                            <td><?php echo $row_tada['candidate_name']; ?></td>
                                                            <td><?php echo $row_tada['team_da']; ?></br></td>
                                                          </tr>
                                                          <?php }}?>
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                    <td><?php echo number_format($row_user['mobile_recharge_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['atm_charge_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['stationary_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['travelling_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['electronic_item_repair_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['permission_expense'],2); ?></td>
                                                    <td><?php echo number_format($row_user['purchase_item_cost'],2); ?></td>
                                                    <td>
                                                    <table id="" class="table table-striped table-bordered table-hover display otherData" style="width:100%">
                                                        <thead>
                                                          <tr class="fontfamily">
                                                            <th style="display: none;">Full Name</th>
                                                            <th>Description</th>
                                                            <th>Expense</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody class="fontfamily">
                                                          <?php
                                                        $sql_expForm = "SELECT * FROM expense_sheet_form WHERE user_id= '".$row_user['user_id']."'";
                                                        $res_expForm_query =  mysqli_query($connection,$sql_expForm);
                                                        $expFormId ='';
                                                        while($row = mysqli_fetch_assoc($res_expForm_query)){ 
                                                        $expFormId=$row['expense_form_id'];
                                                        $expCreatedDate = $row['created_date'];
                                                        $sql_oth_exp = "SELECT * FROM others_expenses WHERE expense_form_id= '".$expFormId."' AND created_date = '".$row_user['created_date']."'";
                                                        $res_othexp_query =  mysqli_query($connection,$sql_oth_exp);
                                                        while($row_othExp = mysqli_fetch_assoc($res_othexp_query)){ ?>
                                                          <tr>
                                                            <td style="display: none;"><?php echo $row_othExp['full_name']; ?></td>
                                                            <td><?php echo $row_othExp['expense_desc']; ?></td>
                                                            <td><?php echo $row_othExp['others_expense']; ?></td>
                                                          </tr>
                                                          <?php }}?>
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                    <td><?php echo number_format($row_user['total_expense_day_wise'],2); ?></td>
                                                    <td><?php echo number_format($row_user['opening_balance'],2); ?></td>
                                                    <td><?php echo number_format($row_user['receiveing_amount'],2); ?></td>
                                                    <td><?php echo number_format($row_user['receiveing_amount'] + $row_user['opening_balance'],2); ?></td>
                                                    <td><?php echo number_format($row_user['total_balance'],2); ?></td>
                                                    <td><?php echo $row_user['from_source_place']; ?></td>
                                                    <td><?php echo $row_user['to_destination_place']; ?></td>
                                                    <td><?php echo $row_user['start_meter_reading']; ?></td>
                                                    <td><?php echo $row_user['closing_meter_reading']; ?></td>
                                                    <td><?php echo $row_user['day_wise_distance']; ?></td>
                                                    <td><?php echo $row_user['total_distance']; ?></td>
                                                    <td><?php echo $row_user['diesel_in_liter']; ?></td>
                                                    <td><?php echo $row_user['total_diesel_leter']; ?></td>
                                                    <td><?php echo number_format($row_user['diesel_avrgs'],2); ?></td>
                                                </tr>
                                              <?php } ?>
                                            </tbody>
                                        </table>
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
        <script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js" type="text/javascript"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            $( ".date-picker" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $('#example').DataTable( {
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
                    // 'copy',
                    'csv',
                    'excel',
                      
                ],
                select: true
            } );

            $("#check_all").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });
        </script>
    </body>
</html>