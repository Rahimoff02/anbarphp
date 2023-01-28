<?php

include"header.php";

echo'<div class="container">';

if(isset($_POST['he']))
{
    $sil=mysqli_query($con,"DELETE FROM users WHERE id='".$_SESSION['user_id']."' ");
    $sil=mysqli_query($con,"DELETE FROM brands WHERE user_id='".$_SESSION['user_id']."' ");
    $sil=mysqli_query($con,"DELETE FROM clients WHERE user_id='".$_SESSION['user_id']."' ");
    $sil=mysqli_query($con,"DELETE FROM expense WHERE user_id='".$_SESSION['user_id']."' ");
    $sil=mysqli_query($con,"DELETE FROM products WHERE user_id='".$_SESSION['user_id']."' ");
    $sil=mysqli_query($con,"DELETE FROM orders WHERE user_id='".$_SESSION['user_id']."' ");
    $sil=mysqli_query($con,"DELETE FROM staff WHERE user_id='".$_SESSION['user_id']."' ");

    if($sil==true)
    {echo'<meta http-equiv="refresh" content="0; URL=exit.php">';}
    
}

echo'
<div class="card">
 <form method="post">
  <div class="card-body">
    <h5 class="card-title">Profilini yenile :)</h5>
    <p class="card-text">Profilinizi silmek istediyinizden emin olduqda "hesabimi sil" duymesine basa bilersiniz.</p>
     <input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'">
     <button type="submit" class="btn btn-outline-danger" name="bit">Hesabımı sil</button>
  </div>
 </form>
</div><br>';

if(isset($_POST['bit']))
{
echo '
<b>Profilinizi silmeye eminsinizmi ?</b>
 <form method="post">
 <button type="submit" name="he" class="btn btn-success">He</button>
 <button type="submit" name="yox" class="btn btn-secondary">Yox</button>
 <input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'">
</form>';
  
}

?>

<div id="result"><br><br><br><br><br><img style="width: 300px; height:300px;" class="rounded mx-auto d-block" src="images/s.gif"></div>

</div>

<script>

$(document).on('click','.update',function(){
        let form = $('#profile_update')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?pro=profile",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                $('#result').html(response)
                setTimeout(function(){
                  $("#ugurupdate").slideUp();
                },5000);
            },
        })
    })


$.ajax({  

  type:'GET',
  url:'loader.php?pro=profile',
  dataType:'html',
  success:function(response){
    $('#result').html(response)
  }

})
</script>