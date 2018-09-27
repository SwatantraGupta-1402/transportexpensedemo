<?php
//Include the database configuration file
include('../includes/config.php');

if(!empty($_POST["full_name"])){
    //Fetch all state data
    echo "Swat".$query = $connection->query("SELECT * FROM user_registration WHERE user_id = ".$_POST['user_id']." ORDER BY user_id ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //State option list
    if($rowCount > 0){
        echo '<option value="">Select Project Name</option>';
        while($rows = $query->fetch_assoc()){ 
            echo '<option value="'.$rows['user_id'].'">'.$rows['project_name'].'</option>';
        }
    }else{
        echo '<option value="">Project not available</option>';
    }
}
?>