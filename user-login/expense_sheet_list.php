<?php 
error_reporting(0);
 include('../includes/config.php');

    session_start();
    $session_info = $_SESSION['user_session_info'];
      $strUserName = $session_info['user_name'];
      $strUserEmailAddress = $session_info['user_email_address'];
      $intUserId = $session_info['user_id'];
     
    date_default_timezone_set('Asia/Kolkata');
        if(isset($_SESSION['user_name'])){
        if((time()-$_SESSION['last_time']) > 60*15){
            header("Location:../logout.php");
        }else{
          $_SESSION['last_time'] = time();
          
      /* Query for calculating Total Expenses Start Here */

            $sql_expense = "SELECT esf.total_balance,SUM(esf.total_expense_day_wise) as tot_exp,SUM(esf.total_balance) as total_bal, (SUM(esf.receiveing_amount)-SUM(esf.total_expense_day_wise)) as tot_bal, SUM(esf.day_wise_distance) as tot_dis, SUM(esf.diesel_in_liter) as tot_diesel, SUM(esf.receiveing_amount) as tot_recv,(SUM(esf.day_wise_distance)/ SUM(esf.diesel_in_liter)) as diesel_avrgs FROM expense_sheet_form as esf
            LEFT JOIN user_registration as ur ON ur.user_id = esf.user_id
            LEFT JOIN vehicle_type as vt ON vt.vehicle_type_id = ur.vehicle_type_id 
            WHERE ur.user_id='".$intUserId."'";
            $sql_result = mysqli_query($connection, $sql_expense);
            $row_expense = mysqli_fetch_assoc($sql_result);
        
       /* Query for calculating Total Expenses End Here */

              $sql_query_user = "SELECT esf.*,ur.full_name,tda.candidate_name,tda.team_da,esf.day_wise_distance,(esf.total_distance / esf.total_diesel_leter) as diesel_avrgs
              FROM `expense_sheet_form` as esf 
              LEFT JOIN user_registration as ur ON esf.user_id = ur.user_id 
              LEFT JOIN team_ta_da_advance_expense as tda ON tda.expense_form_id = esf.expense_form_id
              WHERE esf.user_id = '".$intUserId."' GROUP BY esf.expense_form_id ORDER BY esf.created_date";
              $result_user = mysqli_query($connection, $sql_query_user);
             
              $sql_query = "SELECT full_name,project_name,user_avatar FROM user_registration WHERE user_id= '".$intUserId."'";
              $result_query = mysqli_query($connection,$sql_query);
              $row_array = mysqli_fetch_assoc($result_query);
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
        <title>BTL | User Admin Dashboard</title>
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
        <!-- <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" /> -->
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
         <style>
            .fontfamily{
            font-family: Cambria;
            }
        </style> 
    </head>

        <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
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
                                    <span class="username username-hide-on-mobile fontfamily" style="text-transform: uppercase;"><?php echo $row_array['full_name']; ?></span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="../logout">
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
                            <li class="nav-item start ">
                                <a href="index" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title fontfamily">Dashboard</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase fontfamily">Features</h3>
                            </li>
                            <!-- <li class="nav-item  ">
                                <a href="users_expense_list.php" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title">User's Expense List</span>
                                </a>
                            </li> -->
                            <li class="nav-item  ">
                                <a href="expense_sheet_form" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title fontfamily">Expense Sheet Form</span>
                                </a>
                            </li>
                             <li class="nav-item start active open">
                                <a href="expense_sheet_list" class="nav-link nav-toggle">
                                    <i class="icon-briefcase"></i>
                                    <span class="title fontfamily">Expense Sheet Details List</span>
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
                        <h1 class="page-title fontfamily"> User Dashboard </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-table font-dark"></i>
                                            <span class="caption-subject bold uppercase fontfamily">User Data Tables</span>
                                        </div>
                                        <div class="tools"> </div>
                                    </div>
                                    <div class="portlet-body fontfamily">
                                       <table id="example" class="table table-striped table-bordered table-hover fontfamily" style="width:100%;text-transform: uppercase;">
                                            <thead>
                                                <tr class="fontfamily">
                                                    <th>Full Name</th>
                                                    <th>Created Date</th>
                                                    <th>Opening Balance</th>
                                                    <th>Receiveing Amount</th>
                                                    <th>Total Amount</th>
                                                    <th>Total Expense (Day Wise)</th>
                                                    <th>Closing Balance</th>
                                                    <th>Action</th>
                                                    <th>Team Advance TA</th>
                                                    <th>Others</th>
                                                     <th>Van Diesel</th>
                                                    <th>Diesel (Power Backup)</th>
                                                    <th>Toll & Tax</th>
                                                    <th>Van Repair</th>
                                                    <th>Van Driver Advance</th>
                                                    <th>Room rent</th>
                                                    <th>Mobile Recharge</th>
                                                    <th>ATM Charge</th>
                                                    <th>Stationary</th>
                                                    <th>Travelling</th>
                                                    <th>Repair</th>
                                                    <th>Premission</th>
                                                    <th>Purchase</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Start Reading</th>
                                                    <th>Closing Reading</th>
                                                    <th>Day Wise Distance</th>
                                                    <th>Total Distance</th>
                                                    <th>Diesel (Litre)</th>
                                                    <th>Total Diesel (Litre)</th>
                                                    <th>Vehicle Avg (KM)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fontfamily">
                                               <?php while($row_user = mysqli_fetch_assoc($result_user)){ ?>  
                                                <tr id="<?php echo $row_user['expense_form_id'] ?>">
                                                    <td><?php echo $row_user['full_name'] ?></td>
                                                    <td><?php echo date('Y-m-d',strtotime($row_user['created_date'])); ?></td>
                                                    <td><?php echo number_format($row_user['opening_balance'],2); ?></td>
                                                    <td><?php echo number_format($row_user['receiveing_amount'],2); ?></td>
                                                    <td><?php echo number_format($row_user['receiveing_amount'] + $row_user['opening_balance'],2); ?></td>
                                                    <td><?php echo number_format($row_user['total_expense_day_wise'],2); ?></td>
                                                    <td><?php echo number_format($row_user['total_balance'],2); ?></td>
                                                    <!--$row_user['receiveing_amount'] + ($row_user['opening_balance'])) - ($row_user['total_expense_day_wise']),2);-->
                                                   
                                                    <td>
                                                        <a href="javascript:void();" class="tadainfo" data-toggle="modal" data-target="#myModal">TA & DA Info</a>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void();" class="tadainfo" data-toggle="modal" data-target="#myModal">Other's Info</a>
                                                    </td>
                                                    <td style="text-align: center;"><?php 
                                                        
                                                        $today = date("Y-m-d");
                                                        $newformat = date('Y-m-d',strtotime($row_user['created_date']. ' + 1 days'));
                                                        ?>

                                                        <?php if($today <= $newformat){ ?> 
                                                        <a href="update_expense_sheet_form.php?ID=<?php echo $row_user['expense_form_id']; ?>" class="" id="any"><i class="fa fa-edit fa-lg"></i></a>
                                                        <?php }else{
                                                            echo '<label style="color:red;"><i class="fa fa-lock fa-lg"></i></label>';
                                                        } ?>
                                                    </td>
                                                     <td><?php echo number_format($row_user['diesel_van_expense'],2); ?></td>
                                                    <td><?php echo $row_user['diesel_power_backup_expense'] ?></td>
                                                    <td><?php echo $row_user['toll_road_tax_expense'] ?></td>
                                                    <td><?php echo $row_user['van_repair_expense']; ?></td>
                                                    <!-- <td><?php //echo $row_user['van_driver_expense']; ?></td> -->
                                                    <td><?php echo $row_user['room_rent_expense']; ?></td>
                                                    <td><?php echo $row_user['mobile_recharge_expense']; ?></td>
                                                    <td><?php echo $row_user['atm_charge_expense']; ?></td>
                                                    <td><?php echo $row_user['stationary_expense']; ?></td>
                                                    <td><?php echo $row_user['travelling_expense']; ?></td>
                                                    <td><?php echo $row_user['electronic_item_repair_expense']; ?></td>
                                                    <td><?php echo $row_user['permission_expense']; ?></td>
                                                    <td><?php echo $row_user['purchase_item_cost']; ?></td>
                                                    <td><?php echo $row_user['van_driver_expense']; ?></td>
                                                    <td><?php echo $row_user['from_source_place']; ?></td>
                                                    <td><?php echo $row_user['to_destination_place']; ?></td>
                                                    <td><?php echo $row_user['start_meter_reading']; ?></td>
                                                    <td><?php echo $row_user['closing_meter_reading']; ?></td>
                                                    <td><?php echo $row_user['day_wise_distance']; ?></td>
                                                    <td><?php echo $row_user['total_distance']; ?></td>
                                                    <td><?php echo $row_user['diesel_in_liter']; ?></td>
                                                    <td><?php echo $row_user['total_diesel_leter']; ?></td>
                                                    <td><?php echo number_format($row_user['diesel_avrgs'],2); ?>
                                                    </td>
                                                </tr>

                                             <?php } ?>

                                            </tbody>

                                        </table>
                                        <label>
                                            <h5>
                                                <strong>Total Receiving Amount:</strong> 
                                                <?php echo number_format($row_expense['tot_recv'],2); ?>
                                            </h5>
                                        </label>
                                        &nbsp;  &nbsp;
                                        <label>
                                            <h5>
                                                <strong>Total Expense:</strong> 
                                                <?php echo number_format($row_expense['tot_exp'],2); ?>
                                            </h5>
                                        </label>
                                        &nbsp;  &nbsp;
                                        <label>
                                            <h5>
                                                <strong>Total Balance:</strong> 
                                                <?php echo number_format($row_expense['tot_bal'],2); ?>
                                            </h5>
                                        </label>
                                        &nbsp;  &nbsp;
                                        <br>
                                        <label>
                                            <h5>
                                                <strong>Total Distance (KM):</strong> 
                                                <?php echo $row_expense['tot_dis']; ?>
                                            </h5>
                                        </label>
                                         &nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;
                                        <label>
                                            <h5>
                                                <strong>Total Diesel (Litre):</strong> 
                                                <?php echo $row_expense['tot_diesel']; ?>
                                            </h5>
                                        </label>
                                         &nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;
                                        <label>
                                            <h5>
                                                <strong>AVG Diesel (Litre):</strong> 
                                                <?php echo number_format($row_expense['diesel_avrgs'],2); ?>
                                            </h5>
                                        </label>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                 <!-- Modal -->
                      <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                                <i class="fa fa-times-circle"></i>
                              </button>
                              <h4 class="modal-title"><strong>Expense Info</strong></h4>

                            </div>

                            <div class="modal-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="fontfamily">
                                            <th>Name</th>
                                            <th>Amount (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fontfamily" id="expModal"></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                              <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                            </div>
                          </div>
                        </div>
                      </div>
                <!-- Modal -->

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
                <div class="page-footer-inner fontfamily"> 2018 &copy; BTL Pramotions Advertising Pvt. Ltd.
                    <!-- <a target="_blank" href="https://btlexpense.in">BTL Expense</a>  -->
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
        
        <!-- BEGIN PAGE LEVEL PLUGINS -->
       <!--  <script src="../assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script> -->
       <!--  -->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        
       <!--  <script src="../assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script> -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <!-- <script src="../assets/pages/scripts/dashboard.min.js" type="text/javascript"></script> -->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script> -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script> -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.tadainfo').on('click', function(){
                    $('#expModal').html('');
                    var expFormId = $(this).closest('tr').attr('id');
                    var trHtml = '';
                    var isOther = true;
                    if($(this).text() == 'TA & DA Info'){
                        isOther = false;
                    }
                    $.ajax({
                       url: 'ExpenseInfo.php',
                       method: 'post',
                       dataType: 'json',                       
                       data: {"isOther":isOther,"expFormId":expFormId },
                       success:function(data){
                          $.each(data, function(k, ob){
                            if(isOther){
                                trHtml = trHtml+'<tr><td>'+ob.expense_desc+'</td><td>'+ob.others_expense+'</td></tr>';
                            }else{
                                trHtml = trHtml+'<tr><td>'+ob.candidate_name+'</td><td>'+ob.team_da+'</td></tr>';
                            }                            
                          });
                          
                          $('#expModal').html(trHtml);
                       }
                     });
                });

                $('#example').DataTable( {
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal( {
                                header: function ( row ) {
                                    var data = row.data();
                                    return 'Details for '+data[0]+' ';
                                }
                            } ),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                                tableClass: 'table'
                            } )
                        }
                    }
                } );
            } );
        </script>
    </body>

</html>