<?php
include"header.php";

echo'<div class="container">'; 

?>

<div id="result"><br><br><br><br><br><img style="width: 300px; height:300px;" class="rounded mx-auto d-block" src="images/s.gif"></div>

</div>

<script>

$(document).on('click','.secsil',function(){
        let form = $('#main_form')[0]
        let data = new FormData(form)

        if (confirm('Mushterileri silmeye eminsinizmi ?')) {
        $('#result').html(
				'<br><br><br><img style="width: 450px; height:450px;" class="rounded mx-auto d-block" src="images/s.gif">'
				)
     
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?c=clients",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                $('#result').html(response)
            },
        })
       }
    })

$(document).ready(function(){

	$("#search").keyup(function(){
		let input = $(this).val();

        if(input !=" "){
		  $.ajax({
			method:'POST',
			url:'loader.php?c=clients',
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
			url:'loader.php?c=clients',
			data:{edit_id:id},
			success:function(response){
				$('#result').html(response)
			}
		})
	
})

$(document).on('click','.update',function(){
        let form = $('#clients_update')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?c=clients",
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

$(document).on('click','.daxil',function(){
        let form = $('#clients_insert')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?c=clients",
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
	if(confirm('Mushterini silmeye eminsinizmi ?')){

		$('#result').html('<br><br><br><img style="width: 450px; height:450px;" class="rounded mx-auto d-block" src="images/s.gif">')

		$.ajax({
			method:'POST',
			url:'loader.php?c=clients',
			data:{clientsil:id},
			success:function(response){
				$('#result').html(response)
				setTimeout(function(){
                  $("#ugursil").slideUp();
                },3000);
			}
		})
	}
})

$(document).on('click','.f1',function(){

let id = $(this).attr('id')

	$.ajax({
		method:'POST',
		url:'loader.php?c=clients',
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
		url:'loader.php?c=clients',
		data:{f2:id},
		success:function(response){
			$('#result').html(response)
		}
	})

})

$.ajax({  

	type:'GET',
	url:'loader.php?c=clients',
	dataType:'html',
	success:function(response){
		$('#result').html(response)
	}

})

</script>