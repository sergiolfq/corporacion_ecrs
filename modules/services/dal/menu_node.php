<?php
    class menu_node {
        private $_uniqueID;
        private $_name;
        private $_parentID;
        private $_depth;        
        private $_children = array();
        private $_href;
        private $_lineage;

        private function getuniqueID() { return $this->_uniqueID; }
        private function setuniqueID($value) { 
            if($this->_uniqueID == 0)
                $this->_uniqueID = $value; 
            else
                throw new OutOfBoundsException('The UniqueID property cannot be modified once it has a non-zero value');
        }
        
        private function getdepth() { return $this->_depth; }
        
        private function getname() { return $this->_name; }
        private function setname($value) { $this->_name = $value; }
        
        private function getparentID() { return $this->_parentID; }
        private function setparentID($value) { $this->_parentID = $value; }
        
        private function getchildren() { return $this->_children; }
        private function setchildren($value) { $this->_children[] = $value; }
        
        private function gethref() { return $this->_href; }
        private function sethref($value) { $this->_href = $value; }        
        
        private function getlineage() { return $this->_lineage; }
        private function setlineage($value) { $this->_lineage = $value; }

        //$name = 'root', $parentID = 0 ó null
        public function __construct($name, $parentID, $uniqueID=0, $depth=-1, $href='#', $lineage='') {
            $this->_uniqueID = $uniqueID;   //echo "uniqueID: ".$uniqueID." ";
            $this->_name = $name;           //echo "name: ".$name." ";
            $this->_parentID = $parentID;   //echo "parentID: ".$parentID." ";
            $this->_depth = $depth;         //echo "depth: ".$depth."<br />";
            $this->_href = $href;
            $this->_lineage = $lineage;
        }

        public function __get($name) { 
            if (method_exists($this, 'get'.$name)) { 
                $method = 'get' . $name; 
                return $this->$method(); 
            } else { 
                throw new OutOfBoundsException('Member is not gettable');
            }
        }    

        public function __set($name, $value) {
            if (method_exists($this, 'set'.$name)) { 
                $method = 'set' . $name; 
                return $this->$method($value); 
            } else { 
                throw new OutOfBoundsException('Member is not settable');
            }            
        }              
    }
    
    /*
    $obj2 = new menu_node(23,"root", null,-1);
    echo $obj2->uniqueID."<br />";
    //$obj2->uniqueID = 45;
    echo $obj2->name;
    */
?>
