<?php include 'inc/header.php'; ?>
<?php 
    $login  =Session::get("cusLogin");
    if ($login == false) {
        header("Location:login.php");
    }
?>
<style>
.psuccess{width: 500px; min-height: 200px;text-align: center;border: 1px solid #ddd;margin: 0 auto;padding: 20px;}
.psuccess h2{ border-bottom:  1px solid #ddd; margin-bottom: 20px; padding-bottom: 10px; font-size: 30px;}
.psuccess p{ line-height: 25px; text-align: left; font-size: 18px;}
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
			<div class="psuccess">
				<h2 style="color:green">Success</h2>
				<?php
					$cmrId  =Session::get("cusId");
					$amount = $ct->payableAmount($cmrId);
					if ($amount) {
						$sum = 0;
						while ($result = $amount->fetch_assoc()) {
							$price = $result['price'];
							$sum = $sum + $price;
						}
					}
					$Total = $sum + $sum*.1;
					
				?>
				<p style="color: red;">Total Payable Amount(Including Vat) : TK.<?php echo $Total;?> </p>
				<p>Thanks for purchase. Receive your order successfully. We will contract you as soon as possible with delevery details. Here is your order delails....<a href="orderdelails.php">Visit Here..</a> </p>
			</div>
    	</div>
 	</div>
</div>
<?php include 'inc/footer.php'; ?> 