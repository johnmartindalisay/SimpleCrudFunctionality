@extends('master')
@section('content')


<div id="loading_class"></div>
	<div class="center-container">

		  <div class="imgcontainer">
		    <h3>Registration</h3>
		    
		    Go Back <a href="login">Login</a>
		  </div>
		
		  <div class="container">
		  		
		    	<div id="message_alert"class="success">Successfully! Registered Please go to <strong>Login </strong>Page</div>
		    
		  	<form id='register-form' action="#" class="container" enctype="multipart/form-data">
		  		<input type="hidden" name="_token" value="{{csrf_token()}}">
		  		<!-- ******************* -->

		  		<label for="imgFile">Upload Image File:</label><br/>
				<input name="userImage" type="file" id="img_file" required>
				<br><br>
		  		<label for="fname"><b>First Name</b></label>
		    	<input type="text" placeholder="Enter First Name" name="fname" id="fname" required>

		    	<label for="lname"><b>Last Name</b></label>
		    	<input type="text" placeholder="Enter Last Name" name="lname" id="lname" required>

		    	 <label for="address"><b>Address</b></label>
		    	<input type="text" placeholder="You're Address" name="address" id="address" required>

			    <label for="email"><b>Email</b></label>
			    <input type="text" placeholder="Enter your Email" name="email" id="email" required>

			   <label for="password"><b>Password</b></label>
			    <input type="password" placeholder="Password" name="password" id="password" required>

			     <label for="pnumber"><b>Phone Number</b></label>
			    <input type="text" placeholder="Phone Number" name="pnumber" id="pnumber" required>


		    	<button type="submit">Register</button>
		    	<!-- Loading -->
		    	
		  	</form>

		  </div>

			<!-- <h2>Get Request</h2>

			<button id='getRequest'>getRequest</button>
			<div id="loadgetRequest"></div> -->
			<!-- <div id="loadpostRequest"></div> -->
	</div>

@stop

@section('footer')
	<script>
		$(function(){
			$(".loader").hide();
			$(".alert").hide();
			$("div#message_alert").hide();

			

		});
	
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});


		$('#getRequest').click(function(){
			$.get('getRequest',function(data){
				//console.log(data);
				$("#loadgetRequest").append(data);
			});
		});


		$("#test_button").click(function(){
			
		});

		$("#register-form").submit(function(e){

			e.preventDefault();

			var fname = $("#fname").val();
			var lname = $("#lname").val();
			var address = $("#address").val();
			var email = $("#email").val();
			var password = $("#password").val();
			var pnumber = $("#pnumber").val();
			 var img_file = $("#img_file").val();

			//console.log(img_file);
			// $.post('postRequest',{firstname:fname,lastname:lname},function(data){
			// 	//console.log(data);
			// 	$("#loadpostRequest")html(data);
			// });
			var dataString = "firstname="+fname+"&lastname="+lname+
							  "&address="+address+"&email="+email+
							  "&password="+password+"&phone_num="+pnumber;

			$.ajax({

				type: "POST",
				url: "postRequest",
				data : new FormData(this),
				contentType:false,
				processData: false,
				beforeSend:function(){

					$("body").delay(800).css("filter","blur(2px)");
					$("div#loading_class").addClass("loader");

				},
				success: function(data){
					//console.log(data);
					if (data.content.results) {
						$("body").css("filter","none");

						$("div#loading_class").removeClass("loader");

						$("#message_alert").fadeIn();

						$("form#register-form.container input").val("");

						setTimeout(function() {
						 $('#message_alert').fadeOut();
						}, 10000);


					}

				},
				error: function(){
					console.log("Error");
				},

			});


		});

	</script>

@stop