<?php 

include"header.php";

echo'<div class="container">';

if(isset($_POST['beli']) && count($_POST['secim'])>0)
{
    for($n=0;$n<count($_POST['secim']); $n++)
    {
        $sil=mysqli_query($con,"DELETE FROM staff WHERE id='".$_POST['secim'][$n]."'");
    }
    {echo'<div class="alert alert-danger" role="alert">Seçilmiş məlumatlar uğurla silindi.</div>';}
}


//---------------------------------------------------------//-----------------------------------------------------------//

if(!isset($_POST['sedit']) && !isset($_POST['tesdiq']) && !isset($_POST['edit']) && !isset($_POST['delete']) && !isset($_POST['update']))
{
    
echo'
<div class="alert alert-secondary" role="alert">
  <form method="post" enctype="multipart/form-data">
    Shekil:<br>
    <input type="file" name="foto" class="form-control"><br>
    Ad:<br>
    <input type="text" name="ad" class="form-control"><br>
    Soyad:<br>
    <input type="text" name="soyad" class="form-control"><br>
    Email:<br>
    <input type="text" name="email" class="form-control"><br>
    Telefon:<br>
    <input type="text" name="telefon" class="form-control"><br>
    Zaman:<br>
    <input type="date" name="hired" class="form-control"><br>
    Maash:<br>
    <input type="text" name="salary" class="form-control"><br>
    Ish:<br>
    <input type="text" name="job" class="form-control"><br>
    <button type="submit" class="btn btn-success" name="insert">Gir</button>
  </form>
</div>';    
}

//-----------------------------------------------INSERT--------------------------------------------//

if(isset($_POST['insert']))
{
    $ad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['ad']))));
    $soyad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['soyad']))));
    $email=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['email']))));
    $telefon=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['telefon']))));
    $hired=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['hired']))));
    $salary=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['salary']))));
    $job=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['job']))));

    if(!empty($ad) && !empty($soyad) && !empty($email) && !empty($telefon) && !empty($hired) && !empty($salary) && !empty($job))
    {
        $yoxla=mysqli_query($con,"SELECT * FROM staff WHERE email='".$email."' AND user_id='".$_SESSION['user_id']."' OR telefon='".$telefon."' AND user_id='".$_SESSION['user_id']."' ");

        if(mysqli_num_rows($yoxla)==0)
        {
            include"upload.php";
            if(!isset($error))
    {
        $inserting=mysqli_query($con,"INSERT INTO staff(ad,soyad,email,telefon,hired,salary,job,foto,user_id) 
         VALUES('".$ad."','".$soyad."','".$email."','".$telefon."','".$hired."','".$salary."','".$job."','".$unvan."','".$_SESSION['user_id']."')");
    }
        if($inserting==true)
        {echo'<div class="alert alert-success" id="ugurinsert" role="alert">Melumatlar qeyde alindi.</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar qeyde alinmadi.</div>';}
}
else
{
    {echo'<div class="alert alert-warning" role="alert">Melumatlar artiq movcuddur.</div>';}
}
    
}
else
{echo'<div class="alert" alert-warning" role="alert">Bos xanalari doldurun !</div>';}

}


//-------------------------------------------------EDIT------------------------------------------------//

if(isset($_POST['sedit']))
{
    $editing=mysqli_query($con,"SELECT * FROM staff WHERE id='".$_POST['id']."' ");
    $info=mysqli_fetch_array($editing);

    echo'<div class="alert alert-secondary" role="alert">
    <form method="post" enctype="multipart/form-data">
    Shekil:<br>
    <img style="width:75px; height:60px;" src="'.$info['foto'].'"><br>
    <input type="file"  name="foto" value="'.$info['foto'].'" class="form-control"><br>
    Ad:<br>
    <input type="text" name="ad" value="'.$info['ad'].'" class="form-control"><br>
    Soyad:<br>
    <input type="text" name="soyad" value="'.$info['soyad'].'" class="form-control"><br>
    Email:<br>
    <input type="text" name="email" value="'.$info['email'].'" class="form-control"><br>
    Telefon:<br>
    <input type="text" name="telefon" value="'.$info['telefon'].'" class="form-control"><br>
    Zaman:<br>
    <input type="date" name="hired" value="'.$info['hired'].'" class="form-control"><br>
    Maash:<br>
    <input type="text" name="salary" value="'.$info['salary'].'" class="form-control"><br>
    Ish:<br>
    <input type="text" name="job" value="'.$info['job'].'" class="form-control"><br>
    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="lid" value="'.$info['foto'].'">
    <button type="submit" class="btn btn-success" name="supdate">Yenile</button>
</form>
</div>';
}

if(isset($_POST['supdate']))
{
        $ad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['ad']))));
        $soyad=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['soyad']))));
        $telefon=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['telefon']))));
        $email=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['email']))));
        $hired=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['hired']))));
        $salary=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['salary']))));
        $job=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['job']))));

        if(!empty($ad) && !empty($soyad) && !empty($telefon) && !empty($email) && !empty($hired) && !empty($salary) && !empty($job))
         {
             
          $unikal=mysqli_query($con,"SELECT * FROM staff WHERE telefon='".$telefon."' AND id !='".$_POST['id']."' AND user_id='".$_SESSION['user_id']."' OR email='".$email."' AND id !='".$_POST['id']."' AND user_id='".$_SESSION['user_id']."' ");
    
          $sayisi=mysqli_num_rows($unikal);
          
          if($sayisi==0){
               
        if($_FILES['foto']['size']<1024)
        {$unvan = $_POST['lid'];}
         else
        {include "upload.php";}
         if(!isset($error))
         {
                $update=mysqli_query($con,"UPDATE staff SET 
                                              foto='".$unvan."',
                                              ad='".$ad."',
                                              soyad='".$soyad."',
                                              telefon='".$telefon."',
                                              email='".$email."',
                                              hired='".$hired."',
                                              salary='".$salary."',
                                              job='".$job."'
                                              
                                              WHERE id='".$_POST['id']."' ");

      if($update==true)
      {echo'<div class="alert alert-success" role="alert">Melumatlar ugurla yenilendi.</div>';}
      else
      {echo'<div class="alert alert-danger" role="alert">Melumatlari yenilemek mumkun olmadi.</div>';}
}

}
else
    {echo'<div class="alert alert-danger" role="alert">Eyni nomre veya email bazaya otura bilmez.</div>';}
}
  else
  {echo'<div class="alert alert-warning" role="alert">Bosh xanalari doldurun !</div>';}

}

if(isset($_POST['sdelete']))
{
  echo '<b>Melumati silmeye eminsinizmi ?</b>
 <form method="post">
 <button type="submit" name="he" class="btn btn-success btn-sm">He</button>
 <button type="submit" name="yox" class="btn btn-secondary btn-sm">Yox</button>
 <input type="hidden" name="id" value="'.$_POST['id'].'">
 </form>';
  
}

if(isset($_POST['he']))
{
        $deleting=mysqli_query($con,"DELETE FROM staff WHERE id='".$_POST['id']."' ");

        $deleting=mysqli_query($con,"DELETE FROM doc WHERE emp_id='".$_POST['id']."' ");
    
        if($deleting==true)
        {echo'<div class="alert alert-success" role="alert">Melumatlar ugurla silindi.</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar silinmedi.</div>';}
}

if(!isset($_POST['tesdiq']) && !isset($_POST['edit']) && !isset($_POST['update']))
{
    $selecting=mysqli_query($con,"SELECT * FROM staff WHERE user_id='".$_SESSION['user_id']."' ");

$count=mysqli_num_rows($selecting);

$i=0;

if($count!=0)
{echo'<div class="alert alert-warning" role="alert">Anbarda <b>'.$count.'</b> brend var.</div>';}

echo '<form method="post">';

echo'<div class="table-dark">
    <table class="table table-hover table-dark">
       <thead class="thead-dark">
    
    <th>#</th>
    <th>Shekil</th>
    <th>Ad</th>
    <th>Soyad</th>
    <th>Email</th>
    <th>Telefon</th>
    <th>Zaman</th>
    <th>Maash</th>
    <th>Ish</th>
    <th>Tarix</th>
    <th><button type="submit" name="secsil" class="btn btn-danger btn-sm">Secimleri sil</button></th>
   
    </thead>

    <tbody> ';

while($info=mysqli_fetch_array($selecting)) 
{
    $i++;
    
    echo'<tr>';
    echo'<td>'.$i.' <input type="checkbox" name="secim[]" value="'.$info['id'].'"></td>';
    echo'<td><img style="width:75px; height:60px;" src="'.$info['foto'].'"></td>';
    echo'<td>'.$info['ad'].'</td>';
    echo'<td>'.$info['soyad'].'</td>';
    echo'<td>'.$info['email'].'</td>';
    echo'<td>'.$info['telefon'].'</td>';
    echo'<td>'.$info['hired'].'</td>';
    echo'<td>'.$info['salary'].'</td>';
    echo'<td>'.$info['job'].'</td>';
    echo'<td>'.$info['tarix'].'</td>';

    echo'
    <td>
    <form method="post">
    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="lid" value="'.$info['foto'].'">
    <button type="submit" name="sedit" class="btn btn-warning"><i class="bi bi-pencil"></i></button>
    <button type="submit" name="sdelete" class="btn btn-danger"><i class="bi bi-trash"></i></button>
    <button type="submit" name="tesdiq" class="btn btn-success"><i class="bi bi-check"></i></button>

    </form>
    </td></tr>';

}

echo'</tbody></table></div>';

}


//-------------------------------------------------------------------------------

if(isset($_POST['edit']))
{
    $select=mysqli_query($con,"SELECT * FROM doc WHERE id='".$_POST['id']."' AND user_id='".$_SESSION['user_id']."' ");
    
    $info=mysqli_fetch_array($select);
    
    echo'
    <div class="alert alert-secondary" role="alert">
    <form method="post" enctype="multipart/form-data">
    Shekil:<br>
    <input type="file" name="foto" class="form-control" value="'.$info['foto'].'"><br>
    Title:<br>
    <input type="text" name="title" class="form-control" value="'.$info['title'].'"><br>
    About:<br>
    <input type="text" name="about" class="form-control" value="'.$info['about'].'"><br>
    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="lid" value="'.$info['foto'].'">
    <button type="submit" name="update" class="btn btn-success">Yenile</button>
    <button type="submit" class="btn btn-secondary">Imtina</button>
    </form>
    </div>';    
}

if(!isset($_POST['edit']) && isset($_POST['tesdiq']) or isset($_POST['update']))
{
    echo'
    <div class="alert alert-secondary" role="alert">
    <form method="post" enctype="multipart/form-data">
    Shekil:<br>
    <input type="file" name="foto" class="form-control"><br>
    Title:<br>
    <input type="text" name="title" class="form-control"><br>
    About:<br>
    <input type="text" name="about" class="form-control"><br>
    <input type="hidden" name="id" value="'.$_POST['id'].'">
    <button type="submit" name="daxil" class="btn btn-dark">Gir</button>
    </form>
    </div>';    
}

if(isset($_POST['delete']))
{
        $deleting=mysqli_query($con,"DELETE FROM doc WHERE id='".$_POST['id']."' ");
    
        if($deleting==true)
        {echo'<div class="alert alert-success" role="alert">Melumatlar ugurla silindi.</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar silinmedi.</div>';}
}

if(isset($_POST['update']))
{
        $title=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['title']))));
        $about=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['about']))));

        if(!empty($title) && !empty($about))
         {
         
        if($_FILES['foto']['size']<1024)
        {$unvan = $_POST['lid'];}
         else
        {include "upload.php";}
         if(!isset($error))
         {
                $update=mysqli_query($con,"UPDATE doc SET 
                                              foto='".$unvan."',
                                              title='".$title."',
                                              about='".$about."'
                                               
                                              WHERE id='".$_POST['id']."' ");

      if($update==true)
      {echo'<div class="alert alert-success" role="alert">Melumatlar ugurla yenilendi.</div>';}
      else
      {echo'<div class="alert alert-danger" role="alert">Melumatlari yenilemek mumkun olmadi.</div>';}
}

}
  else
  {echo'<div class="alert alert-warning" role="alert">Bosh xanalari doldurun !</div>';}

}

if(isset($_POST['daxil']))
{
    $title=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['title']))));
    $about=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['about']))));
    $emp_id=mysqli_real_escape_string($con,htmlspecialchars(strip_tags(trim($_POST['emp_id']))));


    if(!empty($title) && !empty($about))
    {
    include"upload.php";
    if(!isset($error))
    {
        $inserting=mysqli_query($con,"INSERT INTO doc(title,about,foto,emp_id,user_id) 
                               VALUES('".$title."','".$about."','".$unvan."','".$_POST['id']."','".$_SESSION['user_id']."')");
    }
        if($inserting==true)
        {echo'<div class="alert alert-success" role="alert">Melumatlar qeyde alindi.</div>';}
        else
        {echo'<div class="alert alert-danger" role="alert">Melumatlar qeyde alinmadi.</div>';}
}
else
    {echo'<div class="alert alert-danger" role="alert">Melumatlar bosh ola bilmez.</div>';}
}

if(isset($_POST['tesdiq']) or isset($_POST['edit']) or isset($_POST['update']))
{
    $selecting=mysqli_query($con,"SELECT * FROM doc WHERE emp_id = '".$_POST['id']."' AND user_id = '".$_SESSION['user_id']."' ");

$count=mysqli_num_rows($selecting);

$i=0;

if($count!=0)
{echo'<div class="alert alert-warning" role="alert">Anbarda <b>'.$count.'</b> brend var.</div>';}

echo '<form method="post">';

echo'<div class="table-dark">
    <table class="table table-hover table-dark">
       <thead class="thead-dark">
    
    <th>#</th>
    <th>Shekil</th>
    <th>Title</th>
    <th>About</th>
    <th>Tarix</th>
    <th><button type="submit" name="secsil" class="btn btn-danger btn-sm">Secimleri sil</button></th>
   
    </thead>

    <tbody> ';

while($info=mysqli_fetch_array($selecting)) 
{
    $i++;
    
    echo'<tr>';
    echo'<td>'.$i.' <input type="checkbox" name="secim[]" value="'.$info['id'].'"></td>';
    echo'<td><img style="width:75px; height:60px;" src="'.$info['foto'].'"></td>';
    echo'<td>'.$info['title'].'</td>';
    echo'<td>'.$info['about'].'</td>';
    echo'<td>'.$info['tarix'].'</td>';

    echo'
    <td>
    <form method="post">
    <input type="hidden" name="id" value="'.$info['id'].'">
    <input type="hidden" name="lid" value="'.$info['foto'].'">
    <button type="submit" name="edit" class="btn btn-warning"><i class="bi bi-pencil"></i></button>
    <button type="submit" name="delete" class="btn btn-danger"><i class="bi bi-trash"></i></button>

    </form>
    </td></tr></div>';
}

}

?>
