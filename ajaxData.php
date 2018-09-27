<?php
//Include the database configuration file
include('includes/config.php');

if(!empty($_POST["country_id"])){
    //Fetch all state data
    $query = $connection->query("SELECT * FROM states WHERE country_id = ".$_POST['country_id']." AND status = 1 ORDER BY state_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //State option list
    if($rowCount > 0){
        echo '<option value="">Select state</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['state_id'].'">'.$row['state_name'].'</option>';
        }
    }else{
        echo '<option value="">State not available</option>';
    }
}elseif(!empty($_POST["state_id"])){
    //Fetch all city data
    $query = $connection->query("SELECT * FROM cities WHERE state_id = ".$_POST['state_id']." AND status = 1 ORDER BY city_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //City option list
    if($rowCount > 0){
        echo '<option value="">Select city</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
        }
    }else{
        echo '<option value="">City not available</option>';
    }
}
?>