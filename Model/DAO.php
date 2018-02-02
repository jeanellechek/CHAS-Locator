<?php
//interface
interface dbDAO
{
	public static function connect(); //connects to db based on implementation
	public static function filter($page); //returns all CHAS locations based on keyword
	public static function numberRecords();
}

class SQLImpl implements dbDAO
{
	public static function connect()
	{
		$servername = "localhost";
		$username = "root";
		$password = "";
		$database = "chasdb";
		
		$conn = new mysqli($servername,  $username, $password, $database);
		
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
		return $conn;
	}	
	public static function filter($page)
	{
		$conn    = SQLImpl::connect();
        $medical = "MEDICAL";
        $dental  = "DENTAL";
        
        if (isset($_SESSION['keyword'])) {
            $nameStmt = "%" . $_SESSION['keyword'] . "%";
            if (!is_numeric($_SESSION['keyword']))
                $telephone = 0;
            else
                $telephone = $_SESSION['keyword'];
        }
        $pageQuery = $conn->prepare("Select * from chas");
        $pageQuery->execute();
        $pageQuery1  = $pageQuery->get_result();
        $totalRecord = $pageQuery1->num_rows;
        
        $medicalQuery = $conn->prepare("Select * from chas where dental =?");
        $medicalQuery->bind_param("s", $medical);
        $medicalQuery->execute();
        $medicalQuery1 = $medicalQuery->get_result();
        $medicalRecord = $medicalQuery1->num_rows;
        
        $startingRecord = ($page-1)*20;
        $default = 0;
        //DEFAULT
        //Keyword and filter not set
        if (!isset($_SESSION['keyword']) && !isset($_SESSION['filterType'])) {
            $default = 1;
            $sql     = $conn->prepare("Select * from chas order by name limit ?,20");
            $sql->bind_param("i", $startingRecord);
            
        }
        //Keyword with ALL								
        else if (isset($_SESSION['keyword']) && isset($_SESSION['filterType']) && $_SESSION['filterType'] == "ALL" && $_SESSION['keyword'] != "") {
            $sql = $conn->prepare("Select * from chas where telephone = ? || name like ?|| ADDRESSSTREETNAME like ? order by name limit ?,20");
            $sql->bind_param("issi", $telephone, $nameStmt, $nameStmt,$startingRecord);
        }
        
        //keyword with MEDICAL
        else if (isset($_SESSION['keyword']) && isset($_SESSION['filterType']) && $_SESSION['filterType'] == "MEDICAL" && $_SESSION['keyword'] != "") {
            
            $sql = $conn->prepare("Select * from chas where (telephone = ? || name like ?|| ADDRESSSTREETNAME like ?) && dental=? order by name limit ?,20");
            $sql->bind_param("isssi", $telephone, $nameStmt, $nameStmt, $medical, $startingRecord);
        }
        
        //Keyword with DENTAL
        else if (isset($_SESSION['keyword']) && isset($_SESSION['filterType']) && $_SESSION['filterType'] == "DENTAL" && $_SESSION['keyword'] != "") {
            $sql = $conn->prepare("Select * from chas where (telephone = ? || name like ?|| ADDRESSSTREETNAME like ?) && dental=? order by name limit ?,20");
            $sql->bind_param("isssi", $telephone, $nameStmt, $nameStmt, $dental, $startingRecord);
        }
        //No keyword with All
        else if ($_SESSION['filterType'] == "ALL" && $_SESSION['keyword'] == "") {
            $default = 1;
            $sql     = $conn->prepare("Select * from chas order by name limit ?,20");
            $sql->bind_param("i", $startingRecord);
            
        }
        
        //No keyword with MEDICAL
        else if ($_SESSION['filterType'] == "MEDICAL" && $_SESSION['keyword'] == "") {
            $default = 2;
            $sql     = $conn->prepare("Select * from chas where name like ? && Dental = ? order by name limit ?,20");
            $sql->bind_param("ssi", $nameStmt, $medical, $startingRecord);
        }
        //No keyword with DENTAL
        else if ($_SESSION['filterType'] == "DENTAL" && $_SESSION['keyword'] == "") {
            $sql = $conn->prepare("Select * from chas where name like ? && Dental = ? order by name limit ?,20");
            $sql->bind_param("ssi", $nameStmt, $dental, $startingRecord);
            
        }
        
        
        $sql->execute();
        $result = $sql->get_result();
        return $result;
	}
	public static function numberRecords()
	{
		$conn    = SQLImpl::connect();
        $medical = "MEDICAL";
        $dental  = "DENTAL";
        
        if (isset($_SESSION['keyword'])) {
            $nameStmt = "%" . $_SESSION['keyword'] . "%";
            if (!is_numeric($_SESSION['keyword']))
                $telephone = 0;
            else
                $telephone = $_SESSION['keyword'];
        }
        $pageQuery = $conn->prepare("Select * from chas");
        $pageQuery->execute();
        $pageQuery1  = $pageQuery->get_result();
        $totalRecord = $pageQuery1->num_rows;
        
        $medicalQuery = $conn->prepare("Select * from chas where dental =?");
        $medicalQuery->bind_param("s", $medical);
        $medicalQuery->execute();
        $medicalQuery1 = $medicalQuery->get_result();
        $medicalRecord = $medicalQuery1->num_rows;
        
        $default = 0;
        //DEFAULT
        //Keyword and filter not set
        if (!isset($_SESSION['keyword']) && !isset($_SESSION['filterType'])) {
            $default = 1;
            $sql     = $conn->prepare("Select * from chas order by name");
            
        }
        //Keyword with ALL								
        else if (isset($_SESSION['keyword']) && isset($_SESSION['filterType']) && $_SESSION['filterType'] == "ALL" && $_SESSION['keyword'] != "") {
			$sql = $conn->prepare("Select * from chas where telephone = ? || name like ?|| ADDRESSSTREETNAME like ? order by name");
            $sql->bind_param("iss", $telephone, $nameStmt, $nameStmt);
        }
        
        //keyword with MEDICAL
        else if (isset($_SESSION['keyword']) && isset($_SESSION['filterType']) && $_SESSION['filterType'] == "MEDICAL" && $_SESSION['keyword'] != "") {
            $sql = $conn->prepare("Select * from chas where (telephone = ? || name like ?|| ADDRESSSTREETNAME like ?) && dental=? order by name");
            $sql->bind_param("isss", $telephone, $nameStmt, $nameStmt, $medical);
        }
        
        //Keyword with DENTAL
        else if (isset($_SESSION['keyword']) && isset($_SESSION['filterType']) && $_SESSION['filterType'] == "DENTAL" && $_SESSION['keyword'] != "") {
            $sql = $conn->prepare("Select * from chas where (telephone = ? || name like ?|| ADDRESSSTREETNAME like ?) && dental=? order by name");
            $sql->bind_param("isss", $telephone, $nameStmt, $nameStmt, $dental);
        }
        //No keyword with All
        else if ($_SESSION['filterType'] == "ALL" && $_SESSION['keyword'] == "") {
            $default = 1;
            $sql     = $conn->prepare("Select * from chas order by name");
            
        }
        
        //No keyword with MEDICAL
        else if ($_SESSION['filterType'] == "MEDICAL" && $_SESSION['keyword'] == "") {
            $default = 2;
            $sql     = $conn->prepare("Select * from chas where name like ? && Dental = ? order by name");
            $sql->bind_param("ss", $nameStmt, $medical);
        }
        //No keyword with DENTAL
        else if ($_SESSION['filterType'] == "DENTAL" && $_SESSION['keyword'] == "") {
            $sql = $conn->prepare("Select * from chas where name like ? && Dental = ? order by name");
            $sql->bind_param("ss", $nameStmt, $dental);
            
        }
        
        
        $sql->execute();
        $result = $sql->get_result();
        
            return ($result->num_rows);
	}
}


/*class MongoImpl implements dbDAO
{
	public function connect()
	{
		
	}	
	public function filter()
	{
		
	}
	public function numberRecords()
	{
		
	}

}*/

class DAO_Factory
{
	private static $_instance;
	public function _construct()
	{
	}
	public static function setFactory(DAO_Factory $f)
	{
		self::$_instance = $f;
	}
	public static function getFactory()
	{
		if(!self::$_instance)
			self::$_instance = new self;
		return self::$_instance;
	}
	/*
	public static function getMongoDAO()
	{
		return new MongoImpl();
	}*/
	public static function getSQLDAO()
	{
		return new SQLImpl();
	}
}

//to initialise an sqlDAO, $sqlDAO = DAO_Factory::getSQLDAO();
//to invoke function, $sqlDAO->connect();

?>