<?php
include"header.php";

echo'<div class="container">';

// ________________________________________Buttons_TESDIQ-LEGV__________________________________//

if(isset($_POST['tesdiq']))
{
	if($_POST['smiq']<=$_POST['pmiq'])
	{
     $p_tesdiq=mysqli_query($con,"UPDATE products SET miqdar=miqdar-".$_POST['smiq']." WHERE id='".$_POST['pid']."'");

     if($p_tesdiq==true)
     {
     	    $s_tesdiq=mysqli_query($con,"UPDATE orders SET tesdiq=1 WHERE id='".$_POST['id']."'");

     	 if($s_tesdiq==true)
     	 {echo'<div class="alert alert-success" role="alert">Sifarishiniz ugurla tesdiqlendi.</div>';}

     	 else
       {

  	     	echo'<div class="alert alert-warning" role="alert">Sifarishinizi ugurla tesdiq etmek mumkun olmadi.</div>';
          $p_tesdiq=mysqli_query($con,"UPDATE products SET miqdar=miqdar+".$_POST['smiq']." WHERE id='".$_POST['pid']."' ");

             	  }
           }
    } 
    else
    {echo'<div class="alert alert-warning" role="alert">Sifarishinizi tesdiq ucun bazada kifayet qeder mehsul yoxdur.</div>';}
}

if(isset($_POST['legv']))
{
   $s_tesdiq=mysqli_query($con,"UPDATE orders SET tesdiq=0 WHERE id='".$_POST['id']."'");
   if($s_tesdiq==true)
   {
   	echo'<div class="alert alert-danger" role="alert">Sifarisi legv etdiniz.</div>';
   	$p_tesdiq=mysqli_query($con,"UPDATE products SET miqdar=miqdar+".$_POST['smiq']." WHERE id='".$_POST['pid']."' ");
   }
}

?>

<div id="result"><br><br><br><br><br><img style="width: 300px; height:300px;" class="rounded mx-auto d-block" src="images/s.gif"></div>

</div>

<script>


$(document).ready(function(){

    $("#search").keyup(function(){
        let input = $(this).val();

        if(input !=" "){
          $.ajax({
            method:'POST',
            url:'loader.php?o=orders',
            data:{input:input},
            success:function(response){
                $('#result').html(response)
                }
            });
        }
        
    });
});

$(document).on('click','.edit',function(){

    let id = $(this).attr('id')

          $.ajax({
            method:'POST',
            url:'loader.php?o=orders',
            data:{edit_id:id},
            success:function(response){
                $('#result').html(response)
            }
        })
    
})

$(document).on('click','.update',function(){
        let form = $('#orders_update')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            url: "loader.php?o=orders",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                $('#result').html(response)
                setTimeout(function(){
                  $("#ugurupdate").slideUp();
                },3000);
            },
        })
    })

$(document).on('click','.insert',function(){
        let form = $('#orders_insert')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            url: "loader.php?o=orders",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                $('#result').html(response)
                setTimeout(function(){
                  $("#ugurgir").slideUp();
                },3000);
            },
        })
    })

$(document).on('click','.sil',function(){
	let id = $(this).attr('id')
	if(confirm('Sifarishi silmeye eminsinizmi ?')){

		$('#result').html('<br><br><br><img style="width: 450px; height:450px;" class="rounded mx-auto d-block" src="images/s.gif">')

		$.ajax({
			method:'POST',
			url:'loader.php?o=orders',
			data:{ordersil:id},
			success:function(response){
				$('#result').html(response)
                setTimeout(function(){
                  $("#ugursil").slideUp();
                },3000);
			}
		})
	}
})

$.ajax({  

	type:'GET',
	url:'loader.php?o=orders',
	dataType:'html',
	success:function(response){
		$('#result').html(response)
	}

})

$(document).on('click','.f1',function(){

let id = $(this).attr('id')

$.ajax({
	method:'POST',
	url:'loader.php?o=orders',
	data:{f1:id},
	success:function(response){
		$('#result').html(response)
	}
})

})

$(document).on('click','.f2',function(){

let id = $(this).attr('id')

$.ajax({
method:'POST',
url:'loader.php?o=orders',
data:{f2:id},
success:function(response){
	$('#result').html(response)
}
})

})

$(document).on('click','.f3',function(){

let id = $(this).attr('id')

$.ajax({
method:'POST',
url:'loader.php?o=orders',
data:{f3:id},
success:function(response){
	$('#result').html(response)
}
})

})

</script>