<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>
<?php
	/**
	* Cart
	*/
	class Cart{
		
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function addToCart($quqntity,$id){
			$quqntity = $this->fm->validation($quqntity);
			$quqntity = mysqli_real_escape_string($this->db->link,$quqntity);
			$productId = mysqli_real_escape_string($this->db->link,$id);
			$sId = session_id();

			$squery ="SELECT * FROM tbl_product WHERE productId = '$productId'";
			$result = $this->db->select($squery)->fetch_assoc();

			$productName = $result['productName'];
			$price = $result['price'];
			$image = $result['image'];

			$chquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId='$sId'";
			$getPro = $this->db->select($chquery);
			if ($getPro) {
				$msg = "Product already added!";
				return $msg;
			}else{

			$query = "INSERT into tbl_cart(sId, productId, productName, price, quqntity, image) values('$sId','$productId','$productName','$price','$quqntity','$image')";
    			$result = $this->db->insert($query);
				if ($result) {
					header("Location:cart.php");
				}
				else{
					header("Location:404.php");
				}
			}

		}
		public function getCartProduct(){
			$sId = session_id();
			$query = "select * from tbl_cart where sId= '$sId'";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function updateCartQuantity($cartId,$quqntity){
			$cartId = mysqli_real_escape_string($this->db->link, $cartId);	
			$quqntity = mysqli_real_escape_string($this->db->link, $quqntity);
			$query = "UPDATE tbl_cart set quqntity= '$quqntity' where cartId = '$cartId'";
				$updated_row = $this->db->update($query);
				if ($updated_row) {
					header("Location:cart.php");  
				}
				else{
					$msg = "<span class='error'>Quantity Not Updated.</span>";
					return $msg;
				}	
		}
		public function delProductByCart($delid){
			$delid = mysqli_real_escape_string($this->db->link, $delid);	

			$query = "delete from tbl_cart where cartId = '$delid'";
			$deldata = $this->db->delete($query); 
			if ($deldata ) {
				echo "<script>window.location = 'cart.php';</script>";
			}
			else{
				$msg = "<span class='error'>Cart product Not Deleted.</span>";
				return $msg;
			}
		}
		public function chCarkTable(){
			$sId = session_id();
			$query = "select * from tbl_cart where sId= '$sId'";
			$result = $this->db->select($query);
			return $result;
		}
		public function delCustomerCart(){
			$sId = session_id();
			$query = "DELETE From tbl_cart WHERE sId='$sId' ";
			$this->db->delete($query);
		}
		public function orderProduct($cmrId){
			 $sId = session_id();
			$query = "SELECT * from tbl_cart where sId= '$sId'";
			$getPro = $this->db->select($query);
			if ($getPro) {
				while ($result = $getPro->fetch_assoc()) {
					$productId = $result['productId'];
					$productName = $result['ProductName'];
					$quantity = $result['quqntity'];
					$price = $result['price'] * $quantity;
					$image = $result['image'];

					$query = "INSERT into tbl_order(cmrId, productId, productName, quantity, price, image) values('$cmrId','$productId','$productName','$quantity','$price','$image')";
    				$inserted_row = $this->db->insert($query);
				}
			}
		}
		public function payableAmount($cmrId){
			$query = "SELECT price FROM tbl_order WHERE cmrId = '$cmrId' AND date = now() ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getOrderProduct($cmrId){
			$query = "SELECT * FROM tbl_order WHERE cmrId = '$cmrId' order by productId DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function chOrderTable($cmrId){
			$query = "select * from tbl_order where cmrId= '$cmrId'";
			$result = $this->db->select($query);
			return $result;
		}
	}
?>