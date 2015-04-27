<?php
    include("dal/menu_provider.php");
    
    if (!isset($_SESSION)) { 
        session_start(); 
    }          
    
    $nodeID = 49;
    $userID = !empty($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
    $provider = new menu_provider();     
    //$tree = $provider->populate_tree($nodeID);
    $tree = $provider->populate_tree_auth($userID,$nodeID);
    
    function draw($node, $depth) {
        if($depth == 0) {          
            echo '<span class="preload1"></span>';
            echo '<span class="preload2"></span>';
            echo '<ul id="'.$node->name.'">';
            $depth++;
            foreach($node->children as $child) {
                draw($child,$depth);
            }
            echo '</ul>'; 
        }
        else if($depth == 1) {            
            $down = sizeof($node->children) > 0 ? ' class="down"' : '';
            echo '<li class="top"><a href="'.$node->href.'" id="'.$node->uniqueID.'" class="top_link"><span'.$down.'>'.$node->name.'</span></a>';
            if($down != '') echo '<ul class="sub">';
            $depth++;
            foreach($node->children as $child) {
                draw($child,$depth);
            }            
            if($down != '') echo '</ul>';
            echo '</li>';        
        }
        else {
            $down = sizeof($node->children) > 0 ? ' class="fly"' : '';
            echo '<li><a href="'.$node->href.'"'.$down.'>'.$node->name.'</a>';            
            if($down != '') echo '<ul>';
            $depth++;
            foreach($node->children as $child) {
                draw($child,$depth);
            }                        
            if($down != '') echo '</ul>';
            echo '</li>';
        }
    }        
?>