@extends('master')

@section('content')


	 <div class="center-container">

	
		  <div class="imgcontainer">
		    <h3>Welcome in Customer Details - </h3><a href="logout">Logout</a>
		  </div>

		  <div class="container">

		  	<div id='customer-form' class="container">
		  		<!-- ******************* -->

		  		<div class="image_container">
		  			<?php 
		  			$fullpathImage = "public/images/".$result->id."/".$result->ImageName;
		  			//$baseurl = "public/images/".$result->ImageName;?>
		  			<img src="{{ asset($fullpathImage)}}" class="img_cls">
		  		</div>


		  		<input type="hidden" id="customer_id" name="customer_id" value="{{$result->id}}">

		  		<div class="container heading" id="firstname">
		  				<label for="fname">First Name: <b>{{$result->firstname}}</b><span id="firstname" style="float:right;">Change</span></label><br>
		    			<input type="text" style="width:70%;" value="{{$result->firstname}}"  placeholder="Enter First Name" name="firstname" id="firstname">&nbsp;&nbsp;<button id="firstname" onclick="update_customer_details(this.id)" class="primary">Save</button>
		  		</div>

		  		<div class="container heading" id="lastname">
		  				<label for="lname">Last Name: <b>{{$result->lastname}}</b><span id="lastname" style="float:right;">Change</span></label><br>
				    	<input type="text" style="width:70%;" value="{{$result->lastname}}" placeholder="Enter Last Name" name="lastname" id="lastname">&nbsp;&nbsp;<button id="lastname"  onclick="update_customer_details(this.id)" class="primary">Save</button>
		  		</div>

				<div class="container heading" id="address">
						<label for="address">Address: <b>{{$result->address}}</b><span id="address" style="float:right;">Change</span></label><br>
				    	<input type="text" style="width:70%;" value="{{$result->address}}" placeholder="You're Address" name="address" id="address">&nbsp;&nbsp;<button id="address" onclick="update_customer_details(this.id)" class="primary">Save</button>
				</div>		  		
	
		    	<div class="container heading" id="email_address">
		    		<label for="email">Email: <b>{{$result->email_address}}</b><span id="email_address" style="float:right;">Change</span></label><br>
				    <input type="text" style="width:70%;" value="{{$result->email_address}}" placeholder="Enter your Email" name="email_address" id="email_address">&nbsp;&nbsp;<button id="email_address"  onclick="update_customer_details(this.id)" class="primary">Save</button>
		    	</div>
			    
		    	<div class="container heading" id="password">
		    			<label for="password">Password: <b>{{$result->password}}</b><span id="password" style="float:right;">Change</span></label><br>
					    <input type="password" style="width:70%;" value="{{$result->password}}" placeholder="Password" name="password" id="password">&nbsp;&nbsp;<button id="password" onclick="update_customer_details(this.id)" class="primary">Save</button>
		    	</div>

		    	<div class="container heading" id="phone_number">
		    		<label for="pnumber">Phone Number: <b>{{$result->phone_number}}</b><span id="phone_number" style="float:right;">Change</span></label><br>
				    <input type="text" style="width:70%;" value="{{$result->phone_number}}" placeholder="Phone Number" name="phone_number" id="phone_number">&nbsp;&nbsp;<button id="phone_number" onclick="update_customer_details(this.id)" class="primary">Save</button>
		    	</div>
			   
		  	</div>

		  </div>

		  <div id="myModal" class="modal">

  				<!-- Modal content -->
			  <div class="modal-content">
			    <span class="close">&times;</span>
			    <form id='update-img-form' action="#" enctype="multipart/form-data">
			    	<label for="imgFile">Upload Image File:</label><br/>
					<input name="img_file" type="file" id="img_file" required>
		  			<input type="hidden" id="customer_id" name="customer_id" value="{{$result->id}}">
					
					<button type="submit">Submit</button>
			    </form>
			  </div>

		</div>


		  <div>
		  		<!-- <label>Delete Account</label> -->
		  </div>
	
@stop

@section('footer')
<script>
$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

$(function(){
	$('div.container.heading').find('input').hide();
	$('div.container.heading').find('button').hide();
});
$('div.container.heading span').click(function(){
	  var id = this.id;
	  $('div.container.heading').find('input#'+id).toggle();	 
	  $('div.container.heading').find('button#'+id).toggle();	 
});


$("img.img_cls").on('click',function(){
	
	$("#myModal").css("display","block");


});

$("span.close").click(function(){
	$("#myModal").css("display","none");

});

window.onclick = function(event) {

	var modal = document.getElementById('myModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

//User Image Update
$("form#update-img-form").submit(function(e){
	e.preventDefault();

	$.ajax({

		type: "POST",
		url: "updateUserImage",
		data : new FormData(this),
		contentType:false,
		processData: false,
		success: function(data){
			//console.log(data);

			if (data.contents.results) {

				alert("Updated Successfully");

				$("#myModal").css("display","none");
				$("img.img_cls").attr("src",data.contents.existing_fileImage);

			}else{
				console.log("Error");
			}
		
		},
		error: function(){
			console.log("Error");
		},

	});



});

$("div.heading").last().css("border-bottom","none");

//User Details Update
function update_customer_details(id){

	var customer_id = $('input#customer_id').val();
	var inputs_val = $('input#'+id).val();

	if (inputs_val == "") {
		alert("Please Fill the box");
		return false;
	}
	var dataString = "id="+customer_id+"&customer_field="+id+"&customer_field_value="+inputs_val;
	$.ajax({

		type: "POST",
		url: "updateUserDetails",
		data : dataString,
		success: function(data){
				//console.log(data);
			
			if (data.contents.affected_rows) {

				alert("Updated Successfully");
				
				$("div#"+id+".container.heading b").text(data.contents.new_value);

			}else{
				return false;
			}
		},
		error: function(){
			console.log("Error");
		},

	});

}


		 
</script>


@stop