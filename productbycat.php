<?php include 'inc/header.php'; ?>
<?php
    if (!isset($_GET['catId']) || $_GET['catId'] == NULL) {
        echo "<script>window.location = '404.php'; </script>";
    } else{
        $id=$_GET['catId'];
    }
?>
 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Latest from Category</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
			<?php
				$pdbycat = $pd->productByCat($id);
				if ($pdbycat) {
					while ($result = $pdbycat->fetch_assoc()) {
				
			?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="preview.php?proid=<?php echo $result['productId']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
					 <h2><?php echo $result['productName']; ?></h2>
					 <p><?php echo $fm->textshorten($result['body'],60); ?></p>
					  <p><span class="price">TK.<?php echo $result['price']; ?></span></p>
				     <div class="button"><span><a href="preview.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span></div>
				</div>
			<?php } } ?>
			</div>

	
	
    </div>
 </div>
<?php include 'inc/footer.php'; ?>
