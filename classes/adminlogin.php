<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/session.php');
	Session::checkLogin();
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


<?php
	/**
	* Adminlogin
	*/
	class Adminlogin
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function adminLogin($adminUser,$adminPass)
		{
			$adminUser = $this->fm->validation($adminUser);
			$adminPass = $this->fm->validation($adminPass);

			$adminUser = mysqli_real_escape_string($this->db->link,$adminUser);
			$adminPass = mysqli_real_escape_string($this->db->link,$adminPass);

			if (empty($adminUser) || empty($adminPass)){
				$loginMsg = "Username and/or Password must not be empty !";
				return $loginMsg;
			}
			else{
				$query = "SELECT * from tbl_admin where adminUser='$adminUser' and adminPass='$adminPass'";
				$result = $this->db->select($query);
				if ($result != false) {
					$value = $result->fetch_assoc();
					Session::set("login",true);
					Session::set("adminId",$value['adminId']);
					Session::set("adminUser",$value['adminUser']);
					Session::set("adminName",$value['adminName']);
					header("location: index.php");
				}
				else{
					$loginMsg = "Username and/or Password  not match !";
					return $loginMsg;
				}
			}
		}
	}
?> 