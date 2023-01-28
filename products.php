<?php
include"header.php";

echo'<div class="container">';

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
			url:'loader.php?p=products',
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
            url:'loader.php?p=products',
            data:{edit_id:id},
            success:function(response){
                $('#result').html(response)
            }
        })
    
})

$(document).on('click','.update',function(){
        let form = $('#products_update')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?p=products",
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
        let form = $('#products_insert')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?p=products",
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
	if(confirm('Melumati silmeye eminsinizmi ?')){

		$('#result').html('<br><br><br><img style="width: 450px; height:450px;" class="rounded mx-auto d-block" src="images/s.gif">')

		$.ajax({
			method:'POST',
			url:'loader.php?p=products',
			data:{productsil:id},
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
	url:'loader.php?p=products',
	dataType:'html',
	success:function(response){
		$('#result').html(response)
	}

})

$(document).on('click','.f1',function(){

let id = $(this).attr('id')

$.ajax({
	method:'POST',
	url:'loader.php?p=products',
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
url:'loader.php?p=products',
data:{f2:id},
success:function(response){
	$('#result').html(response)
}
})

})

</script>