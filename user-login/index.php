<?php 
error_reporting(0);
 include('../includes/config.php');
    session_start();
    $session_info = $_SESSION['user_session_info'];
      //$strUserName = $session_info['candidate_user_name'];
      $strFullName = $session_info['full_name'];
      $strUserEmailAddress = $session_info['user_email_address'];
      $strUserName = $session_info['user_name'];
      $intUserId = $session_info['user_id'];
      if(isset($_SESSION['user_name'])){
        if((time()-$_SESSION['last_time']) > 60*1){
            
            echo '<h3 style="color:red;">Your session has been expired.</h3>';
            header("location:../logout.php");
             
        }else{
          $_SESSION['last_time'] = time();

          $sql_query = "SELECT full_name,project_name,user_avatar FROM user_registration WHERE user_id= '".$intUserId."'";
          $result_query = mysqli_query($connection,$sql_query);
          $row_array = mysqli_fetch_assoc($result_query);

           $sql_query_user = "SELECT ur.*,c.country_name,s.state_name,ct.city_name FROM `user_registration` as ur 
           LEFT JOIN countries as c ON c.country_id = ur.country 
           LEFT JOIN states as s ON s.state_id = ur.state 
           LEFT JOIN cities as ct ON ct.city_id = ur.city WHERE user_id = '$intUserId'";
           $result_user = mysqli_query($connection, $sql_query_user);
        }
    }else{
    header('location:../');
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
        <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
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
         <style>
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
                            <li class="nav-item start active open">
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
                             <li class="nav-item  ">
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
                        <!-- END PAGE BAR
                        <div id="flash-msg">
                              <p> <?php if(isset($err_msg)) { echo $err_msg; } 
                                  if(isset($success_msg)) { echo $success_msg; 
                                } ?>    
                              </p>
                        </div>
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
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2" style="text-transform:uppercase;">
                                            <thead>
                                                <tr class="fontfamily">
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile No</th>
                                                    <!-- <th>Party Name</th> -->
                                                    <th>Project Name</th>
                                                    <th>Address</th>
                                                    <!-- <th>City</th>
                                                    <th>State</th>
                                                    <th>Country</th> -->
                                                    <th>Avatar</th>
                                                    <th>Status</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody class="fontfamily">
                                                  <?php while($row_user = mysqli_fetch_assoc($result_user)){ ?>
                                                <tr>
                                                    
                                                    <td><?php echo $row_user['full_name']; ?></td>
                                                    <td><?php echo $row_user['user_email_address']; ?></td>
                                                    <td><?php echo $row_user['user_mobile_no']; ?></td>
                                                    <!-- <td><?php //echo $row_user['party_name']; ?></td> -->
                                                    <td><?php echo $row_user['project_name']; ?></td>
                                                    <td><?php echo $row_user['user_address'].', '.$row_user['zipcode']; ?></td>
                                                    <!-- <td><?php //echo $row_user['city_name']; ?></td>
                                                    <td><?php //echo $row_user['state_name']; ?></td>
                                                    <td><?php //echo $row_user['country_name']; ?></td> -->
                                                    <input type="hidden" name="user_id" value="<?php echo $row_user['user_id'] ?>">
                                                    <td><img class="img-rectangle" src="../<?php echo $row_user['user_avatar']; ?>" width="60" height="60"></td>
                                                    <td>
                                                        <?php if ($row_user['status'] == 'Deactivate'){ ?>
                                                        <h2><label class="btn btn-danger"><strong>Deactivate</strong></label></h2>
                                                        <?php } ?>
                                                        <?php if ($row_user['status'] == 'Activate'){ ?>
                                                        <h2><label class="btn btn-info"><strong>Activate</strong></label></h2>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- <td> -->
                                                       <!--  <a href="update_users_details.php?UserId=<?php echo $row_user['user_id']; ?>"><img src="../avatar/edit.png" title="Update Info" width="20" height="20"></a>
                                                        <a href=" " id="<?php echo $row_user['user_id']; ?>" class="delete" title="Delete"><img src="../avatar/delete.png" title="Delete" width="20" height="20"><a> -->
                                                        <!-- Modal -->
                                                    <!-- </td> -->
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
            <div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title"><strong>User List Details</strong></h4>
                        </div>
                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Employee ID :</strong><span> BTLEMP101</span></label>
                                </div>
                                <div class="form-group">
                                    <label><strong>Full Name :</strong><span> Swatantra Gupta</span></label>
                                </div>
                                <div class="form-group">
                                    <label><strong>Email Address :</strong><span> swatantragupta70@gmail.com</span></label>
                                </div>
                                <div class="form-group">
                                    <label><strong>Mobile No :</strong><span> 9691315643</span></label>
                                </div>
                                <div class="form-group">
                                    <label><strong>Party Name :</strong><span> ABC</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Project Name :</strong><span> ABC Project</span></label>
                                </div>
                                <div class="form-group">
                                    <label><strong>Address :</strong><span> 875-B, Gumasta Nagar, Indore, Madhya Pradesh-452001</span></label>
                                </div>
                                <div class="form-group">
                                    <label><strong>Aadhar Info :</strong><span> 253614258965</span></label>
                                </div>
                                <div class="form-group">
                                    <label><strong>User Avatar :</strong> <span> <img src="../avatar/swat.jpg" height="90" width="130" style="border-radius: 25px;"></span></label>
                                </div>
                            </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn green">Save changes</button> -->
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- User List View Details Modal End Here -->

            <!-- User List View Details Modal Start Here -->
           
            <!-- User List View Details Modal End Here -->

            <!-- BEGIN FOOTER -->
            <div class="page-footer" align="center">
                <div class="page-footer-inner"> 2018 &copy; BTL Pramotions Advertising Pvt. Ltd.
                   <!--  <a target="_blank" href="https://btlexpense.in">BTL Expense</a>  -->
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
       <!--  <script src="../assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script> -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <!-- <script src="../assets/pages/scripts/dashboard.min.js" type="text/javascript"></script> -->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!--<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
        <!-- END THEME LAYOUT SCRIPTS -->
         <script type="text/javascript">
            $(document).ready(function(){
                alert("Test");
                $("#flash-msg").delay(3000).fadeOut("slow");
            });
    </body>

</html>