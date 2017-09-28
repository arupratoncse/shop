<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>
<?php
	/**
	* User
	*/
	class Customer {
		
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function customerReg($data){
			$name = mysqli_escape_string($this->db->link,$data['name']);
			$city = mysqli_escape_string($this->db->link,$data['city']);
			$zipcode = mysqli_escape_string($this->db->link,$data['zipcode']);
			$email = mysqli_escape_string($this->db->link,$data['email']);
			$address = mysqli_escape_string($this->db->link,$data['address']);
			$country = mysqli_escape_string($this->db->link,$data['country']);
			$phone = mysqli_escape_string($this->db->link,$data['phone']);
			$password = mysqli_escape_string($this->db->link,md5($data['password']));

			if ($name == "" || $city == "" ||$zipcode == "" ||$email == "" ||$address == "" ||$country == "" || $phone == "" || $password == "") {
    			$msg = "<span class='error'>Fields must not be empty.</span>";
				return $msg;
    		}
    		$mailQuery = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
    		$mailchk = $this->db->select($mailQuery);
    		if ($mailchk != false) {
    			$msg = " <span class='error'>Email already exits !</span> ";
    			return $msg;
    		}else{
    			$query = "INSERT into tbl_customer(name, address, city, country, zip, phone, email,pass) values('$name','$address','$city','$country','$zipcode','$phone','$email','$password')";
    			$result = $this->db->insert($query);
				if ($result) {
					$msg = "<span class='success'>Customer data insert successfully.</span>";
					return $msg;
				}
				else{
					$msg = "<span class='error'>Customer data insert error.</span>";
					return $msg;
				}
    		}
		}
 		public function customerLogin($data){
 			$email = mysqli_escape_string($this->db->link,$data['email']);
 			$password = mysqli_escape_string($this->db->link,md5($data['password']));
 			if (empty($email) || empty($password)) {
 				$msg = "<span class='error'>Fields must not be empty.</span>";
				return $msg;
 			}
 			$query = "SELECT * FROM tbl_customer Where email='$email' and pass='$password'";
 			$result = $this->db->select($query);
 			if ($result != false) {
 				$value = $result->fetch_assoc();
 				Session::set("cusLogin",true);
 				Session::set("cusId",$value['id']);
 				Session::set("cusName",$value['name']);
 				header("Location:cart.php");
 			}else{
 				$msg = "<span class='error'>Email or Password not match !</span>";
				return $msg;
 			}	
 		}
 		public function getCustomerData($id){
 				$query = "select * from tbl_customer where id= '$id'";
				$result = $this->db->select($query);
				return $result;
 		}
 		public function customerUpdate($data,$cusId){
 			$name = mysqli_escape_string($this->db->link,$data['name']);
			$city = mysqli_escape_string($this->db->link,$data['city']);
			$zip = mysqli_escape_string($this->db->link,$data['zip']);
			$email = mysqli_escape_string($this->db->link,$data['email']);
			$address = mysqli_escape_string($this->db->link,$data['address']);
			$country = mysqli_escape_string($this->db->link,$data['country']);
			$phone = mysqli_escape_string($this->db->link,$data['phone']);

			if ($name == "" || $city == "" ||$zip == "" ||$email == "" ||$address == "" ||$country == "" || $phone == "") {
    			$msg = "<span class='error'>Fields must not be empty.</span>";
				return $msg;
    		}else{
    			
    			$query = "UPDATE tbl_customer 
    					set 
    					name= '$name', 
    					address= '$address', 
    					city= '$city', 
    					country= '$country', 
    					zip= '$zip', 
    					phone= '$phone', 
    					email= '$email' 
    					where id = '$cusId'";
				$updated_row = $this->db->update($query);
				if ($updated_row) {
					$msg = "<span class='success'>Customer Data Updated successfully.</span>";
					return $msg;
				}
				else{
					$msg = "<span class='error'>Customer Data Not Updated.</span>";
					return $msg;
				}
    		}
 		}
	}
?>