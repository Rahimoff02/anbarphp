<?php
include"header.php";

echo'<div class="container">';

?>

<div id="result"></div><br><br><br><br><br></div>

</div>

<script>

$(document).on('click','.secsil',function(){
        let form = $('#main_form')[0]
        let data = new FormData(form)

        if (confirm('Mushterini silmeye eminsinizmi ?')) {
      

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?e=expense",
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
			url:'loader.php?e=expense',
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
            url:'loader.php?e=expense',
            data:{edit_id:id},
            success:function(response){
                $('#result').html(response)
            }
        })
    
})

$(document).on('click','.update',function(){
        let form = $('#expense_update')[0]
        let data = new FormData(form)
     
        $.ajax({
            type: "POST",
            url: "loader.php?e=expense",
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

$(document).on('click','.ok',function(){
        let form = $('#expense_insert')[0]
        let data = new FormData(form)
 
        $.ajax({
            type: "POST",
            url: "loader.php?e=expense",
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


$(document).on('click','.sil',function(){
	let id = $(this).attr('id')
	if(confirm('Melumati silmeye eminsinizmi ?')){

		

		$.ajax({
			method:'POST',
			url:'loader.php?e=expense',
			data:{xercsil:id},
			success:function(response){
				$('#result').html(response)
			}
		})
	}
})

$.ajax({  

	type:'GET',
	url:'loader.php?e=expense',
	dataType:'html',
	success:function(response){
		$('#result').html(response)
	}

})

$(document).on('click','.f1',function(){

let id = $(this).attr('id')

$.ajax({
	method:'POST',
	url:'loader.php?e=expense',
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
url:'loader.php?e=expense',
data:{f2:id},
success:function(response){
	$('#result').html(response)
}
})

})

</script>

