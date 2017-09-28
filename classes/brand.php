<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>
<?php
	/**
	* Brand
	*/
	class Brand 
	{
		
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function brandInsert($brandName){
			$brandName = $this->fm->validation($brandName);
			$brandName = mysqli_real_escape_string($this->db->link,$brandName);

			if (empty($brandName)){
				$Msg = "<span class='error'>Brand name must not be empty !</span>";
				return $Msg;
			}
			else{
				$query = "insert into tbl_brand(brandName) values('$brandName') ";
				$result = $this->db->insert($query);
				if ($result) {
					$Msg = "<span class='success'>Brand insert successfully.</span>";
					return $Msg;
				}
				else{
					$Msg = "<span class='error'>Brand insert error.</span>";
					return $Msg;
				}
			}
		}

		public function getAllBrand(){
			$query = "select * from tbl_brand order by brandId desc";
			$result = $result = $this->db->select($query);
			return $result;
		}

		public function getBrandById($id){
			$query = "select * from tbl_brand where brandId= '$id'";
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function brandUpdate($brandName,$id){
			$brandName = $this->fm->validation($brandName);
			$brandName = mysqli_real_escape_string($this->db->link,$brandName);
			$id = mysqli_real_escape_string($this->db->link,$id);

			if (empty($brandName)){
				$catMsg = "<span class='error'>Brand name must not be empty !</span>";
				return $catMsg;
			} else {
				$query = "UPDATE tbl_brand set brandName= '$brandName' where brandId = '$id'";
				$updated_row = $this->db->update($query);
				if ($updated_row) {
					$msg = "<span class='success'>Brand Updated successfully.</span>";
					return $msg;
				}
				else{
					$msg = "<span class='error'>Brand Not Updated.</span>";
					return $msg;
				}
			}
		}
		public function delBrandById($id){
			$query = "delete from tbl_brand where brandId = '$id'";
			$deldata = $this->db->delete($query); 
			if ($deldata ) {
				$msg = "<span class='success'>Brand Deleted successfully.</span>";
					return $msg;
			}
			else{
				$msg = "<span class='error'>Brand Not Deleted.</span>";
				return $msg;
			}
		}

	}
	
?>