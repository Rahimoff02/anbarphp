<?php 
//-----------------------------------------------STATISTIKA-----------------------------------------//

$msec=mysqli_query($con,"SELECT * FROM clients WHERE user_id='".$_SESSION['user_id']."'");
$msay=mysqli_num_rows($msec);

$bsec=mysqli_query($con,"SELECT * FROM brands WHERE user_id='".$_SESSION['user_id']."'");
$bsay=mysqli_num_rows($bsec);

$psec=mysqli_query($con,"SELECT * FROM products WHERE user_id='".$_SESSION['user_id']."'");
$psay=mysqli_num_rows($psec);

$ssec=mysqli_query($con,"SELECT * FROM orders WHERE user_id='".$_SESSION['user_id']."'");
$ssay=mysqli_num_rows($ssec);

$asec=mysqli_query($con,"SELECT * FROM products WHERE user_id='".$_SESSION['user_id']."'");

$tmehsul = 0;
$talish = 0;
$tsatish = 0;
$tqazanc = 0;

while($pinfo=mysqli_fetch_array($psec))

{	
	$tmehsul = $tmehsul + $pinfo['miqdar'];
	$talish = $talish + $pinfo['alish'];
	$tsatish = $tsatish + $pinfo['satish'];
}

$tqazanc = ($tsatish - $talish) * $tmehsul;

$sec=mysqli_query($con,"SELECT
							products.alish,
							products.satish,
							orders.miqdar
							FROM brands,products,clients,orders
							WHERE brands.id=products.brand_id AND
							products.id=orders.product_id AND 
							clients.id=orders.client_id AND
						    orders.user_id='".$_SESSION['user_id']."' AND
							orders.tesdiq=1");

	while($info=mysqli_fetch_array($sec))
	{
		$talish = $talish + ($info['alish'] * $info['miqdar']);
		$tsatish = $tsatish + ($info['satish'] * $info['miqdar']);
	}
	
	$cqazanc = $tsatish - $talish;
	$cqazanc=0;

echo'<div class="alert alert-info" role="alert">
<b>Mushteri:'.$msay.' </b> | 
<b>Brend:'.$bsay.' </b> |
<b>Cheshid:'.$psay.' </b> |  
<b>Mehsul:'.$tmehsul.' </b> | 
<b>Sifarish:'.$ssay.' </b> | 
<b>Alish:'.$talish.' </b> | 
<b>Satish:'.$tsatish.' </b> | 
<b>Qazanc:'.$tqazanc.' </b> | 
<b>Cari qazanc:'.$cqazanc.'</b> 
</div>';

?>