<?php        
    /*
    define("DATABASE_SERVER","localhost");
    define("DATABASE_USER","enajenauser");
    define("DATABASE_PASSWORD","alemania1");
    define("DATABASE_NAME","enajenaciones");
    */
    define("DATABASE_SERVER","localhost");
    define("DATABASE_USER","ecrs_siteuser");
    define("DATABASE_PASSWORD","15022413");
    define("DATABASE_NAME","ecrs_website");    
       
    //Clase encargada de gestionar las conexiones a la base de datos
    class db{    
        private $servidor;
        private $usuario;
        private $password;
        private $base_datos;
        
        private static $_instance;

        //La función construct es privada para evitar que el objeto pueda ser creado mediante new
        private function __construct(){
            $this->servidor=DATABASE_SERVER;
            $this->base_datos=DATABASE_NAME;
            $this->usuario=DATABASE_USER;
            $this->password=DATABASE_PASSWORD; 
        }
        
        function __destruct() {    
            //print "code here";
        }

        //Evitamos el clonaje del objeto. Patrón Singleton
        private function __clone(){ }

        //Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos
        public static function get_mysql(){
            if (is_null(self::$_instance)){
                self::$_instance=new self();
            }
            return self::$_instance;
        }

        //Realiza la conexión a la base de datos
        public function conn(){
            //$link = mysql_connect(DATABASE_SERVER,DATABASE_USER,DATABASE_PASSWORD) or die("cannot connect");
            //mysql_select_db(DATABASE_NAME) or die("cannot select DB");                
            $link=mysql_connect($this->servidor, $this->usuario, $this->password) or die(mysql_error());
            mysql_select_db($this->base_datos,$link) or die(mysql_error());                        
            @mysql_query("SET NAMES 'utf8'");
            return $link;
        }
        
        public function conni(){
            //$mysqli = new mysqli($this->servidor, $this->usuario, $this->password, $this->base_datos);
            //return $mysqli;
            
            $link=mysqli_connect($this->servidor, $this->usuario, $this->password, $this->base_datos);

            /* check connection */
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }    
            return $link;         
        }
    }
?>