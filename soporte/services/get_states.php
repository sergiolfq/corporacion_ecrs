<?php
    // connect database
    require_once("../dal/queries.php");  
    require_once("../dal/db.php");
    
    // get id param (from get vars)
    $id = !empty($_GET['id'])?intval($_GET['id']):0;
    // execute query in correct order 
    $items = array();
    $dblink = db::get_mysql()->conni();
    $query = queries::prc_get_states."($id)";
    if(mysqli_multi_query($dblink,$query)) {
        if ($result = mysqli_store_result($dblink)) {
            while ($row = mysqli_fetch_row($result)) {
                $items[] = array( $row[0], $row[1]);
            }        
            mysqli_free_result($result);

            while(mysqli_more_results($dblink) && mysqli_next_result($dblink))
            {
                $extraResult = mysqli_use_result($dblink);
                if($extraResult instanceof mysqli_result){
                    mysqli_free_result($extraResult);
                }
            }                                            
        }   
    }
    mysqli_close($dblink); 
    // encode to json
    echo(json_encode($items)); 
?>