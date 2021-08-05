<?php
class DBconnect {
    private $host = "localhost";
    private $username = "root";
    private $db_name = "571p";
    private $password = "";
    public $conn;

    public function connect()
    {
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name,$this->username,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "error: ".$e->getMessage();
        }
        return $this->conn;
    }
}
?>
