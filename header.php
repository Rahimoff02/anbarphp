<?php
session_start();  

if(!isset($_SESSION['email']) or !isset($_SESSION['parol'])) 
{echo'<meta http-equiv="refresh" content="0; URL=index.php">'; exit;} 
$con=mysqli_connect('localhost','faiq','555','anbar');

//date_default_timezone_set('Europe/Moscow');

?>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link href="style.css" rel="stylesheet">


<nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
  <a class="navbar-brand" href="orders.php"><i class="bi bi-boxes" style="font-size:25px"> <b>Anbar</b></i></a>
</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item active"><a class="nav-link" href="profile.php"><?=$_SESSION['ad'].' '.$_SESSION['soyad']?><span class="sr-only">(current)</span></a></li>
      <li class="nav-item active"><a class="nav-link" href="brands.php">Brendlər<span class="sr-only">(current)</span></a></li>
      <li class="nav-item active"><a class="nav-link" href="clients.php">Müştərilər<span class="sr-only">(current)</span></a></li>
      <li class="nav-item active"><a class="nav-link" href="expense.php">Xərc<span class="sr-only">(current)</span></a></li>
      <li class="nav-item active"><a class="nav-link" href="products.php">Məhsullar<span class="sr-only">(current)</span></a><li>
      <li class="nav-item active"><a class="nav-link" href="orders.php">Sifarişlər<span class="sr-only">(current)</span></a></li>
      <li class="nav-item active"><a class="nav-link" href="staff.php">Ishciler<span class="sr-only">(current)</span></a></li>
      <li class="nav-item active"><a class="nav-link" href="credit.php">Kredit<span class="sr-only">(current)</span></a></li>

    <?php 
    if($_SESSION['user_id']==3)
    {
        echo'<li class="nav-item active"><a class="nav-link" href="admin.php">Admin<span class="sr-only">(current)</span></a></li>';
    }

    ?>  
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post">
      <input class="form-control mr-sm-2" type="text" placeholder="Axtarış" id="search" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit" name="hamisi"></i> Hamısı</button>&nbsp;
      <a class="nav-link btn btn-danger my-2 my-sm-0" href="exit.php"><i class="bi bi-box-arrow-right"></i><span class="sr-only">(current)</span></a>
    </form>
  </div>
</nav>

<br><br><br><br>