<?php
session_start();

if(!isset($_SESSION['email']) or !isset($_SESSION['parol'])) 
{echo'<meta http-equiv="refresh" content="0; URL=index.php">'; exit;} 
$con=mysqli_connect('localhost','faiq','555','anbar');

if($_GET['b']=='brands')
{

//FILTERS START

if($_POST['f1']=='ASC' )
{$order = ' ORDER BY brend ASC'; $f1 = '<button type="button" class="btn btn-light f1" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f1']=='DESC' )
{$order = ' ORDER BY brend DESC'; $f1 = '<button type="button" class="btn btn-light f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f1 = '<button type="button" class="btn btn-light f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if($_POST['f2']=='ASC' )
{$order = ' ORDER BY tarix ASC'; $f2 = '<button type="button" class="btn btn-light f2" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f2']=='DESC' )
{$order = ' ORDER BY tarix DESC'; $f2 = '<button type="button" class="btn btn-light f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f2 = '<button type="button" class="btn btn-light f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if(!isset($_POST['f1']) && !isset($_POST['f2']))
{$order = ' ORDER BY id DESC';}

//FILTER END

//-----------------------------EDIT------------------------------//

if(isset($_POST['edit_id']))
{
    $edit_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['edit_id']))));

    $select=mysqli_query($con,"SELECT * FROM brands WHERE id='".$edit_id."' AND user_id='".$_SESSION['user_id']."' ");
    
    $info=mysqli_fetch_array($select);

echo'
    <div class="alert alert-secondary" role="alert">
  <form method="post" enctype="multipart/form-data" id="brands_update">
  Brend:<br>
  <input type="text" name="brend" value="'.$info['brend'].'" class="form-control"><br>
  Logo:<br>
  <img style="width:75px; height:60px;" src="'.$info['foto'].'"><br>
  <input type="file"  name="foto" value="'.$info['foto'].' class="form-control"><br>
  <input type="hidden" name="id" value="'.$info['id'].'"><br>
  <input type="hidden" name="lid" value="'.$info['foto'].'">
  <input type="hidden" name="update">
  <button type="button" class="btn btn-success update">Yenile</button>
  <button type="button" class="btn btn-danger insert">Legv</button>

 </form>
 </div>';

}

//--------------------------UPDATE-------------------------------//

if(isset($_POST['update']))
{
    $brend=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['brend']))));

    if(!empty($brend))
    {
        $yoxla=mysqli_query($con,"SELECT brend FROM brands WHERE brend='".$brend."' AND id!='".$_POST['id']."' AND user_id='".$_SESSION['user_id']."' ");
        if(mysqli_num_rows($yoxla)==0)
    {       
        if($_FILES['foto']['size']<1024)
        {$unvan = $_POST['lid'];}
    else
        {include "upload.php";}
    if(!isset($error))
    {
        $yenileme=mysqli_query($con,"UPDATE brands SET 
            foto='".$unvan."',
            brend='".$brend."'   
            
            WHERE id='".$_POST['id']."' ");

        if($yenileme==true)
            {echo'<div class="alert alert-success" id="ugurupdate" role="alert">Melumatlar ugurla yenilendi</div>';}
        else
            {echo'<div class="alert alert-danger" role="alert">Melumatlar yenilenmedi !</div>';}
    }

}
else
    {echo'<div class="alert alert-warning" role="alert">Bu mehsul bazada movcuddur!</div>';}
}
else
    {echo'<div class="alert alert-warning" role="alert">Bosh xanani doldurun!</div>';}
}

//---------------------------------INSERT-----------------------------//

if(isset($_POST['insert']))
{
    $brend=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['brend']))));

    if(!empty($brend))
    {
        $yoxla=mysqli_query($con,"SELECT brend FROM brands WHERE brend='".$brend."' AND user_id='".$_SESSION['user_id']."'");
        if(mysqli_num_rows($yoxla)==0)
    {
        include"upload.php";

        if(!isset($error))
        {
        $daxil=mysqli_query($con,"INSERT INTO brands(brend,foto,user_id) VALUES('".$brend."','".$unvan."','".$_SESSION['user_id']."') ");

            if($daxil==true)
              {echo'<div class="alert alert-success" id="ugurinsert" role="alert">Brendler ugurla daxil edildi.</div>';}
            else
              {echo'<div class="alert alert-danger" role="alert">Brendleri daxil etmek mumkun olmadi.</div>';} 
      }

    }
else
{echo'<div class="alert alert-warning" role="alert">Eyni brend bazaya otura bilməz.</div>';}
}
else
{echo'<div class="alert alert-warning" role="alert">Bos xanalari doldurun !</div>';}
}

if(!isset($_POST['edit']) && !isset($_POST['edit_id']))
{
echo'
<div class="alert alert-secondary" role="alert">  
  <form method="post" enctype="multipart/form-data" id="brands_insert">
    Brend:<br>
    <input type="text" name="brend" class="form-control">
    Logo:<br> 
    <input type="file" class="form-control" name="foto" autocomplete="off"><br>
    <input type="hidden" name="insert">
    <button type="button" class="btn rounded-pill btn-dark insert">Daxil ol</button>
  </form>
</div>';    
}


if(isset($_POST['sil_id']))
    {
        $yoxla=mysqli_query($con,"SELECT brand_id FROM products WHERE brand_id='".$_POST['sil_id']."' ");
        if(mysqli_num_rows($yoxla)==0)
        {
        $sil=mysqli_query($con,"DELETE FROM brands WHERE id='".$_POST['sil_id']."' ");

        if($sil==true)
        {echo'<div class="alert alert-success" id="ugursil" role="alert">Brend ugurla silindi.</div>';}
        else
    {echo'<div class="alert alert-danger" role="alert">Brendi silmek mumkun olmadi.</div>';}
    }
    else
    {echo'<div class="alert alert-danger" role="alert">Bu brendin bazada məhsulu var deyə silinə bilməz.</div>';}

    }

//-----------------------------------------------SECIM DELETE-------------------------------------------//

     if(count($_POST['secim'])>0)
    {
        $mesaj = '';
        for($n=0;$n<count($_POST['secim']); $n++)
        {   
            $yoxlama=mysqli_query($con,"SELECT brand_id FROM products WHERE brand_id='".$_POST['secim'][$n]."' ");
            if(mysqli_num_rows($yoxlama)==0)
            {$silme=mysqli_query($con,"DELETE FROM brands WHERE id='".$_POST['secim'][$n]."' ");

            {$mesaj = '<div class="alert alert-success" role="alert">Brendler ugurla silindi.</div>';}
      }
            else
            {$mesaj = '<div class="alert alert-danger" role="alert">Bezi brendlerin bazada mehsulu oldugu ucun silinmesi mumkun deyil.</div>';}
        }

        echo $mesaj;
    }
//-----------------------------------------------SECIM DELETE END-------------------------------------------//

    $input=$_POST['input'];
    $secim=mysqli_query($con,"SELECT * FROM brands WHERE brend LIKE '{$input}%' AND user_id ='".$_SESSION['user_id']."' ".$order." ");

    $sayi=mysqli_num_rows($secim);

    $i=0;

    if($sayi!=0)
    {echo'<div class="alert alert-warning" role="alert">Anbarda <b>'.$sayi.'</b> brend var.</div>';}

    echo'<form method="post" id="main_form">
    <div class="table-dark">
        <table class="table table-bordered table-dark">
            <thead class="thead-dark">

                <th><input type="checkbox" name="secim[]" value="'.$info['id'].'"></th>
                <th>Logo</th>
                <th>Brend '.$f1.'</th>
                <th>Tarix '.$f2.'</th>
                <th><button type="button" name="secsil" class="btn btn-danger btn-sm secsil">Secimleri sil</button></th>
            
            </thead>
            <tbody>';

while($info=mysqli_fetch_array($secim))
{
        $i++;

        echo'<tr>';
        echo'<td>'.$i.' <input type="checkbox" name="secim[]" value="'.$info['id'].'"></td>';
        echo'<td><img style="width:75px; height:60px;" src="'.$info['foto'].'"></td>';
        echo'<td>'.$info['brend'].'</td>';
        echo'<td>'.$info['tarix'].'</td>';
        echo'
        <td>
        <form method="post">
            <input type="hidden" name="id" value="'.$info['id'].'">
            <button type="button" name="edit" class="btn btn-warning edit" id="'.$info['id'].'"><i class="bi bi-pencil"></i></button>
            <button type="button" name="delete" class="btn btn-danger sil" id="'.$info['id'].'"><i class="bi bi-trash"></i></button>
        </form>
        </td>
        </tr>';       
    }

    echo'</tbody></table>';
}

//-------------------------------------CLIENTS START AJAX----------------------------------//
?>

<?php

if($_GET['c']=='clients')
{

//FILTERS START

if($_POST['f1']=='ASC' )
{$order = ' ORDER BY ad ASC'; $f1 = '<button type="button" class="btn btn-light btn-sm f1" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f1']=='DESC' )
{$order = ' ORDER BY ad DESC'; $f1 = '<button type="button" class="btn btn-light btn-sm f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f1 = '<button type="button" class="btn btn-light btn-sm f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if($_POST['f2']=='ASC' )
{$order = ' ORDER BY tarix ASC'; $f2 = '<button type="button" class="btn btn-light btn-sm f2" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f2']=='DESC' )
{$order = ' ORDER BY tarix DESC'; $f2 = '<button type="button" class="btn btn-light btn-sm f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f2 = '<button type="button" class="btn btn-light btn-sm f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if(!isset($_POST['f1']) && !isset($_POST['f2']))
{$order = ' ORDER BY id DESC';}

//FILTER END

//----------------------------------------DELETE SECIM--------------------------------------//

if(count($_POST['secim'])>0)
{
        $mesaj = '';
        for($n=0;$n<count($_POST['secim']); $n++)
    {   
            $yoxlama=mysqli_query($con,"SELECT client_id FROM orders WHERE client_id='".$_POST['secim'][$n]."' ");
            if(mysqli_num_rows($yoxlama)==0)
        { 
                $silme=mysqli_query($con,"DELETE FROM clients WHERE id='".$_POST['secim'][$n]."' ");

            {$mesaj = '<div class="alert alert-success" role="alert">Mushteriler ugurla silindi.</div>';}
        }
            else
            {$mesaj = '<div class="alert alert-danger" role="alert">Bezi mushterilerin sifarisi oldugu ucun silinmesi mumkun deyil.</div>';}
    }

        echo $mesaj;
}
   
//----------------------------------------------EDIT--------------------------------------------//

if(isset($_POST['edit_id']))
{
     $edit_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['edit_id']))));

    $edit=mysqli_query($con,"SELECT * FROM clients WHERE id='".$edit_id."' AND user_id='".$_SESSION['user_id']."' ");

    $info=mysqli_fetch_array($edit);

echo'
<div class="alert alert-secondary" role="alert">
  <form method="post" id="clients_update" enctype="multipart/form-data">
    Foto:<br>
    <img style="width:75px; height:60px;" src="'.$info['foto'].'"><br>
    <input type="file"  name="foto" value="'.$info['foto'].'" class="form-control"><br>
    <input type="hidden" name="lid" value="'.$info['foto'].'">
    Ad:<br>
    <input type="text" name="ad" value="'.$info['ad'].'" class="form-control"><br>
    Soyad:<br>
    <input type="text" name="soyad" value="'.$info['soyad'].'" class="form-control"><br>
    Telefon:<br>
    <input type="text" name="telefon" value="'.$info['telefon'].'" class="form-control"><br>
    Email:<br>
    <input type="text" name="email" value="'.$info['email'].'" class="form-control"><br>
    Shirket:<br>
    <input type="text" name="shirket" value="'.$info['shirket'].'" class="form-control"><br>
    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="update">
    <button type="button" class="btn btn-success update">Yenile</button>
    <button type="button" class="btn btn-danger daxil">Legv</button>
  </form>
</div>';

}

//--------------------------------------------------UPDATE--------------------------------------------------//

if(isset($_POST['update']))
{
        $ad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['ad']))));
        $soyad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['soyad']))));
        $telefon=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['telefon']))));
        $email=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['email']))));
        $shirket=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['shirket']))));

    if(!empty($ad) && !empty($soyad) && !empty($telefon) && !empty($email) && !empty($shirket) && !empty($_POST['foto']))
        {

        if($_FILES['foto']['size']<1024)
        {$unvan = $_POST['lid'];}
         else
        {include "upload.php";}
        if(!isset($error))
        {
                                $update=mysqli_query($con,"UPDATE clients SET 
                                                      ad='".$ad."',
                                                      soyad='".$soyad."',
                                                      telefon='".$telefon."',
                                                      email='".$email."',
                                                      shirket='".$shirket."',
                                                      foto='".$unvan."'

                                                      WHERE id='".$_POST['id']."'");

      if($update==true)
      {echo'<div class="alert alert-success" id="ugurupdate" role="alert">Melumatlar ugurla yenilendi.</div>';}
      else
      {echo'<div class="alert alert-danger" role="alert">Melumatlari yenilemek mumkun olmadi.</div>';}
   }

}

  else
  {echo'<div class="alert alert-warning" role="alert">Bosh xanalari doldurun !</div>';}

}

if(!isset($_POST['edit']) && !isset($_POST['edit_id']))
{
    echo'
<div class="alert alert-secondary" role="alert">
  <form method="post" id="clients_insert">
    Foto:<br>
    <input type="file" name="foto" class="form-control"><br>
    Ad:<br>
    <input type="text" name="ad" class="form-control"><br>
    Soyad:<br>
    <input type="text" name="soyad" class="form-control"><br>
    Telefon:<br>
    <input type="text" name="telefon" class="form-control"><br>
    Email:<br>
    <input type="text" name="email" class="form-control"><br>
    Shirket:<br>    
    <input type="text" name="shirket" class="form-control"><br>
    <input type="hidden" name="daxil">
    <button type="button" class="btn btn-dark daxil">Daxil</button>
   </form>
</div>';    
}

//--------------------------------------------INSERT---------------------------------------------//

if(isset($_POST['daxil']))
{
        $ad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['ad']))));
        $soyad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['soyad']))));
        $telefon=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['telefon']))));
        $email=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['email']))));
        $shirket=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['shirket']))));

    if(!empty($ad) && !empty($soyad) && !empty($telefon) && !empty($email) && !empty($shirket))
    {
        $unikal=mysqli_query($con,"SELECT * FROM clients WHERE telefon='".$telefon."' OR email='".$email."'");

        $sayisi=mysqli_num_rows($unikal);
        if($sayisi==0)
      {
        include"upload.php";
        if(!isset($error))
        {

        $insert=mysqli_query($con,"INSERT INTO clients(ad,soyad,telefon,email,shirket,foto,user_id)
        VALUES('".$ad."','".$soyad."','".$telefon."','".$email."','".$shirket."','".$unvan."','".$_SESSION['user_id']."')");


                    if($insert==true)
                    {echo'<div class="alert alert-success" id="ugurgir" role="alert">Melumatlar ugurla daxil edildi.</div>';}
                    else
                    {echo'<div class="alert alert-danger" role="alert">Melumatlar daxil olmadi.</div>';}
    }

  }
    else
    {echo'<div class="alert alert-danger" role="alert">Eyni nomre bazaya otura bilmez.</div>';}
}

else
    {echo'<div class="alert alert-warning" role="alert">Bosh xanalari bosh saxlamayin.</div>';}
}


if(isset($_POST['clientsil']))
{
    $yox=mysqli_query($con,"SELECT client_id FROM orders WHERE client_id='".$_POST['clientsil']."' ");
    if(mysqli_num_rows($yox)==0)
    {
    $delete=mysqli_query($con,"DELETE FROM clients WHERE id='".$_POST['clientsil']."' ");

    if($delete==true)
    {echo'<div class="alert alert-success" id="ugursil" role="alert">Melumatlar ugurla silindi.</div>';}
    else
    {echo'<div class="alert alert-danger" role="alert">Melumatlari silmediniz.</div>';}
}
else
   {echo'<div class="alert alert-danger" role="alert">Bu mushterinin sifarisi oldugu ucun silinmesi mumkun deyil.</div>';}
}

$input=$_POST['input'];
$select=mysqli_query($con,"SELECT * FROM clients WHERE (ad LIKE '%{$input}%' OR soyad LIKE '%{$input}%' OR telefon LIKE '%{$input}%' OR shirket LIKE '%{$input}%') AND user_id='".$_SESSION['user_id']."' ".$order." ");

$say=mysqli_num_rows($select);

$i=0;

if($say!=0)
{echo'<div class="alert alert-warning" role="alert">Anbarda <b>'.$say.'</b> brend var.</div>';}

echo'
<form method="post" id="main_form">
  <div class="table-dark">
    <table class="table table-bordered table-dark">
       <thead class="thead-dark">

     <th>#</th>
     <th>Foto</th>
     <th>Ad '.$f1.'</th>
     <th>Soyad</th>
     <th>Telefon</th>
     <th>Email</th>
     <th>Shirket</th>
     <th>Tarix '.$f2.'</th>
     <th><button type="button" class="btn btn-danger btn-sm secsil">Secimleri sil</button></th>

     </thead>

     <tbody> ';

while($info=mysqli_fetch_array($select))
{
    $i++;

    echo'<tr>';
    echo'<td>'.$i.' <input type="checkbox" name="secim[]" value="'.$info['id'].'"></td>';
    echo'<td><img style="width:75px; height:60px;" src="'.$info['foto'].'"></td>';
    echo'<td>'.$info['ad'].'</td>';
    echo'<td>'.$info['soyad'].'</td>';
    echo'<td>'.$info['telefon'].'</td>';
    echo'<td>'.$info['email'].'</td>';
    echo'<td>'.$info['shirket'].'</td>';
    echo'<td>'.$info['tarix'].'</td>';

    echo'
    <td>
    <form method="post">
           <input type="hidden" name="id" value="'.$info['id'].'">
           <button type="button" class="btn btn-warning edit" id="'.$info['id'].'"><i class="bi bi-pencil"></i></button>
           <button type="button" class="btn btn-danger sil" id="'.$info['id'].'"><i class="bi bi-trash"></i></button>
     </form>
     </td>';

    echo'</tr>';
}

echo'</tbody></table>';

}

//---------------------------------EXPENSE AJAX START-----------------------------//

?>

<?php 

if($_GET['e']=='expense')
{

//FILTER START

if($_POST['f1']=='ASC' )
{$order = ' ORDER BY teyinat ASC'; $f1 = '<button type="button" class="btn btn-light f1" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f1']=='DESC' )
{$order = ' ORDER BY teyinat DESC'; $f1 = '<button type="button" class="btn btn-light f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f1 = '<button type="button" class="btn btn-light f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if($_POST['f2']=='ASC' )
{$order = ' ORDER BY tarix ASC'; $f2 = '<button type="button" class="btn btn-light f2" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f2']=='DESC' )
{$order = ' ORDER BY tarix DESC'; $f2 = '<button type="button" class="btn btn-light f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f2 = '<button type="button" class="btn btn-light f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if(!isset($_POST['f1']) && !isset($_POST['f2']))
{$order = ' ORDER BY id DESC';}

//FILTER END

//-------------------------------------------SECIM DELETE------------------------------------------//

if(count($_POST['secim'])>0)
{
    $mesaj = '';
    for($n=0;$n<count($_POST['secim']); $n++)
    {
        $sil=mysqli_query($con,"DELETE FROM expense WHERE id='".$_POST['secim'][$n]."'");
    
    {$mesaj = '<div class="alert alert-success" role="alert">Seçilmiş teyinatlar uğurla silindi.</div>';}
}
    echo $mesaj;
}

//-----------------------------------------------EDIT----------------------------------------------//

if(isset($_POST['edit_id']))
{
     $edit_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['edit_id']))));

  $editing=mysqli_query($con,"SELECT * FROM expense WHERE id='".$edit_id."' AND user_id='".$_SESSION['user_id']."'");
  $info=mysqli_fetch_array($editing);

echo '
<div class="alert alert-secondary" role="alert">
  <form method="post" id="expense_update">
    Təyinat:<br>
    <input type="text" name="teyinat" value="'.$info['teyinat'].'" class="form-control"><br>
    Məbləg:<br>
    <input type="text" name="mebleg" value="'.$info['mebleg'].'" class="form-control"><br>
    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="update">
    <button type="button" class="btn btn-success update">Yenile</button>
    <button type="button" class="btn btn-danger ok">Legv</button>
</form> 
</div>';

}

//-----------------------------------------------UPDATE---------------------------------------------//

if(isset($_POST['update']))
{
    $teyinat=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['teyinat']))));

    $mebleg=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['mebleg']))));

    if(!empty($teyinat) && !empty($mebleg))

    {
        $updating=mysqli_query($con,"UPDATE expense SET teyinat='".$teyinat."',
            mebleg='".$mebleg."'
           WHERE id='".$_POST['id']."'");

        if($updating==true)
        {echo'<div class="alert alert-success" role="alert">Teyinatlar ugurla yeniləndi.</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Teyinatlar yenilənmədi.</div>';}
}

   else
   {echo'<div class="alert alert-warning" role="alert">Boş yerləri doldurun.</div>';}
  
}


if(!isset($_POST['edit']) && !isset($_POST['edit_id']))
{
echo'
<div class="alert alert-secondary" role="alert">
  <form method="post" id="expense_insert">
    Təyinat:<br>
    <input type="text" name="teyinat" class="form-control"><br>
    Məbləg:<br>
    <input type="text" name="mebleg" class="form-control"><br>
    <input type="hidden" name="ok">
    <button type="button" class="btn btn-dark ok">Daxil</button>
  </form>
</div>';    
}

//------------------------------------------INSERT--------------------------------------//

if(isset($_POST['ok']))
{
    $teyinat=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['teyinat']))));

    $mebleg=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['mebleg']))));

    if(!empty($teyinat) && !empty($mebleg))
    {
        $inserting=mysqli_query($con,"INSERT INTO expense(teyinat,mebleg,user_id) VALUES('".$teyinat."','".$mebleg."','".$_SESSION['user_id']."')");

        if($inserting==true)
        {echo'<div class="alert alert-success" role="alert">Məlumatlar ugurla daxil edildi.</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Məlumatları daxil etmek mumkun olmadı.</div>';}
}

else
{echo'<div class="alert alert-dark" role="alert">Məlumatları daxil ediniz.</div>';}

}

//---------------------------------------EXPENSE SIL---------------------------------//

if(isset($_POST['xercsil']))
{
    $deleting=mysqli_query($con,"DELETE FROM expense WHERE id='".$_POST['xercsil']."'");

    if($deleting==true)
    {echo'<div class="alert alert-success" role="alert">Teyinat ugurla silindi.</div>';}
    else
    {echo'<div class="alert alert-danger" role="alert">Teyinatı silmək mümkün olmadı.</div>';}
}

//---------------------------------------EXPENSE SIL END---------------------------------//

$input=$_POST['input'];
$secme=mysqli_query($con,"SELECT * FROM expense WHERE (teyinat LIKE '{$input}%' OR mebleg LIKE '%{$input}%') AND user_id='".$_SESSION['user_id']."' ".$order." ");

$say=mysqli_num_rows($secme);

$i=0;

if($say!=0)
{echo'<div class="alert alert-warning" role="alert">Anbarda <b>'.$say.'</b> brend var.</div>';}

echo'
<form method="post" id="main_form">
 <div class="table-dark">
    <table class="table table-bordered table-dark">
       <thead class="thead-dark">

        <th>#</th>
        <th>Təyinat '.$f1.'</th>
        <th>Məbləg</th>
        <th>Tarix '.$f2.'</th>
        <th><button type="button" name="secsil" class="btn btn-danger btn-sm secsil">Secimleri sil</button></th>       
        

        </thead>

        <tbody> ';

while($info=mysqli_fetch_array($secme))
{
    $i++;

    echo'<tr>';
    echo'<td>'.$i.' <input type="checkbox" name="secim[]" value="'.$info['id'].'"></td>';
    echo'<td>'.$info['teyinat'].'</td>';
    echo'<td>'.$info['mebleg'].'</td>';
    echo'<td>'.$info['tarix'].'</td>';

    echo'
    <td>
    <form method="post">
           <input type="hidden" name="id" value="'.$info['id'].'">
           <button type="button" name="edit" class="btn btn-warning edit" id="'.$info['id'].'"><i class="bi bi-pencil"></i></button>
           <button type="button" name="delete" class="btn btn-danger sil" id="'.$info['id'].'"><i class="bi bi-trash"></i></button>
   </form> 
   </td>
   </tr>';

}

echo'</tbody></table>';

}

//---------------------------------PRODUCTS AJAX START---------------------------------//
?>

<?php 

if($_GET['p']=='products')
{

//FILTER START

if($_POST['f1']=='ASC' )
{$order = ' ORDER BY mehsul ASC'; $f1 = '<button type="button" class="btn btn-light btn-sm f1" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f1']=='DESC' )
{$order = ' ORDER BY mehsul DESC'; $f1 = '<button type="button" class="btn btn-light btn-sm f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f1 = '<button type="button" class="btn btn-light btn-sm f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if($_POST['f2']=='ASC' )
{$order = ' ORDER BY tarix ASC'; $f2 = '<button type="button" class="btn btn-light btn-sm f2" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f2']=='DESC' )
{$order = ' ORDER BY tarix DESC'; $f2 = '<button type="button" class="btn btn-light btn-sm f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f2 = '<button type="button" class="btn btn-light btn-sm f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if(!isset($_POST['f1']) && !isset($_POST['f2']))
{$order = ' ORDER BY id DESC';}

//FILTER END

//----------------------------------------------SECIM DELETE------------------------------------------//

if(isset($_POST['beli']) && count($_POST['secim'])>0)
{
    for($n=0;$n<count($_POST['secim']); $n++)
    {
        $sil=mysqli_query($con,"DELETE FROM products WHERE id='".$_POST['secim'][$n]."'");
    }
    {echo'<div class="alert alert-danger" role="alert">Seçilmiş məlumatlar uğurla silindi.</div>';}
}

//-------------------------------------------------EDIT------------------------------------------------//

if(isset($_POST['edit_id']))
{
     $edit_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['edit_id']))));

    $editing=mysqli_query($con,"SELECT * FROM products WHERE id='".$_POST['edit_id']."' ");
    $info=mysqli_fetch_array($editing);

    echo'<div class="alert alert-secondary" role="alert">
    <form method="post" enctype="multipart/form-data" id="products_update">
    Shekil:<br>
    <img style="width:75px; height:60px;" src="'.$info['foto'].'"><br>
    <input type="file"  name="foto" value="'.$info['foto'].' class="form-control"><br>
    Mehsul:<br>
    <input type="text" name="mehsul" value="'.$info['mehsul'].'" class="form-control"><br>

    Brend:<br>
    <select name="brand_id" class="form-control"><br>
    <option value="">Brend secin</option>';

    $bsec=mysqli_query($con,"SELECT * FROM brands WHERE user_id='".$_SESSION['user_id']."' ORDER BY brend ASC ");

    while ($binfo=mysqli_fetch_array($bsec))
    {
        if($info['brand_id']==$binfo['id'])
            {echo'<option selected value="'.$binfo['id'].'">'.$binfo['brend'].'</option>';}
        else
            {echo'<option value="'.$binfo['id'].'">'.$binfo['brend'].'</option>';}
    }
    echo'
    </select>
    <br>
    Alish:<br>
    <input type="text" name="alish" value="'.$info['alish'].'" class="form-control"><br>
    Satish:<br>
    <input type="text" name="satish" value="'.$info['satish'].'" class="form-control"><br>
    Miqdar:<br>
    <input type="text" name="miqdar" value="'.$info['miqdar'].'" class="form-control"><br>
    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="lid" value="'.$info['foto'].'">
    <input type="hidden" name="update">
    <button type="button" class="btn btn-success update">Yenile</button>
    <button type="button" class="btn btn-danger insert">Legv</button>
</form>
</div>';
}

//------------------------------------------------UPDATE---------------------------------------------------//

if(isset($_POST['update']))
{
    $mehsul=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['mehsul']))));
    $brand_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['brand_id']))));
    $alish=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['alish']))));
    $satish=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['satish']))));
    $miqdar=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['miqdar']))));

    if(!empty($mehsul) && !empty($brand_id) && !empty($alish) && !empty($satish) && !empty($miqdar))
    {
        $updating=mysqli_query($con,"UPDATE products SET
                               mehsul='".$mehsul."',
                               brand_id='".$brand_id."',
                               alish='".$alish."',
                               satish='".$satish."',
                               miqdar='".$miqdar."'

                               WHERE id='".$_POST['id']."'");

        if($updating==true)
            {echo'<div class="alert alert-success" id="ugurupdate" role="alert">Melumatlar ugurla yenilendi.</div>';}
        else
            {echo'<div class="alert alert-danger" role="alert">Melumatlari yenilemek mumkun olmadi.</div>';}
}

else
{echo'<div class="alert alert-warning" role="alert">Bosh xanalari doldurun !</div>';}

}

if(!isset($_POST['edit']) && !isset($_POST['edit_id']))
{
    echo'
    <div class="alert alert-secondary" role="alert">
    <form method="post" enctype="multipart/form-data" id="products_insert">
    Shekil:<br>
    <input type="file" name="foto" class="form-control" title="şəkil əlavə ediniz"><br>
    Mehsul:<br>
    <input type="text" name="mehsul" class="form-control"><br>
    Brend:<br>
    <select name="brand_id" class="form-control">
    <option value="">Brend secin</option><br>';

    $bsec = mysqli_query($con,"SELECT * FROM brands WHERE user_id = '".$_SESSION['user_id']."' ORDER BY brend ASC");
    while($binfo = mysqli_fetch_array($bsec))
        {echo'<option value="'.$binfo['id'].'">'.$binfo['brend'].'</option><br>';}
    
    echo'
    </select>
    <br>
    Alish:<br>
    <input type="text" name="alish" class="form-control"><br>
    Satish:<br>
    <input type="text" name="satish" class="form-control"><br>
    Miqdar:<br>
    <input type="text" name="miqdar" class="form-control"><br>
    <input type="hidden" name="insert">
    <button type="button" class="btn btn-dark insert">Gir</button>
    </form>
    </div>';    
}


//-----------------------------------------------INSERT--------------------------------------------//

if(isset($_POST['insert']))
{
    $mehsul=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['mehsul']))));
    $brand_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['brand_id']))));
    $alish=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['alish']))));
    $satish=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['satish']))));
    $miqdar=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['miqdar']))));

    if(!empty($mehsul) &&  !empty($brand_id) && !empty($alish) && !empty($satish) && !empty($miqdar))
    {
        include"upload.php";

    if(!isset($error))
    {
        $inserting=mysqli_query($con,"INSERT INTO products(mehsul,brand_id,alish,satish,miqdar,user_id,foto) 
                               VALUES('".$mehsul."','".$brand_id."','".$alish."','".$satish."','".$miqdar."','".$_SESSION['user_id']."','".$unvan."')");
    }
        if($inserting==true)
        {echo'<div class="alert alert-success" id="ugurgir" role="alert">Melumatlar qeyde alindi.</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar qeyde alinmadi.</div>';}
}

else
{echo'<div class="alert" alert-warning" role="alert">Bos xanalari doldurun !</div>';}

}

if(isset($_POST['productsil']))
{
        $deleting=mysqli_query($con,"DELETE FROM products WHERE id='".$_POST['productsil']."'");
    
        if($deleting==true)
        {echo'<div class="alert alert-success" id="ugursil" role="alert">Melumatlar ugurla silindi.</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar silinmedi.</div>';}
}
    
    $input=$_POST['input'];

    $selecting=mysqli_query($con,"SELECT 
    brands.brend,
    products.id, 
    products.mehsul,
    products.alish,
    products.satish,
    products.miqdar,
    products.foto,
    products.tarix
    FROM users,brands,products
    WHERE
    (mehsul LIKE '{$input}%' OR brands.brend LIKE '%{$input}%') AND
    brands.id=products.brand_id AND 
    users.id=products.user_id AND 
    users.id='".$_SESSION['user_id']."'
    ".$order." ");

$count=mysqli_num_rows($selecting);

$i=0;

if($count!=0)
{echo'<div class="alert alert-warning" role="alert">Anbarda <b>'.$count.'</b> brend var.</div>';}

echo '<form method="post">';

echo'<div class="table-dark">
    <table class="table table-bordered table-dark">
       <thead class="thead-dark">
    
    <th>#</th>
    <th>Shekil</th>
    <th>Mehsul '.$f1.'</th>
    <th>Brand</th>
    <th>Alish</th>
    <th>Satish</th>
    <th>Miqdar</th>
    <th>Qazanc</th>
    <th>Tarix '.$f2.'</th>
    <th><button type="submit" name="secsil" class="btn btn-danger btn-sm">Secimleri sil</button></th>
   
    </thead>

    <tbody> ';

while($info=mysqli_fetch_array($selecting)) 
{
    $i++;

    $qazanc=($info['satish']-$info['alish'])*$info['miqdar'];

    echo'<tr>';
    echo'<td>'.$i.' <input type="checkbox" name="secim[]" value="'.$info['id'].'"></td>';
    echo'<td><img style="width:75px; height:60px;" src="'.$info['foto'].'"></td>';
    echo'<td>'.$info['mehsul'].'</td>';
    echo'<td>'.$info['brend'].'</td>';
    echo'<td>'.$info['alish'].'</td>';
    echo'<td>'.$info['satish'].'</td>';
    echo'<td>'.$info['miqdar'].'</td>';
    echo'<td>'.$qazanc.'</td>';
    echo'<td>'.$info['tarix'].'</td>';

    echo'
    <td>
    <form method="post">
    <input type="hidden" name="id" value="'.$info['id'].'">
    <button type="button" name="edit" class="btn btn-warning edit" id="'.$info['id'].'"><i class="bi bi-pencil"></i></button>
    <button type="button" name="delete" class="btn btn-danger sil" id="'.$info['id'].'"><i class="bi bi-trash"></i></button>

    </form>
    </td></tr>';

}

echo'</tbody></table>';

}

//---------------------------------ORDERS AJAX START---------------------------------//
?>

<?php  

if($_GET['o']=='orders')
{

//FILTER START

if($_POST['f1']=='ASC' )
{$order = ' ORDER BY ad ASC'; $f1 = '<button type="button" class="btn btn-light btn-sm f1" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f1']=='DESC' )
{$order = ' ORDER BY ad DESC'; $f1 = '<button type="button" class="btn btn-light btn-sm f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f1 = '<button type="button" class="btn btn-light btn-sm f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}


if($_POST['f2']=='ASC' )
{$order = ' ORDER BY mehsul ASC'; $f2 = '<button type="button" class="btn btn-light btn-sm f2" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f2']=='DESC' )
{$order = ' ORDER BY mehsul DESC'; $f2 = '<button type="button" class="btn btn-light btn-sm f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f2 = '<button type="button" class="btn btn-light btn-sm f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}


if($_POST['f3']=='ASC' )
{$order = ' ORDER BY tarix ASC'; $f3 = '<button type="button" class="btn btn-light btn-sm f3" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f3']=='DESC' )
{$order = ' ORDER BY tarix DESC'; $f3 = '<button type="button" class="btn btn-light btn-sm f3" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f3 = '<button type="button" class="btn btn-light btn-sm f3" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if(!isset($_POST['f1']) && !isset($_POST['f2']) && !isset($_POST['f3']))
{$order = ' ORDER BY id DESC';}

//FILTER END


//----------------------------------------------SECIM DELETE------------------------------------------//

if(count($_POST['secim'])>0)
{
    for($n=0;$n<count($_POST['secim']); $n++)
    {
        $sil=mysqli_query($con,"DELETE FROM orders WHERE id='".$_POST['secim'][$n]."'");
    }
    
    {echo'<div class="alert alert-danger" role="alert">Seçilmiş məlumatlar uğurla silindi.</div>';}
}

//-------------------------------------------------EDIT------------------------------------------------//

if(isset($_POST['edit_id']))
{
     $edit_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['edit_id']))));

    $editing=mysqli_query($con,"SELECT * FROM orders WHERE id='".$_POST['edit_id']."' ");
    $info=mysqli_fetch_array($editing);

    echo'<div class="alert alert-secondary" role="alert">
    <form method="post" id="orders_update">
    Musteri:<br>
    <select name="client_id" class="form-control"><br>
    <option value="">Musteri secin</option>';

$bsec=mysqli_query($con,"SELECT * FROM clients WHERE clients.user_id = '".$_SESSION['user_id']."' ORDER BY id ASC");

    while($binfo=mysqli_fetch_array($bsec))
    {
        if($info['client_id']==$binfo['id'])
            {echo'<option selected value="'.$binfo['id'].'">'.$binfo['ad'].' '.$binfo['soyad'].'</option>';}
      else
           {echo'<option value="'.$binfo['id'].'">'.$binfo['ad'].' '.$binfo['soyad'].'</option>';}
    }
    echo'
    </select>
    <br>
    Mehsul:<br>
    <select name="product_id" class="form-control"><br>
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
    if($info['product_id']==$binfo['id'])
    {echo'<option selected value="'.$binfo['id'].'">'.$binfo['brend'].' '.$binfo['mehsul'].' ['.$binfo['miqdar'].']</option>';}
    else
    {echo'<option value="'.$binfo['id'].'">'.$binfo['brend'].' '.$binfo['mehsul'].' ['.$binfo['miqdar'].']</option>';}
 }
echo'
    </select>
    <br>
    Miqdar:<br>
    <input type="text" name="miqdar" value="'.$info['miqdar'].'" class="form-control"><br>
    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="update">
    <button type="button" class="btn btn-success update">Yenile</button>
    <button type="button" class="btn btn-danger insert">Legv</button>

</form>
</div>';
}

//------------------------------------------------UPDATE---------------------------------------------------//

if(isset($_POST['update']))
{
    $client_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['client_id']))));
    $product_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['product_id']))));
    $miqdar=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['miqdar']))));

    if(!empty($client_id) && !empty($product_id) && !empty($miqdar))
    {
        $updating=mysqli_query($con,"UPDATE orders SET

                               client_id='".$client_id."',
                               product_id='".$product_id."',
                               miqdar='".$miqdar."'

                               WHERE id='".$_POST['id']."'");

        if($updating==true)
            {echo'<div class="alert alert-success" id="ugurupdate" role="alert">Sifarishler ugurla yenilendi !</div>';}
        else
            {echo'<div class="alert alert-danger" role="alert">Sifarishleri yenilemek mumkun olmadi !</div>';}
}

else
{echo'<div class="alert alert-warning" role="alert">Bosh xanalari doldurun !</div>';}

}

if(!isset($_POST['edit']) && !isset($_POST['edit_id']))
{
    echo'
    <div class="alert alert-secondary" role="alert">
    <form method="post" enctype="multipart/form-data" id="orders_insert">
    Musteri:<br>
    <select name="client_id" class="form-control"><br>
    <option value="">Musterini secin</option>';

    $dsec = mysqli_query($con,"SELECT * FROM clients WHERE user_id='".$_SESSION['user_id']."' ORDER BY ad ASC");
    while($dinfo = mysqli_fetch_array($dsec))
        {echo'<option value="'.$dinfo['id'].'">'.$dinfo['ad'].' '.$dinfo['soyad'].'</option><br>';}
echo'
</select>
<br>
<form method="post">
    Mehsul:<br>
    <select name="product_id" class="form-control">
    <option value="">Brend secin</option><br>';

   $bsec=mysqli_query($con,"SELECT 
                      brands.brend,
                      products.id,
                      products.mehsul,
                      products.miqdar
                      FROM brands,products
                      WHERE brands.id=products.brand_id AND products.user_id='".$_SESSION['user_id']."'
                      ORDER BY products.id DESC");

   while($binfo=mysqli_fetch_array($bsec))
    {echo'<option value="'.$binfo['id'].'">'.$binfo['brend'].' '.$binfo['mehsul'].' ['.$binfo['miqdar'].']</option>';}
    
    echo'
    </select>
    <br>
    Miqdar:<br>
    <input type="text" name="miqdar" class="form-control"><br>
    <input type="hidden" name="insert">
    <button type="button" class="btn btn-dark insert">Daxil</button>
  </form>
</div>';    
}

//-----------------------------------------------INSERT--------------------------------------------//

if(isset($_POST['insert']))
{
    $client_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['client_id']))));
    $product_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['product_id']))));
    $miqdar=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['miqdar']))));

    if(!empty($client_id) && !empty($product_id) && !empty($miqdar))
    {
                        $daxiliy=mysqli_query($con,"INSERT INTO orders(client_id,product_id,miqdar,user_id) 
                        VALUES('".$client_id."','".$product_id."','".$miqdar."','".$_SESSION['user_id']."')");

        if($daxiliy==true)
        {echo'<div class="alert alert-success" id="ugurgir" role="alert">Melumatlar qeyde alindi !</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar qeyde alinmadi !</div>';}
}

else
{echo'<div class="alert alert-warning" role="alert">Bos xanalari doldurun !</div>';}

}

if(isset($_POST['ordersil']))
{
    $silmeli=mysqli_query($con,"DELETE FROM orders WHERE id='".$_POST['ordersil']."' ");

    if($silmeli==true)
    {echo'<div class="alert alert-success" id="ugursil" role="alert">Melumatlar ugurla silindi !</div>';}
    else
    {echo'<div class="alert alert-danger" role="alert">Melumatlar silinmedi !</div>';}
}

   $input=$_POST['input'];

$selecting=mysqli_query($con,"SELECT 
    orders.id,
    orders.miqdar AS sifaris, 
    orders.tarix,
    brands.brend,
    clients.ad,
    clients.soyad,
    products.mehsul,
    products.alish,
    products.satish,
    orders.tesdiq,
    products.miqdar AS stok
    FROM users,brands,products,clients,orders
    WHERE
    (products.mehsul LIKE '%{$input}%' OR clients.ad LIKE '%{$input}%') AND
    brands.id=products.brand_id AND 
    products.id=orders.product_id AND 
    clients.id=orders.client_id AND 
    users.id=orders.user_id AND 
    users.id='".$_SESSION['user_id']."' ".$order." ");

$count=mysqli_num_rows($selecting);

$i=0;

if($count!=0)
{echo'<div class="alert alert-warning" role="alert">Anbarda <b>'.$count.'</b> brend var.</div>';}

echo'<form method="post">';

echo'<div class="table-dark">
    <table class="table table-bordered table-dark">
       <thead class="thead-dark">

        <th>#</th>
        <th>Musteri '.$f1.'</th>
        <th>Mehsul '.$f2.'</th>
        <th>Brand</th>
        <th>Alish</th>
        <th>Satish</th>
        <th>Stok</th>
        <th>Sifarish</th>
        <th>Qazanc</th>
        <th>Tarix '.$f3.'</th>
        <th><button type="submit" name="secsil" class="btn btn-danger btn-sm">Secimleri sil</button></th>       
       

        </thead><tbody>';


while($info=mysqli_fetch_array($selecting)) 
{
    $i++;

    $qazanc=($info['satish']-$info['alish'])*$info['sifaris'];

    echo'<tr>';
    echo'<td>'.$i.' <input type="checkbox" name="secim[]" value="'.$info['id'].'"></td>';
    echo'<td>'.$info['ad'].' '.$info['soyad'].'</td>';
    echo'<td>'.$info['mehsul'].'</td>';
    echo'<td>'.$info['brend'].'</td>';
    echo'<td>'.$info['alish'].'</td>';
    echo'<td>'.$info['satish'].'</td>';
    echo'<td>'.$info['stok'].'</td>';
    echo'<td>'.$info['sifaris'].'</td>';
    echo'<td>'.$qazanc.'</td>';
    echo'<td>'.$info['tarix'].'</td>';

    echo'
    <td>
    <form method="post">

    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="pid" value="'.$info['product_id'].'">
    <input type="hidden" name="pmiq" value="'.$info['stok'].'">
    <input type="hidden" name="smiq" value="'.$info['sifaris'].'">';


if($info['tesdiq']==0)
    {
        echo'
      <button type="button" name="sil" title="Sil" class="btn btn-danger btn-sm sil" id="'.$info['id'].'"><i class="bi bi-x"></i></button>
      <button type="button" name="edit" title="Redakte" class="btn btn-warning btn-sm edit" id="'.$info['id'].'" ><i class="bi bi-pen"></i></button>
      <button type="submit" name="tesdiq" title="Tesdiq etme" class="btn btn-success btn-sm"><i class="bi bi-check"></i></button>';
    }
      else
     {echo'<button type="submit" name="legv" title="Legv etme" class="btn btn-danger btn-sm"><i class="bi bi-x"></i></button>';}

echo'
    </form>
    </td></tr>';

}

echo'</tbody></table>';

}

//--------------------------------------PROFILE AJAX --------------------------------------//

?>

<?php

if($_GET['pro']=='profile')
{

if(isset($_POST['update']))
{
    $ad = mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['ad']))));
    $soyad = mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['soyad']))));
    $telefon = mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['telefon']))));
    $email = mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['email']))));
    $parol = mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim(sha1($_POST['parol'])))));

   if($parol==$_SESSION['parol'] OR $parol==' '){

    if($_POST['yparol']==$_POST['tparol']){

    $yoxla=mysqli_query($con,"SELECT * FROM users WHERE (telefon='".$_SESSION['telefon']."' AND id = '".$_POST['id']."' AND id != '".$_SESSION['user_id']."' OR email='".$_SESSION['email']."') AND id = '".$_POST['id']."' AND id != '".$_SESSION['user_id']."' ");
    $say=mysqli_num_rows($yoxla);

    if($say==0){

    if(empty($_POST['yparol']))
      {$parol=$_SESSION['parol'];}
    else
    {$parol = mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim(sha1($_POST['yparol'])))));}

  if(!empty($ad) && !empty($soyad) && !empty($telefon) && !empty($email) && !empty($parol))
    {
      if($_FILES['foto']['size']<1024)
      {$unvan=$_SESSION['foto'];}
       else
      {include"upload.php";}

      if(!isset($error)){

        $yenile=mysqli_query($con,"UPDATE users SET
         foto='".$unvan."', 
         ad='".$ad."',
         soyad='".$soyad."',
         telefon='".$telefon."',
         email='".$email."',
         parol='".$parol."'
         WHERE id='".$_SESSION['user_id']."' ");

          if($yenile==true){

             echo'<div class="alert alert-success" id="ugurupdate" role="alert">Melumat ugurla yenilendi.</div>';

             $_SESSION['foto'] = $unvan;
             $_SESSION['ad'] = $ad;
             $_SESSION['soyad'] = $soyad;
             $_SESSION['telefon'] = $telefon;       
             $_SESSION['email'] = $email;
             $_SESSION['parol'] = $parol;
          
             echo'<meta http-equiv="refresh" content="0; URL=profile.php">';
           }

            else
            {echo'<div class="alert alert-warning" role="alert">Qeydiyyati yenilemek mumkun olmadi.</div>';}
        }
    }
     else
      {echo'<div class="alert alert-warning" role="alert">Melumati tam doldurun!</div>';}
}
else
    {echo'<div class="alert alert-warning" role="alert">Bu istifadəçi artiq movcuddur !</div>';}

}
  else
        {echo'<div class="alert alert-warning" role="alert">Yeni parol tekrar parolla eyni deyil !</div>';}
  }
    else
      {echo'<div class="alert alert-warning" role="alert">Hal-hazirki parol yalnisdir!</div>';}
} 
 
echo'
<div class="alert alert-dark" role="alert">
    <form method = "post" enctype="multipart/form-data" id="profile_update">
    <div class="input-group">
    <span class="input-group-text"><i class="" style="font-size:30px"></i>
    <img style="width:95px" src="'.$_SESSION['foto'].'"></span>
    <input type="file" class="form-control" name="foto">
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-person-circle" style="font-size:30px"></i></span><br>
    <input type="text" class="form-control" name="ad" value="'.$_SESSION['ad'].'" autocomplete="off"><br>
    <input type="text" class="form-control" name="soyad" value="'.$_SESSION['soyad'].'" autocomplete="off"><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-telephone-fill" style="font-size:30px"></i></span>
    <input type="text" class="form-control" name="telefon" value="'.$_SESSION['telefon'].'" autocomplet="off"><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-envelope-fill" style="font-size:30px"></i></span>
    <input type="email" class="form-control" name="email" value="'.$_SESSION['email'].'" autocomplete="off"><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-file-lock2-fill" style="font-size:30px"></i></span>
    <input type="password" class="form-control" name="parol" autocomplete="off" required><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-key-fill" style="font-size:30px"></i></span>
    <input type="password" class="form-control" name="yparol" autocomplete="off"><br>
    </div><br>
    <div class="input-group">
    <span class="input-group-text"><i class="bi bi-key-fill" style="font-size:30px"></i></span>
    <input type="password" class="form-control" name="tparol" autocomplete="off"><br>
    </div><br>
    <input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'">
    <input type="hidden" name="update">
    <button type="button" class="btn btn-success btn-sm update"><b>Yenile</b></button>
</form>';

echo'</div>';

}

//--------------------------------------ADMIN AJAX --------------------------------------//

?>

<?php 

if($_GET['a']=='admin')
{

if($_POST['f1']=='ASC' )
{$order = ' ORDER BY ad ASC'; $f1 = '<button type="button" class="btn btn-light f1" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f1']=='DESC' )
{$order = ' ORDER BY ad DESC'; $f1 = '<button type="button" class="btn btn-light f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f1 = '<button type="button" class="btn btn-light f1" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if($_POST['f2']=='ASC' )
{$order = ' ORDER BY tarix ASC'; $f2 = '<button type="button" class="btn btn-light f2" id="DESC"><i class="bi bi-sort-alpha-down-alt"></i></button>';}

elseif($_POST['f2']=='DESC' )
{$order = ' ORDER BY tarix DESC'; $f2 = '<button type="button" class="btn btn-light f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

else
{$f2 = '<button type="button" class="btn btn-light f2" id="ASC"><i class="bi bi-sort-alpha-down"></i></button>';}

if(!isset($_POST['f1']) && !isset($_POST['f2']))
{$order = ' ORDER BY id DESC';}


if(isset($_POST['secsil']) && count($_POST['secim'])>0)
{
    for($i=0; $i<count($_POST['secim']); $i++)
    {
        $sil=mysqli_query($con,"DELETE FROM users WHERE id='".$_POST['secim'][$i]."'");
    }
    if($sil==true)
    {echo'<div class="alert alert-success" role="alert">Seçilmiş məlumatlar uğurla silindi</div>';}
    else
    {echo'<div class="alert alert-success" role="alert">Seçilmiş məlumatlar silmək mümkün olmadı</div>';}

}

if(isset($_POST['edit_id']))
{
    $edit_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['edit_id']))));

    $sech=mysqli_query($con,"SELECT * FROM users WHERE id='".$edit_id."'");
    $info=mysqli_fetch_array($sech);
    echo'<div class="alert alert-secondary" role="alert">
    <form method="post" enctype="multipart/form-data" id="admin_update">
    Ad:<br>
    <input required type="text" name="ad" value="'.$info['ad'].'" class="form-control"><br>
    Soyad:<br>
    <input required type="text" name="soyad" value="'.$info['soyad'].'" class="form-control"><br>
    Telefon:<br>
    <input required type="text" name="telefon" value="'.$info['telefon'].'" class="form-control"><br>
    Email:<br>
    <input required type="email" name="email" value="'.$info['email'].'" class="form-control"><br>
    Parol:<br>
    <input required type="password" name="parol" value="'.$info['parol'].'" class="form-control"><br>
    Təkrar parol:<br>
    <input required type="password" name="tekrar_parol" value="'.$info['tekrar_parol'].'" class="form-control"><br>
    <input type="hidden" name="id" value="'.$_POST['id'].'">
    <input type="hidden" name="update">
    <button type="button" class="btn btn-primary update">Yenilə</button>&nbsp;
    <button type="button" class="btn btn-danger d">Legv et</button>
</form>
</div>';
}

if(isset($_POST['update']))
{
  if($_POST['parol']==$_POST['tekrar_parol'])
  {
      $ad = mysqli_real_escape_string($con,strip_tags(trim($_POST['ad'])));
      $soyad = mysqli_real_escape_string($con,strip_tags(trim($_POST['soyad'])));
      $telefon = mysqli_real_escape_string($con,strip_tags(trim($_POST['telefon'])));
      $email = mysqli_real_escape_string($con,strip_tags(trim($_POST['email'])));
      $parol = mysqli_real_escape_string($con,strip_tags(trim($_POST['parol'])));

      $yoxla=mysqli_query($con,"SELECT * FROM users WHERE email='".$email."' OR telefon='".$telefon."'");
      
      if(mysqli_num_rows($yoxla)==0)
    {
    
    $yenile=mysqli_query($con,"UPDATE users SET 
    ad='".$ad."',
    soyad='".$soyad."',
    telefon='".$telefon."',
    email='".$email."',
    parol='".$parol."'
    
    WHERE id='".$_POST['id']."' ");
    
if($yenile==true)
    {echo '<div class="alert alert-primary" role="alert">Məlumatlar uğurla yeniləndi!</div>';}
else
    {echo '<div class="alert alert-danger" role="alert">Məlumatlar yenilemek mümkün olmadı!</div>';}
    }
   else
   {echo '<div class="alert alert-danger" role="alert">Bu email və ya telefon mövcuddur!</div>';}
}
  else
  {echo '<div class="alert alert-danger" role="alert">Parollar üst-üstə düşmür!</div>';}
}

if(isset($_POST['sil_id']))
{
    $sil=mysqli_query($con,"DELETE FROM users WHERE id='".$_POST['sil_id']."'");
    if($sil==true)
        {echo'<div class="alert alert-success" role="alert">Məlumatlar uğurla silindi!</div>';}
    else
        {echo'<div class="alert alert-danger" role="alert">Məlumatlar silinmədi!</div>';}
}

if(isset($_POST['d']))
{
    if($_POST['parol']==$_POST['tekrar_parol'])
    {
            $ad = mysqli_real_escape_string($con,strip_tags(trim($_POST['ad'])));
            $soyad = mysqli_real_escape_string($con,strip_tags(trim($_POST['soyad'])));
            $telefon = mysqli_real_escape_string($con,strip_tags(trim($_POST['telefon'])));
            $email = mysqli_real_escape_string($con,strip_tags(trim($_POST['email'])));
            $parol = mysqli_real_escape_string($con,strip_tags(trim($_POST['parol'])));

        if (!empty($ad) && !empty($soyad) && !empty($telefon) && !empty($email) && !empty($parol))
          {
            $yoxla=mysqli_query($con,"SELECT * FROM users WHERE email='".$email."' OR telefon='".$telefon."'");
            
            if(mysqli_num_rows($yoxla)==0)
            {                
                $insert=mysqli_query($con,"INSERT INTO users(ad,soyad,telefon,email,parol)
                VALUES('".$ad."','".$soyad."','".$telefon."','".$email."','".$parol."')");
                
                if($insert==true)
                 {echo '<div class="alert alert-primary" role="alert">Istifadəçi bazaya daxil edildi!</div>';}
                else
                 {echo '<div class="alert alert-danger" role="alert">Istifadəçini bazaya daxil etmək mümkün olmadı!</div>';}
             } 
            
         else
            {echo '<div class="alert alert-danger" role="alert">Bu email və ya telefon mövcüddur</div>';}
          
          }
         else
          {echo '<div class="alert alert-danger" role="alert">Zəhmət olmasa məlumatları doldurun!</div>';}
    }
    else
    {echo '<div class="alert alert-danger" role="alert">Parollar üst-üste düşmür</div>';}
}

if(!isset($_POST['edit']) && !isset($_POST['edit_id']))
{
echo'
<div class="alert alert-secondary" role="alert">
<form method="post" enctype="multipart/form-data" id="admin_insert">
    Ad:<br>
    <input required type="text" name="ad" class="form-control"><br>
    Soyad:<br>
    <input required type="text" name="soyad" class="form-control"><br>
    Telefon:<br>
    <input required type="text" name="telefon" class="form-control"><br>
    Email:<br>
    <input required type="email" name="email" class="form-control"><br>
    Parol:<br>
    <input required type="password" name="parol" class="form-control"><br>
    Təkrar parol:<br>
    <input required type="password" name="tekrar_parol" class="form-control"><br>
    <input type="hidden" name="d">
    <button type="button" class="btn btn-dark d">Daxil et</button>
</form>
</div>';
}

echo'<form method="post">
<table class="table table-hover table-dark">
             <thead class="thead-dark">

          <th>#</th>
          <th>Istifadəçi '.$f1.'</th>
          <th>Telefon</th>
          <th>Email</th>
          <th>Tarix '.$f2.'</th>
          <th><button class="btn btn-danger btn-sm" name="secsil">Seçilmişləri sil</button></th>
          </thead>
        
          <tbody>';

$sec=mysqli_query($con,"SELECT * FROM users WHERE id != '".$_SESSION['user_id']."' ".$order);

$say=mysqli_num_rows($sec);
echo'<div class="alert alert-warning" role="alert"><b>Istifadəçilərin sayi:</b> '.$say.'</div>';

$i=0;
while($info=mysqli_fetch_array($sec))
{
    $i++;
    echo'<tr>';
    echo'<td><input type="checkbox" name="secim[]" value="'.$info['id'].'"> '.$i.'</td>';
    echo'<td>'.$info['ad'].' '.$info['soyad'].'</td>';
    echo'<td>'.$info['telefon'].'</td>';
    echo'<td>'.$info['email'].'</td>';
    echo'<td>'.$info['tarix'].'</td>';
    echo'
    <td>
    <form method="post">
    <input type="hidden" name="id" value="'.$info['id'].'">';

        if($info['blok']==0)
    {
        echo'
    <button type="button" name="edit" class="btn btn-warning edit" id="'.$info['id'].'"><i class="bi bi-pencil"></i></button>
    <button type="button" name="sil"  class="btn btn-danger sil" id="'.$info['id'].'"><i class="bi bi-trash"></i></button>
    <button type="submit" name="blok"  class="btn btn-success"><i class="bi bi-check2"></i></button>';
     }
     else
    {echo'<button type="submit" name="levg" class="btn btn-danger"><i class="bi bi-x-octagon"></i></button>';}
    echo'
    </form>
    </td>
    </tr>';

}
echo'</tbody>     
    </table>';  

}

?>
