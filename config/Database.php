<?php
class Database{

    // specify your own database credentials
    /*private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function __construct(){
        
         $this->username = getenv('USERNAME');
         $this->password = getenv('PASSWORD');
         $this->dbname = getenv('DBNAME');
         $this->host = getenv('HOST');
         $this->port =  getenv('PORT');
    }*/

    private $host = "dpg-cg998cseooghng6ulel0-a.oregon-postgres.render.com";
    private $port = "5432";
    private $dbname = "quotesdb_gct4";
    private $username = "admin";
    private $password = "3NYcymJbCA3eLUsaZmu6cYdq1J88QpV0";
    private $conn;

    // get the database connection
    public function connect(){

       if ($this->conn){
            return $this-conn;
       }
       else {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};";
            try{
                 $this->conn = new PDO($dsn, $this->username, $this->password);
                 $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 
            }
            catch(PDOException $e){
                 echo "Connection error: " . $e->getMessage();
            }
            return $this->conn;

       }
    }
}
?>
