<?php 
/*
@Function : Create MySQLi Connection
@author : Swatantra G
@Created Date : 06/02/2018
*/
		session_start();
		$connection = mysqli_connect('localhost', 'root', '');
        if (!$connection){
            die("Database Connection Failed" . mysqli_error($connection));
        }
        $select_db = mysqli_select_db($connection, 'btl_expense');
        if (!$select_db){
            die("Database Selection Failed" . mysqli_error($connection));
        }
       //define('SITE_URL', 'http://localhost/megajobportal/');
?>