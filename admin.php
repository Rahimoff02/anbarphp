<?php
include"header.php";

if($_SESSION['user_id']!=44)
  {echo'<meta http-equiv="refresh" content="0; URL=brands.php">'; exit; }

echo'<div class="container">';

if(isset($_POST['blok']))
{
    $blok=mysqli_query($con,"UPDATE users SET blok=1 WHERE id='".$_POST['id']."'");
    
    if($blok==true)
        {echo'<div class="alert alert-success" role="alert">Istifadəçi bloklandı</div>';}
    else
        {echo'<div class="alert alert-danger" role="alert">Istifadəçi bloklanmadi</div>';}  
}
if(isset($_POST['levg']))
{
    
    $blok=mysqli_query($con,"UPDATE users SET blok=0 WHERE id='".$_POST['id']."'");
    if($blok==true)
         {echo'<div class="alert alert-success" role="alert">Istifadəçi bloku ləvğ edildi</div>';}
    else
         {echo'<div class="alert alert-danger" role="alert">Istifadəçi bloku ləvğ edilmedi</div>';}    
 
}


?>

<div id="result"><br><br><br><br><br><img style="width: 300px; height:300px;" class="rounded mx-auto d-block" src="images/s.gif"></div>

</div>

<script>

$(document).on('click','.edit',function(){

	let id = $(this).attr('id')

		  $.ajax({
			method:'POST',
			url:'loader.php?a=admin',
			data:{edit_id:id},
			success:function(response){
				$('#result').html(response)
			}
		})	
})

$(document).on('click','.update',function(){
        let form = $('#admin_update')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?a=admin",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                $('#result').html(response)
            },
        })
    })

$(document).on('click','.d',function(){
        let form = $('#admin_insert')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?a=admin",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                $('#result').html(response)
            },
        })
    })

	$(document).on('click', '.sil', function () {
		let id = $(this).attr('id')
		if (confirm('Melumati silmeye eminsinizmi ?')) {

			$('#result').html(
				'<br><br><br><img style="width: 450px; height:450px;" class="rounded mx-auto d-block" src="s.gif">'
				)

			$.ajax({
				method: 'POST',
				url: 'loader.php?a=admin',
				data: {sil_id:id},
				success: function (response) {
					$('#result').html(response)
				}
			})
		}
	})

	$.ajax({

		type: 'GET',
		url: 'loader.php?a=admin',
		dataType: 'html',
		success: function (response) {
			$('#result').html(response)
		}

	})

	$(document).on('click','.f1',function(){

    let id = $(this).attr('id')

	$.ajax({
		method:'POST',
		url:'loader.php?a=admin',
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
	url:'loader.php?a=admin',
	data:{f2:id},
	success:function(response){
		$('#result').html(response)
	}
})

})


</script>