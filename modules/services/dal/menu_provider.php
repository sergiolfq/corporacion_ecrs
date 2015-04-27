<?php    
    include_once("queries.php");    
    include_once("db.php");
    include_once("menu_node.php"); 

    class menu_provider {
        private $link;

        function __construct() {
            $this->link = db::get_mysql()->conni();            
        }

        function __destruct() {    
            mysqli_close($this->link);
        }

        public function add_nodo(menu_node $nodo,$href='#') {
            $retval = 0;
            $query = queries::fnc_add_menu_node."('$nodo->name',$nodo->parentID,'$href')";
            if(mysqli_multi_query($this->link,$query)) {            
                if ($result = mysqli_use_result($this->link)) {
                    while ($row = mysqli_fetch_row($result)) {
                        $retval = $row[0];
                    }
                    mysqli_free_result($result);
                }            
            }
            return $retval;             
        }

        public function set_nodo(menu_node $nodo,$href='#') {
            $query = queries::prc_set_menu_node."($nodo->uniqueID,'$nodo->name',$nodo->parentID,'$href')";
            $result = mysqli_multi_query($this->link,$query);
            return (bool)$result;            
        }

        public function del_nodo($uniqueID) {
            $query = queries::prc_del_menu_node."($uniqueID)";
            $result = mysqli_multi_query($this->link,$query);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($this->link));
            }
            return (bool)$result;   
        }    

        public function get_children($uniqueID) {            
            $items = array();
            $query = queries::prc_get_menu_children."($uniqueID)";
            if(mysqli_multi_query($this->link,$query)) {
                if ($result = mysqli_store_result($this->link)) {
                    while ($row = mysqli_fetch_row($result)) {
                        $id_padre = is_null($row[1]) ? 0 : $row[1];
                        $items[] = new menu_node($row[2], $id_padre, $row[0], $row[3], $row[5]);  //agrega un nuevo elemento
                    }        
                    mysqli_free_result($result);

                    while(mysqli_more_results($this->link) && mysqli_next_result($this->link))
                    {
                        $extraResult = mysqli_use_result($this->link);
                        if($extraResult instanceof mysqli_result){
                            mysqli_free_result($extraResult);
                        }
                    }                        
                }   
            }
            return $items;            
        }
        
        public function get_path($uniqueID) {
            $items = array();
            $query = queries::prc_get_menu_path."($uniqueID)";
            if(mysqli_multi_query($this->link,$query)) {
                if ($result = mysqli_store_result($this->link)) {
                    while ($row = mysqli_fetch_row($result)) {
                        $id_padre = is_null($row[1]) ? 0 : $row[1];
                        $items[] = new menu_node($row[2], $id_padre, $row[0], $row[3], $row[5]);  //agrega un nuevo elemento
                    }        
                    mysqli_free_result($result);

                    while(mysqli_more_results($this->link) && mysqli_next_result($this->link))
                    {
                        $extraResult = mysqli_use_result($this->link);
                        if($extraResult instanceof mysqli_result){
                            mysqli_free_result($extraResult);
                        }
                    }                        
                }   
            }
            return $items;   
        }
        
        public function get_subchildren($uniqueID, $depth) {            
            $items = array();
            $query = queries::prc_get_menu_subchildren."($uniqueID,$depth)";
            if(mysqli_multi_query($this->link,$query)) {
                if ($result = mysqli_store_result($this->link)) {
                    while ($row = mysqli_fetch_row($result)) {
                        $id_padre = is_null($row[1]) ? 0 : $row[1];
                        $items[] = new menu_node($row[2], $id_padre, $row[0], $row[3], $row[5]);  //agrega un nuevo elemento
                    }        
                    mysqli_free_result($result);

                    while(mysqli_more_results($this->link) && mysqli_next_result($this->link))
                    {
                        $extraResult = mysqli_use_result($this->link);
                        if($extraResult instanceof mysqli_result){
                            mysqli_free_result($extraResult);
                        }
                    }                        
                }   
            }
            return $items;            
        }  
        
        public function get_tree($uniqueID) {            
            $items = array();
            $query = queries::prc_get_menu_tree."($uniqueID)";
            if(mysqli_multi_query($this->link,$query)) {
                if ($result = mysqli_store_result($this->link)) {
                    while ($row = mysqli_fetch_row($result)) {
                        $id_padre = is_null($row[1]) ? 0 : $row[1];
                        $items[] = new menu_node($row[2], $id_padre, $row[0], $row[3], $row[5]);  //agrega un nuevo elemento
                    }        
                    mysqli_free_result($result);

                    while(mysqli_more_results($this->link) && mysqli_next_result($this->link))
                    {
                        $extraResult = mysqli_use_result($this->link);
                        if($extraResult instanceof mysqli_result){
                            mysqli_free_result($extraResult);
                        }
                    }                        
                }   
            }
            return $items;            
        } 
        
        public function populate_tree($uniqueID) {                        
            $nodes = array();
            $root_node = null;
            $query = queries::prc_get_menu_tree."($uniqueID)";            
            if(mysqli_multi_query($this->link,$query)) {
                if ($result = mysqli_store_result($this->link)) {
                    $row = mysqli_fetch_row($result);
                    $root_node = new menu_node($row[2], is_null($row[1]) ? 0 : $row[1], $row[0], $row[3], $row[5]);
                    $current_depth = 0;
                    $current_node = $root_node;
                    while ($row = mysqli_fetch_row($result)) {
                        if($row[3] > $current_depth) {
                            $nodes[] = $current_node;
                            $current_depth = $row[3];
                        }
                        else if($row[3] < $current_depth) {
                            while($row[3] < $current_depth) {
                                --$current_depth;
                                array_pop($nodes);
                            }
                        }
                        $current_node = new menu_node($row[2], is_null($row[1]) ? 0 : $row[1], $row[0], $row[3], $row[5]);
                        $nodes[sizeof($nodes)-1]->children = $current_node;
                    }        
                    mysqli_free_result($result);

                    while(mysqli_more_results($this->link) && mysqli_next_result($this->link))
                    {
                        $extraResult = mysqli_use_result($this->link);
                        if($extraResult instanceof mysqli_result){
                            mysqli_free_result($extraResult);
                        }
                    }                                                                                    
                }
            }
            $nodes = null; //suficiente para eliminar la memoria
            return $root_node;                  
        } 
        
        public function populate_tree_auth($usuarioID, $uniqueID) {                        
            $nodes = array();
            $root_node = null;
            $query = queries::prc_get_menu_auth."('$usuarioID',$uniqueID)";            
            if(mysqli_multi_query($this->link,$query)) {
                if ($result = mysqli_store_result($this->link)) {
                    $row = mysqli_fetch_row($result);
                    $root_node = new menu_node($row[2], is_null($row[1]) ? 0 : $row[1], $row[0], $row[3], $row[5], $row[4]);
                    $current_depth = 0;
                    $current_node = $root_node;
                    while ($row = mysqli_fetch_row($result)) {
                        if($row[3] > $current_depth) {                                                                                
                            $nodes[] = $current_node; 
                            $current_depth = $row[3];  
                        }
                        else if($row[3] < $current_depth) {
                            while($row[3] < $current_depth) {
                                --$current_depth;
                                array_pop($nodes);
                            }
                        }
                        $current_node = new menu_node($row[2], is_null($row[1]) ? 0 : $row[1], $row[0], $row[3], $row[5], $row[4]);
                        $nodes[sizeof($nodes)-1]->children = $current_node;
                    }        
                    mysqli_free_result($result);

                    while(mysqli_more_results($this->link) && mysqli_next_result($this->link))
                    {
                        $extraResult = mysqli_use_result($this->link);
                        if($extraResult instanceof mysqli_result){
                            mysqli_free_result($extraResult);
                        }
                    }                                                                                    
                }
            }
            $nodes = null; //suficiente para eliminar la memoria
            return $root_node;                  
        }         
    }

    //$obj = new menu_provider();
    //var_dump($obj->populate_tree(675));

    /*
    //Agregar un primer nodo
    $mnu = new menu_node('Luis',0);
    $obj = new menu_provider();
    $first = $obj->add_nodo($mnu);    
    echo $first."<br/>";
    //Agregar un segundo nodo en cascada
    $mnu2 = new menu_node('Javier',$first);
    $second = $obj->add_nodo($mnu2);
    echo $second."<br/>";
    //Agregar un tercer nodo en cascada
    $mnu3 = new menu_node('Jimenez',$second);
    $third = $obj->add_nodo($mnu3,"noticias24.com");
    echo $third."<br/>";
    //Cambiar el padre del tercer nodo
    $mnu4 = new menu_node('Jimenez',$first,$third);
    $obj->set_nodo($mnu4,"bitelia.com");
    //Eliminar el tercer nodo
    $obj->del_nodo($third);
    //Eliminar el primer nodo y por lo tanto el segundo
    $obj->del_nodo($first);
    */
?>        
        