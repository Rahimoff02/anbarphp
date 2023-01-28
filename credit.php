<?php
include"header.php";

echo'<div class="container">';

if(isset($_POST['edit']) && !isset($_POST['tesdiq']))
{
    $editing=mysqli_query($con,"SELECT * FROM credits WHERE id='".$_POST['id']."' AND user_id = '".$_SESSION['user_id']."' ");
    $info=mysqli_fetch_array($editing);

    echo'<div class="alert alert-secondary" role="alert">
    <form method="post">
    Musteri:<br>
    <select name="mushteri_id" class="form-control"><br>
    <option value="">Musteri secin</option>';

$bsec=mysqli_query($con,"SELECT * FROM clients WHERE user_id = '".$_SESSION['user_id']."' ");

    while($binfo=mysqli_fetch_array($bsec))
    {
        if($info['mushteri_id']==$binfo['id'])
            {echo'<option selected value="'.$binfo['id'].'">'.$binfo['ad'].' '.$binfo['soyad'].'</option>';}
        else
           {echo'<option value="'.$binfo['id'].'">'.$binfo['ad'].' '.$binfo['soyad'].'</option>';}
    }
    echo'
    </select>
    <br>
    Mehsul:<br>
    <select name="mehsul_id" class="form-control"><br>
    <option value="">Mehsul secin</option>';

    $bsec=mysqli_query($con,"SELECT
                      brands.brend,
                      products.id,
                      products.mehsul,
                      products.miqdar,
                      products.tarix
                      FROM brands,products
                      WHERE brands.id=products.brand_id AND products.user_id='".$_SESSION['user_id']."'
                      ORDER BY products.id DESC");

   while($binfo=mysqli_fetch_array($bsec))
 {
    if($info['mehsul_id']==$binfo['id'])
    {echo'<option selected value="'.$binfo['id'].'">'.$binfo['brend'].' '.$binfo['mehsul'].' ['.$binfo['miqdar'].']</option>';}
    else
    {echo'<option value="'.$binfo['id'].'">'.$binfo['brend'].' '.$binfo['mehsul'].' ['.$binfo['miqdar'].']</option>';}
 }
echo'
    </select>
    <br>
    Say:<br>
    <input type="text" name="say" class="form-control" value="'.$info['say'].'"><br>
    Muddet:<br>
    <select name="muddet" class="form-control"><br>
    <option value="">Muddeti secin</option>';

    ?>

        <option <?php if($info['muddet']==3){echo'selected';}?> value="3">3</option>
        <option <?php if($info['muddet']==6){echo'selected';}?> value="6">6</option>
        <option <?php if($info['muddet']==12){echo'selected';}?> value="12">12</option>
        <option <?php if($info['muddet']==24){echo'selected';}?> value="24">24</option>

    <?php
    echo'
    </select>
    <br>
    Ilkin:<br>
    <input type="text" name="ilkin" class="form-control" value="'.$info['ilkin'].'"><br>
    Faiz:<br>
    <select name="faiz" class="form-control"><br>
    <option value="">Faizi secin</option>';
    ?>

        <option <?php if($info['faiz']==3){echo'selected';}?> value="3">3</option>
        <option <?php if($info['faiz']==6){echo'selected';}?> value="6">6</option>
        <option <?php if($info['faiz']==12){echo'selected';}?> value="12">12</option>

    <?php
echo'
</select>
<br>
    <input type="hidden" name="id" value="'.$info['id'].'">
    <button type="submit" class="btn btn-success" name="update">Yenile</button>
    <button type="submit" class="btn btn-danger" name="legv">Legv</button>

</form>
</div>';
}

//-----------------------------------------------INSERT--------------------------------------------//

if(isset($_POST['insert']))
{
    $mushteri_id = trim($_POST['mushteri_id']);
    $mehsul_id = trim($_POST['mehsul_id']);    
    $muddet=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['muddet']))));
    $ilkin=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['ilkin']))));
    $say=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['say']))));
    $faiz=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['faiz']))));

    if(!empty($mushteri_id) && !empty($mehsul_id) && !empty($muddet) && !empty($ilkin) && !empty($say) && !empty($faiz))
    {
       $daxiliy=mysqli_query($con,"INSERT INTO credits(mushteri_id,mehsul_id,muddet,ilkin,say,faiz,user_id) 
                                     VALUES('".$mushteri_id."','".$mehsul_id."','".$muddet."','".$ilkin."','".$say."','".$faiz."','".$_SESSION['user_id']."')");


        if($daxiliy==true)
        {echo'<div class="alert alert-success" role="alert">Melumatlar qeyde alindi !</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar qeyde alinmadi !</div>';}
}

else
{echo'<div class="alert alert-warning" role="alert">Bos xanalari doldurun !</div>';}

}


//-----------------------------------------------

if(isset($_POST['update']))
{
    $mushteri_id = trim($_POST['mushteri_id']);
    $mehsul_id = trim($_POST['mehsul_id']);    
    $muddet=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['muddet']))));
    $ilkin=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['ilkin']))));
    $say=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['say']))));
    $faiz=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['faiz']))));

    if(!empty($mushteri_id) && !empty($mehsul_id) && !empty($muddet) && !empty($ilkin) && !empty($say) && !empty($faiz))
    {
        $updating=mysqli_query($con,"UPDATE credits SET

                               mushteri_id='".$mushteri_id."',
                               mehsul_id='".$mehsul_id."',
                               say='".$say."',
                               muddet='".$muddet."',
                               ilkin='".$ilkin."',
                               say='".$say."',
                               faiz='".$faiz."'

                               WHERE id='".$_POST['id']."'");

        if($updating==true)
            {echo'<div class="alert alert-success" role="alert">Kredit ugurla yenilendi !</div>';}
        else
            {echo'<div class="alert alert-danger" role="alert">Krediti yenilemek mumkun olmadi !</div>';}
}

else
{echo'<div class="alert alert-warning" role="alert">Bosh xanalari doldurun !</div>';}

}

//-----------------------------------------------INSERT--------------------------------------------//

if(isset($_POST['x']))
{
    $k_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['k_id']))));
    $mebleg=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['mebleg']))));

    if(!empty($k_id) && !empty($mebleg))
    {
       $daxiliy=mysqli_query($con,"INSERT INTO payment(k_id,mebleg,user_id) 
                                     VALUES('".$k_id."','".$mebleg."','".$_SESSION['user_id']."')");

        if($daxiliy==true)
        {echo'<div class="alert alert-success" role="alert">Melumatlar qeyde alindi !</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar qeyde alinmadi !</div>';}
}

else
{echo'<div class="alert alert-warning" role="alert">Bos xanalari doldurun !</div>';}

}


//----------------------------------------------------------FORMA------------------------------------------------------------
if(!isset($_POST['edit']) && !isset($_POST['tesdiq']))
{
echo'
    <div class="alert alert-secondary" role="alert">
    <form method="post">
    Mushteri:<br>
    <select name="mushteri_id" class="form-control"><br>
    <option value="">Musterini secin</option>';

    $dsec = mysqli_query($con,"SELECT * FROM clients WHERE user_id='".$_SESSION['user_id']."' ORDER BY ad ASC");
    while($dinfo = mysqli_fetch_array($dsec))
        {echo'<option value="'.$dinfo['id'].'">'.$dinfo['ad'].' '.$dinfo['soyad'].'</option><br>';}
echo'
</select>
<br>
<form method="post">
    Mehsul:<br>
    <select name="mehsul_id" class="form-control">
    <option value="">Brend secin</option><br>';

   $bsec=mysqli_query($con,"SELECT 
                      brands.brend,
                      products.id,
                      products.mehsul,
                      products.miqdar,
                      products.satish
                      FROM brands,products
                      WHERE brands.id=products.brand_id AND products.user_id='".$_SESSION['user_id']."'
                      ORDER BY products.id DESC");

   while($binfo=mysqli_fetch_array($bsec))
    {echo'<option value="'.$binfo['id'].'">'.$binfo['brend'].' '.$binfo['mehsul'].' ['.$binfo['miqdar'].'] -- ['.$binfo['satish'].'azn] </option>';}
    
    echo'
    </select>
    <br>
    Sayi:<br>
    <input type="text" name="say" class="form-control" placeholder="Malın sayı"><br>
    Muddet:<br>
    <select name="muddet" class="form-control">
    <option value="">Muddeti secin</option><br>
    <option value="3">3</option>
    <option value="6">6</option>
    <option value="12">12</option>
    <option value="24">24</option>
    </select><br>
    Depozit:<br>
    <input type="text" name="ilkin" class="form-control" placeholder="İlkin ödəniş"><br>
    Faiz:<br>
    <select name="faiz" class="form-control">
    <option value="">Faizi secin</option><br>
    <option value="3">3</option>
    <option value="6">6</option>
    <option value="12">12</option>
    <option value="24">24</option>
    <option value="30">30</option>
    </select><br>
    <button type="submit" class="btn btn-dark" name="insert">Daxil</button>
    </form>
    </div>';    
}

if(isset($_POST['sil']))
{
    $silmeli=mysqli_query($con,"DELETE FROM credits WHERE id='".$_POST['id']."' ");

    if($silmeli==true)
    {echo'<div class="alert alert-success" role="alert">Melumatlar ugurla silindi !</div>';}
    else
    {echo'<div class="alert alert-danger" role="alert">Melumatlar silinmedi !</div>';}
}

//-------------------------------------------------------------

$selecting=mysqli_query($con,"SELECT 
                        brands.brend,
                        credits.id,
                        clients.ad,
                        clients.soyad,
                        products.mehsul,
                        products.satish,
                        credits.faiz,
                        credits.say,
                        credits.ilkin,
                        credits.muddet,
                        payment.mebleg,
                        payment.k_id,
                        credits.tarix
                        FROM users,brands,clients,products,credits,payment
                        WHERE
                        brands.id = products.brand_id AND
                        clients.id = credits.mushteri_id AND 
                        products.id = credits.mehsul_id AND
                        users.id = credits.user_id AND
                        users.id = '".$_SESSION['user_id']."' ORDER BY credits.id DESC ");

$count=mysqli_num_rows($selecting);

$i=0;

$osec = mysqli_query($con,"SELECT 
                            payment.k_id,
                            credits.id 
                            FROM credits,payment,users
                            WHERE
                            credits.id = payment.k_id AND
                            users.id = credits.user_id AND
                            users.id = '".$_SESSION['user_id']."' ");

$time=mysqli_num_rows($osec);

echo'
</div>
<form method="post">
    <table class="table table-bordered table-dark">
       <thead class="thead-dark">

        <th>#</th>
        <th>Mushteri</th>
        <th>Brand</th>
        <th>Mehsul</th>
        <th>Qiymeti</th>
        <th>Muddeti</th>
        <th>Sayi</th>
        <th>Faiz</th>
        <th>Depozit</th>
        <th>Top/brc</th>
        <th>Qal/brc</th>
        <th>Ayliq</th>
        <th>Kredit</th>
        <th>Tarix</th>   
        <th>Sil / Edit</th> 

        </thead><tbody>';



while($info=mysqli_fetch_array($selecting)) 
{
    $i++;

     $qiymet = $info['say'] * $info['satish'];
     $faiz = $qiymet * $info['faiz'] / 100 ;
     $topborc = ($qiymet + $faiz) - $info['ilkin'];
     $ayliq = round($topborc / $info['muddet']); 
     $odenish = $info['mebleg'] + $info['mebleg'];
     $qalborc = $topborc - $odenish;

     if($qalborc<=0){
        $qalborc = '0';

}

    /*$topborc = ($info['satish'] * $info['say']) - $info['ilkin'];
    $qalborc = $topborc - $info['ilkin'] / 100 * $info['faiz'];
    $ayliq = $qalborc / $info['muddet'];*/

    echo'<tr>';
    echo'<td>'.$i.'</td>';
    echo'<td>'.$info['ad'].' '.$info['soyad'].'</td>';
    echo'<td>'.$info['brend'].'</td>';
    echo'<td>'.$info['mehsul'].'</td>';
    echo'<td>'.$info['satish'].' azn</td>';
    echo'<td>'.$info['muddet'].' ay</td>';    
    echo'<td>'.$info['say'].' dənə</td>';
    echo'<td>'.$info['faiz'].' %</td>';
    echo'<td>'.$info['ilkin'].' azn</td>';
    echo'<td>'.$topborc.' azn</td>';
    echo'<td>'.$qalborc.' azn</td>';
    echo'<td>'.$ayliq.' azn</td>';
    echo'<td>'.$info['muddet'].'/'.$time.'</td>';
    echo'<td>'.$info['tarix'].'</td>';

    echo'
    <td>
    <form method="post">

      <input type="hidden" name="id" value="'.$info['id'].'">
      <button type="submit" name="sil" class="btn btn-danger"><i class="bi bi-x"></i></button>
      <button type="submit" name="edit" class="btn btn-warning"><i class="bi bi-pen"></i></button>
      <button type="submit" name="tesdiq" class="btn btn-light"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
     <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
      </svg></button>';


    echo'
    </form>
    </td></tr>';
}

if(isset($_POST['tesdiq']))
{
$xsec=mysqli_query($con,"SELECT 
                        clients.ad,
                        clients.soyad,
                        products.mehsul,
                        products.satish,
                        credits.id,
                        credits.ilkin,
                        credits.say,
                        credits.faiz,
                        credits.muddet
                        FROM credits,clients,products,users 
                        WHERE 
                        clients.id = credits.mushteri_id AND
                        products.id = credits.mehsul_id AND 
                        users.id = credits.user_id AND
                        credits.id = '".$_POST['id']."' AND
                        users.id = '".$_SESSION['user_id']."' ");

$xinfo=mysqli_fetch_array($xsec);
{
     $qiymet = $xinfo['say'] * $xinfo['satish'];
     $faiz = $qiymet * $xinfo['faiz'] / 100 ;
     $topborc = ($qiymet + $faiz) - $xinfo['ilkin'];
     $ayliq = round($topborc / $xinfo['muddet']); 
}

echo'
<div class="alert alert-secondary" role="alert">  
  <form method="post">
    Musteri : '.$xinfo['ad'].' '.$xinfo['soyad'].' <br><br>
    Ayliq : <b> '.$ayliq.' azn </b><br><br>
    Mehsul : '.$xinfo['mehsul'].'
    <br><br>
    Odenishin miqdari:
    <input type="text" name="mebleg"><br><br>
    <input type="hidden" name="k_id" value="'.$xinfo['id'].'">  
    <input type="hidden" name="ayliq" value="'.$ayliq.'">  

    <button type="submit" class="btn btn-dark" name="x">Odenish et</button>

  </form>
</div>';    
}

echo'</tbody></table></div>';

?>

<style>

body {
  display: grid;
  justify-content: center;
  align-items: center;
  font-size: 0.9rem;
}

</style>