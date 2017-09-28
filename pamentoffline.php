<?php include 'inc/header.php'; ?>
<?php 
    $login  =Session::get("cusLogin");
    if ($login == false) {
        header("Location:login.php");
    }
?>
<?php
	if (isset($_GET['orderid']) && $_GET['orderid']=='order') {
		$cmrId  =Session::get("cusId");
		$insertOrder = $ct->orderProduct($cmrId);
		$delData = $ct->delCustomerCart();
		header("Location: success.php");
	}
?>
<style>
.division{width: 50%; float: left;}
.tblone{ width: 500px; margin: 0 auto; border: 2px solid #ddd; }
.tblone tr td{text-align: justify;}
.tbltwo{float:right;text-align:left;width: 60%;border: 2px solid #ddd;margin-right: 14px; margin-top: 12px;}
.tbltwo tr td{text-align: justify; padding: 5px 10px; }
.ordernow{}
.ordernow a{width: 200px;  margin: 20px auto 0; text-align: center; padding: 5px; font-size: 30px; display: block; background: #ff0000; color: #fff; border-radius: 3px;}
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
			<div class="division">
				<table class="tblone">
							<tr>
								<th >No</th>
								<th >Product</th>
								<th >Price</th>
								<th >Quantity</th>
								<th >Total</th>
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
								<td>Tk. <?php echo $result['price'] ?></td>
								<td><?php echo $result['quqntity'] ?></td>
								<td>Tk. 
								<?php 
									$total = $result['price'] * $result['quqntity'];
									echo $total;
									$totalPrice = $totalPrice + $total;
									?>
								</td>
							</tr>
							<?php } } ?>

						</table>
						
						<table class="tbltwo">
							<tr>
								<td>Sub Total</td>
								<td>:</td>
								<td>TK. <?php echo $totalPrice;?></td>
							</tr>
							<tr>
								<td>VAT</td>
								<td>:</td>
								<td>10%(<?php echo $totalPrice * 0.1;?>)</td>
							</tr>
							<tr>
								<td>Grand Total</td>
								<td>:</td>
								<td>TK. <?php echo $totalPrice + $totalPrice * 0.1; ?> </td>
							</tr>
					   </table>
			</div>



			<div class="division">
				<?php
    		$id = Session::get("cusId");
    		$getdata = $cmr->getCustomerData($id);
    		if ($getdata) {
    			while ($result = $getdata->fetch_assoc()) {
    				
    	?>
		<table class="tblone">
			<tr>
				<td colspan="3"><h2>Your Profile Details</h2></td>
			<tr>
				<td width="20%">Name</td>
				<td width="5%">:</td>
				<td><?php echo $result['name']; ?></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td>:</td>
				<td><?php echo $result['phone']; ?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td>:</td>
				<td><?php echo $result['email']; ?></td>
			</tr>
			<tr>
				<td>Address</td>
				<td>:</td>
				<td><?php echo $result['address']; ?></td>
			</tr>
			<tr>
				<td>City</td>
				<td>:</td>
				<td><?php echo $result['city']; ?></td>
			</tr>
			<tr>
				<td>Zip-Code</td>
				<td>:</td>
				<td><?php echo $result['zip']; ?></td>
			</tr>
			<tr>
				<td>Country</td>
				<td>:</td>
				<td><?php echo $result['country']; ?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><a href="editprofile.php">Update Information</a></td>
			</tr>
		</table>	
		<?php } } ?>
			</div>
 	</div>
 	<div class="ordernow"> <a href="?orderid=order">Order</a> </div>
</div>
<?php include 'inc/footer.php'; ?> 