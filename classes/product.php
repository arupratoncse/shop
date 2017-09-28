<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>

<?php
	/**
	* Product
	*/
	class Product
	{
		
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function productInsert($data, $file){
			$productName = mysqli_real_escape_string($this->db->link,$data['productName']);
			
			$catId = mysqli_real_escape_string($this->db->link,$data['catId']);
			$brandId = mysqli_real_escape_string($this->db->link,$data['brandId']);
			$body = mysqli_real_escape_string($this->db->link,$data['body']);
			$price = mysqli_real_escape_string($this->db->link,$data['price']);
			$type = mysqli_real_escape_string($this->db->link,$data['type']);
			
			$permited  = array('jpg', 'jpeg', 'png', 'gif');
    		$file_name = $file['image']['name'];
    		$file_size = $file['image']['size'];
   			$file_temp = $file['image']['tmp_name'];

    		$div = explode('.', $file_name);
    		$file_ext = strtolower(end($div));
    		$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    		$uploaded_image = "uploads/".$unique_image;

    		if ($productName == "" || $catId == "" ||$brandId == "" ||$body == "" ||$price == "" ||$file_name == "" || $type == "") {
    			$msg = "<span class='error'>Fields must not be empty.</span>";
					return $msg;
    		}

    		elseif ($file_size >1048567) {
     			echo "<span class='error'>Image Size should be less then 1MB!
     			</span>";
    		} 

    		elseif (in_array($file_ext, $permited) === false) {
     			echo "<span class='error'>You can upload only:-"
     			.implode(', ', $permited)."</span>";
    		}

    		else{
    			move_uploaded_file($file_temp, $uploaded_image);
    			$query = "insert into tbl_product(productName, catId, brandId, body, price, image, type) values('$productName','$catId','$brandId','$body','$price','$uploaded_image','$type')";
    			$result = $this->db->insert($query);
				if ($result) {
					$msg = "<span class='success'>Product insert successfully.</span>";
					return $msg;
				}
				else{
					$msg = "<span class='error'>Product insert error.</span>";
					return $msg;
				}
    		}
		}
		public function getAllProduct(){
			$query = "SELECT p.*, c.catName, b.brandName
					FROM tbl_product as p, tbl_category as c, tbl_brand as b
					WHERE p.catId = c.catId AND p.brandId = b.brandId
					ORDER BY p.productId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function getProById($id){
			$query = "select * from tbl_product where productId= '$id'";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function productUpdate($data, $file,$id){
			$productName = mysqli_real_escape_string($this->db->link,$data['productName']);
			
			$catId = mysqli_real_escape_string($this->db->link,$data['catId']);
			$brandId = mysqli_real_escape_string($this->db->link,$data['brandId']);
			$body = mysqli_real_escape_string($this->db->link,$data['body']);
			$price = mysqli_real_escape_string($this->db->link,$data['price']);
			$type = mysqli_real_escape_string($this->db->link,$data['type']);
			
			$permited  = array('jpg', 'jpeg', 'png', 'gif');
    		$file_name = $file['image']['name'];
    		$file_size = $file['image']['size'];
   			$file_temp = $file['image']['tmp_name'];

    		$div = explode('.', $file_name);
    		$file_ext = strtolower(end($div));
    		$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    		$uploaded_image = "uploads/".$unique_image;

    		if ($productName == "" || $catId == "" ||$brandId == "" ||$body == "" ||$price == "" || $type == "") {
    			$msg = "<span class='error'>Fields must not be empty.</span>";
					return $msg;
    		} else {
    			if (!empty($file_name)){
    			
    				if ($file_size >1048567) {
     					echo "<span class='error'>Image Size should be less then 1MB!
     					</span>";
    				} 

    				elseif (in_array($file_ext, $permited) === false) {
     					echo "<span class='error'>You can upload only:-"
     					.implode(', ', $permited)."</span>";
    				}

    				else{
    					move_uploaded_file($file_temp, $uploaded_image);
    					
    					$query = "UPDATE tbl_product
    								SET
    								productName ='$productName',
    								catId		='$catId',
    								brandId		='$brandId',
    								body 		='$body',
    								price		='$price',
    								image		='$uploaded_image',
    								type		='$type'
    								WHERE productId = '$id'";
    					$result = $this->db->update($query);
						if ($result) {
							$msg = "<span class='success'>Product Updated successfully.</span>";
							return $msg;
						}
						else{
							$msg = "<span class='error'>Product Updated error.</span>";
							return $msg;
						}
    				}
    			} else{
    				$query = "UPDATE tbl_product
    								SET
    								productName ='$productName',
    								catId		='$catId',
    								brandId		='$brandId',
    								body 		='$body',
    								price		='$price',
    								type		='$type'
    								WHERE productId = '$id'";
    					$result = $this->db->update($query);
						if ($result) {
							$msg = "<span class='success'>Product Updated successfully.</span>";
							return $msg;
						}
						else{
							$msg = "<span class='error'>Product Updated error.</span>";
							return $msg;
						}
    			}
			}
		}

		public function delProById($id){
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$getData = $this->db->select($query);
			if ($getData) {
				while ($delImg = $getData->fetch_assoc()) {
					$dellink = $delImg['image'];
					unlink($dellink);
				}
			}
			$delquery = "DELETE FROM tbl_product WHERE productId = '$id' ";
			$deldata = $this->db->delete($delquery); 
			if ($deldata ) {
				$msg = "<span class='success'>Product Deleted successfully.</span>";
					return $msg;
			}
			else{
				$msg = "<span class='error'>Product Not Deleted.</span>";
				return $msg;
			}
		}
		public function getFeaturedProduct(){
			$query = "SELECT * FROM tbl_product WHERE type='0' ORDER BY productId DESC LIMIT 4";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function getNewProduct(){
			$query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function getSingleProduct($id){
			$query = "SELECT p.*, c.catName, b.brandName
					FROM tbl_product as p, tbl_category as c, tbl_brand as b
					WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId= '$id'";
			$result = $this->db->select($query);
			return $result;
		}
		public function latestFromIphone(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function latestFromSamsung(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '2' ORDER BY productId DESC LIMIT 1";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function latestFromAccer(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '4' ORDER BY productId DESC LIMIT 1";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function latestFromCanon(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '5' ORDER BY productId DESC LIMIT 1";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function productByCat($id){
			$id = mysqli_real_escape_string($this->db->link,$id);
			$query = "select * from tbl_product where catId= '$id'";
			$result = $result = $this->db->select($query);
			return $result;
		}
	}
?>