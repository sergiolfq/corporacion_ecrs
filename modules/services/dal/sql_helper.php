<?php
    require_once("db.php");
    require_once("queries.php");

    class sql_helper {
        static function exec_query($proc_name, $params="") {            
            $items = array();            
            $dblink = db::get_mysql()->conni();
            $query = $proc_name."($params)";
            if(mysqli_multi_query($dblink,$query)) {
                if ($result = mysqli_store_result($dblink)) {
                    while ($row = mysqli_fetch_row($result)) {
                        $items[] = $row;
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
                else {
                    return null;
                }   
            }
            else {
                throw new Exception("The call failed: " . mysql_error());
            }                        
            mysqli_close($dblink);
            return $items;            
        }
        
        static function get_permissions($id_usuario,$page) {            
            $items = array();
            $dblink = db::get_mysql()->conni();
            $query = queries::prc_get_page_auth."('$id_usuario','$page')";
            if(mysqli_multi_query($dblink,$query)) {
                if ($result = mysqli_store_result($dblink)) {
                    while ($row = mysqli_fetch_row($result)) {
                        $items[$row[0]] = $row[1];
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
            return $items;            
        }   
    }
?>
