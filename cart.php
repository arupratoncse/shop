<?php include 'inc/header.php'; ?>
<?php 
	if (isset($_GET['delpro'])) {
		$delid=preg_replace('/[^-a-zA-Z0-9_]/', '' , $_GET['delpro']);
		$delProduct = $ct->delProductByCart($delid);
	}
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cartId = $_POST['cartId'];
        $quqntity = $_POST['quqntity'];

        $updateCart = $ct->updateCartQuantity($cartId,$quqntity);
        if ($quqntity <0 ) {
        	$delProduct = $ct->delProductByCart($cartId);
        }
    }
?>
<?php 
	if (!isset($_GET['id'] )) {
		echo "<meta http-equiv='refresh' content='0;URL=?id=live'/>";
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>
			    	<?php
			    		if (isset($updateCart)) {
			    			echo $updateCart;
			    		}
			    		if (isset($delProduct)) {
			    			echo $delProduct;
			    		}
			    	?>
						<table class="tblone">
							<tr>
								<th width="5%">SL</th>
								<th width="30%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
								<th width="15%">Total Price</th>
								<th width="10%">Action</th>
							</tr>
							<?php 
								$getPro = $ct->getCartProduct();
								if ($getPro) {
									$i=0;
									$totalPrice = 0;
									while ($result = $getPro->fetch_assoc()) {
										$i++;
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $result['ProductName'] ;?></td>
								<td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
								<td>Tk. <?php echo $result['price'] ?></td>
								<td>
									<form action="" method="post">

										<input type="hidden" name="cartId" value="<?php echo $result['cartId']; ?>"/>

										<input type="number" name="quqntity" value="<?php echo $result['quqntity']; ?>"/>
										<input type="submit" name="submit" value="Update"/>

									</form>
								</td>
								<td>Tk. 
								<?php 
									$total = $result['price'] * $result['quqntity'];
									echo $total;
									$totalPrice = $totalPrice + $total;
									Session::set("totalPrice",$totalPrice);
									?></td>
								<td><a onclick="return confirm('Are you sure to delete!');" href="?delpro=<?php echo $result['cartId']; ?>">X</a></td>
							</tr>
							<?php } } ?>

						</table>
						<?php
							$getData = $ct->chCarkTable(); 
									if ($getData) {
						?>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td>TK. <?php echo $totalPrice;?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>TK. <?php echo $totalPrice + $totalPrice * 0.1; ?> </td>
							</tr>
					   </table>
					   <?php 
							}else{
								header("Location: index.php");
							}

					   ?>
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php'; ?>