<?php
session_start();

if(isset($_SESSION['email']) && isset($_SESSION['parol'])) 
{echo'<meta http-equiv="refresh" content="0; URL=orders.php">'; exit;}
$con=mysqli_connect('localhost','faiq','555','anbar');

?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<link href="style.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="bi bi-boxes" style="font-size:26px"> <b>Anbar</b></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        
      <li class="nav-item">
        <a class="nav-link active text-white" aria-current="page" href="#"><i class="bi bi-info-circle-fill" style="font-size:26px"></i><b> Haqqımızda</b></a>
      </li> 
        <li class="nav-item">
        <a class="nav-link active text-white" aria-current="page" href="#"><i class="bi bi-envelope-fill" style="font-size:26px"></i><b> Əlaqə</b></a>
        </li>

      </ul>
      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-2 d-flex" method="post" action="#cedvel">
        <input class="form-control form-control-dark me-2" type="email" name="email" placeholder="Emailiniz">
        <input class="form-control form-control-dark me-2" type="password" name="parol" placeholder="Parolunuz">
        <button class="btn btn-warning me-0" type="submit" name="daxilol">Giriş</button>
      </form>
    </div>
  </div>
</nav>

<br>

<div class="container">
  <div class="alert alert-warning" role="alert">
  Anbar proqramında işləmək üçün ya qeydiyyatdan keçin, ya da <b>email</b> və <b>parolunuzu</b> daxil edərək sistemə giriş edin<b>.</b>
</div>

<?php 

$tarix=date('Y-m-d H:i:s');

if(isset($_POST['daxilol']))
{
   $email=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['email']))));
    $parol=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim(sha1($_POST['parol'])))));

    $yoxlama=mysqli_query($con,"SELECT * FROM users WHERE email='".$email."' AND parol='".$parol."' AND blok=0");

    if(mysqli_num_rows($yoxlama)>0)
    {
      $info = mysqli_fetch_array($yoxlama);

      $_SESSION['user_id'] = $info['id'];
      $_SESSION['ad'] = $info['ad'];
      $_SESSION['soyad'] = $info['soyad'];
      $_SESSION['email'] = $info['email'];
      $_SESSION['telefon'] = $info['telefon'];
      $_SESSION['foto'] = $info['foto']; 
      $_SESSION['parol'] = $info['parol'];

      echo'<meta http-equiv="refresh" content="0; URL=orders.php">';
    }
}

//-----------------------------------------------QEYDIYYAT------------------------------------------//

if(isset($_POST['qeydiyyat']))
{
    $ad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['ad']))));
    $soyad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['soyad']))));
    $email=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['email']))));
    $telefon=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['telefon']))));
    $parol=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim(sha1($_POST['parol'])))));
    $tparol=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim(sha1($_POST['tparol'])))));

  if(!empty($ad) && !empty($soyad) && !empty($telefon) && !empty($email) && !empty($parol) && !empty($tparol))
{
  $yoxla=mysqli_query($con,"SELECT * FROM users WHERE telefon='".$telefon."' OR email='".$email."' ");
    $say=mysqli_num_rows($yoxla);
    if($say==0)
    {
  if(strlen($parol)>=5)
  {
  if($parol==$tparol)
{
    $daxil=mysqli_query($con,"INSERT INTO users(ad,soyad,telefon,email,parol,tarix) 
    VALUES('".$ad."','".$soyad."','".$telefon."','".$email."','".$parol."','".$tarix."')");

    if($daxil==true)
      {echo'<div class="alert alert-success role="alert">Qeydiyyata alındınız.Zəhmət olmasa daxil olun.</div>';}
    else
      {echo'<div class="alert alert-danger role="alert">Təəssüfki qeydiyyata alınmadınız.</div>';}
}
else
{echo'<div class="alert alert-warning role="alert">Parol təkrar parolla eyni olmalıdır.</div>';}
}
else
{echo'<div class="alert alert-warning role="alert">Parol ən az 5 şrift olmalıdır.</div>';}
}
else
{echo'<div class="alert alert-danger role="alert">Daxil etdiyiniz <b>email</b> veya <b>nömrə</b> artıq istifadə olunub.</div>';}
}
else
  echo'<div class="alert alert-warning role="alert">Zəhmət olmasa bütün xanalariı doldurun.</div>';
}


?>

<div class="alert alert-dark" role="alert">
  <form method="post">
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-person" style="font-size:25px"></i></span>
    <input required type="text" class="form-control" name="ad" placeholder="Adınız"><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-person-circle" style="font-size:25px"></i></span>
    <input required type="text" class="form-control" name="soyad" placeholder="Soyadınız"><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-telephone" style="font-size:25px"></i></span>
    <input required type="text" class="form-control" name="telefon" placeholder="+994..."><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-envelope" style="font-size:25px"></i></span>
    <input required type="email" class="form-control" name="email" placeholder="@gmail.com"><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-file-lock2" style="font-size:25px"></i></span>
    <input required type="password" class="form-control" name="parol" autocomplete="off" placeholder="Parol"><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-key" style="font-size:25px"></i></span>
    <input required type="password" class="form-control" name="tparol" autocomplete="off" placeholder="Təkrar parol"><br>
    </div><br>
    <button type="submit" class="btn btn-success btn-sm" name="qeydiyyat"><b>Qeydiyyatdan kecin</b></button>
  </form>
</div>

</div>
    
      
