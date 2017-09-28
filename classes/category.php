<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?> 

<?php
	/**
	* Category class
	*/
	class Category
	{ 
		
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function catInsert($catName){
			$catName = $this->fm->validation($catName);
			$catName = mysqli_real_escape_string($this->db->link,$catName);

			if (empty($catName)){
				$catMsg = "<span class='error'>Category name must not be empty !</span>";
				return $catMsg;
			}
			else{
				$query = "insert into tbl_category(catName) values('$catName') ";
				$result = $this->db->insert($query);
				if ($result) {
					$catMsg = "<span class='success'>Category insert successfully.</span>";
					return $catMsg;
				}
				else{
					$catMsg = "<span class='error'>Category insert error.</span>";
					return $catMsg;
				}
			}
		}
		public function getAllCat(){
			$query = "select * from tbl_category order by catId desc";
			$result = $result = $this->db->select($query);
			return $result;
		}

		public function getCatById($id){
			$query = "select * from tbl_category where catId= '$id'"; 
			$result = $result = $this->db->select($query);
			return $result;
		}
		public function catUpdate($catName,$id){
			$catName = $this->fm->validation($catName);
			$catName = mysqli_real_escape_string($this->db->link,$catName);
			$id = mysqli_real_escape_string($this->db->link,$id);

			if (empty($catName)){
				$catMsg = "<span class='error'>Category name must not be empty !</span>";
				return $catMsg;
			} else {
				$query = "UPDATE tbl_category set catName= '$catName' where catId = '$id'";
				$updated_row = $this->db->update($query);
				if ($updated_row) {
					$msg = "<span class='success'>Category Updated successfully.</span>";
					return $msg;
				}
				else{
					$msg = "<span class='error'>Category Not Updated.</span>";
					return $msg;
				}
			}
		}
		public function delCatById($id){
			$query = "delete from tbl_category where catId = '$id'";
			$deldata = $this->db->delete($query); 
			if ($deldata ) {
				$msg = "<span class='success'>Category Deleted successfully.</span>";
					return $msg;
			}
			else{
				$msg = "<span class='error'>Category Not Deleted.</span>";
				return $msg;
			}
		}
	}


?>